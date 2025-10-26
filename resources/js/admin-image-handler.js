/**
 * Admin Image Handler Module
 * Handles image uploads, previews, and gallery management for admin forms
 */

class AdminImageHandler {
    constructor() {
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.initializeCategorySearch();
    }

    setupEventListeners() {
        // Image preview functionality
        document.addEventListener('change', (e) => {
            if (e.target.matches('input[type="file"][accept*="image"]')) {
                this.handleImagePreview(e.target);
            }
        });

        // Featured image handling
        document.addEventListener('change', (e) => {
            if (e.target.id === 'featured-image') {
                this.handleFeaturedImage(e.target);
            }
        });

        // Gallery images handling
        document.addEventListener('change', (e) => {
            if (e.target.id === 'gallery-images') {
                this.handleGalleryImages(e.target);
            }
        });
    }

    initializeCategorySearch() {
        const searchInput = document.getElementById('category-search');
        if (!searchInput) return;

        const categoryItems = document.querySelectorAll('.category-item');

        searchInput.addEventListener('input', (e) => {
            const searchTerm = e.target.value.toLowerCase();

            categoryItems.forEach(item => {
                const categoryName = item.getAttribute('data-category-name');
                const label = item.querySelector('span');

                if (categoryName && categoryName.includes(searchTerm) ||
                    (label && label.textContent.toLowerCase().includes(searchTerm))) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    }

    // Image preview functionality
    handleImagePreview(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = (e) => {
                const previewElement = document.getElementById('preview-img');
                const previewContainer = document.getElementById('image-preview');

                if (previewElement) {
                    previewElement.src = e.target.result;
                }
                if (previewContainer) {
                    previewContainer.classList.remove('hidden');
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Featured image handling
    handleFeaturedImage(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const reader = new FileReader();

            reader.onload = (e) => {
                const preview = document.getElementById('featured-image-preview');
                if (preview) {
                    preview.innerHTML = `
                        <img src="${e.target.result}" alt="Featured Image Preview" class="max-w-full h-32 object-cover rounded-lg mx-auto">
                        <p class="text-sm text-gray-500 mt-2">Featured Image</p>
                        <button type="button" onclick="adminImageHandler.removeFeaturedImage()"
                                class="mt-2 text-red-600 hover:text-red-800 text-sm">
                            Remove Image
                        </button>
                    `;
                }
            };
            reader.readAsDataURL(file);
        }
    }

    // Gallery images handling
    handleGalleryImages(input) {
        if (input.files && input.files.length > 0) {
            const preview = document.getElementById('gallery-preview');
            if (!preview) return;

            preview.innerHTML = '';

            Array.from(input.files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const imageDiv = document.createElement('div');
                    imageDiv.className = 'relative group';
                    imageDiv.innerHTML = `
                        <img src="${e.target.result}" alt="Gallery Image ${index + 1}"
                             class="w-full h-24 object-cover rounded-lg">
                        <button type="button" onclick="adminImageHandler.removeGalleryImage(this)"
                                class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition-opacity">
                            ×
                        </button>
                    `;
                    preview.appendChild(imageDiv);
                };
                reader.readAsDataURL(file);
            });
        }
    }

    // Remove featured image
    removeFeaturedImage() {
        const input = document.getElementById('featured-image');
        const preview = document.getElementById('featured-image-preview');

        if (input) input.value = '';
        if (preview) {
            preview.innerHTML = `
                <span class="material-symbols-outlined text-gray-400 text-4xl">landscape</span>
                <p class="text-sm text-gray-500 mt-2">Featured Image</p>
            `;
        }
    }

    // Remove gallery image
    removeGalleryImage(button) {
        button.parentElement.remove();
    }

    // Handle featured image selection from image selector
    handleFeaturedImageSelection(images) {
        if (images && images.length > 0) {
            const image = images[0]; // Take only the first image for featured image
            const preview = document.getElementById('featured-image-preview');

            if (preview) {
                preview.innerHTML = `
                    <img src="${image.url}" alt="Featured Image Preview" class="max-w-full h-32 object-cover rounded-lg mx-auto">
                    <p class="text-sm text-gray-500 mt-2">Featured Image</p>
                    <button type="button" onclick="adminImageHandler.removeFeaturedImage()"
                            class="mt-2 text-red-600 hover:text-red-800 text-sm">
                        Remove Image
                    </button>
                `;
            }

            // Handle file or URL
            if (image.type === 'file') {
                // Create a data transfer object to simulate file input
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(image.file);
                const fileInput = document.getElementById('featured-image');
                if (fileInput) {
                    fileInput.files = dataTransfer.files;
                }
            } else if (image.type === 'url') {
                // Create a hidden input to store the URL
                let urlInput = document.getElementById('featured-image-url');
                if (!urlInput) {
                    urlInput = document.createElement('input');
                    urlInput.type = 'hidden';
                    urlInput.id = 'featured-image-url';
                    urlInput.name = 'featured_image_url';
                    const form = document.querySelector('form');
                    if (form) {
                        form.appendChild(urlInput);
                    }
                }
                urlInput.value = image.url;
            }
        }
    }

    // Handle gallery selection from image selector
    handleGallerySelection(images) {
        if (images && images.length > 0) {
            const preview = document.getElementById('gallery-preview');
            if (!preview) return;

            preview.innerHTML = '';

            // Create a data transfer object for multiple files
            const dataTransfer = new DataTransfer();

            images.forEach((image, index) => {
                if (image.type === 'file') {
                    dataTransfer.items.add(image.file);
                }

                const imageDiv = document.createElement('div');
                imageDiv.className = 'relative group';
                imageDiv.innerHTML = `
                    <img src="${image.url}" alt="Gallery Image ${index + 1}"
                         class="w-full h-24 object-cover rounded-lg">
                    <button type="button" onclick="adminImageHandler.removeGalleryImage(this)"
                            class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition-opacity">
                        ×
                    </button>
                `;
                preview.appendChild(imageDiv);
            });

            // Update the file input
            const fileInput = document.getElementById('gallery-images');
            if (fileInput) {
                fileInput.files = dataTransfer.files;
            }
        }
    }

    // Open image URL modal
    openImageUrlModal() {
        const url = prompt('Enter image URL:');
        if (url && url.trim() !== '') {
            const preview = document.getElementById('featured-image-preview');
            if (preview) {
                preview.innerHTML = `
                    <img src="${url}" alt="Featured Image Preview"
                         class="max-w-full h-32 object-cover rounded-lg mx-auto"
                         onerror="this.parentElement.innerHTML='<span class=\\"material-symbols-outlined text-red-400 text-4xl\\">error</span><p class=\\"text-sm text-red-500 mt-2\\">Invalid Image URL</p><button type=\\"button\\" onclick=\\"adminImageHandler.removeFeaturedImage()\\" class=\\"mt-2 text-red-600 hover:text-red-800 text-sm\\">Remove Image</button>'">
                    <p class="text-sm text-gray-500 mt-2">Featured Image</p>
                    <button type="button" onclick="adminImageHandler.removeFeaturedImage()"
                            class="mt-2 text-red-600 hover:text-red-800 text-sm">
                        Remove Image
                    </button>
                `;
            }

            // Create a hidden input to store the URL
            let urlInput = document.getElementById('featured-image-url');
            if (!urlInput) {
                urlInput = document.createElement('input');
                urlInput.type = 'hidden';
                urlInput.id = 'featured-image-url';
                urlInput.name = 'featured_image_url';
                const form = document.querySelector('form');
                if (form) {
                    form.appendChild(urlInput);
                }
            }
            urlInput.value = url;
        }
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.adminImageHandler = new AdminImageHandler();
});

// Export for module usage
export default AdminImageHandler;
