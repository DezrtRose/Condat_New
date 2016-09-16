<?php $__env->startSection('title', 'All Users'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    @parent
    <li><a href="<?php echo e(url('users')); ?>" title="All Users"><i class="fa fa-dashboard"></i> Users</a></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="col-xs-12">
        <?php echo $__env->make('flash::message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Manage Users</h3>
                <a href="<?php echo e(route('tenant.user.create')); ?>" class="btn btn-primary btn-flat pull-right">Add New User</a>
            </div>
            <div class="box-body">
                <table id="users" class="table table-bordered table-striped dataTable">
                    <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <script type="text/javascript">
            $(document).ready(function () {
                oTable = $('#users').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": appUrl + "/tenant/users/data",
                    "columns": [
                        {data: 'user_id', name: 'user_id'},
                        {data: 'fullname', name: 'fullname'},
                        {data: 'email', name: 'email'},
                        {data: 'status', name: 'status'},
                        {data: 'created_at', name: 'created_at'},
                        {data: 'action', name: 'action', orderable: false, searchable: false}
                    ],
                    order: [ [0, 'desc'] ]
                });
            });
        </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.tenant', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>