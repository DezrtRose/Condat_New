<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/css/AdminLTE.css') }}">
</head>
<body>
<div class="wrapper">
    <div>
        <h2 class="page-header">
            Condat Solutions - Client Invoices
            <small class="pull-right"><strong>Date:</strong> {{ get_formatted_today_date() }}</small>
            <br/>
        </h2>
    </div>
    <div>
        <table class="table table-striped" id="invoice_report_table">
            <thead>
            <tr>
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
                <tr>
                    <td>{{ format_id($invoice->invoice_id, 'SI') }}</td>
                    <td>{{ format_date($invoice->invoice_date) }}</td>
                    <td>{{ $invoice->fullname }}</td>
                    <td>{{ $invoice->number }}</td>
                    <td>{{ $invoice->email }}</td>
                    <td>{{ format_price($invoice->invoice_amount) }}</td>
                    <td>{{ format_price($invoice->total_gst) }}</td>

                    <td>
                        @if(($invoice->final_total) - ($invoice->total_paid) == 0)
                            {{ '-' }}
                        @else
                            {{ format_price(($invoice->final_total) - ($invoice->total_paid)) }}
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
