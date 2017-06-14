<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Invoice</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
</head>

<body>
<div class="container">
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
                    <p>{{ $company['abn'] or '' }}

                    <h3>
                        <small>{{ $company['street'] or '' }}</small>
                    </h3>
                    <h3>
                        <small>{{ $company['suburb'] or '' }} {{ $company['state'] or '' }} {{ $company['postcode'] or '' }}</small>
                    </h3>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xs-5 col-xs-offset-2 text-right">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Invoice To</h4>
                </div>
                <div class="panel-body">
                    <p>
                        {{ $invoice->client_name }}

                    <h3>
                        <small>Invoice #{{ format_id($invoice->invoice_id, 'I') }}</small>
                    </h3>
                    <h3>
                        <small>Date {{ format_date($invoice->invoice_date) }}</small>
                    </h3>
                    </p>
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
                        {{--<small>${{ float_format($invoice->amount) }}</small>--}}
                        <small>{{ format_price($invoice->invoice_amount) }}</small>
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
                    <p>{{ $bank['account_name'] or '' }}</p>

                    <p><strong>BSB</strong> : {{ $bank['bsb'] or '' }} | <strong>Account Number</strong>
                        : {{ $bank['number'] or '' }}</p>

                    <p>{{ $bank['name'] or '' }}</p>
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