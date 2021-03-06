@extends('layouts.tenant')
@section('title', 'Client View')
@section('breadcrumb')
    @parent
    <li><a href="{{url('tenant/client')}}" title="All Clients"><i class="fa fa-users"></i> Clients</a></li>
    <li>View</li>
@stop
@section('content')
    @include('Tenant::Client/Application/navbar')
    <br/>
    <div class="col-xs-3">
        <?php if($type == 1) $route_type = 'college'; elseif($type == 2) $route_type = 'student'; else $route_type = 'subagents'; ?>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Invoice Details</h3>
                    <a href="{{ $invoice->edit_link }}" class="btn btn-success pull-right btn-sm"><i class="fa fa-pencil"></i></a>
                </div>
                <!-- Recent Payments -->
                <div class="box-body">

                    <strong><i class="fa fa-file-text-o margin-r-5"></i> Invoice Id</strong>

                    <p class="text-muted">{{ $invoice->formatted_id }}</p>

                    <strong><i class="fa fa-file-text-o margin-r-5"></i> Invoice Date </strong>

                    <p class="text-muted">{{ format_date($invoice->invoice_date) }}</p>

                    <strong><i class="fa fa-file-text-o margin-r-5"></i> Application ID </strong>

                    <p class="text-muted">{{ ($invoice->application_id != null)? format_id($invoice->application_id, 'A') : 'No Application' }}</p>

                    <strong><i class="fa fa-file-text-o margin-r-5"></i> Total Amount</strong>

                    <p class="text-muted">${{float_format($invoice->total_amount)}}</p>

                    <strong><i class="fa fa-file-text-o margin-r-5"></i> Total GST </strong>

                    <p class="text-muted">${{float_format($invoice->total_gst)}}</p>

                    <strong><i class="fa fa-file-text-o margin-r-5"></i> Final Total </strong>

                    <p class="text-muted">${{float_format($invoice->final_total)}}</p>

                    <strong><i class="fa fa-file-text-o margin-r-5"></i> Total Paid </strong>

                    <p class="text-muted">${{float_format($invoice->paid)}}</p>

                    <strong><i class="fa fa-file-text-o margin-r-5"></i> Status </strong>

                    <p class="text-muted">{{ $invoice->status }}</p>

                    <strong><i class="fa fa-file-text-o margin-r-5"></i> Outstanding Amount </strong>

                    <p class="text-muted">${{float_format($invoice->outstanding)}}</p>

                </div>
            </div>

    </div>
    <div class="col-xs-9">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Invoice Payments</h3>

                <a href="{{route('tenant.'.$route_type.'.invoice', [$tenant_id, $invoice->invoice_id])}}"
                   class="btn btn-primary btn-flat pull-right" target="_blank"><i class="fa fa-print"></i> Print Invoice </a>
                <a href="#" class="btn btn-success btn-flat pull-right marginRight" data-toggle="modal" data-target="#condat-modal" data-url="{{ $invoice->payment_link }}"><i class="fa fa-money"></i> Add Payment </a>&nbsp;&nbsp;
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
                        {{--<th></th>--}}
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            oTable = $('#payments').DataTable({
                "processing": true,
                "serverSide": true,

                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": true,

                "ajax": appUrl + "/invoices/payments/" + <?php echo $invoice_id ?> + "/" + <?php echo $type ?> + "/data",
                "columns": [
                    {data: 'payment_id', name: 'payment_id'},
                    {data: 'date_paid', name: 'date_paid'},
                    {data: 'amount', name: 'amount'},
                    {data: 'payment_method', name: 'payment_method'},
                    {data: 'payment_type', name: 'payment_type'},
                    {data: 'description', name: 'description', orderable: false, searchable: false},
                    /*{data: 'action', name: 'action', orderable: false, searchable: false}*/
                ],
                order: [[0, 'desc']]
            });
        });
    </script>

    {!! Condat::registerModal() !!}
@stop