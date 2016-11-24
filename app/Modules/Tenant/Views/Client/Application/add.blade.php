@extends('layouts.tenant')
@section('title', 'Client View')
@section('breadcrumb')
    @parent
    <li><a href="{{url('tenant/client')}}" title="All Clients"><i class="fa fa-users"></i> Clients</a></li>
    <li>View</li>
@stop
@section('content')

    @include('Tenant::Client/client_header')
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Application -
                    <small>Add</small>
                </h3>
            </div>
            {!!Form::open(array('route' => ['tenant.application.store', $tenant_id, $client->client_id], 'class' => 'form-horizontal form-left'))!!}
            <div class="box-body">
                @include('Tenant::Client/Application/form')
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right">Submit</button>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
@stop
