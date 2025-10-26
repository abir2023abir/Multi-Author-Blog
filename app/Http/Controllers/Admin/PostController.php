<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Events\PostCreated;
use App\Events\PostUpdated;
use App\Events\PostDeleted;
use App\Events\UserActivity;
use App\Events\AdminStatsUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        // Optimized query with eager loading and select specific columns
        $posts = Post::with([
            'user:id,name',
            'category:id,name'
        ])
        ->select('id', 'title', 'user_id', 'category_id', 'status', 'published_at', 'created_at')
        ->latest()
        ->paginate(20);

        return view('admin.posts.index_all', compact('posts'));
    }

    public function add()
    {
        return view('admin.posts.add');
    }

    public function create(Request $request)
    {
        $type = $request->get('type', 'article');
        $categories = \App\Models\Category::where('status', 'active')->get();

        return view('admin.posts.create', compact('type', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'categories' => 'required|array|min:1',
            'categories.*' => 'string',
            'status' => 'required|in:draft,pending,published',
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'featured_image_url' => 'nullable|url|max:500',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'type' => 'required|string',
            'tags' => 'nullable|string',
            'reading_time' => 'nullable|integer|min:1',
            'layout' => 'nullable|string',
            'allow_comments' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
        ]);

        // Generate slug
        $validated['slug'] = \Illuminate\Support\Str::slug($validated['title']);

        // Ensure unique slug
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (Post::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Set user
        $validated['user_id'] = Auth::id();

        // Handle categories - convert to category_id for now (first selected category)
        $validated['category_id'] = 1; // Default category ID, you can modify this logic

        // Generate excerpt if not provided
        $validated['excerpt'] = $validated['excerpt'] ?? \Illuminate\Support\Str::limit(strip_tags($validated['content']), 200);

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('posts', 'public');
        } elseif ($request->filled('featured_image_url')) {
            // Handle featured image from URL
            $validated['featured_image'] = $this->downloadImageFromUrl($request->featured_image_url, 'posts');
        }

        // Handle gallery images upload
        $galleryImages = [];
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $image) {
                $galleryImages[] = $image->store('posts/gallery', 'public');
            }
        }
        $validated['gallery_images'] = json_encode($galleryImages);

        // Set published_at if status is published
        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        // Set default values
        $validated['allow_comments'] = $validated['allow_comments'] ?? true;
        $validated['is_featured'] = $validated['is_featured'] ?? false;
        $validated['reading_time'] = $validated['reading_time'] ?? $this->calculateReadingTime($validated['content']);

        $post = Post::create($validated);

        // Handle tags
        if ($request->filled('tags')) {
            $tags = array_map('trim', explode(',', $request->tags));
            $post->syncTags($tags);
        }

        // Dispatch real-time events
        event(new PostCreated($post));
        event(new UserActivity(Auth::user(), 'created_post', [
            'post_id' => $post->id,
            'post_title' => $post->title,
            'post_status' => $post->status
        ]));

        // Dispatch admin stats update
        $this->dispatchStatsUpdate();

        // Log activity
        activity()
            ->causedBy(Auth::user())
            ->performedOn($post)
            ->withProperties(['title' => $post->title, 'status' => $post->status])
            ->log('created_post');

        return redirect()->route('admin.posts.index')->with('success', 'Post created successfully!');
    }

    private function calculateReadingTime($content)
    {
        $wordCount = str_word_count(strip_tags($content));
        return max(1, ceil($wordCount / 200)); // Assuming 200 words per minute
    }

    private function downloadImageFromUrl($url, $folder = 'posts')
    {
        try {
            $imageData = file_get_contents($url);
            if ($imageData === false) {
                return null;
            }

            $extension = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION);
            $extension = $extension ?: 'jpg';

            $filename = time() . '_' . uniqid() . '.' . $extension;
            $path = $folder . '/' . $filename;

            \Storage::disk('public')->put($path, $imageData);

            return $path;
        } catch (\Exception $e) {
            \Log::error('Failed to download image from URL: ' . $url . ' - ' . $e->getMessage());
            return null;
        }
    }

    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        $postTitle = $post->title;
        $postId = $post->id;

        $post->delete();

        // Dispatch real-time events
        event(new PostDeleted($postId, $postTitle));
        event(new UserActivity(Auth::user(), 'deleted_post', ['post_id' => $postId, 'post_title' => $postTitle]));

        // Dispatch admin stats update
        $this->dispatchStatsUpdate();

        return back()->with('status', 'Post deleted successfully.');
    }

    public function toggleType(Request $request, Post $post)
    {
        $request->validate([
            'type' => 'required|in:featured,slider,breaking,recommended'
        ]);

        $type = $request->input('type');
        $field = 'is_' . $type;

        // Toggle the boolean value
        $post->update([$field => !$post->$field]);

        $status = $post->$field ? 'enabled' : 'disabled';
        $typeName = ucfirst($type);

        return back()->with('status', "{$typeName} status {$status} for post: {$post->title}");
    }

    public function slider()
    {
        $posts = Post::with(['user:id,name', 'category:id,name'])
            ->select('id', 'title', 'user_id', 'category_id', 'status', 'published_at', 'created_at')
            ->where('is_slider', true)
            ->latest()
            ->paginate(20);

        return view('admin.posts.slider', compact('posts'));
    }

    public function featured()
    {
        $posts = Post::with(['user:id,name', 'category:id,name'])
            ->select('id', 'title', 'user_id', 'category_id', 'status', 'published_at', 'created_at')
            ->where('is_featured', true)
            ->latest()
            ->paginate(20);

        return view('admin.posts.featured', compact('posts'));
    }

    public function breaking()
    {
        $posts = Post::with(['user:id,name', 'category:id,name'])
            ->select('id', 'title', 'user_id', 'category_id', 'status', 'published_at', 'created_at')
            ->where('is_breaking', true)
            ->latest()
            ->paginate(20);

        return view('admin.posts.breaking', compact('posts'));
    }

    public function recommended()
    {
        $posts = Post::with(['user:id,name', 'category:id,name'])
            ->select('id', 'title', 'user_id', 'category_id', 'status', 'published_at', 'created_at')
            ->where('is_recommended', true)
            ->latest()
            ->paginate(20);

        return view('admin.posts.recommended', compact('posts'));
    }

    public function scheduled()
    {
        $posts = Post::with(['user:id,name', 'category:id,name'])
            ->select('id', 'title', 'user_id', 'category_id', 'status', 'published_at', 'created_at')
            ->where('status', 'scheduled')
            ->where('published_at', '>', now())
            ->latest('published_at')
            ->paginate(20);

        return view('admin.posts.scheduled', compact('posts'));
    }

    public function drafts()
    {
        $posts = Post::with(['user:id,name', 'category:id,name'])
            ->select('id', 'title', 'user_id', 'category_id', 'status', 'published_at', 'created_at')
            ->where('status', 'draft')
            ->latest()
            ->paginate(20);

        return view('admin.posts.drafts', compact('posts'));
    }

    private function dispatchStatsUpdate()
    {
        $stats = [
            'total_posts' => Post::count(),
            'published_posts' => Post::where('status', 'published')->count(),
            'pending_posts' => Post::where('status', 'pending')->count(),
            'draft_posts' => Post::where('status', 'draft')->count(),
            'total_users' => \App\Models\User::count(),
            'total_categories' => \App\Models\Category::count(),
            'total_comments' => \App\Models\Comment::count(),
        ];

        event(new AdminStatsUpdated($stats));
    }

    public function edit(Post $post)
    {
        $categories = \App\Models\Category::where('status', 'active')->get();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:draft,pending,published',
            'excerpt' => 'nullable|string|max:500',
        ]);

        // Update slug if title changed
        if ($post->title !== $validated['title']) {
            $validated['slug'] = \Illuminate\Support\Str::slug($validated['title']);

            // Ensure unique slug
            $originalSlug = $validated['slug'];
            $counter = 1;
            while (Post::where('slug', $validated['slug'])->where('id', '!=', $post->id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        $validated['excerpt'] = $validated['excerpt'] ?? \Illuminate\Support\Str::limit(strip_tags($validated['content']), 200);

        $post->update($validated);

        // Dispatch real-time events
        event(new PostUpdated($post->id, $post->title));
        event(new UserActivity(Auth::user(), 'updated_post', ['post_id' => $post->id, 'post_title' => $post->title]));

        // Dispatch admin stats update
        $this->dispatchStatsUpdate();

        return redirect()->route('admin.posts.index')->with('success', 'Post updated successfully!');
    }
}


