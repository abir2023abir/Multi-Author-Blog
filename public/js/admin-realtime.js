/**
 * Comprehensive Real-time Admin System
 * Handles all real-time functionality for the admin panel
 */

class AdminRealtimeSystem {
    constructor() {
        this.pusher = null;
        this.channels = {};
        this.isConnected = false;
        this.reconnectAttempts = 0;
        this.maxReconnectAttempts = 5;
        this.reconnectInterval = 5000;

        this.init();
    }

    init() {
        this.setupPusher();
        this.setupEventListeners();
        this.startHealthChecks();
        this.loadInitialData();
    }

    setupPusher() {
        if (typeof Pusher === 'undefined') {
            console.error('Pusher is not loaded');
            return;
        }

        try {
            this.pusher = new Pusher(window.pusherKey || 'your-pusher-key', {
                cluster: window.pusherCluster || 'us2',
                encrypted: true,
                authEndpoint: '/broadcasting/auth',
                auth: {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }
            });

            this.setupChannels();
            this.bindConnectionEvents();
        } catch (error) {
            console.error('Failed to initialize Pusher:', error);
        }
    }

    setupChannels() {
        // Admin dashboard channel
        this.channels.admin = this.pusher.subscribe('admin-dashboard');

        // Public channels
        this.channels.posts = this.pusher.subscribe('posts');
        this.channels.comments = this.pusher.subscribe('comments');
        this.channels.users = this.pusher.subscribe('users');
        this.channels.activities = this.pusher.subscribe('user-activity');

        // Private channels
        this.channels.privateAdmin = this.pusher.subscribe('private-admin.dashboard');
        this.channels.privatePosts = this.pusher.subscribe('private-admin.posts');
        this.channels.privateUsers = this.pusher.subscribe('private-admin.users');
        this.channels.privateComments = this.pusher.subscribe('private-admin.comments');
        this.channels.privateNotifications = this.pusher.subscribe('private-admin.notifications');

        this.bindChannelEvents();
    }

    bindConnectionEvents() {
        this.pusher.connection.bind('connected', () => {
            this.isConnected = true;
            this.reconnectAttempts = 0;
            this.showConnectionStatus('connected');
            console.log('Pusher connected');
        });

        this.pusher.connection.bind('disconnected', () => {
            this.isConnected = false;
            this.showConnectionStatus('disconnected');
            console.log('Pusher disconnected');
        });

        this.pusher.connection.bind('error', (error) => {
            console.error('Pusher connection error:', error);
            this.handleConnectionError();
        });
    }

    bindChannelEvents() {
        // Admin dashboard events
        this.channels.admin.bind('stats-updated', (data) => {
            this.updateDashboardStats(data);
            this.showNotification('Dashboard updated with latest data', 'success');
        });

        this.channels.admin.bind('system-health-updated', (data) => {
            this.updateSystemHealth(data);
        });

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

        // Comment events
        this.channels.comments.bind('comment.created', (data) => {
            this.handleCommentCreated(data);
        });

        this.channels.comments.bind('comment.approved', (data) => {
            this.handleCommentApproved(data);
        });

        this.channels.comments.bind('comment.rejected', (data) => {
            this.handleCommentRejected(data);
        });

        // User events
        this.channels.users.bind('user.created', (data) => {
            this.handleUserCreated(data);
        });

        this.channels.users.bind('user.updated', (data) => {
            this.handleUserUpdated(data);
        });

        this.channels.users.bind('user.deleted', (data) => {
            this.handleUserDeleted(data);
        });

        // Activity events
        this.channels.activities.bind('user.activity', (data) => {
            this.handleUserActivity(data);
        });

        // Private admin events
        this.channels.privateAdmin.bind('admin.stats-updated', (data) => {
            this.updateDashboardStats(data);
        });

        this.channels.privateAdmin.bind('admin.notification', (data) => {
            this.handleAdminNotification(data);
        });

        this.channels.privateNotifications.bind('notification.created', (data) => {
            this.handleNotificationCreated(data);
        });
    }

