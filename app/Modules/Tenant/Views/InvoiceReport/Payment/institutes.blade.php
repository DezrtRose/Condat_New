@extends('layouts.tenant')
@section('title', 'Client Payments')
@section('heading', 'All Payments - <small>Institute</small>')
@section('breadcrumb')
    @parent
    <li><a href="{{url('tenant/client')}}" title="All Clients"><i class="fa fa-users"></i> Clients</a></li>
    <li>View</li>
@stop
@section('content')

    <div class="col-xs-12">
        @include('Tenant::InvoiceReport/Payment/partial/navbar')
        @include('flash::message')

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">All Payments</h3>
            </div>
            <div class="box-body">
                <table id="payments" class="table table-bordered table-striped dataTable">
                    <thead>
                    <tr>
                        <th>Payment ID</th>
                        <th>Payment Date</th>
                        <th>Institute Name</th>
                        <th>Client Name</th>
                        <th>Amount</th>
                        <th>Payment Type</th>
                        <th>Invoice Id</th>
                        <th>Added By</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody> <?php //dd($payments->toArray()) ?>

                    @foreach($payments as $key => $payment)
                        <tr>
                            <td>{{ format_id($payment->college_payment_id, 'CPI') }}</td>
                            <td>{{ format_date($payment->date_paid) }}</td>
                            <td>{{ $payment->company_name }}</td>
                            <td>{{ $payment->client_name }}</td>
                            <td>{{ format_price($payment->amount) }}</td>
                            <td>{{ $payment->payment_type }}</td>
                            <td>{{ ($payment->college_invoice_id != 0)? format_id($payment->college_invoice_id, 'CI') : ''}}</td>
                            <td>{{ get_tenant_name($payment->added_by) }}</td>
                            <td>
                                <a target="_blank" href="{{route('tenant.college.payment.receipt', [$tenant_id, $payment->college_payment_id])}}" title="Print Payment"><i
                                            class="processing btn btn-primary btn-sm glyphicon glyphicon-print"
                                            data-toggle="tooltip" data-placement="top"
                                            title="Print Payment"></i></a>
                                <a href="{{route('tenant.application.editPayment', [$tenant_id, $payment->college_payment_id])}}" title="Edit Payment"><i
                                            class="processing btn btn-primary btn-sm glyphicon glyphicon-pencil"
                                            data-toggle="tooltip" data-placement="top" title="Edit Payment"></i></a>
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
            oTable = $('#payments').DataTable({
                "pageLength": 50,
                order: [[0, 'desc']],
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>

    {!! Condat::registerModal() !!}
@stop