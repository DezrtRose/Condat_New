<?php $__env->startSection('title', 'Institute View'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    @parent
    <li><a href="<?php echo e(url('tenant/institute')); ?>" title="All Institutes"><i class="fa fa-building"></i> Institutes</a></li>
    <li>View</li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('Tenant::Institute/navbar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div class="col-md-3 col-xs-12">

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">General Information</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <strong><i class="fa fa-calendar margin-r-5"></i> Institute Id</strong>

                <p class="text-muted"><?php echo e(format_id($institute->institution_id, 'I')); ?></p>

                <strong><i class="fa fa-calendar margin-r-5"></i> Short Name</strong>

                <p class="text-muted"><?php echo e($institute->short_name); ?></p>

                <strong><i class="fa fa-phone margin-r-5"></i> Website</strong>

                <p class="text-muted"><a href="http://<?php echo e($institute->website); ?>"
                                         target="_blank"><?php echo e($institute->website); ?></a></p>

                <strong><i class="fa fa-calendar margin-r-5"></i> Invoice To</strong>

                <p class="text-muted"><?php echo e($institute->invoice_to_name); ?></p>

                <strong><i class="fa fa-calendar margin-r-5"></i> Created At</strong>

                <p class="text-muted"><?php echo e(format_datetime($institute->created_at)); ?></p>

                <strong><i class="fa fa-phone margin-r-5"></i> Created By</strong>

                <p class="text-muted"><?php echo e($institute->number); ?></p>

            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Super Agents</h3>
            </div>
            <div class="box-body">
                <?php if(count($super_agents) > 0): ?>
                <table class="table table-hover">
                    <tbody>
                    <?php foreach($super_agents as $key => $super_agent): ?>
                        <tr>
                            <td><?php echo e($super_agent->name); ?></td>
                            <td><?php echo e($super_agent->commission_percent); ?>%</td>
                            <td><a data-toggle="tooltip" title="Remove Super Agent" class="btn btn-action-box" href ="<?php echo e(route('tenant.superagent.remove', ['institute_id' => $institute->institution_id, 'agent_id' => $super_agent->agent_id])); ?>" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></a></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    <p class="text-muted well well-sm no-shadow">
                        No super agents found.
                    </p>
                <?php endif; ?>
            </div>
            <div class ="box-footer">
                <?php if(count($agents) > 0): ?>
                <button class="btn btn-success pull-right" data-toggle="modal" data-target="#agentModal"><i class="glyphicon glyphicon-plus-sign"></i> Super Agent
                </button>
                <?php endif; ?>
            </div>

        </div>

    </div>

    <div class="col-md-9">

        <?php echo $__env->make('Tenant::Institute/contact', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <?php echo $__env->make('Tenant::Institute/address', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>

    <!-- Add Super Agent -->
    <div id="agentModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Super Agent</h4>
                </div>
                <?php echo Form::open(['url' => 'tenant/superagents/'.$institute->institution_id.'/store', 'id' => 'add-agent', 'class' => 'form-horizontal form-left']); ?>

                <div class="modal-body">

                    <div class="form-group">
                        <?php echo Form::label('agent_id', 'Agent *', array('class' => 'col-sm-4 control-label')); ?>

                        <div class="col-sm-8">
                            <?php echo Form::select('agent_id', $agents, null, array('class' => 'form-control', 'id'=>'agent_id')); ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo Form::label('commission_percent', 'Commission', array('class' => 'col-sm-4 control-label')); ?>

                        <div class="col-sm-8">
                            <div class="input-group">
                                <?php echo Form::text('commission_percent', null, array('class' => 'form-control', 'id'=>'	commission_percent')); ?>

                                <span class="input-group-addon">%</span>
                            </div>
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

    <?php /*<script type="text/javascript">*/ ?>
        <?php /*$(document).ready(function () {*/ ?>
            <?php /*oTable = $('#courses').DataTable({*/ ?>
                <?php /*"processing": true,*/ ?>
                <?php /*"serverSide": true,*/ ?>
                {{--"ajax": appUrl + "/tenant/institutes/<?= $institute->institution_id ?>/courses",--}}
                <?php /*"columns": [*/ ?>
                    <?php /*{data: 'course_id', name: 'course_id'},*/ ?>
                    <?php /*{data: 'name', name: 'name'},*/ ?>
                    <?php /*{data: 'level', name: 'level'},*/ ?>
                    <?php /*{data: 'total_tuition_fee', name: 'total_tuition_fee'},*/ ?>
                    <?php /*{data: 'commission_percent', name: 'commission_percent'},*/ ?>
                    <?php /*{data: 'action', name: 'action', orderable: false, searchable: false}*/ ?>
                <?php /*]*/ ?>
            <?php /*});*/ ?>
        <?php /*});*/ ?>
    <?php /*</script>*/ ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.tenant', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>