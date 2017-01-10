@extends('layouts.min')
@section('title', 'Login')
@section('content')
    <!-- Datatable css -->
    <link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css"/>

    <div class="login-box" style="width: 800px">
        <div class="login-logo">
            <a href="">Consultancy Database</a>
        </div>

        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Find a link for your company to Log in.</p>

            <table class="table" id="agencies">
                <thead>
                <tr>
                    <th>Company Name</th>
                    <th>Link</th>
                </tr>
                </thead>
                @foreach($agencies as $key => $agency)
                    <tr>
                        <td>{{ $agency->name }}</td>
                        <td><a href="{{ route('tenant.login', $agency->agency_id) }}">{{ route('tenant.login', $agency->agency_id) }}</a></td>
                    </tr>
                @endforeach
            </table>
        </div>
        <div class="login-box-footer">
            <p class="text-center">
                <small>&copy; copyright {{date('Y')}} | Condat</small>
            </p>
        </div>
    </div>

    <!-- Datatable JS -->
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>

    <script type="text/javascript">
        $("#agencies").DataTable();
    </script>
@stop
