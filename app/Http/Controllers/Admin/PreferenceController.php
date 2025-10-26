<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PreferenceController extends Controller
{
    public function index()
    {
        $preferences = [
            'language' => 'en',
            'timezone' => 'UTC',
            'notifications' => true,
        ];
        return view('admin.preferences.index', compact('preferences'));
    }

    public function update(Request $request)
    {
        // Update user preferences
        return back()->with('status', 'Preferences updated successfully.');
    }
}
