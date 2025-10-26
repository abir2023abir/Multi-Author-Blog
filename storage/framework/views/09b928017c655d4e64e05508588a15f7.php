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

<div class="flex flex-wrap justify-between gap-3 pb-8">
<div class="flex flex-col gap-3">
<h1 class="text-slate-800 dark:text-white text-4xl font-black leading-tight tracking-[-0.033em]">Plugins</h1>
<p class="text-slate-500 dark:text-[#92adc9] text-base font-normal leading-normal">Extend your blog's functionality with plugins.</p>
</div>
<div class="flex items-center gap-4">
<span class="material-symbols-outlined text-slate-500 dark:text-white cursor-pointer">notifications</span>
<div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10 bg-gray-300 dark:bg-gray-600"></div>
</div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
<?php $__currentLoopData = $availablePlugins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plugin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="rounded-lg border border-slate-200 dark:border-[#324d67] bg-white dark:bg-[#111a22] p-6">
<div class="flex items-start justify-between">
<div class="flex-1">
<h3 class="text-slate-800 dark:text-white text-lg font-bold mb-2"><?php echo e($plugin['title']); ?></h3>
<p class="text-slate-500 dark:text-[#92adc9] text-sm mb-4"><?php echo e($plugin['description']); ?></p>
</div>
<?php if($plugin['active']): ?>
<span class="inline-flex items-center justify-center rounded-full bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-300 px-2.5 py-0.5 text-xs font-medium">Active</span>
<?php else: ?>
<span class="inline-flex items-center justify-center rounded-full bg-gray-100 dark:bg-gray-900/50 text-gray-700 dark:text-gray-300 px-2.5 py-0.5 text-xs font-medium">Inactive</span>
<?php endif; ?>
</div>
<div class="flex gap-2 mt-4">
<?php if($plugin['active']): ?>
<form method="POST" action="<?php echo e(route('admin.plugins.deactivate')); ?>">
<?php echo csrf_field(); ?>
<input type="hidden" name="plugin" value="<?php echo e($plugin['name']); ?>">
<button type="submit" class="text-xs font-medium text-red-600 hover:text-red-500">Deactivate</button>
</form>
<?php else: ?>
<form method="POST" action="<?php echo e(route('admin.plugins.activate')); ?>">
<?php echo csrf_field(); ?>
<input type="hidden" name="plugin" value="<?php echo e($plugin['name']); ?>">
<button type="submit" class="text-xs font-medium text-primary hover:text-primary/80">Activate</button>
</form>
<?php endif; ?>
</div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Laravel Projects\Multi Author Blog\resources\views\admin\plugins\index.blade.php ENDPATH**/ ?>