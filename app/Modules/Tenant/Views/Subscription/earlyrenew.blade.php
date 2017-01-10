@extends('layouts.tenant')
@section('title', 'Renew Subscription')
@section('breadcrumb')
    @parent
    <li>Subscription</li>
    <li>Renew</li>
@stop
@section('content')
    <div class="col-md-12">@include('flash::message')</div>

    <div class="col-md-3">
        <!-- About Me Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">General Information</h3>
            </div>

            <!-- /.box-header -->
            <div class="box-body">

                <strong><i class="fa fa-file-text-o margin-r-5"></i> Subscription ID</strong>

                <p class="text-muted">{{format_id($agency_subscription->agency_subscription_id, 'Sub')}}</p>

                <strong><i class="fa fa-file-text-o margin-r-5"></i> Agency ID</strong>

                <p class="text-muted">{{format_id($agency_subscription->agency_id, 'Ag')}}</p>

                <strong><i class="fa fa-calendar margin-r-5"></i> Start Date</strong>

                <p class="text-muted">{{format_datetime($agency_subscription->created_at)}}</p>

                <strong><i class="fa fa-calendar margin-r-5"></i> End Date</strong>

                <p class="text-muted">{{format_datetime($agency_subscription->end_date)}}</p>

                <strong><i class="fa fa-user-plus margin-r-5"></i> Status</strong>

                <p class="text-muted">{{($agency_subscription->status == 0) ? 'Trial' : 'Paid'}}</p>

                <strong><i class="fa fa-user-plus margin-r-5"></i> Subscription Type</strong>

                <p class="text-muted">{{($agency_subscription->subscription_status_id == 1) ? 'Basic' : 'Premium'}}</p>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Subscription Renew</h3>
            </div>

            {!!Form::open(array('method' => 'post', 'class' => 'form-horizontal form-left'))!!}
            <input type="hidden" name="return_url"
                   value="{{url($tenant_id.'/subscription/complete_subscription_paypal')}}"/>

            <div class="box-body">
                <div class="col-md-6 col-xs-12">
                    <div class="form-group">
                        {!!Form::label('subscription_years', 'Years', array('class' => 'col-sm-4 control-label')) !!}
                        <div class="col-sm-8">
                            {!!Form::select('subscription_years', config('constants.subscription_years'), null, array('class' =>
                            'form-control'))!!}
                        </div>
                    </div>
                    <div class="form-group total-amount">
                        {!!Form::label('amount', 'Total Amount', array('class' => 'col-sm-4 control-label')) !!}
                        <div class="col-sm-8">
                            $<span class="subscription-amount">0</span>
                        </div>
                    </div>
                    <div class="form-group">
                        {!!Form::label('', 'Payment Type', array('class' => 'col-sm-4 control-label')) !!}
                        <div class="col-sm-8">
                            {!! Form::radio('payment_type', 'Paypal', true, ['id' => 'Paypal', 'class' => 'payment_type']) !!}
                            {!! Form::label('Paypal', 'Paypal', array('class' => 'control-label')) !!}

                            {!! Form::radio('payment_type', 'Credit Card', null, ['id' => 'Credit Card', 'class' => 'payment_type']) !!}
                            {!! Form::label('Credit Card', 'Credit Card', array('class' => 'control-label')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!!Form::label('subscription_type', 'Type', array('class' => 'col-sm-4 control-label')) !!}
                        <div class="col-sm-8">
                            {!!Form::select('subscription_type', config('constants.subscription_type'), null, array('class' =>
                            'form-control'))!!}
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xs-12 card-details" style="display: none;">
                    <div class="form-group">
                        {!!Form::label('card_type', 'Card Type', array('class' => 'col-sm-4 control-label')) !!}
                        <div class="col-sm-8">
                            {!!Form::select('card_type', config('constants.card_type'), null, array('class' =>
                            'form-control'))!!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!!Form::label('card-number', 'Card Number', array('class' => 'col-sm-4 control-label')) !!}
                        <div class="col-sm-8">
                            {!!Form::text('card-number', null, array('class' =>'form-control', 'autocomplete' => 'off'))!!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!!Form::label('expiration-month', 'Expiration Date', array('class' => 'col-sm-4 control-label')) !!}
                        <div class="col-sm-8">
                            <div class="col-md-6 col-xs-12 no-padding">
                                {!!Form::select('expiration-month', config('constants.card_type'), null, array('class' => 'form-control', 'id' => 'expiration-month'))!!}
                            </div>
                            <div class="col-md-6 col-xs-12 no-padding">
                                <select id="expiration-year" class="form-control">
                                    <?php
                                    $yearRange = 20;
                                    $thisYear = date('Y');
                                    $startYear = ($thisYear + $yearRange);

                                    foreach (range($thisYear, $startYear) as $year) {
                                        if ($year == $thisYear) {
                                            print '<option value="' . $year . '" selected="selected">' . $year . '</option>';
                                        } else {
                                            print '<option value="' . $year . '">' . $year . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {!!Form::label('cvc', 'CVC', array('class' => 'col-sm-4 control-label')) !!}
                        <div class="col-sm-8">
                            {!!Form::text('cvc', null, array('class' =>'form-control', 'id'=> 'card-security-code', 'autocomplete' => 'off'))!!}
                        </div>
                    </div>

                </div>
            </div>
            <div class="box-footer clearfix">
                <input type="submit" class="btn btn-primary pull-right" value="Renew Now"/>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
@stop
<script>
    window.onload = function () {

        $('.payment_type').change(function (e) {
            var type = $(this).val();
            if(type == 'Paypal')
                $('.card-details').hide('slow');
            else
                $('.card-details').show('slow');
        });

        var CSRF_TOKEN = "<?php echo csrf_token() ?>";

        $('#subscription_years, #subscription_type').on('change', function (e) {
            e.preventDefault();
            var subscription_years = $('#subscription_years').val();
            var subscription_type = $('#subscription_type').val();
            $.post("<?php echo url($tenant_id.'/subscription/get_subscription_amount') ?>", {
                'subscription_years': subscription_years,
                'subscription_type': subscription_type,
                _token: CSRF_TOKEN
            })
                    .done(function (resp) {
                        if (resp != 'false') {
                            $('.subscription-amount').html(resp);
                        }
                    })
        });
        $('#subscription_years').trigger('change');
    };
</script>