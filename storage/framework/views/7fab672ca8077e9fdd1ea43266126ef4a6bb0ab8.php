<?php $__env->startSection('title', 'Add Agency'); ?>
<?php $__env->startSection('heading', 'Add Agency'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    @parent
    <li><a href="<?php echo e(url('agency')); ?>" title="All Agencies"><i class="fa fa-Agencies"></i> Agencies</a></li>
    <li>Add</li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="col-xs-12">
        <?php echo $__env->make('flash::message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Agency Details</h3>
            </div>
            <?php echo Form::open(array('route' => 'agency.store', 'class' => 'form-horizontal form-left')); ?>

            <div class="box-body">
                <?php echo $__env->make('Agency::form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
            <div class="box-footer clearfix">
                <input type="submit" class="btn btn-primary pull-right" value="Add"/>
            </div>
            <?php echo Form::close(); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>