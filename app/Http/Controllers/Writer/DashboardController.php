<?php

namespace App\Http\Controllers\Writer;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get writer's posts
        $writerPosts = Post::where('user_id', $user->id)
            ->with(['category', 'user'])
            ->latest()
            ->paginate(10);

        // Get recent posts from other writers
        $recentPosts = Post::where('user_id', '!=', $user->id)
            ->where('status', 'published')
            ->with(['category', 'user'])
            ->latest()
            ->take(5)
            ->get();

        // Get categories for post creation
        $categories = Category::where('status', true)->get();

        // Get writer stats
        $stats = [
            'total_posts' => Post::where('user_id', $user->id)->count(),
            'published_posts' => Post::where('user_id', $user->id)->where('status', 'published')->count(),
            'pending_posts' => Post::where('user_id', $user->id)->where('status', 'pending')->count(),
            'draft_posts' => Post::where('user_id', $user->id)->where('status', 'draft')->count(),
            'total_views' => Post::where('user_id', $user->id)->sum('views'),
        ];

        return view('writer.dashboard', compact('writerPosts', 'recentPosts', 'categories', 'stats'));
    }
}
