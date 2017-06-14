@extends('layouts.tenant')
@section('title', 'All Agents')
@section('breadcrumb')
    @parent
    <li><a href="{{url('agents')}}" title="All Agents"><i class="fa fa-dashboard"></i> Agents</a></li>
@stop
@section('content')
    <div class="col-xs-12">
        @include('flash::message')

        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Manage Agents</h3>
                <a href="{{route('tenant.agents.create', $tenant_id)}}" class="btn btn-primary btn-flat pull-right">Add New Agent</a>
            </div>
            <div class="box-body">
                <table id="agents" class="table table-bordered table-striped dataTable">
                    <thead>
                    <tr>
                        <th>Agent ID</th>
                        <th>Agent Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Website</th>
                        <th>Added By</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($agents as $agent)
                    <tr>
                        <td>{{ format_id($agent->agent_id, 'Ag') }}</td>
                        <td>{{ $agent->name }}</td>
                        <td>{{ $agent->number }}</td>
                        <td><a href="mailto:{{ $agent->email }}">{{ $agent->email }}</a></td>
                        <td><a href="{{ $agent->website }}" target="_blank">{{ $agent->website }}</a></td>
                        <td>{{ get_tenant_name($agent->added_by) }}</td>
                        <td><a data-toggle="tooltip" title="View Agent" class="btn btn-action-box" href ="{{ route('tenant.agents.show', [$tenant_id, $agent->agent_id]) }}"><i class="fa fa-eye"></i></a> <a data-toggle="tooltip" title="Edit Agent" class="btn btn-action-box" href ="{{ route('tenant.agents.edit', [$tenant_id, $agent->agent_id]) }}"><i class="fa fa-edit"></i></a> <a data-toggle="tooltip" title="Delete Agent" class="delete-user btn btn-action-box" href="{{ route( 'tenant.agents.destroy', [$tenant_id, $agent->agent_id]) }}"><i class="fa fa-trash"></i></a></td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#agents').DataTable({
                "pageLength": 50,
                order: [[0, 'desc']]
            });
        });
    </script>
@stop
