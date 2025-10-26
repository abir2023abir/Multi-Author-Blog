<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Events\UserActivity;
use App\Events\AdminStatsUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class MediaController extends Controller
{
    public function index()
    {
        $media = Media::latest()->paginate(20);
        $stats = [
            'total_files' => Media::count(),
            'total_size' => Media::sum('size'),
            'images' => Media::where('type', 'image')->count(),
            'videos' => Media::where('type', 'video')->count(),
            'documents' => Media::where('type', 'document')->count(),
        ];

        return view('admin.media.index', compact('media', 'stats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'files.*' => 'required|file|max:10240', // 10MB max
        ]);

        $uploadedFiles = [];

        foreach ($request->file('files') as $file) {
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $size = $file->getSize();
            $mimeType = $file->getMimeType();

            // Determine file type
            $type = $this->getFileType($mimeType);

            // Generate unique filename
            $filename = time() . '_' . uniqid() . '.' . $extension;

            // Store file
            $path = $file->storeAs('media', $filename, 'public');

            // Create thumbnail for images
            $thumbnailPath = null;
            if ($type === 'image') {
                $thumbnailPath = $this->createThumbnail($file, $filename);
            }

            // Create media record
            $media = Media::create([
                'filename' => $filename,
                'original_name' => $originalName,
                'path' => $path,
                'thumbnail_path' => $thumbnailPath,
                'type' => $type,
                'size' => $size,
                'mime_type' => $mimeType,
                'uploaded_by' => Auth::id(),
            ]);

            $uploadedFiles[] = $media;
        }

        // Dispatch real-time events
        event(new UserActivity(Auth::user(), 'uploaded_media', [
            'count' => count($uploadedFiles),
            'files' => $uploadedFiles->pluck('original_name')->toArray()
        ]));

        $this->dispatchStatsUpdate();

        // Log activity
        activity()
            ->causedBy(Auth::user())
            ->withProperties(['count' => count($uploadedFiles)])
            ->log('uploaded_media');

        return response()->json([
            'status' => 'success',
            'message' => 'Files uploaded successfully',
            'files' => $uploadedFiles
        ]);
    }

    public function show(Media $media)
    {
        return view('admin.media.show', compact('media'));
    }

    public function destroy(Media $media)
    {
        $filename = $media->original_name;
        $filePath = $media->path;
        $thumbnailPath = $media->thumbnail_path;

        // Delete files from storage
        Storage::disk('public')->delete($filePath);
        if ($thumbnailPath) {
            Storage::disk('public')->delete($thumbnailPath);
        }

        $media->delete();

        // Dispatch real-time events
        event(new UserActivity(Auth::user(), 'deleted_media', [
            'filename' => $filename
        ]));

        $this->dispatchStatsUpdate();

        // Log activity
        activity()
            ->causedBy(Auth::user())
            ->withProperties(['filename' => $filename])
            ->log('deleted_media');

        return redirect()->route('admin.media.index')->with('success', 'File deleted successfully!');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'media_ids' => 'required|array|min:1',
            'media_ids.*' => 'exists:media,id'
        ]);

        $mediaFiles = Media::whereIn('id', $request->media_ids);
        $files = $mediaFiles->get();

        foreach ($files as $media) {
            // Delete files from storage
            Storage::disk('public')->delete($media->path);
            if ($media->thumbnail_path) {
                Storage::disk('public')->delete($media->thumbnail_path);
            }
        }

        $mediaFiles->delete();

        // Dispatch real-time events
        event(new UserActivity(Auth::user(), 'bulk_deleted_media', [
            'count' => count($request->media_ids)
        ]));

        $this->dispatchStatsUpdate();

        return redirect()->route('admin.media.index')->with('success', 'Files deleted successfully!');
    }

    public function getStats()
    {
        $stats = [
            'total_files' => Media::count(),
            'total_size' => Media::sum('size'),
            'images' => Media::where('type', 'image')->count(),
            'videos' => Media::where('type', 'video')->count(),
            'documents' => Media::where('type', 'document')->count(),
            'audio' => Media::where('type', 'audio')->count(),
            'recent_uploads' => Media::where('created_at', '>=', now()->subWeek())->count(),
        ];

        return response()->json($stats);
    }

    public function getRecentUploads()
    {
        $media = Media::with('uploader')
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'filename' => $item->original_name,
                    'type' => $item->type,
                    'size' => $this->formatBytes($item->size),
                    'uploader' => $item->uploader ? $item->uploader->name : 'System',
                    'created_at' => $item->created_at->diffForHumans(),
                    'url' => Storage::disk('public')->url($item->path),
                    'thumbnail_url' => $item->thumbnail_path ? Storage::disk('public')->url($item->thumbnail_path) : null,
                ];
            });

        return response()->json($media);
    }

    private function getFileType($mimeType)
    {
        if (str_starts_with($mimeType, 'image/')) {
            return 'image';
        } elseif (str_starts_with($mimeType, 'video/')) {
            return 'video';
        } elseif (str_starts_with($mimeType, 'audio/')) {
            return 'audio';
        } else {
            return 'document';
        }
    }

    private function createThumbnail($file, $filename)
    {
        try {
            $thumbnailFilename = 'thumb_' . $filename;
            $thumbnailPath = 'media/thumbnails/' . $thumbnailFilename;

            $image = Image::make($file);
            $image->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $image->save(storage_path('app/public/' . $thumbnailPath));

            return $thumbnailPath;
        } catch (\Exception $e) {
            return null;
        }
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }

    private function dispatchStatsUpdate()
    {
        $stats = [
            'total_files' => Media::count(),
            'total_size' => Media::sum('size'),
        ];

        event(new AdminStatsUpdated($stats));
    }
}
