<?php $__env->startSection('content'); ?>
<?php if(session('status')): ?>
<div class="mb-4 rounded-lg bg-green-100 dark:bg-green-900/50 p-4 text-green-700 dark:text-green-300">
<?php echo e(session('status')); ?>

</div>
<?php endif; ?>

<!-- Header -->
<div class="bg-gray-800 text-white px-6 py-4 mb-6">
<div class="flex items-center justify-between">
<div class="flex items-center gap-4">
<button class="p-2 hover:bg-gray-700 rounded">
<span class="material-symbols-outlined">menu</span>
</button>
<h1 class="text-xl font-bold">Navigation Management</h1>
</div>
<div class="flex items-center gap-4">
<a href="<?php echo e(route('home')); ?>" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm font-medium">View Site</a>
<select class="bg-gray-700 text-white px-3 py-2 rounded text-sm">
<option>English</option>
<option>Spanish</option>
<option>French</option>
</select>
<div class="flex items-center gap-2">
<span class="text-sm">admin</span>
<div class="w-8 h-8 bg-gray-600 rounded-full flex items-center justify-center">
<span class="material-symbols-outlined text-sm">person</span>
</div>
</div>
</div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
<!-- Left Section - Navigation Management -->
<div class="lg:col-span-2 space-y-6">
<!-- Language Selection -->
<div class="bg-white border border-gray-200 rounded-lg p-4">
<h2 class="text-lg font-semibold text-gray-800 mb-3">Language</h2>
<select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
<option selected>English</option>
<option>Spanish</option>
<option>French</option>
</select>
</div>

<!-- Navigation Items -->
<div class="bg-white border border-gray-200 rounded-lg p-4">
<h2 class="text-lg font-semibold text-gray-800 mb-2">Navigation</h2>
<p class="text-sm text-gray-600 mb-4">You can manage the navigation by dragging and dropping menu items.</p>

<div class="space-y-2" id="navigation-list">
<?php $__empty_1 = true; $__currentLoopData = $navigations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $navigation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<div class="flex items-center justify-between p-3 bg-gray-50 border border-gray-200 rounded hover:bg-gray-100 transition-colors navigation-item" data-id="<?php echo e($navigation->id); ?>">
<div class="flex items-center gap-3">
<span class="material-symbols-outlined text-gray-400 cursor-move drag-handle">drag_indicator</span>
<div>
<h3 class="font-medium text-gray-800"><?php echo e($navigation->name); ?></h3>
<p class="text-sm text-gray-500"><?php echo e($navigation->url); ?></p>
</div>
</div>
<div class="flex items-center gap-2">
<span class="text-xs px-2 py-1 bg-blue-100 text-blue-800 rounded"><?php echo e(ucfirst($navigation->type ?? 'link')); ?></span>
<?php if($navigation->name !== 'Home'): ?>
<div class="flex gap-1">
<button class="p-1 text-gray-500 hover:text-blue-600 edit-nav" data-id="<?php echo e($navigation->id); ?>">
<span class="material-symbols-outlined text-sm">edit</span>
</button>
<button class="p-1 text-gray-500 hover:text-red-600 delete-nav" data-id="<?php echo e($navigation->id); ?>">
<span class="material-symbols-outlined text-sm">delete</span>
</button>
<button class="p-1 text-gray-500 hover:text-green-600 add-sub-nav" data-id="<?php echo e($navigation->id); ?>">
<span class="material-symbols-outlined text-sm">add</span>
</button>
</div>
<?php else: ?>
<button class="p-1 text-gray-500 hover:text-gray-700">
<span class="material-symbols-outlined text-sm">visibility_off</span>
</button>
<div class="flex gap-1">
<button class="p-1 text-gray-500 hover:text-blue-600 edit-nav" data-id="<?php echo e($navigation->id); ?>">
<span class="material-symbols-outlined text-sm">edit</span>
</button>
<button class="p-1 text-gray-500 hover:text-red-600 delete-nav" data-id="<?php echo e($navigation->id); ?>">
<span class="material-symbols-outlined text-sm">delete</span>
</button>
<button class="p-1 text-gray-500 hover:text-green-600 add-sub-nav" data-id="<?php echo e($navigation->id); ?>">
<span class="material-symbols-outlined text-sm">add</span>
</button>
</div>
<?php endif; ?>
</div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
<div class="text-center py-8 text-gray-500">No navigation items found.</div>
<?php endif; ?>
</div>

