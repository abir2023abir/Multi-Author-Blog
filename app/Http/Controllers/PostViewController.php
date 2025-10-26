<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PostViewController extends Controller
{
    public function show(Post $post)
    {
        abort_unless($post->status === 'published', 404);

        // Increment view count
        $post->increment('view_count');

        // Load relationships
        $post->load(['user', 'category', 'comments.user']);

        // Get related posts (same category, excluding current post)
        $relatedPosts = Cache::remember("related_posts_{$post->id}", 300, function () use ($post) {
            return Post::with(['user:id,name', 'category:id,name,color'])
                ->select('id', 'title', 'slug', 'excerpt', 'featured_image', 'user_id', 'category_id', 'published_at', 'view_count', 'reading_time')
                ->where('status', 'published')
                ->whereNotNull('published_at')
                ->where('id', '!=', $post->id)
                ->when($post->category_id, function($query) use ($post) {
                    return $query->where('category_id', $post->category_id);
                })
                ->orderBy('published_at', 'desc')
                ->take(3)
                ->get();
        });

        // Get popular posts for sidebar
        $popularPosts = Cache::remember('popular_posts_sidebar', 300, function () {
            return Post::with(['user:id,name', 'category:id,name,color'])
                ->select('id', 'title', 'slug', 'user_id', 'category_id', 'published_at', 'view_count')
                ->where('status', 'published')
                ->whereNotNull('published_at')
                ->orderBy('view_count', 'desc')
                ->take(5)
                ->get();
        });

        // Get recent posts for sidebar
        $recentPosts = Cache::remember('recent_posts_sidebar', 300, function () {
            return Post::with(['user:id,name', 'category:id,name,color'])
                ->select('id', 'title', 'slug', 'user_id', 'category_id', 'published_at')
                ->where('status', 'published')
                ->whereNotNull('published_at')
                ->orderBy('published_at', 'desc')
                ->take(5)
                ->get();
        });

        // Get categories for breadcrumb
        $categories = Cache::remember('all_categories_breadcrumb', 300, function () {
            return Category::where('status', true)
                ->select('id', 'name', 'slug')
                ->orderBy('name')
                ->get();
        });

        return view('posts.show', compact('post', 'relatedPosts', 'popularPosts', 'recentPosts', 'categories'));
    }
}
