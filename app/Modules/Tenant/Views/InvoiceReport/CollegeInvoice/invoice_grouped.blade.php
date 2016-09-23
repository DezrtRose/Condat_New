@extends('layouts.tenant')
@section('title', 'College Invoice Grouped')
@section('heading', '<h1>College Invoice - <small>Grouped</small></h1>')
@section('breadcrumb')
    @parent
    <li><a href="{{url('tenant/college_invoice_report/invoice_pending')}}" title="All College Invoices"><i
                    class="fa fa-users"></i> College Invoices</a></li>
    <li>Grouped Invoices</li>
@stop

@section('content')
    <div class="col-md-12">
        @include('Tenant::InvoiceReport/CollegeInvoice/partial/navbar')
        @include('flash::message')
    </div>

    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Grouped Invoices</h3>
            </div>
            <div class="box-body">
                <table class="table table-striped table-bordered table-condensed" id="invoice_report_table">
                    <thead>
                    <tr class="text-nowrap">
                        <th>Group Invoice Id</th>
                        <th>Date</th>
                        <th>Number of Invoices</th>
                        <th>Total Amount</th>
                        <th>Total GST</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($invoice_reports as $invoice)
                        <tr>
                            <td>{{ format_id($invoice->group_invoice_id, 'GI') }}</td>
                            <td>{{ format_date($invoice->date) }}</td>
                            <td>{{ $invoice->invoiceCount }}</td>
                            <td>{{ $invoice->total_amount }}</td>
                            <td>{{ $invoice->total_gst }}</td>
                            <td>
                                <a href="{{ route('invoice.grouped.show', $invoice->group_invoice_id) }}" title="View Invoice"><i
                                            class="processing btn btn-primary btn-sm glyphicon glyphicon-eye-open"
                                            data-toggle="tooltip" data-placement="top" title="View Invoice"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#invoice_report_table').DataTable({
                "pageLength": 10
            });
        });
    </script>
@stop