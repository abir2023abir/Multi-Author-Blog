<?php $__env->startSection('content'); ?>
<?php if(session('status')): ?>
<div class="mb-4 rounded-lg bg-green-100 dark:bg-green-900/50 p-4 text-green-700 dark:text-green-300">
<?php echo e(session('status')); ?>

</div>
<?php endif; ?>

<div class="flex flex-wrap justify-between gap-3 pb-8">
<div class="flex flex-col gap-3">
<h1 class="text-slate-800 dark:text-white text-4xl font-black leading-tight tracking-[-0.033em]">Create New Page</h1>
<p class="text-slate-500 dark:text-[#92adc9] text-base font-normal leading-normal">Add a new static page to your website.</p>
</div>
<div class="flex items-center gap-4">
<a href="<?php echo e(route('admin.pages.index')); ?>" class="flex items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-slate-600 text-white text-sm font-bold leading-normal tracking-[0.015em]">
<span class="truncate">Back to Pages</span>
</a>
<span class="material-symbols-outlined text-slate-500 dark:text-white cursor-pointer">notifications</span>
<div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10 bg-gray-300 dark:bg-gray-600"></div>
</div>
</div>

<div class="rounded-lg border border-slate-200 dark:border-[#324d67] bg-white dark:bg-[#111a22] p-6">
<form method="POST" action="<?php echo e(route('admin.pages.store')); ?>">
<?php echo csrf_field(); ?>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
<div class="lg:col-span-2">
<div class="mb-4">
<label class="text-slate-800 dark:text-white text-sm font-medium mb-2 block">Page Title <span class="text-red-500">*</span></label>
<input type="text" name="title" value="<?php echo e(old('title')); ?>" class="w-full border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Enter page title">
<?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
<p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div class="mb-4">
<label class="text-slate-800 dark:text-white text-sm font-medium mb-2 block">Slug <span class="text-red-500">*</span></label>
<input type="text" name="slug" value="<?php echo e(old('slug')); ?>" class="w-full border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="page-url-slug">
<?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
<p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
<p class="text-slate-500 dark:text-[#92adc9] text-xs mt-1">URL-friendly version of the title (e.g., "about-us")</p>
</div>

<div class="mb-4">
<label class="text-slate-800 dark:text-white text-sm font-medium mb-2 block">Content <span class="text-red-500">*</span></label>
<textarea name="content" rows="15" class="w-full border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Enter page content"><?php echo e(old('content')); ?></textarea>
<?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
<p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>
</div>

<div class="lg:col-span-1">
<div class="mb-4">
<label class="text-slate-800 dark:text-white text-sm font-medium mb-2 block">Meta Description</label>
<textarea name="meta_description" rows="3" class="w-full border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white <?php $__errorArgs = ['meta_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Brief description for search engines"><?php echo e(old('meta_description')); ?></textarea>
<?php $__errorArgs = ['meta_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
<p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
<p class="text-slate-500 dark:text-[#92adc9] text-xs mt-1">Keep it under 160 characters</p>
</div>

<div class="mb-4">
<label class="text-slate-800 dark:text-white text-sm font-medium mb-2 block">Language</label>
<select name="language" class="w-full border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white <?php $__errorArgs = ['language'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
<option value="en" <?php echo e(old('language', 'en') == 'en' ? 'selected' : ''); ?>>English</option>
<option value="ar" <?php echo e(old('language') == 'ar' ? 'selected' : ''); ?>>Arabic</option>
</select>
<?php $__errorArgs = ['language'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
<p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div class="mb-4">
<label class="text-slate-800 dark:text-white text-sm font-medium mb-2 block">Location</label>
<select name="location" class="w-full border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
<option value="main_menu" <?php echo e(old('location', 'main_menu') == 'main_menu' ? 'selected' : ''); ?>>Main Menu</option>
<option value="footer" <?php echo e(old('location') == 'footer' ? 'selected' : ''); ?>>Footer</option>
<option value="top_menu" <?php echo e(old('location') == 'top_menu' ? 'selected' : ''); ?>>Top Menu</option>
</select>
<?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
<p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div class="mb-4">
<label class="text-slate-800 dark:text-white text-sm font-medium mb-2 block">Page Type</label>
<select name="page_type" class="w-full border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white <?php $__errorArgs = ['page_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
<option value="custom" <?php echo e(old('page_type', 'custom') == 'custom' ? 'selected' : ''); ?>>Custom</option>
<option value="default" <?php echo e(old('page_type') == 'default' ? 'selected' : ''); ?>>Default</option>
</select>
<?php $__errorArgs = ['page_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
<p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div class="mb-4">
<label class="text-slate-800 dark:text-white text-sm font-medium mb-2 block">Status</label>
<select name="is_published" class="w-full border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white <?php $__errorArgs = ['is_published'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
<option value="1" <?php echo e(old('is_published', '1') == '1' ? 'selected' : ''); ?>>Published</option>
<option value="0" <?php echo e(old('is_published') == '0' ? 'selected' : ''); ?>>Draft</option>
</select>
<?php $__errorArgs = ['is_published'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
<p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>
</div>
</div>

<div class="flex gap-3 pt-6 border-t border-slate-200 dark:border-[#324d67]">
<button type="submit" class="flex items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-primary text-white text-sm font-bold leading-normal tracking-[0.015em]">
<span class="truncate">Create Page</span>
</button>
<a href="<?php echo e(route('admin.pages.index')); ?>" class="flex items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-slate-600 text-white text-sm font-bold leading-normal tracking-[0.015em]">
<span class="truncate">Cancel</span>
</a>
</div>
</form>
</div>

<script>
// Auto-generate slug from title
document.querySelector('input[name="title"]').addEventListener('input', function() {
    const title = this.value;
    const slug = title
        .toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .trim('-');

    document.querySelector('input[name="slug"]').value = slug;
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Laravel Projects\Multi Author Blog\resources\views\admin\pages\create.blade.php ENDPATH**/ ?>