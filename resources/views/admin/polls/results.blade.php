@extends('layouts.admin')

@section('content')
<div class="flex items-center justify-between mb-6">
<h1 class="text-slate-800 dark:text-white text-3xl font-bold">Poll Results</h1>
<a href="{{ route('admin.polls.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium">Back to Polls</a>
</div>

<div class="bg-white dark:bg-[#111a22] rounded-lg border border-slate-200 dark:border-[#324d67] p-6">
<h2 class="text-xl font-bold text-slate-800 dark:text-white mb-4">{{ $poll->question }}</h2>
<p class="text-slate-600 dark:text-[#92adc9] mb-6">Language: {{ ucfirst($poll->language) }} | Status:
@if($poll->is_active)
<span class="text-green-600 dark:text-green-400">Active</span>
@else
<span class="text-red-600 dark:text-red-400">Inactive</span>
@endif
</p>

<div class="space-y-4">
@foreach($poll->options as $index => $option)
<div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-[#192633] rounded-lg">
<span class="text-slate-800 dark:text-white font-medium">{{ $option }}</span>
<div class="flex items-center gap-4">
<div class="w-32 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
<div class="bg-blue-600 h-2 rounded-full" style="width: {{ rand(20, 80) }}%"></div>
</div>
<span class="text-slate-600 dark:text-[#92adc9] text-sm">{{ rand(10, 100) }}%</span>
</div>
</div>
@endforeach
</div>

<div class="mt-6 text-center">
<p class="text-slate-600 dark:text-[#92adc9]">Total Votes: {{ rand(50, 500) }}</p>
</div>
</div>
@endsection
