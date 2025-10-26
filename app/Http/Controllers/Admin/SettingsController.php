<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Events\UserActivity;
use App\Events\AdminStatsUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        $categories = [
            'general' => 'General Settings',
            'seo' => 'SEO Settings',
            'email' => 'Email Settings',
            'social' => 'Social Media',
            'appearance' => 'Appearance',
            'security' => 'Security',
            'performance' => 'Performance',
        ];

        return view('admin.settings.index', compact('settings', 'categories'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'settings' => 'required|array',
            'settings.*' => 'nullable|string|max:1000'
        ]);

        $updatedSettings = [];

        foreach ($request->settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
            $updatedSettings[] = $key;
        }

        // Clear settings cache
        Cache::forget('settings');

        // Dispatch real-time events
        event(new UserActivity(Auth::user(), 'updated_settings', [
            'updated_keys' => $updatedSettings
        ]));

        // Log activity
        activity()
            ->causedBy(Auth::user())
            ->withProperties(['updated_keys' => $updatedSettings])
            ->log('updated_settings');

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully!');
    }

    public function updateCategory(Request $request, $category)
    {
        $validated = $request->validate([
            'settings' => 'required|array',
            'settings.*' => 'nullable|string|max:1000'
        ]);

        $updatedSettings = [];

        foreach ($validated['settings'] as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
            $updatedSettings[] = $key;
        }

        // Clear settings cache
        Cache::forget('settings');

        // Dispatch real-time events
        event(new UserActivity(Auth::user(), 'updated_settings_category', [
            'category' => $category,
            'updated_keys' => $updatedSettings
        ]));

        // Log activity
        activity()
            ->causedBy(Auth::user())
            ->withProperties(['category' => $category, 'updated_keys' => $updatedSettings])
            ->log('updated_settings_category');

        return response()->json([
            'status' => 'success',
            'message' => ucfirst($category) . ' settings updated successfully'
        ]);
    }

    public function resetToDefault(Request $request)
    {
        $request->validate([
            'category' => 'required|string|in:general,seo,email,social,appearance,security,performance'
        ]);

        $defaultSettings = $this->getDefaultSettings($request->category);
        $updatedSettings = [];

        foreach ($defaultSettings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
            $updatedSettings[] = $key;
        }

        // Clear settings cache
        Cache::forget('settings');

        // Dispatch real-time events
        event(new UserActivity(Auth::user(), 'reset_settings_to_default', [
            'category' => $request->category,
            'updated_keys' => $updatedSettings
        ]));

        // Log activity
        activity()
            ->causedBy(Auth::user())
            ->withProperties(['category' => $request->category])
            ->log('reset_settings_to_default');

        return response()->json([
            'status' => 'success',
            'message' => ucfirst($request->category) . ' settings reset to default'
        ]);
    }

    public function export()
    {
        $settings = Setting::all()->pluck('value', 'key');
        $filename = 'settings_export_' . date('Y-m-d_H-i-s') . '.json';

        $content = json_encode($settings, JSON_PRETTY_PRINT);

        return response($content)
            ->header('Content-Type', 'application/json')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    public function import(Request $request)
    {
        $request->validate([
            'settings_file' => 'required|file|mimes:json|max:2048'
        ]);

        $content = file_get_contents($request->file('settings_file')->getPathname());
        $settings = json_decode($content, true);

        if (!$settings) {
            return redirect()->route('admin.settings.index')
                ->with('error', 'Invalid settings file format');
        }

        $importedCount = 0;
        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
            $importedCount++;
        }

        // Clear settings cache
        Cache::forget('settings');

        // Dispatch real-time events
        event(new UserActivity(Auth::user(), 'imported_settings', [
            'imported_count' => $importedCount
        ]));

        // Log activity
        activity()
            ->causedBy(Auth::user())
            ->withProperties(['imported_count' => $importedCount])
            ->log('imported_settings');

        return redirect()->route('admin.settings.index')
            ->with('success', "Successfully imported {$importedCount} settings!");
    }

    public function getSettingsByCategory($category)
    {
        $settings = Setting::where('key', 'like', $category . '.%')
            ->orWhere('key', 'like', $category . '_%')
            ->get()
            ->pluck('value', 'key');

        return response()->json($settings);
    }

    private function getDefaultSettings($category)
    {
        $defaults = [
            'general' => [
                'site_name' => 'Multi Author Blog',
                'site_description' => 'A modern multi-author blog platform',
                'site_url' => url('/'),
                'admin_email' => 'admin@example.com',
                'timezone' => 'UTC',
                'date_format' => 'Y-m-d',
                'time_format' => 'H:i:s',
            ],
            'seo' => [
                'meta_title' => 'Multi Author Blog',
                'meta_description' => 'A modern multi-author blog platform',
                'meta_keywords' => 'blog, multi-author, content',
                'og_image' => '',
                'twitter_card' => 'summary_large_image',
            ],
            'email' => [
                'mail_driver' => 'smtp',
                'mail_host' => 'smtp.gmail.com',
                'mail_port' => '587',
                'mail_username' => '',
                'mail_password' => '',
                'mail_encryption' => 'tls',
                'mail_from_address' => 'noreply@example.com',
                'mail_from_name' => 'Multi Author Blog',
            ],
            'social' => [
                'facebook_url' => '',
                'twitter_url' => '',
                'instagram_url' => '',
                'linkedin_url' => '',
                'youtube_url' => '',
                'github_url' => '',
            ],
            'appearance' => [
                'theme' => 'default',
                'primary_color' => '#1173d4',
                'secondary_color' => '#6c757d',
                'logo' => '',
                'favicon' => '',
                'custom_css' => '',
            ],
            'security' => [
                'password_min_length' => '8',
                'password_require_special' => '1',
                'login_attempts_limit' => '5',
                'session_timeout' => '120',
                'two_factor_auth' => '0',
            ],
            'performance' => [
                'cache_enabled' => '1',
                'cache_duration' => '3600',
                'image_optimization' => '1',
                'lazy_loading' => '1',
                'cdn_enabled' => '0',
                'cdn_url' => '',
            ],
        ];

        return $defaults[$category] ?? [];
    }
}
