<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Events\UserActivity;
use App\Events\AdminStatsUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->latest()->paginate(20);
        $roles = Role::all();
        return view('admin.users.index', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:roles,name',
            'status' => 'required|in:active,inactive',
            'bio' => 'nullable|string|max:1000',
            'website' => 'nullable|url|max:255',
            'twitter' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['email_verified_at'] = now();

        $user = User::create($validated);
        $user->assignRole($validated['roles']);

        // Dispatch real-time events
        event(new UserActivity(Auth::user(), 'created_user', [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email
        ]));

        $this->dispatchStatsUpdate();

        // Log activity
        activity()
            ->causedBy(Auth::user())
            ->performedOn($user)
            ->withProperties(['name' => $user->name, 'email' => $user->email])
            ->log('created_user');

        return redirect()->route('admin.users.index')->with('success', 'User created successfully!');
    }

    public function show(User $user)
    {
        $user->load(['posts' => function($query) {
            $query->latest()->take(10);
        }, 'roles']);

        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:roles,name',
            'status' => 'required|in:active,inactive',
            'bio' => 'nullable|string|max:1000',
            'website' => 'nullable|url|max:255',
            'twitter' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);
        $user->syncRoles($validated['roles']);

        // Dispatch real-time events
        event(new UserActivity(Auth::user(), 'updated_user', [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email
        ]));

        $this->dispatchStatsUpdate();

        // Log activity
        activity()
            ->causedBy(Auth::user())
            ->performedOn($user)
            ->withProperties(['name' => $user->name, 'email' => $user->email])
            ->log('updated_user');

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully!');
    }

    public function destroy(User $user)
    {
        // Prevent deleting the current user
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $userName = $user->name;
        $userEmail = $user->email;
        $userId = $user->id;

        $user->delete();

        // Dispatch real-time events
        event(new UserActivity(Auth::user(), 'deleted_user', [
            'user_id' => $userId,
            'user_name' => $userName,
            'user_email' => $userEmail
        ]));

        $this->dispatchStatsUpdate();

        // Log activity
        activity()
            ->causedBy(Auth::user())
            ->withProperties(['name' => $userName, 'email' => $userEmail])
            ->log('deleted_user');

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully!');
    }

    public function toggleStatus(User $user)
    {
        // Prevent deactivating the current user
        if ($user->id === Auth::id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'You cannot deactivate your own account.'
            ], 400);
        }

        $user->update([
            'status' => $user->status === 'active' ? 'inactive' : 'active'
        ]);

        // Dispatch real-time events
        event(new UserActivity(Auth::user(), 'toggled_user_status', [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'new_status' => $user->status
        ]));

        $this->dispatchStatsUpdate();

        return response()->json([
            'status' => 'success',
            'message' => 'User status updated successfully',
            'new_status' => $user->status
        ]);
    }

    public function assignRole(Request $request, User $user)
    {
        $request->validate([
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:roles,name'
        ]);

        $user->syncRoles($request->roles);

        // Dispatch real-time events
        event(new UserActivity(Auth::user(), 'assigned_roles', [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'roles' => $request->roles
        ]));

        return response()->json([
            'status' => 'success',
            'message' => 'Roles assigned successfully'
        ]);
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,delete,assign_role',
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'exists:users,id',
            'role' => 'required_if:action,assign_role|exists:roles,name'
        ]);

        $users = User::whereIn('id', $request->user_ids);
        $action = $request->action;

        // Prevent bulk actions on current user
        if (in_array(Auth::id(), $request->user_ids)) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot perform bulk actions on your own account.');
        }

        switch ($action) {
            case 'activate':
                $users->update(['status' => 'active']);
                $message = 'Users activated successfully';
                break;
            case 'deactivate':
                $users->update(['status' => 'inactive']);
                $message = 'Users deactivated successfully';
                break;
            case 'delete':
                $users->delete();
                $message = 'Users deleted successfully';
                break;
            case 'assign_role':
                $users->get()->each(function($user) use ($request) {
                    $user->assignRole($request->role);
                });
                $message = 'Role assigned to users successfully';
                break;
        }

        // Dispatch real-time events
        event(new UserActivity(Auth::user(), 'bulk_action_users', [
            'action' => $action,
            'count' => count($request->user_ids)
        ]));

        $this->dispatchStatsUpdate();

        return redirect()->route('admin.users.index')->with('success', $message);
    }

    public function getStats()
    {
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('status', 'active')->count(),
            'inactive_users' => User::where('status', 'inactive')->count(),
            'admin_users' => User::role('admin')->count(),
            'writer_users' => User::role('writer')->count(),
            'regular_users' => User::role('user')->count(),
            'new_users_today' => User::whereDate('created_at', today())->count(),
            'new_users_this_week' => User::where('created_at', '>=', now()->subWeek())->count(),
        ];

        return response()->json($stats);
    }

    private function dispatchStatsUpdate()
    {
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('status', 'active')->count(),
            'inactive_users' => User::where('status', 'inactive')->count(),
        ];

        event(new AdminStatsUpdated($stats));
    }
}
