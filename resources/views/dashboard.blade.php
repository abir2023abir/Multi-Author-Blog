@extends('layouts.admin')

@section('content')
<!-- Success Messages -->
@if(session('status'))
<div class="mb-4 rounded-lg bg-green-100 dark:bg-green-900/50 p-4 text-green-700 dark:text-green-300">
{{ session('status') }}
</div>
@endif

<div class="flex flex-wrap justify-between gap-3 pb-8">
<div class="flex flex-col gap-3">
<h1 class="text-slate-800 dark:text-white text-4xl font-black leading-tight tracking-[-0.033em]">Welcome, Admin!</h1>
<p class="text-slate-500 dark:text-[#92adc9] text-base font-normal leading-normal">Here's a summary of your blog's activity.</p>
</div>
<div class="flex items-center gap-4">
<a href="{{ route('home') }}" class="flex items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-green-600 text-white text-sm font-bold leading-normal tracking-[0.015em]">
<span class="truncate">View Site</span>
</a>
<span class="material-symbols-outlined text-slate-500 dark:text-white cursor-pointer">notifications</span>
<div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10 bg-gray-300 dark:bg-gray-600"></div>
</div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
<div class="rounded-lg p-6 bg-teal-600 text-white">
<div class="flex items-center justify-between">
<div>
<p class="text-3xl font-bold">{{ $stats['total_posts'] }}</p>
<p class="text-sm mt-1">Posts</p>
</div>
<span class="material-symbols-outlined text-5xl opacity-30">description</span>
</div>
</div>
<div class="rounded-lg p-6 bg-red-500 text-white">
<div class="flex items-center justify-between">
<div>
<p class="text-3xl font-bold">{{ $stats['pending_posts'] }}</p>
<p class="text-sm mt-1">Pending Posts</p>
</div>
<span class="material-symbols-outlined text-5xl opacity-30">pending</span>
</div>
</div>
<div class="rounded-lg p-6 bg-indigo-600 text-white">
<div class="flex items-center justify-between">
<div>
<p class="text-3xl font-bold">{{ $stats['draft_posts'] }}</p>
<p class="text-sm mt-1">Drafts</p>
</div>
<span class="material-symbols-outlined text-5xl opacity-30">draft</span>
</div>
</div>
<div class="rounded-lg p-6 bg-yellow-500 text-white">
<div class="flex items-center justify-between">
<div>
<p class="text-3xl font-bold">0</p>
<p class="text-sm mt-1">Scheduled Posts</p>
</div>
<span class="material-symbols-outlined text-5xl opacity-30">schedule</span>
</div>
</div>
</div>
<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
<!-- Pending Comments -->
<div class="rounded-lg border border-slate-200 dark:border-[#324d67] bg-white dark:bg-[#111a22]">
<div class="px-4 py-3 border-b border-slate-200 dark:border-[#324d67] flex justify-between items-center">
<div>
<h3 class="text-slate-800 dark:text-white text-lg font-bold">Pending Comments</h3>
<p class="text-xs text-slate-500 dark:text-[#92adc9]">Recently added unapproved comments</p>
</div>
<div class="flex gap-2">
<button class="text-slate-500 dark:text-white hover:text-slate-700"><span class="material-symbols-outlined text-sm">minimize</span></button>
<button class="text-slate-500 dark:text-white hover:text-slate-700"><span class="material-symbols-outlined text-sm">close</span></button>
</div>
</div>
<div class="overflow-x-auto">
<table class="w-full">
<thead class="bg-slate-50 dark:bg-[#192633]">
<tr>
<th class="px-4 py-2 text-left text-xs font-medium text-slate-600 dark:text-white">Id</th>
<th class="px-4 py-2 text-left text-xs font-medium text-slate-600 dark:text-white">Name</th>
<th class="px-4 py-2 text-left text-xs font-medium text-slate-600 dark:text-white">Comment</th>
<th class="px-4 py-2 text-left text-xs font-medium text-slate-600 dark:text-white">Date</th>
</tr>
</thead>
<tbody>
@forelse($pendingComments as $comment)
<tr class="border-t border-slate-200 dark:border-[#324d67]">
<td class="px-4 py-2 text-xs text-slate-800 dark:text-white">{{ $comment->id }}</td>
<td class="px-4 py-2 text-xs text-slate-800 dark:text-white">{{ optional($comment->user)->name ?? 'Guest' }}</td>
<td class="px-4 py-2 text-xs text-slate-500 dark:text-[#92adc9]">{{ Str::limit($comment->content, 40) }}</td>
<td class="px-4 py-2 text-xs text-slate-500 dark:text-[#92adc9]">{{ $comment->created_at->format('Y-m-d / H:i') }}</td>
</tr>
@empty
<tr>
<td colspan="4" class="px-4 py-4 text-center text-sm text-slate-500 dark:text-[#92adc9]">No pending comments</td>
</tr>
@endforelse
</tbody>
</table>
<div class="p-3 border-t border-slate-200 dark:border-[#324d67] text-right">
<a href="{{ route('admin.comments.index') }}" class="text-xs text-primary hover:underline">View All</a>
</div>
</div>
</div>

