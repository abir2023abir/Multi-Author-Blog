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
<h1 class="text-slate-800 dark:text-white text-3xl font-bold">Pages</h1>
<a href="{{ route('admin.pages.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium">+ Add Page</a>
</div>

<!-- Filtering and Search Controls -->
<div class="flex items-center justify-between mb-6">
<div class="flex items-center gap-4">
<div class="flex items-center gap-2">
<label class="text-slate-600 dark:text-[#92adc9] text-sm font-medium">Show</label>
<select name="per_page" onchange="this.form.submit()" class="border border-slate-300 dark:border-[#324d67] rounded px-3 py-1 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white text-sm">
<option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10</option>
<option value="15" {{ request('per_page') == '15' || !request('per_page') ? 'selected' : '' }}>15</option>
<option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>25</option>
<option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50</option>
<option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100</option>
</select>
</div>
<div class="flex items-center gap-2">
<label class="text-slate-600 dark:text-[#92adc9] text-sm font-medium">Language</label>
<select name="language" onchange="this.form.submit()" class="border border-slate-300 dark:border-[#324d67] rounded px-3 py-1 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white text-sm">
<option value="all" {{ request('language') == 'all' || !request('language') ? 'selected' : '' }}>All</option>
@foreach($languages as $key => $label)
@if($key !== 'all')
<option value="{{ $key }}" {{ request('language') == $key ? 'selected' : '' }}>{{ $label }}</option>
@endif
@endforeach
</select>
</div>
</div>
<div class="flex items-center gap-2">
<label class="text-slate-600 dark:text-[#92adc9] text-sm font-medium">Search</label>
<input type="text" name="search" value="{{ request('search') }}" placeholder="Search pages..." class="border border-slate-300 dark:border-[#324d67] rounded px-3 py-1 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white text-sm w-64">
</div>
</div>

<!-- Pages Table -->
<form method="GET" id="filterForm">
<input type="hidden" name="sort" value="{{ request('sort', 'id') }}">
<input type="hidden" name="direction" value="{{ request('direction', 'desc') }}">
<input type="hidden" name="per_page" value="{{ request('per_page', 15) }}">
<input type="hidden" name="language" value="{{ request('language', 'all') }}">
<input type="hidden" name="search" value="{{ request('search') }}">
</form>

