<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Admin Dashboard - Multi Author Blog Web</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        "primary": "#1173d4",
                        "sidebar": "#111a22",
                        "sidebar-hover": "#233648",
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
                    },
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings:
                'FILL' 0,
                'wght' 400,
                'GRAD' 0,
                'opsz' 24
        }

        /* Fix sidebar visual issues */
        .sidebar-nav {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .sidebar-nav::-webkit-scrollbar {
            display: none;
        }

        /* Ensure proper icon rendering */
        .material-symbols-outlined {
            font-family: 'Material Symbols Outlined';
            font-weight: normal;
            font-style: normal;
            font-size: 24px;
            line-height: 1;
            letter-spacing: normal;
            text-transform: none;
            display: inline-block;
            white-space: nowrap;
            word-wrap: normal;
            direction: ltr;
            -webkit-font-feature-settings: 'liga';
            -webkit-font-smoothing: antialiased;
        }

        /* Fix hover states */
        .nav-item {
            transition: all 0.2s ease-in-out;
        }

        .nav-item:hover {
            background-color: #233648;
            transform: translateX(2px);
        }

        /* Fix submenu animations */
        .submenu {
            transition: all 0.3s ease-in-out;
            transform-origin: top;
        }

        .submenu.hidden {
            opacity: 0;
            transform: scaleY(0);
            max-height: 0;
        }

        .submenu:not(.hidden) {
            opacity: 1;
            transform: scaleY(1);
            max-height: 200px;
        }

        /* Fix arrow rotations */
        .arrow-rotate {
            transition: transform 0.2s ease-in-out;
        }

        .arrow-rotate.rotated {
            transform: rotate(180deg);
        }

        /* Ensure proper spacing */
        .nav-item {
            margin-bottom: 2px;
        }

        .submenu-item {
            margin-left: 24px;
            padding-left: 12px;
            border-left: 2px solid transparent;
            transition: all 0.2s ease-in-out;
        }

        .submenu-item:hover {
            border-left-color: #1173d4;
            background-color: #1a2a3a;
        }

        /* Fix notification badges */
        .notification-badge {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

        /* Fix logo and branding */
        .logo-container {
            transition: all 0.2s ease-in-out;
        }

        .logo-container:hover {
            transform: scale(1.05);
        }
    </style>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <!-- Pusher for Real-time -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <!-- Alpine.js for interactivity -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Admin Real-time System -->
    <script>
        window.pusherKey = '<?php echo e(config('broadcasting.connections.pusher.key')); ?>';
        window.pusherCluster = '<?php echo e(config('broadcasting.connections.pusher.options.cluster')); ?>';
    </script>
    <script>
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
    </script>
</head>
<body class="bg-gray-50 font-display">
<div class="flex h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-[#111a22] flex flex-col">
        <!-- Logo -->
        <div class="p-6 border-b border-gray-700 logo-container">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-white rounded flex items-center justify-center">
                    <span class="text-[#111a22] font-bold text-sm">S</span>
                </div>
                <h1 class="text-white text-xl font-bold">Multi Author Blog Web</h1>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 p-4 space-y-2 sidebar-nav overflow-y-auto">
            <!-- Dashboard -->
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-item flex items-center space-x-3 px-3 py-2 rounded-lg <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-[#233648]' : 'hover:bg-[#233648]'); ?>">
                <span class="material-symbols-outlined text-white text-lg">home</span>
                <span class="text-white text-sm font-medium">Dashboard</span>
            </a>

            <!-- Pages -->
            <a href="<?php echo e(route('admin.pages.index')); ?>" class="nav-item flex items-center space-x-3 px-3 py-2 rounded-lg <?php echo e(request()->routeIs('admin.pages.*') ? 'bg-[#233648]' : 'hover:bg-[#233648]'); ?>">
                <span class="material-symbols-outlined text-white text-lg">description</span>
                <span class="text-white text-sm font-medium">Pages</span>
            </a>

            <!-- Blog -->
            <a href="<?php echo e(route('admin.posts.index')); ?>" class="nav-item flex items-center space-x-3 px-3 py-2 rounded-lg <?php echo e(request()->routeIs('admin.posts.*') ? 'bg-[#233648]' : 'hover:bg-[#233648]'); ?>">
                <span class="material-symbols-outlined text-white text-lg">article</span>
                <span class="text-white text-sm font-medium">Blog</span>
            </a>

            <!-- Add Post -->
            <a href="<?php echo e(route('admin.posts.add')); ?>" class="nav-item flex items-center space-x-3 px-3 py-2 rounded-lg <?php echo e(request()->routeIs('admin.posts.add*') ? 'bg-[#233648]' : 'hover:bg-[#233648]'); ?>">
                <span class="material-symbols-outlined text-white text-lg">add_box</span>
                <span class="text-white text-sm font-medium">Add Post</span>
            </a>

            <!-- Galleries -->
            <div class="nav-item flex items-center justify-between px-3 py-2 rounded-lg hover:bg-[#233648] cursor-pointer" onclick="toggleSubmenu('galleries')">
                <div class="flex items-center space-x-3">
                    <span class="material-symbols-outlined text-white text-lg">photo_library</span>
                    <span class="text-white text-sm font-medium">Galleries</span>
                </div>
                <span id="galleries-arrow" class="material-symbols-outlined text-white text-lg arrow-rotate">keyboard_arrow_down</span>
            </div>
            <div id="galleries-submenu" class="submenu ml-6 space-y-1 hidden">
                <a href="<?php echo e(route('admin.galleries.index')); ?>" class="submenu-item flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-[#233648]">
                    <span class="material-symbols-outlined text-white text-sm">photo</span>
                    <span class="text-white text-xs">All Galleries</span>
                </a>
                <a href="<?php echo e(route('admin.galleries.create')); ?>" class="submenu-item flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-[#233648]">
                    <span class="material-symbols-outlined text-white text-sm">add</span>
                    <span class="text-white text-xs">Add Gallery</span>
                </a>
            </div>

            <!-- Ads -->
            <div class="nav-item flex items-center justify-between px-3 py-2 rounded-lg hover:bg-[#233648] cursor-pointer" onclick="toggleSubmenu('ads')">
                <div class="flex items-center space-x-3">
                    <span class="material-symbols-outlined text-white text-lg">campaign</span>
                    <span class="text-white text-sm font-medium">Ads</span>
                </div>
                <span id="ads-arrow" class="material-symbols-outlined text-white text-lg arrow-rotate">keyboard_arrow_down</span>
            </div>
            <div id="ads-submenu" class="submenu ml-6 space-y-1 hidden">
                <a href="<?php echo e(route('admin.ads.index')); ?>" class="submenu-item flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-[#233648]">
                    <span class="material-symbols-outlined text-white text-sm">campaign</span>
                    <span class="text-white text-xs">All Ads</span>
                </a>
                <a href="<?php echo e(route('admin.ads.create')); ?>" class="submenu-item flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-[#233648]">
                    <span class="material-symbols-outlined text-white text-sm">add</span>
                    <span class="text-white text-xs">Add Ad</span>
                </a>
            </div>

            <!-- Announcements -->
            <a href="<?php echo e(route('admin.announcements.index')); ?>" class="nav-item flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-[#233648]">
                <span class="material-symbols-outlined text-white text-lg">campaign</span>
                <span class="text-white text-sm font-medium">Announcements</span>
            </a>

            <!-- Comments -->
            <a href="<?php echo e(route('admin.comments.index')); ?>" class="nav-item flex items-center space-x-3 px-3 py-2 rounded-lg <?php echo e(request()->routeIs('admin.comments.*') ? 'bg-[#233648]' : 'hover:bg-[#233648]'); ?>">
                <span class="material-symbols-outlined text-white text-lg">comment</span>
                <span class="text-white text-sm font-medium">Comments</span>
            </a>

            <!-- Users -->
            <a href="<?php echo e(route('admin.users.index')); ?>" class="nav-item flex items-center space-x-3 px-3 py-2 rounded-lg <?php echo e(request()->routeIs('admin.users.*') ? 'bg-[#233648]' : 'hover:bg-[#233648]'); ?>">
                <span class="material-symbols-outlined text-white text-lg">group</span>
                <span class="text-white text-sm font-medium">Users</span>
            </a>

            <!-- Categories -->
            <a href="<?php echo e(route('admin.categories.index')); ?>" class="nav-item flex items-center space-x-3 px-3 py-2 rounded-lg <?php echo e(request()->routeIs('admin.categories.*') ? 'bg-[#233648]' : 'hover:bg-[#233648]'); ?>">
                <span class="material-symbols-outlined text-white text-lg">category</span>
                <span class="text-white text-sm font-medium">Categories</span>
            </a>

            <!-- Contact -->
            <div class="nav-item flex items-center justify-between px-3 py-2 rounded-lg hover:bg-[#233648] cursor-pointer relative" onclick="toggleSubmenu('contact')">
                <div class="flex items-center space-x-3">
                    <span class="material-symbols-outlined text-white text-lg">mail</span>
                    <span class="text-white text-sm font-medium">Contact</span>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="bg-blue-500 text-white text-xs px-2 py-1 rounded-full notification-badge">7</span>
                    <span id="contact-arrow" class="material-symbols-outlined text-white text-lg arrow-rotate">keyboard_arrow_down</span>
                </div>
            </div>
            <div id="contact-submenu" class="submenu ml-6 space-y-1 hidden">
                <a href="#" class="submenu-item flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-[#233648]">
                    <span class="material-symbols-outlined text-white text-sm">mail</span>
                    <span class="text-white text-xs">All Messages</span>
                </a>
                <a href="#" class="submenu-item flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-[#233648]">
                    <span class="material-symbols-outlined text-white text-sm">reply</span>
                    <span class="text-white text-xs">Replied</span>
                </a>
            </div>

            <!-- Newsletters -->
            <a href="<?php echo e(route('admin.newsletters.index')); ?>" class="nav-item flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-[#233648]">
                <span class="material-symbols-outlined text-white text-lg">mail</span>
                <span class="text-white text-sm font-medium">Newsletters</span>
            </a>

            <!-- Media -->
            <a href="<?php echo e(route('admin.media.index')); ?>" class="nav-item flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-[#233648]">
                <span class="material-symbols-outlined text-white text-lg">folder</span>
                <span class="text-white text-sm font-medium">Media</span>
            </a>

            <!-- Appearance -->
            <div class="nav-item flex items-center justify-between px-3 py-2 rounded-lg hover:bg-[#233648] cursor-pointer" onclick="toggleSubmenu('appearance')">
                <div class="flex items-center space-x-3">
                    <span class="material-symbols-outlined text-white text-lg">palette</span>
                    <span class="text-white text-sm font-medium">Appearance</span>
                </div>
                <span id="appearance-arrow" class="material-symbols-outlined text-white text-lg arrow-rotate">keyboard_arrow_down</span>
            </div>
            <div id="appearance-submenu" class="submenu ml-6 space-y-1 hidden">
                <a href="<?php echo e(route('admin.themes.index')); ?>" class="submenu-item flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-[#233648]">
                    <span class="material-symbols-outlined text-white text-sm">palette</span>
                    <span class="text-white text-xs">Themes</span>
                </a>
                <a href="#" class="submenu-item flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-[#233648]">
                    <span class="material-symbols-outlined text-white text-sm">widgets</span>
                    <span class="text-white text-xs">Widgets</span>
                </a>
            </div>

            <!-- Plugins -->
            <div class="nav-item flex items-center justify-between px-3 py-2 rounded-lg hover:bg-[#233648] cursor-pointer" onclick="toggleSubmenu('plugins')">
                <div class="flex items-center space-x-3">
                    <span class="material-symbols-outlined text-white text-lg">extension</span>
                    <span class="text-white text-sm font-medium">Plugins</span>
                </div>
                <span id="plugins-arrow" class="material-symbols-outlined text-white text-lg arrow-rotate">keyboard_arrow_down</span>
            </div>
            <div id="plugins-submenu" class="submenu ml-6 space-y-1 hidden">
                <a href="<?php echo e(route('admin.plugins.index')); ?>" class="submenu-item flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-[#233648]">
                    <span class="material-symbols-outlined text-white text-sm">extension</span>
                    <span class="text-white text-xs">All Plugins</span>
                </a>
                <a href="<?php echo e(route('admin.plugins.create')); ?>" class="submenu-item flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-[#233648]">
                    <span class="material-symbols-outlined text-white text-sm">add</span>
                    <span class="text-white text-xs">Add Plugin</span>
                </a>
            </div>

            <!-- Tools -->
            <div class="nav-item flex items-center justify-between px-3 py-2 rounded-lg hover:bg-[#233648] cursor-pointer" onclick="toggleSubmenu('tools')">
                <div class="flex items-center space-x-3">
                    <span class="material-symbols-outlined text-white text-lg">build</span>
                    <span class="text-white text-sm font-medium">Tools</span>
                </div>
                <span id="tools-arrow" class="material-symbols-outlined text-white text-lg arrow-rotate">keyboard_arrow_down</span>
            </div>
            <div id="tools-submenu" class="submenu ml-6 space-y-1 hidden">
                <a href="<?php echo e(route('admin.tools.index')); ?>" class="submenu-item flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-[#233648]">
                    <span class="material-symbols-outlined text-white text-sm">backup</span>
                    <span class="text-white text-xs">Backup</span>
                </a>
                <a href="<?php echo e(route('admin.tools.index')); ?>" class="submenu-item flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-[#233648]">
                    <span class="material-symbols-outlined text-white text-sm">restore</span>
                    <span class="text-white text-xs">Restore</span>
                </a>
            </div>

            <!-- Settings -->
            <a href="<?php echo e(route('admin.settings.index')); ?>" class="nav-item flex items-center space-x-3 px-3 py-2 rounded-lg <?php echo e(request()->routeIs('admin.settings.*') ? 'bg-[#233648]' : 'hover:bg-[#233648]'); ?>">
                <span class="material-symbols-outlined text-white text-lg">settings</span>
                <span class="text-white text-sm font-medium">Settings</span>
            </a>

            <!-- Platform Administration -->
            <a href="<?php echo e(route('admin.platform-admin.index')); ?>" class="nav-item flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-[#233648]">
                <span class="material-symbols-outlined text-white text-lg">admin_panel_settings</span>
                <span class="text-white text-sm font-medium">Platform Administration</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <!-- Header -->
        <header class="bg-white border-b border-gray-200 px-6 py-4">
            <div class="flex items-center justify-between">
                <!-- Left Side -->
                <div class="flex items-center space-x-4">
                    <button class="p-2 hover:bg-gray-100 rounded-lg">
                        <span class="material-symbols-outlined text-gray-600">menu</span>
                    </button>
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-[#111a22] rounded flex items-center justify-center">
                            <span class="text-white font-bold text-sm">S</span>
                        </div>
                        <h1 class="text-xl font-bold text-[#111a22]">Multi Author Blog Web</h1>
                    </div>
                </div>

                <!-- Center - Search -->
                <div class="flex-1 max-w-md mx-8">
                    <div class="relative">
                        <input type="text" placeholder="Search" class="w-full px-4 py-2 pl-10 bg-gray-100 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">search</span>
                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                            <span class="text-xs text-gray-400 bg-gray-200 px-2 py-1 rounded">ctrl/cmd + k</span>
                        </div>
                    </div>
                </div>

                <!-- Right Side -->
                <div class="flex items-center space-x-4">
                    <!-- View Website -->
                    <a href="<?php echo e(route('home')); ?>" target="_blank" class="flex items-center space-x-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <span class="material-symbols-outlined text-sm">language</span>
                        <span class="text-sm font-medium">View website</span>
                    </a>

                    <!-- Dark Mode Toggle -->
                    <button onclick="toggleDarkMode()" class="p-2 hover:bg-gray-100 rounded-lg transition-colors" id="dark-mode-toggle">
                        <span class="material-symbols-outlined text-gray-600" id="dark-mode-icon">dark_mode</span>
                    </button>

                    <!-- Notifications -->
                    <div class="relative">
                        <button onclick="toggleNotifications()" class="p-2 hover:bg-gray-100 rounded-lg relative transition-colors">
                            <span class="material-symbols-outlined text-gray-600">notifications</span>
                            <span class="absolute -top-1 -right-1 bg-blue-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center" id="notification-count">0</span>
                        </button>

                        <!-- Notifications Dropdown -->
                        <div id="notifications-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-white dark:bg-gray-700 rounded-lg shadow-lg border border-gray-200 dark:border-gray-600 z-50">
                            <div class="p-4 border-b border-gray-200 dark:border-gray-600">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Notifications</h3>
                            </div>
                            <div class="max-h-96 overflow-y-auto" id="notifications-list">
                                <div class="p-4 text-center text-gray-500 dark:text-gray-400" id="no-notifications">
                                    No new notifications
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Messages -->
                    <div class="relative">
                        <button onclick="toggleMessages()" class="p-2 hover:bg-gray-100 rounded-lg relative transition-colors">
                            <span class="material-symbols-outlined text-gray-600">mail</span>
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center" id="message-count">7</span>
                        </button>

                        <!-- Messages Dropdown -->
                        <div id="messages-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-white dark:bg-gray-700 rounded-lg shadow-lg border border-gray-200 dark:border-gray-600 z-50">
                            <div class="p-4 border-b border-gray-200 dark:border-gray-600">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Messages</h3>
                            </div>
                            <div class="max-h-96 overflow-y-auto" id="messages-list">
                                <div class="p-4 text-center text-gray-500 dark:text-gray-400">
                                    No new messages
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- User Profile Dropdown -->
                    <div class="relative">
                        <button onclick="toggleProfileDropdown()" class="flex items-center space-x-3 hover:bg-gray-100 rounded-lg p-2">
                            <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode(auth()->user()->name)); ?>&background=random" alt="Profile" class="w-8 h-8 rounded-full">
                            <div class="text-sm text-left">
                                <div class="font-medium text-gray-900"><?php echo e(auth()->user()->name); ?></div>
                                <div class="text-gray-500"><?php echo e(auth()->user()->email); ?></div>
                            </div>
                            <span class="material-symbols-outlined text-gray-500">keyboard_arrow_down</span>
                        </button>

                        <!-- Profile Dropdown -->
                        <div id="profileDropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 hidden z-50">
                            <div class="py-1">
                                <a href="<?php echo e(route('profile.edit')); ?>" class="flex items-center space-x-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <span class="material-symbols-outlined text-lg">person</span>
                                    <span>Profile</span>
                                </a>
                                <form method="POST" action="<?php echo e(route('logout')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="flex items-center space-x-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full text-left">
                                        <span class="material-symbols-outlined text-lg">logout</span>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="flex-1 p-6 bg-gray-50">
            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>
</div>

<!-- Image Selector Component -->
<?php echo $__env->make('components.image-selector', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<script>
function toggleSubmenu(menuName) {
    const submenu = document.getElementById(menuName + '-submenu');
    const arrow = document.getElementById(menuName + '-arrow');

    if (submenu.classList.contains('hidden')) {
        submenu.classList.remove('hidden');
        arrow.classList.add('rotated');
    } else {
        submenu.classList.add('hidden');
        arrow.classList.remove('rotated');
    }
}

function toggleProfileDropdown() {
    const dropdown = document.getElementById('profileDropdown');
    dropdown.classList.toggle('hidden');
}

function toggleNotifications() {
    const dropdown = document.getElementById('notifications-dropdown');
    dropdown.classList.toggle('hidden');

    // Close messages dropdown if open
    const messagesDropdown = document.getElementById('messages-dropdown');
    messagesDropdown.classList.add('hidden');
}

function toggleMessages() {
    const dropdown = document.getElementById('messages-dropdown');
    dropdown.classList.toggle('hidden');

    // Close notifications dropdown if open
    const notificationsDropdown = document.getElementById('notifications-dropdown');
    notificationsDropdown.classList.add('hidden');
}

function toggleDarkMode() {
    const html = document.documentElement;
    const darkModeIcon = document.getElementById('dark-mode-icon');
    const isDark = html.classList.contains('dark');

    if (isDark) {
        html.classList.remove('dark');
        darkModeIcon.textContent = 'dark_mode';
        localStorage.setItem('darkMode', 'false');
    } else {
        html.classList.add('dark');
        darkModeIcon.textContent = 'light_mode';
        localStorage.setItem('darkMode', 'true');
    }
}

// Initialize dark mode from localStorage
document.addEventListener('DOMContentLoaded', function() {
    const darkMode = localStorage.getItem('darkMode');
    const darkModeIcon = document.getElementById('dark-mode-icon');

    if (darkMode === 'true') {
        document.documentElement.classList.add('dark');
        darkModeIcon.textContent = 'light_mode';
    }
});

// Close dropdowns when clicking outside
document.addEventListener('click', function(event) {
    const profileDropdown = document.getElementById('profileDropdown');
    const profileButton = event.target.closest('[onclick="toggleProfileDropdown()"]');

    if (!profileButton && !profileDropdown.contains(event.target)) {
        profileDropdown.classList.add('hidden');
    }

    const notificationsDropdown = document.getElementById('notifications-dropdown');
    const notificationsButton = event.target.closest('[onclick="toggleNotifications()"]');

    if (!notificationsButton && !notificationsDropdown.contains(event.target)) {
        notificationsDropdown.classList.add('hidden');
    }

    const messagesDropdown = document.getElementById('messages-dropdown');
    const messagesButton = event.target.closest('[onclick="toggleMessages()"]');

    if (!messagesButton && !messagesDropdown.contains(event.target)) {
        messagesDropdown.classList.add('hidden');
    }
});

// Real-time notifications
if (typeof Pusher !== 'undefined') {
    const pusher = new Pusher('<?php echo e(config('broadcasting.connections.pusher.key')); ?>', {
        cluster: '<?php echo e(config('broadcasting.connections.pusher.options.cluster')); ?>'
    });

    const channel = pusher.subscribe('admin-dashboard');

    let notificationCount = 0;

    channel.bind('new-post', function(data) {
        addNotification('New Post', data.title, 'article', 'success');
    });

    channel.bind('new-comment', function(data) {
        addNotification('New Comment', data.post_title, 'comment', 'info');
    });

    channel.bind('user-activity', function(data) {
        addNotification('User Activity', data.action, 'person', 'warning');
    });

    function addNotification(title, message, icon, type) {
        notificationCount++;
        updateNotificationCount();

        const notificationsList = document.getElementById('notifications-list');
        const noNotifications = document.getElementById('no-notifications');

        if (noNotifications) {
            noNotifications.style.display = 'none';
        }

        const notification = document.createElement('div');
        notification.className = 'p-4 border-b border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 cursor-pointer';
        notification.innerHTML = `
            <div class="flex items-start space-x-3">
                <span class="material-symbols-outlined text-lg ${getNotificationIconColor(type)}">${icon}</span>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">${title}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-300">${message}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">${new Date().toLocaleTimeString()}</p>
                </div>
            </div>
        `;

        notificationsList.insertBefore(notification, notificationsList.firstChild);

        // Limit to 10 notifications
        const notifications = notificationsList.querySelectorAll('.p-4.border-b');
        if (notifications.length > 10) {
            notifications[notifications.length - 1].remove();
        }
    }

    function updateNotificationCount() {
        const countElement = document.getElementById('notification-count');
        if (countElement) {
            countElement.textContent = notificationCount;
        }
    }

    function getNotificationIconColor(type) {
        const colors = {
            'success': 'text-green-600',
            'info': 'text-blue-600',
            'warning': 'text-yellow-600',
            'error': 'text-red-600'
        };
        return colors[type] || colors['info'];
    }
}
</script>

<?php echo $__env->yieldContent('scripts'); ?>

<!-- Real-time Admin Component -->
<?php echo $__env->make('components.admin-realtime', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>
</html>
<?php /**PATH E:\Laravel Projects\Multi Author Blog\resources\views\layouts\admin.blade.php ENDPATH**/ ?>