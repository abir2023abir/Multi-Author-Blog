@extends('layouts.admin')

@section('content')
@if(session('status'))
<div class="mb-4 rounded-lg bg-green-100 dark:bg-green-900/50 p-4 text-green-700 dark:text-green-300">
{{ session('status') }}
</div>
@endif

<div class="flex flex-wrap justify-between gap-3 pb-8">
<div class="flex flex-col gap-3">
<h1 class="text-slate-800 dark:text-white text-4xl font-black leading-tight tracking-[-0.033em]">Google News</h1>
<p class="text-slate-500 dark:text-[#92adc9] text-base font-normal leading-normal">Submit content to Google News.</p>
</div>
<div class="flex items-center gap-4">
<span class="material-symbols-outlined text-slate-500 dark:text-white cursor-pointer">notifications</span>
<div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10 bg-gray-300 dark:bg-gray-600"></div>
</div>
</div>

<div class="rounded-lg border border-slate-200 dark:border-[#324d67] bg-white dark:bg-[#111a22] p-6">
<h3 class="text-slate-800 dark:text-white text-lg font-bold mb-4">Recent Posts for Submission</h3>
<div class="space-y-3">
@foreach($recentPosts as $post)
<div class="flex items-center justify-between py-3 border-b border-slate-200 dark:border-[#324d67]">
<div>
<p class="text-slate-800 dark:text-white font-medium">{{ $post->title }}</p>
<p class="text-sm text-slate-500 dark:text-[#92adc9]">{{ $post->published_at->format('Y-m-d') }}</p>
</div>
<form method="POST" action="{{ route('admin.google-news.submit') }}">
@csrf
<input type="hidden" name="post_id" value="{{ $post->id }}">
<button type="submit" class="text-xs font-medium text-primary hover:text-primary/80">Submit to Google News</button>
</form>
</div>
@endforeach
</div>
</div>
@endsection
