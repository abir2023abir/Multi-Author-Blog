@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Video Details</h1>
            <div class="flex space-x-2">
                <a href="{{ route('admin.videos.edit', $video) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                    <i class="fas fa-edit mr-2"></i>Edit Video
                </a>
                <a href="{{ route('admin.videos.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Videos
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Video Player -->
            <div class="lg:col-span-2">
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <div class="aspect-video bg-gray-900">
                        @if($video->youtube_id)
                            <iframe src="{{ $video->embed_url }}"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen
                                    class="w-full h-full">
                            </iframe>
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <div class="text-center text-white">
                                    <i class="fas fa-play-circle text-6xl mb-4"></i>
                                    <p class="text-lg">Direct Video Link</p>
                                    <a href="{{ $video->video_url }}" target="_blank" class="text-blue-400 hover:text-blue-300">
                                        Open Video
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $video->title }}</h2>
                        <div class="flex items-center space-x-4 text-sm text-gray-600 mb-4">
                            <span><i class="fas fa-eye mr-1"></i>{{ $video->formatted_views }}</span>
                            <span><i class="fas fa-clock mr-1"></i>{{ $video->formatted_duration }}</span>
                            <span><i class="fas fa-calendar mr-1"></i>{{ $video->created_at->format('M d, Y') }}</span>
                        </div>

                        @if($video->description)
                            <div class="prose max-w-none">
                                <p class="text-gray-700">{{ $video->description }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Video Information -->
            <div class="space-y-6">
                <!-- Basic Info -->
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Video Information</h3>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Category</label>
                            <p class="text-sm text-gray-900">{{ $video->category ?? 'Uncategorized' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Author</label>
                            <p class="text-sm text-gray-900">{{ $video->author_name ?? 'Unknown' }}</p>
                        </div>
                        @if($video->author_channel)
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Channel</label>
                                <a href="{{ $video->author_channel }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-external-link-alt mr-1"></i>Visit Channel
                                </a>
                            </div>
                        @endif
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Sort Order</label>
                            <p class="text-sm text-gray-900">{{ $video->sort_order }}</p>
                        </div>
                        @if($video->published_at)
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Published</label>
                                <p class="text-sm text-gray-900">{{ $video->published_at->format('M d, Y H:i') }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Status -->
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Status</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-500">Active</span>
                            <span class="px-2 py-1 text-xs rounded-full {{ $video->is_active ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                                {{ $video->is_active ? 'Yes' : 'No' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-500">Featured</span>
                            <span class="px-2 py-1 text-xs rounded-full {{ $video->is_featured ? 'bg-yellow-200 text-yellow-800' : 'bg-gray-200 text-gray-800' }}">
                                {{ $video->is_featured ? 'Yes' : 'No' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Statistics -->
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistics</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-500">Views</span>
                            <span class="text-sm text-gray-900">{{ number_format($video->views_count) }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-500">Likes</span>
                            <span class="text-sm text-gray-900">{{ number_format($video->likes_count) }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-500">Created</span>
                            <span class="text-sm text-gray-900">{{ $video->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-500">Updated</span>
                            <span class="text-sm text-gray-900">{{ $video->updated_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions</h3>
                    <div class="space-y-2">
                        <form action="{{ route('admin.videos.toggle-status', $video) }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit" class="w-full text-left px-3 py-2 text-sm rounded-md {{ $video->is_active ? 'bg-red-100 text-red-700 hover:bg-red-200' : 'bg-green-100 text-green-700 hover:bg-green-200' }}">
                                <i class="fas fa-power-off mr-2"></i>
                                {{ $video->is_active ? 'Deactivate' : 'Activate' }} Video
                            </button>
                        </form>

                        <form action="{{ route('admin.videos.toggle-featured', $video) }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit" class="w-full text-left px-3 py-2 text-sm rounded-md {{ $video->is_featured ? 'bg-yellow-100 text-yellow-700 hover:bg-yellow-200' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                <i class="fas fa-star mr-2"></i>
                                {{ $video->is_featured ? 'Remove from Featured' : 'Add to Featured' }}
                            </button>
                        </form>

                        <form action="{{ route('admin.videos.destroy', $video) }}" method="POST" class="w-full" onsubmit="return confirm('Are you sure you want to delete this video?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full text-left px-3 py-2 text-sm rounded-md bg-red-100 text-red-700 hover:bg-red-200">
                                <i class="fas fa-trash mr-2"></i>Delete Video
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
