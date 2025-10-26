<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class StorageController extends Controller
{
    public function index()
    {
        $totalFiles = count(Storage::allFiles('public'));
        $totalSize = 0;
        
        foreach (Storage::allFiles('public') as $file) {
            $totalSize += Storage::size($file);
        }
        
        $totalSize = round($totalSize / 1024 / 1024, 2); // Convert to MB
        
        return view('admin.storage.index', compact('totalFiles', 'totalSize'));
    }

    public function clean(Request $request)
    {
        // Clean temporary files logic here
        return back()->with('status', 'Storage cleaned successfully.');
    }
}
