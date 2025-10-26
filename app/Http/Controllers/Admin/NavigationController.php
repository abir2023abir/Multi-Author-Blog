<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Navigation;
use Illuminate\Http\Request;

class NavigationController extends Controller
{
    public function index()
    {
        $navigations = Navigation::orderBy('order')->paginate(20);
        return view('admin.navigation.index', compact('navigations'));
    }

    public function create()
    {
        return view('admin.navigation.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'order' => 'nullable|integer',
            'parent_id' => 'nullable|exists:navigations,id',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? (bool)$request->is_active : true;
        $validated['type'] = 'link'; // Default type

        Navigation::create($validated);
        return redirect()->route('admin.navigation.index')->with('status', 'Navigation item created successfully.');
    }

    public function edit(Navigation $navigation)
    {
        $navigations = Navigation::where('id', '!=', $navigation->id)->get();
        return view('admin.navigation.edit', compact('navigation', 'navigations'));
    }

    public function update(Request $request, Navigation $navigation)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'order' => 'nullable|integer',
            'parent_id' => 'nullable|exists:navigations,id',
        ]);

        $navigation->update($validated);
        return redirect()->route('admin.navigation.index')->with('status', 'Navigation item updated successfully.');
    }

    public function destroy(Navigation $navigation)
    {
        $navigation->delete();
        return back()->with('status', 'Navigation item deleted successfully.');
    }

    public function updateOrder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:navigations,id',
            'items.*.order' => 'required|integer',
        ]);

        foreach ($request->items as $item) {
            Navigation::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json(['success' => true]);
    }

    public function updateLimit(Request $request)
    {
        $request->validate([
            'menu_limit' => 'required|integer|min:1|max:50',
        ]);

        // Store menu limit in settings
        \App\Models\Setting::updateOrCreate(
            ['key' => 'menu_limit'],
            ['value' => $request->menu_limit, 'type' => 'setting']
        );

        return back()->with('status', 'Menu limit updated successfully.');
    }
}
