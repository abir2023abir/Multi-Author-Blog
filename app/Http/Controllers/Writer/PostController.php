<?php

namespace App\Http\Controllers\Writer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Events\PostCreated;
use App\Events\PostUpdated;
use App\Events\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
        return view('writer.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('writer.posts.format-selection');
    }

    /**
     * Show the form for creating a new resource with specific format.
     */
    public function createWithFormat(Request $request)
    {
        $format = $request->get('format', 'article');
        $categories = Category::orderBy('name')->get();

        $allowedFormats = [
            'article', 'gallery', 'sorted_list', 'table_of_contents',
            'video', 'audio', 'trivia_quiz', 'personality_quiz', 'poll', 'recipe'
        ];

        if (!in_array($format, $allowedFormats)) {
            return redirect()->route('writer.posts.create');
        }

        return view('writer.posts.create', compact('categories', 'format'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'post_format' => ['required', 'string', 'in:article,gallery,sorted_list,table_of_contents,video,audio,trivia_quiz,personality_quiz,poll,recipe'],
            'meta_description' => ['nullable', 'string', 'max:160'],
            'featured_image' => ['nullable', 'string'],
        ]);

        $validated['user_id'] = Auth::id();
        // Publish directly per requirement
        $validated['status'] = 'published';
        $validated['published_at'] = now();

        $post = Post::create($validated);

        // Dispatch real-time events
        event(new PostCreated($post));
        event(new UserActivity(Auth::user(), 'created_post', ['post_id' => $post->id, 'post_title' => $post->title]));

        return redirect()->route('writer.posts.index')
            ->with('status', 'Post submitted and pending approval.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::where('user_id', Auth::id())->findOrFail($id);
        // Writers can edit their posts; keep published status and update content
        $categories = Category::orderBy('name')->get();
        return view('writer.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::where('user_id', Auth::id())->findOrFail($id);
        abort_unless($post->status === 'pending', 403);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'category_id' => ['nullable', 'exists:categories,id'],
        ]);

        $validated['published_at'] = $post->published_at ?? now();
        $post->update($validated);

        return redirect()->route('writer.posts.index')
            ->with('status', 'Post updated and pending approval.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::where('user_id', Auth::id())->findOrFail($id);
        abort_unless($post->status === 'pending', 403);
        $post->delete();

        return redirect()->route('writer.posts.index')
            ->with('status', 'Post deleted.');
    }
}
