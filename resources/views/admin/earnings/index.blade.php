@extends('layouts.admin')

@section('content')
<div class="flex flex-wrap justify-between gap-3 pb-8">
<div class="flex flex-col gap-3">
<h1 class="text-slate-800 dark:text-white text-4xl font-black leading-tight tracking-[-0.033em]">My Earnings</h1>
<p class="text-slate-500 dark:text-[#92adc9] text-base font-normal leading-normal">Track your earnings and revenue.</p>
</div>
<div class="flex items-center gap-4">
<span class="material-symbols-outlined text-slate-500 dark:text-white cursor-pointer">notifications</span>
<div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10 bg-gray-300 dark:bg-gray-600"></div>
</div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
<div class="rounded-lg border border-slate-200 dark:border-[#324d67] bg-white dark:bg-[#111a22] p-6">
<p class="text-slate-600 dark:text-white text-base font-medium leading-normal">Total Earnings</p>
<p class="text-slate-800 dark:text-white tracking-light text-2xl font-bold leading-tight">${{ number_format($totalEarnings, 2) }}</p>
</div>
<div class="rounded-lg border border-slate-200 dark:border-[#324d67] bg-white dark:bg-[#111a22] p-6">
<p class="text-slate-600 dark:text-white text-base font-medium leading-normal">This Month</p>
<p class="text-slate-800 dark:text-white tracking-light text-2xl font-bold leading-tight">${{ number_format($thisMonth, 2) }}</p>
</div>
<div class="rounded-lg border border-slate-200 dark:border-[#324d67] bg-white dark:bg-[#111a22] p-6">
<p class="text-slate-600 dark:text-white text-base font-medium leading-normal">Last Month</p>
<p class="text-slate-800 dark:text-white tracking-light text-2xl font-bold leading-tight">${{ number_format($lastMonth, 2) }}</p>
</div>
</div>

<div class="rounded-lg border border-slate-200 dark:border-[#324d67] bg-white dark:bg-[#111a22] p-6">
<h3 class="text-slate-800 dark:text-white text-lg font-bold mb-4">Earnings History</h3>
<p class="text-slate-500 dark:text-[#92adc9]">No earnings history available.</p>
</div>
@endsection
