<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * Get featured videos for homepage
     */
    public function getFeatured(Request $request)
    {
        $limit = $request->get('limit', 8);

        $videos = Video::active()
            ->featured()
            ->published()
            ->orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        return response()->json($videos);
    }

    /**
     * Get all active videos
     */
    public function index(Request $request)
    {
        $query = Video::active()->published();

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $videos = $query->paginate($request->get('per_page', 12));

        return response()->json($videos);
    }

    /**
     * Get video by ID
     */
    public function show(Video $video)
    {
        // Increment view count
        $video->increment('views_count');

        return response()->json($video);
    }

    /**
     * Get video categories
     */
    public function getCategories()
    {
        $categories = Video::active()
            ->distinct()
            ->pluck('category')
            ->filter()
            ->values();

        return response()->json($categories);
    }
}
