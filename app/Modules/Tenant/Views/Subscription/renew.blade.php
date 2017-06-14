@extends('layouts.min')
@section('title', 'Renew Subscription')
@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href="">Consultancy Database</a>
        </div>

        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Subscription Renew</p>
            @include('flash::message')

            {!!Form::open(array('method' => 'post', 'class' => ''))!!}
            <input type="hidden" name="return_url"
                   value="{{url($tenant_id.'/subscription/complete_subscription_paypal')}}"/>

            <div class="box-body">
                <div class="form-group">
                    {!!Form::label('subscription_years', 'Years', array('class' => 'control-label')) !!}

                    {!!Form::select('subscription_years', config('constants.subscription_years'), null, array('class' =>
                    'form-control'))!!}
                </div>
                <div class="form-group total-amount">
                    {!!Form::label('amount', 'Total Amount', array('class' => 'control-label')) !!}
                    <div class="form-control"> $<span class="subscription-amount">0</span></div>
                </div>
                <div class="form-group">
                    {!!Form::label('', 'Payment Type', array('class' => 'control-label')) !!}
                    <div>
                        {!! Form::radio('payment_type', 'Credit Card', true, ['id' => 'Credit Card', 'class' => 'payment_type']) !!}
                        {!! Form::label('Credit Card', 'Credit Card', array('class' => 'control-label')) !!}
                        {{--{!! Form::radio('payment_type', 'Paypal', true, ['id' => 'Paypal', 'class' => 'form-control']) !!}
                        Paypal--}}
                    </div>
                </div>
                <div class="form-group">
                    {!!Form::label('subscription_type', 'Type', array('class' => 'control-label')) !!}
                    {!!Form::select('subscription_type', config('constants.subscription_type'), null, array('class' =>
                    'form-control'))!!}
                </div>


                <div style="display: none"> {{-- Remove display none in live --}}
                    <div class="form-group">
                        {!!Form::label('card_type', 'Card Type', array('class' => 'control-label')) !!}
                        {!!Form::select('card_type', config('constants.card_type'), null, array('class' =>
                        'form-control'))!!}
                    </div>
                    <div class="form-group @if($errors->has('card_number')) {{'has-error'}} @endif">
                        {!!Form::label('card_number', 'Card Number *', array('class' => 'control-label')) !!}
                        {!!Form::text('card_number', null, array('class' =>'form-control', 'autocomplete' => 'off'))!!}
                        @if($errors->has('card_number'))
                            {!! $errors->first('card_number', '<label class="control-label"
                                                                     for="inputError">:message</label>') !!}
                        @endif
                    </div>
                    <div class="form-group">
                        {!!Form::label('expiration_month', 'Expiration Month', array('class' => 'control-label')) !!}
                        {!!Form::select('expiration_month', config('constants.months'), null, array('class' => 'form-control', 'id' => 'expiration-month'))!!}
                    </div>
                    <div class="form-group">
                        {!!Form::label('expiration_year', 'Expiration Year', array('class' => 'control-label')) !!}
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
                    <div class="form-group @if($errors->has('cvc')) {{'has-error'}} @endif">
                        {!!Form::label('cvc', 'CVC *', array('class' => 'control-label')) !!}
                        {!!Form::text('cvc', null, array('class' =>'form-control', 'id'=> 'card-security-code', 'autocomplete' => 'off'))!!}
                        @if($errors->has('cvc'))
                            {!! $errors->first('cvc', '<label class="control-label"
                                                                     for="inputError">:message</label>') !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer clearfix">
            <a class="btn btn-warning pull-left" href="{{ route('tenant.logout', $tenant_id) }}">Logout</a>
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
            {{--<input type="submit" class="btn btn-primary pull-right" value="Renew Now"/>--}}
        </div>
        {!!Form::close()!!}
    </div>
    </div>
@stop
<script>
    window.onload = function () {
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
    }
</script>