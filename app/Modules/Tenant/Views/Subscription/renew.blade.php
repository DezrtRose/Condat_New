@extends('layouts.tenant')
@section('title', 'Add User')
@section('breadcrumb')
    @parent
    <li>Subscription</li>
    <li>Renew</li>
@stop
@section('content')
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Subscription Renew</h3>
            </div>
            @include('flash::message')
            {!!Form::open(array('method' => 'post', 'class' => 'form-horizontal form-left'))!!}
            <input type="hidden" name="return_url" value="{{url('tenant/subscription/complete_subscription_paypal')}}"/>
            <div class="box-body">
                <div class="col-md-6">
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
                            {!! Form::radio('payment_type', 'Paypal', true, ['id' => 'Paypal']) !!}
                            {!! Form::label('Paypal', 'Paypal', array('class' => 'control-label')) !!}
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
            </div>
            <div class="box-footer clearfix">
                <input type="submit" class="btn btn-primary pull-right" value="Renew Now" />
            </div>
            {!!Form::close()!!}
        </div>
    </div>
@stop
<script>
    window.onload = function() {
        var CSRF_TOKEN = "<?php echo csrf_token() ?>";
        $('#subscription_years, #subscription_type').on('change', function (e) {
            e.preventDefault();
            var subscription_years = $('#subscription_years').val();
            var subscription_type = $('#subscription_type').val();
            $.post("<?php echo url('tenant/subscription/get_subscription_amount') ?>", {'subscription_years': subscription_years, 'subscription_type': subscription_type, _token: CSRF_TOKEN})
            .done(function(resp) {
                if(resp != 'false') {
                    $('.subscription-amount').html(resp);
                }
            })
        });
        $('#subscription_years').trigger('change');
    }
</script>