<!-- Latest Contact Messages -->
<div class="rounded-lg border border-slate-200 dark:border-[#324d67] bg-white dark:bg-[#111a22]">
<div class="px-4 py-3 border-b border-slate-200 dark:border-[#324d67] flex justify-between items-center">
<div>
<h3 class="text-slate-800 dark:text-white text-lg font-bold">Latest Contact Messages</h3>
<p class="text-xs text-slate-500 dark:text-[#92adc9]">Recently added contact messages</p>
</div>
<div class="flex gap-2">
<button class="text-slate-500 dark:text-white hover:text-slate-700"><span class="material-symbols-outlined text-sm">minimize</span></button>
<button class="text-slate-500 dark:text-white hover:text-slate-700"><span class="material-symbols-outlined text-sm">close</span></button>
</div>
</div>
<div class="overflow-x-auto">
<table class="w-full">
<thead class="bg-slate-50 dark:bg-[#192633]">
<tr>
<th class="px-4 py-2 text-left text-xs font-medium text-slate-600 dark:text-white">Id</th>
<th class="px-4 py-2 text-left text-xs font-medium text-slate-600 dark:text-white">Name</th>
<th class="px-4 py-2 text-left text-xs font-medium text-slate-600 dark:text-white">Message</th>
<th class="px-4 py-2 text-left text-xs font-medium text-slate-600 dark:text-white">Date</th>
</tr>
</thead>
<tbody>
<tr class="border-t border-slate-200 dark:border-[#324d67]">
<td colspan="4" class="px-4 py-4 text-center text-sm text-slate-500 dark:text-[#92adc9]">No contact messages</td>
</tr>
</tbody>
</table>
<div class="p-3 border-t border-slate-200 dark:border-[#324d67] text-right">
<a href="#" class="text-xs text-primary hover:underline">View All</a>
</div>
</div>
</div>
</div>

<!-- Latest Users Widget -->
<div class="rounded-lg border border-slate-200 dark:border-[#324d67] bg-white dark:bg-[#111a22] mb-6">
<div class="px-4 py-3 border-b border-slate-200 dark:border-[#324d67] flex justify-between items-center">
<div>
<h3 class="text-slate-800 dark:text-white text-lg font-bold">Latest Users</h3>
<p class="text-xs text-slate-500 dark:text-[#92adc9]">Recently registered users</p>
</div>
<div class="flex gap-2">
<button class="text-slate-500 dark:text-white hover:text-slate-700"><span class="material-symbols-outlined text-sm">minimize</span></button>
<button class="text-slate-500 dark:text-white hover:text-slate-700"><span class="material-symbols-outlined text-sm">close</span></button>
</div>
</div>
<div class="p-4">
<div class="flex gap-4 overflow-x-auto">
@foreach($latestUsers as $latestUser)
<div class="flex flex-col items-center gap-2 min-w-[100px]">
<div class="bg-gray-300 dark:bg-gray-600 rounded-full size-16"></div>
<div class="text-center">
<p class="text-sm font-medium text-slate-800 dark:text-white">{{ $latestUser->name }}</p>
<p class="text-xs text-slate-500 dark:text-[#92adc9]">{{ $latestUser->created_at->diffForHumans() }}</p>
</div>
</div>
@endforeach
</div>
</div>
</div>

