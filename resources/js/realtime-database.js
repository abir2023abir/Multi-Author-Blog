/**
 * Real-time Database Service
 * Handles all real-time database updates using Laravel Echo and Reverb
 */

class RealtimeDatabase {
    constructor() {
        this.echo = null;
        this.initialized = false;
        this.listeners = new Map();
        this.connectionStatus = 'disconnected';

        this.init();
    }

    /**
     * Initialize using global Echo instance from bootstrap.js
     */
    init() {
        // Wait for Echo to be available
        if (typeof window.Echo === 'undefined') {
            console.warn('⏳ Waiting for Laravel Echo to initialize...');
            setTimeout(() => this.init(), 100);
            return;
        }

        this.echo = window.Echo;
        this.initialized = true;
        this.setupConnectionListeners();
        console.log('✅ Real-time Database service ready');
    }

    /**
     * Setup connection status listeners
     */
    setupConnectionListeners() {
        if (!this.echo || !this.echo.connector || !this.echo.connector.pusher) {
            console.log('ℹ️ Connection listeners will be set up when WebSocket connects');
            return;
        }

        const pusher = this.echo.connector.pusher;

        pusher.connection.bind('connected', () => {
            this.connectionStatus = 'connected';
            console.log('🟢 Real-time connection established');
            this.notifyConnectionStatus('connected');
        });

        pusher.connection.bind('disconnected', () => {
            this.connectionStatus = 'disconnected';
            console.log('🔴 Real-time connection lost');
            this.notifyConnectionStatus('disconnected');
        });

        pusher.connection.bind('unavailable', () => {
            this.connectionStatus = 'unavailable';
            console.log('⚠️ Real-time connection unavailable');
            this.notifyConnectionStatus('unavailable');
        });

        pusher.connection.bind('error', (err) => {
            console.error('❌ Real-time connection error:', err);
            this.notifyConnectionStatus('error');
        });
    }

    /**
     * Notify connection status change
     */
    notifyConnectionStatus(status) {
        window.dispatchEvent(new CustomEvent('realtime:connection', {
            detail: { status }
        }));
    }

    /**
     * Listen to all database updates
     */
    listenToDatabase(callback) {
        if (!this.initialized) {
            console.warn('Real-time Database not initialized yet');
            return;
        }

        // Listen to general database updates
        this.echo.channel('database.post')
            .listen('.database.updated', (data) => {
                if (data.entity === 'post') {
                    callback('post', data.action, data.data);
                }
            });

        this.echo.channel('database.comment')
            .listen('.database.updated', (data) => {
                if (data.entity === 'comment') {
                    callback('comment', data.action, data.data);
                }
            });

        this.echo.channel('database.user')
            .listen('.database.updated', (data) => {
                if (data.entity === 'user') {
                    callback('user', data.action, data.data);
                }
            });

        this.echo.channel('database.category')
            .listen('.database.updated', (data) => {
                if (data.entity === 'category') {
                    callback('category', data.action, data.data);
                }
            });
    }

    /**
     * Listen to specific entity updates
     */
    listenToEntity(entity, callback) {
        if (!this.initialized) {
            console.warn('Real-time Database not initialized yet');
            return;
        }

        const channelName = `database.${entity}`;

        this.echo.channel(channelName)
            .listen('.database.updated', (data) => {
                if (data.entity === entity) {
                    callback(data.action, data.data);
                }
            });

        console.log(`👂 Listening to ${entity} updates`);
    }

    /**
     * Listen to posts channel
     */
    listenToPosts(callback) {
        if (!this.initialized) return;

        this.echo.channel('posts')
            .listen('.new-post', (data) => {
                callback('created', data.post);
            })
            .listen('.post-updated', (data) => {
                callback('updated', data.post);
            })
            .listen('.post-deleted', (data) => {
                callback('deleted', { id: data.post_id });
            });
    }

    /**
     * Listen to admin dashboard updates (requires authentication)
     */
    listenToAdminDashboard(callback) {
        if (!this.initialized) return;

        this.echo.private('admin.dashboard')
            .listen('.database.updated', (data) => {
                callback(data);
            })
            .listen('.AdminStatsUpdated', (data) => {
                callback({ type: 'stats', data: data });
            });
    }

    /**
     * Listen to writer dashboard updates (requires authentication)
     */
    listenToWriterDashboard(userId, callback) {
        if (!this.initialized) return;

        this.echo.private(`writer.${userId}`)
            .listen('.database.updated', (data) => {
                callback(data);
            });
    }

    /**
     * Listen to user notifications
     */
    listenToUserNotifications(userId, callback) {
        if (!this.initialized) return;

        this.echo.private(`user.notifications.${userId}`)
            .listen('.NotificationSent', (data) => {
                callback(data);
            });
    }

    /**
     * Join presence channel to see who's online
     */
    joinOnlineUsers(callback) {
        if (!this.initialized) return;

        this.echo.join('online')
            .here((users) => {
                callback('here', users);
            })
            .joining((user) => {
                callback('joining', user);
            })
            .leaving((user) => {
                callback('leaving', user);
            });
    }

    /**
     * Leave a channel
     */
    leaveChannel(channelName) {
        if (!this.initialized) return;

        this.echo.leave(channelName);
        console.log(`👋 Left channel: ${channelName}`);
    }

    /**
     * Disconnect from all channels
     */
    disconnect() {
        if (!this.initialized) return;

        this.echo.disconnect();
        this.connectionStatus = 'disconnected';
        console.log('🔌 Disconnected from real-time service');
    }

    /**
     * Get connection status
     */
    getStatus() {
        return this.connectionStatus;
    }

    /**
     * Check if connected
     */
    isConnected() {
        return this.connectionStatus === 'connected';
    }
}

// Create global instance
window.realtimeDB = new RealtimeDatabase();

// Export for module usage
export default RealtimeDatabase;
