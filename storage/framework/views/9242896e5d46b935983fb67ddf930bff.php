

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Article Section Settings</h1>
            <div class="flex space-x-2">
                <form action="<?php echo e(route('admin.article-section.reset')); ?>" method="POST" class="inline">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200" onclick="return confirm('Are you sure you want to reset all settings to default?');">
                        <i class="fas fa-undo mr-2"></i>Reset to Default
                    </button>
                </form>
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
                </a>
            </div>
        </div>

        <?php if(session('success')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline"><?php echo e(session('success')); ?></span>
            </div>
        <?php endif; ?>

        <div class="bg-white shadow-lg rounded-lg p-6">
            <form action="<?php echo e(route('admin.article-section.update')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                
                <!-- Section Header Settings -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Section Header</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="section_title" class="block text-sm font-medium text-gray-700 mb-2">Section Title</label>
                            <input type="text" name="section_title" id="section_title" value="<?php echo e($settings['section_title']); ?>" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="section_subtitle" class="block text-sm font-medium text-gray-700 mb-2">Section Subtitle</label>
                            <input type="text" name="section_subtitle" id="section_subtitle" value="<?php echo e($settings['section_subtitle']); ?>" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Articles Display Settings -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Articles Display</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="articles_per_page" class="block text-sm font-medium text-gray-700 mb-2">Articles Per Page</label>
                            <input type="number" name="articles_per_page" id="articles_per_page" value="<?php echo e($settings['articles_per_page']); ?>" min="1" max="20" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="articles_sort_by" class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                            <select name="articles_sort_by" id="articles_sort_by" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="published_at" <?php echo e($settings['articles_sort_by'] == 'published_at' ? 'selected' : ''); ?>>Published Date</option>
                                <option value="created_at" <?php echo e($settings['articles_sort_by'] == 'created_at' ? 'selected' : ''); ?>>Created Date</option>
                                <option value="view_count" <?php echo e($settings['articles_sort_by'] == 'view_count' ? 'selected' : ''); ?>>View Count</option>
                                <option value="title" <?php echo e($settings['articles_sort_by'] == 'title' ? 'selected' : ''); ?>>Title</option>
                            </select>
                        </div>
                        <div>
                            <label for="articles_sort_order" class="block text-sm font-medium text-gray-700 mb-2">Sort Order</label>
                            <select name="articles_sort_order" id="articles_sort_order" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="desc" <?php echo e($settings['articles_sort_order'] == 'desc' ? 'selected' : ''); ?>>Descending</option>
                                <option value="asc" <?php echo e($settings['articles_sort_order'] == 'asc' ? 'selected' : ''); ?>>Ascending</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Settings -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Sidebar Settings</h3>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" name="show_sidebar" id="show_sidebar" value="1" <?php echo e($settings['show_sidebar'] ? 'checked' : ''); ?>

                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <label for="show_sidebar" class="ml-2 text-sm text-gray-700">Show Sidebar</label>
                        </div>
                        
                        <div class="flex items-center">
                            <input type="checkbox" name="show_hottest_authors" id="show_hottest_authors" value="1" <?php echo e($settings['show_hottest_authors'] ? 'checked' : ''); ?>

                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <label for="show_hottest_authors" class="ml-2 text-sm text-gray-700">Show Hottest Authors</label>
                        </div>
                        
                        <div class="flex items-center">
                            <input type="checkbox" name="show_suggested_tags" id="show_suggested_tags" value="1" <?php echo e($settings['show_suggested_tags'] ? 'checked' : ''); ?>

                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <label for="show_suggested_tags" class="ml-2 text-sm text-gray-700">Show Suggested Tags</label>
                        </div>
                        
                        <div class="flex items-center">
                            <input type="checkbox" name="show_suggested_categories" id="show_suggested_categories" value="1" <?php echo e($settings['show_suggested_categories'] ? 'checked' : ''); ?>

                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <label for="show_suggested_categories" class="ml-2 text-sm text-gray-700">Show Suggested Categories</label>
                        </div>
                        
                        <div class="flex items-center">
                            <input type="checkbox" name="show_load_more" id="show_load_more" value="1" <?php echo e($settings['show_load_more'] ? 'checked' : ''); ?>

                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <label for="show_load_more" class="ml-2 text-sm text-gray-700">Show Load More Button</label>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Limits -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Sidebar Limits</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="hottest_authors_limit" class="block text-sm font-medium text-gray-700 mb-2">Hottest Authors Limit</label>
                            <input type="number" name="hottest_authors_limit" id="hottest_authors_limit" value="<?php echo e($settings['hottest_authors_limit']); ?>" min="1" max="10" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="suggested_tags_limit" class="block text-sm font-medium text-gray-700 mb-2">Suggested Tags Limit</label>
                            <input type="number" name="suggested_tags_limit" id="suggested_tags_limit" value="<?php echo e($settings['suggested_tags_limit']); ?>" min="1" max="20" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="suggested_categories_limit" class="block text-sm font-medium text-gray-700 mb-2">Suggested Categories Limit</label>
                            <input type="number" name="suggested_categories_limit" id="suggested_categories_limit" value="<?php echo e($settings['suggested_categories_limit']); ?>" min="1" max="10" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Preview Section -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Preview</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex justify-between items-center mb-2">
                            <h4 class="text-lg font-semibold text-gray-900"><?php echo e($settings['section_title']); ?></h4>
                            <span class="text-sm text-gray-500"><?php echo e($settings['articles_per_page']); ?> articles per page</span>
                        </div>
                        <p class="text-gray-600 mb-4"><?php echo e($settings['section_subtitle']); ?></p>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white p-3 rounded border">
                                <div class="h-32 bg-gray-200 rounded mb-2"></div>
                                <div class="h-4 bg-gray-300 rounded mb-1"></div>
                                <div class="h-3 bg-gray-200 rounded w-3/4"></div>
                            </div>
                            <div class="bg-white p-3 rounded border">
                                <div class="h-32 bg-gray-200 rounded mb-2"></div>
                                <div class="h-4 bg-gray-300 rounded mb-1"></div>
                                <div class="h-3 bg-gray-200 rounded w-3/4"></div>
                            </div>
                        </div>
                        
                        <?php if($settings['show_sidebar']): ?>
                            <div class="mt-4 p-3 bg-white rounded border">
                                <h5 class="font-semibold mb-2">Sidebar Preview</h5>
                                <div class="space-y-2 text-sm">
                                    <?php if($settings['show_hottest_authors']): ?>
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 bg-gray-300 rounded-full"></div>
                                            <span>Hottest Authors (<?php echo e($settings['hottest_authors_limit']); ?>)</span>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($settings['show_suggested_tags']): ?>
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 bg-gray-300 rounded"></div>
                                            <span>Suggested Tags (<?php echo e($settings['suggested_tags_limit']); ?>)</span>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($settings['show_suggested_categories']): ?>
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 bg-gray-300 rounded"></div>
                                            <span>Suggested Categories (<?php echo e($settings['suggested_categories_limit']); ?>)</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200">
                        Cancel
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200">
                        <i class="fas fa-save mr-2"></i>Save Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Update preview when form values change
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const preview = document.querySelector('.bg-gray-50');
    
    form.addEventListener('input', function() {
        const title = document.getElementById('section_title').value;
        const subtitle = document.getElementById('section_subtitle').value;
        const perPage = document.getElementById('articles_per_page').value;
        
        preview.querySelector('h4').textContent = title;
        preview.querySelector('p').textContent = subtitle;
        preview.querySelector('.text-sm.text-gray-500').textContent = perPage + ' articles per page';
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Laravel Projects\Multi Author Blog\resources\views\admin\article-section\index.blade.php ENDPATH**/ ?>