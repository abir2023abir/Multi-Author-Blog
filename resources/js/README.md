# Admin JavaScript Modules

This directory contains modular JavaScript components for the Laravel Multi Author Blog admin interface. The modules are designed to be reusable, maintainable, and easily integrated with the existing admin system.

## Modules Overview

### 1. AdminImageHandler (`admin-image-handler.js`)

Handles all image-related functionality for admin forms including uploads, previews, and gallery management.

#### Features
- **Image Preview**: Automatic preview generation for uploaded images
- **Featured Image Management**: Handle single image selection and preview
- **Gallery Management**: Handle multiple image selection and preview
- **Image URL Support**: Support for both file uploads and URL-based images
- **Error Handling**: Graceful handling of invalid images and URLs

#### Usage
```javascript
// Initialize (automatically done on DOM load)
window.adminImageHandler = new AdminImageHandler();

// Handle featured image upload
document.getElementById('featured-image').addEventListener('change', function(e) {
    window.adminImageHandler.handleFeaturedImage(e.target);
});

// Handle gallery images upload
document.getElementById('gallery-images').addEventListener('change', function(e) {
    window.adminImageHandler.handleGalleryImages(e.target);
});

// Remove featured image
window.adminImageHandler.removeFeaturedImage();

// Remove gallery image
window.adminImageHandler.removeGalleryImage(buttonElement);

// Handle image selection from image selector
window.adminImageHandler.handleFeaturedImageSelection(images);
window.adminImageHandler.handleGallerySelection(images);

// Open image URL modal
window.adminImageHandler.openImageUrlModal();
```

#### Methods
- `handleFeaturedImage(input)` - Process featured image upload
- `handleGalleryImages(input)` - Process gallery images upload
- `removeFeaturedImage()` - Remove featured image and reset preview
- `removeGalleryImage(button)` - Remove specific gallery image
- `handleFeaturedImageSelection(images)` - Handle image selection from external selector
- `handleGallerySelection(images)` - Handle gallery selection from external selector
- `openImageUrlModal()` - Open modal for image URL input

### 2. AdminNotificationSystem (`admin-notifications.js`)

Provides a comprehensive notification system with different types and animations.

#### Features
- **Multiple Types**: Success, error, warning, and info notifications
- **Auto-dismiss**: Configurable auto-removal timing
- **Animations**: Smooth slide-in/out animations
- **Loading States**: Special loading notifications with spinner
- **Manual Control**: Ability to manually remove notifications
- **Queue Management**: Automatic cleanup and limit management

#### Usage
```javascript
// Initialize (automatically done on DOM load)
window.adminNotifications = new AdminNotificationSystem();

// Show different types of notifications
window.adminNotifications.success('Operation completed successfully!');
window.adminNotifications.error('Something went wrong!');
window.adminNotifications.warning('Please check your input');
window.adminNotifications.info('Information message');

// Show notification with custom duration
window.adminNotifications.show('Custom message', 'success', 5000);

// Show loading notification
const loadingNotification = window.adminNotifications.loading('Processing...');

// Update loading notification
window.adminNotifications.updateLoading(loadingNotification, 'Completed!', 'success');

// Clear all notifications
window.adminNotifications.clearAll();

// Global function for backward compatibility
showNotification('Message', 'info');
```

#### Methods
- `show(message, type, duration)` - Show notification with custom settings
- `success(message, duration)` - Show success notification
- `error(message, duration)` - Show error notification
- `warning(message, duration)` - Show warning notification
- `info(message, duration)` - Show info notification
- `loading(message)` - Show loading notification
- `updateLoading(notification, message, type)` - Update loading notification
- `clearAll()` - Clear all notifications

### 3. AdminCategorySearch (`admin-category-search.js`)

Handles category search and filtering functionality with real-time updates.

#### Features
- **Real-time Search**: Instant filtering as user types
- **Multiple Search Fields**: Search by category name or label text
- **Dynamic Updates**: Automatically handles dynamically added categories
- **Search Results Count**: Shows filtered vs total count
- **Keyboard Support**: Escape key to clear search
- **Highlighting**: Optional search term highlighting

