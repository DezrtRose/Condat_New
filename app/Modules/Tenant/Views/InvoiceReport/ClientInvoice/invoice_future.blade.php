@extends('layouts.tenant')
@section('title', 'Client Invoice Future')
@section('heading', '<h1>Client Invoice - <small>Future</small></h1>')
@section('breadcrumb')
    @parent
    <li><a href="{{url($tenant_id.'/client_invoice_report/invoice_pending')}}" title="All Client Invoices"><i
                    class="fa fa-users"></i> Client Invoices</a></li>
    <li>Future Invoices</li>
@stop

@section('content')
    <div class="col-md-12">
        @include('Tenant::InvoiceReport/ClientInvoice/partial/navbar')
        @include('flash::message')

        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Future Invoices</h3>
            </div>
            <div class="box-body">
                @include('Tenant::InvoiceReport/ClientInvoice/partial/table')
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
@stop