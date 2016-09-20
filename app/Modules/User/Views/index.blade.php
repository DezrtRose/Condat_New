@extends('layouts.main')
@section('title', 'All Users')
@section('heading', 'All Users')
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
                <a href="{{route('user.create')}}" class="btn btn-primary btn-flat pull-right">Add New User</a>
            </div>
            <div class="box-body">
                <table id="users" class="table table-bordered table-striped dataTable">
                    <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Username</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>User Role</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <script type="text/javascript">
            $(document).ready(function () {
                oTable = $('#users').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": appUrl + "/users/data",
                    "columns": [
                        {data: 'id', name: 'id'},
                        {data: 'username', name: 'username'},
                        {data: 'fullname', name: 'fullname'},
                        {data: 'email', name: 'email'},
                        {data: 'role', name: 'role'},
                        {data: 'status', name: 'status'},
                        {data: 'action', name: 'action', orderable: false, searchable: false}
                    ]
                });
            });
        </script>
@stop
