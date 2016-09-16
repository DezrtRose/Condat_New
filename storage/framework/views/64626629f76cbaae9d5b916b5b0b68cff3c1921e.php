<?php $__env->startSection('title', 'Application List'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    @parent
    <li><a href="<?php echo e(url('tenant/client')); ?>" title="All Clients"><i class="fa fa-users"></i> Clients</a></li>
    <li>View</li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <div class="container">
        <div class="row">
            <?php echo $__env->make('Tenant::Client/client_header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>

        <div class="col-xs-12 col-md-12">
            <?php echo $__env->make('flash::message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Manage Applications</h3>
                    <a href="<?php echo e(route('tenant.application.create', $client->client_id)); ?>"
                       class="btn btn-primary btn-flat pull-right"><i class="fa  fa-graduation-cap"></i> Enroll Now</a>
                </div>
                <div class="box-body table-responsive">

                    <table id="applications" class="table table-bordered table-striped dataTable">
                        <thead>
                        <tr>
                            <th>Application ID</th>
                            <th>Institute Name</th>
                            <th>Course Name</th>
                            <th>Start Date</th>
                            <th>Finish Date</th>
                            <th>Student Id</th>
                            <th>Total Tuition Fee</th>
                            <th>Status</th>
                            <th>Added By</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            oTable = $('#applications').DataTable({
                "processing": true,
                "serverSide": true,

                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": true,

                "ajax": appUrl + "/tenant/applications/"+ <?php echo $client->client_id ?> +"/data",
                "columns": [
                    {data: 'application_id', name: 'application_id'},
                    {data: 'name', name: 'name'},
                    {data: 'course_name', name: 'course_name'},
                    {data: 'orientation_date', name: 'orientation_date'},
                    {data: 'end_date', name: 'end_date'},
                    {data: 'student_id', name: 'student_id'},
                    {data: 'tuition_fee', name: 'tuition_fee'},
                    {data: 'status', name: 'status'},
                    {data: 'added_by', name: 'added_by'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.tenant', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>