@extends('layouts.tenant')
@section('title', 'Client View')
@section('breadcrumb')
    @parent
    <li><a href="{{url('tenant/client')}}" title="All Clients"><i class="fa fa-users"></i> Clients</a></li>
    <li>View</li>
@stop
@section('content')

    @include('Tenant::Client/Application/navbar')

    <div class="col-xs-12">
    <br/>
        @if($application->sub_agent_id != 0 && $application->sub_agent_id != null)
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Recent Payments</h3>
                <a href="{{ route('application.subagents.payment', [$tenant_id, $application->application_id]) }}"
                   class="btn btn-success btn-flat pull-right"><i class="glyphicon glyphicon-plus-sign"></i> Add
                    Payments</a>
            </div>
            <div class="box-body">
                <table id="payments" class="table table-bordered table-striped dataTable">
                    <thead>
                    <tr>
                        <th>Payment ID</th>
                        <th>Payment Date</th>
                        <th>Amount</th>
                        <th>Paid By</th>
                        <th>Payment Type</th>
                        <th>Description</th>
                        {{--<th>Invoice</th>--}}
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($payments as $key => $payment)
                    <tr>
                        <td>{{ format_id($payment->subagent_payments_id, 'SAP') }}</td>
                        <td>{{ format_date($payment->date_paid) }}</td>
                        <td>{{ format_price($payment->amount) }}</td>
                        <td>{{ $payment->payment_method }}</td>
                        <td>{{ $payment->payment_type }}</td>
                        <td>{{ $payment->description }}</td>
                        {{--<td>
                            @if(empty($payment->invoice_id) || $payment->invoice_id == 0)
                                Uninvoiced <a class="btn btn-success btn-xs" data-toggle="modal" data-target="#condat-modal" data-url="{{url($tenant_id.'/payment/'.$payment->client_payment_id.'/'.$payment->course_application_id.'/assign')}}"><i class="glyphicon glyphicon-plus-sign"></i> Assign to Invoice</a>
                            @else
                                {{format_id($payment->invoice_id, 'I')}}
                            @endif
                        </td>--}}
                        {{--<td>
                            <a class="btn btn-success btn-xs" data-toggle="modal" data-target="#condat-modal" data-url="{{route('subagents.invoice.upload', [$tenant_id, $payment->client_payment_id])}}"><i class="fa fa-upload"></i> Upload Invoice</a>
                        </td>--}}
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-primary" type="button">Action</button>
                                <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul role="menu" class="dropdown-menu">
                                    <li><a target="_blank" href="{{route('tenant.subagent.payments.receipt', [$tenant_id, $payment->subagent_payments_id])}}">Print Receipt</a></li>
                                    <li><a href="{{route("application.subagents.editPayment", [$tenant_id, $payment->subagent_payments_id])}}">Edit</a></li>
                                    <li><a href="{{route('application.subagent.deletePayment', [$tenant_id, $payment->client_payment_id])}}" onclick="return confirm('Are you sure you want to delete the record?')">Delete</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
            <div class="callout callout-warning">
                <h4>Sub Agent Not Assigned!</h4>

                <p>Sub Agent for the application is not assigned. Please visit the application <a href="{{ route('tenant.application.show', [$tenant_id, $application->application_id]) }}">dashboard</a> to add sub-agent and process further.</p>
            </div>
        @endif
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            oTable = $('#payments').DataTable({
                "pageLength": 50,
                order: [[0, 'desc']]
            });
        });
    </script>

    {!! Condat::registerModal() !!}
@stop