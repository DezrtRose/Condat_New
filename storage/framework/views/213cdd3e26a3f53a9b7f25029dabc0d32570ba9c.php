<?php $__env->startSection('title', 'All Clients'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    @parent
    <li><a href="<?php echo e(url('client')); ?>" title="All Clients"><i class="fa fa-dashboard"></i> Clients</a></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="col-xs-12">
        <?php echo $__env->make('flash::message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">All Clients</h3>
                <a href="<?php echo e(route('tenant.client.create')); ?>" class="btn btn-primary btn-flat pull-right">Add New Client</a>
            </div>
            <div class="box-body">
                <table id="clients" class="table table-bordered table-striped dataTable">
                    <thead>
                    <tr>
                        <th>Client ID</th>
                        <th>Client Name</th>
                        <th>Phone No</th>
                        <th>Email</th>
                        <th>Added By</th>
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
            oTable = $('#clients').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": appUrl + "/tenant/client/data",
                "columns": [
                    {data: 'client_id', name: 'client_id'},
                    {data: 'fullname', name: 'fullname'},
                    {data: 'phone', name: 'phone'},
                    {data: 'email', name: 'email'},
                    {data: 'added_by', name: 'added_by'},
                    {data: 'created_at', name: 'created_at', searchable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                order: [ [0, 'desc'] ]
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.tenant', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>