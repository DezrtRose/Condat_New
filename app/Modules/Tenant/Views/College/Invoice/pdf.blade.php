<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>College Invoice</title>
    {{--<link type="text/css" media="all" rel="stylesheet" href="https://v4-alpha.getbootstrap.com/dist/css/bootstrap.min.css">--}}
    <link type="text/css" media="all" rel="stylesheet"
          href="https://almsaeedstudio.com/themes/AdminLTE/dist/css/AdminLTE.min.css">

    <style type="text/css">
        body {
            background-color: #fff;
            color: #333;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 12px;
            line-height: 1.42857;
        }

        .row {
            margin-right: -15px;
            margin-left: -15px;
        }

        .no-border {
            border: 0;
        }

        .pull-right {
            float: right;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .panel-default {
            border-color: #ddd;
        }

        .panel {
            background-color: #fff;
            border: 1px solid transparent;
            border-radius: 4px;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .panel-default > .panel-heading {
            color: #333;
            background-color: #f5f5f5;
            border-color: #ddd;
        }

        .panel-heading {
            padding: 10px 15px;
            border-bottom: 1px solid transparent;
            border-top-left-radius: 3px;
            border-top-right-radius: 3px;
        }

        .panel-body {
            padding: 15px;
        }

        .panel-body::after, .row::after, .col-12::after {
            clear: both;
        }

        .clearfix {
            clear: both;
        }

        .col-12 {
            width: 100%;
        }

        .col-6 {
            width: 50%;
        }

        .table {
            margin-bottom: 20px;
            max-width: 100%;
            width: 100%;
            border-collapse: collapse;
            padding: 8px;
        }

        .tab-bordered {
            border: 1px solid #b6b6b6;
        }

        .tab-bordered > tbody > tr > td, .tab-bordered > tbody > tr > th, .tab-bordered > tfoot > tr > td, .tab-bordered > tfoot > tr > th, .tab-bordered > thead > tr > td, .tab-bordered > thead > tr > th {
            border: 1px solid #b6b6b6;
        }

        .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
            border-top: 1px solid #ddd;
            line-height: 1.42857;
            padding: 8px;
            vertical-align: top;
        }

        .col-offset-6 {
            margin-left: 50%;
        }

        .bordered {
            border: 1px solid #b6b6b6;
            border-radius: 4px;
        }

        .color-dim {
            color: #777;
        }

        .big {
            font-size: 16px;
        }

    </style>
</head>
<body>
<div class="container">
    <section class="invoice">
        <table class="no-border col-12">
            <tr class="invoice-info">
                <td class="invoice-col">
                    <img src="{{ (isset($company['logo_path']) && !empty($company['logo_path']))? $company['logo_path'] : '' }}"
                         height="100px" style="max-width: 250px">
                </td>
                <td class="invoice-col text-right pull-right">
                    <h2 class="page-header">
                        TAX INVOICE
                    </h2>
                </td>
            </tr>
        </table>
        <!-- info row -->
        <div class="row col-12">
            <table class="table no-border">
                <tr class="invoice-info">
                    <td class="invoice-col" style="width:35%;">
                        <div class="panel panel-default bordered">
                            <div class="panel-heading">
                                <strong>{{ $company['company_name'] or ''}}</strong>
                            </div>
                            <div class="panel-body">
                                {{ $company['abn'] or '' }}<br/>

                                <div class="color-dim">
                                    {{ $company['street'] or '' }}<br/>
                                    {{ $company['suburb'] or '' }} {{ $company['state'] or '' }} {{ $company['postcode'] or '' }}
                                    <br/>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="invoice-col text-right pull-right" style="width:35%;">
                        <div class="panel panel-default bordered">
                            <div class="panel-heading">
                                <strong>Invoice To</strong>
                            </div>
                            <div class="panel-body">
                                {{ $invoice_to }}<br/>

                                <div class="color-dim">
                                    <strong>Invoice</strong> #{{ format_id($invoice->invoice_id, 'CI') }}<br/>
                                    <strong>Date</strong> {{ format_date($invoice->invoice_date) }}
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Table row -->
        <div class="row">
            <div class="col-12">

                <table class="table tab-bordered">
                    <thead>
                    <tr>
                        <th class="text-left">Student Name</th>
                        <th class="text-left">Description</th>
                        <th class="text-right">Amount</th>
                        <th class="text-right">GST</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($invoice->commission_amount || $invoice->commission_gst)
                        <tr>
                            <td>{{ $client_name }}</td>
                            <td>{{ $invoice->description }}</td>
                            <td class="text-right">{{ format_price($invoice->commission_amount) }}</td>
                            <td class="text-right">{{ format_price($invoice->commission_gst) }}</td>
                        </tr>
                    @endif
                    @if($invoice->incentive || $invoice->incentive_gst)
                        <tr>
                            <td>{{ $client_name }}</td>
                            <td>{{ $invoice->other_description }}</td>
                            <td class="text-right">{{ format_price($invoice->incentive) }}</td>
                            <td class="text-right">{{ format_price($invoice->incentive_gst) }}</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row col-12" style="padding: 8px;">
            <div class="col-offset-6 col-6 bordered text-right">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <p>Sub Total:
                            <small>${{ float_format($invoice->total_commission) }}</small>
                        </p>
                        <p>GST:
                            <small>${{ float_format($invoice->total_gst) }}</small>
                        </p>
                        <div class="big"><strong>Total Amount:</strong>
                            <small>${{ float_format($invoice->final_total) }}</small>
                        </div>
                        <p>Less Paid Amount:
                            <small>${{ float_format($pay_details->paid) }}</small>
                        </p>
                        <div class="big"><strong>Amount Due:</strong>
                            <small>${{ float_format($pay_details->outstandingAmount) }}</small>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="row col-12">
            <!-- info row -->
            <table class="table no-border">
                <tr class="invoice-info">
                    <td class="invoice-col" style="width:35%;">
                        <div class="panel panel-default bordered">
                            <div class="panel-heading">
                                <strong>Bank details</strong>
                            </div>
                            <div class="panel-body">
                                {{ $bank['account_name'] or '' }}<br/>
                                <strong>BSB</strong> : {{ $bank['bsb'] or '' }} | <strong>Account Number</strong>
                                : {{ $bank['number'] or '' }}<br/>
                                {{ $bank['name'] or '' }}<br/>
                            </div>
                        </div>
                    </td>
                    <td class="invoice-col text-right pull-right" style="width:35%;">
                        <div class="panel panel-default bordered">
                            <div class="panel-heading">
                                <strong>Contact Details</strong>
                            </div>
                            <div class="panel-body">
                                <strong>Ph</strong> : {{ $company['phone_number'] or '' }} <br/>
                                <strong>Email</strong> : {{ $company['email'] or '' }} <br/>
                                <strong>Website</strong> : {{ $company['website'] or '' }}<br/>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </section>
</div>
</body>
</html>