<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostApprovalController extends Controller
{
    public function index()
    {
        $pendingPosts = Post::with(['user', 'category'])
            ->where('status', 'pending')
            ->latest()
            ->paginate(15);

        return view('admin.posts.pending', compact('pendingPosts'));
    }

    public function approve(Post $post)
    {
        $post->update(['status' => 'published']);
        return back()->with('status', 'Post approved.');
    }

    public function reject(Post $post)
    {
        $post->delete();
        return back()->with('status', 'Post rejected and removed.');
    }
}
