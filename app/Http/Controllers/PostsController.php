<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PostsController extends Controller
{
    public function index(Request $request)
    {
        // Clear cache to ensure fresh data
        Cache::forget('all_categories');
        Cache::forget('popular_posts');

        $query = Post::with(['user:id,name', 'category:id,name,color'])
            ->select('id', 'title', 'content', 'user_id', 'category_id', 'published_at', 'view_count', 'created_at', 'featured_image', 'reading_time')
            ->where('status', 'published')
            ->whereNotNull('published_at');

        // Filter by category if provided
        if ($request->has('category') && $request->category) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->category . '%');
            });
        }

        // Enhanced search functionality
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('content', 'like', '%' . $searchTerm . '%')
                  ->orWhere('excerpt', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('user', function($userQuery) use ($searchTerm) {
                      $userQuery->where('name', 'like', '%' . $searchTerm . '%');
                  });
            });
        }

        // Sort options with better handling
        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'popular':
                $query->orderBy('view_count', 'desc')
                      ->orderBy('published_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('published_at', 'asc');
                break;
            case 'alphabetical':
                $query->orderBy('title', 'asc');
                break;
            default:
                $query->orderBy('published_at', 'desc');
        }

        $posts = $query->paginate(12)->appends($request->query());

        // Get categories for filtering with count
        $categories = Cache::remember('all_categories_with_count', 300, function () {
            return Category::where('status', true)
                ->withCount(['posts' => function($query) {
                    $query->where('status', 'published')->whereNotNull('published_at');
                }])
                ->select('id', 'name', 'color')
                ->orderBy('name')
                ->get();
        });

        // Get popular posts for sidebar
        $popularPosts = Cache::remember('popular_posts_enhanced', 300, function () {
            return Post::with(['user:id,name', 'category:id,name,color'])
                ->select('id', 'title', 'user_id', 'category_id', 'published_at', 'view_count', 'slug')
                ->where('status', 'published')
                ->whereNotNull('published_at')
                ->orderBy('view_count', 'desc')
                ->take(5)
                ->get();
        });

        // Get recent posts for sidebar
        $recentPosts = Cache::remember('recent_posts_sidebar', 300, function () {
            return Post::with(['user:id,name', 'category:id,name,color'])
                ->select('id', 'title', 'user_id', 'category_id', 'published_at', 'slug')
                ->where('status', 'published')
                ->whereNotNull('published_at')
                ->orderBy('published_at', 'desc')
                ->take(5)
                ->get();
        });

        return view('posts.index', compact('posts', 'categories', 'popularPosts', 'recentPosts'));
    }
}