<!-- Warning Message -->
<div class="mt-4 p-3 bg-red-50 border border-red-200 rounded text-red-700 text-sm">
<strong>Warning!</strong> You cannot drag a category below a page or a page below a category link!
</div>
</div>
</div>

<!-- Right Section - Add Menu Link and Menu Limit -->
<div class="space-y-6">
<!-- Add Menu Link Form -->
<div class="bg-white border border-gray-200 rounded-lg p-4">
<h2 class="text-lg font-semibold text-gray-800 mb-4">Add Menu Link</h2>
<form method="POST" action="<?php echo e(route('admin.navigation.store')); ?>" class="space-y-4">
<?php echo csrf_field(); ?>
<div>
<label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
<input type="text" name="name" required placeholder="Title" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
</div>
<div>
<label class="block text-sm font-medium text-gray-700 mb-2">Link</label>
<input type="text" name="url" required placeholder="Link" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
</div>
<div>
<label class="block text-sm font-medium text-gray-700 mb-2">Menu Order</label>
<input type="number" name="order" value="1" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
</div>
<div>
<label class="block text-sm font-medium text-gray-700 mb-2">Parent Link</label>
<select name="parent_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
<option value="">None</option>
<?php $__currentLoopData = $navigations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nav): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<option value="<?php echo e($nav->id); ?>"><?php echo e($nav->name); ?></option>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select>
</div>
<div>
<label class="block text-sm font-medium text-gray-700 mb-3">Show on Menu</label>
<div class="flex gap-4">
<label class="flex items-center">
<input type="radio" name="is_active" value="1" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
<span class="ml-2 text-sm text-gray-700">Yes</span>
</label>
<label class="flex items-center">
<input type="radio" name="is_active" value="0" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
<span class="ml-2 text-sm text-gray-700">No</span>
</label>
</div>
</div>
<button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md font-medium transition-colors">
Add Menu Link
</button>
</form>
</div>

<!-- Menu Limit -->
<div class="bg-white border border-gray-200 rounded-lg p-4">
<h2 class="text-lg font-semibold text-gray-800 mb-2">Menu Limit</h2>
<p class="text-sm text-gray-600 mb-3">Menu Limit (The number of links that appear in the menu)</p>
<form method="POST" action="<?php echo e(route('admin.navigation.update-limit')); ?>">
<?php echo csrf_field(); ?>
<input type="number" name="menu_limit" value="9" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent mb-3">
<button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md font-medium transition-colors">
Save Changes
</button>
</form>
</div>
</div>
</div>

<!-- Drag and Drop Script -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize sortable for navigation items
    const navList = document.getElementById('navigation-list');
    if (navList) {
        new Sortable(navList, {
            handle: '.drag-handle',
            animation: 150,
            onEnd: function(evt) {
                // Update order in database
                const items = Array.from(navList.children);
                const orderData = items.map((item, index) => ({
                    id: item.dataset.id,
                    order: index
                }));

                fetch('<?php echo e(route("admin.navigation.update-order")); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ items: orderData })
                });
            }
        });
    }

    // Delete navigation item
    document.querySelectorAll('.delete-nav').forEach(button => {
        button.addEventListener('click', function() {
            if (confirm('Are you sure you want to delete this navigation item?')) {
                const id = this.dataset.id;
                fetch(`/admin/navigation/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }).then(() => {
                    location.reload();
                });
            }
        });
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Laravel Projects\Multi Author Blog\resources\views\admin\navigation\index.blade.php ENDPATH**/ ?>