<?php $__env->startSection('title', 'System Information'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50">
    <div class="px-6 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">System Information</h1>
            <p class="text-gray-600 mt-2">All information about current system configuration</p>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">System Details</h3>
                    <dl class="space-y-3">
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-500">PHP Version</dt>
                            <dd class="text-sm text-gray-900"><?php echo e($systemInfo['php_version']); ?></dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-500">Laravel Version</dt>
                            <dd class="text-sm text-gray-900"><?php echo e($systemInfo['laravel_version']); ?></dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-500">Server Software</dt>
                            <dd class="text-sm text-gray-900"><?php echo e($systemInfo['server_software']); ?></dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-500">Database Driver</dt>
                            <dd class="text-sm text-gray-900"><?php echo e($systemInfo['database_driver']); ?></dd>
                        </div>
                    </dl>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">PHP Configuration</h3>
                    <dl class="space-y-3">
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-500">Memory Limit</dt>
                            <dd class="text-sm text-gray-900"><?php echo e($systemInfo['memory_limit']); ?></dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-500">Max Execution Time</dt>
                            <dd class="text-sm text-gray-900"><?php echo e($systemInfo['max_execution_time']); ?>s</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-500">Upload Max Filesize</dt>
                            <dd class="text-sm text-gray-900"><?php echo e($systemInfo['upload_max_filesize']); ?></dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-500">Post Max Size</dt>
                            <dd class="text-sm text-gray-900"><?php echo e($systemInfo['post_max_size']); ?></dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Laravel Projects\Multi Author Blog\resources\views\admin\system-info\index.blade.php ENDPATH**/ ?>