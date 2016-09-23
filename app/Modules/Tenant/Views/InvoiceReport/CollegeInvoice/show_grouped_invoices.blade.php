@extends('layouts.tenant')
@section('title', 'Grouped Invoices')
@section('heading', '<h1>Invoices - <small>Grouped</small></h1>')
@section('breadcrumb')
    @parent
    <li><a href="{{url('tenant/college_invoice_report/invoice_grouped')}}" title="All Grouped Invoices"><i
                    class="fa fa-users"></i> Grouped Invoices</a></li>
    <li>Invoices Invoices</li>
@stop
@section('content')
    <div class="col-md-12">
        @include('Tenant::InvoiceReport/CollegeInvoice/partial/navbar')
        @include('flash::message')
    </div>

    <div class="col-xs-3">

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Group Invoice Details</h3>
            </div>
            <!-- Recent Payments -->
            <div class="box-body">

                <strong><i class="fa fa-file-text-o margin-r-5"></i> Invoice Id</strong>

                <p class="text-muted">{{ format_id($invoice_details->group_invoice_id) }}</p>

                <strong><i class="fa fa-file-text-o margin-r-5"></i> Invoice Date </strong>

                <p class="text-muted">{{ format_date($invoice_details->date) }}</p>

                <strong><i class="fa fa-file-text-o margin-r-5"></i> Due Date</strong>

                <p class="text-muted">{{ format_date($invoice_details->due_date)}}</p>

                <strong><i class="fa fa-file-text-o margin-r-5"></i> Description </strong>

                <p class="text-muted">{{ $invoice_details->description }}</p>

            </div>
        </div>

    </div>

    <div class="col-xs-9">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Grouped Invoices</h3>
            </div>
            <div class="box-body table-responsive">
                @include('Tenant::InvoiceReport/CollegeInvoice/partial/table')
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

    {!! Condat::registerModal() !!}
@stop