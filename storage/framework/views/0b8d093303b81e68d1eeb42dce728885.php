<?php $__env->startSection('content'); ?>
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

<!-- Page Header -->
<div class="flex items-center justify-between mb-6">
<h1 class="text-slate-800 dark:text-white text-3xl font-bold">Scheduled Posts</h1>
<a href="<?php echo e(route('admin.posts.index')); ?>" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium">All Posts</a>
</div>

<!-- Posts Table -->
<div class="rounded-lg border border-slate-200 dark:border-[#324d67] bg-white dark:bg-[#111a22] overflow-hidden">
<table class="w-full">
<thead>
<tr class="bg-slate-50 dark:bg-[#192633]">
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">ID</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">Title</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">Author</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">Category</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">Scheduled For</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">Status</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">Actions</th>
</tr>
</thead>
<tbody>
<?php $__empty_1 = true; $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<tr class="border-t border-slate-200 dark:border-[#324d67] hover:bg-slate-50 dark:hover:bg-[#192633]">
<td class="px-4 py-3 text-slate-600 dark:text-white text-sm"><?php echo e($post->id); ?></td>
<td class="px-4 py-3">
<div class="flex items-center gap-3">
<div class="w-10 h-10 bg-purple-200 dark:bg-purple-800 rounded"></div>
<div>
<p class="text-slate-800 dark:text-white text-sm font-medium"><?php echo e(Str::limit($post->title, 50)); ?></p>
<p class="text-slate-500 dark:text-[#92adc9] text-xs"><?php echo e($post->created_at->format('M d, Y')); ?></p>
</div>
</div>
</td>
<td class="px-4 py-3 text-slate-600 dark:text-white text-sm"><?php echo e($post->user->name); ?></td>
<td class="px-4 py-3 text-slate-600 dark:text-white text-sm"><?php echo e($post->category->name ?? 'Uncategorized'); ?></td>
<td class="px-4 py-3 text-slate-600 dark:text-white text-sm"><?php echo e($post->published_at ? $post->published_at->format('M d, Y H:i') : '-'); ?></td>
<td class="px-4 py-3">
<span class="px-2 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300">
Scheduled
</span>
</td>
<td class="px-4 py-3">
<div class="flex items-center gap-2">
<a href="#" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-sm">View</a>
<a href="#" class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 text-sm">Edit</a>
<form method="POST" action="<?php echo e(route('admin.posts.destroy', $post)); ?>" class="inline">
<?php echo csrf_field(); ?>
<?php echo method_field('DELETE'); ?>
<button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 text-sm" onclick="return confirm('Are you sure?')">Delete</button>
</form>
</div>
</td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
<tr>
<td colspan="7" class="px-4 py-8 text-center text-slate-500 dark:text-[#92adc9]">No scheduled posts found.</td>
</tr>
<?php endif; ?>
</tbody>
</table>
</div>

<!-- Pagination -->
<?php if($posts->hasPages()): ?>
<div class="mt-6">
<?php echo e($posts->links()); ?>

</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Laravel Projects\Multi Author Blog\resources\views\admin\posts\scheduled.blade.php ENDPATH**/ ?>