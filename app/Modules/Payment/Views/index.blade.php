@extends('layouts.main')
@section('title', 'All Agencies')
@section('heading', 'All Agencies')
@section('breadcrumb')
    @parent
    <li><a href="{{url('agency')}}" title="All Agencies"><i class="fa fa-dashboard"></i> Agencies</a></li>
@stop
@section('content')
    <div class="col-xs-12">
        @include('flash::message')
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Manage Agencies</h3>
                <a href="{{route('agency.create')}}" class="btn btn-primary btn-flat pull-right">Add New Agency</a>
            </div>
            <div class="box-body">
                <table id="agencies" class="table table-bordered table-striped dataTable">
                    <thead>
                    <tr>
                        <th>Company Name</th>
                        <th>Amount</th>
                        <th>Payment Date</th>
                        <th>Payment Type</th>
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
                    {data: 'company_name', name: 'company_name'},
                    {data: 'amount', name: 'amount'},
                    {data: 'payment_date', name: 'payment_date'},
                    {data: 'payment_type', name: 'payment_type'},
                ]
            });
        });
    </script>
@stop
