<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Student Invoice</title>
    {{--<link type="text/css" media="all" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">--}}
    <style>
        html {
            font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
            font-size: 14px;
            line-height: 1.42857143;
            color: #333;
        }
        body {
            margin: 0;
        }
        .container {
            width: 1170px;
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
        }
        .row {
            margin-right: -15px;
            margin-left: -15px;
        }
        .col-xs-6 {
            width: 50%;
        }
        .text-right {
            text-align: right;
        }
        .col-xs-5 {
            width: 41.66666667%;
        }
        .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9 {
            float: left;
            position: relative;
            min-height: 1px;
            padding-right: 15px;
            padding-left: 15px;
        }
        .panel-default {
            border-color: #ddd;
        }
        .panel {
            margin-bottom: 20px;
            background-color: #fff;
            border: 1px solid transparent;
            border-radius: 4px;
            box-shadow: 0 1px 1px rgba(0,0,0,.05);
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
        .no-border {
            border: 0;
        }


    </style>
</head>

<body>
<div class="container">
    <table class="no-border">
        <tr>
            <td>
                <h1>
                    <img src="{{ (isset($company['logo_path']) && !empty($company['logo_path']))? $company['logo_path'] : '' }}"
                         height="100px">
                </h1>
            </td>
            <td>
                <h2>TAX INVOICE</h2>
            </td>
        </tr>
    </table>
    <div class="row">
        <div class="col-xs-6">
            <h1>
                <img src="{{ (isset($company['logo_path']) && !empty($company['logo_path']))? $company['logo_path'] : '' }}"
                     height="100px">
            </h1>
        </div>
        <div class="col-xs-6 text-right">
            <h2>TAX INVOICE</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-5">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>{{ $company['company_name'] or ''}}</h4>
                </div>
                <div class="panel-body">
                    {{ $company['abn'] or '' }}

                    <h3>
                        <small>{{ $company['street'] or '' }}</small>
                    </h3>
                    <h3>
                        <small>{{ $company['suburb'] or '' }} {{ $company['state'] or '' }} {{ $company['postcode'] or '' }}</small>
                    </h3>
                </div>
            </div>
        </div>
        <div class="col-xs-5 col-xs-offset-2 text-right">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Invoice To</h4>
                </div>
                <div class="panel-body">
                    {{ $invoice->client_name }}

                    <h3>
                        <small>Invoice #{{ format_id($invoice->invoice_id, 'I') }}</small>
                    </h3>
                    <h3>
                        <small>Date {{ format_date($invoice->invoice_date) }}</small>
                    </h3>
                </div>
            </div>
        </div>
    </div>
    <!-- / end client details section -->
    <table class="table table-bordered">
        <thead class="thead-default">
        <tr>

            <th>
                <h4>Description</h4>
            </th>

            <th>
                <h4>Amount</h4>
            </th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ $invoice->description }}</td>
            <td class="text-right">${{ float_format($invoice->invoice_amount) }}</td>
        </tr>


        </tbody>
    </table>
    <div class="row">
        <div class="col-xs-5 col-xs-offset-7 text-right">
            <div class="panel panel-default">
                <div class="panel-body">
                    <p>Sub Total:
                        <small>${{ float_format($invoice->amount) }}</small>
                    </p>
                    <p>GST:
                        <small>${{ float_format($invoice->total_gst) }}</small>
                    </p>
                    <h3>Total Amount:
                        <small>${{ float_format($invoice->final_total) }}</small>
                    </h3>
                    <p>Less Paid Amount:
                        <small>${{ float_format($pay_details->paid) }}</small>
                    </p>
                    <h3>Amount Due:
                        <small>${{ float_format($pay_details->outstandingAmount) }}</small>
                    </h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-5">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h4>Bank details</h4>
                </div>
                <div class="panel-body">
                    <p>{{ $bank['account_name'] }}</p>

                    <p><strong>BSB</strong> : {{ $bank['bsb'] }} | <strong>Account Number</strong>
                        : {{ $bank['number'] }}</p>

                    <p>{{ $bank['name'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-xs-7">
            <div class="span7">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h4>Contact Details</h4>
                    </div>
                    <div class="panel-body">
                        <p><strong>Ph</strong> : {{ $company['phone_number'] or '' }} </p>

                        <p><strong>Email</strong> : {{ $company['email'] or '' }} </p>

                        <p><strong>Website</strong> : {{ $company['website'] or '' }}</p>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>