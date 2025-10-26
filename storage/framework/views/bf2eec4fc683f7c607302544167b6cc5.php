

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
<a href="<?php echo e(route('admin.widgets.create')); ?>" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium">+ Add Widget</a>
</div>
</div>

<!-- Page Header -->
<div class="flex items-center justify-between mb-6">
<h1 class="text-slate-800 dark:text-white text-3xl font-bold">Widgets</h1>
</div>

<!-- Filter and Search Controls -->
<div class="bg-white dark:bg-[#111a22] rounded-lg border border-slate-200 dark:border-[#324d67] p-6 mb-6">
<form method="GET" action="<?php echo e(route('admin.widgets.index')); ?>" class="flex items-center gap-4">
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
<input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search" class="border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white text-sm w-48">
</div>

<button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium">Filter</button>
</form>
</div>

<!-- Widgets Table -->
<div class="rounded-lg border border-slate-200 dark:border-[#324d67] bg-white dark:bg-[#111a22] overflow-hidden">
<table class="w-full">
<thead>
<tr class="bg-slate-50 dark:bg-[#192633]">
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">Id</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">Title</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">Language</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">Where To Display</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">Order</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">Type</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">Visibility</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">Date Added</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">Options</th>
</tr>
</thead>
<tbody>
<?php $__empty_1 = true; $__currentLoopData = $widgets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $widget): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<tr class="border-t border-slate-200 dark:border-[#324d67] hover:bg-slate-50 dark:hover:bg-[#192633]">
<td class="px-4 py-3 text-slate-600 dark:text-white text-sm"><?php echo e($widget->id); ?></td>
<td class="px-4 py-3 text-slate-800 dark:text-white text-sm font-medium"><?php echo e($widget->title); ?></td>
<td class="px-4 py-3 text-slate-600 dark:text-white text-sm"><?php echo e(ucfirst($widget->language)); ?></td>
<td class="px-4 py-3 text-slate-600 dark:text-white text-sm"><?php echo e($widget->where_to_display); ?></td>
<td class="px-4 py-3 text-slate-600 dark:text-white text-sm"><?php echo e($widget->order); ?></td>
<td class="px-4 py-3 text-slate-600 dark:text-white text-sm"><?php echo e($widget->type); ?></td>
<td class="px-4 py-3 text-slate-600 dark:text-white text-sm">
<?php if($widget->visibility): ?>
<span class="inline-flex items-center text-green-600 dark:text-green-400">
<span class="material-symbols-outlined text-sm mr-1">visibility</span>
Visible
</span>
<?php else: ?>
<span class="inline-flex items-center text-red-600 dark:text-red-400">
<span class="material-symbols-outlined text-sm mr-1">visibility_off</span>
Hidden
</span>
<?php endif; ?>
</td>
<td class="px-4 py-3 text-slate-600 dark:text-white text-sm"><?php echo e($widget->date_added->format('Y-m-d / H:i')); ?></td>
<td class="px-4 py-3">
<select class="border border-slate-300 dark:border-[#324d67] rounded px-2 py-1 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white text-xs" onchange="handleOptionChange(this, <?php echo e($widget->id); ?>)">
<option value="">Select an option</option>
<option value="edit">Edit</option>
<option value="delete">Delete</option>
<option value="toggle-visibility">Toggle Visibility</option>
<option value="duplicate">Duplicate</option>
</select>
</div>
</td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
<tr>
<td colspan="9" class="px-4 py-8 text-center text-slate-500 dark:text-[#92adc9]">No widgets found.</td>
</tr>
<?php endif; ?>
</tbody>
</table>
</div>

<!-- Pagination -->
<?php if($widgets->hasPages()): ?>
<div class="mt-6">
<?php echo e($widgets->links()); ?>

</div>
<?php endif; ?>

<script>
function handleOptionChange(select, widgetId) {
    const value = select.value;
    if (value === 'edit') {
        window.location.href = `/admin/widgets/${widgetId}/edit`;
    } else if (value === 'delete') {
        if (confirm('Are you sure you want to delete this widget?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/widgets/${widgetId}`;
            form.innerHTML = '<?php echo csrf_field(); ?> <?php echo method_field("DELETE"); ?>';
            document.body.appendChild(form);
            form.submit();
        }
    } else if (value === 'toggle-visibility') {
        // Handle toggle visibility
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/widgets/${widgetId}/toggle-visibility`;
        form.innerHTML = '<?php echo csrf_field(); ?>';
        document.body.appendChild(form);
        form.submit();
    } else if (value === 'duplicate') {
        // Handle duplicate
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/widgets/${widgetId}/duplicate`;
        form.innerHTML = '<?php echo csrf_field(); ?>';
        document.body.appendChild(form);
        form.submit();
    }
    select.value = '';
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Laravel Projects\Multi Author Blog\resources\views\admin\widgets\index.blade.php ENDPATH**/ ?>