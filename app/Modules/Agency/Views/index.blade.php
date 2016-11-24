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
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Manage Agencies</h3>
                <a href="{{route('agency.create')}}" class="btn btn-primary btn-flat pull-right">Add New Agency</a>
            </div>
            <div class="box-body">
                <table id="agencies" class="table table-bordered table-striped dataTable">
                    <thead>
                    <tr>
                        <th>Agency ID</th>
                        <th>Company Name</th>
                        <th>Phone</th>
                        <th>Subscription Type</th>
                        <th>Subscription Status</th>
                        <th>Expiry Date</th>
                        <th>Actions</th>
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
                    "ajax": appUrl + "/agencies/data",
                    "columns": [
                        {data: 'agency_id', name: 'agencies.agency_id'},
                        {data: 'name', name: 'companies.name'},
                        {data: 'phone_id', name: 'phone_id'},
                        {data: 'subscription_id', name: 'subscription_id'},
                        {data: 'subscription_name', name: 'subscription_name', searchable: false},
                        {data: 'end_date', name: 'end_date'},
                        {data: 'action', name: 'action', orderable: false, searchable: false}
                    ],
                    "order": [[0, "desc"]]
                });
            });
        </script>
@stop
