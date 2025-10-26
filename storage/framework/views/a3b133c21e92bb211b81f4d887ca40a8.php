<?php $__env->startSection('content'); ?>
<?php if(session('status')): ?>
<div class="mb-4 rounded-lg bg-green-100 dark:bg-green-900/50 p-4 text-green-700 dark:text-green-300">
<?php echo e(session('status')); ?>

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
<a href="<?php echo e(route('admin.categories.create')); ?>" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium">+ Add Category</a>
</div>
</div>

<!-- Page Header -->
<div class="flex items-center justify-between mb-6">
<h1 class="text-slate-800 dark:text-white text-3xl font-bold">Categories</h1>
</div>

<!-- Filter and Search Controls -->
<div class="bg-white dark:bg-[#111a22] rounded-lg border border-slate-200 dark:border-[#324d67] p-6 mb-6">
<form method="GET" action="<?php echo e(route('admin.categories.index')); ?>" class="flex items-center gap-4">
<div class="flex items-center gap-2">
<label class="text-slate-600 dark:text-[#92adc9] text-sm font-medium">Show</label>
<select name="per_page" class="border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white text-sm">
<option value="10" <?php echo e(request('per_page') == '10' ? 'selected' : ''); ?>>10</option>
<option value="15" <?php echo e(request('per_page') == '15' || !request('per_page') ? 'selected' : ''); ?>>15</option>
<option value="25" <?php echo e(request('per_page') == '25' ? 'selected' : ''); ?>>25</option>
<option value="50" <?php echo e(request('per_page') == '50' ? 'selected' : ''); ?>>50</option>
<option value="100" <?php echo e(request('per_page') == '100' ? 'selected' : ''); ?>>100</option>
</select>
</div>

<div class="flex items-center gap-2">
<label class="text-slate-600 dark:text-[#92adc9] text-sm font-medium">Language</label>
<select name="language" class="border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white text-sm">
<?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<option value="<?php echo e($value); ?>" <?php echo e(request('language') == $value ? 'selected' : ''); ?>><?php echo e($label); ?></option>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select>
</div>

<div class="flex items-center gap-2">
<label class="text-slate-600 dark:text-[#92adc9] text-sm font-medium">Parent Category</label>
<select name="parent_category" class="border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white text-sm">
<option value="all" <?php echo e(request('parent_category') == 'all' ? 'selected' : ''); ?>>All</option>
<option value="none" <?php echo e(request('parent_category') == 'none' ? 'selected' : ''); ?>>-</option>
<?php $__currentLoopData = $parentCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<option value="<?php echo e($parent->id); ?>" <?php echo e(request('parent_category') == $parent->id ? 'selected' : ''); ?>><?php echo e($parent->name); ?></option>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select>
</div>

<div class="flex items-center gap-2">
<input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search" class="border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white text-sm w-48">
</div>

<button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium">Filter</button>
</form>
</div>

<!-- Categories Table -->
<div class="rounded-lg border border-slate-200 dark:border-[#324d67] bg-white dark:bg-[#111a22] overflow-hidden">
<table class="w-full">
<thead>
<tr class="bg-slate-50 dark:bg-[#192633]">
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">Id</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">Category Name</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">Language</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">Parent Category</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">Order</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">Color</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">Status</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">Options</th>
</tr>
</thead>
<tbody>
<?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<tr class="border-t border-slate-200 dark:border-[#324d67] hover:bg-slate-50 dark:hover:bg-[#192633]">
<td class="px-4 py-3 text-slate-600 dark:text-white text-sm"><?php echo e($category->id); ?></td>
<td class="px-4 py-3 text-slate-800 dark:text-white text-sm font-medium"><?php echo e($category->name); ?></td>
<td class="px-4 py-3 text-slate-600 dark:text-white text-sm"><?php echo e(ucfirst($category->language)); ?></td>
<td class="px-4 py-3 text-slate-600 dark:text-white text-sm">
<?php if($category->parent): ?>
<?php echo e($category->parent->name); ?>

<?php else: ?>
-
<?php endif; ?>
</td>
<td class="px-4 py-3 text-slate-600 dark:text-white text-sm"><?php echo e($category->order); ?></td>
<td class="px-4 py-3 text-slate-600 dark:text-white text-sm">
<div class="flex items-center gap-2">
<div class="w-4 h-4 rounded-full border border-slate-300" style="background-color: <?php echo e($category->color); ?>"></div>
<span class="text-xs"><?php echo e($category->color); ?></span>
</div>
</td>
<td class="px-4 py-3 text-slate-600 dark:text-white text-sm">
<?php if($category->status): ?>
<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
Active
</span>
<?php else: ?>
<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
Inactive
</span>
<?php endif; ?>
</td>
<td class="px-4 py-3">
<select class="border border-slate-300 dark:border-[#324d67] rounded px-2 py-1 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white text-xs" onchange="handleOptionChange(this, <?php echo e($category->id); ?>)">
<option value="">Select an option</option>
<option value="edit">Edit</option>
<option value="delete">Delete</option>
<option value="toggle-status">Toggle Status</option>
</select>
</div>
</td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
<tr>
<td colspan="8" class="px-4 py-8 text-center text-slate-500 dark:text-[#92adc9]">No categories found.</td>
</tr>
<?php endif; ?>
</tbody>
</table>
</div>

<!-- Pagination -->
<?php if($categories->hasPages()): ?>
<div class="mt-6">
<?php echo e($categories->links()); ?>

</div>
<?php endif; ?>

<script>
function handleOptionChange(select, categoryId) {
    const value = select.value;
    if (value === 'edit') {
        window.location.href = `/admin/categories/${categoryId}/edit`;
    } else if (value === 'delete') {
        if (confirm('Are you sure you want to delete this category?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/categories/${categoryId}`;
            form.innerHTML = '<?php echo csrf_field(); ?> <?php echo method_field("DELETE"); ?>';
            document.body.appendChild(form);
            form.submit();
        }
    } else if (value === 'toggle-status') {
        // Handle toggle status
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/categories/${categoryId}/toggle-status`;
        form.innerHTML = '<?php echo csrf_field(); ?>';
        document.body.appendChild(form);
        form.submit();
    }
    select.value = '';
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Laravel Projects\Multi Author Blog\resources\views\admin\categories\index.blade.php ENDPATH**/ ?>