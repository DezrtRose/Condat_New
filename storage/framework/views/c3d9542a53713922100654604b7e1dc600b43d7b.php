<?php $__env->startSection('title', 'Update Institute'); ?>
<?php $__env->startSection('heading', 'Update Institute'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    @parent
    <li><a href="<?php echo e(url('tenant/institute')); ?>" title="All Institutes"><i class="fa fa-building"></i> Institutes</a></li>
    <li>Update</li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Institute Details</h3>
            </div>
            <?php echo $__env->make('flash::message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php echo Form::model($institute, array('route' => array('tenant.institute.update', $institute->institution_id), 'class' => 'form-horizontal form-left', 'method' => 'put')); ?>

            <?php echo Form::hidden('user_id', $institute->user_id); ?>

            <?php echo $__env->make('Tenant::Institute/form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="box-footer clearfix">
                <input type="submit" class="btn btn-primary pull-right" value="Update"/>
            </div>
            <?php echo Form::close(); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.tenant', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>