<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Page Title -->
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">DASHBOARD</h1>
    </div>


    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Themes Card -->
        <div class="bg-gradient-to-r from-pink-500 to-pink-600 rounded-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-pink-100 text-sm font-medium">Themes</p>
                    <p class="text-3xl font-bold" id="themes-count">1</p>
                </div>
                <span class="material-symbols-outlined text-4xl text-pink-200">palette</span>
            </div>
        </div>

        <!-- Users Card -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Users</p>
                    <p class="text-3xl font-bold" id="users-count"><?php echo e($stats['total_users'] ?? 0); ?></p>
                </div>
                <span class="material-symbols-outlined text-4xl text-blue-200">group</span>
            </div>
        </div>

        <!-- Posts Card -->
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Posts</p>
                    <p class="text-3xl font-bold" id="posts-count"><?php echo e($stats['total_posts'] ?? 0); ?></p>
                </div>
                <span class="material-symbols-outlined text-4xl text-green-200">article</span>
            </div>
        </div>

        <!-- Comments Card -->
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm font-medium">Comments</p>
                    <p class="text-3xl font-bold" id="comments-count"><?php echo e($stats['total_comments'] ?? 0); ?></p>
                </div>
                <span class="material-symbols-outlined text-4xl text-orange-200">comment</span>
            </div>
        </div>
    </div>

    <!-- Site Analytics Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Site Analytics</h2>
            <select class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option>Today</option>
                <option>This Week</option>
                <option>This Month</option>
            </select>
        </div>

        <!-- Chart Area -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Area Chart -->
            <div class="lg:col-span-2">
                <div class="h-64 bg-gray-50 rounded-lg flex items-center justify-center">
                    <div class="text-center">
                        <span class="material-symbols-outlined text-6xl text-gray-300">bar_chart</span>
                        <p class="text-gray-500 mt-2">Analytics Chart</p>
                        <p class="text-sm text-gray-400">Sessions (Blue) and Visitors (Pink) over 24 hours</p>
                    </div>
                </div>
            </div>

            <!-- World Map -->
            <div class="lg:col-span-1">
                <div class="h-64 bg-gray-50 rounded-lg flex items-center justify-center relative">
                    <div class="text-center">
                        <span class="material-symbols-outlined text-6xl text-gray-300">public</span>
                        <p class="text-gray-500 mt-2">World Map</p>
                        <p class="text-sm text-gray-400">Geographic traffic distribution</p>
                    </div>
                    <!-- Zoom Controls -->
                    <div class="absolute top-2 right-2 flex flex-col space-y-1">
                        <button class="w-8 h-8 bg-white border border-gray-300 rounded flex items-center justify-center hover:bg-gray-50">
                            <span class="material-symbols-outlined text-sm">add</span>
                        </button>
                        <button class="w-8 h-8 bg-white border border-gray-300 rounded flex items-center justify-center hover:bg-gray-50">
                            <span class="material-symbols-outlined text-sm">remove</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Analytics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-6">
            <div class="bg-white border border-gray-200 rounded-lg p-4">
                <div class="flex items-center space-x-3">
                    <span class="material-symbols-outlined text-blue-600">visibility</span>
                    <div>
                        <p class="text-sm text-gray-600">Published Posts</p>
                        <p class="text-xl font-bold text-gray-900" id="published-posts"><?php echo e($stats['published_posts'] ?? 0); ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-lg p-4">
                <div class="flex items-center space-x-3">
                    <span class="material-symbols-outlined text-green-600">group</span>
                    <div>
                        <p class="text-sm text-gray-600">Categories</p>
                        <p class="text-xl font-bold text-gray-900" id="categories-count"><?php echo e($stats['total_categories'] ?? 0); ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-lg p-4">
                <div class="flex items-center space-x-3">
                    <span class="material-symbols-outlined text-purple-600">article</span>
                    <div>
                        <p class="text-sm text-gray-600">Pending Posts</p>
                        <p class="text-xl font-bold text-gray-900" id="pending-posts"><?php echo e($stats['pending_posts'] ?? 0); ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-lg p-4">
                <div class="flex items-center space-x-3">
                    <span class="material-symbols-outlined text-red-600">flash_on</span>
                    <div>
                        <p class="text-sm text-gray-600">Draft Posts</p>
                        <p class="text-xl font-bold text-gray-900" id="draft-posts"><?php echo e($stats['draft_posts'] ?? 0); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Feed -->
    <div class="mb-6">
        <?php echo $__env->make('components.admin-activity-feed', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>

    <!-- Tables Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Posts -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Recent Posts</h3>
                <a href="<?php echo e(route('admin.posts.index')); ?>" class="text-blue-600 hover:underline text-sm">View All</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="text-left py-2 text-sm font-medium text-gray-600">Title</th>
                            <th class="text-left py-2 text-sm font-medium text-gray-600">Author</th>
                            <th class="text-left py-2 text-sm font-medium text-gray-600">Status</th>
                        </tr>
                    </thead>
                    <tbody id="recent-posts-table">
                        <?php $__empty_1 = true; $__currentLoopData = $stats['recent_posts'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="border-b border-gray-100">
                            <td class="py-3 text-sm">
                                <a href="<?php echo e(route('admin.posts.edit', $post->id)); ?>" class="text-blue-600 hover:underline"><?php echo e(Str::limit($post->title, 30)); ?></a>
                            </td>
                            <td class="py-3 text-sm text-gray-900"><?php echo e($post->user->name ?? 'Unknown'); ?></td>
                            <td class="py-3 text-sm">
                                <span class="px-2 py-1 text-xs rounded-full <?php echo e($post->status === 'published' ? 'bg-green-100 text-green-800' : ($post->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')); ?>">
                                    <?php echo e(ucfirst($post->status)); ?>

                                </span>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="3" class="py-8 text-center text-gray-500">No posts found</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Popular Categories -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Popular Categories</h3>
                <a href="<?php echo e(route('admin.categories.index')); ?>" class="text-blue-600 hover:underline text-sm">View All</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="text-left py-2 text-sm font-medium text-gray-600">Category</th>
                            <th class="text-left py-2 text-sm font-medium text-gray-600">Posts</th>
                            <th class="text-left py-2 text-sm font-medium text-gray-600">Status</th>
                        </tr>
                    </thead>
                    <tbody id="popular-categories-table">
                        <?php $__empty_1 = true; $__currentLoopData = $stats['popular_categories'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="border-b border-gray-100">
                            <td class="py-3 text-sm">
                                <a href="<?php echo e(route('admin.categories.edit', $category->id)); ?>" class="text-blue-600 hover:underline"><?php echo e($category->name); ?></a>
                            </td>
                            <td class="py-3 text-sm text-gray-900"><?php echo e($category->posts_count ?? 0); ?></td>
                            <td class="py-3 text-sm">
                                <span class="px-2 py-1 text-xs rounded-full <?php echo e($category->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                    <?php echo e(ucfirst($category->status ?? 'inactive')); ?>

                                </span>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="3" class="py-8 text-center text-gray-500">No categories found</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- System Health -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">System Health</h3>
                <button onclick="clearCache()" class="text-sm bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                    Clear Cache
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center space-x-2">
                        <div id="database-health" class="w-3 h-3 rounded-full bg-green-500" title="Database connected"></div>
                        <span class="text-sm font-medium text-gray-700">Database</span>
                    </div>
                    <span class="text-green-500 text-sm font-medium">Healthy</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center space-x-2">
                        <div id="storage-health" class="w-3 h-3 rounded-full bg-green-500" title="Storage available"></div>
                        <span class="text-sm font-medium text-gray-700">Storage</span>
                    </div>
                    <span class="text-green-500 text-sm font-medium" id="storage-usage">85% Used</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center space-x-2">
                        <div id="cache-health" class="w-3 h-3 rounded-full bg-green-500" title="Cache working"></div>
                        <span class="text-sm font-medium text-gray-700">Cache</span>
                    </div>
                    <span class="text-green-500 text-sm font-medium">Active</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center space-x-2">
                        <div id="queue-health" class="w-3 h-3 rounded-full bg-green-500" title="Queue system available"></div>
                        <span class="text-sm font-medium text-gray-700">Queue</span>
                    </div>
                    <span class="text-green-500 text-sm font-medium">Running</span>
                </div>
            </div>
        </div>

        <!-- Real-time Activity Feed -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Live Activity Feed</h3>
                <div class="flex items-center space-x-2">
                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                    <span class="text-sm text-gray-500">Live</span>
                </div>
            </div>
            <div id="activity-feed" class="space-y-3 max-h-64 overflow-y-auto">
                <!-- Activity items will be loaded here -->
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
class AdminDashboard {
    constructor() {
        this.pusher = null;
        this.channels = {};
        this.init();
    }

    init() {
        this.setupPusher();
        this.startRealTimeUpdates();
        this.loadInitialData();
    }

    setupPusher() {
        if (typeof Pusher !== 'undefined') {
            this.pusher = new Pusher('<?php echo e(config('broadcasting.connections.pusher.key')); ?>', {
                cluster: '<?php echo e(config('broadcasting.connections.pusher.options.cluster')); ?>',
                encrypted: false
            });

            this.channels.admin = this.pusher.subscribe('admin-dashboard');
            this.channels.posts = this.pusher.subscribe('posts');
            this.channels.userActivity = this.pusher.subscribe('user-activity');

            this.bindEvents();
        }
    }

    bindEvents() {
        // Admin dashboard events
        this.channels.admin.bind('stats-updated', (data) => {
            this.updateStats(data);
            this.showNotification('Dashboard updated with latest data', 'success');
        });

        // Post events
        this.channels.posts.bind('post.created', (data) => {
            this.updateStats();
            this.showNotification(`New post created: ${data.post.title}`, 'info');
            this.addActivityItem(data);
        });

        this.channels.posts.bind('post.updated', (data) => {
            this.updateStats();
            this.showNotification(`Post updated: ${data.post.title}`, 'info');
        });

        this.channels.posts.bind('post.deleted', (data) => {
            this.updateStats();
            this.showNotification(`Post deleted: ${data.post.title}`, 'warning');
        });

        // User activity events
        this.channels.userActivity.bind('user.activity', (data) => {
            this.addActivityItem(data);
        });
    }

    startRealTimeUpdates() {
        // Update stats every 30 seconds
        setInterval(() => this.updateStats(), 30000);

        // Update notifications every 60 seconds
        setInterval(() => this.updateNotifications(), 60000);

        // Update system health every 2 minutes
        setInterval(() => this.updateSystemHealth(), 120000);

        // Update activity feed every 10 seconds
        setInterval(() => this.updateActivityFeed(), 10000);
    }

    loadInitialData() {
        this.updateStats();
        this.updateNotifications();
        this.updateSystemHealth();
        this.updateActivityFeed();
    }

    async updateStats() {
        try {
            const response = await fetch('/admin/dashboard/stats');
            const data = await response.json();

            // Update summary cards
            this.updateElement('users-count', data.total_users || 0);
            this.updateElement('posts-count', data.total_posts || 0);
            this.updateElement('comments-count', data.total_comments || 0);

            // Update analytics cards
            this.updateElement('published-posts', data.published_posts || 0);
            this.updateElement('categories-count', data.total_categories || 0);
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

            // Update notification count
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

            // Update system health indicators
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
}

// Initialize dashboard when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.adminDashboard = new AdminDashboard();
});

// Cache clear function
async function clearCache() {
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
            window.adminDashboard.showNotification('Cache cleared successfully', 'success');
        }
    } catch (error) {
        console.error('Error clearing cache:', error);
        window.adminDashboard.showNotification('Error clearing cache', 'error');
    }
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Laravel Projects\Multi Author Blog\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>