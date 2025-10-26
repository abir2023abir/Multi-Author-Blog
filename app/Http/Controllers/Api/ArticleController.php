<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Get latest articles for homepage
     */
    public function getLatest(Request $request)
    {
        $perPage = $request->get('per_page', Setting::get('articles_per_page', 6));
        $sortBy = $request->get('sort_by', Setting::get('articles_sort_by', 'published_at'));
        $sortOrder = $request->get('sort_order', Setting::get('articles_sort_order', 'desc'));

        $articles = Post::with(['author', 'category'])
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy($sortBy, $sortOrder)
            ->paginate($perPage);

        // Transform the data to include required fields
        $articles->getCollection()->transform(function ($post) {
            // Generate slug if not exists
            if (!$post->slug) {
                $post->slug = \Illuminate\Support\Str::slug($post->title);
                $post->save();
            }

            // Generate excerpt if not exists
            if (!$post->excerpt) {
                $post->excerpt = \Illuminate\Support\Str::limit(strip_tags($post->content), 200);
                $post->save();
            }

            return [
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
                'excerpt' => $post->excerpt,
                'featured_image' => $post->featured_image,
                'category' => $post->category?->name,
                'author' => [
                    'id' => $post->author?->id,
                    'name' => $post->author?->name,
                    'avatar_url' => $post->author?->avatar_url,
                ],
                'published_at' => $post->published_at,
                'created_at' => $post->created_at,
                'view_count' => $post->view_count,
                'likes_count' => $post->reactions()->where('type', 'like')->count(),
                'comments_count' => $post->comments()->count(),
                'read_time' => $this->calculateReadTime($post->content),
            ];
        });

        return response()->json($articles);
    }

    /**
     * Get popular tags
     */
    public function getPopularTags(Request $request)
    {
        $limit = $request->get('limit', 6);

        // Get tags from posts (assuming posts have tags field or relationship)
        $tags = Post::where('status', 'published')
            ->whereNotNull('tags')
            ->get()
            ->pluck('tags')
            ->flatten()
            ->countBy()
            ->sortDesc()
            ->take($limit)
            ->map(function ($count, $name) {
                return [
                    'name' => $name,
                    'slug' => strtolower(str_replace(' ', '-', $name)),
                    'count' => $count,
                ];
            })
            ->values();

        return response()->json($tags);
    }

    /**
     * Get popular categories
     */
    public function getPopularCategories(Request $request)
    {
        $limit = $request->get('limit', 4);

        $categories = Category::withCount('posts')
            ->where('status', true)
            ->orderBy('posts_count', 'desc')
            ->limit($limit)
            ->get()
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'color' => $category->color,
                    'posts_count' => $category->posts_count,
                ];
            });

        return response()->json($categories);
    }

    /**
     * Calculate read time for article
     */
    private function calculateReadTime($content)
    {
        $wordCount = str_word_count(strip_tags($content));
        $readTime = ceil($wordCount / 200); // Average reading speed: 200 words per minute
        return max(1, $readTime);
    }
}
