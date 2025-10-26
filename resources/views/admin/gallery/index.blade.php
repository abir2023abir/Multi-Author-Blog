@extends('layouts.admin')

@section('content')
@if(session('status'))
<div class="mb-4 rounded-lg bg-green-100 dark:bg-green-900/50 p-4 text-green-700 dark:text-green-300">
{{ session('status') }}
</div>
@endif

<div class="flex flex-wrap justify-between gap-3 pb-8">
<div class="flex flex-col gap-3">
<h1 class="text-slate-800 dark:text-white text-4xl font-black leading-tight tracking-[-0.033em]">Gallery</h1>
<p class="text-slate-500 dark:text-[#92adc9] text-base font-normal leading-normal">Manage your media gallery.</p>
</div>
<div class="flex items-center gap-4">
<a href="{{ route('admin.gallery.create') }}" class="flex items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-primary text-white text-sm font-bold leading-normal tracking-[0.015em]">
<span class="truncate">Upload Image</span>
</a>
<span class="material-symbols-outlined text-slate-500 dark:text-white cursor-pointer">notifications</span>
<div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10 bg-gray-300 dark:bg-gray-600"></div>
</div>
</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-4">
@forelse($galleries as $item)
<div class="rounded-lg border border-slate-200 dark:border-[#324d67] bg-white dark:bg-[#111a22] p-4">
<div class="aspect-square bg-gray-200 dark:bg-gray-700 rounded mb-2"></div>
<h3 class="text-slate-800 dark:text-white text-sm font-medium">{{ $item->title }}</h3>
<div class="flex gap-2 mt-2">
<a href="{{ route('admin.gallery.edit', $item) }}" class="text-xs font-medium text-primary hover:text-primary/80">Edit</a>
<form method="POST" action="{{ route('admin.gallery.destroy', $item) }}" class="inline">
@csrf
@method('DELETE')
<button type="submit" class="text-xs font-medium text-red-600 hover:text-red-500" onclick="return confirm('Are you sure?')">Delete</button>
</form>
</div>
</div>
@empty
<div class="col-span-4 px-4 py-8 text-center text-slate-500 dark:text-[#92adc9]">No images found.</div>
@endforelse
</div>

@if($galleries->hasPages())
<div class="mt-4">{{ $galleries->links() }}</div>
@endif
@endsection
