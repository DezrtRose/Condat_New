@extends('layouts.tenant')
@section('title', 'All Institutions')
@section('breadcrumb')
    @parent
    <li><a href="{{url('institute')}}" title="All Institutions"><i class="fa fa-dashboard"></i> Institutions</a></li>
@stop
@section('content')
    <div class="col-xs-12">
        @include('flash::message')
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">All Institutions</h3>
                <a href="{{route('tenant.institute.create', $tenant_id)}}" class="btn btn-primary btn-flat pull-right">Add
                    New Institute</a>
            </div>
            <div class="search">

            </div>

            <div class="box-body">
                <table id="institutes" class="table table-bordered table-striped dataTable">
                    <thead>
                    <tr>
                        <th>Institute ID</th>
                        <th>Institute Name</th>
                        <th>Short Name</th>
                        <th>Phone</th>
                        <th>Website</th>
                        <th>Created By</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($institutes as $institute)
                        <tr>
                            <td>{{ format_id($institute->institution_id, 'I') }}</td>
                            <td>{{ $institute->name }}</td>
                            <td>{{ $institute->short_name }}</td>
                            <td>{{ $institute->number }}</td>
                            <td><a href="{{ $institute->website }}" target="_blank">{{ $institute->website }}</a></td>
                            <td>{{ get_tenant_name($institute->added_by) }}</td>
                            <td><a data-toggle="tooltip" title="View Institute" class="btn btn-action-box"
                                   href="{{ route('tenant.institute.show', [$tenant_id, $institute->institution_id]) }}"><i
                                            class="fa fa-eye"></i></a> <a data-toggle="tooltip"
                                                                          title="Institute Documents"
                                                                          class="btn btn-action-box"
                                                                          href="{{ route('tenant.institute.document', [$tenant_id, $institute->institution_id]) }}"><i
                                            class="fa fa-file"></i></a> <a data-toggle="tooltip"
                                                                           title="Edit Institute"
                                                                           class="btn btn-action-box"
                                                                           href="{{ route('tenant.institute.edit', [$tenant_id, $institute->institution_id]) }}"><i
                                            class="fa fa-edit"></i></a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#institutes').DataTable({
                "pageLength": 50,
                order: [[0, 'desc']]
            });
        });
    </script>
@stop