<div class="bg-white dark:bg-[#111a22] rounded-lg border border-slate-200 dark:border-[#324d67] overflow-hidden">
<table class="w-full">
<thead class="bg-slate-50 dark:bg-[#192633]">
<tr>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">
<a href="{{ request()->fullUrlWithQuery(['sort' => 'id', 'direction' => request('sort') == 'id' && request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="flex items-center gap-1 hover:text-primary">
Id
<span class="material-symbols-outlined text-xs">unfold_more</span>
</a>
</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">
<a href="{{ request()->fullUrlWithQuery(['sort' => 'title', 'direction' => request('sort') == 'title' && request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="flex items-center gap-1 hover:text-primary">
Title
<span class="material-symbols-outlined text-xs">unfold_more</span>
</a>
</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">
<a href="{{ request()->fullUrlWithQuery(['sort' => 'language', 'direction' => request('sort') == 'language' && request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="flex items-center gap-1 hover:text-primary">
Language
<span class="material-symbols-outlined text-xs">unfold_more</span>
</a>
</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">
<a href="{{ request()->fullUrlWithQuery(['sort' => 'location', 'direction' => request('sort') == 'location' && request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="flex items-center gap-1 hover:text-primary">
Location
<span class="material-symbols-outlined text-xs">unfold_more</span>
</a>
</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">
<a href="{{ request()->fullUrlWithQuery(['sort' => 'is_published', 'direction' => request('sort') == 'is_published' && request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="flex items-center gap-1 hover:text-primary">
Visibility
<span class="material-symbols-outlined text-xs">unfold_more</span>
</a>
</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">
Page Type
</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">
<a href="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'direction' => request('sort') == 'created_at' && request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="flex items-center gap-1 hover:text-primary">
Date Added
<span class="material-symbols-outlined text-xs">unfold_more</span>
</a>
</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">Options</th>
</tr>
</thead>
<tbody>
@forelse($pages as $page)
<tr class="border-t border-slate-200 dark:border-[#324d67] hover:bg-slate-50 dark:hover:bg-[#192633]">
<td class="px-4 py-3 text-slate-800 dark:text-white text-sm">{{ $page->id }}</td>
<td class="px-4 py-3 text-slate-800 dark:text-white text-sm font-medium">{{ $page->title ?: 'Page No Title' }}</td>
<td class="px-4 py-3 text-slate-800 dark:text-white text-sm">{{ ucfirst($page->language ?? 'en') }}</td>
<td class="px-4 py-3 text-slate-800 dark:text-white text-sm">{{ ucfirst(str_replace('_', ' ', $page->location ?? 'main_menu')) }}</td>
<td class="px-4 py-3 text-slate-800 dark:text-white text-sm">
@if($page->is_published)
<span class="material-symbols-outlined text-green-600 text-lg">visibility</span>
@else
<span class="material-symbols-outlined text-gray-400 text-lg">visibility_off</span>
@endif
</td>
<td class="px-4 py-3 text-slate-800 dark:text-white text-sm">
<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300">
{{ ucfirst($page->page_type ?? 'custom') }}
</span>
</td>
<td class="px-4 py-3 text-slate-800 dark:text-white text-sm">{{ $page->created_at->format('Y-m-d / H:i') }}</td>
<td class="px-4 py-3 text-slate-800 dark:text-white text-sm">
<div class="relative">
<button type="button" class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-1 rounded text-xs font-medium flex items-center gap-1" onclick="toggleDropdown({{ $page->id }})">
Select an option
<span class="material-symbols-outlined text-xs">keyboard_arrow_down</span>
</button>
<div id="dropdown-{{ $page->id }}" class="absolute right-0 mt-1 w-48 bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#324d67] rounded-lg shadow-lg z-10 hidden">
<div class="py-1">
@if($page->is_published)
<a href="{{ route('pages.show', $page) }}" target="_blank" class="block px-4 py-2 text-sm text-slate-700 dark:text-white hover:bg-slate-100 dark:hover:bg-[#192633]">View</a>
@endif
<a href="{{ route('admin.pages.edit', $page) }}" class="block px-4 py-2 text-sm text-slate-700 dark:text-white hover:bg-slate-100 dark:hover:bg-[#192633]">Edit</a>
<a href="{{ route('admin.pages.show', $page) }}" class="block px-4 py-2 text-sm text-slate-700 dark:text-white hover:bg-slate-100 dark:hover:bg-[#192633]">Details</a>
<form method="POST" action="{{ route('admin.pages.destroy', $page) }}" class="block">
@csrf
@method('DELETE')
<button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-slate-100 dark:hover:bg-[#192633]" onclick="return confirm('Are you sure you want to delete this page?')">Delete</button>
</form>
</div>
</div>
</div>
</td>
</tr>
@empty
<tr>
<td colspan="8" class="px-4 py-8 text-center text-slate-500 dark:text-[#92adc9]">No pages found.</td>
</tr>
@endforelse
</tbody>
</table>
</div>

<!-- Pagination Footer -->
<div class="flex items-center justify-between mt-6">
<div class="text-slate-600 dark:text-[#92adc9] text-sm">
Showing {{ $pages->firstItem() ?? 0 }} to {{ $pages->lastItem() ?? 0 }} of {{ $pages->total() }} entries
</div>
<div class="flex items-center gap-2">
{{ $pages->links() }}
</div>
</div>

<script>
// Dropdown toggle functionality
function toggleDropdown(pageId) {
    // Close all other dropdowns
    document.querySelectorAll('[id^="dropdown-"]').forEach(dropdown => {
        if (dropdown.id !== `dropdown-${pageId}`) {
            dropdown.classList.add('hidden');
        }
    });
    
    // Toggle current dropdown
    const dropdown = document.getElementById(`dropdown-${pageId}`);
    dropdown.classList.toggle('hidden');
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('[onclick^="toggleDropdown"]') && !event.target.closest('[id^="dropdown-"]')) {
        document.querySelectorAll('[id^="dropdown-"]').forEach(dropdown => {
            dropdown.classList.add('hidden');
        });
    }
});

// Search functionality
document.querySelector('input[name="search"]').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        document.getElementById('filterForm').submit();
    }
});

// Auto-submit form when filters change
document.querySelectorAll('select[name="per_page"], select[name="language"]').forEach(select => {
    select.addEventListener('change', function() {
        document.getElementById('filterForm').submit();
    });
});
</script>
@endsection