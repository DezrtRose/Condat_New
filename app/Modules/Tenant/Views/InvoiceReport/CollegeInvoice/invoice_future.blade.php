@extends('layouts.tenant')
@section('title', 'College Invoice Future')
@section('heading', '<h1>College Invoice - <small>Future</small></h1>')
@section('breadcrumb')
    @parent
    <li><a href="{{url('tenant/college_invoice_report/invoice_pending')}}" title="All College Invoices"><i
                    class="fa fa-users"></i> College Invoices</a></li>
    <li>Future Invoices</li>
@stop

@section('content')
    <div class="col-md-12">
        @include('Tenant::InvoiceReport/CollegeInvoice/partial/navbar')
        @include('flash::message')
    </div>

    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Future Invoices</h3>
            </div>
            <div class="box-body">
                @include('Tenant::InvoiceReport/CollegeInvoice/partial/table')
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
                ]
            });
        });
    </script>
@stop