@extends('layouts.main')
@section('title', 'All Payments')
@section('heading', 'All Payments')
@section('breadcrumb')
    @parent
    <li><a href="{{url('payment')}}" title="All Payments"><i class="fa fa-dashboard"></i> Payments</a></li>
@stop
@section('content')
    <div class="col-xs-12">
        @include('flash::message')
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Manage Payments</h3>
            </div>
            <div class="box-body">
                <table id="agencies" class="table table-bordered table-striped dataTable">
                    <thead>
                    <tr>
                        <th>Payment ID</th>
                        <th>Agency Name</th>
                        <th>Amount</th>
                        <th>Payment Date</th>
                        <th>Payment Type</th>
                        <th>Subscription Type</th>
                        <th>Subscription Expiry Date</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            oTable = $('#agencies').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": appUrl + "/payments/data",
                "columns": [
                    {data: 'subscription_payment_id', name: 'subscription_payment_id'},
                    {data: 'company_name', name: 'companies.name'},
                    {data: 'amount', name: 'amount'},
                    {data: 'payment_date', name: 'payment_date'},
                    {data: 'payment_type', name: 'payment_type'},
                    {data: 'subscription_id', name: 'subscription_id'},
                    {data: 'end_date', name: 'end_date'},
                ]
            });
        });
    </script>
@stop