    setupEventListeners() {
        // Global keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            if (e.ctrlKey || e.metaKey) {
                switch (e.key) {
                    case 'k':
                        e.preventDefault();
                        this.openQuickSearch();
                        break;
                    case 'r':
                        e.preventDefault();
                        this.refreshDashboard();
                        break;
                }
            }
        });

        // Window focus/blur events
        window.addEventListener('focus', () => {
            this.refreshDashboard();
        });

        window.addEventListener('beforeunload', () => {
            this.cleanup();
        });
    }

    startHealthChecks() {
        // Check connection every 30 seconds
        setInterval(() => {
            this.checkConnectionHealth();
        }, 30000);

        // Update dashboard stats every 60 seconds
        setInterval(() => {
            this.updateDashboardStats();
        }, 60000);

        // Update notifications every 30 seconds
        setInterval(() => {
            this.updateNotifications();
        }, 30000);
    }

    loadInitialData() {
        this.updateDashboardStats();
        this.updateNotifications();
        this.updateSystemHealth();
        this.updateActivityFeed();
    }

    async updateDashboardStats(data = null) {
        try {
            if (!data) {
                const response = await fetch('/admin/dashboard/stats');
                data = await response.json();
            }

            // Update summary cards
            this.updateElement('users-count', data.total_users || 0);
            this.updateElement('posts-count', data.total_posts || 0);
            this.updateElement('comments-count', data.total_comments || 0);
            this.updateElement('categories-count', data.total_categories || 0);

            // Update analytics cards
            this.updateElement('published-posts', data.published_posts || 0);
            this.updateElement('pending-posts', data.pending_posts || 0);
            this.updateElement('draft-posts', data.draft_posts || 0);

        } catch (error) {
            console.error('Error updating dashboard stats:', error);
        }
    }

    async updateNotifications() {
        try {
            const response = await fetch('/admin/dashboard/notifications');
            const data = await response.json();

            const notificationCount = document.getElementById('notification-count');
            if (notificationCount) {
                const total = (data.new_posts || 0) + (data.new_comments || 0) + (data.new_users || 0);
                notificationCount.textContent = total;
                notificationCount.style.display = total > 0 ? 'flex' : 'none';
            }
        } catch (error) {
            console.error('Error updating notifications:', error);
        }
    }

    async updateSystemHealth() {
        try {
            const response = await fetch('/admin/dashboard/health');
            const data = await response.json();

            this.updateHealthIndicator('database', data.database);
            this.updateHealthIndicator('storage', data.storage);
            this.updateHealthIndicator('cache', data.cache);
            this.updateHealthIndicator('queue', data.queue);
        } catch (error) {
            console.error('Error updating system health:', error);
        }
    }

    async updateActivityFeed() {
        try {
            const response = await fetch('/admin/dashboard/activity');
            const activities = await response.json();

            const activityFeed = document.getElementById('activity-feed');
            if (activityFeed && activities.length > 0) {
                activityFeed.innerHTML = activities.map(activity => `
                    <div class="flex items-center space-x-3 p-3 bg-white dark:bg-gray-800 rounded-lg">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                <span class="text-white text-sm font-medium">
                                    ${activity.user ? activity.user.name.charAt(0) : 'S'}
                                </span>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-gray-900 dark:text-white">
                                <span class="font-medium">${activity.user ? activity.user.name : 'System'}</span>
                                ${activity.description}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">${activity.created_at}</p>
                        </div>
                    </div>
                `).join('');
            }
        } catch (error) {
            console.error('Error updating activity feed:', error);
        }
    }

    // Event Handlers
    handlePostCreated(data) {
        this.updateDashboardStats();
        this.showNotification(`New post created: ${data.post.title}`, 'info');
        this.addActivityItem(data);
    }

    handlePostUpdated(data) {
        this.updateDashboardStats();
        this.showNotification(`Post updated: ${data.post.title}`, 'info');
    }

    handlePostDeleted(data) {
        this.updateDashboardStats();
        this.showNotification(`Post deleted: ${data.post.title}`, 'warning');
    }

    handleCommentCreated(data) {
        this.updateDashboardStats();
        this.showNotification(`New comment on: ${data.post.title}`, 'info');
        this.addActivityItem(data);
    }

    handleCommentApproved(data) {
        this.showNotification(`Comment approved on: ${data.post.title}`, 'success');
    }

    handleCommentRejected(data) {
        this.showNotification(`Comment rejected on: ${data.post.title}`, 'warning');
    }

    handleUserCreated(data) {
        this.updateDashboardStats();
        this.showNotification(`New user registered: ${data.user.name}`, 'info');
        this.addActivityItem(data);
    }

    handleUserUpdated(data) {
        this.showNotification(`User updated: ${data.user.name}`, 'info');
    }

    handleUserDeleted(data) {
        this.updateDashboardStats();
        this.showNotification(`User deleted: ${data.user.name}`, 'warning');
    }

    handleUserActivity(data) {
        this.addActivityItem(data);
    }

    handleAdminNotification(data) {
        this.showNotification(data.message, data.type || 'info');
    }

    handleNotificationCreated(data) {
        this.updateNotifications();
        this.showNotification(data.message, data.type || 'info');
    }

    // Utility Methods
    updateElement(id, value) {
        const element = document.getElementById(id);
        if (element) {
            element.textContent = value;
        }
    }

    updateHealthIndicator(type, health) {
        const indicator = document.getElementById(`${type}-health`);
        if (indicator) {
            indicator.className = `w-3 h-3 rounded-full ${
                health.status === 'healthy' ? 'bg-green-500' :
                health.status === 'warning' ? 'bg-yellow-500' : 'bg-red-500'
            }`;
            indicator.title = health.message;
        }
    }

    addActivityItem(data) {
        const activityFeed = document.getElementById('activity-feed');
        if (activityFeed) {
            const activityItem = document.createElement('div');
            activityItem.className = 'flex items-center space-x-3 p-3 bg-white dark:bg-gray-800 rounded-lg';
            activityItem.innerHTML = `
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                        <span class="text-white text-sm font-medium">${data.user ? data.user.name.charAt(0) : 'S'}</span>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm text-gray-900 dark:text-white">
                        <span class="font-medium">${data.user ? data.user.name : 'System'}</span> ${data.activity || data.description}
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">${new Date().toLocaleTimeString()}</p>
                </div>
            `;
            activityFeed.insertBefore(activityItem, activityFeed.firstChild);

            // Keep only last 10 activities
            while (activityFeed.children.length > 10) {
                activityFeed.removeChild(activityFeed.lastChild);
            }
        }
    }

    showNotification(message, type = 'info') {
        // Use the new notification system if available
        if (window.adminNotifications) {
            return window.adminNotifications.show(message, type);
        }

        // Fallback to original implementation
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 ${this.getNotificationClass(type)}`;
        notification.innerHTML = `
            <div class="flex items-center space-x-2">
                <span class="material-symbols-outlined">${this.getNotificationIcon(type)}</span>
                <span>${message}</span>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-2 text-gray-500 hover:text-gray-700">
                    <span class="material-symbols-outlined text-sm">close</span>
                </button>
            </div>
        `;

        document.body.appendChild(notification);

        setTimeout(() => {
            if (notification.parentElement) {
                notification.remove();
            }
        }, 5000);
    }

    getNotificationClass(type) {
        const classes = {
            'success': 'bg-green-100 text-green-800 border border-green-200',
            'info': 'bg-blue-100 text-blue-800 border border-blue-200',
            'warning': 'bg-yellow-100 text-yellow-800 border border-yellow-200',
            'error': 'bg-red-100 text-red-800 border border-red-200'
        };
        return classes[type] || classes['info'];
    }

    getNotificationIcon(type) {
        const icons = {
            'success': 'check_circle',
            'info': 'info',
            'warning': 'warning',
            'error': 'error'
        };
        return icons[type] || icons['info'];
    }

    showConnectionStatus(status) {
        const statusElement = document.getElementById('connection-status');
        if (statusElement) {
            statusElement.className = `w-2 h-2 rounded-full ${
                status === 'connected' ? 'bg-green-500' : 'bg-red-500'
            }`;
            statusElement.title = status === 'connected' ? 'Connected' : 'Disconnected';
        }
    }

    checkConnectionHealth() {
        if (!this.isConnected && this.reconnectAttempts < this.maxReconnectAttempts) {
            this.reconnectAttempts++;
            setTimeout(() => {
                this.setupPusher();
            }, this.reconnectInterval);
        }
    }

    handleConnectionError() {
        this.isConnected = false;
        this.showConnectionStatus('disconnected');

        if (this.reconnectAttempts < this.maxReconnectAttempts) {
            this.reconnectAttempts++;
            setTimeout(() => {
                this.setupPusher();
            }, this.reconnectInterval);
        }
    }

    openQuickSearch() {
        // Implement quick search functionality
        console.log('Quick search opened');
    }

    refreshDashboard() {
        this.updateDashboardStats();
        this.updateNotifications();
        this.updateSystemHealth();
        this.updateActivityFeed();
    }

    cleanup() {
        if (this.pusher) {
            this.pusher.disconnect();
        }
    }
}

// Initialize the real-time system when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.adminRealtime = new AdminRealtimeSystem();
});

// Global functions for use in templates
window.clearCache = async function() {
    try {
        const response = await fetch('/admin/dashboard/cache/clear', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        });

        const result = await response.json();
        if (result.status === 'success') {
            window.adminRealtime.showNotification('Cache cleared successfully', 'success');
        }
    } catch (error) {
        console.error('Error clearing cache:', error);
        window.adminRealtime.showNotification('Error clearing cache', 'error');
    }
};

window.refreshDashboard = function() {
    if (window.adminRealtime) {
        window.adminRealtime.refreshDashboard();
    }
};
