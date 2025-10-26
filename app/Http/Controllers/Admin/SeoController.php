<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    public function index()
    {
        $seoSettings = [
            'site_title' => Setting::where('key', 'site_title')->value('value') ?? 'My Blog',
            'meta_description' => Setting::where('key', 'meta_description')->value('value') ?? '',
            'meta_keywords' => Setting::where('key', 'meta_keywords')->value('value') ?? '',
        ];
        return view('admin.seo.index', compact('seoSettings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
        ]);

        foreach ($validated as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return back()->with('status', 'SEO settings updated successfully.');
    }
}
