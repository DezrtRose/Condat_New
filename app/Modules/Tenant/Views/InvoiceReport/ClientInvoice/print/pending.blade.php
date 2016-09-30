<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Condat Solutions | Invoice Reports</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/css/AdminLTE.css') }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body onload="window.print();">
<div class="wrapper">
    <section class="invoice">

        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <i class="fa fa-globe"></i> Condat Solutions
                    <small class="pull-right"><strong>Date:</strong> {{ get_formatted_today_date() }}</small>
                </h2>
            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->

        <!-- Table row -->
        <div class="row">
            <div class="col-xs-12 table-responsive">
                <p class="lead">Client Invoices - Pending</p>
                <table class="table table-striped" id="invoice_report_table">
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
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>
</div>
</body>
</html>
