<?php

namespace App\Http\Controllers\User;

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

        // Get user's posts
        $userPosts = Post::where('user_id', $user->id)
            ->with(['category', 'user'])
            ->latest()
            ->paginate(10);

        // Get recent posts from other users
        $recentPosts = Post::where('user_id', '!=', $user->id)
            ->where('status', 'published')
            ->with(['category', 'user'])
            ->latest()
            ->take(5)
            ->get();

        // Get categories for post creation
        $categories = Category::where('status', true)->get();

        // Get user stats
        $stats = [
            'total_posts' => Post::where('user_id', $user->id)->count(),
            'published_posts' => Post::where('user_id', $user->id)->where('status', 'published')->count(),
            'pending_posts' => Post::where('user_id', $user->id)->where('status', 'pending')->count(),
            'draft_posts' => Post::where('user_id', $user->id)->where('status', 'draft')->count(),
        ];

        return view('user.dashboard', compact('userPosts', 'recentPosts', 'categories', 'stats'));
    }
}
