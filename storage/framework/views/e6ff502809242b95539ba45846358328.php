<?php $__env->startSection('content'); ?>
<!-- Success Messages -->
<?php if(session('status')): ?>
<div class="mb-4 rounded-lg bg-green-100 dark:bg-green-900/50 p-4 text-green-700 dark:text-green-300">
<?php echo e(session('status')); ?>

</div>
<?php endif; ?>

<div class="flex flex-wrap justify-between gap-3 pb-8">
<div class="flex flex-col gap-3">
<h1 class="text-slate-800 dark:text-white text-4xl font-black leading-tight tracking-[-0.033em]">All Posts</h1>
<p class="text-slate-500 dark:text-[#92adc9] text-base font-normal leading-normal">Manage all blog posts and their status.</p>
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
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium leading-normal">Title</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium leading-normal">Author</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium leading-normal">Category</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium leading-normal">Status</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium leading-normal">Types</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium leading-normal">Published</th>
<th class="px-4 py-3 text-left text-slate-600 dark:text-white text-sm font-medium leading-normal">Actions</th>
</tr>
</thead>
<tbody>
<?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr class="border-t border-t-slate-200 dark:border-t-[#324d67]">
<td class="h-[72px] px-4 py-2 text-slate-800 dark:text-white text-sm font-normal leading-normal">
<a class="text-primary hover:underline" href="<?php echo e(route('posts.show', $post)); ?>"><?php echo e(Str::limit($post->title, 40)); ?></a>
</td>
<td class="h-[72px] px-4 py-2 text-slate-500 dark:text-[#92adc9] text-sm font-normal leading-normal"><?php echo e($post->user->name); ?></td>
<td class="h-[72px] px-4 py-2 text-slate-500 dark:text-[#92adc9] text-sm font-normal leading-normal"><?php echo e(optional($post->category)->name ?? 'Uncategorized'); ?></td>
<td class="h-[72px] px-4 py-2 text-sm font-normal leading-normal">
<span class="inline-flex items-center justify-center rounded-full <?php echo e($post->status === 'published' ? 'bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-300' : 'bg-yellow-100 dark:bg-yellow-900/50 text-yellow-800 dark:text-yellow-300'); ?> px-2.5 py-0.5 text-xs font-medium"><?php echo e(ucfirst($post->status)); ?></span>
</td>
<td class="h-[72px] px-4 py-2 text-sm font-normal leading-normal">
<div class="flex flex-wrap gap-1">
<form method="POST" action="<?php echo e(route('admin.posts.toggle-type', $post)); ?>" class="inline">
<?php echo csrf_field(); ?>
<input type="hidden" name="type" value="featured">
<button type="submit" class="px-2 py-1 text-xs rounded <?php echo e($post->is_featured ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400'); ?>">
⭐ Featured
</button>
</form>

<form method="POST" action="<?php echo e(route('admin.posts.toggle-type', $post)); ?>" class="inline">
<?php echo csrf_field(); ?>
<input type="hidden" name="type" value="slider">
<button type="submit" class="px-2 py-1 text-xs rounded <?php echo e($post->is_slider ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400'); ?>">
🎠 Slider
</button>
</form>

<form method="POST" action="<?php echo e(route('admin.posts.toggle-type', $post)); ?>" class="inline">
<?php echo csrf_field(); ?>
<input type="hidden" name="type" value="breaking">
<button type="submit" class="px-2 py-1 text-xs rounded <?php echo e($post->is_breaking ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400'); ?>">
🚨 Breaking
</button>
</form>

<form method="POST" action="<?php echo e(route('admin.posts.toggle-type', $post)); ?>" class="inline">
<?php echo csrf_field(); ?>
<input type="hidden" name="type" value="recommended">
<button type="submit" class="px-2 py-1 text-xs rounded <?php echo e($post->is_recommended ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400'); ?>">
👍 Recommended
</button>
</form>
</div>
</td>
<td class="h-[72px] px-4 py-2 text-slate-500 dark:text-[#92adc9] text-sm font-normal leading-normal"><?php echo e(optional($post->published_at)->format('Y-m-d') ?? 'Not published'); ?></td>
<td class="h-[72px] px-4 py-2 text-sm font-normal leading-normal">
<div class="flex gap-2">
<form method="POST" action="<?php echo e(route('admin.posts.destroy', $post)); ?>" class="inline">
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
<?php echo e($posts->links()); ?>

</div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Real-time updates for posts table
    if (typeof Pusher !== 'undefined') {
        const pusher = new Pusher('<?php echo e(config('broadcasting.connections.pusher.key')); ?>', {
            cluster: '<?php echo e(config('broadcasting.connections.pusher.options.cluster')); ?>'
        });

        const channel = pusher.subscribe('admin-dashboard');

        channel.bind('new-post', function(data) {
            refreshPostsTable();
            showToast('New post created: ' + data.title, 'success');
        });

        channel.bind('post-updated', function(data) {
            refreshPostsTable();
            showToast('Post updated: ' + data.title, 'info');
        });

        channel.bind('post-deleted', function(data) {
            refreshPostsTable();
            showToast('Post deleted: ' + data.title, 'warning');
        });
    }

    // Auto-refresh every 30 seconds
    setInterval(refreshPostsTable, 30000);
});

function refreshPostsTable() {
    fetch('<?php echo e(route('admin.posts.index')); ?>', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.text())
    .then(html => {
        // Extract table body content
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        const newTableBody = doc.querySelector('tbody');

        if (newTableBody) {
            const currentTableBody = document.querySelector('tbody');
            if (currentTableBody) {
                currentTableBody.innerHTML = newTableBody.innerHTML;
            }
        }
    })
    .catch(error => {
        console.error('Error refreshing posts table:', error);
    });
}

function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 ${getToastClass(type)}`;
    toast.innerHTML = `
        <div class="flex items-center space-x-2">
            <span class="material-symbols-outlined">${getToastIcon(type)}</span>
            <span>${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-2 text-gray-500 hover:text-gray-700">
                <span class="material-symbols-outlined text-sm">close</span>
            </button>
        </div>
    `;

    document.body.appendChild(toast);

    setTimeout(() => {
        if (toast.parentElement) {
            toast.remove();
        }
    }, 5000);
}

function getToastClass(type) {
    const classes = {
        'success': 'bg-green-100 text-green-800 border border-green-200',
        'info': 'bg-blue-100 text-blue-800 border border-blue-200',
        'warning': 'bg-yellow-100 text-yellow-800 border border-yellow-200',
        'error': 'bg-red-100 text-red-800 border border-red-200'
    };
    return classes[type] || classes['info'];
}

function getToastIcon(type) {
    const icons = {
        'success': 'check_circle',
        'info': 'info',
        'warning': 'warning',
        'error': 'error'
    };
    return icons[type] || icons['info'];
}
</script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Laravel Projects\Multi Author Blog\resources\views\admin\posts\index_all.blade.php ENDPATH**/ ?>