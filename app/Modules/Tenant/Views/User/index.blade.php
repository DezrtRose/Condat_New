@extends('layouts.tenant')
@section('title', 'All Users')
@section('breadcrumb')
    @parent
    <li><a href="{{url('users')}}" title="All Users"><i class="fa fa-dashboard"></i> Users</a></li>
@stop
@section('content')
    <div class="col-xs-12">
        @include('flash::message')
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Manage Users</h3>
                @if($agency_subscription == 2 || get_total_count('TU') < 10)
                    <a href="{{route('tenant.user.create', $tenant_id)}}" class="btn btn-primary btn-flat pull-right">Add New User</a>
                @endif
            </div>
            <div class="box-body">
                <table id="users" class="table table-bordered table-striped dataTable">
                    <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Full Name</th>
                        <th>Phone No</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ format_id($user->user_id, 'U') }}</td>
                            <td>{{ $user->fullname }}</td>
                            <td>{{ $user->number }}</td>
                            <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                            <td>{{ $user->user_role }}</td>
                            <td>
                                @if($user->status == 0)
                                    <span class="label label-warning">Pending</span>
                                @elseif($user->status == 1)
                                    <span class="label label-success">Activated</span>
                                @elseif($user->status == 2)
                                    <span class="label label-info">Suspended</span>
                                @else
                                    <span class="label label-danger">Trashed</span>
                                @endif
                            </td>
                            <td>
                                <?php
                                $icon = $user->status == 1 ? 'fa-minus-circle' : 'fa-check-circle';
                                $change_status_btn = "";
                                if ($user->role != 3) {
                                    $change_status_btn = ' <a data-toggle="tooltip" title="Change Status" class="btn btn-action-box" href="' . route('tenant.user.changeStatus', [$tenant_id, $user->user_id]) . '"><i class="fa ' . $icon . '"></i></a>';
                                }
                                ?>
                                    <a data-toggle="tooltip" title="Edit User" class="btn btn-action-box" href ="{{ route('tenant.user.edit', [$tenant_id, $user->user_id]) }}"><i class="fa fa-edit"></i></a>{!! $change_status_btn !!}
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
                $('#users').DataTable({
                    "pageLength": 50,
                    order: [[0, 'desc']]
                });
            });
        </script>
@stop
