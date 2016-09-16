<?php $__env->startSection('title', 'Register Agency'); ?>
<?php $__env->startSection('heading', 'Register Agency'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    @parent
    <li><a href="<?php echo e(url('agency')); ?>" title="All Agencies"><i class="fa fa-Agencies"></i> Agencies</a></li>
    <li>Register</li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <?php echo $__env->make('flash::message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <div class="panel panel-default">
                    <div class="panel-heading">Register Your Agency</div>
                    <?php echo Form::open(array('class' => 'form-horizontal form-left')); ?>

                    <div class="panel-body">
                        <?php echo $__env->make('Agency::form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>
                    <div class="panel-footer clearfix">
                        <input type="submit" class="btn btn-primary pull-right" value="Register"/>
                    </div>
                    <?php echo Form::close(); ?>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>