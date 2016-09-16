<?php $__env->startSection('title', 'All Courses'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    @parent
    <li><a href="<?php echo e(url('institute')); ?>" title="All Institutes"><i class="fa fa-dashboard"></i> Institutes</a></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="col-xs-12">
        <?php echo $__env->make('flash::message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
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

        </div>

        <div class="col-md-9">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Manage Courses</h3>
                <a href="<?php echo e(route('tenant.course.create', $institution_id)); ?>" class="btn btn-primary btn-flat pull-right">Add New Course</a>
            </div>
            <div class="box-body">
                <table id="courses" class="table table-bordered table-striped dataTable">
                    <thead>
                    <tr>
                        <th>Cricos ID</th>
                        <th>Course Name</th>
                        <th>Level</th>
                        <th>Tuition Fee</th>
                        <th>Com %</th>
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
            oTable = $('#courses').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": appUrl + "/tenant/courses/"+ <?php echo $institution_id ?> +"/data",
                "columns": [
                    {data: 'course_id', name: 'course_id'},
                    {data: 'name', name: 'name'},
                    {data: 'level', name: 'level'},
                    {data: 'total_tuition_fee', name: 'total_tuition_fee'},
                    {data: 'commission_percent', name: 'commission_percent'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.tenant', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>