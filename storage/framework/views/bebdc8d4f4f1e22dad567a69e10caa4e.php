<?php $__env->startSection('content'); ?>
<div class="flex items-center justify-between mb-6">
<h1 class="text-slate-800 dark:text-white text-3xl font-bold">Poll Results</h1>
<a href="<?php echo e(route('admin.polls.index')); ?>" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium">Back to Polls</a>
</div>

<div class="bg-white dark:bg-[#111a22] rounded-lg border border-slate-200 dark:border-[#324d67] p-6">
<h2 class="text-xl font-bold text-slate-800 dark:text-white mb-4"><?php echo e($poll->question); ?></h2>
<p class="text-slate-600 dark:text-[#92adc9] mb-6">Language: <?php echo e(ucfirst($poll->language)); ?> | Status:
<?php if($poll->is_active): ?>
<span class="text-green-600 dark:text-green-400">Active</span>
<?php else: ?>
<span class="text-red-600 dark:text-red-400">Inactive</span>
<?php endif; ?>
</p>

<div class="space-y-4">
<?php $__currentLoopData = $poll->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-[#192633] rounded-lg">
<span class="text-slate-800 dark:text-white font-medium"><?php echo e($option); ?></span>
<div class="flex items-center gap-4">
<div class="w-32 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
<div class="bg-blue-600 h-2 rounded-full" style="width: <?php echo e(rand(20, 80)); ?>%"></div>
</div>
<span class="text-slate-600 dark:text-[#92adc9] text-sm"><?php echo e(rand(10, 100)); ?>%</span>
</div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<div class="mt-6 text-center">
<p class="text-slate-600 dark:text-[#92adc9]">Total Votes: <?php echo e(rand(50, 500)); ?></p>
</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Laravel Projects\Multi Author Blog\resources\views\admin\polls\results.blade.php ENDPATH**/ ?>