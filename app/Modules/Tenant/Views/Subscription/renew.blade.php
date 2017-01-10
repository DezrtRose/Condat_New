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
                    {!! Form::radio('payment_type', 'Paypal', true, ['id' => 'Paypal', 'class' => 'form-control']) !!}
                    Paypal
                    </div>
                </div>
                <div class="form-group">
                    {!!Form::label('subscription_type', 'Type', array('class' => 'control-label')) !!}

                    {!!Form::select('subscription_type', config('constants.subscription_type'), null, array('class' =>
                    'form-control'))!!}
                </div>
            </div>
            <div class="box-footer clearfix">
                <a class="btn btn-warning pull-left" href="{{ route('tenant.logout', $tenant_id) }}">Logout</a>
                <input type="submit" class="btn btn-primary pull-right" value="Renew Now"/>
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