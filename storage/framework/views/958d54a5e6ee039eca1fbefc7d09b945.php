

<?php $__env->startSection('content'); ?>
<?php if(session('status')): ?>
<div class="mb-4 rounded-lg bg-green-100 dark:bg-green-900/50 p-4 text-green-700 dark:text-green-300">
<?php echo e(session('status')); ?>

</div>
<?php endif; ?>

<div class="flex flex-wrap justify-between gap-3 pb-8">
<div class="flex flex-col gap-3">
<h1 class="text-slate-800 dark:text-white text-4xl font-black leading-tight tracking-[-0.033em]">Ad Spaces</h1>
<p class="text-slate-500 dark:text-[#92adc9] text-base font-normal leading-normal">Manage advertisement spaces and campaigns.</p>
</div>
<div class="flex items-center gap-4">
<a href="<?php echo e(route('admin.ads.create')); ?>" class="flex items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-primary text-white text-sm font-bold leading-normal tracking-[0.015em]">
<span class="truncate">New Ad</span>
</a>
<span class="material-symbols-outlined text-slate-500 dark:text-white cursor-pointer">notifications</span>
<div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10 bg-gray-300 dark:bg-gray-600"></div>
</div>
</div>

<div class="overflow-hidden rounded-lg border border-slate-200 dark:border-[#324d67] bg-white dark:bg-[#111a22]">
<table class="w-full">
<thead>
<tr class="bg-slate-50 dark:bg-[#192633]">
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium leading-normal">Name</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium leading-normal">Position</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium leading-normal">Status</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium leading-normal">Actions</th>
</tr>
</thead>
<tbody>
<?php $__empty_1 = true; $__currentLoopData = $ads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<tr class="border-t border-t-slate-200 dark:border-t-[#324d67]">
<td class="h-[72px] px-4 py-2 text-slate-800 dark:text-white text-sm font-normal leading-normal"><?php echo e($ad->name); ?></td>
<td class="h-[72px] px-4 py-2 text-slate-500 dark:text-[#92adc9] text-sm font-normal leading-normal"><?php echo e($ad->position); ?></td>
<td class="h-[72px] px-4 py-2 text-sm font-normal leading-normal">
<span class="inline-flex items-center justify-center rounded-full <?php echo e($ad->is_active ? 'bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-300' : 'bg-red-100 dark:bg-red-900/50 text-red-700 dark:text-red-300'); ?> px-2.5 py-0.5 text-xs font-medium"><?php echo e($ad->is_active ? 'Active' : 'Inactive'); ?></span>
</td>
<td class="h-[72px] px-4 py-2 text-sm font-normal leading-normal">
<div class="flex gap-2">
<a href="<?php echo e(route('admin.ads.edit', $ad)); ?>" class="text-xs font-medium text-primary hover:text-primary/80">Edit</a>
<form method="POST" action="<?php echo e(route('admin.ads.destroy', $ad)); ?>" class="inline">
<?php echo csrf_field(); ?>
<?php echo method_field('DELETE'); ?>
<button type="submit" class="text-xs font-medium text-red-600 hover:text-red-500" onclick="return confirm('Are you sure?')">Delete</button>
</form>
</div>
</td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
<tr>
<td colspan="4" class="px-4 py-8 text-center text-slate-500 dark:text-[#92adc9]">No ads found.</td>
</tr>
<?php endif; ?>
</tbody>
</table>
<div class="p-4 border-t border-slate-200 dark:border-t-[#324d67]">
<?php echo e($ads->links()); ?>

</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Laravel Projects\Multi Author Blog\resources\views\admin\ads\index.blade.php ENDPATH**/ ?>