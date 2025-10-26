<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        // Cache featured posts for 10 minutes
        $featuredPosts = Cache::remember('home_featured_posts', 600, function () {
            return Post::with(['user:id,name', 'category:id,name,color'])
                ->select('id', 'title', 'content', 'user_id', 'category_id', 'published_at', 'view_count', 'created_at')
                ->where('status', 'published')
                ->where('is_featured', true)
                ->latest('published_at')
                ->take(5)
                ->get();
        });

        // If no featured posts, get latest posts
        if ($featuredPosts->isEmpty()) {
            $featuredPosts = Post::with(['user:id,name', 'category:id,name,color'])
                ->select('id', 'title', 'content', 'user_id', 'category_id', 'published_at', 'view_count', 'created_at')
                ->where('status', 'published')
                ->latest('published_at')
                ->take(5)
                ->get();
        }

        // Optimized pagination with eager loading
        $latestPosts = Post::with(['user:id,name', 'category:id,name,color'])
            ->select('id', 'title', 'content', 'user_id', 'category_id', 'published_at', 'view_count', 'created_at')
            ->where('status', 'published')
            ->latest('published_at')
            ->paginate(6);

        // Cache popular categories for 15 minutes
        $popularCategories = Cache::remember('popular_categories', 900, function () {
            return Category::select('id', 'name', 'color')
                ->withCount(['posts' => function ($query) {
                    $query->where('status', 'published');
                }])
                ->orderBy('posts_count', 'desc')
                ->take(5)
                ->get()
                ->filter(function ($category) {
                    return $category->posts_count > 0;
                });
        });

        return view('home', compact('featuredPosts', 'latestPosts', 'popularCategories'));
    }
}
