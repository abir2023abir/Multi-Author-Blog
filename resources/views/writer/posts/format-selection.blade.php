@extends('layouts.admin')

@section('content')
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

<!-- Main Content Area -->
<div class="flex items-center justify-between mb-8">
<div></div>
<div class="flex items-center gap-2">
<a href="{{ route('writer.posts.index') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2">
<span class="material-symbols-outlined text-sm">menu</span>
Posts
</a>
</div>
</div>

<!-- Choose a Post Format Title -->
<div class="text-center mb-12">
<h1 class="text-slate-800 dark:text-white text-4xl font-bold">Choose a Post Format</h1>
</div>

<!-- Post Format Cards Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
<!-- Row 1 -->
<!-- Article -->
<div class="bg-white dark:bg-[#111a22] rounded-lg border border-slate-200 dark:border-[#324d67] p-8 text-center hover:shadow-lg transition-shadow cursor-pointer" onclick="selectFormat('article')">
<div class="mb-6">
<div class="w-16 h-16 bg-teal-500 rounded-lg flex items-center justify-center mx-auto">
<span class="material-symbols-outlined text-white text-3xl">article</span>
</div>
</div>
<h3 class="text-slate-800 dark:text-white text-xl font-bold mb-3">Article</h3>
<p class="text-slate-600 dark:text-[#92adc9] text-sm">An article with images and embed videos</p>
</div>

<!-- Gallery -->
<div class="bg-white dark:bg-[#111a22] rounded-lg border border-slate-200 dark:border-[#324d67] p-8 text-center hover:shadow-lg transition-shadow cursor-pointer" onclick="selectFormat('gallery')">
<div class="mb-6">
<div class="w-16 h-16 bg-teal-500 rounded-lg flex items-center justify-center mx-auto">
<span class="material-symbols-outlined text-white text-3xl">photo_library</span>
</div>
</div>
<h3 class="text-slate-800 dark:text-white text-xl font-bold mb-3">Gallery</h3>
<p class="text-slate-600 dark:text-[#92adc9] text-sm">A collection of images</p>
</div>

<!-- Sorted List -->
<div class="bg-white dark:bg-[#111a22] rounded-lg border border-slate-200 dark:border-[#324d67] p-8 text-center hover:shadow-lg transition-shadow cursor-pointer" onclick="selectFormat('sorted_list')">
<div class="mb-6">
<div class="w-16 h-16 bg-teal-500 rounded-lg flex items-center justify-center mx-auto">
<span class="material-symbols-outlined text-white text-3xl">format_list_numbered</span>
</div>
</div>
<h3 class="text-slate-800 dark:text-white text-xl font-bold mb-3">Sorted List</h3>
<p class="text-slate-600 dark:text-[#92adc9] text-sm">A list based article</p>
</div>

<!-- Table of Contents -->
<div class="bg-white dark:bg-[#111a22] rounded-lg border border-slate-200 dark:border-[#324d67] p-8 text-center hover:shadow-lg transition-shadow cursor-pointer" onclick="selectFormat('table_of_contents')">
<div class="mb-6">
<div class="w-16 h-16 bg-teal-500 rounded-lg flex items-center justify-center mx-auto">
<span class="material-symbols-outlined text-white text-3xl">link</span>
</div>
</div>
<h3 class="text-slate-800 dark:text-white text-xl font-bold mb-3">Table of Contents</h3>
<p class="text-slate-600 dark:text-[#92adc9] text-sm">List of links based on the headings</p>
</div>

<!-- Row 2 -->
<!-- Video -->
<div class="bg-white dark:bg-[#111a22] rounded-lg border border-slate-200 dark:border-[#324d67] p-8 text-center hover:shadow-lg transition-shadow cursor-pointer" onclick="selectFormat('video')">
<div class="mb-6">
<div class="w-16 h-16 bg-teal-500 rounded-lg flex items-center justify-center mx-auto">
<span class="material-symbols-outlined text-white text-3xl">play_circle</span>
</div>
</div>
<h3 class="text-slate-800 dark:text-white text-xl font-bold mb-3">Video</h3>
<p class="text-slate-600 dark:text-[#92adc9] text-sm">Upload or embed videos</p>
</div>

