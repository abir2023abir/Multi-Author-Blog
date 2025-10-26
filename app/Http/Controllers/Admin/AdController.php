<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use Illuminate\Http\Request;

class AdController extends Controller
{
    public function index()
    {
        $ads = Ad::latest()->paginate(20);
        return view('admin.ads.index', compact('ads'));
    }

    public function create()
    {
        return view('admin.ads.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string',
            'position' => 'required|string',
            'width' => 'nullable|integer|min:1',
            'height' => 'nullable|integer|min:1',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
            'is_responsive' => 'boolean',
        ]);

        // Set default values for boolean fields
        $validated['is_active'] = $request->has('is_active');
        $validated['is_responsive'] = $request->has('is_responsive');

        Ad::create($validated);
        return redirect()->route('admin.ads.index')->with('status', 'Ad created successfully.');
    }

    public function edit(Ad $ad)
    {
        return view('admin.ads.edit', compact('ad'));
    }

    public function update(Request $request, Ad $ad)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string',
            'position' => 'required|string',
            'width' => 'nullable|integer|min:1',
            'height' => 'nullable|integer|min:1',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
            'is_responsive' => 'boolean',
        ]);

        // Set default values for boolean fields
        $validated['is_active'] = $request->has('is_active');
        $validated['is_responsive'] = $request->has('is_responsive');

        $ad->update($validated);
        return redirect()->route('admin.ads.index')->with('status', 'Ad updated successfully.');
    }

    public function destroy(Ad $ad)
    {
        $ad->delete();
        return back()->with('status', 'Ad deleted successfully.');
    }

    public function show(Ad $ad)
    {
        return view('admin.ads.show', compact('ad'));
    }
}
