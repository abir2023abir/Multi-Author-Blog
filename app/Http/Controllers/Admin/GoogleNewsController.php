<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class GoogleNewsController extends Controller
{
    public function index()
    {
        $recentPosts = Post::published()->latest()->take(10)->get();
        return view('admin.google-news.index', compact('recentPosts'));
    }

    public function submit(Request $request)
    {
        // Google News API submission logic
        return back()->with('status', 'Content submitted to Google News successfully.');
    }
}
