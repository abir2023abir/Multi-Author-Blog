// Real-time functionality for the admin panel
class RealtimeManager {
    constructor() {
        this.pusher = null;
        this.channels = {};
        this.init();
    }

    init() {
        // Initialize Pusher with configuration from Laravel
        if (typeof Pusher !== 'undefined') {
            this.pusher = new Pusher(import.meta.env.VITE_PUSHER_APP_KEY, {
                cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
                wsHost: import.meta.env.VITE_PUSHER_HOST,
                wsPort: import.meta.env.VITE_PUSHER_PORT,
                wssPort: import.meta.env.VITE_PUSHER_PORT,
                forceTLS: false,
                enabledTransports: ['ws', 'wss'],
            });

            this.setupChannels();
        }
    }

    setupChannels() {
        // Posts channel
        this.channels.posts = this.pusher.subscribe('posts');
        
        // Admin posts channel
        this.channels.adminPosts = this.pusher.subscribe('private-admin.posts');
        
        // User activity channel
        this.channels.userActivity = this.pusher.subscribe('user-activity');
        
        // Admin activity channel
        this.channels.adminActivity = this.pusher.subscribe('private-admin.activity');
        
        // Admin notifications channel
        this.channels.adminNotifications = this.pusher.subscribe('private-admin.notifications');

        this.bindEvents();
    }

    bindEvents() {
        // Post events
        this.channels.posts.bind('post.created', (data) => {
            this.handlePostCreated(data);
        });

        this.channels.posts.bind('post.updated', (data) => {
            this.handlePostUpdated(data);
        });

        this.channels.posts.bind('post.deleted', (data) => {
            this.handlePostDeleted(data);
        });

        // User activity events
        this.channels.userActivity.bind('user.activity', (data) => {
            this.handleUserActivity(data);
        });

        // Admin notifications
        this.channels.adminNotifications.bind('notification.sent', (data) => {
            this.handleNotification(data);
        });
    }

    handlePostCreated(data) {
        this.showNotification('New Post Created', data.message, 'success');
        this.updatePostsTable(data);
        this.updateDashboardStats();
    }

    handlePostUpdated(data) {
        this.showNotification('Post Updated', data.message, 'info');
        this.updatePostsTable(data);
    }

    handlePostDeleted(data) {
        this.showNotification('Post Deleted', data.message, 'warning');
        this.removePostFromTable(data.post_id);
        this.updateDashboardStats();
    }

    handleUserActivity(data) {
        this.updateActivityFeed(data);
    }

    handleNotification(data) {
        this.showNotification('Notification', data.notification, data.type);
    }

    showNotification(title, message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 max-w-sm w-full bg-white dark:bg-gray-800 shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden`;
        
        const colors = {
            success: 'border-l-4 border-green-400 bg-green-50 dark:bg-green-900',
            error: 'border-l-4 border-red-400 bg-red-50 dark:bg-red-900',
            warning: 'border-l-4 border-yellow-400 bg-yellow-50 dark:bg-yellow-900',
            info: 'border-l-4 border-blue-400 bg-blue-50 dark:bg-blue-900'
        };

        notification.innerHTML = `
            <div class="p-4 ${colors[type] || colors.info}">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <span class="material-symbols-outlined text-${type === 'success' ? 'green' : type === 'error' ? 'red' : type === 'warning' ? 'yellow' : 'blue'}-400">
                            ${type === 'success' ? 'check_circle' : type === 'error' ? 'error' : type === 'warning' ? 'warning' : 'info'}
                        </span>
                    </div>
                    <div class="ml-3 w-0 flex-1">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">${title}</p>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">${message}</p>
                    </div>
                    <div class="ml-4 flex-shrink-0 flex">
                        <button class="bg-white dark:bg-gray-800 rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none" onclick="this.parentElement.parentElement.parentElement.parentElement.remove()">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>
                </div>
            </div>
        `;

        document.body.appendChild(notification);

        // Auto remove after 5 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 5000);
    }

    updatePostsTable(data) {
        // Update the posts table if we're on a posts page
        if (window.location.pathname.includes('/admin/posts')) {
            // Refresh the page or update specific rows
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        }
    }

    removePostFromTable(postId) {
        // Remove post row from table
        const row = document.querySelector(`tr[data-post-id="${postId}"]`);
        if (row) {
            row.remove();
        }
    }

    updateDashboardStats() {
        // Update dashboard statistics
        if (window.location.pathname.includes('/admin/dashboard')) {
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        }
    }

    updateActivityFeed(data) {
        // Update activity feed
        const activityFeed = document.getElementById('activity-feed');
        if (activityFeed) {
            const activityItem = document.createElement('div');
            activityItem.className = 'flex items-center space-x-3 p-3 bg-white dark:bg-gray-800 rounded-lg';
            activityItem.innerHTML = `
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                        <span class="text-white text-sm font-medium">${data.user.name.charAt(0)}</span>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm text-gray-900 dark:text-white">
                        <span class="font-medium">${data.user.name}</span> ${data.activity}
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">${new Date(data.timestamp).toLocaleTimeString()}</p>
                </div>
            `;
            activityFeed.insertBefore(activityItem, activityFeed.firstChild);
            
            // Keep only last 10 activities
            while (activityFeed.children.length > 10) {
                activityFeed.removeChild(activityFeed.lastChild);
            }
        }
    }
}

// Initialize real-time manager when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.realtimeManager = new RealtimeManager();
});

// Export for use in other scripts
export default RealtimeManager;
