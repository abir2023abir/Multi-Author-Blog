<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $query = Page::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Language filtering (assuming we'll add language field later)
        if ($request->filled('language') && $request->get('language') !== 'all') {
            $query->where('language', $request->get('language'));
        }

        // Status filtering
        if ($request->filled('status')) {
            $query->where('is_published', $request->get('status') === 'published');
        }

        // Sorting functionality
        $sortField = $request->get('sort', 'id');
        $sortDirection = $request->get('direction', 'desc');
        
        // Validate sort field to prevent SQL injection
        $allowedSortFields = ['id', 'title', 'slug', 'is_published', 'created_at', 'updated_at'];
        if (in_array($sortField, $allowedSortFields)) {
            $query->orderBy($sortField, $sortDirection);
        } else {
            $query->orderBy('id', 'desc');
        }

        // Pagination
        $perPage = $request->get('per_page', 15);
        $allowedPerPage = [10, 15, 25, 50, 100];
        if (!in_array($perPage, $allowedPerPage)) {
            $perPage = 15;
        }

        $pages = $query->paginate($perPage)->withQueryString();

        // Get filter options
        $languages = ['all' => 'All', 'en' => 'English', 'ar' => 'Arabic'];
        $statuses = ['all' => 'All', 'published' => 'Published', 'draft' => 'Draft'];

        return view('admin.pages.index', compact('pages', 'languages', 'statuses'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'slug' => 'required|string|unique:pages,slug',
            'meta_description' => 'nullable|string|max:160',
            'is_published' => 'boolean',
            'language' => 'nullable|string|in:en,ar',
            'location' => 'nullable|string|in:main_menu,footer,top_menu',
            'page_type' => 'nullable|string|in:custom,default',
        ]);

        // Set defaults
        $validated['language'] = $validated['language'] ?? 'en';
        $validated['location'] = $validated['location'] ?? 'main_menu';
        $validated['page_type'] = $validated['page_type'] ?? 'custom';

        Page::create($validated);
        return redirect()->route('admin.pages.index')->with('status', 'Page created successfully.');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'slug' => 'required|string|unique:pages,slug,' . $page->id,
            'meta_description' => 'nullable|string|max:160',
            'is_published' => 'boolean',
            'language' => 'nullable|string|in:en,ar',
            'location' => 'nullable|string|in:main_menu,footer,top_menu',
            'page_type' => 'nullable|string|in:custom,default',
        ]);

        // Set defaults
        $validated['language'] = $validated['language'] ?? 'en';
        $validated['location'] = $validated['location'] ?? 'main_menu';
        $validated['page_type'] = $validated['page_type'] ?? 'custom';

        $page->update($validated);
        return redirect()->route('admin.pages.index')->with('status', 'Page updated successfully.');
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return back()->with('status', 'Page deleted successfully.');
    }

    public function show(Page $page)
    {
        return view('admin.pages.show', compact('page'));
    }
}
