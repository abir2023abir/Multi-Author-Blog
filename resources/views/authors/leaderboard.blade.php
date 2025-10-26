@extends('layouts.app')

@section('title', 'Top Authors Leaderboard')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">🏆 Top Authors Leaderboard</h1>
            <p class="text-xl text-gray-600">Discover the most influential authors in our community</p>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <form method="GET" class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-64">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search Authors</label>
                    <input type="text" 
                           id="search" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Search by name or email..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <div class="min-w-48">
                    <label for="badge" class="block text-sm font-medium text-gray-700 mb-2">Filter by Badge</label>
                    <select id="badge" 
                            name="badge" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">All Badges</option>
                        @foreach($badges as $badge)
                            <option value="{{ $badge->id }}" {{ request('badge') == $badge->id ? 'selected' : '' }}>
                                {{ $badge->emoji }} {{ $badge->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Filter
                </button>
                
                <a href="{{ route('authors.leaderboard') }}" 
                   class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                    Clear
                </a>
            </form>
        </div>

        <!-- Leaderboard -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rank</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Badge</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Points</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Posts</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Views</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Comments</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reactions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($rankings as $ranking)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if($ranking->rank_position <= 3)
                                            <span class="text-2xl">
                                                @if($ranking->rank_position == 1) 🥇
                                                @elseif($ranking->rank_position == 2) 🥈
                                                @else 🥉
                                                @endif
                                            </span>
                                        @else
                                            <span class="text-lg font-semibold text-gray-600">#{{ $ranking->rank_position }}</span>
                                        @endif
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-12">
                                            <img class="h-12 w-12 rounded-full object-cover" 
                                                 src="{{ $ranking->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($ranking->user->name) }}" 
                                                 alt="{{ $ranking->user->name }}">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                <a href="{{ route('authors.profile', $ranking->user) }}" 
                                                   class="hover:text-blue-600 transition-colors">
                                                    {{ $ranking->user->name }}
                                                </a>
                                            </div>
                                            <div class="text-sm text-gray-500">{{ $ranking->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="text-2xl mr-2">{{ $ranking->badge->emoji ?? '🏆' }}</span>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $ranking->badge->name ?? 'No Badge' }}</div>
                                            <div class="text-xs text-gray-500">{{ $ranking->badge->level_name ?? '' }}</div>
                                        </div>
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-gray-900">{{ number_format($ranking->total_points) }}</div>
                                    <div class="text-xs text-gray-500">
                                        +{{ $ranking->post_points }} posts
                                        +{{ $ranking->comment_points }} comments
                                        +{{ $ranking->view_points }} views
                                        +{{ $ranking->reaction_points }} reactions
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ number_format($ranking->posts_count) }}
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ number_format($ranking->total_views) }}
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ number_format($ranking->comments_count) }}
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ number_format($ranking->total_reactions) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                    <div class="text-4xl mb-4">🔍</div>
                                    <p class="text-lg">No authors found matching your criteria.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($rankings->hasPages())
            <div class="mt-8">
                {{ $rankings->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
