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
<a href="{{ route('admin.polls.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium">+ Add Poll</a>
</div>
</div>

<!-- Page Header -->
<div class="flex items-center justify-between mb-6">
<h1 class="text-slate-800 dark:text-white text-3xl font-bold">Polls</h1>
</div>

<!-- Filter and Search Controls -->
<div class="bg-white dark:bg-[#111a22] rounded-lg border border-slate-200 dark:border-[#324d67] p-6 mb-6">
<form method="GET" action="{{ route('admin.polls.index') }}" class="flex items-center gap-4">
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
<input type="text" name="search" value="{{ request('search') }}" placeholder="Search" class="border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white text-sm w-48">
</div>

<button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium">Filter</button>
</form>
</div>

<!-- Polls Table -->
<div class="rounded-lg border border-slate-200 dark:border-[#324d67] bg-white dark:bg-[#111a22] overflow-hidden">
<table class="w-full">
<thead>
<tr class="bg-slate-50 dark:bg-[#192633]">
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium cursor-pointer hover:bg-slate-100 dark:hover:bg-[#233648]">
<div class="flex items-center gap-1">
Id
<span class="material-symbols-outlined text-xs">unfold_more</span>
</div>
</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium cursor-pointer hover:bg-slate-100 dark:hover:bg-[#233648]">
<div class="flex items-center gap-1">
Question
<span class="material-symbols-outlined text-xs">unfold_more</span>
</div>
</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium cursor-pointer hover:bg-slate-100 dark:hover:bg-[#233648]">
<div class="flex items-center gap-1">
Language
<span class="material-symbols-outlined text-xs">unfold_more</span>
</div>
</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium cursor-pointer hover:bg-slate-100 dark:hover:bg-[#233648]">
<div class="flex items-center gap-1">
Vote Permission
<span class="material-symbols-outlined text-xs">unfold_more</span>
</div>
</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium cursor-pointer hover:bg-slate-100 dark:hover:bg-[#233648]">
<div class="flex items-center gap-1">
Status
<span class="material-symbols-outlined text-xs">unfold_more</span>
</div>
</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium cursor-pointer hover:bg-slate-100 dark:hover:bg-[#233648]">
<div class="flex items-center gap-1">
Date Added
<span class="material-symbols-outlined text-xs">unfold_more</span>
</div>
</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">Options</th>
</tr>
</thead>
<tbody>
@forelse($polls as $poll)
<tr class="border-t border-slate-200 dark:border-[#324d67] hover:bg-slate-50 dark:hover:bg-[#192633]">
<td class="px-4 py-3 text-slate-600 dark:text-white text-sm">{{ $poll->id }}</td>
<td class="px-4 py-3">
<div class="flex items-center justify-between">
<span class="text-slate-800 dark:text-white text-sm font-medium">{{ $poll->question }}</span>
<a href="{{ route('admin.polls.results', $poll) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs font-medium">View Results</a>
</div>
</td>
<td class="px-4 py-3 text-slate-600 dark:text-white text-sm">{{ ucfirst($poll->language) }}</td>
<td class="px-4 py-3 text-slate-600 dark:text-white text-sm">{{ ucfirst($poll->vote_permission ?? 'All') }}</td>
<td class="px-4 py-3">
@if($poll->is_active)
<button onclick="toggleStatus({{ $poll->id }})" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs font-medium">Active</button>
@else
<button onclick="toggleStatus({{ $poll->id }})" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-medium">Inactive</button>
@endif
</td>
<td class="px-4 py-3 text-slate-600 dark:text-white text-sm">{{ $poll->date_added->format('Y-m-d / H:i') }}</td>
<td class="px-4 py-3">
<select class="border border-slate-300 dark:border-[#324d67] rounded px-2 py-1 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white text-xs" onchange="handleOptionChange(this, {{ $poll->id }})">
<option value="">Select an option</option>
<option value="edit">Edit</option>
<option value="delete">Delete</option>
<option value="toggle-status">Toggle Status</option>
<option value="duplicate">Duplicate</option>
<option value="results">View Results</option>
</select>
</td>
</tr>
@empty
<tr>
<td colspan="7" class="px-4 py-8 text-center text-slate-500 dark:text-[#92adc9]">No polls found.</td>
</tr>
@endforelse
</tbody>
</table>
</div>

<!-- Pagination -->
@if($polls->hasPages())
<div class="mt-6 flex items-center justify-between">
<div class="text-slate-600 dark:text-[#92adc9] text-sm">
Showing {{ $polls->firstItem() }} to {{ $polls->lastItem() }} of {{ $polls->total() }} entries
</div>
<div class="flex items-center gap-2">
{{ $polls->links() }}
</div>
</div>
@else
<div class="mt-6 text-slate-600 dark:text-[#92adc9] text-sm">
Showing {{ $polls->firstItem() }} to {{ $polls->lastItem() }} of {{ $polls->total() }} entries
</div>
@endif

<script>
function handleOptionChange(select, pollId) {
    const value = select.value;
    if (value === 'edit') {
        window.location.href = `/admin/polls/${pollId}/edit`;
    } else if (value === 'delete') {
        if (confirm('Are you sure you want to delete this poll?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/polls/${pollId}`;
            form.innerHTML = '@csrf @method("DELETE")';
            document.body.appendChild(form);
            form.submit();
        }
    } else if (value === 'toggle-status') {
        toggleStatus(pollId);
    } else if (value === 'duplicate') {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/polls/${pollId}/duplicate`;
        form.innerHTML = '@csrf';
        document.body.appendChild(form);
        form.submit();
    } else if (value === 'results') {
        window.location.href = `/admin/polls/${pollId}/results`;
    }
    select.value = '';
}

function toggleStatus(pollId) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/admin/polls/${pollId}/toggle-status`;
    form.innerHTML = '@csrf';
    document.body.appendChild(form);
    form.submit();
}
</script>
@endsection
