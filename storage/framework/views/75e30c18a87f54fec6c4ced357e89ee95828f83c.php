<?php $__env->startSection('title', 'Add User'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    @parent
    <li><a href="<?php echo e(url('users')); ?>" title="All Users"><i class="fa fa-users"></i> Users</a></li>
    <li>Add</li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">User Details</h3>
            </div>
            <?php echo $__env->make('flash::message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php echo Form::open(array('route' => 'tenant.user.store', 'class' => 'form-horizontal')); ?>

            <?php echo $__env->make('Tenant::User/form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="box-footer">
                <input type="submit" class="btn btn-primary pull-right" value="Add"/>
            </div>
            <?php echo Form::close(); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.tenant', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>