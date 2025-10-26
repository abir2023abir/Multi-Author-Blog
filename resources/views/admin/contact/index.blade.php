@extends('layouts.admin')

@section('content')
@if(session('status'))
<div class="mb-4 rounded-lg bg-green-100 dark:bg-green-900/50 p-4 text-green-700 dark:text-green-300">
{{ session('status') }}
</div>
@endif

<div class="flex flex-wrap justify-between gap-3 pb-8">
<div class="flex flex-col gap-3">
<h1 class="text-slate-800 dark:text-white text-4xl font-black leading-tight tracking-[-0.033em]">Contact Messages</h1>
<p class="text-slate-500 dark:text-[#92adc9] text-base font-normal leading-normal">View and manage contact form submissions.</p>
</div>
<div class="flex items-center gap-4">
<span class="material-symbols-outlined text-slate-500 dark:text-white cursor-pointer">notifications</span>
<div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10 bg-gray-300 dark:bg-gray-600"></div>
</div>
</div>

<div class="overflow-hidden rounded-lg border border-slate-200 dark:border-[#324d67] bg-white dark:bg-[#111a22]">
<table class="w-full">
<thead>
<tr class="bg-slate-50 dark:bg-[#192633]">
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium leading-normal">Name</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium leading-normal">Email</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium leading-normal">Subject</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium leading-normal">Message</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium leading-normal">Date</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium leading-normal">Actions</th>
</tr>
</thead>
<tbody>
@forelse($contacts as $contact)
<tr class="border-t border-t-slate-200 dark:border-t-[#324d67]">
<td class="h-[72px] px-4 py-2 text-slate-800 dark:text-white text-sm font-normal leading-normal">{{ $contact->name }}</td>
<td class="h-[72px] px-4 py-2 text-slate-500 dark:text-[#92adc9] text-sm font-normal leading-normal">{{ $contact->email }}</td>
<td class="h-[72px] px-4 py-2 text-slate-500 dark:text-[#92adc9] text-sm font-normal leading-normal">{{ $contact->subject }}</td>
<td class="h-[72px] px-4 py-2 text-slate-500 dark:text-[#92adc9] text-sm font-normal leading-normal">{{ Str::limit($contact->message, 50) }}</td>
<td class="h-[72px] px-4 py-2 text-slate-500 dark:text-[#92adc9] text-sm font-normal leading-normal">{{ $contact->created_at->format('Y-m-d') }}</td>
<td class="h-[72px] px-4 py-2 text-sm font-normal leading-normal">
<form method="POST" action="{{ route('admin.contact.destroy', $contact) }}" class="inline">
@csrf
@method('DELETE')
<button type="submit" class="text-xs font-medium text-red-600 hover:text-red-500" onclick="return confirm('Are you sure?')">Delete</button>
</form>
</td>
</tr>
@empty
<tr>
<td colspan="6" class="px-4 py-8 text-center text-slate-500 dark:text-[#92adc9]">No contact messages found.</td>
</tr>
@endforelse
</tbody>
</table>
<div class="p-4 border-t border-slate-200 dark:border-t-[#324d67]">
{{ $contacts->links() }}
</div>
</div>
@endsection
