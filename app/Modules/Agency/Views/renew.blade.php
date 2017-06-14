@extends('layouts.main')
@section('title', 'Renew Agency Subscription')
@section('heading', 'Renew Agency Subscription')
@section('breadcrumb')
    @parent
    <li><a href="{{url('agency')}}" title="All Agencies"><i class="fa fa-Agencies"></i> Agencies</a></li>
    <li>Subscription</li>
    <li>Renew</li>
@stop
@section('content')
    <div class="col-xs-12">
        @include('flash::message')
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Subscription Renew</h3>
            </div>
                {!!Form::open(array('method' => 'post', 'class' => 'form-horizontal form-left subs-form'))!!}
                <input type="hidden" name="return_url" value="{{url('agencies/complete_subscription_paypal')}}"/>
                <div class="box-body">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="col-sm-4"><strong>Company Name</strong></div>
                            <div class="col-sm-8">
                                {{ $companyDetails->name }}
                            </div>
                        </div>
                        <div class="form-group">
                            {!!Form::label('renewal_date', 'Renewal Date', array('class' => 'col-sm-4 control-label')) !!}
                            <div class="col-sm-8">
                                {{ format_date(get_today_date()) }}
                            </div>
                        </div>
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
                        {{--<div class="form-group @if($errors->has('payment_date')) {{'has-error'}} @endif">
                            {!!Form::label('payment_date', 'Payment Date', array('class' => 'col-sm-4 control-label')) !!}
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    {!!Form::text('payment_date', null, array('class' =>
                                    'form-control datemask', 'data-inputmask' => "'alias': 'dd/mm/yyyy'", 'data-mask'=> ''))!!}
                                    @if($errors->has('payment_date'))
                                        {!! $errors->first('payment_date', '<label class="control-label"
                                                                                  for="inputError">:message</label>') !!}
                                    @endif
                                </div>
                            </div>
                        </div>--}}
                        <div class="form-group">
                            {!!Form::label('', 'Payment Type', array('class' => 'col-sm-4 control-label')) !!}
                            <div class="col-sm-8">
                                {!! Form::radio('payment_type', 'Credit Card', true, ['id' => 'Credit Card', 'class' => 'payment_type']) !!}
                                {!! Form::label('Credit Card', 'Credit Card', array('class' => 'control-label')) !!}

                                {!! Form::radio('payment_type', 'Cash', null, ['id' => 'cash', 'class' => 'payment_type']) !!}
                                {!! Form::label('cash', 'Cash', array('class' => 'control-label')) !!}

                                {!! Form::radio('payment_type', 'NetBank Transfer', null, ['id' => 'NetBank_Transfer', 'class' => 'payment_type']) !!}
                                {!! Form::label('NetBank_Transfer', 'NetBank Transfer', array('class' => 'control-label')) !!}
                                {{--@foreach(config('constants.payment_type') as $key => $value)
                                    {!! Form::radio('payment_type', $key, false, ['id' => $key]) !!}
                                    {!! Form::label($key, $value, array('class' => 'control-label')) !!}

                                @endforeach--}}
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
                    <input type="button" class="btn btn-primary pull-right btn-form-sub" value="Renew" style="display: none"/>
                </div>
                {!!Form::close()!!}
        </div>
    </div>

<script type="text/javascript">

    window.onload = function () {

        var CSRF_TOKEN = "<?php echo csrf_token() ?>";
        $('#subscription_years, #subscription_type').on('change', function (e) {
            e.preventDefault();
            var subscription_years = $('#subscription_years').val();
            var subscription_type = $('#subscription_type').val();
            $.post("<?php echo url('agency/get_subscription_amount') ?>", {
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

    $(document).on('click', '.btn-form-sub', function(e) {
        e.preventDefault();
        $( ".subs-form" ).submit();
    });

    $('.payment_type').on('change', function (e) {
        if ($(this).val() == 'Credit Card') {
            $('.stripe-button-el').show();
            $('.btn-form-sub').hide();
        } else {
            $('.stripe-button-el').hide();
            $('.btn-form-sub').show();
        }
    });
</script>

@stop