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
                    <a href="{{ route('writer.posts.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 flex items-center space-x-2">
                        <i class="fas fa-arrow-left"></i>
                        <span>Back to Posts</span>
                    </a>
                    <a href="{{ route('writer.posts.edit', $post) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center space-x-2">
                        <i class="fas fa-edit"></i>
                        <span>Edit Post</span>
                    </a>
                    @if($post->status === 'published')
                        <a href="{{ route('posts.show', $post) }}" target="_blank" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 flex items-center space-x-2">
                            <i class="fas fa-external-link-alt"></i>
                            <span>View Live</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <i class="fas fa-eye text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Views</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($post->views) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <i class="fas fa-comments text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Comments</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $post->comments_count ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-purple-100 rounded-lg">
                        <i class="fas fa-heart text-purple-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Reactions</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $post->reactions_count ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-yellow-100 rounded-lg">
                        <i class="fas fa-share-alt text-yellow-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Shares</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $post->shares_count ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Post Content -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            @if($post->featured_image)
                <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-96 object-cover">
            @endif

            <div class="p-8">
                <!-- Post Meta -->
                <div class="flex items-center justify-between mb-6 pb-6 border-b border-gray-200">
                    <div class="flex items-center space-x-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            @if($post->status === 'published') bg-green-100 text-green-800
                            @elseif($post->status === 'pending') bg-yellow-100 text-yellow-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            <i class="fas fa-circle text-xs mr-2"></i>
                            {{ ucfirst($post->status) }}
                        </span>
                        @if($post->category)
                            <span class="text-sm text-gray-500">
                                <i class="fas fa-folder text-gray-400"></i>
                                {{ $post->category->name }}
                            </span>
                        @endif
                        @if($post->reading_time)
                            <span class="text-sm text-gray-500">
                                <i class="fas fa-clock text-gray-400"></i>
                                {{ $post->reading_time }} min read
                            </span>
                        @endif
                    </div>
                    <div class="text-sm text-gray-500">
                        <i class="fas fa-calendar text-gray-400"></i>
                        {{ $post->created_at->format('M d, Y') }}
                    </div>
                </div>

                <!-- Excerpt -->
                @if($post->excerpt)
                    <div class="mb-6 p-4 bg-blue-50 border-l-4 border-blue-500 rounded">
                        <p class="text-gray-700 italic">{{ $post->excerpt }}</p>
                    </div>
                @endif

                <!-- Post Content -->
                <div class="prose prose-lg max-w-none">
                    {!! $post->content !!}
                </div>

                <!-- Tags -->
                @if($post->tags && count($post->tags) > 0)
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h3 class="text-sm font-medium text-gray-900 mb-3">Tags</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($post->tags as $tag)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-gray-100 text-gray-700">
                                    <i class="fas fa-tag text-xs mr-2"></i>
                                    {{ $tag }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Gallery Images -->
                @if($post->gallery_images && count($post->gallery_images) > 0)
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h3 class="text-sm font-medium text-gray-900 mb-3">Gallery</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($post->gallery_images as $image)
                                <img src="{{ Storage::url($image) }}" alt="Gallery image" class="w-full h-48 object-cover rounded-lg">
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- SEO Information -->
                @if($post->meta_title || $post->meta_description)
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h3 class="text-sm font-medium text-gray-900 mb-3">
                            <i class="fas fa-search text-gray-400"></i>
                            SEO Information
                        </h3>
                        <div class="bg-gray-50 p-4 rounded-lg space-y-2">
                            @if($post->meta_title)
                                <div>
                                    <span class="text-xs font-medium text-gray-500">Meta Title:</span>
                                    <p class="text-sm text-gray-900">{{ $post->meta_title }}</p>
                                </div>
                            @endif
                            @if($post->meta_description)
                                <div>
                                    <span class="text-xs font-medium text-gray-500">Meta Description:</span>
                                    <p class="text-sm text-gray-900">{{ $post->meta_description }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Actions -->
        <div class="mt-6 flex justify-between items-center">
            <a href="{{ route('writer.posts.index') }}" class="text-gray-600 hover:text-gray-900">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to My Posts
            </a>
            <div class="flex space-x-3">
                <a href="{{ route('writer.posts.edit', $post) }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 flex items-center space-x-2">
                    <i class="fas fa-edit"></i>
                    <span>Edit Post</span>
                </a>
                @if($post->status === 'published')
                    <a href="{{ route('posts.show', $post) }}" target="_blank" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 flex items-center space-x-2">
                        <i class="fas fa-external-link-alt"></i>
                        <span>View Live</span>
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
