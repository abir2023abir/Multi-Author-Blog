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
<button type="button" onclick="openImportModal()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium">+ Import RSS Feed</button>
</div>
</div>

<!-- Page Header -->
<div class="flex items-center justify-between mb-6">
<h1 class="text-slate-800 dark:text-white text-3xl font-bold">RSS Feeds</h1>
</div>

<!-- Filter and Search Controls -->
<div class="bg-white dark:bg-[#111a22] rounded-lg border border-slate-200 dark:border-[#324d67] p-6 mb-6">
<form method="GET" action="{{ route('admin.rss.index') }}" class="flex items-center gap-4">
<div class="flex items-center gap-2">
<label class="text-slate-600 dark:text-[#92adc9] text-sm font-medium">Show</label>
<select name="per_page" class="border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white text-sm">
<option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10</option>
<option value="15" {{ request('per_page') == '15' || !request('per_page') ? 'selected' : '' }}>15</option>
<option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>25</option>
<option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50</option>
<option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100</option>
</select>
</div>

<div class="flex items-center gap-2">
<label class="text-slate-600 dark:text-[#92adc9] text-sm font-medium">Language</label>
<select name="language" class="border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white text-sm">
@foreach($languages as $value => $label)
<option value="{{ $value }}" {{ request('language') == $value ? 'selected' : '' }}>{{ $label }}</option>
@endforeach
</select>
</div>

<div class="flex items-center gap-2">
<input type="text" name="search" value="{{ request('search') }}" placeholder="Search feeds..." class="border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white text-sm w-64">
</div>

<button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium">Filter</button>
</form>
</div>

<!-- RSS Feeds Table -->
<div class="rounded-lg border border-slate-200 dark:border-[#324d67] bg-white dark:bg-[#111a22] overflow-hidden">
<table class="w-full">
<thead>
<tr class="bg-slate-50 dark:bg-[#192633]">
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">Id</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">Feed Name</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">Feed URL</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">Language</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">Category</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">Posts</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">Author</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">Auto Update</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">Options</th>
</tr>
</thead>
<tbody>
@forelse($feeds as $feed)
<tr class="border-t border-slate-200 dark:border-[#324d67] hover:bg-slate-50 dark:hover:bg-[#192633]">
<td class="px-4 py-3 text-slate-600 dark:text-white text-sm">{{ $feed->id }}</td>
<td class="px-4 py-3 text-slate-800 dark:text-white text-sm font-medium">{{ $feed->name }}</td>
<td class="px-4 py-3 text-slate-500 dark:text-[#92adc9] text-sm">
<a href="{{ $feed->url }}" target="_blank" class="hover:underline">{{ Str::limit($feed->url, 50) }}</a>
</td>
<td class="px-4 py-3 text-slate-600 dark:text-white text-sm">{{ ucfirst($feed->language) }}</td>
<td class="px-4 py-3 text-slate-600 dark:text-white text-sm">
@if($feed->categories)
@foreach($feed->categories as $category)
<span class="inline-block bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-300 px-2 py-1 rounded text-xs mr-1">{{ $category }}</span>
@endforeach
@else
<span class="text-slate-400 dark:text-slate-500">-</span>
@endif
</td>
<td class="px-4 py-3 text-slate-600 dark:text-white text-sm">{{ $feed->posts_count }}</td>
<td class="px-4 py-3 text-slate-600 dark:text-white text-sm">{{ $feed->author }}</td>
<td class="px-4 py-3 text-slate-600 dark:text-white text-sm">
@if($feed->auto_update)
<span class="inline-flex items-center text-green-600 dark:text-green-400">
<span class="material-symbols-outlined text-sm mr-1">check</span>
Yes
</span>
@else
<span class="inline-flex items-center text-red-600 dark:text-red-400">
<span class="material-symbols-outlined text-sm mr-1">close</span>
No
</span>
@endif
</td>
<td class="px-4 py-3">
<div class="flex items-center gap-2">
<form method="POST" action="{{ route('admin.rss.update-feed', $feed) }}" class="inline">
@csrf
<button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs">Update</button>
</form>
<select class="border border-slate-300 dark:border-[#324d67] rounded px-2 py-1 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white text-xs" onchange="handleOptionChange(this, {{ $feed->id }})">
<option value="">Select an option</option>
<option value="edit">Edit</option>
<option value="delete">Delete</option>
<option value="toggle-auto">Toggle Auto Update</option>
</select>
</div>
</td>
</tr>
@empty
<tr>
<td colspan="9" class="px-4 py-8 text-center text-slate-500 dark:text-[#92adc9]">No RSS feeds found.</td>
</tr>
@endforelse
</tbody>
</table>
</div>

