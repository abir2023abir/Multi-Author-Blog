@extends('layouts.app')

@section('title', $user->name . ' - Author Profile')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Author Header -->
        <div class="bg-white rounded-lg shadow-sm p-8 mb-8">
            <div class="flex flex-col md:flex-row items-start md:items-center space-y-4 md:space-y-0 md:space-x-6">
                <!-- Avatar -->
                <div class="flex-shrink-0">
                    <img class="h-24 w-24 rounded-full object-cover"
                         src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}"
                         alt="{{ $user->name }}">
                </div>

                <!-- Author Info -->
                <div class="flex-1">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">{{ $user->name }}</h1>
                            <p class="text-lg text-gray-600 mt-1">{{ $user->email }}</p>
                            @if($user->bio)
                                <p class="text-gray-700 mt-2">{{ $user->bio }}</p>
                            @endif
                        </div>

                        <!-- Badge and Stats -->
                        <div class="mt-4 md:mt-0 text-center md:text-right">
                            <div class="flex items-center justify-center md:justify-end space-x-2 mb-2">
                                <span class="text-4xl">{{ $stats['badge_emoji'] }}</span>
                                <div>
                                    <div class="text-lg font-semibold text-gray-900">{{ $stats['badge_level'] }}</div>
                                    @if($stats['rank_position'])
                                        <div class="text-sm text-gray-500">Rank #{{ $stats['rank_position'] }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="text-2xl font-bold text-blue-600">{{ number_format($stats['total_posts'] ?? 0) }} Posts</div>
                        </div>
                    </div>

                    <!-- Social Links -->
                    @if($user->social_links && count($user->social_links) > 0)
                        <div class="mt-4 flex flex-wrap gap-4">
                            @foreach($user->social_links as $platform => $link)
                                <a href="{{ $link }}"
                                   target="_blank"
                                   class="text-blue-600 hover:text-blue-800 transition-colors">
                                    {{ ucfirst($platform) }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-sm p-6 text-center">
                <div class="text-3xl font-bold text-blue-600">{{ number_format($stats['total_views'] ?? 0) }}</div>
                <div class="text-sm text-gray-500 mt-1">Total Views</div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6 text-center">
                <div class="text-3xl font-bold text-green-600">{{ number_format($stats['total_comments'] ?? 0) }}</div>
                <div class="text-sm text-gray-500 mt-1">Comments Received</div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6 text-center">
                <div class="text-3xl font-bold text-purple-600">{{ number_format($stats['total_reactions'] ?? 0) }}</div>
                <div class="text-sm text-gray-500 mt-1">Total Reactions</div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6 text-center">
                <div class="text-3xl font-bold text-yellow-600">{{ number_format($stats['average_rating'] ?? 0, 1) }}</div>
                <div class="text-sm text-gray-500 mt-1">Average Rating</div>
            </div>
        </div>

        <!-- Progress to Next Badge -->
        @if(isset($progress['next_badge']) && $progress['next_badge'])
            <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Progress to Next Badge</h3>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2">
                        <span class="text-2xl">{{ $stats['badge_emoji'] }}</span>
                        <span class="text-sm text-gray-600">{{ $stats['badge_level'] }}</span>
                    </div>

                    <div class="flex-1">
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-gradient-to-r from-blue-500 to-purple-600 h-3 rounded-full transition-all duration-500"
                                 style="width: {{ $progress['progress_percentage'] }}%"></div>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600 mt-2">
                            <span>{{ number_format($progress['current_points']) }} points</span>
                            <span>{{ number_format($progress['next_badge_points']) }} points needed</span>
                        </div>
                    </div>

                    <div class="flex items-center space-x-2">
                        <span class="text-2xl">{{ $progress['next_badge']->emoji }}</span>
                        <span class="text-sm text-gray-600">{{ $progress['next_badge']->name }}</span>
                    </div>
                </div>

                @if($progress['points_needed'] > 0)
                    <div class="mt-4 text-center">
                        <span class="text-sm text-gray-500">
                            {{ $progress['points_needed'] }} more points needed for next badge
                        </span>
                    </div>
                @endif
            </div>
        @endif

        <!-- Recent Posts -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Recent Posts</h3>

            @if($recentPosts->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($recentPosts as $post)
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                            <h4 class="font-semibold text-gray-900 mb-2 line-clamp-2">
                                <a href="{{ route('posts.show', $post) }}" class="hover:text-blue-600 transition-colors">
                                    {{ $post->title }}
                                </a>
                            </h4>

                            <p class="text-sm text-gray-600 mb-3 line-clamp-3">
                                {{ Str::limit(strip_tags($post->content), 120) }}
                            </p>

                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <span>{{ $post->view_count }} views</span>
                                <span>{{ $post->published_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <div class="text-4xl mb-4">📝</div>
                    <p>No posts published yet.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
