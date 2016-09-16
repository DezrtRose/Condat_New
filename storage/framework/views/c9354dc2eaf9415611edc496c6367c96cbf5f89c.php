<?php $__env->startSection('title', 'Application Details'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    @parent
    <li><a href="<?php echo e(url('tenant/application')); ?>" title="All Applications"><i class="fa fa-users"></i> Applications</a>
    </li>
    <li>Details</li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('Tenant::Client/Application/navbar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div class="content">

        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title"> &nbsp;Application -
                    <small>Timeline</small>
                </h3>
            </div>

            <div class="box-body">
                <?php echo $__env->make('Tenant::Client/Show/timeline', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.tenant', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>