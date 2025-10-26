@extends('layouts.admin')

@section('content')
@if(session('status'))
<div class="mb-4 rounded-lg bg-green-100 dark:bg-green-900/50 p-4 text-green-700 dark:text-green-300">
{{ session('status') }}
</div>
@endif

<div class="flex flex-wrap justify-between gap-3 pb-8">
<div class="flex flex-col gap-3">
<h1 class="text-slate-800 dark:text-white text-4xl font-black leading-tight tracking-[-0.033em]">Preferences</h1>
<p class="text-slate-500 dark:text-[#92adc9] text-base font-normal leading-normal">Configure your personal preferences.</p>
</div>
<div class="flex items-center gap-4">
<span class="material-symbols-outlined text-slate-500 dark:text-white cursor-pointer">notifications</span>
<div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10 bg-gray-300 dark:bg-gray-600"></div>
</div>
</div>

<div class="rounded-lg border border-slate-200 dark:border-[#324d67] bg-white dark:bg-[#111a22] p-6">
<form method="POST" action="{{ route('admin.preferences.update') }}">
@csrf
<div class="mb-4">
<label class="text-slate-800 dark:text-white text-sm font-medium mb-2 block">Language</label>
<select name="language" class="w-full border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white">
<option value="en" {{ $preferences['language'] == 'en' ? 'selected' : '' }}>English</option>
<option value="es">Spanish</option>
<option value="fr">French</option>
</select>
</div>
<div class="mb-4">
<label class="text-slate-800 dark:text-white text-sm font-medium mb-2 block">Timezone</label>
<select name="timezone" class="w-full border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white">
<option value="UTC" {{ $preferences['timezone'] == 'UTC' ? 'selected' : '' }}>UTC</option>
<option value="America/New_York">EST</option>
<option value="America/Los_Angeles">PST</option>
</select>
</div>
<div class="mb-4">
<label class="flex items-center">
<input type="checkbox" name="notifications" {{ $preferences['notifications'] ? 'checked' : '' }} class="rounded border-slate-300 dark:border-[#324d67]">
<span class="ml-2 text-slate-800 dark:text-white text-sm">Enable Notifications</span>
</label>
</div>
<button type="submit" class="flex items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-primary text-white text-sm font-bold leading-normal tracking-[0.015em]">
Save Preferences
</button>
</form>
</div>
@endsection
