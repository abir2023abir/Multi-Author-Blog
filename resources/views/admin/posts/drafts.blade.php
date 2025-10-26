@extends('layouts.admin')

@section('content')
<!-- Top Header Bar -->
<div class="flex items-center justify-between mb-6">
<div class="flex items-center gap-4">
<span class="material-symbols-outlined text-slate-500 dark:text-white cursor-pointer text-2xl">menu</span>
</div>
<div class="flex items-center gap-4">
<a href="{{ route('home') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium">View Site</a>
<select class="border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white text-sm">
<option>English</option>
<option>Arabic</option>
</select>
<div class="w-8 h-8 bg-gray-300 dark:bg-gray-600 rounded-full"></div>
<select class="border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white text-sm">
<option>admin</option>
</select>
</div>
</div>

<!-- Page Header -->
<div class="flex items-center justify-between mb-6">
<h1 class="text-slate-800 dark:text-white text-3xl font-bold">Draft Posts</h1>
<a href="{{ route('admin.posts.index') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium">All Posts</a>
</div>

<!-- Posts Table -->
<div class="rounded-lg border border-slate-200 dark:border-[#324d67] bg-white dark:bg-[#111a22] overflow-hidden">
<table class="w-full">
<thead>
<tr class="bg-slate-50 dark:bg-[#192633]">
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">ID</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">Title</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">Author</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">Category</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">Last Modified</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">Status</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">Actions</th>
</tr>
</thead>
<tbody>
@forelse($posts as $post)
<tr class="border-t border-slate-200 dark:border-[#324d67] hover:bg-slate-50 dark:hover:bg-[#192633]">
<td class="px-4 py-3 text-slate-600 dark:text-white text-sm">{{ $post->id }}</td>
<td class="px-4 py-3">
<div class="flex items-center gap-3">
<div class="w-10 h-10 bg-gray-200 dark:bg-gray-700 rounded"></div>
<div>
<p class="text-slate-800 dark:text-white text-sm font-medium">{{ Str::limit($post->title, 50) }}</p>
<p class="text-slate-500 dark:text-[#92adc9] text-xs">{{ $post->created_at->format('M d, Y') }}</p>
</div>
</div>
</td>
<td class="px-4 py-3 text-slate-600 dark:text-white text-sm">{{ $post->user->name }}</td>
<td class="px-4 py-3 text-slate-600 dark:text-white text-sm">{{ $post->category->name ?? 'Uncategorized' }}</td>
<td class="px-4 py-3 text-slate-600 dark:text-white text-sm">{{ $post->updated_at->format('M d, Y H:i') }}</td>
<td class="px-4 py-3">
<span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300">
Draft
</span>
</td>
<td class="px-4 py-3">
<div class="flex items-center gap-2">
<a href="#" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-sm">View</a>
<a href="#" class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 text-sm">Edit</a>
<form method="POST" action="{{ route('admin.posts.destroy', $post) }}" class="inline">
@csrf
@method('DELETE')
<button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 text-sm" onclick="return confirm('Are you sure?')">Delete</button>
</form>
</div>
</td>
</tr>
@empty
<tr>
<td colspan="7" class="px-4 py-8 text-center text-slate-500 dark:text-[#92adc9]">No draft posts found.</td>
</tr>
@endforelse
</tbody>
</table>
</div>

<!-- Pagination -->
@if($posts->hasPages())
<div class="mt-6">
{{ $posts->links() }}
</div>
@endif
@endsection
