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

                <p class="text-muted">{{($agency_subscription->subscription_status_id == 1) ? 'Basic' : 'Standard'}}</p>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs pull-right">
                <li class="active"><a href="#tab_1-1" data-toggle="tab" aria-expanded="true">Renew</a></li>
                <li class=""><a href="#tab_2-2" data-toggle="tab" aria-expanded="false">Upgrade</a></li>
                <li class=""><a href="#tab_3-2" data-toggle="tab" aria-expanded="false">Upgrade + Renew</a></li>
                <li class="pull-left header"><i class="fa fa-refresh"></i> Renew Options</li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1-1">
                    {{--<div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-warning"></i> Feature Unavailable Temporarily!</h4>
                        Subscription renewal is currently not available. Please try again in a couple of days or
                        contact
                        the administrator.
                    </div>--}}

                    {!!Form::open(array('method' => 'post', 'class' => 'form-horizontal form-left'))!!}
                    <input type="hidden" name="return_url"
                           value="{{url($tenant_id.'/subscription/complete_subscription_paypal')}}"/>

                    <div class="row">
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
                                    {{--{!! Form::radio('payment_type', 'Paypal', true, ['id' => 'Paypal', 'class' => 'payment_type']) !!}
                                    {!! Form::label('Paypal', 'Paypal', array('class' => 'control-label')) !!}--}}

                                    {!! Form::radio('payment_type', 'Credit Card', true, ['id' => 'Credit Card', 'class' => 'payment_type']) !!}
                                    {!! Form::label('Credit Card', 'Credit Card', array('class' => 'control-label')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!!Form::label('subscription_type', 'Type', array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    {!!Form::select('subscription_type', config('constants.subscription_type'), $agency_subscription->subscription_status_id, array('class' =>
                                    'form-control', 'readonly' => 'readonly'))!!}
                                    {{--{!!Form::select('subscription_type', config('constants.subscription_type'), null, array('class' =>
                                    'form-control'))!!}--}}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xs-12 card-details"
                             style="display: none"> {{-- Remove display none in live --}}
                            <div class="form-group">
                                {!!Form::label('card_type', 'Card Type', array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    {!!Form::select('card_type', config('constants.card_type'), null, array('class' =>
                                    'form-control'))!!}
                                </div>
                            </div>

                            <div class="form-group @if($errors->has('card_number')) {{'has-error'}} @endif">
                                {!!Form::label('card_number', 'Card Number *', array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    {!!Form::text('card_number', null, array('class' =>'form-control', 'autocomplete' => 'off'))!!}
                                    @if($errors->has('card_number'))
                                        {!! $errors->first('card_number', '<label class="control-label"
                                                                                 for="inputError">:message</label>') !!}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                {!!Form::label('expiration_month', 'Expiration Date', array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    <div class="col-md-6 col-xs-12 no-padding">
                                        {!!Form::select('expiration_month', config('constants.months'), null, array('class' => 'form-control', 'id' => 'expiration-month'))!!}
                                    </div>
                                    <div class="col-md-6 col-xs-12 no-padding">
                                        <select name="expiration_year" id="expiration_year" class="form-control">
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

                            <div class="form-group @if($errors->has('cvc')) {{'has-error'}} @endif">
                                {!!Form::label('cvc', 'CVC *', array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    {!!Form::text('cvc', null, array('class' =>'form-control', 'id'=> 'card-security-code', 'autocomplete' => 'off'))!!}
                                    @if($errors->has('cvc'))
                                        {!! $errors->first('cvc', '<label class="control-label"
                                                                                 for="inputError">:message</label>') !!}
                                    @endif
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-right">
                                <script
                                        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                        data-key="{{ env('STRIPE_PUBLISHABLE_KEY') }}"
                                        data-name="Condat Solutions"
                                        data-description="Subscription Renew"
                                        data-image="https://www.condat.com.au/assets/images/logo.png"
                                        data-locale="auto"
                                        data-zip-code="true"
                                        data-currency="aud"
                                        data-label="Renew Now">
                                </script>
                            </div>
                        </div>
                    </div>
                    {!!Form::close()!!}
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_2-2">
                    The European languages are members of the same family. Their separate existence is a myth.
                    For science, music, sport, etc, Europe uses the same vocabulary. The languages only differ
                    in their grammar, their pronunciation and their most common words. Everyone realizes why a
                    new common language would be desirable: one could refuse to pay expensive translators. To
                    achieve this, it would be necessary to have uniform grammar, pronunciation and more common
                    words. If several languages coalesce, the grammar of the resulting language is more simple
                    and regular than that of the individual languages.
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_3-2">
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                    Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                    when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                    It has survived not only five centuries, but also the leap into electronic typesetting,
                    remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset
                    sheets containing Lorem Ipsum passages, and more recently with desktop publishing software
                    like Aldus PageMaker including versions of Lorem Ipsum.
                </div>
                <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
        </div>
    </div>
@stop
<script>
    window.onload = function () {

        $('.payment_type').change(function (e) {
            var type = $(this).val();
            if (type == 'Paypal')
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