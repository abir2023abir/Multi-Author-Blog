@extends('layouts.admin')

@section('content')
@if(session('status'))
<div class="mb-4 rounded-lg bg-green-100 dark:bg-green-900/50 p-4 text-green-700 dark:text-green-300">
{{ session('status') }}
</div>
@endif

<div class="flex flex-wrap justify-between gap-3 pb-8">
<div class="flex flex-col gap-3">
<h1 class="text-slate-800 dark:text-white text-4xl font-black leading-tight tracking-[-0.033em]">Create New Page</h1>
<p class="text-slate-500 dark:text-[#92adc9] text-base font-normal leading-normal">Add a new static page to your website.</p>
</div>
<div class="flex items-center gap-4">
<a href="{{ route('admin.pages.index') }}" class="flex items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-slate-600 text-white text-sm font-bold leading-normal tracking-[0.015em]">
<span class="truncate">Back to Pages</span>
</a>
<span class="material-symbols-outlined text-slate-500 dark:text-white cursor-pointer">notifications</span>
<div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10 bg-gray-300 dark:bg-gray-600"></div>
</div>
</div>

<div class="rounded-lg border border-slate-200 dark:border-[#324d67] bg-white dark:bg-[#111a22] p-6">
<form method="POST" action="{{ route('admin.pages.store') }}">
@csrf
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
<div class="lg:col-span-2">
<div class="mb-4">
<label class="text-slate-800 dark:text-white text-sm font-medium mb-2 block">Page Title <span class="text-red-500">*</span></label>
<input type="text" name="title" value="{{ old('title') }}" class="w-full border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white @error('title') border-red-500 @enderror" placeholder="Enter page title">
@error('title')
<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
@enderror
</div>

<div class="mb-4">
<label class="text-slate-800 dark:text-white text-sm font-medium mb-2 block">Slug <span class="text-red-500">*</span></label>
<input type="text" name="slug" value="{{ old('slug') }}" class="w-full border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white @error('slug') border-red-500 @enderror" placeholder="page-url-slug">
@error('slug')
<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
@enderror
<p class="text-slate-500 dark:text-[#92adc9] text-xs mt-1">URL-friendly version of the title (e.g., "about-us")</p>
</div>

<div class="mb-4">
<label class="text-slate-800 dark:text-white text-sm font-medium mb-2 block">Content <span class="text-red-500">*</span></label>
<textarea name="content" rows="15" class="w-full border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white @error('content') border-red-500 @enderror" placeholder="Enter page content">{{ old('content') }}</textarea>
@error('content')
<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
@enderror
</div>
</div>

<div class="lg:col-span-1">
<div class="mb-4">
<label class="text-slate-800 dark:text-white text-sm font-medium mb-2 block">Meta Description</label>
<textarea name="meta_description" rows="3" class="w-full border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white @error('meta_description') border-red-500 @enderror" placeholder="Brief description for search engines">{{ old('meta_description') }}</textarea>
@error('meta_description')
<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
@enderror
<p class="text-slate-500 dark:text-[#92adc9] text-xs mt-1">Keep it under 160 characters</p>
</div>

<div class="mb-4">
<label class="text-slate-800 dark:text-white text-sm font-medium mb-2 block">Language</label>
<select name="language" class="w-full border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white @error('language') border-red-500 @enderror">
<option value="en" {{ old('language', 'en') == 'en' ? 'selected' : '' }}>English</option>
<option value="ar" {{ old('language') == 'ar' ? 'selected' : '' }}>Arabic</option>
</select>
@error('language')
<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
@enderror
</div>

<div class="mb-4">
<label class="text-slate-800 dark:text-white text-sm font-medium mb-2 block">Location</label>
<select name="location" class="w-full border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white @error('location') border-red-500 @enderror">
<option value="main_menu" {{ old('location', 'main_menu') == 'main_menu' ? 'selected' : '' }}>Main Menu</option>
<option value="footer" {{ old('location') == 'footer' ? 'selected' : '' }}>Footer</option>
<option value="top_menu" {{ old('location') == 'top_menu' ? 'selected' : '' }}>Top Menu</option>
</select>
@error('location')
<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
@enderror
</div>

<div class="mb-4">
<label class="text-slate-800 dark:text-white text-sm font-medium mb-2 block">Page Type</label>
<select name="page_type" class="w-full border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white @error('page_type') border-red-500 @enderror">
<option value="custom" {{ old('page_type', 'custom') == 'custom' ? 'selected' : '' }}>Custom</option>
<option value="default" {{ old('page_type') == 'default' ? 'selected' : '' }}>Default</option>
</select>
@error('page_type')
<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
@enderror
</div>

<div class="mb-4">
<label class="text-slate-800 dark:text-white text-sm font-medium mb-2 block">Status</label>
<select name="is_published" class="w-full border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white @error('is_published') border-red-500 @enderror">
<option value="1" {{ old('is_published', '1') == '1' ? 'selected' : '' }}>Published</option>
<option value="0" {{ old('is_published') == '0' ? 'selected' : '' }}>Draft</option>
</select>
@error('is_published')
<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
@enderror
</div>
</div>
</div>

<div class="flex gap-3 pt-6 border-t border-slate-200 dark:border-[#324d67]">
<button type="submit" class="flex items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-primary text-white text-sm font-bold leading-normal tracking-[0.015em]">
<span class="truncate">Create Page</span>
</button>
<a href="{{ route('admin.pages.index') }}" class="flex items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-slate-600 text-white text-sm font-bold leading-normal tracking-[0.015em]">
<span class="truncate">Cancel</span>
</a>
</div>
</form>
</div>

<script>
// Auto-generate slug from title
document.querySelector('input[name="title"]').addEventListener('input', function() {
    const title = this.value;
    const slug = title
        .toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .trim('-');

    document.querySelector('input[name="slug"]').value = slug;
});
</script>
@endsection
