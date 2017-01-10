@extends('layouts.tenant')
@section('title', 'College Invoice Grouped')
@section('heading', '<h1>College Invoice - <small>Grouped</small></h1>')
@section('breadcrumb')
    @parent
    <li><a href="{{url($tenant_id.'/college_invoice_report/invoice_pending')}}" title="All College Invoices"><i
                    class="fa fa-users"></i> College Invoices</a></li>
    <li>Group Invoices</li>
@stop

@section('content')
    <div class="col-md-12">
        @include('Tenant::InvoiceReport/GroupInvoice/navbar')
        @include('flash::message')
    </div>

    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Group Invoices</h3>
            </div>
            <div class="box-body">
                <table class="table table-striped table-bordered table-condensed" id="invoice_report_table">
                    <thead>
                    <tr class="text-nowrap">
                        <th>Group Invoice Id</th>
                        <th>Date</th>
                        <th>Invoice To</th>
                        <th>Number of Invoices</th>
                        <th>Sub Total</th>
                        <th>GST</th>
                        <th>Outstanding Amount</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($invoice_reports as $invoice)
                        <tr>
                            <td>{{ format_id($invoice->group_invoice_id, 'GI') }}</td>
                            <td>{{ format_date($invoice->date) }}</td>
                            <td>{{ $invoice->description }}</td>
                            <td>{{ $invoice->invoiceCount }}</td>
                            <td>{{ format_price($invoice->total_amount - $invoice->total_gst) }}</td>
                            <td>{{ format_price($invoice->total_gst) }}</td>
                            <td>{{ format_price($invoice->outstanding_amount) }}</td>
                            <td>
                                <a href="{{ route('invoice.grouped.show', [$tenant_id, $invoice->group_invoice_id]) }}" title="View Invoice"><i
                                            class="processing btn btn-primary btn-sm glyphicon glyphicon-eye-open"
                                            data-toggle="tooltip" data-placement="top" title="View Invoice"></i></a>
                                <a href="#" target="_blank" title="Clear Invoice" data-toggle="modal" data-target="#clear-modal{{$invoice->group_invoice_id}}"><i
                                            class="processing btn btn-primary btn-sm glyphicon glyphicon-usd"
                                            data-toggle="tooltip" data-placement="top"
                                            title="Clear Payment"></i></a>
                                <a href="{{ route('invoice.grouped.print', [$tenant_id, $invoice->group_invoice_id]) }}" target="_blank" title="Print Invoice"><i
                                            class="processing btn btn-primary btn-sm glyphicon glyphicon-print"
                                            data-toggle="tooltip" data-placement="top"
                                            title="Print Invoice"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @foreach($invoice_reports as $invoice)
    <div class="modal fade modal" id="clear-modal{{$invoice->group_invoice_id}}" tabindex="-1" role="dialog" aria-labelledby="clear-modal{{$invoice->group_invoice_id}}">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Payment Details</h4>
                </div>
                {!!Form::open(['route' => ['invoice.grouped.clear', $tenant_id, $invoice->group_invoice_id], 'method'=> 'post', 'class' => 'form-horizontal'])!!}
                <div class="modal-body">
                    <div class="form-group">
                        {!!Form::label('date_paid', 'Payment Date *', array('class' => 'col-md-4 control-label')) !!}
                        <div class="col-md-8">
                            <div class="input-group date" id="date_paid">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                {!!Form::text('date_paid', null, array('class' => 'form-control date_paid_picker'))!!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {!!Form::label('payment_method', 'Payment Method *', array('class' => 'col-sm-4 control-label')) !!}
                        <div class="col-sm-8">
                            {!!Form::text('payment_method', null, array('class' => 'form-control', 'id'=>'payment_method'))!!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!!Form::label('payment_type', 'Payment Type *', array('class' => 'col-sm-4 control-label')) !!}
                        <div class="col-sm-8">
                            {!!Form::select('payment_type', ['College to Agent' => 'College to Agent', 'Pre Claimed Commission' => 'Pre Claimed Commission'], null, array('class' => 'form-control', 'id'=>'payment_type'))!!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!!Form::label('description', 'Description', array('class' => 'col-sm-4 control-label')) !!}
                        <div class="col-sm-8">
                            {!!Form::textarea('description', null, array('class' => 'form-control', 'id'=>'description'))!!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i>
                        Save
                    </button>
                </div>
                {!!Form::close()!!}
            </div>
        </div>

    </div>
    @endforeach

    <script type="text/javascript">
        $(document).ready(function () {
            $('#invoice_report_table').DataTable({
                "pageLength": 50,
                order: [[0, 'desc']]
            });

            $(".date_paid_picker").datepicker({
                autoclose: true,
                format: 'dd/mm/yyyy'
            });
        });
    </script>
@stop