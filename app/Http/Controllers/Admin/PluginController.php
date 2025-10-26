<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class PluginController extends Controller
{
    public function index()
    {
        $availablePlugins = [
            [
                'name' => 'post-scheduler',
                'title' => 'Post Scheduler',
                'description' => 'Schedule posts for future publication',
                'active' => Setting::where('key', 'plugin_post-scheduler')->where('value', 'active')->exists(),
            ],
            [
                'name' => 'social-share',
                'title' => 'Social Share',
                'description' => 'Enable social media sharing buttons',
                'active' => Setting::where('key', 'plugin_social-share')->where('value', 'active')->exists(),
            ],
            [
                'name' => 'analytics',
                'title' => 'Analytics',
                'description' => 'Track site analytics and visitor data',
                'active' => Setting::where('key', 'plugin_analytics')->where('value', 'active')->exists(),
            ],
            [
                'name' => 'backup',
                'title' => 'Backup',
                'description' => 'Automated database backups',
                'active' => Setting::where('key', 'plugin_backup')->where('value', 'active')->exists(),
            ],
            [
                'name' => 'sitemap',
                'title' => 'Sitemap Generator',
                'description' => 'Auto-generate XML sitemaps for SEO',
                'active' => Setting::where('key', 'plugin_sitemap')->where('value', 'active')->exists(),
            ],
        ];

        return view('admin.plugins.index', compact('availablePlugins'));
    }

    public function activate(Request $request)
    {
        $pluginName = $request->plugin;

        try {
            Artisan::call('plugin:activate', ['plugin' => $pluginName]);
            return back()->with('status', "Plugin '{$pluginName}' activated successfully!");
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to activate plugin: ' . $e->getMessage());
        }
    }

    public function deactivate(Request $request)
    {
        $pluginName = $request->plugin;

        Setting::where('key', "plugin_{$pluginName}")->delete();

        return back()->with('status', "Plugin '{$pluginName}' deactivated successfully!");
    }
}
