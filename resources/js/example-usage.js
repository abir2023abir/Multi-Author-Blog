/**
 * Example Usage of Admin JavaScript Modules
 * This file demonstrates how to use the admin modules in various scenarios
 */

// Wait for DOM to be ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('Admin modules example loaded');

    // Example 1: Basic notification usage
    demonstrateNotifications();

    // Example 2: Image handling setup
    demonstrateImageHandling();

    // Example 3: Category search setup
    demonstrateCategorySearch();

    // Example 4: Integration with forms
    demonstrateFormIntegration();
});

/**
 * Demonstrate notification system usage
 */
function demonstrateNotifications() {
    // Show different types of notifications
    setTimeout(() => {
        if (window.adminNotifications) {
            window.adminNotifications.info('Welcome to the admin panel!');
        }
    }, 1000);

    // Example of showing notifications based on form submission
    const form = document.querySelector('form[action*="posts"]');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (window.adminNotifications) {
                window.adminNotifications.loading('Saving post...');
            }
        });
    }
}

/**
 * Demonstrate image handling setup
 */
function demonstrateImageHandling() {
    // Set up custom image upload handlers
    const customImageInput = document.getElementById('custom-image-input');
    if (customImageInput && window.adminImageHandler) {
        customImageInput.addEventListener('change', function(e) {
            // Custom processing before using the handler
            console.log('Custom image processing...');

            // Use the admin image handler
            window.adminImageHandler.handleFeaturedImage(e.target);

            // Show success notification
            if (window.adminNotifications) {
                window.adminNotifications.success('Image uploaded successfully!');
            }
        });
    }
}

/**
 * Demonstrate category search setup
 */
function demonstrateCategorySearch() {
    // Set up custom search functionality
    const customSearchInput = document.getElementById('custom-search');
    if (customSearchInput && window.adminCategorySearch) {
        customSearchInput.addEventListener('input', function(e) {
            // Custom search logic
            const searchTerm = e.target.value;
            console.log('Custom search for:', searchTerm);

            // Use the admin category search
            window.adminCategorySearch.setSearchTerm(searchTerm);
        });
    }
}

/**
 * Demonstrate form integration
 */
function demonstrateFormIntegration() {
    // Example: Form validation with notifications
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            // Basic validation
            const requiredFields = form.querySelectorAll('[required]');
            let hasErrors = false;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    hasErrors = true;
                    field.classList.add('border-red-500');

                    if (window.adminNotifications) {
                        window.adminNotifications.error(`${field.name} is required`);
                    }
                } else {
                    field.classList.remove('border-red-500');
                }
            });

            if (hasErrors) {
                e.preventDefault();
                return false;
            }

            // Show success notification
            if (window.adminNotifications) {
                window.adminNotifications.success('Form submitted successfully!');
            }
        });
    });
}

/**
 * Example: Custom image selector integration
 */
function setupCustomImageSelector() {
    // Create a custom image selector button
    const customButton = document.createElement('button');
    customButton.textContent = 'Select Custom Images';
    customButton.className = 'px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700';

    customButton.addEventListener('click', function() {
        // Simulate image selection
        const mockImages = [
            {
                url: 'https://via.placeholder.com/300x200?text=Image+1',
                type: 'url'
            },
            {
                url: 'https://via.placeholder.com/300x200?text=Image+2',
                type: 'url'
            }
        ];

        // Use the admin image handler
        if (window.adminImageHandler) {
            window.adminImageHandler.handleGallerySelection(mockImages);

            if (window.adminNotifications) {
                window.adminNotifications.success('Images selected successfully!');
            }
        }
    });

    // Add button to page
    const container = document.getElementById('image-selector-container');
    if (container) {
        container.appendChild(customButton);
    }
}

/**
 * Example: Real-time category updates
 */
function setupRealTimeCategoryUpdates() {
    // Simulate adding new categories dynamically
    const addCategoryButton = document.getElementById('add-category');
    if (addCategoryButton) {
        addCategoryButton.addEventListener('click', function() {
            const categoryName = prompt('Enter category name:');
            if (categoryName) {
                // Create new category element
                const categoryElement = document.createElement('div');
                categoryElement.className = 'category-item';
                categoryElement.setAttribute('data-category-name', categoryName.toLowerCase());
                categoryElement.innerHTML = `<span>${categoryName}</span>`;

                // Add to category list
                const categoryList = document.querySelector('.category-list');
                if (categoryList) {
                    categoryList.appendChild(categoryElement);
                }

                // Add to search system
                if (window.adminCategorySearch) {
                    window.adminCategorySearch.addCategoryItem(categoryElement);
                }

                // Show notification
                if (window.adminNotifications) {
                    window.adminNotifications.success(`Category "${categoryName}" added successfully!`);
                }
            }
        });
    }
}

/**
 * Example: Error handling and recovery
 */
function setupErrorHandling() {
    // Global error handler
    window.addEventListener('error', function(e) {
        console.error('Global error:', e.error);

        if (window.adminNotifications) {
            window.adminNotifications.error('An unexpected error occurred. Please try again.');
        }
    });

    // Unhandled promise rejection handler
    window.addEventListener('unhandledrejection', function(e) {
        console.error('Unhandled promise rejection:', e.reason);

        if (window.adminNotifications) {
            window.adminNotifications.error('A network error occurred. Please check your connection.');
        }
    });
}

/**
 * Example: Performance monitoring
 */
function setupPerformanceMonitoring() {
    // Monitor module initialization time
    const startTime = performance.now();

    // Check if modules are loaded
    const checkModules = setInterval(() => {
        if (window.adminImageHandler && window.adminNotifications && window.adminCategorySearch) {
            const loadTime = performance.now() - startTime;
            console.log(`Admin modules loaded in ${loadTime.toFixed(2)}ms`);
            clearInterval(checkModules);
        }
    }, 100);

    // Timeout after 5 seconds
    setTimeout(() => {
        clearInterval(checkModules);
        if (!window.adminImageHandler) {
            console.warn('Admin modules failed to load within 5 seconds');
        }
    }, 5000);
}

// Initialize example features
document.addEventListener('DOMContentLoaded', function() {
    setupCustomImageSelector();
    setupRealTimeCategoryUpdates();
    setupErrorHandling();
    setupPerformanceMonitoring();
});
