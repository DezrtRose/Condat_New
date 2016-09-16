<?php $__env->startSection('title', 'Application Offer Letter Issued'); ?>
<?php $__env->startSection('heading', '<h1>Application - <small>Offer Letter Issued</small></h1>'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    @parent
    <li><a href="<?php echo e(url('tenant/clients')); ?>" title="All Applications"><i class="fa fa-users"></i> Applications</a></li>
    <li>Offer Letter Issued</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="col-md-12">
        <?php echo $__env->make('Tenant::ApplicationStatus/partial/navbar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <?php echo $__env->make('flash::message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">All Applications</h3>
            </div>
            <div class="box-body">
                <table class="table table-striped table-bordered table-condensed" id="letter_table">
                    <thead>
                    <tr class="text-nowrap">
                        <th>Id</th>
                        <th>Client Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>College Name</th>
                        <th>Course Name</th>
                        <th>Start date</th>
                        <th>Invoice To</th>
                        <th>Processing</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($applications as $application): ?>
                        <tr>
                            <td><?php echo e(format_id($application->course_application_id, 'AP')); ?></td>
                            <td><?php echo e($application->fullname); ?></td>
                            <td><?php echo e($application->number); ?></td>
                            <td><?php echo e($application->email); ?></td>
                            <td><?php echo e($application->company); ?></td>
                            <td><?php echo e($application->name); ?></td>
                            <td><?php echo e(format_date($application->intake_date)); ?></td>
                            <td><?php echo e($application->invoice_to); ?></td>
                            <td><a href="<?php echo e(route('applications.apply.coe', $application->course_application_id)); ?>"
                                   title="Apply COE"><i class=" btn btn-primary btn-sm glyphicon glyphicon-education"
                                                        data-toggle="tooltip" data-placement="top"
                                                        title="Apply COE"></i></a>
                                <a href="#" title="view"><i
                                            class="processing btn btn-primary btn-sm glyphicon glyphicon-eye-open"
                                            data-toggle="tooltip" data-placement="top" title="View"></i></a>
                                <a href="#" title="edit"><i
                                            class="processing btn btn-primary btn-sm glyphicon glyphicon-edit"
                                            data-toggle="tooltip" data-placement="top" title="Edit"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#letter_table').DataTable({
                "pageLength": 10
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.tenant', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>