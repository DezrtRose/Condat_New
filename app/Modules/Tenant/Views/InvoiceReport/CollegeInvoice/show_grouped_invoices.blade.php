@extends('layouts.tenant')
@section('title', 'Group Invoices')

@section('breadcrumb')
    @parent
    <li><a href="{{url('tenant/college_invoice_report/invoice_grouped')}}" title="All Group Invoices"><i
                    class="fa fa-users"></i> Group Invoices</a></li>
    <li>View</li>
@stop
@section('content')
    <div class="row">
        @include('Tenant::InvoiceReport/CollegeInvoice/partial/navbar')
        @include('flash::message')
    </div>

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Group Invoice Details</h3>
        </div>
        <div class="box-body">
            <div class="col-sm-2">


                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Invoice Details</h3>
                    </div>

                    <!-- Recent Payments -->
                    <div class="box-body">

                        <strong><i class="fa fa-file-text-o margin-r-5"></i> Invoice Id</strong>

                        <p class="text-muted">{{ format_id($invoice_details->group_invoice_id, "GI") }}</p>
                        
                        <strong><i class="fa fa-file-text-o margin-r-5"></i> Invoice Date </strong>

                        <p class="text-muted">{{ format_date($invoice_details->date) }}</p>

                        <strong><i class="fa fa-file-text-o margin-r-5"></i> Total Amount </strong>

                        <p class="text-muted">{{ format_date($invoice_details->date) }}</p>

                        <strong><i class="fa fa-file-text-o margin-r-5"></i> Total GST </strong>

                        <p class="text-muted">{{ format_date($invoice_details->date) }}</p>

                        <strong><i class="fa fa-file-text-o margin-r-5"></i> Paid Amount </strong>

                        <p class="text-muted">{{ format_date($invoice_details->date) }}</p>

                        <strong><i class="fa fa-file-text-o margin-r-5"></i> Due Amount </strong>

                        <p class="text-muted">{{ format_date($invoice_details->date) }}</p>

                        <strong><i class="fa fa-file-text-o margin-r-5"></i> Due Date</strong>

                        <p class="text-muted">{{ format_date($invoice_details->due_date)}}</p>

                        <strong><i class="fa fa-file-text-o margin-r-5"></i> Description </strong>

                        <p class="text-muted">{{ $invoice_details->description }}</p>

                    </div>
                </div>
            </div>


            <div class="col-sm-10">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Invoices List</h3>
                    </div>
                    <div class="box-body table-responsive">
                        @include('Tenant::InvoiceReport/CollegeInvoice/partial/table')
                    </div>
                </div>
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