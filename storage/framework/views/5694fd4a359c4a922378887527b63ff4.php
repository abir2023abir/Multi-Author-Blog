

<?php $__env->startSection('title', 'My Posts'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">My Posts</h1>
                    <p class="text-gray-600">Manage and organize your content</p>
                </div>
                <div class="flex space-x-4">
                    <a href="<?php echo e(route('user.dashboard')); ?>" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 flex items-center space-x-2">
                        <i class="fas fa-arrow-left"></i>
                        <span>Back to Dashboard</span>
                    </a>
                    <a href="<?php echo e(route('user.posts.create')); ?>" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center space-x-2">
                        <i class="fas fa-plus"></i>
                        <span>Create New Post</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <?php if(session('success')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if($posts->count() > 0): ?>
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">All Posts (<?php echo e($posts->total()); ?>)</h2>
                </div>
                <div class="divide-y divide-gray-200">
                    <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="p-6 hover:bg-gray-50">
                            <div class="flex items-start space-x-4">
                                <?php if($post->featured_image): ?>
                                    <img src="<?php echo e(Storage::url($post->featured_image)); ?>" alt="<?php echo e($post->title); ?>" class="w-20 h-20 object-cover rounded-lg">
                                <?php else: ?>
                                    <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400"></i>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-lg font-medium text-gray-900"><?php echo e($post->title); ?></h3>
                                        <div class="flex items-center space-x-2">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                <?php if($post->status === 'published'): ?> bg-green-100 text-green-800
                                                <?php elseif($post->status === 'pending'): ?> bg-yellow-100 text-yellow-800
                                                <?php else: ?> bg-gray-100 text-gray-800
                                                <?php endif; ?>">
                                                <?php echo e(ucfirst($post->status)); ?>

                                            </span>
                                        </div>
                                    </div>
                                    
                                    <p class="text-sm text-gray-600 mt-1"><?php echo e($post->excerpt ?? Str::limit(strip_tags($post->content), 150)); ?></p>
                                    
                                    <div class="flex items-center justify-between mt-3">
                                        <div class="flex items-center space-x-4 text-sm text-gray-500">
                                            <span><i class="fas fa-folder"></i> <?php echo e($post->category->name ?? 'Uncategorized'); ?></span>
                                            <span><i class="fas fa-calendar"></i> <?php echo e($post->created_at->format('M d, Y')); ?></span>
                                            <?php if($post->views > 0): ?>
                                                <span><i class="fas fa-eye"></i> <?php echo e($post->views); ?> views</span>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <div class="flex items-center space-x-2">
                                            <a href="<?php echo e(route('user.posts.show', $post)); ?>" class="text-blue-600 hover:text-blue-800 p-2 rounded-lg hover:bg-blue-50">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?php echo e(route('user.posts.edit', $post)); ?>" class="text-green-600 hover:text-green-800 p-2 rounded-lg hover:bg-green-50">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="<?php echo e(route('user.posts.destroy', $post)); ?>" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this post?')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="text-red-600 hover:text-red-800 p-2 rounded-lg hover:bg-red-50">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                
                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    <?php echo e($posts->links()); ?>

                </div>
            </div>
        <?php else: ?>
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <i class="fas fa-file-alt text-gray-400 text-6xl mb-4"></i>
                <h3 class="text-xl font-medium text-gray-900 mb-2">No posts yet</h3>
                <p class="text-gray-500 mb-6">Start creating content to share with the community</p>
                <a href="<?php echo e(route('user.posts.create')); ?>" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 inline-flex items-center space-x-2">
                    <i class="fas fa-plus"></i>
                    <span>Create Your First Post</span>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Laravel Projects\Multi Author Blog\resources\views\user\posts\index.blade.php ENDPATH**/ ?>