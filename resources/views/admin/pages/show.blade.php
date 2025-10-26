@extends('layouts.admin')

@section('content')
<div class="flex flex-wrap justify-between gap-3 pb-8">
<div class="flex flex-col gap-3">
<h1 class="text-slate-800 dark:text-white text-4xl font-black leading-tight tracking-[-0.033em]">{{ $page->title }}</h1>
<p class="text-slate-500 dark:text-[#92adc9] text-base font-normal leading-normal">Page preview and details.</p>
</div>
<div class="flex items-center gap-4">
<a href="{{ route('admin.pages.edit', $page) }}" class="flex items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-primary text-white text-sm font-bold leading-normal tracking-[0.015em]">
<span class="truncate">Edit Page</span>
</a>
<a href="{{ route('admin.pages.index') }}" class="flex items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-slate-600 text-white text-sm font-bold leading-normal tracking-[0.015em]">
<span class="truncate">Back to Pages</span>
</a>
<span class="material-symbols-outlined text-slate-500 dark:text-white cursor-pointer">notifications</span>
<div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10 bg-gray-300 dark:bg-gray-600"></div>
</div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
<div class="lg:col-span-2">
<div class="rounded-lg border border-slate-200 dark:border-[#324d67] bg-white dark:bg-[#111a22] p-6">
<h2 class="text-slate-800 dark:text-white text-xl font-bold mb-4">Page Content</h2>
<div class="prose prose-slate dark:prose-invert max-w-none">
{!! nl2br(e($page->content)) !!}
</div>
</div>
</div>

<div class="lg:col-span-1">
<div class="rounded-lg border border-slate-200 dark:border-[#324d67] bg-white dark:bg-[#111a22] p-6">
<h3 class="text-slate-800 dark:text-white text-lg font-bold mb-4">Page Details</h3>

<div class="space-y-4">
<div>
<label class="text-slate-600 dark:text-[#92adc9] text-sm font-medium">Status</label>
<div class="mt-1">
<span class="inline-flex items-center justify-center rounded-full {{ $page->is_published ? 'bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-300' : 'bg-yellow-100 dark:bg-yellow-900/50 text-yellow-800 dark:text-yellow-300' }} px-2.5 py-0.5 text-xs font-medium">
{{ $page->is_published ? 'Published' : 'Draft' }}
</span>
</div>
</div>

<div>
<label class="text-slate-600 dark:text-[#92adc9] text-sm font-medium">Slug</label>
<div class="mt-1 text-slate-800 dark:text-white text-sm">{{ $page->slug }}</div>
</div>

@if($page->meta_description)
<div>
<label class="text-slate-600 dark:text-[#92adc9] text-sm font-medium">Meta Description</label>
<div class="mt-1 text-slate-800 dark:text-white text-sm">{{ $page->meta_description }}</div>
</div>
@endif

<div>
<label class="text-slate-600 dark:text-[#92adc9] text-sm font-medium">Created</label>
<div class="mt-1 text-slate-800 dark:text-white text-sm">{{ $page->created_at->format('M d, Y \a\t g:i A') }}</div>
</div>

<div>
<label class="text-slate-600 dark:text-[#92adc9] text-sm font-medium">Last Updated</label>
<div class="mt-1 text-slate-800 dark:text-white text-sm">{{ $page->updated_at->format('M d, Y \a\t g:i A') }}</div>
</div>
</div>

<div class="mt-6 pt-6 border-t border-slate-200 dark:border-[#324d67]">
<div class="flex gap-2">
<a href="{{ route('admin.pages.edit', $page) }}" class="flex-1 flex items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-primary text-white text-sm font-bold leading-normal tracking-[0.015em]">
<span class="truncate">Edit Page</span>
</a>
<form method="POST" action="{{ route('admin.pages.destroy', $page) }}" class="flex-1">
@csrf
@method('DELETE')
<button type="submit" class="w-full flex items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-red-600 text-white text-sm font-bold leading-normal tracking-[0.015em]" onclick="return confirm('Are you sure you want to delete this page? This action cannot be undone.')">
<span class="truncate">Delete</span>
</button>
</form>
</div>
</div>
</div>
</div>
@endsection
