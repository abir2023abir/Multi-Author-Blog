<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Events\CommentCreated;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function show(Post $post)
    {
        $post->load(['user', 'category', 'comments' => function($query) {
            $query->latest();
        }]);

        return view('posts.show', compact('post'));
    }

    public function storeComment(Request $request, Post $post)
    {
        $validated = $request->validate([
            'author_name' => 'required|string|max:255',
            'author_email' => 'required|email|max:255',
            'content' => 'required|string|max:1000',
        ]);

        $comment = $post->comments()->create($validated);

        // Dispatch real-time event
        event(new CommentCreated($comment));

        return back()->with('status', 'Comment added successfully!');
    }
}