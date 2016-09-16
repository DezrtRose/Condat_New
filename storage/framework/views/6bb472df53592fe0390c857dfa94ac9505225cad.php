<?php $__env->startSection('title', 'Update Agent'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    @parent
    <li><a href="<?php echo e(url('tenant/agents')); ?>" title="All Agents"><i class="fa fa-users"></i> Agents</a></li>
    <li>Update</li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Agent Details</h3>
            </div>
            <?php echo $__env->make('flash::message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php echo Form::model($agent, array('route' => array('tenant.agents.update', $agent->agent_id), 'class' => 'form-horizontal form-left', 'method' => 'put')); ?>

            <?php echo $__env->make('Tenant::Agent/form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="box-footer clearfix">
                <input type="submit" class="btn btn-primary pull-right" value="Update"/>
            </div>
            <?php echo Form::close(); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.tenant', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>