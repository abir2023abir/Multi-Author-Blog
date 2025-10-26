<!-- Image Selector Modal -->
<div id="image-selector-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
            <!-- Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Select Images</h3>
                <button onclick="closeImageSelector()" class="text-gray-400 hover:text-gray-600">
                    <span class="material-symbols-outlined text-2xl">close</span>
                </button>
            </div>

            <!-- Tabs -->
            <div class="border-b border-gray-200">
                <nav class="flex space-x-8 px-6">
                    <button onclick="switchImageTab('upload')" id="upload-tab" class="py-4 px-1 border-b-2 border-blue-500 text-blue-600 font-medium text-sm">
                        Upload Images
                    </button>
                    <button onclick="switchImageTab('library')" id="library-tab" class="py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium text-sm">
                        Media Library
                    </button>
                    <button onclick="switchImageTab('url')" id="url-tab" class="py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium text-sm">
                        From URL
                    </button>
                </nav>
            </div>

            <!-- Content -->
            <div class="p-6">
                <!-- Upload Tab -->
                <div id="upload-content" class="image-tab-content">
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center">
                        <input type="file" id="image-upload" multiple accept="image/*" class="hidden" onchange="handleImageUpload(this)">
                        <button onclick="document.getElementById('image-upload').click()" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center space-x-2 mx-auto">
                            <span class="material-symbols-outlined">add_photo_alternate</span>
                            <span>Choose Images</span>
                        </button>
                        <p class="text-gray-500 mt-2">Drag and drop images here or click to browse</p>
                    </div>
                </div>

                <!-- Library Tab -->
                <div id="library-content" class="image-tab-content hidden">
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 max-h-96 overflow-y-auto">
                        <!-- Media library images will be loaded here -->
                        <div class="text-center text-gray-500 py-8">
                            <span class="material-symbols-outlined text-4xl">image</span>
                            <p class="mt-2">No images in library</p>
                        </div>
                    </div>
                </div>

                <!-- URL Tab -->
                <div id="url-content" class="image-tab-content hidden">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Image URL</label>
                            <input type="url" id="image-url" placeholder="https://example.com/image.jpg" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <button onclick="addImageFromUrl()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Add Image
                        </button>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="flex items-center justify-between p-6 border-t border-gray-200">
                <div class="text-sm text-gray-500">
                    <span id="selected-count">0</span> images selected
                </div>
                <div class="flex space-x-3">
                    <button onclick="closeImageSelector()" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">
                        Cancel
                    </button>
                    <button onclick="confirmImageSelection()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Select Images
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let selectedImages = [];
let currentCallback = null;

function openImageSelector(callback) {
    currentCallback = callback;
    selectedImages = [];
    document.getElementById('image-selector-modal').classList.remove('hidden');
    updateSelectedCount();
}

function closeImageSelector() {
    document.getElementById('image-selector-modal').classList.add('hidden');
    selectedImages = [];
    currentCallback = null;
}

function switchImageTab(tab) {
    // Update tab buttons
    document.querySelectorAll('[id$="-tab"]').forEach(btn => {
        btn.classList.remove('border-blue-500', 'text-blue-600');
        btn.classList.add('border-transparent', 'text-gray-500');
    });
    document.getElementById(tab + '-tab').classList.add('border-blue-500', 'text-blue-600');
    document.getElementById(tab + '-tab').classList.remove('border-transparent', 'text-gray-500');

    // Update tab content
    document.querySelectorAll('.image-tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    document.getElementById(tab + '-content').classList.remove('hidden');
}

function handleImageUpload(input) {
    if (input.files && input.files.length > 0) {
        Array.from(input.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imageData = {
                    type: 'file',
                    file: file,
                    url: e.target.result,
                    name: file.name
                };
                selectedImages.push(imageData);
                updateSelectedCount();
            };
            reader.readAsDataURL(file);
        });
    }
}

function addImageFromUrl() {
    const url = document.getElementById('image-url').value;
    if (url && url.trim() !== '') {
        const imageData = {
            type: 'url',
            url: url,
            name: url.split('/').pop() || 'image.jpg'
        };
        selectedImages.push(imageData);
        updateSelectedCount();
        document.getElementById('image-url').value = '';
    }
}

function updateSelectedCount() {
    document.getElementById('selected-count').textContent = selectedImages.length;
}

function confirmImageSelection() {
    if (currentCallback && selectedImages.length > 0) {
        currentCallback(selectedImages);
    }
    closeImageSelector();
}

// Global functions for use in forms
window.openImageSelector = openImageSelector;
window.closeImageSelector = closeImageSelector;
</script>
