@extends('layouts.tenant')
@section('title', 'Update Payment')
@section('breadcrumb')
    @parent
    <li><a href="{{url($tenant_id.'/clients')}}" title="All Clients"><i class="fa fa-users"></i> Clients</a></li>
    <li>Update</li>
@stop
@section('content')
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Update Payment</h3>
            </div>
            @include('flash::message')
            {!!Form::model($payment, array('route' => ['client.payment.update', $tenant_id, $payment->client_payment_id], 'class' => 'form-horizontal form-left'))!!}
            @include('Tenant::Client/Payment/form')
            <div class="box-footer clearfix">
                <input type="submit" class="btn btn-primary pull-right" value="Update"/>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
@stop