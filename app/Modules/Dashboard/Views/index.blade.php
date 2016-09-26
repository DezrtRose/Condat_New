@extends('layouts.main')
@section('title', 'Dashboard')
@section('heading', 'Dashboard')
@section('breadcrumb')
    @parent
@stop
@section('content')

    <div class="col-xs-12">
        @include('flash::message')
        {{--@include('Dashboard::statistics')--}}
        <div class="box box-primary">
            <div class="box-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#new" aria-controls="new" role="tab" data-toggle="tab">
                            <div class="box-header">
                                <h3 class="box-title">Newly Registered Agencies<span
                                            class="small"> - within two months</span></h3>
                            </div>
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#expiring" aria-controls="expiring" role="tab" data-toggle="tab">
                            <div class="box-header">
                                <h3 class="box-title">Expiring Agencies<span
                                            class="small"> - within two months</span></h3>
                            </div>
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#expired" aria-controls="expired" role="tab" data-toggle="tab">
                            <div class="box-header">
                                <h3 class="box-title">Expired Agencies</h3>
                            </div>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="new">
                        <div class="form-group">
                            <a href="{{route('agency.create')}}" class="btn btn-primary btn-flat">Add New
                                Agency</a>
                        </div>
                        <table id="new-agencies" class="table table-bordered table-striped dataTable">
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
                    <div role="tabpanel" class="tab-pane" id="expiring">
                        <table id="expiring-agencies" class="table table-bordered table-striped dataTable">
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
                    <div role="tabpanel" class="tab-pane" id="expired">
                        <table id="expired-agencies" class="table table-bordered table-striped dataTable">
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
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            oTable = $('#new-agencies').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": appUrl + "/dashboard/newAgencyData",
                "columns": [
                    {data: 'agency_id', name: 'agency_id'},
                    {data: 'name', name: 'name'},
                    {data: 'phone_id', name: 'phone_id'},
                    {data: 'subscription_id', name: 'subscription_id'},
                    {data: 'subscription_name', name: 'subscription_name'},
                    {data: 'end_date', name: 'end_date'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

            eTable = $('#expiring-agencies').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": appUrl + "/dashboard/expiringAgencyData",
                "columns": [
                    {data: 'agency_id', name: 'agency_id'},
                    {data: 'name', name: 'name'},
                    {data: 'phone_id', name: 'phone_id'},
                    {data: 'subscription_id', name: 'subscription_id'},
                    {data: 'subscription_name', name: 'subscription_name'},
                    {data: 'end_date', name: 'end_date'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

            exTable = $('#expired-agencies').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": appUrl + "/dashboard/expiredAgencyData",
                "columns": [
                    {data: 'agency_id', name: 'agency_id'},
                    {data: 'name', name: 'name'},
                    {data: 'phone_id', name: 'phone_id'},
                    {data: 'subscription_id', name: 'subscription_id'},
                    {data: 'subscription_name', name: 'subscription_name'},
                    {data: 'end_date', name: 'end_date'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>
@stop