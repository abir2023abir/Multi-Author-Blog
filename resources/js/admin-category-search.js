/**
 * Admin Category Search Module
 * Handles category search and filtering functionality
 */

class AdminCategorySearch {
    constructor() {
        this.searchInput = null;
        this.categoryItems = [];
        this.filteredItems = [];
        this.init();
    }

    init() {
        this.setupSearchInput();
        this.setupCategoryItems();
        this.bindEvents();
    }

    setupSearchInput() {
        this.searchInput = document.getElementById('category-search');
        if (!this.searchInput) {
            console.warn('Category search input not found');
            return;
        }
    }

    setupCategoryItems() {
        this.categoryItems = Array.from(document.querySelectorAll('.category-item'));
        this.filteredItems = [...this.categoryItems];
    }

    bindEvents() {
        if (this.searchInput) {
            this.searchInput.addEventListener('input', (e) => {
                this.handleSearch(e.target.value);
            });

            // Clear search on escape
            this.searchInput.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    this.clearSearch();
                }
            });
        }

        // Re-setup items when new categories are added dynamically
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.type === 'childList') {
                    const addedNodes = Array.from(mutation.addedNodes);
                    const hasNewCategoryItems = addedNodes.some(node =>
                        node.nodeType === Node.ELEMENT_NODE &&
                        (node.classList.contains('category-item') ||
                         node.querySelector('.category-item'))
                    );

                    if (hasNewCategoryItems) {
                        this.setupCategoryItems();
                    }
                }
            });
        });

        // Observe the container for category items
        const categoryContainer = document.querySelector('.category-list, .categories-container, #categories');
        if (categoryContainer) {
            observer.observe(categoryContainer, {
                childList: true,
                subtree: true
            });
        }
    }

    /**
     * Handle search input
     * @param {string} searchTerm - The search term
     */
    handleSearch(searchTerm) {
        const term = searchTerm.toLowerCase().trim();

        if (term === '') {
            this.showAllItems();
            return;
        }

        this.filteredItems = this.categoryItems.filter(item => {
            const categoryName = item.getAttribute('data-category-name') || '';
            const label = item.querySelector('span, .category-name, .category-label');
            const labelText = label ? label.textContent.toLowerCase() : '';

            const matches = categoryName.includes(term) || labelText.includes(term);

            // Show/hide item
            item.style.display = matches ? 'flex' : 'none';

            return matches;
        });

        // Update search results count if element exists
        this.updateSearchResultsCount();
    }

    /**
     * Show all category items
     */
    showAllItems() {
        this.categoryItems.forEach(item => {
            item.style.display = 'flex';
        });
        this.filteredItems = [...this.categoryItems];
        this.updateSearchResultsCount();
    }

    /**
     * Clear search
     */
    clearSearch() {
        if (this.searchInput) {
            this.searchInput.value = '';
            this.showAllItems();
        }
    }

    /**
     * Update search results count
     */
    updateSearchResultsCount() {
        const countElement = document.getElementById('search-results-count');
        if (countElement) {
            const total = this.categoryItems.length;
            const filtered = this.filteredItems.length;

            if (this.searchInput && this.searchInput.value.trim() !== '') {
                countElement.textContent = `Showing ${filtered} of ${total} categories`;
                countElement.style.display = 'block';
            } else {
                countElement.style.display = 'none';
            }
        }
    }

    /**
     * Add a new category item to the search
     * @param {HTMLElement} item - The category item element
     */
    addCategoryItem(item) {
        if (item && item.classList.contains('category-item')) {
            this.categoryItems.push(item);
            this.filteredItems.push(item);
        }
    }

    /**
     * Remove a category item from the search
     * @param {HTMLElement} item - The category item element
     */
    removeCategoryItem(item) {
        const index = this.categoryItems.indexOf(item);
        if (index > -1) {
            this.categoryItems.splice(index, 1);
        }

        const filteredIndex = this.filteredItems.indexOf(item);
        if (filteredIndex > -1) {
            this.filteredItems.splice(filteredIndex, 1);
        }
    }

    /**
     * Get filtered results
     * @returns {Array} - Array of filtered category items
     */
    getFilteredResults() {
        return this.filteredItems;
    }

    /**
     * Get search term
     * @returns {string} - Current search term
     */
    getSearchTerm() {
        return this.searchInput ? this.searchInput.value : '';
    }

    /**
     * Set search term programmatically
     * @param {string} term - The search term
     */
    setSearchTerm(term) {
        if (this.searchInput) {
            this.searchInput.value = term;
            this.handleSearch(term);
        }
    }

    /**
     * Highlight search term in results
     * @param {string} text - The text to highlight
     * @param {string} searchTerm - The search term
     * @returns {string} - HTML with highlighted text
     */
    highlightSearchTerm(text, searchTerm) {
        if (!searchTerm || searchTerm.trim() === '') {
            return text;
        }

        const regex = new RegExp(`(${searchTerm})`, 'gi');
        return text.replace(regex, '<mark class="bg-yellow-200 px-1 rounded">$1</mark>');
    }

    /**
     * Reset search to initial state
     */
    reset() {
        this.clearSearch();
        this.setupCategoryItems();
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.adminCategorySearch = new AdminCategorySearch();
});

// Export for module usage
export default AdminCategorySearch;
