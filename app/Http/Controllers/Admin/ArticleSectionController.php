<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class ArticleSectionController extends Controller
{
    /**
     * Display the article section settings
     */
    public function index()
    {
        $settings = [
            'articles_per_page' => Setting::get('articles_per_page', 6),
            'show_sidebar' => Setting::get('show_sidebar', true),
            'show_hottest_authors' => Setting::get('show_hottest_authors', true),
            'show_suggested_tags' => Setting::get('show_suggested_tags', true),
            'show_suggested_categories' => Setting::get('show_suggested_categories', true),
            'hottest_authors_limit' => Setting::get('hottest_authors_limit', 4),
            'suggested_tags_limit' => Setting::get('suggested_tags_limit', 6),
            'suggested_categories_limit' => Setting::get('suggested_categories_limit', 4),
            'section_title' => Setting::get('articles_section_title', 'Latest articles'),
            'section_subtitle' => Setting::get('articles_section_subtitle', 'Explore the most popular categories'),
            'show_load_more' => Setting::get('show_load_more', true),
            'articles_sort_by' => Setting::get('articles_sort_by', 'published_at'),
            'articles_sort_order' => Setting::get('articles_sort_order', 'desc'),
        ];

        return view('admin.article-section.index', compact('settings'));
    }

    /**
     * Update the article section settings
     */
    public function update(Request $request)
    {
        $request->validate([
            'articles_per_page' => 'required|integer|min:1|max:20',
            'show_sidebar' => 'boolean',
            'show_hottest_authors' => 'boolean',
            'show_suggested_tags' => 'boolean',
            'show_suggested_categories' => 'boolean',
            'hottest_authors_limit' => 'required|integer|min:1|max:10',
            'suggested_tags_limit' => 'required|integer|min:1|max:20',
            'suggested_categories_limit' => 'required|integer|min:1|max:10',
            'section_title' => 'required|string|max:255',
            'section_subtitle' => 'required|string|max:255',
            'show_load_more' => 'boolean',
            'articles_sort_by' => 'required|string|in:published_at,created_at,view_count,title',
            'articles_sort_order' => 'required|string|in:asc,desc',
        ]);

        $settings = [
            'articles_per_page' => $request->articles_per_page,
            'show_sidebar' => $request->boolean('show_sidebar'),
            'show_hottest_authors' => $request->boolean('show_hottest_authors'),
            'show_suggested_tags' => $request->boolean('show_suggested_tags'),
            'show_suggested_categories' => $request->boolean('show_suggested_categories'),
            'hottest_authors_limit' => $request->hottest_authors_limit,
            'suggested_tags_limit' => $request->suggested_tags_limit,
            'suggested_categories_limit' => $request->suggested_categories_limit,
            'articles_section_title' => $request->section_title,
            'articles_section_subtitle' => $request->section_subtitle,
            'show_load_more' => $request->boolean('show_load_more'),
            'articles_sort_by' => $request->articles_sort_by,
            'articles_sort_order' => $request->articles_sort_order,
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, $value);
        }

        return redirect()->route('admin.article-section.index')
                        ->with('success', 'Article section settings updated successfully.');
    }

    /**
     * Reset settings to default
     */
    public function reset()
    {
        $defaultSettings = [
            'articles_per_page' => 6,
            'show_sidebar' => true,
            'show_hottest_authors' => true,
            'show_suggested_tags' => true,
            'show_suggested_categories' => true,
            'hottest_authors_limit' => 4,
            'suggested_tags_limit' => 6,
            'suggested_categories_limit' => 4,
            'articles_section_title' => 'Latest articles',
            'articles_section_subtitle' => 'Explore the most popular categories',
            'show_load_more' => true,
            'articles_sort_by' => 'published_at',
            'articles_sort_order' => 'desc',
        ];

        foreach ($defaultSettings as $key => $value) {
            Setting::set($key, $value);
        }

        return redirect()->route('admin.article-section.index')
                        ->with('success', 'Article section settings reset to default.');
    }
}
