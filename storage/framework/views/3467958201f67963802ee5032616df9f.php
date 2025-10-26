<?php $__env->startSection('title', 'View Ad'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Ad Details: <?php echo e($ad->name); ?></h3>
                    <div class="btn-group">
                        <a href="<?php echo e(route('admin.ads.edit', $ad->id)); ?>" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="<?php echo e(route('admin.ads.index')); ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Ads
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="200">Name:</th>
                                    <td><?php echo e($ad->name); ?></td>
                                </tr>
                                <tr>
                                    <th>Position:</th>
                                    <td>
                                        <span class="badge badge-info"><?php echo e(ucfirst(str_replace('-', ' ', $ad->position))); ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        <?php if($ad->is_active): ?>
                                            <span class="badge badge-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge badge-danger">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Responsive:</th>
                                    <td>
                                        <?php if($ad->is_responsive): ?>
                                            <span class="badge badge-success">Yes</span>
                                        <?php else: ?>
                                            <span class="badge badge-warning">No</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php if($ad->width || $ad->height): ?>
                                <tr>
                                    <th>Dimensions:</th>
                                    <td>
                                        <?php if($ad->width && $ad->height): ?>
                                            <?php echo e($ad->width); ?>px × <?php echo e($ad->height); ?>px
                                        <?php elseif($ad->width): ?>
                                            Width: <?php echo e($ad->width); ?>px
                                        <?php elseif($ad->height): ?>
                                            Height: <?php echo e($ad->height); ?>px
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endif; ?>
                                <?php if($ad->description): ?>
                                <tr>
                                    <th>Description:</th>
                                    <td><?php echo e($ad->description); ?></td>
                                </tr>
                                <?php endif; ?>
                                <tr>
                                    <th>Created:</th>
                                    <td><?php echo e($ad->created_at->format('M d, Y H:i')); ?></td>
                                </tr>
                                <tr>
                                    <th>Updated:</th>
                                    <td><?php echo e($ad->updated_at->format('M d, Y H:i')); ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Ad Preview</h5>
                                </div>
                                <div class="card-body">
                                    <?php if($ad->is_active): ?>
                                        <div class="ad-preview" style="
                                            <?php if($ad->width): ?> width: <?php echo e($ad->width); ?>px; <?php endif; ?>
                                            <?php if($ad->height): ?> height: <?php echo e($ad->height); ?>px; <?php endif; ?>
                                            border: 1px dashed #ccc;
                                            padding: 10px;
                                            text-align: center;
                                            background: #f8f9fa;
                                        ">
                                            <small class="text-muted">Ad Preview</small>
                                            <div class="mt-2">
                                                <?php echo $ad->code; ?>

                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="alert alert-warning">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            This ad is currently inactive and will not be displayed.
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Laravel Projects\Multi Author Blog\resources\views\admin\ads\show.blade.php ENDPATH**/ ?>