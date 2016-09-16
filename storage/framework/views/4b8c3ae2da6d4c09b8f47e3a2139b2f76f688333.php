<?php $__env->startSection('title', 'All Agents'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    @parent
    <li><a href="<?php echo e(url('agents')); ?>" title="All Agents"><i class="fa fa-dashboard"></i> Agents</a></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="col-xs-12">
        <?php echo $__env->make('flash::message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Manage Agents</h3>
                <a href="<?php echo e(route('tenant.agents.create')); ?>" class="btn btn-primary btn-flat pull-right">Add New Agent</a>
            </div>
            <div class="box-body">
                <table id="agents" class="table table-bordered table-striped dataTable">
                    <thead>
                    <tr>
                        <th>Agent ID</th>
                        <th>Agent Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Website</th>
                        <th>Added By</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            oTable = $('#agents').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": appUrl + "/tenant/agent/data",
                "columns": [
                    {data: 'agent_id', name: 'agent_id'},
                    {data: 'name', name: 'name'},
                    {data: 'number', name: 'number'},
                    {data: 'email', name: 'email'},
                    {data: 'website', name: 'website'},
                    {data: 'user_email', name: 'user_email'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.tenant', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>