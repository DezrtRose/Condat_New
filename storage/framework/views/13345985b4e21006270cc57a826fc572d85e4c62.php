<?php $__env->startSection('title', 'Update Agency'); ?>
<?php $__env->startSection('heading', 'Update Agency'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    @parent
    <li><a href="<?php echo e(url('agency')); ?>" title="All Agencies"><i class="fa fa-Agencies"></i> Agencies</a></li>
    <li>Update</li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="col-xs-12">
        <?php echo $__env->make('flash::message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Agency Details</h3>
            </div>
            <?php echo Form::model($agency, array('route' => ['agency.update', $agency->agency_id], 'class' => 'form-horizontal form-left', 'method' => 'PUT')); ?>

            <div class="box-body">
                <?php echo $__env->make('Agency::form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
            <div class="box-footer clearfix">
                <input type="submit" class="btn btn-primary pull-right" value="Update"/>
            </div>
            <?php echo Form::close(); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>