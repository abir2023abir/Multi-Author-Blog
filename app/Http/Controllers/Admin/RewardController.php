<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reward;
use App\Models\User;
use Illuminate\Http\Request;

class RewardController extends Controller
{
    public function index()
    {
        $rewards = Reward::with('user:id,name')->latest()->paginate(20);
        return view('admin.rewards.index', compact('rewards'));
    }

    public function create()
    {
        $users = User::all(['id', 'name']);
        return view('admin.rewards.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'points' => 'required|integer',
            'reason' => 'nullable|string',
        ]);

        Reward::create($validated);
        return redirect()->route('admin.rewards.index')->with('status', 'Reward added successfully.');
    }

    public function edit(Reward $reward)
    {
        $users = User::all(['id', 'name']);
        return view('admin.rewards.edit', compact('reward', 'users'));
    }

    public function update(Request $request, Reward $reward)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'points' => 'required|integer',
            'reason' => 'nullable|string',
        ]);

        $reward->update($validated);
        return redirect()->route('admin.rewards.index')->with('status', 'Reward updated successfully.');
    }

    public function destroy(Reward $reward)
    {
        $reward->delete();
        return back()->with('status', 'Reward deleted successfully.');
    }

    public function show(Reward $reward)
    {
        return view('admin.rewards.show', compact('reward'));
    }
}
