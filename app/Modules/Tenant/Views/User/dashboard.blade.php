@extends('layouts.tenant')
@section('title', 'Dashboard')

@section('content')
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Recent Activity</h3>
            </div>
            <div class="box-body">
                <div class="inbox-widget slimscroll">
                    @include('Tenant::Client/Show/timeline')
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Application List</h3>
            </div>
            <div class="box-body"> <?php //dd($app_stat) ?>
                <div id="chart">
                    <ul id="numbers">
                        <li><span>&nbsp;</span></li>
                        <li><span>28</span></li>
                        <li><span>24</span></li>
                        <li><span>20</span></li>
                        <li><span>16</span></li>
                        <li><span>12</span></li>
                        <li><span>8</span></li>
                        <li><span>4</span></li>
                        <li><span>0</span></li>
                    </ul>
                    <ul id="bars">
                        @foreach($app_stat as $key => $stat)
                            <li>
                                <div data-applications="{{ $stat->total }}" class="bar"></div>
                                <span>{{ $stat->name }}</span></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <br>
        </div>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Outstanding Payments</h3>
            </div>
            <div class="box-body">
                @if(!empty($outstanding_payments))
                    <table id="clients" class="table table-bordered table-striped dataTable">
                        <thead>
                        <tr>
                            <th>Client Name</th>
                            <th>Outstanding Amount</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($outstanding_payments as $client_id => $outstanding_payment)
                            <tr>
                                <td>{{ $outstanding_payment['client_name'] }}</td>
                                <td>{{ format_price($outstanding_payment['outstanding_amount']) }}</td>
                                <td>
                                    <a data-toggle="tooltip" title="View Client Account" class="btn btn-action-box"
                                       href="{{ route('tenant.client.show', [$tenant_id, $client_id]) }}"><i
                                                class="fa fa-eye"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-muted well">
                        No outstanding payment.
                    </p>
                @endif
            </div>
        </div>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Active Clients</h3>

                <div class="box-tools pull-right">
                    <a class="btn btn-primary" href="{{ route('tenant.client.create', $tenant_id)}}"><i
                                class="fa fa-plus"></i> Add Client</a>
                </div>
            </div>
            <div class="box-body">
                @if(!empty($active_clients))
                <table id="clients" class="table table-bordered table-striped dataTable">
                    <thead>
                    <tr>
                        <th>Client Name</th>
                        <th>Phone No</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <?php
                    foreach ($active_clients as $key => $value) {
                    ?>
                    <tr>
                        <td>{{ $value->first_name }} {{ $value->middle_name }} {{ $value->last_name }} </td>
                        <td>{{ $value->number }}</td>
                        <td>{{ $value->email }}</td>

                        <td>
                            <div class="box-tools pull-left">
                                <a class="btn btn-primary btn-sm"
                                   href="{{ route('tenant.client.show',[$tenant_id, $value->client_id])}}" data-toggle="tooltip"
                                   data-placement="top" title="View"><i class="fa fa-eye"></i></a>
                                <a class="btn btn-primary btn-sm inactive" id="{{$value->client_id}}"
                                   data-toggle="tooltip" data-placement="top" title="Make Inactive"><i
                                            class="fa fa-remove"></i></a>
                            </div>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                </table>
                @else
                    <p class="text-muted well">
                        No active clients.
                    </p>
                @endif
            </div>
        </div>
    </div>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/local/public/css/chart.css') }}"/>

    <script src="{{ URL::asset('/local/public/js/chart.js') }}"></script>
    <script type="text/javascript">

        /* Make clients inactive */
        $(document).on('click', '.inactive', function (event) {
            var clientId = $(this).attr('id');
            var parentTr = $(this).closest('tr');
            $.ajax({
                url: appUrl + "/tenant/clients/" + clientId + "/inactive",
                success: function (result) {
                    $('.content .box-primary').first().before(notify('success', 'Client Made Inactive Successfully!'));
                    setTimeout(function () {
                        $('.callout').remove()
                    }, 2500);

                    parentTr.slideUp("slow", function () {
                        $(this).remove();
                    });
                }
            });
        });

        function notify(type, text) {
            return '<div class="callout callout-' + type + '"><p>' + text + '</p></div>';
        }
    </script>


@stop
