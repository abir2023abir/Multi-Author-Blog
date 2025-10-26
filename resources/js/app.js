import './bootstrap';

import Alpine from 'alpinejs';
import AdminImageHandler from './admin-image-handler.js';
import AdminNotificationSystem from './admin-notifications.js';
import AdminCategorySearch from './admin-category-search.js';
import RealtimeDatabase from './realtime-database.js';

window.Alpine = Alpine;

// Initialize admin modules
document.addEventListener('DOMContentLoaded', function() {
    // Initialize admin modules
    window.adminImageHandler = new AdminImageHandler();
    window.adminNotifications = new AdminNotificationSystem();
    window.adminCategorySearch = new AdminCategorySearch();

    // Initialize real-time database (auto-initialized on creation)
    // window.realtimeDB is already available globally

    console.log('✅ All modules initialized');
});

Alpine.start();
