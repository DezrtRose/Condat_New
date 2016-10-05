@extends('layouts.tenant')
@section('title', 'Application Enquiry')
@section('heading', 'Client Invoices - <small>Paid Invoices</small>')
@section('breadcrumb')
    @parent
    <li><a href="{{url('tenant/clients')}}" title="All Clients"><i class="fa fa-users"></i> Clients</a></li>
    <li>Paid Invoices</li>
@stop

@section('content')
    <div class="col-md-12">

        @include('Tenant::InvoiceReport/ClientInvoice/partial/navbar')
        @include('flash::message')

        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Paid Invoices</h3>
                <a href="{{ route('client.invoice.print.paid') }}" target="_blank"
                   class="btn btn-primary pull-right">
                    <i class="fa fa-print"></i> Print
                </a>
                <a href="{{ route('client.invoice.pdf.paid') }}" target="_blank"
                   class="btn btn-primary pull-right"
                   style="margin-right: 5px;">
                    <i class="fa fa-download"></i> Generate PDF
                </a>
                <a href="{{ route('client.invoice.export.paid') }}" target="_blank"
                   class="btn btn-primary pull-right"
                   style="margin-right: 5px;">
                    <i class="fa fa-file-excel-o"></i> Export Excel
                </a>
            </div>
            <div class="box-body">
                <section>
                    <table class="table table-striped table-bordered table-condensed"
                           id="invoice_report_table">
                        <thead>
                        <tr class="text-nowrap">
                            <th>Invoice Id</th>
                            <th>Date</th>
                            <th>Client Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Invoice Amount</th>
                            <th>Total gst</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($invoice_reports as $invoice)
                            <tr>
                                <td>{{ $invoice->invoice_id }}</td>
                                <td>{{ $invoice->invoice_date }}</td>
                                <td>{{ $invoice->fullname }}</td>
                                <td>{{ $invoice->number }}</td>
                                <td>{{ $invoice->email }}</td>
                                <td>{{ $invoice->invoice_amount }}</td>
                                <td>{{ $invoice->total_gst }}</td>
                                <td>
                                    <a data-toggle="modal" data-target="#condat-modal"
                                       data-url="{{url('tenant/invoices/' . $invoice->invoice_id . '/payment/add/2')}}"><i
                                                class=" btn btn-primary btn-sm glyphicon glyphicon-shopping-cart"
                                                data-toggle="tooltip" data-placement="top"
                                                title="Add Payment"></i></a>
                                    <a href="{{route('tenant.student.invoice', $invoice->student_invoice_id)}}"
                                       title="Print Invoice"><i
                                                class="processing btn btn-primary btn-sm glyphicon glyphicon-print"
                                                data-toggle="tooltip" data-placement="top"
                                                title="Print Invoice"></i></a>
                                    <a href="{{route("tenant.invoice.payments", [$invoice->invoice_id, 2])}}"
                                       title="View Invoice"><i
                                                class="processing btn btn-primary btn-sm glyphicon glyphicon-eye-open"
                                                data-toggle="tooltip" data-placement="top"
                                                title="View Invoice"></i></a>
                                    <a href="#" title="Email Invoice"><i
                                                class="processing btn btn-primary btn-sm glyphicon glyphicon-send"
                                                data-toggle="tooltip" data-placement="top"
                                                title="Email Invoice"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </section>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#invoice_report_table').DataTable({
                "pageLength": 50
            });
        });
    </script>
    {!! Condat::registerModal() !!}
@stop
                      

                      
                            
                

      

              


              
        
