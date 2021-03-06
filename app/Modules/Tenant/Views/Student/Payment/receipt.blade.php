<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Receipt</title>
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
            <h2>PAYMENT RECEIPT</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-5">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>{{ $company['company_name'] }}</h4>
                </div>
                <div class="panel-body">
                    <p>{{ $company['abn'] or '' }}

                    <h3>
                        <small>{{ $company['street'] }}</small>
                    </h3>
                    <h3>
                        <small>{{ $company['suburb'] }} {{ $company['state'] }} {{ $company['postcode'] }}</small>
                    </h3>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xs-5 col-xs-offset-2 text-right">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Paid By</h4>
                </div>
                <div class="panel-body">
                    <p>
                    {{ get_client_name($payment->client_id) }}

                    <h3>
                        <small>Receipt No #
                            @if(isset($payment->client_payment_id) && !isset($payment->subagent_payments_id))
                                {{ format_id($payment->client_payment_id, 'CP') }}
                            @elseif(isset($payment->college_payment_id))
                                {{ format_id($payment->college_payment_id, 'CPI') }}
                            @elseif(isset($payment->subagent_payments_id))
                                {{ format_id($payment->subagent_payments_id, 'SAP') }}
                            @endif
                        </small>
                    </h3>
                    <h3>
                        <small>Payment Date {{ format_date($payment->date_paid) }}</small>
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
                <h4>Payment Method</h4>
            </th>

            <th class="text-right">
                <h4>Amount</h4>
            </th>
        </tr>
        </thead>
        <tbody>
        <tr>

            <td>{{ $payment->description }}</td>
            <td>{{ $payment->payment_method }}</td>
            <td class="text-right">${{ float_format($payment->amount) }}</td>

        </tr>

        </tbody>
    </table>
    <div class="row Text-center">

        <p>
        <h4>
            THANK YOU FOR YOUR PAYMENT
        </h4>
        </p>
        <p>
            &nbsp;
        </p>


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
                        <p><strong>Ph</strong> : {{ $company['phone_number'] }} </p>

                        <p><strong>Email</strong> : {{ $company['email'] }} </p>

                        <p><strong>Website</strong> : {{ $company['website'] }}</p>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>