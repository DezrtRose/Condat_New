@extends('layouts.tenant')
@section('title', 'Client Due Payments')
@section('heading', '<h1>Client - <small>Due Payments</small></h1>')
@section('breadcrumb')
    @parent
    <li><a href="{{url($tenant_id.'/clients')}}" title="All Clients"><i class="fa fa-users"></i> Clients</a></li>
    <li>Due Payment</li>
@stop

@section('content')
    <div class="col-md-12">

        @include('flash::message')
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Due Payments</h3>
            </div>
            <div class="box-body">
                <table class="table table-striped table-bordered table-condensed" id="due_table">
                    <thead>
                    <tr class="text-nowrap">
                        <th>Client ID</th>
                        <th>Client Name</th>
                        <th>Due Payment</th>
                        <th>Phone Number</th>
                        <th>Email</th>
                        <th>Processing</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($due_payments as $key => $payment)
                        <tr>
                            <td>{{ format_id($key, 'C') }}</td>
                            <td>{{ $payment['client_name']}}</td>
                            <td>{{ format_price($payment['outstanding_amount']) }}</td>
                            <td>{{ $payment['number']}}</td>
                            <td>{{ $payment['email']}}</td>
                            <td>
                                <a data-toggle="tooltip" title="View Client" class="btn btn-action-box"
                                   href="{{ route('tenant.client.show', [$tenant_id, $key]) }}"><i
                                            class="fa fa-eye"></i></a>
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
            $('#due_table').DataTable({
                "pageLength": 50,
                order: [[0, 'desc']]
            });
        });
    </script>
@stop