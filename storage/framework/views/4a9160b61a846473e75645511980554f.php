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
</div>
</div>

<!-- Page Header -->
<div class="flex items-center justify-between mb-6">
<h1 class="text-slate-800 dark:text-white text-3xl font-bold">Pages</h1>
<a href="<?php echo e(route('admin.pages.create')); ?>" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium">+ Add Page</a>
</div>

<!-- Filtering and Search Controls -->
<div class="flex items-center justify-between mb-6">
<div class="flex items-center gap-4">
<div class="flex items-center gap-2">
<label class="text-slate-600 dark:text-[#92adc9] text-sm font-medium">Show</label>
<select name="per_page" onchange="this.form.submit()" class="border border-slate-300 dark:border-[#324d67] rounded px-3 py-1 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white text-sm">
<option value="10" <?php echo e(request('per_page') == '10' ? 'selected' : ''); ?>>10</option>
<option value="15" <?php echo e(request('per_page') == '15' || !request('per_page') ? 'selected' : ''); ?>>15</option>
<option value="25" <?php echo e(request('per_page') == '25' ? 'selected' : ''); ?>>25</option>
<option value="50" <?php echo e(request('per_page') == '50' ? 'selected' : ''); ?>>50</option>
<option value="100" <?php echo e(request('per_page') == '100' ? 'selected' : ''); ?>>100</option>
</select>
</div>
<div class="flex items-center gap-2">
<label class="text-slate-600 dark:text-[#92adc9] text-sm font-medium">Language</label>
<select name="language" onchange="this.form.submit()" class="border border-slate-300 dark:border-[#324d67] rounded px-3 py-1 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white text-sm">
<option value="all" <?php echo e(request('language') == 'all' || !request('language') ? 'selected' : ''); ?>>All</option>
<?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php if($key !== 'all'): ?>
<option value="<?php echo e($key); ?>" <?php echo e(request('language') == $key ? 'selected' : ''); ?>><?php echo e($label); ?></option>
<?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select>
</div>
</div>
<div class="flex items-center gap-2">
<label class="text-slate-600 dark:text-[#92adc9] text-sm font-medium">Search</label>
<input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search pages..." class="border border-slate-300 dark:border-[#324d67] rounded px-3 py-1 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white text-sm w-64">
</div>
</div>

<!-- Pages Table -->
<form method="GET" id="filterForm">
<input type="hidden" name="sort" value="<?php echo e(request('sort', 'id')); ?>">
<input type="hidden" name="direction" value="<?php echo e(request('direction', 'desc')); ?>">
<input type="hidden" name="per_page" value="<?php echo e(request('per_page', 15)); ?>">
<input type="hidden" name="language" value="<?php echo e(request('language', 'all')); ?>">
<input type="hidden" name="search" value="<?php echo e(request('search')); ?>">
</form>

<div class="bg-white dark:bg-[#111a22] rounded-lg border border-slate-200 dark:border-[#324d67] overflow-hidden">
<table class="w-full">
<thead class="bg-slate-50 dark:bg-[#192633]">
<tr>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">
<a href="<?php echo e(request()->fullUrlWithQuery(['sort' => 'id', 'direction' => request('sort') == 'id' && request('direction') == 'asc' ? 'desc' : 'asc'])); ?>" class="flex items-center gap-1 hover:text-primary">
Id
<span class="material-symbols-outlined text-xs">unfold_more</span>
</a>
</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">
<a href="<?php echo e(request()->fullUrlWithQuery(['sort' => 'title', 'direction' => request('sort') == 'title' && request('direction') == 'asc' ? 'desc' : 'asc'])); ?>" class="flex items-center gap-1 hover:text-primary">
Title
<span class="material-symbols-outlined text-xs">unfold_more</span>
</a>
</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">
<a href="<?php echo e(request()->fullUrlWithQuery(['sort' => 'language', 'direction' => request('sort') == 'language' && request('direction') == 'asc' ? 'desc' : 'asc'])); ?>" class="flex items-center gap-1 hover:text-primary">
Language
<span class="material-symbols-outlined text-xs">unfold_more</span>
</a>
</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">
<a href="<?php echo e(request()->fullUrlWithQuery(['sort' => 'location', 'direction' => request('sort') == 'location' && request('direction') == 'asc' ? 'desc' : 'asc'])); ?>" class="flex items-center gap-1 hover:text-primary">
Location
<span class="material-symbols-outlined text-xs">unfold_more</span>
</a>
</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">
<a href="<?php echo e(request()->fullUrlWithQuery(['sort' => 'is_published', 'direction' => request('sort') == 'is_published' && request('direction') == 'asc' ? 'desc' : 'asc'])); ?>" class="flex items-center gap-1 hover:text-primary">
Visibility
<span class="material-symbols-outlined text-xs">unfold_more</span>
</a>
</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">
Page Type
</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">
<a href="<?php echo e(request()->fullUrlWithQuery(['sort' => 'created_at', 'direction' => request('sort') == 'created_at' && request('direction') == 'asc' ? 'desc' : 'asc'])); ?>" class="flex items-center gap-1 hover:text-primary">
Date Added
<span class="material-symbols-outlined text-xs">unfold_more</span>
</a>
</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium">Options</th>
</tr>
</thead>
<tbody>
<?php $__empty_1 = true; $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<tr class="border-t border-slate-200 dark:border-[#324d67] hover:bg-slate-50 dark:hover:bg-[#192633]">
<td class="px-4 py-3 text-slate-800 dark:text-white text-sm"><?php echo e($page->id); ?></td>
<td class="px-4 py-3 text-slate-800 dark:text-white text-sm font-medium"><?php echo e($page->title ?: 'Page No Title'); ?></td>
<td class="px-4 py-3 text-slate-800 dark:text-white text-sm"><?php echo e(ucfirst($page->language ?? 'en')); ?></td>
<td class="px-4 py-3 text-slate-800 dark:text-white text-sm"><?php echo e(ucfirst(str_replace('_', ' ', $page->location ?? 'main_menu'))); ?></td>
<td class="px-4 py-3 text-slate-800 dark:text-white text-sm">
<?php if($page->is_published): ?>
<span class="material-symbols-outlined text-green-600 text-lg">visibility</span>
<?php else: ?>
<span class="material-symbols-outlined text-gray-400 text-lg">visibility_off</span>
<?php endif; ?>
</td>
<td class="px-4 py-3 text-slate-800 dark:text-white text-sm">
<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300">
<?php echo e(ucfirst($page->page_type ?? 'custom')); ?>

</span>
</td>
<td class="px-4 py-3 text-slate-800 dark:text-white text-sm"><?php echo e($page->created_at->format('Y-m-d / H:i')); ?></td>
<td class="px-4 py-3 text-slate-800 dark:text-white text-sm">
<div class="relative">
<button type="button" class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-1 rounded text-xs font-medium flex items-center gap-1" onclick="toggleDropdown(<?php echo e($page->id); ?>)">
Select an option
<span class="material-symbols-outlined text-xs">keyboard_arrow_down</span>
</button>
<div id="dropdown-<?php echo e($page->id); ?>" class="absolute right-0 mt-1 w-48 bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#324d67] rounded-lg shadow-lg z-10 hidden">
<div class="py-1">
<?php if($page->is_published): ?>
<a href="<?php echo e(route('pages.show', $page)); ?>" target="_blank" class="block px-4 py-2 text-sm text-slate-700 dark:text-white hover:bg-slate-100 dark:hover:bg-[#192633]">View</a>
<?php endif; ?>
<a href="<?php echo e(route('admin.pages.edit', $page)); ?>" class="block px-4 py-2 text-sm text-slate-700 dark:text-white hover:bg-slate-100 dark:hover:bg-[#192633]">Edit</a>
<a href="<?php echo e(route('admin.pages.show', $page)); ?>" class="block px-4 py-2 text-sm text-slate-700 dark:text-white hover:bg-slate-100 dark:hover:bg-[#192633]">Details</a>
<form method="POST" action="<?php echo e(route('admin.pages.destroy', $page)); ?>" class="block">
<?php echo csrf_field(); ?>
<?php echo method_field('DELETE'); ?>
<button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-slate-100 dark:hover:bg-[#192633]" onclick="return confirm('Are you sure you want to delete this page?')">Delete</button>
</form>
</div>
</div>
</div>
</td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
<tr>
<td colspan="8" class="px-4 py-8 text-center text-slate-500 dark:text-[#92adc9]">No pages found.</td>
</tr>
<?php endif; ?>
</tbody>
</table>
</div>

<!-- Pagination Footer -->
<div class="flex items-center justify-between mt-6">
<div class="text-slate-600 dark:text-[#92adc9] text-sm">
Showing <?php echo e($pages->firstItem() ?? 0); ?> to <?php echo e($pages->lastItem() ?? 0); ?> of <?php echo e($pages->total()); ?> entries
</div>
<div class="flex items-center gap-2">
<?php echo e($pages->links()); ?>

</div>
</div>

<script>
// Dropdown toggle functionality
function toggleDropdown(pageId) {
    // Close all other dropdowns
    document.querySelectorAll('[id^="dropdown-"]').forEach(dropdown => {
        if (dropdown.id !== `dropdown-${pageId}`) {
            dropdown.classList.add('hidden');
        }
    });
    
    // Toggle current dropdown
    const dropdown = document.getElementById(`dropdown-${pageId}`);
    dropdown.classList.toggle('hidden');
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('[onclick^="toggleDropdown"]') && !event.target.closest('[id^="dropdown-"]')) {
        document.querySelectorAll('[id^="dropdown-"]').forEach(dropdown => {
            dropdown.classList.add('hidden');
        });
    }
});

// Search functionality
document.querySelector('input[name="search"]').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        document.getElementById('filterForm').submit();
    }
});

// Auto-submit form when filters change
document.querySelectorAll('select[name="per_page"], select[name="language"]').forEach(select => {
    select.addEventListener('change', function() {
        document.getElementById('filterForm').submit();
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Laravel Projects\Multi Author Blog\resources\views\admin\pages\index.blade.php ENDPATH**/ ?>