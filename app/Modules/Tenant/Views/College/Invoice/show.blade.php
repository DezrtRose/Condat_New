<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>College Invoice</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
</head>

<body>
<div class="container">
    <div class="row">
        <div class="col-xs-6">
            <h1>
                <img src="{{ (isset($company['logo_path']) && !empty($company['logo_path']))? $company['logo_path'] : '' }}" height="100px">
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
                    <h4>{{ $company['company_name'] or '' }}</h4>
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
                        {{ $invoice_to }}
                    <h3>
                        <small>Invoice #{{ format_id($invoice->invoice_id, 'CI') }}</small>
                    </h3>
                    <h3>
                        <small>Date: {{ format_date($invoice->invoice_date) }}</small>
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
                <h4>
                    Student Name
                </h4>
            </th>
            <th>
                <h4>Description</h4>
            </th>

            <th>
                <h4>Amount</h4>
            </th>
            <th>
                <h4>GST</h4>
            </th>
        </tr>
        </thead>
        <tbody>
        @if($invoice->commission_amount || $invoice->commission_gst)
        <tr>
            <td>{{ $client_name }}</td>
            <td>{{ $invoice->description }}</td>
            <td class="text-right">${{ float_format($invoice->commission_amount) }}</td>
            <td class="text-right">${{ float_format($invoice->commission_gst) }}</td>
        </tr>
        @endif
        @if($invoice->incentive || $invoice->incentive_gst)
        <tr>
            <td>{{ $client_name }}</td>
            <td>{{ $invoice->other_description }}</td>
            <td class="text-right">${{ float_format($invoice->incentive) }}</td>
            <td class="text-right">${{ float_format($invoice->incentive_gst) }}</td>
        </tr>
        @endif
        </tbody>
    </table>
    <div class="row">
        <div class="col-xs-5 col-xs-offset-7 text-right">
            <div class="panel panel-default">
                <div class="panel-body">
                    <p>Sub Total: <small>${{ float_format($invoice->total_commission) }}</small></p>
                    <p>GST: <small>${{ float_format($invoice->total_gst) }}</small></p>
                    <h3>Total Amount: <small>${{ float_format($invoice->final_total) }}</small></h3>
                    <p>Less Paid Amount: <small>${{ float_format($pay_details->paid) }}</small></p>
                    <h3>Amount Due: <small>${{ float_format($pay_details->outstandingAmount) }}</small></h3>
                </div>
            </div>
        </div>
        {{--<div class="col-xs-2 col-xs-offset-8">
            <p>
            <h4>
                Sub Total : <br>
                GST : <br>

                <h3>Total Amount :</h3>
                Less Paid Amount : <br>

                <h3>Amount Due :</h3> <br>
            </h4>
            </p>
        </div>
        <div class="col-xs-2">
            <p>
            <h4>
                ${{ float_format($invoice->total_commission) }} <br>
                ${{ float_format($invoice->total_gst) }} <br>

                <h3>${{ float_format($invoice->final_total) }} </h3>
                ${{ float_format($pay_details->paid) }}<br>

                <h3>${{ float_format($pay_details->outstandingAmount) }}</h3><br>
            </h4>
            </p>
        </div>--}}
    </div>
    <div class="row">
        <div class="col-xs-5">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h4>Bank details</h4>
                </div>
                <div class="panel-body">
                    <p>{{ $bank['account_name'] or '' }}</p>

                    <p><strong>BSB</strong> : {{ $bank['bsb'] or '' }} | <strong>Account Number</strong> : {{ $bank['number'] or '' }}</p>

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