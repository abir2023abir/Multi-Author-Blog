@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <!-- Post Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">{{ $post->title }}</h1>
        <div class="flex items-center space-x-4 text-sm text-gray-600 dark:text-gray-400">
            <span>By {{ $post->user->name }}</span>
            <span>•</span>
            <span>{{ $post->created_at->format('M d, Y') }}</span>
            @if($post->category)
            <span>•</span>
            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                {{ $post->category->name }}
            </span>
            @endif
        </div>
    </div>

    <!-- Post Content -->
    <div class="prose prose-lg max-w-none mb-8">
        {!! nl2br(e($post->content)) !!}
    </div>

    <!-- Comments Section -->
    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Comments (<span id="comment-count">{{ $post->comments->count() }}</span>)</h2>

        <!-- Add Comment Form -->
        <form method="POST" action="{{ route('posts.comments.store', $post) }}" class="mb-8">
            @csrf
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="author_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Name</label>
                        <input type="text" id="author_name" name="author_name" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="author_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                        <input type="email" id="author_email" name="author_email" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Comment</label>
                    <textarea id="content" name="content" rows="4" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md font-medium">Post Comment</button>
            </div>
        </form>

        <!-- Comments List -->
        <div id="comments-list" class="space-y-4">
            @foreach($post->comments as $comment)
            <div class="comment-item border-b border-gray-200 dark:border-gray-700 pb-4 last:border-b-0">
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center">
                            <span class="text-gray-600 dark:text-gray-300 font-medium">{{ $comment->author_name[0] }}</span>
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center space-x-2 mb-1">
                            <h4 class="text-sm font-medium text-gray-900 dark:text-white">{{ $comment->author_name }}</h4>
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-gray-700 dark:text-gray-300">{{ $comment->content }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Real-time Comments -->
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Pusher
    const pusher = new Pusher('{{ env("PUSHER_APP_KEY") }}', {
        cluster: '{{ env("PUSHER_APP_CLUSTER") }}',
        wsHost: '{{ env("PUSHER_HOST") }}',
        wsPort: '{{ env("PUSHER_PORT") }}',
        wssPort: '{{ env("PUSHER_PORT") }}',
        forceTLS: false,
        enabledTransports: ['ws', 'wss'],
    });

    // Subscribe to comments channel
    const commentsChannel = pusher.subscribe('comments');

    // Handle new comment
    commentsChannel.bind('comment.created', function(data) {
        if (data.comment.post_id === {{ $post->id }}) {
            addCommentToPage(data.comment);
            updateCommentCount();
        }
    });

    function addCommentToPage(comment) {
        const commentsList = document.getElementById('comments-list');
        const commentElement = document.createElement('div');
        commentElement.className = 'comment-item border-b border-gray-200 dark:border-gray-700 pb-4 last:border-b-0';
        
        const timeAgo = new Date(comment.created_at).toLocaleString();
        
        commentElement.innerHTML = `
            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center">
                        <span class="text-gray-600 dark:text-gray-300 font-medium">${comment.author.charAt(0)}</span>
                    </div>
                </div>
                <div class="flex-1">
                    <div class="flex items-center space-x-2 mb-1">
                        <h4 class="text-sm font-medium text-gray-900 dark:text-white">${comment.author}</h4>
                        <span class="text-xs text-gray-500 dark:text-gray-400">${timeAgo}</span>
                        <span class="text-xs text-green-600 dark:text-green-400 font-medium">• New</span>
                    </div>
                    <p class="text-gray-700 dark:text-gray-300">${comment.content}</p>
                </div>
            </div>
        `;
        
        commentsList.insertBefore(commentElement, commentsList.firstChild);
        
        // Add animation
        commentElement.style.opacity = '0';
        commentElement.style.transform = 'translateY(-10px)';
        setTimeout(() => {
            commentElement.style.transition = 'all 0.3s ease';
            commentElement.style.opacity = '1';
            commentElement.style.transform = 'translateY(0)';
        }, 100);
    }

    function updateCommentCount() {
        const countElement = document.getElementById('comment-count');
        const currentCount = parseInt(countElement.textContent);
        countElement.textContent = currentCount + 1;
    }
});
</script>
@endsection