<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function index()
    {
        $activeTheme = Setting::where('key', 'active_theme')->value('value') ?? 'magazine';

        $themes = [
            [
                'name' => 'Magazine',
                'slug' => 'magazine',
                'active' => $activeTheme === 'magazine',
                'preview' => 'magazine-preview.jpg',
                'description' => 'Modern magazine layout with featured content'
            ],
            [
                'name' => 'News',
                'slug' => 'news',
                'active' => $activeTheme === 'news',
                'preview' => 'news-preview.jpg',
                'description' => 'Clean news-focused layout'
            ],
            [
                'name' => 'Classic',
                'slug' => 'classic',
                'active' => $activeTheme === 'classic',
                'preview' => 'classic-preview.jpg',
                'description' => 'Traditional blog layout'
            ],
        ];

        $settings = Setting::all()->pluck('value', 'key');

        return view('admin.themes.index', compact('themes', 'settings'));
    }

    public function activate(Request $request)
    {
        $validated = $request->validate([
            'theme' => 'required|string|in:magazine,news,classic'
        ]);

        Setting::updateOrCreate(['key' => 'active_theme'], ['value' => $validated['theme']]);

        return back()->with('status', 'Theme activated successfully.');
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'site_color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'header_color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        foreach ($validated as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return back()->with('status', 'Theme settings updated successfully.');
    }

    public function toggleDarkMode(Request $request)
    {
        $request->validate([
            'dark_mode' => 'required'
        ]);

        // Convert string to boolean properly
        $darkMode = filter_var($request->input('dark_mode'), FILTER_VALIDATE_BOOLEAN);

        Setting::updateOrCreate(['key' => 'dark_mode'], ['value' => $darkMode ? '1' : '0']);

        return response()->json(['success' => true, 'dark_mode' => $darkMode]);
    }
}
