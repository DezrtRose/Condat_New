@extends('layouts.tenant')
@section('title', 'Client View')
@section('breadcrumb')
    @parent
    <li><a href="{{url('tenant/client')}}" title="All Clients"><i class="fa fa-users"></i> Clients</a></li>
    <li>View</li>
@stop
@section('content')

    @include('Tenant::Client/Application/navbar')

    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Recent Invoices</h3>
                <a href='{{ route('application.students.invoice', [$tenant_id, $application->application_id]) }}'
                   class="btn btn-success btn-flat pull-right"><i class="glyphicon glyphicon-plus-sign"></i> Create
                    Invoice</a>
            </div>
            <div class="box-body">
                <table id="invoices" class="table table-bordered table-striped dataTable">
                    <thead>
                    <tr>
                        <th>Invoice ID</th>
                        <th>Invoice Date</th>
                        <th>Description</th>
                        <th>Discount</th>
                        <th>Invoice Amount</th>
                        <th>GST</th>
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
                <a href="{{ route('application.students.payment', [$tenant_id, $application->application_id]) }}"
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
                        <th>Payment Method</th>
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
            </div>
            <div class="box-body">
                <table id="recent" class="table table-bordered table-striped dataTable">
                    <thead>
                    <tr>
                        <th>Invoice ID</th>
                        <th>Invoice Date</th>
                        <th>Description</th>
                        <th>Discount</th>
                        <th>Invoice Amount</th>
                        <th>GST</th>
                        <th>Status</th>
                        <th>Outstanding Amount</th>
                        <th></th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    @include('Tenant::Client/Invoice/deletebox')

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

                "ajax": appUrl + "/students/payments/" + <?php echo $application->application_id ?> +"/data",
                "columns": [
                    {data: 'student_payments_id', name: 'student_payments_id'},
                    {data: 'date_paid', name: 'date_paid'},
                    {data: 'amount', name: 'amount'},
                    {data: 'payment_method', name: 'payment_method'},
                    {data: 'payment_type', name: 'payment_type'},
                    {data: 'invoice_id', name: 'invoice_id', orderable: false, searchable: false},
                    {data: 'description', name: 'description', orderable: false, searchable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                order: [[0, 'desc']]
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

                "ajax": appUrl + "/students/invoices/" + <?php echo $application->application_id ?> +"/data",
                "columns": [
                    {data: 'invoice_id', name: 'invoice_id'},
                    {data: 'invoice_date', name: 'invoice_date'},
                    {data: 'description', name: 'description', orderable: false},
                    {data: 'discount', name: 'discount'},
                    {data: 'invoice_amount', name: 'invoice_amount'},
                    {data: 'total_gst', name: 'total_gst'},
                    {data: 'status', name: 'status'},
                    {data: 'outstanding_amount', name: 'outstanding_amount'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                order: [[0, 'desc']]
            });

            rTable = $('#recent').DataTable({
                "processing": true,
                "serverSide": true,

                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": true,

                "ajax": appUrl + "/students/recent/" + <?php echo $application->application_id ?> +"/data",
                "columns": [
                    {data: 'invoice_id', name: 'invoice_id'},
                    {data: 'invoice_date', name: 'invoice_date'},
                    {data: 'description', name: 'description', orderable: false},
                    {data: 'discount', name: 'discount'},
                    {data: 'invoice_amount', name: 'invoice_amount'},
                    {data: 'total_gst', name: 'total_gst'},
                    {data: 'status', name: 'status'},
                    {data: 'outstanding_amount', name: 'outstanding_amount'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                order: [[0, 'desc']]
            });

            $(document).on("click", ".delete-invoice", function () {
                var invoiceId = $(this).attr('id');
                $(".modal-footer .btn-action").attr('id', invoiceId);
            });

            $('.btn-delete').click(function(e){
                e.preventDefault();
                var invoiceId = $(this).attr('id');
                var invoiceAction = $(this).data('action');
                var url = appUrl + '/student/' + invoiceId + '/' + invoiceAction;
                //var conf = confirm('Are you sure?');
                window.location.replace(url);
                return false;
            });

            $(document).on("submit", "#add-invoice", function (event) {
                var formData = $(this).serialize();
                var url = $(this).attr('action');
                $(this).find('.has-error').removeClass('has-error');
                $(this).find('label.error').remove();
                $(this).find('.callout').remove();

                // process the form
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: formData,
                    dataType: 'json',
                    encode: true
                })
                        .done(function (result) {
                            if (result.status == 1) {
                                $('#condat-modal').modal('hide');
                                window.location.reload();
                            }
                            else {
                                $.each(result.data.errors, function (i, v) {
                                    $('#add-invoice').find('#' + i).after('<label class="error ">' + v + '</label>').closest('.form-group').addClass('has-error');
                                });
                            }
                            setTimeout(function () {
                                $('.callout').remove()
                            }, 2500);
                        });
                event.preventDefault();
            });
        });
    </script>

    {!! Condat::js('client_mail.js') !!}
    {!! Condat::registerModal() !!}
@stop