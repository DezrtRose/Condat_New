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
                <a href='{{ route('tenant.application.invoice', [$tenant_id, $application->application_id]) }}'
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
                        <th>Total GST</th>
                        <th>Status</th>
                        <th>Outstanding Amount</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($invoices as $key => $invoice)
                        <tr>
                            <td>{{ format_id($invoice->college_invoice_id, 'CI') }}</td>
                            <td>{{ format_date($invoice->invoice_date) }}</td>
                            <td>{{ format_price($invoice->total_commission) }}</td>
                            <td>{{ format_price($invoice->total_gst) }}</td>
                            <td>{{ ($invoice->outstanding_amount > 0) ? 'Outstanding' : 'Paid' }}</td>
                            <td>
                                @if ($invoice->outstanding_amount > 0)
                                    {{ format_price($invoice->outstanding_amount) }} <a class="btn btn-success btn-xs" data-toggle="modal" data-target="#condat-modal" data-url="{{ url($tenant_id.'/invoices/' . $invoice->college_invoice_id . '/payment/add/1') }}"><i class="glyphicon glyphicon-plus-sign"></i> Add Payment</a>
                                @else
                                    $0.00
                                @endif
                            </td>
                            <td><div class="btn-group">
                                    <button class="btn btn-primary" type="button">Action</button>
                                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul role="menu" class="dropdown-menu">
                                        <li><a href="{{ route("tenant.invoice.payments", [$tenant_id, $invoice->college_invoice_id, 1]) }}">View payments</a></li>
                                        <li><a href="{{ route('tenant.college.invoice', [$tenant_id, $invoice->college_invoice_id]) }}" target="_blank">Print Invoice</a></li>
                                        <li><a href="{{ route('tenant.college.pdf', [$tenant_id, $invoice->college_invoice_id]) }}" target="_blank">Download PDF</a></li>
                                        <li><a href="#" data-toggle="modal" data-target="#condat-modal" data-url="{{ route('tenant.college.mail', [$tenant_id, $invoice->college_invoice_id]) }}">Mail Invoice</a></li>
                                        <li><a href="{{ route("tenant.college.editInvoice", [$tenant_id, $invoice->college_invoice_id]) }}">Edit</a></li>
                                        <li><a type="button" data-toggle="modal" data-target="#deleteInvoice" id="{{ $invoice->college_invoice_id }}" class="delete-invoice">Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Recent Payments</h3>
                <a href="{{ route('tenant.application.payment', [$tenant_id, $application->application_id]) }}"
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
                        <th>Assign Invoice</th>
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
                <table id="future" class="table table-bordered table-striped dataTable">
                    <thead>
                    <tr>
                        <th>Invoice ID</th>
                        <th>Invoice Date</th>
                        <th>Sub Total</th>
                        <th>Total GST</th>
                        <th>Status</th>
                        <th>Outstanding Amount</th>
                        <th></th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($future_invoices as $key => $invoice)
                        <tr>
                            <td>{{ format_id($invoice->college_invoice_id, 'CI') }}</td>
                            <td>{{ format_date($invoice->invoice_date) }}</td>
                            <td>{{ format_price($invoice->total_commission) }}</td>
                            <td>{{ format_price($invoice->total_gst) }}</td>
                            <td>{{ ($invoice->outstanding_amount > 0) ? 'Outstanding' : 'Paid' }}</td>
                            <td>
                                @if ($invoice->outstanding_amount > 0)
                                    {{ format_price($invoice->outstanding_amount) }} <a class="btn btn-success btn-xs" data-toggle="modal" data-target="#condat-modal" data-url="{{ url($tenant_id.'/invoices/' . $invoice->college_invoice_id . '/payment/add/1') }}"><i class="glyphicon glyphicon-plus-sign"></i> Add Payment</a>
                                @else
                                    $0.00
                                @endif
                            </td>
                            <td><div class="btn-group">
                                    <button class="btn btn-primary" type="button">Action</button>
                                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul role="menu" class="dropdown-menu">
                                        <li><a href="{{ route("tenant.invoice.payments", [$tenant_id, $invoice->college_invoice_id, 1]) }}">View payments</a></li>
                                        <li><a href="{{ route('tenant.college.invoice', [$tenant_id, $invoice->college_invoice_id]) }}" target="_blank">Print Invoice</a></li>
                                        <li><a href="{{ route('tenant.college.pdf', [$tenant_id, $invoice->college_invoice_id]) }}" target="_blank">Download PDF</a></li>
                                        <li><a href="{{ route("tenant.college.editInvoice", [$tenant_id, $invoice->college_invoice_id]) }}">Edit</a></li>
                                        <li><a type="button" data-toggle="modal" data-target="#deleteInvoice" id="{{ $invoice->college_invoice_id }}" class="delete-invoice">Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    @include('Tenant::Client/Invoice/deletebox')

    <script type="text/javascript">
        $(document).ready(function () {
            $('#invoices, #future').DataTable({
                "pageLength": 20,
                order: [[0, 'desc']]
            });

            oTable = $('#payments').DataTable({
                "processing": true,
                "serverSide": true,

                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": true,

                "ajax": appUrl + "/applications/payments/" + <?php echo $application->application_id ?> +"/data",
                "columns": [
                    {data: 'college_payment_id', name: 'college_payment_id'},
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

            $(document).on("click", ".delete-invoice", function () {
                var invoiceId = $(this).attr('id');
                $(".modal-footer .btn-action").attr('id', invoiceId);
            });

            $('.btn-delete').click(function(e){
                e.preventDefault();
                var invoiceId = $(this).attr('id');
                var invoiceAction = $(this).data('action');
                var url = appUrl + '/college/' + invoiceId + '/' + invoiceAction;
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

            $(document).on('submit', '#mail-invoice', function (e) {
                e.preventDefault();
                var form = $(this);

                var doing = false;
                form.find('.btn-success').html('Sending...');
                form.find('.btn-success').attr('disabled', true);

                form.find('.has-error').removeClass('has-error');
                form.find('label.error').remove();
                form.find('.callout').remove();

                var formData = form.serialize();
                var formAction = form.attr('action');

                if (doing == false) {
                    doing = true;

                    $.ajax({
                        url: formAction,
                        type: 'POST',
                        data: formData,
                        dataType: 'json'
                    })
                            .done(function (response) {
                                if (response.status == 0) {
                                    $.each(response.data.errors, function (i, v) {
                                        $('.modal-body #' + i).parent().addClass('has-error');
                                        $('.modal-body #' + i).after('<label class="error error-' + i + '">' + v + '<label>');
                                    });
                                }

                                if (response.status == 1) {
                                    $('#condat-modal').modal('hide');
                                    $('.mainContainer .box').before(notify('success', response.message));
                                    setTimeout(function () {
                                        $('.callout').remove()
                                    }, 2500);
                                    window.location.reload();
                                } //success
                            })
                            .fail(function () {
                                alert('Something Went Wrong! Please Try Again Later.');
                            })
                            .always(function () {
                                doing = false;
                                form.find('.btn-success').removeAttr('disabled');
                                form.find('.btn-success').val('<i class="fa fa-paper-plane"></i> Send');
                            });
                }

            });

            function notify(type, text) {
                return '<div class="callout callout-' + type + '"><p>' + text + '</p></div>';
            }
        });
    </script>

    {!! Condat::registerModal() !!}
@stop