<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Events\UserActivity;
use App\Events\AdminStatsUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::with('user')
            ->latest()
            ->paginate(20);

        $stats = [
            'total_notifications' => Notification::count(),
            'unread_notifications' => Notification::where('read_at', null)->count(),
            'read_notifications' => Notification::whereNotNull('read_at')->count(),
            'notifications_today' => Notification::whereDate('created_at', today())->count(),
        ];

        return view('admin.notifications.index', compact('notifications', 'stats'));
    }

    public function markAsRead(Notification $notification)
    {
        if (!$notification->read_at) {
            $notification->update(['read_at' => now()]);

            // Dispatch real-time events
            event(new UserActivity(Auth::user(), 'read_notification', [
                'notification_id' => $notification->id,
                'notification_type' => $notification->type
            ]));
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Notification marked as read'
        ]);
    }

    public function markAllAsRead()
    {
        $unreadCount = Notification::where('read_at', null)->count();

        Notification::where('read_at', null)->update(['read_at' => now()]);

        // Dispatch real-time events
        event(new UserActivity(Auth::user(), 'marked_all_notifications_read', [
            'marked_count' => $unreadCount
        ]));

        // Log activity
        activity()
            ->causedBy(Auth::user())
            ->withProperties(['marked_count' => $unreadCount])
            ->log('marked_all_notifications_read');

        return response()->json([
            'status' => 'success',
            'message' => 'All notifications marked as read'
        ]);
    }

    public function destroy(Notification $notification)
    {
        $notificationId = $notification->id;
        $notificationType = $notification->type;

        $notification->delete();

        // Dispatch real-time events
        event(new UserActivity(Auth::user(), 'deleted_notification', [
            'notification_id' => $notificationId,
            'notification_type' => $notificationType
        ]));

        // Log activity
        activity()
            ->causedBy(Auth::user())
            ->withProperties(['notification_type' => $notificationType])
            ->log('deleted_notification');

        return redirect()->route('admin.notifications.index')->with('success', 'Notification deleted successfully!');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:mark_read,mark_unread,delete',
            'notification_ids' => 'required|array|min:1',
            'notification_ids.*' => 'exists:notifications,id'
        ]);

        $notifications = Notification::whereIn('id', $request->notification_ids);
        $action = $request->action;

        switch ($action) {
            case 'mark_read':
                $notifications->update(['read_at' => now()]);
                $message = 'Notifications marked as read successfully';
                break;
            case 'mark_unread':
                $notifications->update(['read_at' => null]);
                $message = 'Notifications marked as unread successfully';
                break;
            case 'delete':
                $notifications->delete();
                $message = 'Notifications deleted successfully';
                break;
        }

        // Dispatch real-time events
        event(new UserActivity(Auth::user(), 'bulk_action_notifications', [
            'action' => $action,
            'count' => count($request->notification_ids)
        ]));

        $this->dispatchStatsUpdate();

        return redirect()->route('admin.notifications.index')->with('success', $message);
    }

    public function getStats()
    {
        $stats = [
            'total_notifications' => Notification::count(),
            'unread_notifications' => Notification::where('read_at', null)->count(),
            'read_notifications' => Notification::whereNotNull('read_at')->count(),
            'notifications_today' => Notification::whereDate('created_at', today())->count(),
            'notifications_this_week' => Notification::where('created_at', '>=', now()->subWeek())->count(),
            'notifications_this_month' => Notification::where('created_at', '>=', now()->subMonth())->count(),
        ];

        return response()->json($stats);
    }

    public function getRecentNotifications()
    {
        $notifications = Notification::with('user')
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'type' => $notification->type,
                    'data' => $notification->data,
                    'user' => $notification->user ? [
                        'name' => $notification->user->name,
                        'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($notification->user->name)
                    ] : null,
                    'read_at' => $notification->read_at,
                    'created_at' => $notification->created_at->diffForHumans(),
                ];
            });

        return response()->json($notifications);
    }

    public function create(Request $request)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'data' => 'required|array',
            'user_id' => 'nullable|exists:users,id',
            'broadcast' => 'nullable|boolean'
        ]);

        $notification = Notification::create([
            'id' => \Str::uuid(),
            'type' => $request->type,
            'notifiable_type' => 'App\Models\User',
            'notifiable_id' => $request->user_id ?? Auth::id(),
            'data' => $request->data,
        ]);

        // Broadcast if requested
        if ($request->broadcast) {
            event(new UserActivity(Auth::user(), 'created_notification', [
                'notification_id' => $notification->id,
                'notification_type' => $notification->type
            ]));
        }

        $this->dispatchStatsUpdate();

        return response()->json([
            'status' => 'success',
            'message' => 'Notification created successfully',
            'notification' => $notification
        ]);
    }

    private function dispatchStatsUpdate()
    {
        $stats = [
            'total_notifications' => Notification::count(),
            'unread_notifications' => Notification::where('read_at', null)->count(),
        ];

        event(new AdminStatsUpdated($stats));
    }
}
