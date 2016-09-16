<?php $__env->startSection('title', 'All Institutions'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    @parent
    <li><a href="<?php echo e(url('institute')); ?>" title="All Institutions"><i class="fa fa-dashboard"></i> Institutions</a></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="col-xs-12">
        <?php echo $__env->make('flash::message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">All Institutions</h3>
                <a href="<?php echo e(route('tenant.institute.create')); ?>" class="btn btn-primary btn-flat pull-right">Add New Institute</a>
            </div>
            <div class="search">
                
            </div>

            <div class="box-body">
                <table id="institutes" class="table table-bordered table-striped dataTable">
                    <thead>
                    <tr>
                        <th>Institute ID</th>
                        <th>Institute Name</th>
                        <th>Short Name</th> 
                        <th>Phone</th>
                        <th>Website</th>
                        <th>Invoice To</th>
                        <th>Created By</th>
                        <th>Actions</th>
                        
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            oTable = $('#institutes').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": appUrl + "/tenant/institutes/data",
                "columns": [
                    {data: 'institution_id', name: 'institution_id'},
                    {data: 'name', name: 'name'},
                    {data: 'short_name', name: 'short_name'},  
                    {data: 'number', name: 'number'},
                    {data: 'website', name: 'website'},
                    {data: 'invoice_to_name', name: 'invoice_to_name'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.tenant', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>