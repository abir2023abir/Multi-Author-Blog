<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Poll;
use Illuminate\Http\Request;

class PollController extends Controller
{
    public function index(Request $request)
    {
        $query = Poll::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('question', 'like', "%{$search}%");
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

        $polls = $query->orderBy('id', 'desc')->paginate($perPage)->withQueryString();

        $languages = ['all' => 'All', 'en' => 'English', 'ar' => 'Arabic'];

        return view('admin.polls.index', compact('polls', 'languages'));
    }

    public function create()
    {
        return view('admin.polls.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'language' => 'required|string|in:en,ar',
            'vote_permission' => 'nullable|string',
            'options' => 'required|array|min:2',
            'is_active' => 'boolean',
            'closes_at' => 'nullable|date|after:now',
        ]);

        $validated['is_active'] = $validated['is_active'] ?? true;
        $validated['date_added'] = now();

        Poll::create($validated);
        return redirect()->route('admin.polls.index')->with('status', 'Poll created successfully.');
    }

    public function edit(Poll $poll)
    {
        return view('admin.polls.edit', compact('poll'));
    }

    public function update(Request $request, Poll $poll)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'language' => 'required|string|in:en,ar',
            'vote_permission' => 'nullable|string',
            'options' => 'required|array|min:2',
            'is_active' => 'boolean',
            'closes_at' => 'nullable|date|after:now',
        ]);

        $validated['is_active'] = $validated['is_active'] ?? true;

        $poll->update($validated);
        return redirect()->route('admin.polls.index')->with('status', 'Poll updated successfully.');
    }

    public function destroy(Poll $poll)
    {
        $poll->delete();
        return back()->with('status', 'Poll deleted successfully.');
    }

    public function show(Poll $poll)
    {
        return view('admin.polls.show', compact('poll'));
    }

    public function viewResults(Poll $poll)
    {
        return view('admin.polls.results', compact('poll'));
    }

    public function toggleStatus(Poll $poll)
    {
        $poll->update(['is_active' => !$poll->is_active]);

        $status = $poll->is_active ? 'activated' : 'deactivated';
        return back()->with('status', "Poll '{$poll->question}' {$status} successfully.");
    }

    public function duplicate(Poll $poll)
    {
        $newPoll = $poll->replicate();
        $newPoll->question = $poll->question . ' (Copy)';
        $newPoll->date_added = now();
        $newPoll->save();

        return back()->with('status', "Poll '{$poll->question}' duplicated successfully.");
    }
}
