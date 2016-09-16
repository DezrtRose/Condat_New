<?php $__env->startSection('title', 'Client View'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    @parent
    <li><a href="<?php echo e(url('tenant/client')); ?>" title="All Clients"><i class="fa fa-users"></i> Clients</a></li>
    <li>View</li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Invoice Payments</h3>
                <?php /*<a href="<?php echo e(route('application.subagents.payment', $application->application_id)); ?>"
                   class="btn btn-success btn-flat pull-right"><i class="glyphicon glyphicon-plus-sign"></i> Add
                    Payments</a>*/ ?>
            </div>
            <div class="box-body">
                <table id="payments" class="table table-bordered table-striped dataTable">
                    <thead>
                    <tr>
                        <th>Payment ID</th>
                        <th>Payment Date</th>
                        <th>Amount</th>
                        <th>Paid By</th>
                        <th>Payment Type</th>
                        <th>Description</th>
                        <th></th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            oTable = $('#payments').DataTable({
                "processing": true,
                "serverSide": true,

                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": true,

                "ajax": appUrl + "/tenant/invoices/payments/" + <?php echo $invoice_id ?> + "/" + <?php echo $type ?> + "/data",
                "columns": [
                    {data: 'payment_id', name: 'payment_id'},
                    {data: 'date_paid', name: 'date_paid'},
                    {data: 'amount', name: 'amount'},
                    {data: 'payment_method', name: 'payment_method'},
                    {data: 'payment_type', name: 'payment_type'},
                    {data: 'description', name: 'description', orderable: false, searchable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>

    <?php echo Condat::registerModal(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.tenant', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>