<div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
<div class="lg:col-span-2">
<h2 class="text-slate-800 dark:text-white text-[22px] font-bold leading-tight tracking-[-0.015em] pb-3 pt-5">Recent Posts</h2>
<div class="@container">
<div class="overflow-hidden rounded-lg border border-slate-200 dark:border-[#324d67] bg-white dark:bg-[#111a22]">
<table class="w-full">
<thead>
<tr class="bg-slate-50 dark:bg-[#192633]">
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium leading-normal">Post Title</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium leading-normal">Author</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium leading-normal">Date Published</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium leading-normal">Status</th>
</tr>
</thead>
<tbody>
@foreach($recentPosts as $post)
<tr class="border-t border-t-slate-200 dark:border-t-[#324d67]">
<td class="h-[72px] px-4 py-2 text-slate-800 dark:text-white text-sm font-normal leading-normal">{{ Str::limit($post->title, 30) }}</td>
<td class="h-[72px] px-4 py-2 text-slate-500 dark:text-[#92adc9] text-sm font-normal leading-normal">{{ $post->user->name }}</td>
<td class="h-[72px] px-4 py-2 text-slate-500 dark:text-[#92adc9] text-sm font-normal leading-normal">{{ optional($post->published_at ?? $post->created_at)->format('Y-m-d') }}</td>
<td class="h-[72px] px-4 py-2 text-sm font-normal leading-normal">
<span class="inline-flex items-center justify-center rounded-full {{ $post->status === 'published' ? 'bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-300' : 'bg-yellow-100 dark:bg-yellow-900/50 text-yellow-800 dark:text-yellow-300' }} px-2.5 py-0.5 text-xs font-medium">{{ ucfirst($post->status) }}</span>
</td>
</tr>
@endforeach
</tbody>
</table>
<div class="p-4 border-t border-slate-200 dark:border-t-[#324d67]">
<a class="text-sm font-medium text-primary hover:underline" href="{{ route('admin.posts.index') }}">View All Posts</a>
</div>
</div>
</div>
</div>
<div class="lg:col-span-1">
<h2 class="text-slate-800 dark:text-white text-[22px] font-bold leading-tight tracking-[-0.015em] pb-3 pt-5">Recent Comments</h2>
<div class="space-y-4">
@foreach($recentComments as $comment)
<div class="rounded-lg border border-slate-200 dark:border-[#324d67] bg-white dark:bg-[#111a22] p-4">
<div class="flex items-start gap-3">
<div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-8 bg-gray-300 dark:bg-gray-600"></div>
<div class="flex-1">
<p class="text-sm font-medium text-slate-800 dark:text-white">{{ optional($comment->user)->name ?? 'Guest' }} on <a class="text-primary hover:underline" href="{{ route('posts.show', $comment->post) }}">{{ Str::limit($comment->post->title, 20) }}</a></p>
<p class="text-sm text-slate-500 dark:text-[#92adc9] mt-1">"{{ Str::limit($comment->content, 60) }}"</p>
<div class="mt-2 flex gap-2">
<button class="text-xs font-medium text-green-600 hover:text-green-500">Approve</button>
<button class="text-xs font-medium text-primary hover:text-primary/80">Reply</button>
<button class="text-xs font-medium text-red-600 hover:text-red-500">Spam</button>
</div>
</div>
</div>
</div>
@endforeach
</div>
<h2 class="text-slate-800 dark:text-white text-[22px] font-bold leading-tight tracking-[-0.015em] pb-3 pt-8">Top Authors</h2>
<div class="rounded-lg border border-slate-200 dark:border-[#324d67] bg-white dark:bg-[#111a22] p-4">
<div class="space-y-4">
@php
    $maxPosts = $topAuthors->max('posts_count') ?: 1;
    $colors = ['bg-primary', 'bg-[#F5A623]', 'bg-[#50E3C2]'];
@endphp
@foreach($topAuthors as $index => $author)
<div>
<div class="flex justify-between mb-1">
<span class="text-base font-medium text-slate-800 dark:text-white">{{ $author->name }}</span>
<span class="text-sm font-medium text-slate-500 dark:text-[#92adc9]">{{ $author->posts_count }} posts</span>
</div>
<div class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-2.5">
<div class="{{ $colors[$index] ?? 'bg-primary' }} h-2.5 rounded-full" style="width: {{ ($author->posts_count / $maxPosts) * 100 }}%"></div>
</div>
</div>
@endforeach
</div>
            </div>
        </div>
    </div>
@endsection
