@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $post->title }}</h1>
                    <p class="text-gray-600">Posted {{ $post->created_at->diffForHumans() }}</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('user.posts.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 flex items-center space-x-2">
                        <i class="fas fa-arrow-left"></i>
                        <span>Back to Posts</span>
                    </a>
                    <a href="{{ route('user.posts.edit', $post) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center space-x-2">
                        <i class="fas fa-edit"></i>
                        <span>Edit Post</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-lg shadow overflow-hidden">
            @if($post->featured_image)
                <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-64 object-cover">
            @endif

            <div class="p-8">
                <!-- Post Meta -->
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            @if($post->status === 'published') bg-green-100 text-green-800
                            @elseif($post->status === 'pending') bg-yellow-100 text-yellow-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($post->status) }}
                        </span>
                        <span class="text-sm text-gray-500">{{ $post->category->name ?? 'Uncategorized' }}</span>
                        <span class="text-sm text-gray-500">{{ $post->views }} views</span>
                    </div>
                    <div class="text-sm text-gray-500">
                        {{ $post->created_at->format('M d, Y') }}
                    </div>
                </div>

                <!-- Post Content -->
                <div class="prose max-w-none">
                    {!! nl2br(e($post->content)) !!}
                </div>

                @if($post->excerpt)
                    <div class="mt-8 p-4 bg-gray-50 rounded-lg">
                        <h3 class="text-sm font-medium text-gray-900 mb-2">Excerpt</h3>
                        <p class="text-gray-700">{{ $post->excerpt }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
