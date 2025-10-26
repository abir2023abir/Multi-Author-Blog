@extends('layouts.admin')

@section('content')
@if(session('status'))
<div class="mb-4 rounded-lg bg-green-100 dark:bg-green-900/50 p-4 text-green-700 dark:text-green-300">
{{ session('status') }}
</div>
@endif

<div class="flex flex-wrap justify-between gap-3 pb-8">
<div class="flex flex-col gap-3">
<h1 class="text-slate-800 dark:text-white text-4xl font-black leading-tight tracking-[-0.033em]">Settings</h1>
<p class="text-slate-500 dark:text-[#92adc9] text-base font-normal leading-normal">Configure global application settings.</p>
</div>
<div class="flex items-center gap-4">
<span class="material-symbols-outlined text-slate-500 dark:text-white cursor-pointer">notifications</span>
<div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10 bg-gray-300 dark:bg-gray-600"></div>
</div>
</div>

<div class="rounded-lg border border-slate-200 dark:border-[#324d67] bg-white dark:bg-[#111a22] p-6">
<form method="POST" action="/admin/settings">
@csrf
<div class="mb-4">
<label class="text-slate-800 dark:text-white text-sm font-medium mb-2 block">Site Name</label>
<input type="text" name="site_name" value="{{ $settings['site_name'] ?? 'My Blog' }}" class="w-full border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white">
</div>
<div class="mb-4">
<label class="text-slate-800 dark:text-white text-sm font-medium mb-2 block">Admin Email</label>
<input type="email" name="admin_email" value="{{ $settings['admin_email'] ?? '' }}" class="w-full border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white">
</div>
<div class="mb-4">
<label class="text-slate-800 dark:text-white text-sm font-medium mb-2 block">Posts Per Page</label>
<input type="number" name="posts_per_page" value="{{ $settings['posts_per_page'] ?? 10 }}" class="w-full border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white">
</div>
<button type="submit" class="flex items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-primary text-white text-sm font-bold leading-normal tracking-[0.015em]">
Save Settings
</button>
</form>
</div>
@endsection
