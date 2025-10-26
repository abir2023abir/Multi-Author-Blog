/**
 * Admin Notification System
 * Handles notifications, alerts, and user feedback
 */

class AdminNotificationSystem {
    constructor() {
        this.notifications = [];
        this.maxNotifications = 5;
        this.defaultDuration = 3000;
        this.init();
    }

    init() {
        this.createNotificationContainer();
    }

    createNotificationContainer() {
        // Create notification container if it doesn't exist
        if (!document.getElementById('notification-container')) {
            const container = document.createElement('div');
            container.id = 'notification-container';
            container.className = 'fixed top-4 right-4 z-50 space-y-2';
            document.body.appendChild(container);
        }
    }

    /**
     * Show a notification
     * @param {string} message - The notification message
     * @param {string} type - The notification type (success, error, warning, info)
     * @param {number} duration - Duration in milliseconds (optional)
     */
    show(message, type = 'info', duration = null) {
        const notification = this.createNotification(message, type);
        this.addToContainer(notification);

        // Auto remove after duration
        const removeDuration = duration || this.defaultDuration;
        setTimeout(() => {
            this.remove(notification);
        }, removeDuration);

        return notification;
    }

    /**
     * Create a notification element
     * @param {string} message - The notification message
     * @param {string} type - The notification type
     * @returns {HTMLElement} - The notification element
     */
    createNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `px-4 py-3 rounded-lg text-white shadow-lg transform transition-all duration-300 translate-x-full opacity-0 ${this.getTypeClasses(type)}`;
        notification.innerHTML = `
            <div class="flex items-center space-x-2">
                <span class="material-symbols-outlined text-sm">${this.getTypeIcon(type)}</span>
                <span class="flex-1">${message}</span>
                <button onclick="adminNotifications.remove(this.parentElement.parentElement)"
                        class="ml-2 text-white hover:text-gray-200 transition-colors">
                    <span class="material-symbols-outlined text-sm">close</span>
                </button>
            </div>
        `;

        // Add to notifications array
        this.notifications.push(notification);

        return notification;
    }

    /**
     * Add notification to container with animation
     * @param {HTMLElement} notification - The notification element
     */
    addToContainer(notification) {
        const container = document.getElementById('notification-container');
        if (container) {
            container.appendChild(notification);

            // Trigger animation
            requestAnimationFrame(() => {
                notification.classList.remove('translate-x-full', 'opacity-0');
                notification.classList.add('translate-x-0', 'opacity-100');
            });
        }
    }

    /**
     * Remove a notification
     * @param {HTMLElement} notification - The notification element
     */
    remove(notification) {
        if (notification && notification.parentElement) {
            // Animate out
            notification.classList.remove('translate-x-0', 'opacity-100');
            notification.classList.add('translate-x-full', 'opacity-0');

            // Remove from DOM after animation
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 300);

            // Remove from notifications array
            const index = this.notifications.indexOf(notification);
            if (index > -1) {
                this.notifications.splice(index, 1);
            }
        }
    }

    /**
     * Clear all notifications
     */
    clearAll() {
        this.notifications.forEach(notification => {
            this.remove(notification);
        });
    }

    /**
     * Get CSS classes for notification type
     * @param {string} type - The notification type
     * @returns {string} - CSS classes
     */
    getTypeClasses(type) {
        const classes = {
            'success': 'bg-green-500',
            'error': 'bg-red-500',
            'warning': 'bg-yellow-500',
            'info': 'bg-blue-500'
        };
        return classes[type] || classes['info'];
    }

    /**
     * Get icon for notification type
     * @param {string} type - The notification type
     * @returns {string} - Icon name
     */
    getTypeIcon(type) {
        const icons = {
            'success': 'check_circle',
            'error': 'error',
            'warning': 'warning',
            'info': 'info'
        };
        return icons[type] || icons['info'];
    }

    /**
     * Show success notification
     * @param {string} message - The message
     * @param {number} duration - Duration in milliseconds (optional)
     */
    success(message, duration = null) {
        return this.show(message, 'success', duration);
    }

    /**
     * Show error notification
     * @param {string} message - The message
     * @param {number} duration - Duration in milliseconds (optional)
     */
    error(message, duration = null) {
        return this.show(message, 'error', duration);
    }

    /**
     * Show warning notification
     * @param {string} message - The message
     * @param {number} duration - Duration in milliseconds (optional)
     */
    warning(message, duration = null) {
        return this.show(message, 'warning', duration);
    }

    /**
     * Show info notification
     * @param {string} message - The message
     * @param {number} duration - Duration in milliseconds (optional)
     */
    info(message, duration = null) {
        return this.show(message, 'info', duration);
    }

    /**
     * Show loading notification
     * @param {string} message - The message
     * @returns {HTMLElement} - The notification element
     */
    loading(message = 'Loading...') {
        const notification = document.createElement('div');
        notification.className = 'px-4 py-3 rounded-lg text-white shadow-lg bg-gray-600';
        notification.innerHTML = `
            <div class="flex items-center space-x-2">
                <div class="animate-spin rounded-full h-4 w-4 border-2 border-white border-t-transparent"></div>
                <span>${message}</span>
            </div>
        `;

        this.addToContainer(notification);
        this.notifications.push(notification);

        return notification;
    }

    /**
     * Update loading notification
     * @param {HTMLElement} notification - The notification element
     * @param {string} message - New message
     * @param {string} type - New type (success, error, etc.)
     */
    updateLoading(notification, message, type = 'success') {
        if (notification && notification.parentElement) {
            notification.className = `px-4 py-3 rounded-lg text-white shadow-lg ${this.getTypeClasses(type)}`;
            notification.innerHTML = `
                <div class="flex items-center space-x-2">
                    <span class="material-symbols-outlined text-sm">${this.getTypeIcon(type)}</span>
                    <span>${message}</span>
                    <button onclick="adminNotifications.remove(this.parentElement.parentElement)"
                            class="ml-2 text-white hover:text-gray-200 transition-colors">
                        <span class="material-symbols-outlined text-sm">close</span>
                    </button>
                </div>
            `;
        }
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.adminNotifications = new AdminNotificationSystem();
});

// Global function for backward compatibility
window.showNotification = function(message, type = 'info') {
    if (window.adminNotifications) {
        return window.adminNotifications.show(message, type);
    }
};

// Export for module usage
export default AdminNotificationSystem;
