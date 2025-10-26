

<?php $__env->startSection('content'); ?>
<?php if(session('status')): ?>
<div class="mb-4 rounded-lg bg-green-100 dark:bg-green-900/50 p-4 text-green-700 dark:text-green-300">
<?php echo e(session('status')); ?>

</div>
<?php endif; ?>

<div class="flex flex-wrap justify-between gap-3 pb-8">
<div class="flex flex-col gap-3">
<h1 class="text-slate-800 dark:text-white text-4xl font-black leading-tight tracking-[-0.033em]">Storage</h1>
<p class="text-slate-500 dark:text-[#92adc9] text-base font-normal leading-normal">Manage file storage and media files.</p>
</div>
<div class="flex items-center gap-4">
<span class="material-symbols-outlined text-slate-500 dark:text-white cursor-pointer">notifications</span>
<div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10 bg-gray-300 dark:bg-gray-600"></div>
</div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
<div class="rounded-lg border border-slate-200 dark:border-[#324d67] bg-white dark:bg-[#111a22] p-6">
<p class="text-slate-600 dark:text-white text-base font-medium leading-normal">Total Files</p>
<p class="text-slate-800 dark:text-white tracking-light text-2xl font-bold leading-tight"><?php echo e($totalFiles); ?></p>
</div>
<div class="rounded-lg border border-slate-200 dark:border-[#324d67] bg-white dark:bg-[#111a22] p-6">
<p class="text-slate-600 dark:text-white text-base font-medium leading-normal">Total Size</p>
<p class="text-slate-800 dark:text-white tracking-light text-2xl font-bold leading-tight"><?php echo e($totalSize); ?> MB</p>
</div>
<div class="rounded-lg border border-slate-200 dark:border-[#324d67] bg-white dark:bg-[#111a22] p-6">
<form method="POST" action="<?php echo e(route('admin.storage.clean')); ?>">
<?php echo csrf_field(); ?>
<button type="submit" class="flex items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-red-600 text-white text-sm font-bold leading-normal tracking-[0.015em]">
Clean Storage
</button>
</form>
</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Laravel Projects\Multi Author Blog\resources\views\admin\storage\index.blade.php ENDPATH**/ ?>