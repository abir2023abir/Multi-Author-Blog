<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __invoke()
    {
        // Cache dashboard stats for 5 minutes
        $stats = Cache::remember('dashboard_stats', 300, function () {
            return [
                'total_posts' => Post::count(),
                'pending_posts' => Post::where('status', 'pending')->count(),
                'draft_posts' => Post::where('status', 'draft')->count(),
                'total_users' => User::count(),
                'total_comments' => Comment::count(),
                'posts_this_month' => Post::whereMonth('created_at', now()->month)->count(),
            ];
        });

        // Optimized queries with eager loading
        $recentPosts = Post::with('user:id,name', 'category:id,name')
            ->latest()
            ->take(5)
            ->get();

        $recentComments = Comment::with(['user:id,name', 'post:id,title'])
            ->latest()
            ->take(2)
            ->get();

        $topAuthors = User::withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->take(3)
            ->get();

        $latestUsers = User::latest()
            ->take(6)
            ->get(['id', 'name', 'created_at']);

        $pendingComments = Comment::with('user:id,name')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'stats',
            'recentPosts',
            'recentComments',
            'topAuthors',
            'latestUsers',
            'pendingComments'
        ));
    }
}
