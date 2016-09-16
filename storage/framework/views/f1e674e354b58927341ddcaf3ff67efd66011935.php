<?php $__env->startSection('title', 'Update Client'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    @parent
    <li><a href="<?php echo e(url('tenant/clients')); ?>" title="All Clients"><i class="fa fa-users"></i> Clients</a></li>
    <li>Update</li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="col-xs-12">
        <?php echo $__env->make('flash::message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Client Details</h3>
            </div>
            <?php echo Form::model($client, array('route' => array('tenant.client.update', $client->client_id), 'class' => 'form-horizontal form-left', 'method' => 'put')); ?>

            <?php echo Form::hidden('email_id', $client->email_id); ?>

            <?php echo $__env->make('Tenant::Client/form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="box-footer clearfix">
                <input type="submit" class="btn btn-primary pull-right" value="Update"/>
            </div>
            <?php echo Form::close(); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.tenant', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>