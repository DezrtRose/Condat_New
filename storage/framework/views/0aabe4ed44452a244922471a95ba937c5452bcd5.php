<?php $__env->startSection('title', 'Application View'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    @parent
    <li><a href="<?php echo e(url('tenant/application')); ?>" title="All Applications"><i class="fa fa-users"></i> Applications</a>
    </li>
    <li>View</li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('Tenant::Client/Application/navbar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div class="content">

        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title"> &nbsp;Application -
                    <small>View</small>
                </h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-sm-9">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <span class="panel-title">Course Information</span>
                                <a href="#" class="btn btn-primary btn-flat btn-xs pull-right"><i class="fa fa-pencil"></i> Edit</a>
                            </div>
                            <div class="panel-body">
                                <dl class="dl-horizontal">
                                    <dt>Course Enrolled : </dt>
                                    <dd><?php echo e($application->course_name); ?></dd>
                                    <dt>Institute : </dt>
                                    <dd><?php echo e($application->company_name); ?></dd>
                                    <dt>From : </dt>
                                    <dd><?php echo e(format_date($application->intake_date)); ?></dd>
                                    <dt>To : </dt>
                                    <dd><?php echo e(format_date($application->end_date)); ?></dd>
                                    <dt>Student ID : </dt>
                                    <dd><?php echo e(format_id($application->student_id, 'Std')); ?></dd>
                                </dl>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <span class="panel-title">Payment to College</span>
                                <a href="<?php echo e(route('tenant.application.college.payment', [$application->application_id, 2])); ?>" class="btn btn-primary btn-xs btn-flat pull-right"><i class="glyphicon glyphicon-plus-sign"></i> Add Payment</a>
                            </div>
                            <div class="panel-body">
                                <table class="table table-striped table-bordered">
                                    <tr>
                                        <td>Total Fee</td>
                                        <td>$<?php echo e($application->tuition_fee); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Total Paid</td>
                                        <td>$<?php echo e($paid_to_college); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Total Remaining</td>
                                        <td>$<?php echo e($remaining); ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Commission Details</h3>
                            </div>
                            <div class="panel-body">
                                <table class="table table-striped table-bordered">
                                    <tr>
                                        <td>Total Invoice</td>
                                        <td>$<?php echo e($college_stats['invoice_amount']); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Total Paid Invoice</td>
                                        <td>$<?php echo e($college_stats['total_paid']); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Outstanding Amount</td>
                                        <td>$<?php echo e($college_stats['due_amount']); ?></td>
                                    </tr>

                                    <?php /*<tr>
                                        <td>Commission Payable Amount</td>
                                        <td>$<?php echo e($total_commission_amount); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Total Commission Claimed</td>
                                        <td>$<?php echo e($commission_claimed); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Remaining Commission</td>
                                        <td>$<?php echo e($remaining_commission); ?></td>
                                    </tr>*/ ?>
                                </table>
                            </div>
                        </div>

                    </div>

                    <div class="col-sm-3">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Status</h3>
                            </div>
                            <div class="panel-body">
                                <div class="well well-sm">
                                    <?php echo e($status->name); ?>

                                    <a href="<?php echo e($status->action_link); ?>" class="pull-right">Modify</a>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Super Agent</h3>
                            </div>
                            <div class="panel-body">
                                <div class="well well-sm">
                                    <?php if($application->super_agent_id != null): ?>
                                        <?php echo e(get_agent_name($application->super_agent_id)); ?>

                                        <a href="<?php echo e(route('tenant.agents.show', $application->super_agent_id)); ?>" class="pull-right" target="_blank">view</a>
                                    <?php else: ?>
                                        None
                                        <button class="btn btn-primary btn-xs pull-right" data-toggle="modal"
                                                data-target="#superAgentModal"><i class="glyphicon glyphicon-plus-sign"></i>
                                            Add
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Sub Agent</h3>
                            </div>
                            <div class="panel-body">
                                <div class="well well-sm">
                                    <?php if($application->sub_agent_id != null): ?>
                                        <?php echo e(get_agent_name($application->sub_agent_id)); ?>

                                        <a href="<?php echo e(route('tenant.agents.show', $application->sub_agent_id)); ?>" class="pull-right" target="_blank">view</a>
                                    <?php else: ?>
                                        None
                                        <button class="btn btn-primary btn-xs pull-right" data-toggle="modal"
                                                data-target="#agentModal"><i class="glyphicon glyphicon-plus-sign"></i>
                                            Add
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Student owing Agency</h3>
                            </div>
                            <div class="panel-body">
                                <h3>$<?php echo e($student_outstanding); ?></h3>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Pending Active Commission</h3>
                            </div>
                            <div class="panel-body">
                                <h3>$<?php echo e($college_outstanding); ?></h3>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Uninvoice Amount</h3>
                            </div>
                            <div class="panel-body">
                                <h3>$<?php echo e($uninvoiced_amount); ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="agentModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Sub Agent</h4>
                </div>
                <?php echo Form::open(['url' => 'tenant/applications/'.$application->application_id.'/subagent', 'id' => 'add-agent', 'class' => 'form-horizontal form-left']); ?>

                <div class="modal-body">

                    <div class="form-group">
                        <?php echo Form::label('agent_id', 'Agent *', array('class' => 'col-sm-4 control-label')); ?>

                        <div class="col-sm-8">
                            <?php echo Form::select('agent_id', $agents, null, array('class' => 'form-control', 'id'=>'agent_id')); ?>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i>
                        Add
                    </button>
                </div>
                <?php echo Form::close(); ?>

            </div>

        </div>
    </div>

    <div id="superAgentModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Super Agent</h4>
                </div>
                <?php echo Form::open(['url' => 'tenant/applications/'.$application->application_id.'/superagent', 'id' => 'add-agent', 'class' => 'form-horizontal form-left']); ?>

                <div class="modal-body">

                    <div class="form-group">
                        <?php echo Form::label('agent_id', 'Agent *', array('class' => 'col-sm-4 control-label')); ?>

                        <div class="col-sm-8">
                            <?php echo Form::select('agent_id', $agents, null, array('class' => 'form-control', 'id'=>'agent_id')); ?>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i>
                        Add
                    </button>
                </div>
                <?php echo Form::close(); ?>

            </div>

        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.tenant', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>