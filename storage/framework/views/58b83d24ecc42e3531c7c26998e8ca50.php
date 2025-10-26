<!-- Real-time Admin Component -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize real-time functionality for all admin pages
    if (typeof Pusher !== 'undefined') {
        const pusher = new Pusher('<?php echo e(config('broadcasting.connections.pusher.key')); ?>', {
            cluster: '<?php echo e(config('broadcasting.connections.pusher.options.cluster')); ?>'
        });

        const channel = pusher.subscribe('admin-dashboard');

        // Global real-time event handlers
        channel.bind('stats-updated', function(data) {
            updatePageStats(data);
        });

        channel.bind('new-post', function(data) {
            showRealtimeNotification('New Post', data.title, 'article', 'success');
            refreshCurrentPage();
        });

        channel.bind('post-updated', function(data) {
            showRealtimeNotification('Post Updated', data.title, 'edit', 'info');
            refreshCurrentPage();
        });

        channel.bind('post-deleted', function(data) {
            showRealtimeNotification('Post Deleted', data.title, 'delete', 'warning');
            refreshCurrentPage();
        });

        channel.bind('new-comment', function(data) {
            showRealtimeNotification('New Comment', data.post_title, 'comment', 'info');
            refreshCurrentPage();
        });

        channel.bind('comment-deleted', function(data) {
            showRealtimeNotification('Comment Deleted', 'Comment removed', 'delete', 'warning');
            refreshCurrentPage();
        });

        channel.bind('user-activity', function(data) {
            showRealtimeNotification('User Activity', data.action, 'person', 'warning');
        });
    }

    // Auto-refresh current page every 60 seconds
    setInterval(refreshCurrentPage, 60000);
});

function updatePageStats(data) {
    // Update any stats elements on the current page
    const statsElements = {
        'users-count': data.total_users,
        'posts-count': data.total_posts,
        'comments-count': data.total_comments,
        'categories-count': data.total_categories,
        'published-posts': data.published_posts,
        'pending-posts': data.pending_posts,
        'draft-posts': data.draft_posts
    };

    Object.keys(statsElements).forEach(id => {
        const element = document.getElementById(id);
        if (element && statsElements[id] !== undefined) {
            element.textContent = statsElements[id];
        }
    });
}

function refreshCurrentPage() {
    // Only refresh if we're on a data table page
    const currentPath = window.location.pathname;
    const dataPages = [
        '/admin/posts',
        '/admin/comments',
        '/admin/categories',
        '/admin/users',
        '/admin/widgets',
        '/admin/polls',
        '/admin/rss'
    ];

    if (dataPages.some(page => currentPath.includes(page))) {
        // Add a subtle refresh indicator
        const refreshIndicator = document.createElement('div');
        refreshIndicator.className = 'fixed top-4 left-1/2 transform -translate-x-1/2 bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
        refreshIndicator.innerHTML = `
            <div class="flex items-center space-x-2">
                <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-white"></div>
                <span>Updating data...</span>
            </div>
        `;

        document.body.appendChild(refreshIndicator);

        // Refresh the page after a short delay
        setTimeout(() => {
            window.location.reload();
        }, 1000);
    }
}

function showRealtimeNotification(title, message, icon, type) {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 ${getNotificationClass(type)}`;
    notification.innerHTML = `
        <div class="flex items-center space-x-3">
            <span class="material-symbols-outlined text-lg">${icon}</span>
            <div class="flex-1">
                <p class="text-sm font-medium">${title}</p>
                <p class="text-sm opacity-90">${message}</p>
            </div>
            <button onclick="this.parentElement.parentElement.remove()" class="text-gray-500 hover:text-gray-700">
                <span class="material-symbols-outlined text-sm">close</span>
            </button>
        </div>
    `;

    document.body.appendChild(notification);

    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentElement) {
            notification.remove();
        }
    }, 5000);
}

function getNotificationClass(type) {
    const classes = {
        'success': 'bg-green-100 text-green-800 border border-green-200',
        'info': 'bg-blue-100 text-blue-800 border border-blue-200',
        'warning': 'bg-yellow-100 text-yellow-800 border border-yellow-200',
        'error': 'bg-red-100 text-red-800 border border-red-200'
    };
    return classes[type] || classes['info'];
}

// Global utility functions for real-time updates
window.AdminRealtime = {
    showNotification: showRealtimeNotification,
    refreshPage: refreshCurrentPage,
    updateStats: updatePageStats
};
</script>
<?php /**PATH E:\Laravel Projects\Multi Author Blog\resources\views\components\admin-realtime.blade.php ENDPATH**/ ?>