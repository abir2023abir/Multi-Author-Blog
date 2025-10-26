

<?php $__env->startSection('content'); ?>
<!-- Success Messages -->
<?php if(session('status')): ?>
<div class="mb-4 rounded-lg bg-green-100 dark:bg-green-900/50 p-4 text-green-700 dark:text-green-300">
<?php echo e(session('status')); ?>

</div>
<?php endif; ?>

<div class="flex flex-wrap justify-between gap-3 pb-8">
<div class="flex flex-col gap-3">
<h1 class="text-slate-800 dark:text-white text-4xl font-black leading-tight tracking-[-0.033em]">Comments</h1>
<p class="text-slate-500 dark:text-[#92adc9] text-base font-normal leading-normal">Manage and moderate blog comments.</p>
</div>
<div class="flex items-center gap-4">
<span class="material-symbols-outlined text-slate-500 dark:text-white cursor-pointer">notifications</span>
<div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10 bg-gray-300 dark:bg-gray-600"></div>
</div>
</div>

<div class="overflow-hidden rounded-lg border border-slate-200 dark:border-[#324d67] bg-white dark:bg-[#111a22]">
<table class="w-full">
<thead>
<tr class="bg-slate-50 dark:bg-[#192633]">
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium leading-normal">Post</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium leading-normal">Author</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium leading-normal">Comment</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium leading-normal">Actions</th>
</tr>
</thead>
<tbody>
<?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr class="border-t border-t-slate-200 dark:border-t-[#324d67]">
<td class="h-[72px] px-4 py-2 text-slate-800 dark:text-white text-sm font-normal leading-normal">
<a class="text-primary hover:underline" href="<?php echo e(route('posts.show', $c->post)); ?>"><?php echo e(Str::limit($c->post->title, 30)); ?></a>
</td>
<td class="h-[72px] px-4 py-2 text-slate-500 dark:text-[#92adc9] text-sm font-normal leading-normal"><?php echo e(optional($c->user)->name ?? 'Guest'); ?></td>
<td class="h-[72px] px-4 py-2 text-slate-500 dark:text-[#92adc9] text-sm font-normal leading-normal"><?php echo e(Str::limit($c->content, 80)); ?></td>
<td class="h-[72px] px-4 py-2 text-sm font-normal leading-normal">
<div class="flex gap-2">
<form method="POST" action="<?php echo e(route('admin.comments.destroy', $c)); ?>" class="inline">
<?php echo csrf_field(); ?>
<?php echo method_field('DELETE'); ?>
<button type="submit" class="text-xs font-medium text-red-600 hover:text-red-500" onclick="return confirm('Are you sure?')">Delete</button>
</form>
</div>
</td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</tbody>
</table>
<div class="p-4 border-t border-slate-200 dark:border-t-[#324d67]">
<?php echo e($comments->links()); ?>

</div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Laravel Projects\Multi Author Blog\resources\views\admin\comments\index.blade.php ENDPATH**/ ?>