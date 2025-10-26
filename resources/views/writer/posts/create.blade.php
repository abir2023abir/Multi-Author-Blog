@extends('layouts.admin')

@section('content')
@if(session('status'))
<div class="mb-4 rounded-lg bg-green-100 dark:bg-green-900/50 p-4 text-green-700 dark:text-green-300">
{{ session('status') }}
</div>
@endif

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
<h1 class="text-slate-800 dark:text-white text-3xl font-bold">Create New Post</h1>
<a href="{{ route('writer.posts.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium">Choose Format</a>
</div>

<!-- Post Creation Form -->
<div class="rounded-lg border border-slate-200 dark:border-[#324d67] bg-white dark:bg-[#111a22] p-6">
<form method="POST" action="{{ route('writer.posts.store') }}">
@csrf
<input type="hidden" name="post_format" value="{{ $format ?? 'article' }}">

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
<div class="lg:col-span-2">
<div class="mb-4">
<label class="text-slate-800 dark:text-white text-sm font-medium mb-2 block">Post Title <span class="text-red-500">*</span></label>
<input type="text" name="title" value="{{ old('title') }}" class="w-full border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white @error('title') border-red-500 @enderror" placeholder="Enter post title">
@error('title')
<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
@enderror
</div>

<div class="mb-4">
<label class="text-slate-800 dark:text-white text-sm font-medium mb-2 block">Content <span class="text-red-500">*</span></label>
@if($format === 'gallery')
<textarea name="content" rows="8" class="w-full border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white @error('content') border-red-500 @enderror" placeholder="Describe your gallery or add image URLs (one per line)">{{ old('content') }}</textarea>
@elseif($format === 'video')
<textarea name="content" rows="8" class="w-full border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white @error('content') border-red-500 @enderror" placeholder="Describe your video or add video URLs">{{ old('content') }}</textarea>
@elseif($format === 'audio')
<textarea name="content" rows="8" class="w-full border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white @error('content') border-red-500 @enderror" placeholder="Describe your audio content or add audio URLs">{{ old('content') }}</textarea>
@elseif($format === 'sorted_list')
<textarea name="content" rows="8" class="w-full border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white @error('content') border-red-500 @enderror" placeholder="Create your numbered list (one item per line)">{{ old('content') }}</textarea>
@elseif($format === 'recipe')
<textarea name="content" rows="8" class="w-full border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white @error('content') border-red-500 @enderror" placeholder="Ingredients and cooking directions">{{ old('content') }}</textarea>
@elseif($format === 'poll')
<textarea name="content" rows="8" class="w-full border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white @error('content') border-red-500 @enderror" placeholder="Poll question and options (one per line)">{{ old('content') }}</textarea>
@elseif($format === 'trivia_quiz' || $format === 'personality_quiz')
<textarea name="content" rows="8" class="w-full border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white @error('content') border-red-500 @enderror" placeholder="Quiz questions and answers">{{ old('content') }}</textarea>
@else
<textarea name="content" rows="12" class="w-full border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white @error('content') border-red-500 @enderror" placeholder="Write your article content">{{ old('content') }}</textarea>
@endif
@error('content')
<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
@enderror
</div>
</div>

<div class="lg:col-span-1">
<div class="mb-4">
<label class="text-slate-800 dark:text-white text-sm font-medium mb-2 block">Category</label>
<select name="category_id" class="w-full border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white @error('category_id') border-red-500 @enderror">
<option value="">Select Category</option>
@foreach($categories as $category)
<option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
@endforeach
</select>
@error('category_id')
<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
@enderror
</div>

<div class="mb-4">
<label class="text-slate-800 dark:text-white text-sm font-medium mb-2 block">Meta Description</label>
<textarea name="meta_description" rows="3" class="w-full border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white @error('meta_description') border-red-500 @enderror" placeholder="Brief description for search engines">{{ old('meta_description') }}</textarea>
@error('meta_description')
<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
@enderror
<p class="text-slate-500 dark:text-[#92adc9] text-xs mt-1">Keep it under 160 characters</p>
</div>

<div class="mb-4">
<label class="text-slate-800 dark:text-white text-sm font-medium mb-2 block">Featured Image URL</label>
<input type="url" name="featured_image" value="{{ old('featured_image') }}" class="w-full border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white @error('featured_image') border-red-500 @enderror" placeholder="https://example.com/image.jpg">
@error('featured_image')
<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
@enderror
</div>

<div class="bg-slate-50 dark:bg-[#192633] rounded-lg p-4">
<h3 class="text-slate-800 dark:text-white text-sm font-medium mb-2">Post Format</h3>
<p class="text-slate-500 dark:text-[#92adc9] text-xs mb-2">Format: {{ ucwords(str_replace('_', ' ', $format ?? 'article')) }}</p>
<p class="text-slate-500 dark:text-[#92adc9] text-xs">Posts are automatically published and submitted for approval.</p>
</div>
</div>
</div>

<div class="flex gap-3 pt-6 border-t border-slate-200 dark:border-[#324d67]">
<button type="submit" class="flex items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-primary text-white text-sm font-bold leading-normal tracking-[0.015em]">
<span class="truncate">Create Post</span>
</button>
<a href="{{ route('writer.posts.create') }}" class="flex items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-slate-600 text-white text-sm font-bold leading-normal tracking-[0.015em]">
<span class="truncate">Back to Format Selection</span>
</a>
</div>
</form>
</div>
@endsection