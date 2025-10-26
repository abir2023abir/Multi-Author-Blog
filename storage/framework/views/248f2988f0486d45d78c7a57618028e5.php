<?php $__env->startSection('title', $post->title); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900"><?php echo e($post->title); ?></h1>
                    <p class="text-gray-600">Posted <?php echo e($post->created_at->diffForHumans()); ?></p>
                </div>
                <div class="flex space-x-4">
                    <a href="<?php echo e(route('user.posts.index')); ?>" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 flex items-center space-x-2">
                        <i class="fas fa-arrow-left"></i>
                        <span>Back to Posts</span>
                    </a>
                    <a href="<?php echo e(route('user.posts.edit', $post)); ?>" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center space-x-2">
                        <i class="fas fa-edit"></i>
                        <span>Edit Post</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <?php if($post->featured_image): ?>
                <img src="<?php echo e(Storage::url($post->featured_image)); ?>" alt="<?php echo e($post->title); ?>" class="w-full h-64 object-cover">
            <?php endif; ?>

            <div class="p-8">
                <!-- Post Meta -->
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            <?php if($post->status === 'published'): ?> bg-green-100 text-green-800
                            <?php elseif($post->status === 'pending'): ?> bg-yellow-100 text-yellow-800
                            <?php else: ?> bg-gray-100 text-gray-800
                            <?php endif; ?>">
                            <?php echo e(ucfirst($post->status)); ?>

                        </span>
                        <span class="text-sm text-gray-500"><?php echo e($post->category->name ?? 'Uncategorized'); ?></span>
                        <span class="text-sm text-gray-500"><?php echo e($post->views); ?> views</span>
                    </div>
                    <div class="text-sm text-gray-500">
                        <?php echo e($post->created_at->format('M d, Y')); ?>

                    </div>
                </div>

                <!-- Post Content -->
                <div class="prose max-w-none">
                    <?php echo nl2br(e($post->content)); ?>

                </div>

                <?php if($post->excerpt): ?>
                    <div class="mt-8 p-4 bg-gray-50 rounded-lg">
                        <h3 class="text-sm font-medium text-gray-900 mb-2">Excerpt</h3>
                        <p class="text-gray-700"><?php echo e($post->excerpt); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Laravel Projects\Multi Author Blog\resources\views\user\posts\show.blade.php ENDPATH**/ ?>