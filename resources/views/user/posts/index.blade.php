@extends('layouts.app')

@section('title', 'My Posts')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">My Posts</h1>
                    <p class="text-gray-600">Manage and organize your content</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('user.dashboard') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 flex items-center space-x-2">
                        <i class="fas fa-arrow-left"></i>
                        <span>Back to Dashboard</span>
                    </a>
                    <a href="{{ route('user.posts.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center space-x-2">
                        <i class="fas fa-plus"></i>
                        <span>Create New Post</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if($posts->count() > 0)
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">All Posts ({{ $posts->total() }})</h2>
                </div>
                <div class="divide-y divide-gray-200">
                    @foreach($posts as $post)
                        <div class="p-6 hover:bg-gray-50">
                            <div class="flex items-start space-x-4">
                                @if($post->featured_image)
                                    <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="w-20 h-20 object-cover rounded-lg">
                                @else
                                    <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400"></i>
                                    </div>
                                @endif
                                
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-lg font-medium text-gray-900">{{ $post->title }}</h3>
                                        <div class="flex items-center space-x-2">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @if($post->status === 'published') bg-green-100 text-green-800
                                                @elseif($post->status === 'pending') bg-yellow-100 text-yellow-800
                                                @else bg-gray-100 text-gray-800
                                                @endif">
                                                {{ ucfirst($post->status) }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <p class="text-sm text-gray-600 mt-1">{{ $post->excerpt ?? Str::limit(strip_tags($post->content), 150) }}</p>
                                    
                                    <div class="flex items-center justify-between mt-3">
                                        <div class="flex items-center space-x-4 text-sm text-gray-500">
                                            <span><i class="fas fa-folder"></i> {{ $post->category->name ?? 'Uncategorized' }}</span>
                                            <span><i class="fas fa-calendar"></i> {{ $post->created_at->format('M d, Y') }}</span>
                                            @if($post->views > 0)
                                                <span><i class="fas fa-eye"></i> {{ $post->views }} views</span>
                                            @endif
                                        </div>
                                        
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('user.posts.show', $post) }}" class="text-blue-600 hover:text-blue-800 p-2 rounded-lg hover:bg-blue-50">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('user.posts.edit', $post) }}" class="text-green-600 hover:text-green-800 p-2 rounded-lg hover:bg-green-50">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('user.posts.destroy', $post) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this post?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 p-2 rounded-lg hover:bg-red-50">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $posts->links() }}
                </div>
            </div>
        @else
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <i class="fas fa-file-alt text-gray-400 text-6xl mb-4"></i>
                <h3 class="text-xl font-medium text-gray-900 mb-2">No posts yet</h3>
                <p class="text-gray-500 mb-6">Start creating content to share with the community</p>
                <a href="{{ route('user.posts.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 inline-flex items-center space-x-2">
                    <i class="fas fa-plus"></i>
                    <span>Create Your First Post</span>
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
