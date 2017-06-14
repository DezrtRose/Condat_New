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
                <div class="tab-content" style="margin-top: 15px">
                    <div role="tabpanel" class="tab-pane active" id="new">
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
                            <tbody>
                            @foreach($new_agencies as $key => $new_agency)
                                <tr>
                                    <td>{{ format_id($new_agency->agency_id, 'A') }}</td>
                                    <td>{{ $new_agency->name }}</td>
                                    <td>{{ $new_agency->phone_id }}</td>
                                    <td>{{ $new_agency->subscription_id }}</td>
                                    <td>{{ $new_agency->subscription_name }}</td>
                                    <td>{{ format_date($new_agency->end_date) }}</td>
                                    <td>
                                        <?php $status_link = (($new_agency->status == 1) ? '<a data-toggle="tooltip" title="Deactivate Agency" class="btn btn-action-box" onclick="return confirm (\'Are you sure?\')" href ="'. route('agencies.deactivate', $new_agency->agency_id) .'"><i class="fa fa-minus-circle"></i></a>' : '<a data-toggle="tooltip" title="Reactivate Agency" class="btn btn-action-box" onclick="return confirm (\'Are you sure?\')" href ="'. route('agencies.activate', $new_agency->agency_id) .'"><i class="fa fa-plus-circle"></i></a>') ?>
                                        <a data-toggle="tooltip" title="View Agency" class="btn btn-action-box" href ="{{ route('agency.show', $new_agency->agency_id) }}"><i class="fa fa-eye"></i></a> <a data-toggle="tooltip" title="Renew Agency Subscription" class="btn btn-action-box" href ="{{ route('agency.renew', $new_agency->agency_id) }}"><i class="fa fa-refresh"></i></a> <a data-toggle="tooltip" title="Edit Agency" class="btn btn-action-box" href ="{{ route('agency.edit', $new_agency->agency_id) }}"><i class="fa fa-edit"></i></a> {!! $status_link !!}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
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
                            <tbody>
                            @foreach($expiring_agencies as $key => $expiring_agency)
                                <tr>
                                    <td>{{ format_id($expiring_agency->agency_id, 'A') }}</td>
                                    <td>{{ $expiring_agency->name }}</td>
                                    <td>{{ $expiring_agency->phone_id }}</td>
                                    <td>{{ $expiring_agency->subscription_id }}</td>
                                    <td>{{ $expiring_agency->subscription_name }}</td>
                                    <td>{{ format_date($expiring_agency->end_date) }}</td>
                                    <td>
                                        <?php $status_link = (($expiring_agency->status == 1) ? '<a data-toggle="tooltip" title="Deactivate Agency" class="btn btn-action-box" onclick="return confirm (\'Are you sure?\')" href ="'. route('agencies.deactivate', $expiring_agency->agency_id) .'"><i class="fa fa-minus-circle"></i></a>' : '<a data-toggle="tooltip" title="Reactivate Agency" class="btn btn-action-box" onclick="return confirm (\'Are you sure?\')" href ="'. route('agencies.activate', $expiring_agency->agency_id) .'"><i class="fa fa-plus-circle"></i></a>') ?>
                                        <a data-toggle="tooltip" title="View Agency" class="btn btn-action-box" href ="{{ route('agency.show', $expiring_agency->agency_id) }}"><i class="fa fa-eye"></i></a> <a data-toggle="tooltip" title="Renew Agency Subscription" class="btn btn-action-box" href ="{{ route('agency.renew', $expiring_agency->agency_id) }}"><i class="fa fa-refresh"></i></a> <a data-toggle="tooltip" title="Edit Agency" class="btn btn-action-box" href ="{{ route('agency.edit', $expiring_agency->agency_id) }}"><i class="fa fa-edit"></i></a> {!! $status_link !!}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
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
                            <tbody>
                            @foreach($expired_agencies as $key => $expired_agency)
                                <tr>
                                    <td>{{ format_id($expired_agency->agency_id, 'A') }}</td>
                                    <td>{{ $expired_agency->name }}</td>
                                    <td>{{ $expired_agency->phone_id }}</td>
                                    <td>{{ $expired_agency->subscription_id }}</td>
                                    <td>{{ $expired_agency->subscription_name }}</td>
                                    <td>{{ format_date($expired_agency->end_date) }}</td>
                                    <td>
                                        <?php $status_link = (($expired_agency->status == 1) ? '<a data-toggle="tooltip" title="Deactivate Agency" class="btn btn-action-box" onclick="return confirm (\'Are you sure?\')" href ="'. route('agencies.deactivate', $expired_agency->agency_id) .'"><i class="fa fa-minus-circle"></i></a>' : '<a data-toggle="tooltip" title="Reactivate Agency" class="btn btn-action-box" onclick="return confirm (\'Are you sure?\')" href ="'. route('agencies.activate', $expired_agency->agency_id) .'"><i class="fa fa-plus-circle"></i></a>') ?>
                                        <a data-toggle="tooltip" title="View Agency" class="btn btn-action-box" href ="{{ route('agency.show', $expired_agency->agency_id) }}"><i class="fa fa-eye"></i></a> <a data-toggle="tooltip" title="Renew Agency Subscription" class="btn btn-action-box" href ="{{ route('agency.renew', $expired_agency->agency_id) }}"><i class="fa fa-refresh"></i></a> <a data-toggle="tooltip" title="Edit Agency" class="btn btn-action-box" href ="{{ route('agency.edit', $expired_agency->agency_id) }}"><i class="fa fa-edit"></i></a> {!! $status_link !!}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            oTable = $('#new-agencies').DataTable({
                "pageLength": 50,
                order: [[0, 'desc']]
            });

            eTable = $('#expiring-agencies').DataTable({
                "pageLength": 50,
                order: [[0, 'desc']]
            });

            exTable = $('#expired-agencies').DataTable({
                "pageLength": 50,
                order: [[0, 'desc']]
            });
        });
    </script>
@stop