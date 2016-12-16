<table class="table table-striped table-bordered table-condensed" id="invoice_report_table">
    <thead>
    <tr class="text-nowrap">
        {!! (isset($is_group) && $is_group == true)? '<th>Select</th>' : '' !!}
        <th>Invoice Id</th>
        <th>Date</th>
        <th>Client Name</th>
        <th>Institute Name</th>
        <th>Course Name</th>
        <th>Invoice To</th>
        <th>Total Amount</th>
        <th>Total GST</th>
        <th>Outstanding</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach($invoice_reports as $invoice)
        <tr>
            {!! (isset($is_group) && $is_group == true)? '<td><input type = "checkbox" class = "icheck group-ids" name = "group" value = "'.$invoice->invoice_id.'" /></td>' : '' !!}
            <td>{{ format_id($invoice->invoice_id, 'CI') }}</td>
            <td>{{ format_date($invoice->invoice_date) }}</td>
            <td>{{ $invoice->fullname }}</td>
            <td>{{ $invoice->institute_name }}</td>
            <td>{{ $invoice->course_name }}</td>
            <td>{{ $invoice->invoice_to }}</td>
            <td>{{ format_price($invoice->final_total) }}</td>
            <td>{{ format_price($invoice->total_gst) }}</td>

            <td>
                @if(($invoice->total_commission) - ($invoice->total_paid) == 0)
                    {{ '-' }}
                @else
                    {{ format_price(($invoice->total_commission) - ($invoice->total_paid)) }}
                @endif
            </td>
            <td>
                <a data-toggle="modal" data-target="#condat-modal" data-url="{{ url($tenant_id.'/invoices/' . $invoice->college_invoice_id . '/payment/add/1') }}" title="Add Payment"><i
                            class=" btn btn-primary btn-sm glyphicon glyphicon-shopping-cart"
                            data-toggle="tooltip" data-placement="top" title="Add Payment"></i></a>
                <a href="{{ route('tenant.college.invoice', [$tenant_id, $invoice->college_invoice_id]) }}" target="_blank" title="Print Invoice"><i
                            class="processing btn btn-primary btn-sm glyphicon glyphicon-print"
                            data-toggle="tooltip" data-placement="top"
                            title="Print Invoice"></i></a>
                <a href="{{ route("tenant.invoice.payments", [$tenant_id, $invoice->college_invoice_id, 1]) }}" title="View Invoice"><i
                            class="processing btn btn-primary btn-sm glyphicon glyphicon-eye-open"
                            data-toggle="tooltip" data-placement="top" title="View Invoice"></i></a>
                {{--<a href="#" title="Email Invoice"><i
                            class="processing btn btn-primary btn-sm glyphicon glyphicon-send"
                            data-toggle="tooltip" data-placement="top"
                            title="Email Invoice"></i></a>--}}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{!! Condat::registerModal() !!}