<?php $__env->startSection('content'); ?>
<?php if(session('status')): ?>
<div class="mb-4 rounded-lg bg-green-100 dark:bg-green-900/50 p-4 text-green-700 dark:text-green-300">
<?php echo e(session('status')); ?>

</div>
<?php endif; ?>

<?php if(session('error')): ?>
<div class="mb-4 rounded-lg bg-red-100 dark:bg-red-900/50 p-4 text-red-700 dark:text-red-300">
<?php echo e(session('error')); ?>

</div>
<?php endif; ?>

<!-- Top Header Bar -->
<div class="flex items-center justify-between mb-6">
<div class="flex items-center gap-4">
<span class="material-symbols-outlined text-slate-500 dark:text-white cursor-pointer text-2xl">menu</span>
</div>
<div class="flex items-center gap-4">
<a href="<?php echo e(route('home')); ?>" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium">View Site</a>
<select class="border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white text-sm">
<option>English</option>
<option>Arabic</option>
</select>
<div class="w-8 h-8 bg-gray-300 dark:bg-gray-600 rounded-full"></div>
<select class="border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white text-sm">
<option>admin</option>
</select>
</div>
</div>

<!-- Main Content Area -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
<!-- Left Column - Bulk Post Upload -->
<div class="lg:col-span-2">
<div class="rounded-lg border border-slate-200 dark:border-[#324d67] bg-white dark:bg-[#111a22] p-8">
<h2 class="text-slate-800 dark:text-white text-2xl font-bold mb-3">Bulk Post Upload</h2>
<p class="text-slate-600 dark:text-[#92adc9] text-sm mb-8">You can add your posts with a CSV file from this section</p>

<!-- Drag and Drop Upload Area -->
<div id="dropZone" class="border-2 border-dashed border-slate-300 dark:border-[#324d67] rounded-lg p-12 text-center hover:border-green-500 dark:hover:border-green-500 transition-colors cursor-pointer bg-slate-50 dark:bg-[#192633]">
<div class="mb-6">
<div class="w-16 h-16 bg-slate-400 dark:bg-slate-600 rounded-lg flex items-center justify-center mx-auto">
<span class="material-symbols-outlined text-white text-3xl">cloud_upload</span>
</div>
</div>
<p class="text-slate-600 dark:text-[#92adc9] text-lg mb-4">Drag and drop files here or</p>
<button type="button" id="browseBtn" class="bg-slate-500 hover:bg-slate-600 text-white px-6 py-2 rounded-lg text-sm font-medium">Browse Files</button>
<input type="file" id="fileInput" name="file" accept=".csv,.xlsx" class="hidden" required>
</div>

<!-- Upload Form -->
<form id="uploadForm" method="POST" action="<?php echo e(route('admin.posts.bulk.store')); ?>" enctype="multipart/form-data" class="mt-6">
<?php echo csrf_field(); ?>
<div class="hidden">
<input type="file" name="file" id="formFileInput" accept=".csv,.xlsx" required>
</div>
<button type="submit" id="uploadBtn" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg text-sm font-medium disabled:opacity-50 disabled:cursor-not-allowed" disabled>
Upload Posts
</button>
</form>
</div>
</div>

<!-- Right Column - Help Documents -->
<div class="lg:col-span-1">
<div class="rounded-lg border border-slate-200 dark:border-[#324d67] bg-white dark:bg-[#111a22] p-8">
<h2 class="text-slate-800 dark:text-white text-2xl font-bold mb-3">Help Documents</h2>
<p class="text-slate-600 dark:text-[#92adc9] text-sm mb-8">You can use these documents to generate your CSV file</p>

<div class="space-y-4">
<a href="<?php echo e(route('admin.posts.bulk.categories')); ?>" class="block w-full bg-slate-100 dark:bg-[#192633] hover:bg-slate-200 dark:hover:bg-[#2a3441] text-slate-700 dark:text-white px-4 py-3 rounded-lg text-sm font-medium text-center transition-colors">
Category Ids list
</a>

<a href="<?php echo e(route('admin.posts.bulk.template')); ?>" class="block w-full bg-slate-100 dark:bg-[#192633] hover:bg-slate-200 dark:hover:bg-[#2a3441] text-slate-700 dark:text-white px-4 py-3 rounded-lg text-sm font-medium text-center transition-colors">
Download CSV Template
</a>