<!-- Pagination -->
@if($feeds->hasPages())
<div class="mt-6">
{{ $feeds->links() }}
</div>
@endif

<!-- Warning Message -->
<div class="mt-6 bg-red-100 dark:bg-red-900/50 border border-red-200 dark:border-red-800 rounded-lg p-4">
<div class="flex items-start">
<span class="material-symbols-outlined text-red-600 dark:text-red-400 mr-2">warning</span>
<div class="text-red-800 dark:text-red-300 text-sm">
<strong>Warning!</strong> If you chose to download the images to your server, adding posts will take more time and will use more resources. If you see any problems, increase 'max_execution_time' and 'memory_limit' values from your server settings.
</div>
</div>
</div>

<!-- Import RSS Feed Modal -->
<div id="importModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
<div class="flex items-center justify-center min-h-screen p-4">
<div class="bg-white dark:bg-[#111a22] rounded-lg p-6 w-full max-w-md">
<h3 class="text-slate-800 dark:text-white text-lg font-bold mb-4">Import RSS Feed</h3>
<form method="POST" action="{{ route('admin.rss.store') }}">
@csrf
<div class="space-y-4">
<div>
<label class="text-slate-600 dark:text-[#92adc9] text-sm font-medium block mb-2">Feed Name</label>
<input type="text" name="name" required class="w-full border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white text-sm">
</div>
<div>
<label class="text-slate-600 dark:text-[#92adc9] text-sm font-medium block mb-2">Feed URL</label>
<input type="url" name="url" required class="w-full border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white text-sm">
</div>
<div>
<label class="text-slate-600 dark:text-[#92adc9] text-sm font-medium block mb-2">Language</label>
<select name="language" class="w-full border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white text-sm">
<option value="en">English</option>
<option value="ar">Arabic</option>
</select>
</div>
<div>
<label class="text-slate-600 dark:text-[#92adc9] text-sm font-medium block mb-2">Categories (comma separated)</label>
<input type="text" name="categories" placeholder="RSS News, Technology" class="w-full border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white text-sm">
</div>
<div class="flex items-center gap-4">
<label class="flex items-center">
<input type="checkbox" name="auto_update" value="1" checked class="mr-2">
<span class="text-slate-600 dark:text-[#92adc9] text-sm">Auto Update</span>
</label>
<label class="flex items-center">
<input type="checkbox" name="download_images" value="1" class="mr-2">
<span class="text-slate-600 dark:text-[#92adc9] text-sm">Download Images</span>
</label>
</div>
</div>
<div class="flex gap-3 mt-6">
<button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium">Import Feed</button>
<button type="button" onclick="closeImportModal()" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium">Cancel</button>
</div>
</form>
</div>
</div>
</div>

<script>
function openImportModal() {
    document.getElementById('importModal').classList.remove('hidden');
}

function closeImportModal() {
    document.getElementById('importModal').classList.add('hidden');
}

function handleOptionChange(select, feedId) {
    const value = select.value;
    if (value === 'edit') {
        // Handle edit
        console.log('Edit feed:', feedId);
    } else if (value === 'delete') {
        if (confirm('Are you sure you want to delete this RSS feed?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/rss/${feedId}`;
            form.innerHTML = '@csrf @method("DELETE")';
            document.body.appendChild(form);
            form.submit();
        }
    } else if (value === 'toggle-auto') {
        // Handle toggle auto update
        console.log('Toggle auto update:', feedId);
    }
    select.value = '';
}

// Close modal when clicking outside
document.getElementById('importModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeImportModal();
    }
});
</script>
@endsection
