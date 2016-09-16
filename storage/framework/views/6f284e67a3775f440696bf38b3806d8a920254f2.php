<?php $__env->startSection('title', 'All Agencies'); ?>
<?php $__env->startSection('heading', 'All Agencies'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    @parent
    <li><a href="<?php echo e(url('agency')); ?>" title="All Agencies"><i class="fa fa-dashboard"></i> Agencies</a></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="col-xs-12">
        <?php echo $__env->make('flash::message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Manage Agencies</h3>
                <a href="<?php echo e(route('agency.create')); ?>" class="btn btn-primary btn-flat pull-right">Add New Agency</a>
            </div>
            <div class="box-body">
                <table id="agencies" class="table table-bordered table-striped dataTable">
                    <thead>
                    <tr>
                        <th>Agency ID</th>
                        <th>Company Name</th>
                        <th>Email</th>
                        <th>Database Name</th>
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
                oTable = $('#agencies').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": appUrl + "/agencies/data",
                    "columns": [
                        {data: 'agency_id', name: 'agency_id'},
                        {data: 'name', name: 'name'},
                        {data: 'email_id', name: 'email_id'},
                        {data: 'company_database_name', name: 'company_database_name'},
                        {data: 'created_at', name: 'created_at'},
                        {data: 'action', name: 'action', orderable: false, searchable: false}
                    ]
                });
            });
        </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>