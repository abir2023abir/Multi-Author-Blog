<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;
use League\Csv\Writer;

class BulkPostController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.bulk-posts.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,xlsx|max:10240', // 10MB max
        ]);

        try {
            $file = $request->file('file');
            $path = $file->store('temp');
            $fullPath = storage_path('app/' . $path);

            // Process CSV file
            $csv = Reader::createFromPath($fullPath);
            $csv->setHeaderOffset(0);
            $records = $csv->getRecords();

            $imported = 0;
            $errors = [];

            foreach ($records as $index => $record) {
                try {
                    // Validate required fields
                    if (empty($record['title']) || empty($record['content'])) {
                        $errors[] = "Row " . ($index + 2) . ": Title and content are required";
                        continue;
                    }

                    // Create post
                    Post::create([
                        'title' => $record['title'],
                        'content' => $record['content'],
                        'category_id' => $record['category_id'] ?? null,
                        'post_format' => $record['post_format'] ?? 'article',
                        'meta_description' => $record['meta_description'] ?? null,
                        'featured_image' => $record['featured_image'] ?? null,
                        'user_id' => Auth::id(),
                        'status' => 'published',
                        'published_at' => now(),
                    ]);

                    $imported++;
                } catch (\Exception $e) {
                    $errors[] = "Row " . ($index + 2) . ": " . $e->getMessage();
                }
            }

            // Clean up temp file
            Storage::delete($path);

            $message = "Successfully imported {$imported} posts.";
            if (!empty($errors)) {
                $message .= " Errors: " . implode(', ', array_slice($errors, 0, 5));
                if (count($errors) > 5) {
                    $message .= " and " . (count($errors) - 5) . " more errors.";
                }
            }

            return back()->with('status', $message);

        } catch (\Exception $e) {
            return back()->with('error', 'Error processing file: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        $csv = Writer::createFromString('');
        $csv->insertOne([
            'title',
            'content',
            'category_id',
            'post_format',
            'meta_description',
            'featured_image'
        ]);

        $csv->insertOne([
            'Sample Post Title',
            'This is sample content for the post.',
            '1',
            'article',
            'Sample meta description',
            'https://example.com/image.jpg'
        ]);

        return response($csv->toString(), 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="bulk_post_template.csv"'
        ]);
    }

    public function downloadExample()
    {
        $csv = Writer::createFromString('');
        $csv->insertOne([
            'title',
            'content',
            'category_id',
            'post_format',
            'meta_description',
            'featured_image'
        ]);

        $csv->insertOne([
            'Welcome to Our Blog',
            'This is the first post on our amazing blog. We cover topics about technology, design, and more.',
            '1',
            'article',
            'Welcome post introducing our blog',
            'https://example.com/welcome.jpg'
        ]);

        $csv->insertOne([
            'Design Trends 2024',
            'Here are the latest design trends for 2024 that every designer should know about.',
            '2',
            'article',
            'Latest design trends for 2024',
            'https://example.com/design-trends.jpg'
        ]);

        return response($csv->toString(), 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="bulk_post_example.csv"'
        ]);
    }

    public function categoryIds()
    {
        $categories = Category::orderBy('name')->get();

        $csv = Writer::createFromString('');
        $csv->insertOne(['id', 'name', 'description']);

        foreach ($categories as $category) {
            $csv->insertOne([
                $category->id,
                $category->name,
                $category->description ?? ''
            ]);
        }

        return response($csv->toString(), 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="category_ids.csv"'
        ]);
    }
}
