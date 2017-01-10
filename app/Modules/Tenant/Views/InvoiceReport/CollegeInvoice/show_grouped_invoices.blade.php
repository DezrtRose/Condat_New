@extends('layouts.tenant')
@section('title', 'Group Invoices')
@section('heading', '<h1>Group Invoice - <small>Details</small></h1>')
@section('breadcrumb')
    @parent
    <li><a href="{{url($tenant_id.'/college_invoice_report/invoice_grouped')}}" title="All Group Invoices"><i
                    class="fa fa-users"></i> Group Invoices</a></li>
    <li>View</li>
@stop
@section('content')
    <div class="col-md-12">
        @include('Tenant::InvoiceReport/GroupInvoice/navbar')
        @include('flash::message')
    </div>
    <div class="col-md-3 col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Invoice Details</h3>
            </div>

            <!-- Recent Payments -->
            <div class="box-body">

                <strong><i class="fa fa-file-text-o margin-r-5"></i> Invoice Id</strong>

                <p class="text-muted">{{ format_id($invoice_details->group_invoice_id, "GI") }}</p>

                <strong><i class="fa fa-file-text-o margin-r-5"></i> Invoice Date </strong>

                <p class="text-muted">{{ format_date($invoice_details->date) }}</p>

                <strong><i class="fa fa-file-text-o margin-r-5"></i> Invoice To </strong>

                <p class="text-muted">{{ $invoice_details->description }}</p>

                <strong><i class="fa fa-file-text-o margin-r-5"></i> Total Amount </strong>

                <p class="text-muted">{{ format_price($invoice_details->total_amount) }}</p>

                <strong><i class="fa fa-file-text-o margin-r-5"></i> Total GST </strong>

                <p class="text-muted">{{ format_price($invoice_details->total_gst) }}</p>

                <strong><i class="fa fa-file-text-o margin-r-5"></i> Paid Amount </strong>

                <p class="text-muted">{{ format_price($invoice_details->paid_amount) }}</p>

                <strong><i class="fa fa-file-text-o margin-r-5"></i> Due Amount </strong>

                <p class="text-muted">{{ format_price($invoice_details->outstanding_amount) }}</p>

                <strong><i class="fa fa-file-text-o margin-r-5"></i> Description </strong>

                <p class="text-muted">{{ $invoice_details->description }}</p>

            </div>
        </div>
    </div>

    <div class="col-md-9 col-sm-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Invoices List</h3>
            </div>
            <div class="box-body table-responsive">
                <div class="well well-sm">
                    {!! Form::open(['route'=>['group.invoice.addmore', $tenant_id, $invoice_details->group_invoice_id], 'method' => 'post', 'class' => "form-horizontal"]) !!}
                        <div class="form-group">
                            <label for="invoice_ids" class="col-sm-22 col-md-3 control-label">Add More Invoices</label>

                            <div class="col-sm-12 col-md-5">
                                {!!Form::select('invoice_ids[]', $invoice_ids, null, array('class' => 'form-control select2', 'multiple' => 'multiple', 'palceholder' => 'Invoice Id'))!!}
                            </div>
                            <div class="col-sm-12 col-md-2">
                                <button type="submit" class="btn btn-primary btn-flat pull-right">Add Invoices</button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
                <table class="table table-striped table-bordered table-condensed" id="invoice_report_table">
                    <thead>
                    <tr class="text-nowrap">
                        {!! (isset($is_group) && $is_group == true)? '<th>Select</th>' : '' !!}
                        <th>Invoice Id</th>
                        <th>Date</th>
                        <th>Client Name</th>
                        <th>Institute Name</th>
                        <th>Total Amount</th>
                        <th>Total GST</th>
                        <th>Outstanding</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($invoice_reports as $invoice)
                        <tr>
                            {!! (isset($is_group) && $is_group == true)? '<td><input type = "checkbox" class = "icheck group-ids" name = "group" value = "'.$invoice->invoice_id.'" /></td>' : '' !!}
                            <td>{{ format_id($invoice->invoice_id, 'CI') }}</td>
                            <td>{{ format_date($invoice->invoice_date) }}</td>
                            <td>{{ $invoice->fullname }}</td>
                            <td>{{ $invoice->institute_name }}</td>
                            <td>{{ format_price($invoice->total_commission) }}</td>
                            <td>{{ format_price($invoice->total_gst) }}</td>

                            <td>
                                @if(($invoice->total_commission) - ($invoice->total_paid) == 0)
                                    {{ '-' }}
                                @else
                                    {{ format_price(($invoice->total_commission) - ($invoice->total_paid)) }}
                                @endif
                            </td>
                            <td>
                                <a data-toggle="modal" data-target="#condat-modal" data-url="{{ url($tenant_id.'/invoices/' . $invoice->college_invoice_id . '/payment/add/1') }}" title="Add Payment"><i
                                            class=" btn btn-primary btn-sm glyphicon glyphicon-shopping-cart"
                                            data-toggle="tooltip" data-placement="top" title="Add Payment"></i></a>
                                <a href="{{ route('tenant.college.invoice', [$tenant_id, $invoice->college_invoice_id]) }}" target="_blank" title="Print Invoice"><i
                                            class="processing btn btn-primary btn-sm glyphicon glyphicon-print"
                                            data-toggle="tooltip" data-placement="top"
                                            title="Print Invoice"></i></a>
                                <a href="{{ route("tenant.invoice.payments", [$tenant_id, $invoice->college_invoice_id, 1]) }}" title="View Invoice"><i
                                            class="processing btn btn-primary btn-sm glyphicon glyphicon-eye-open"
                                            data-toggle="tooltip" data-placement="top" title="View Invoice"></i></a>
                                <a href="#" title="Remove From Group" id="{{ $invoice->invoice_id }}" class="remove"><i
                                            class="btn btn-primary btn-sm glyphicon glyphicon-remove-sign"
                                            data-toggle="tooltip" data-placement="top"
                                            title="Remove From Group"></i></a>
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
            $('#invoice_report_table').DataTable({
                "pageLength": 50,
                order: [[0, 'desc']]
            });

            $(document).on('click', '.remove', function (event) {
                event.preventDefault();
                if (!confirm('Are you sure you want to remove the invoice from the group?')) {
                    return false;
                }
                var parentTr = $(this).parent().parent();
                var invoiceId = $(this).attr('id');
                $.ajax({
                    url: appUrl + "/group/{{$invoice_details->group_invoice_id}}" + "/invoice/" + invoiceId,
                    success: function (result) {
                        parentTr.slideUp('slow');
                        $('.content .box-primary').before(notify('success', 'Invoice Removed Successfully!'));
                        setTimeout(function () {
                            $('.callout').remove()
                        }, 2500);
                    }
                });
            });
        });

        function notify(type, text) {
            return '<div class="callout callout-' + type + '"><p>' + text + '</p></div>';
        }
    </script>

    {!! Condat::registerModal() !!}
@stop