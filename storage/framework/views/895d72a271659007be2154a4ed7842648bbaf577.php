<?php $__env->startSection('title', 'Client View'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    @parent
    <li><a href="<?php echo e(url('tenant/client')); ?>" title="All Clients"><i class="fa fa-users"></i> Clients</a></li>
    <li>View</li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('Tenant::Client/Application/navbar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Recent Invoices</h3>
                <a href='<?php echo e(route('tenant.application.invoice', $application->application_id)); ?>'
                   class="btn btn-success btn-flat pull-right"><i class="glyphicon glyphicon-plus-sign"></i> Create
                    Invoice</a>
            </div>
            <div class="box-body">
                <table id="invoices" class="table table-bordered table-striped dataTable">
                    <thead>
                    <tr>
                        <th>Invoice ID</th>
                        <th>Invoice Date</th>
                        <th>Sub Total</th>
                        <th>Invoice Amount</th>
                        <th>Status</th>
                        <th>Outstanding Amount</th>
                        <th></th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Recent Payments</h3>
                <a href="<?php echo e(route('tenant.application.payment', $application->application_id)); ?>"
                   class="btn btn-success btn-flat pull-right"><i class="glyphicon glyphicon-plus-sign"></i> Add
                    Payments</a>
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
                        <th>Invoice Id</th>
                        <th>Description</th>
                        <th></th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Future Invoices</h3>
                <button class="btn btn-success btn-flat pull-right"><i class="glyphicon glyphicon-plus-sign"></i> Create
                    Invoice
                </button>
            </div>
            <div class="box-body">
                <table id="clients" class="table table-bordered table-striped dataTable">
                    <thead>
                    <tr>
                        <th>Invoice ID</th>
                        <th>Future Invoice Date</th>
                        <th>Description</th>
                        <th>Invoice Amount</th>
                        <th>Status</th>
                        <th>Outstanding Amount</th>
                        <th></th>

                    </tr>
                    <tr>
                        <td>I80001</td>
                        <td>12/06/2016</td>

                        <td>College fee</td>
                        <td>2000</td>
                        <td>outstanding</td>
                        <td>5000 /view paymens)</td>
                        <td>Add payment / view / edit / delete</td>

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

                "ajax": appUrl + "/tenant/applications/payments/" + <?php echo $application->application_id ?> +"/data",
                "columns": [
                    {data: 'college_payment_id', name: 'college_payment_id'},
                    {data: 'date_paid', name: 'date_paid'},
                    {data: 'amount', name: 'amount'},
                    {data: 'payment_method', name: 'payment_method'},
                    {data: 'payment_type', name: 'payment_type'},
                    {data: 'invoice_id', name: 'invoice_id', orderable: false, searchable: false},
                    {data: 'description', name: 'description', orderable: false, searchable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

            iTable = $('#invoices').DataTable({
                "processing": true,
                "serverSide": true,

                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": true,

                "ajax": appUrl + "/tenant/applications/invoices/" + <?php echo $application->application_id ?> +"/data",
                "columns": [
                    {data: 'college_invoice_id', name: 'college_invoice_id'},
                    {data: 'invoice_date', name: 'invoice_date'},
                    {data: 'sub_total', name: 'sub_total'},
                    {data: 'invoice_amount', name: 'invoice_amount'},
                    {data: 'status', name: 'status'},
                    {data: 'outstanding_amount', name: 'outstanding_amount'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.tenant', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>