#### Usage
```javascript
// Initialize (automatically done on DOM load)
window.adminCategorySearch = new AdminCategorySearch();

// Set search term programmatically
window.adminCategorySearch.setSearchTerm('technology');

// Get current search term
const currentTerm = window.adminCategorySearch.getSearchTerm();

// Get filtered results
const filteredCategories = window.adminCategorySearch.getFilteredResults();

// Add new category item to search
window.adminCategorySearch.addCategoryItem(newCategoryElement);

// Remove category item from search
window.adminCategorySearch.removeCategoryItem(categoryElement);

// Reset search
window.adminCategorySearch.reset();
```

#### Methods
- `handleSearch(searchTerm)` - Filter categories based on search term
- `clearSearch()` - Clear search and show all items
- `setSearchTerm(term)` - Set search term programmatically
- `getSearchTerm()` - Get current search term
- `getFilteredResults()` - Get array of filtered category items
- `addCategoryItem(item)` - Add new category item to search
- `removeCategoryItem(item)` - Remove category item from search
- `reset()` - Reset search to initial state

## Integration

### With Existing Admin System

The modules are designed to integrate seamlessly with the existing admin realtime system:

```javascript
// The admin realtime system automatically uses the new notification system
if (window.adminNotifications) {
    return window.adminNotifications.show(message, type);
}
```

### With Vite Build System

The modules are imported in `app.js` and built with Vite:

```javascript
import AdminImageHandler from './admin-image-handler.js';
import AdminNotificationSystem from './admin-notifications.js';
import AdminCategorySearch from './admin-category-search.js';
```

### With Blade Templates

The modules are available globally and can be used in Blade templates:

```html
<script>
// Use in Blade templates
document.getElementById('my-button').addEventListener('click', function() {
    window.adminNotifications.success('Button clicked!');
});
</script>
```

## HTML Requirements

### For Image Handler

```html
<!-- Featured Image -->
<input type="file" id="featured-image" name="featured_image" accept="image/*" class="hidden">
<div id="featured-image-preview" class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center">
    <span class="material-symbols-outlined text-gray-400 text-4xl">landscape</span>
    <p class="text-sm text-gray-500 mt-2">Featured Image</p>
</div>

<!-- Gallery Images -->
<input type="file" id="gallery-images" name="gallery_images[]" multiple accept="image/*" class="hidden">
<div id="gallery-preview" class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
    <!-- Gallery images will be previewed here -->
</div>
```

### For Category Search

```html
<!-- Search Input -->
<input type="text" id="category-search" placeholder="Search categories..." class="w-full px-3 py-2 border border-gray-300 rounded-lg">

<!-- Category Items -->
<div class="category-item" data-category-name="technology">
    <span>Technology</span>
</div>

<!-- Search Results Count (optional) -->
<div id="search-results-count" class="text-sm text-gray-500" style="display: none;">
    Showing X of Y categories
</div>
```

### For Notifications

```html
<!-- Notification container is automatically created -->
<!-- No additional HTML required -->
```

## Styling

The modules use Tailwind CSS classes and are designed to work with the existing admin theme. Key classes used:

- **Notifications**: `fixed top-4 right-4 z-50`, `px-4 py-3 rounded-lg`, `text-white shadow-lg`
- **Image Previews**: `max-w-full h-32 object-cover rounded-lg`, `relative group`
- **Search Results**: `flex items-center space-x-2`, `opacity-0 group-hover:opacity-100`

## Browser Support

- **Modern Browsers**: Chrome 60+, Firefox 55+, Safari 12+, Edge 79+
- **ES6 Features**: Uses modern JavaScript features (classes, arrow functions, etc.)
- **File API**: Requires File API support for image handling
- **MutationObserver**: Requires MutationObserver for dynamic category updates

## Error Handling

All modules include comprehensive error handling:

- **Graceful Degradation**: Fallback behavior when modules aren't available
- **Console Warnings**: Helpful warnings for missing elements
- **User Feedback**: Clear error messages through notifications
- **Validation**: Input validation and sanitization

## Performance Considerations

- **Lazy Loading**: Modules only initialize when needed
- **Event Delegation**: Efficient event handling for dynamic content
- **Memory Management**: Proper cleanup of event listeners and observers
- **Debouncing**: Search input is debounced to prevent excessive filtering

## Future Enhancements

- **Drag & Drop**: Image drag and drop support
- **Image Cropping**: Built-in image cropping functionality
- **Bulk Operations**: Bulk category operations
- **Keyboard Shortcuts**: Additional keyboard shortcuts
- **Accessibility**: Enhanced accessibility features
- **Mobile Optimization**: Better mobile touch support
