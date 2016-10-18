@extends('layouts.tenant')
@section('title', 'Payment Advanced Search')
@section('heading', '<h1>Payment - <small>Advanced Search</small></h1>')
@section('breadcrumb')
    @parent
    <li><a href="{{url('tenant/clients')}}" title="All Payments"><i class="fa fa-users"></i> Payments</a>
    </li>
    <li>Advanced Search</li>
@stop

@section('content')
    <div class="col-md-12">
        @include('Tenant::InvoiceReport/Payment/partial/navbar')
        @include('flash::message')
    </div>

    <div class="col-md-12 col-xs-12">
        <div class="box box-primary">
            {!!Form::model($search_attributes, array('route' => 'payments.search', 'method' => 'post', 'class' => ''))!!}
            <div class="box-header">
                <h3 class="box-title">Filter Options</h3>
                <input type="submit" class="btn btn-primary pull-right" value="Search"/>
            </div>

            <div class="box-body">
                <div class="form-group col-md-4 col-xs-12">
                    {!!Form::label('type', 'Payment Type', array('class' => 'control-label')) !!}
                    {!!Form::select('type', $type, null, array('class' => 'form-control select2'))!!}

                </div>
                <div class="form-group col-md-4 col-xs-12">
                    {!!Form::label('invoice_date', 'Payment Date', array('class' => 'control-label')) !!}
                    <div class='input-group'>
                        {!!Form::text('payment_date', null, array('class' => 'form-control dateranger', 'id'=>'payment_date', 'placeholder' => "Select Date Range"))!!}
                        <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                    </div>
                </div>
                <div class="form-group col-md-4 col-xs-12">
                    {!!Form::label('amount', 'Amount', array('class' => 'control-label')) !!}
                    {!!Form::text('amount', null, array('class' => 'form-control', 'id'=>'amount'))!!}
                </div>
                <div class="form-group col-md-4 col-xs-12">
                    {!!Form::label('payment_type', 'Payment Type', array('class' => 'control-label')) !!}
                    {!!Form::select('type', config('constants.student_payment_type'), null, array('class' => 'form-control select2 payment-type'))!!}
                </div>
                <div class="form-group col-md-4 col-xs-12">
                    {!!Form::label('client_name', 'Client Name', array('class' => 'control-label')) !!}
                    {!!Form::select('client_name[]', $clients, null, array('class' => 'form-control select2', 'multiple' => 'multiple'))!!}
                </div>
                <div class="form-group col-md-4 col-xs-12">
                    {!!Form::label('college_name', 'Institute Name', array('class' => 'control-label')) !!}
                    {!!Form::select('college_name[]', $colleges, null, array('class' => 'form-control select2', 'multiple' => 'multiple'))!!}
                </div>
                <div class="form-group col-md-4 col-xs-12">
                    {!!Form::label('added_by', 'Added By', array('class' => 'control-label')) !!}
                    {!!Form::select('added_by[]', $users, null, array('class' => 'form-control select2', 'multiple' => 'multiple'))!!}
                </div>
            </div>
            {{--<div class="box-footer clearfix">
                <input type="submit" class="btn btn-primary pull-right" value="Search"/>
            </div>--}}
            {!!Form::close()!!}
        </div>
    </div>

    <div class="col-md-12 col-xs-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Filtered Payments</h3>
            </div>
            <div class="box-body table-responsive">
                @if(isset($payments))
                    <table id="payments" class="table table-bordered table-striped dataTable">
                        <thead>
                        <tr>
                            {{--<th>Payment ID</th>--}}
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
                                    <a href="{{route("application.students.editPayment", $payment->student_payments_id)}}" title="Edit Payment"><i
                                                class="processing btn btn-primary btn-sm glyphicon glyphicon-pencil"
                                                data-toggle="tooltip" data-placement="top" title="Edit Payment"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="callout callout-warning">
                        <h4>No Filtered Records!</h4>

                        <p>You can search for the invoices by providing the details in the form.</p>
                    </div>
                @endif
            </div>
        </div>

    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#payments').DataTable({
                "pageLength": 50,
                order: [[0, 'desc']]
            });

            $('.dateranger').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                }
            });

            $('.dateranger').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            });

            $('.dateranger').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        });
    </script>
@stop