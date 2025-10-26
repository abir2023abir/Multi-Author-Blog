<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RssFeed;
use Illuminate\Http\Request;

class RssController extends Controller
{
    public function index(Request $request)
    {
        $query = RssFeed::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('url', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            });
        }

        // Language filter
        if ($request->filled('language') && $request->get('language') !== 'all') {
            $query->where('language', $request->get('language'));
        }

        // Per page setting
        $perPage = $request->get('per_page', 15);
        $allowedPerPage = [10, 15, 25, 50, 100];
        if (!in_array($perPage, $allowedPerPage)) {
            $perPage = 15;
        }

        $feeds = $query->orderBy('id', 'desc')->paginate($perPage)->withQueryString();

        $languages = ['all' => 'All', 'en' => 'English', 'ar' => 'Arabic'];

        return view('admin.rss.index', compact('feeds', 'languages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:500',
            'language' => 'required|string|in:en,ar',
            'categories' => 'nullable|string',
            'auto_update' => 'boolean',
            'download_images' => 'boolean',
        ]);

        $validated['categories'] = $validated['categories'] ?
            array_map('trim', explode(',', $validated['categories'])) : [];
        $validated['author'] = auth()->user()->name ?? 'admin';
        $validated['posts_count'] = 0;

        RssFeed::create($validated);

        return back()->with('status', 'RSS feed imported successfully.');
    }

    public function update(Request $request, RssFeed $rssFeed)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:500',
            'language' => 'required|string|in:en,ar',
            'categories' => 'nullable|string',
            'auto_update' => 'boolean',
            'download_images' => 'boolean',
        ]);

        $validated['categories'] = $validated['categories'] ?
            array_map('trim', explode(',', $validated['categories'])) : [];

        $rssFeed->update($validated);

        return back()->with('status', 'RSS feed updated successfully.');
    }

    public function destroy(RssFeed $rssFeed)
    {
        $rssFeed->delete();
        return back()->with('status', 'RSS feed deleted successfully.');
    }

    public function updateFeed(RssFeed $rssFeed)
    {
        // Simulate RSS feed update
        $rssFeed->update([
            'last_updated' => now(),
            'posts_count' => $rssFeed->posts_count + rand(1, 5)
        ]);

        return back()->with('status', "RSS feed '{$rssFeed->name}' updated successfully.");
    }
}
