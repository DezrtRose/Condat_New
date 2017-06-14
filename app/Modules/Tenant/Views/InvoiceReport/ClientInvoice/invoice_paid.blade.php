@extends('layouts.tenant')
@section('title', 'Application Enquiry')
@section('heading', 'Client Invoices - <small>Paid Invoices</small>')
@section('breadcrumb')
    @parent
    <li><a href="{{url($tenant_id.'/clients')}}" title="All Clients"><i class="fa fa-users"></i> Clients</a></li>
    <li>Paid Invoices</li>
@stop

@section('content')
    <div class="col-md-12">

        @include('Tenant::InvoiceReport/ClientInvoice/partial/navbar')
        @include('flash::message')

        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Paid Invoices</h3>
            </div>
            <div class="box-body">
                <section>
                    <table class="table table-striped table-bordered table-condensed"
                           id="invoice_report_table">
                        <thead>
                        <tr class="text-nowrap">
                            <th>Invoice Id</th>
                            <th>Date</th>
                            <th>Client Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Discount</th>
                            <th>Invoice Amount</th>
                            <th>Total gst</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($invoice_reports as $invoice)
                            <tr>
                                <td>{{ format_id($invoice->invoice_id, 'I') }}</td>
                                <td>{{ format_date($invoice->invoice_date) }}</td>
                                <td>{{ $invoice->fullname }}</td>
                                <td>{{ $invoice->number }}</td>
                                <td>{{ $invoice->email }}</td>
                                <td>{{ format_price($invoice->discount) }}</td>
                                <td>{{ format_price($invoice->invoice_amount) }}</td>
                                <td>{{ format_price($invoice->total_gst) }}</td>
                                <td>
                                    <a data-toggle="modal" data-target="#condat-modal"
                                       data-url="{{url($tenant_id.'/invoices/' . $invoice->invoice_id . '/payment/add/2')}}"><i
                                                class=" btn btn-primary btn-sm glyphicon glyphicon-shopping-cart"
                                                data-toggle="tooltip" data-placement="top"
                                                title="Add Payment"></i></a>
                                    <a target="_blank" href="{{route('tenant.student.invoice', [$tenant_id, $invoice->student_invoice_id])}}"
                                       title="Print Invoice"><i
                                                class="processing btn btn-primary btn-sm glyphicon glyphicon-print"
                                                data-toggle="tooltip" data-placement="top"
                                                title="Print Invoice"></i></a>
                                    <a href="{{route("tenant.invoice.payments", [$tenant_id, $invoice->invoice_id, 2])}}"
                                       title="View Invoice"><i
                                                class="processing btn btn-primary btn-sm glyphicon glyphicon-eye-open"
                                                data-toggle="tooltip" data-placement="top"
                                                title="View Invoice"></i></a>
                                    <a href="#" data-toggle="modal" data-target="#condat-modal" data-url="{{ route('tenant.student.mail', [$tenant_id, $invoice->student_invoice_id]) }}"><i
                                                class="processing btn btn-primary btn-sm glyphicon glyphicon-send"
                                                data-toggle="tooltip" data-placement="top"
                                                title="Mail Invoice"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </section>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#invoice_report_table').DataTable({
                "pageLength": 50,
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                order: [[0, 'desc']]
            });
        });
    </script>
    {!! Condat::js('client_mail.js') !!}
    {!! Condat::registerModal() !!}
@stop