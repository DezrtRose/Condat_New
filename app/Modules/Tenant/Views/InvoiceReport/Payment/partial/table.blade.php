<table id="payments" class="table table-bordered table-striped dataTable">
    <thead>
    <tr>
        <th>Payment ID</th>
        <th>Payment Date</th>
        <th>Client Name</th>
        <th>Amount</th>
        <th>Payment Type</th>
        <th>Payment Method</th>
        <th>Added By</th>
        <th></th>
    </tr>
    </thead>
    <tbody> <?php //dd($payments->toArray()) ?>

    @foreach($payments as $key => $payment)
        <tr>
            <td>{{ format_id($payment->client_payment_id, 'CPI') }}</td>
            <td>{{ format_date($payment->date_paid) }}</td>
            <td>{{ $payment->client_name }}</td>
            <td>{{ format_price($payment->amount) }}</td>
            <td>{{ $payment->payment_type }}</td>
            <td>{{ $payment->payment_method }}</td>
            <td>{{ $payment->payment_method }}</td>
            <td>
                <a href="{{url("tenant/students/payment/receipt/" . $payment->student_payments_id)}}" title="Print Payment"><i
                            class="processing btn btn-primary btn-sm glyphicon glyphicon-print"
                            data-toggle="tooltip" data-placement="top"
                            title="Print Payment"></i></a>
                <a href="{{route("application.students.editPayment", [$tenant_id, $payment->student_payments_id])}}" title="Edit Payment"><i
                            class="processing btn btn-primary btn-sm glyphicon glyphicon-pencil"
                            data-toggle="tooltip" data-placement="top" title="Edit Payment"></i></a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>