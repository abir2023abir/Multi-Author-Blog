@extends('layouts.admin')

@section('title', 'Add Post')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Choose a Post Format</h1>
                    <p class="text-gray-600">Select the type of content you want to create</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('admin.posts.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 flex items-center space-x-2">
                        <span class="material-symbols-outlined text-sm">arrow_back</span>
                        <span>Back to Posts</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Post Format Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
            <!-- Post -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow cursor-pointer" onclick="selectFormat('article')">
                <div class="text-center">
                    <div class="w-16 h-16 bg-teal-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-teal-600 text-2xl">article</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Post</h3>
                    <p class="text-sm text-gray-600">An article with images and embed videos</p>
                </div>
            </div>

            <!-- Gallery -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow cursor-pointer" onclick="selectFormat('gallery')">
                <div class="text-center">
                    <div class="w-16 h-16 bg-teal-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-teal-600 text-2xl">photo_library</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Gallery</h3>
                    <p class="text-sm text-gray-600">A collection of images</p>
                </div>
            </div>

            <!-- Quiz -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow cursor-pointer" onclick="selectFormat('quiz')">
                <div class="text-center">
                    <div class="w-16 h-16 bg-teal-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-teal-600 text-2xl">quiz</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Quiz</h3>
                    <p class="text-sm text-gray-600">Quizzes with right and wrong answers</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function selectFormat(format) {
    // Add visual feedback
    event.currentTarget.style.transform = 'scale(0.95)';
    setTimeout(() => {
        event.currentTarget.style.transform = 'scale(1)';
    }, 150);

    // Redirect to create post with format parameter
    window.location.href = `{{ route('admin.posts.create') }}?type=${format}`;
}

// Add hover effects
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.bg-white.rounded-lg.shadow-sm');

    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});
</script>
@endsection
