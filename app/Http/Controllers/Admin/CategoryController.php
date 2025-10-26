<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Events\UserActivity;
use App\Events\AdminStatsUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('posts')->latest()->paginate(20);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'description' => 'nullable|string|max:1000',
            'status' => 'required|in:active,inactive',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'color' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:50',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);

            // Ensure unique slug
            $originalSlug = $validated['slug'];
            $counter = 1;
            while (Category::where('slug', $validated['slug'])->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        $category = Category::create($validated);

        // Dispatch real-time events
        event(new UserActivity(Auth::user(), 'created_category', [
            'category_id' => $category->id,
            'category_name' => $category->name
        ]));

        $this->dispatchStatsUpdate();

        // Log activity
        activity()
            ->causedBy(Auth::user())
            ->performedOn($category)
            ->withProperties(['name' => $category->name, 'status' => $category->status])
            ->log('created_category');

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully!');
    }

    public function show(Category $category)
    {
        $category->load(['posts' => function($query) {
            $query->latest()->take(10);
        }]);

        return view('admin.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string|max:1000',
            'status' => 'required|in:active,inactive',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'color' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:50',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);

            // Ensure unique slug
            $originalSlug = $validated['slug'];
            $counter = 1;
            while (Category::where('slug', $validated['slug'])->where('id', '!=', $category->id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        $category->update($validated);

        // Dispatch real-time events
        event(new UserActivity(Auth::user(), 'updated_category', [
            'category_id' => $category->id,
            'category_name' => $category->name
        ]));

        $this->dispatchStatsUpdate();

        // Log activity
        activity()
            ->causedBy(Auth::user())
            ->performedOn($category)
            ->withProperties(['name' => $category->name, 'status' => $category->status])
            ->log('updated_category');

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        $categoryName = $category->name;
        $categoryId = $category->id;

        // Check if category has posts
        if ($category->posts()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Cannot delete category with existing posts. Please move or delete the posts first.');
        }

        $category->delete();

        // Dispatch real-time events
        event(new UserActivity(Auth::user(), 'deleted_category', [
            'category_id' => $categoryId,
            'category_name' => $categoryName
        ]));

        $this->dispatchStatsUpdate();

        // Log activity
        activity()
            ->causedBy(Auth::user())
            ->withProperties(['name' => $categoryName])
            ->log('deleted_category');

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully!');
    }

    public function toggleStatus(Category $category)
    {
        $category->update([
            'status' => $category->status === 'active' ? 'inactive' : 'active'
        ]);

        // Dispatch real-time events
        event(new UserActivity(Auth::user(), 'toggled_category_status', [
            'category_id' => $category->id,
            'category_name' => $category->name,
            'new_status' => $category->status
        ]));

        $this->dispatchStatsUpdate();

        return response()->json([
            'status' => 'success',
            'message' => 'Category status updated successfully',
            'new_status' => $category->status
        ]);
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'category_ids' => 'required|array|min:1',
            'category_ids.*' => 'exists:categories,id'
        ]);

        $categories = Category::whereIn('id', $request->category_ids);
        $action = $request->action;

        switch ($action) {
            case 'activate':
                $categories->update(['status' => 'active']);
                $message = 'Categories activated successfully';
                break;
            case 'deactivate':
                $categories->update(['status' => 'inactive']);
                $message = 'Categories deactivated successfully';
                break;
            case 'delete':
                // Check if any categories have posts
                $categoriesWithPosts = $categories->whereHas('posts')->count();
                if ($categoriesWithPosts > 0) {
                    return redirect()->route('admin.categories.index')
                        ->with('error', 'Cannot delete categories with existing posts.');
                }
                $categories->delete();
                $message = 'Categories deleted successfully';
                break;
        }

        // Dispatch real-time events
        event(new UserActivity(Auth::user(), 'bulk_action_categories', [
            'action' => $action,
            'count' => count($request->category_ids)
        ]));

        $this->dispatchStatsUpdate();

        return redirect()->route('admin.categories.index')->with('success', $message);
    }

    private function dispatchStatsUpdate()
    {
        $stats = [
            'total_categories' => Category::count(),
            'active_categories' => Category::where('status', 'active')->count(),
            'inactive_categories' => Category::where('status', 'inactive')->count(),
        ];

        event(new AdminStatsUpdated($stats));
    }
}
