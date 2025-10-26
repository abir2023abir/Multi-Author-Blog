<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Widget;
use Illuminate\Http\Request;

class WidgetController extends Controller
{
    public function index(Request $request)
    {
        $query = Widget::query();
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('where_to_display', 'like', "%{$search}%");
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
        
        $widgets = $query->orderBy('id', 'desc')->paginate($perPage)->withQueryString();
        
        $languages = ['all' => 'All', 'en' => 'English', 'ar' => 'Arabic'];
        
        return view('admin.widgets.index', compact('widgets', 'languages'));
    }

    public function create()
    {
        return view('admin.widgets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'language' => 'required|string|in:en,ar',
            'type' => 'required|string',
            'where_to_display' => 'required|string|max:255',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'visibility' => 'boolean',
        ]);

        $validated['order'] = $validated['order'] ?? 0;
        $validated['is_active'] = $validated['is_active'] ?? true;
        $validated['visibility'] = $validated['visibility'] ?? true;
        $validated['date_added'] = now();

        Widget::create($validated);
        return redirect()->route('admin.widgets.index')->with('status', 'Widget created successfully.');
    }

    public function edit(Widget $widget)
    {
        return view('admin.widgets.edit', compact('widget'));
    }

    public function update(Request $request, Widget $widget)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'language' => 'required|string|in:en,ar',
            'type' => 'required|string',
            'where_to_display' => 'required|string|max:255',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'visibility' => 'boolean',
        ]);

        $validated['order'] = $validated['order'] ?? 0;
        $validated['is_active'] = $validated['is_active'] ?? true;
        $validated['visibility'] = $validated['visibility'] ?? true;

        $widget->update($validated);
        return redirect()->route('admin.widgets.index')->with('status', 'Widget updated successfully.');
    }

    public function destroy(Widget $widget)
    {
        $widget->delete();
        return back()->with('status', 'Widget deleted successfully.');
    }

    public function show(Widget $widget)
    {
        return view('admin.widgets.show', compact('widget'));
    }

    public function toggleVisibility(Widget $widget)
    {
        $widget->update(['visibility' => !$widget->visibility]);
        
        $status = $widget->visibility ? 'visible' : 'hidden';
        return back()->with('status', "Widget '{$widget->title}' is now {$status}.");
    }

    public function duplicate(Widget $widget)
    {
        $newWidget = $widget->replicate();
        $newWidget->title = $widget->title . ' (Copy)';
        $newWidget->date_added = now();
        $newWidget->save();
        
        return back()->with('status', "Widget '{$widget->title}' duplicated successfully.");
    }
}