<a href="<?php echo e(route('admin.posts.bulk.example')); ?>" class="block w-full bg-slate-100 dark:bg-[#192633] hover:bg-slate-200 dark:hover:bg-[#2a3441] text-slate-700 dark:text-white px-4 py-3 rounded-lg text-sm font-medium text-center transition-colors">
Download CSV Example
</a>

<a href="#" class="block w-full bg-slate-100 dark:bg-[#192633] hover:bg-slate-200 dark:hover:bg-[#2a3441] text-slate-700 dark:text-white px-4 py-3 rounded-lg text-sm font-medium text-center transition-colors">
Documentation
</a>
</div>
</div>
</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropZone = document.getElementById('dropZone');
    const browseBtn = document.getElementById('browseBtn');
    const fileInput = document.getElementById('fileInput');
    const formFileInput = document.getElementById('formFileInput');
    const uploadBtn = document.getElementById('uploadBtn');
    const uploadForm = document.getElementById('uploadForm');

    // Drag and drop functionality
    dropZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        dropZone.classList.add('border-green-500', 'bg-green-50', 'dark:bg-green-900/20');
    });

    dropZone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        dropZone.classList.remove('border-green-500', 'bg-green-50', 'dark:bg-green-900/20');
    });

    dropZone.addEventListener('drop', function(e) {
        e.preventDefault();
        dropZone.classList.remove('border-green-500', 'bg-green-50', 'dark:bg-green-900/20');

        const files = e.dataTransfer.files;
        if (files.length > 0) {
            handleFile(files[0]);
        }
    });

    // Browse button click
    browseBtn.addEventListener('click', function() {
        fileInput.click();
    });

    // File input change
    fileInput.addEventListener('change', function() {
        if (this.files.length > 0) {
            handleFile(this.files[0]);
        }
    });

    // Handle file selection
    function handleFile(file) {
        // Validate file type
        const allowedTypes = ['text/csv', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
        if (!allowedTypes.includes(file.type) && !file.name.match(/\.(csv|xlsx)$/i)) {
            alert('Please select a CSV or Excel file.');
            return;
        }

        // Validate file size (10MB)
        if (file.size > 10 * 1024 * 1024) {
            alert('File size must be less than 10MB.');
            return;
        }

        // Update form file input
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        formFileInput.files = dataTransfer.files;

        // Update UI
        dropZone.innerHTML = `
            <div class="mb-4">
                <div class="w-16 h-16 bg-green-500 rounded-lg flex items-center justify-center mx-auto">
                    <span class="material-symbols-outlined text-white text-3xl">check</span>
                </div>
            </div>
            <p class="text-green-600 dark:text-green-400 text-lg font-medium">${file.name}</p>
            <p class="text-slate-500 dark:text-[#92adc9] text-sm mt-2">File ready for upload</p>
            <button type="button" id="removeFile" class="mt-4 text-red-500 hover:text-red-700 text-sm">Remove file</button>
        `;

        // Enable upload button
        uploadBtn.disabled = false;

        // Add remove file functionality
        document.getElementById('removeFile').addEventListener('click', function() {
            resetDropZone();
        });
    }

    // Reset drop zone
    function resetDropZone() {
        dropZone.innerHTML = `
            <div class="mb-6">
                <div class="w-16 h-16 bg-slate-400 dark:bg-slate-600 rounded-lg flex items-center justify-center mx-auto">
                    <span class="material-symbols-outlined text-white text-3xl">cloud_upload</span>
                </div>
            </div>
            <p class="text-slate-600 dark:text-[#92adc9] text-lg mb-4">Drag and drop files here or</p>
            <button type="button" id="browseBtn" class="bg-slate-500 hover:bg-slate-600 text-white px-6 py-2 rounded-lg text-sm font-medium">Browse Files</button>
        `;

        formFileInput.value = '';
        uploadBtn.disabled = true;

        // Re-attach event listeners
        document.getElementById('browseBtn').addEventListener('click', function() {
            fileInput.click();
        });
    }

    // Form submission
    uploadForm.addEventListener('submit', function(e) {
        if (!formFileInput.files.length) {
            e.preventDefault();
            alert('Please select a file to upload.');
            return;
        }

        uploadBtn.disabled = true;
        uploadBtn.textContent = 'Uploading...';
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Laravel Projects\Multi Author Blog\resources\views\admin\bulk-posts\index.blade.php ENDPATH**/ ?>