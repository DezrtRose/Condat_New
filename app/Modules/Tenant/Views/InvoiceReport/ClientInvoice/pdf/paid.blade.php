@extends('layouts.tenant')
@section('heading', 'Client Invoices - <small>Pending Invoices</small>')
@section('content')
    <div class="col-md-12">
        <section class="invoice">
            <!-- title row -->
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="page-header">
                        <i class="fa fa-globe"></i> AdminLTE, Inc.
                        <small class="pull-right">Date: {{ get_formatted_today_date() }}</small>
                    </h2>
                </div>
                <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                    From
                    <address>
                        <strong>Admin, Inc.</strong><br>
                        795 Folsom Ave, Suite 600<br>
                        San Francisco, CA 94107<br>
                        Phone: (804) 123-5432<br>
                        Email: info@almasaeedstudio.com
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    To
                    <address>
                        <strong>John Doe</strong><br>
                        795 Folsom Ave, Suite 600<br>
                        San Francisco, CA 94107<br>
                        Phone: (555) 539-1037<br>
                        Email: john.doe@example.com
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    <b>Invoice #007612</b><br>
                    <br>
                    <b>Order ID:</b> 4F3S8J<br>
                    <b>Payment Due:</b> 2/22/2014<br>
                    <b>Account:</b> 968-34567
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
                <div class="col-xs-12 table-responsive">
                    <table class="table table-striped table-bordered table-condensed" id="invoice_report_table">
                        <thead>
                        <tr class="text-nowrap">
                            <th>Invoice Id</th>
                            <th>Date</th>
                            <th>Client Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Invoice Amount</th>
                            <th>Total gst</th>
                            <th>Outstanding</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($invoice_reports as $invoice)

                            @if(($invoice->invoice_date) <= $date and ($invoice->final_total - $invoice->total_paid) <= 0)
                                <tr>
                                    <td>{{ $invoice->invoice_id }}</td>
                                    <td>{{ $invoice->invoice_date }}</td>
                                    <td>{{ $invoice->fullname }}</td>
                                    <td>{{ $invoice->number }}</td>
                                    <td>{{ $invoice->email }}</td>
                                    <td>{{ $invoice->invoice_amount }}</td>
                                    <td>{{ $invoice->total_gst }}</td>

                                    <td>
                                        @if(($invoice->final_total) - ($invoice->total_paid) == 0)
                                            {{ '-' }}
                                        @else
                                            {{ (($invoice->final_total) - ($invoice->total_paid)) }}
                                        @endif
                                    </td>
                                </tr>
                            @else
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

        </section>

    </div>
@stop