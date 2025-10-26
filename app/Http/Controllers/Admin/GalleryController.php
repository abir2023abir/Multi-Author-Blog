<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::latest()->paginate(20);
        return view('admin.gallery.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image_path' => 'required|string',
        ]);

        Gallery::create($validated);
        return redirect()->route('admin.gallery.index')->with('status', 'Image added successfully.');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        // Upload logic here
        return back()->with('status', 'Image uploaded successfully.');
    }

    public function edit(Gallery $gallery)
    {
        return view('admin.gallery.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $gallery->update($validated);
        return redirect()->route('admin.gallery.index')->with('status', 'Image updated successfully.');
    }

    public function destroy(Gallery $gallery)
    {
        $gallery->delete();
        return back()->with('status', 'Image deleted successfully.');
    }

    public function show(Gallery $gallery)
    {
        return view('admin.gallery.show', compact('gallery'));
    }
}
