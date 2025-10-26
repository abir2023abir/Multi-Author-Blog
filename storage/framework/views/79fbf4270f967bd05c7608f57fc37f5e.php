<?php $__env->startSection('title', $user->name . ' - Author Profile'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Author Header -->
        <div class="bg-white rounded-lg shadow-sm p-8 mb-8">
            <div class="flex flex-col md:flex-row items-start md:items-center space-y-4 md:space-y-0 md:space-x-6">
                <!-- Avatar -->
                <div class="flex-shrink-0">
                    <img class="h-24 w-24 rounded-full object-cover"
                         src="<?php echo e($user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name)); ?>"
                         alt="<?php echo e($user->name); ?>">
                </div>

                <!-- Author Info -->
                <div class="flex-1">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900"><?php echo e($user->name); ?></h1>
                            <p class="text-lg text-gray-600 mt-1"><?php echo e($user->email); ?></p>
                            <?php if($user->bio): ?>
                                <p class="text-gray-700 mt-2"><?php echo e($user->bio); ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- Badge and Stats -->
                        <div class="mt-4 md:mt-0 text-center md:text-right">
                            <div class="flex items-center justify-center md:justify-end space-x-2 mb-2">
                                <span class="text-4xl"><?php echo e($stats['badge_emoji']); ?></span>
                                <div>
                                    <div class="text-lg font-semibold text-gray-900"><?php echo e($stats['badge_level']); ?></div>
                                    <?php if($stats['rank_position']): ?>
                                        <div class="text-sm text-gray-500">Rank #<?php echo e($stats['rank_position']); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="text-2xl font-bold text-blue-600"><?php echo e(number_format($stats['total_posts'] ?? 0)); ?> Posts</div>
                        </div>
                    </div>

                    <!-- Social Links -->
                    <?php if($user->social_links && count($user->social_links) > 0): ?>
                        <div class="mt-4 flex flex-wrap gap-4">
                            <?php $__currentLoopData = $user->social_links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $platform => $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e($link); ?>"
                                   target="_blank"
                                   class="text-blue-600 hover:text-blue-800 transition-colors">
                                    <?php echo e(ucfirst($platform)); ?>

                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-sm p-6 text-center">
                <div class="text-3xl font-bold text-blue-600"><?php echo e(number_format($stats['total_views'] ?? 0)); ?></div>
                <div class="text-sm text-gray-500 mt-1">Total Views</div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6 text-center">
                <div class="text-3xl font-bold text-green-600"><?php echo e(number_format($stats['total_comments'] ?? 0)); ?></div>
                <div class="text-sm text-gray-500 mt-1">Comments Received</div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6 text-center">
                <div class="text-3xl font-bold text-purple-600"><?php echo e(number_format($stats['total_reactions'] ?? 0)); ?></div>
                <div class="text-sm text-gray-500 mt-1">Total Reactions</div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6 text-center">
                <div class="text-3xl font-bold text-yellow-600"><?php echo e(number_format($stats['average_rating'] ?? 0, 1)); ?></div>
                <div class="text-sm text-gray-500 mt-1">Average Rating</div>
            </div>
        </div>

        <!-- Progress to Next Badge -->
        <?php if(isset($progress['next_badge']) && $progress['next_badge']): ?>
            <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Progress to Next Badge</h3>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2">
                        <span class="text-2xl"><?php echo e($stats['badge_emoji']); ?></span>
                        <span class="text-sm text-gray-600"><?php echo e($stats['badge_level']); ?></span>
                    </div>

                    <div class="flex-1">
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-gradient-to-r from-blue-500 to-purple-600 h-3 rounded-full transition-all duration-500"
                                 style="width: <?php echo e($progress['progress_percentage']); ?>%"></div>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600 mt-2">
                            <span><?php echo e(number_format($progress['current_points'])); ?> points</span>
                            <span><?php echo e(number_format($progress['next_badge_points'])); ?> points needed</span>
                        </div>
                    </div>

                    <div class="flex items-center space-x-2">
                        <span class="text-2xl"><?php echo e($progress['next_badge']->emoji); ?></span>
                        <span class="text-sm text-gray-600"><?php echo e($progress['next_badge']->name); ?></span>
                    </div>
                </div>

                <?php if($progress['points_needed'] > 0): ?>
                    <div class="mt-4 text-center">
                        <span class="text-sm text-gray-500">
                            <?php echo e($progress['points_needed']); ?> more points needed for next badge
                        </span>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Recent Posts -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Recent Posts</h3>

            <?php if($recentPosts->count() > 0): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php $__currentLoopData = $recentPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                            <h4 class="font-semibold text-gray-900 mb-2 line-clamp-2">
                                <a href="<?php echo e(route('posts.show', $post)); ?>" class="hover:text-blue-600 transition-colors">
                                    <?php echo e($post->title); ?>

                                </a>
                            </h4>

                            <p class="text-sm text-gray-600 mb-3 line-clamp-3">
                                <?php echo e(Str::limit(strip_tags($post->content), 120)); ?>

                            </p>

                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <span><?php echo e($post->view_count); ?> views</span>
                                <span><?php echo e($post->published_at->format('M d, Y')); ?></span>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="text-center py-8 text-gray-500">
                    <div class="text-4xl mb-4">📝</div>
                    <p>No posts published yet.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Laravel Projects\Multi Author Blog\resources\views\authors\profile.blade.php ENDPATH**/ ?>