<!-- Audio -->
<div class="bg-white dark:bg-[#111a22] rounded-lg border border-slate-200 dark:border-[#324d67] p-8 text-center hover:shadow-lg transition-shadow cursor-pointer" onclick="selectFormat('audio')">
<div class="mb-6">
<div class="w-16 h-16 bg-teal-500 rounded-lg flex items-center justify-center mx-auto">
<span class="material-symbols-outlined text-white text-3xl">music_note</span>
</div>
</div>
<h3 class="text-slate-800 dark:text-white text-xl font-bold mb-3">Audio</h3>
<p class="text-slate-600 dark:text-[#92adc9] text-sm">Upload audios and create playlist</p>
</div>

<!-- Trivia Quiz -->
<div class="bg-white dark:bg-[#111a22] rounded-lg border border-slate-200 dark:border-[#324d67] p-8 text-center hover:shadow-lg transition-shadow cursor-pointer" onclick="selectFormat('trivia_quiz')">
<div class="mb-6">
<div class="w-16 h-16 bg-teal-500 rounded-lg flex items-center justify-center mx-auto">
<span class="material-symbols-outlined text-white text-3xl">quiz</span>
</div>
</div>
<h3 class="text-slate-800 dark:text-white text-xl font-bold mb-3">Trivia Quiz</h3>
<p class="text-slate-600 dark:text-[#92adc9] text-sm">Quizzes with right and wrong answers</p>
</div>

<!-- Personality Quiz -->
<div class="bg-white dark:bg-[#111a22] rounded-lg border border-slate-200 dark:border-[#324d67] p-8 text-center hover:shadow-lg transition-shadow cursor-pointer" onclick="selectFormat('personality_quiz')">
<div class="mb-6">
<div class="w-16 h-16 bg-teal-500 rounded-lg flex items-center justify-center mx-auto">
<span class="material-symbols-outlined text-white text-3xl">psychology</span>
</div>
</div>
<h3 class="text-slate-800 dark:text-white text-xl font-bold mb-3">Personality Quiz</h3>
<p class="text-slate-600 dark:text-[#92adc9] text-sm">Quizzes with custom results</p>
</div>

<!-- Row 3 -->
<!-- Poll -->
<div class="bg-white dark:bg-[#111a22] rounded-lg border border-slate-200 dark:border-[#324d67] p-8 text-center hover:shadow-lg transition-shadow cursor-pointer" onclick="selectFormat('poll')">
<div class="mb-6">
<div class="w-16 h-16 bg-teal-500 rounded-lg flex items-center justify-center mx-auto">
<span class="material-symbols-outlined text-white text-3xl">poll</span>
</div>
</div>
<h3 class="text-slate-800 dark:text-white text-xl font-bold mb-3">Poll</h3>
<p class="text-slate-600 dark:text-[#92adc9] text-sm">Get user opinions about something</p>
</div>

<!-- Recipe -->
<div class="bg-white dark:bg-[#111a22] rounded-lg border border-slate-200 dark:border-[#324d67] p-8 text-center hover:shadow-lg transition-shadow cursor-pointer" onclick="selectFormat('recipe')">
<div class="mb-6">
<div class="w-16 h-16 bg-teal-500 rounded-lg flex items-center justify-center mx-auto">
<span class="material-symbols-outlined text-white text-3xl">restaurant</span>
</div>
</div>
<h3 class="text-slate-800 dark:text-white text-xl font-bold mb-3">Recipe</h3>
<p class="text-slate-600 dark:text-[#92adc9] text-sm">A list of ingredients and directions for cooking</p>
</div>
</div>

<script>
function selectFormat(format) {
    // Add visual feedback
    event.currentTarget.style.transform = 'scale(0.95)';
    setTimeout(() => {
        event.currentTarget.style.transform = 'scale(1)';
    }, 150);
    
    // Redirect to create form with selected format
    window.location.href = `{{ route('writer.posts.create-with-format') }}?format=${format}`;
}
</script>
@endsection
