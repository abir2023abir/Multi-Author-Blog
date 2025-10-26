<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function index()
    {
        $newsletters = Newsletter::latest()->paginate(20);
        return view('admin.newsletter.index', compact('newsletters'));
    }

    public function create()
    {
        return view('admin.newsletter.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:newsletters,email',
        ]);

        Newsletter::create($validated);
        return redirect()->route('admin.newsletter.index')->with('status', 'Subscriber added successfully.');
    }

    public function send(Request $request)
    {
        // Email sending logic would go here
        return back()->with('status', 'Newsletter sent successfully.');
    }

    public function edit(Newsletter $newsletter)
    {
        return view('admin.newsletter.edit', compact('newsletter'));
    }

    public function update(Request $request, Newsletter $newsletter)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:newsletters,email,' . $newsletter->id,
        ]);

        $newsletter->update($validated);
        return redirect()->route('admin.newsletter.index')->with('status', 'Subscriber updated successfully.');
    }

    public function destroy(Newsletter $newsletter)
    {
        $newsletter->delete();
        return back()->with('status', 'Subscriber deleted successfully.');
    }

    public function show(Newsletter $newsletter)
    {
        return view('admin.newsletter.show', compact('newsletter'));
    }
}
