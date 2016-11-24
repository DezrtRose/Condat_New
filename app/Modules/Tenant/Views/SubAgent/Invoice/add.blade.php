@extends('layouts.tenant')
@section('title', 'Add Invoice')
@section('breadcrumb')
    @parent
    <li><a href="{{url($tenant_id.'/clients')}}" title="All Clients"><i class="fa fa-users"></i> Clients</a></li>
    <li>Add</li>
@stop
@section('content')

    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Add Invoice</h3>
            </div>
            @include('flash::message')
            {!!Form::open(array('route' => ['application.subagents.storeInvoice', $tenant_id, $application_id], 'class' => 'form-horizontal form-left'))!!}
            @include('Tenant::SubAgent/Invoice/form')
            <div class="box-footer clearfix">
                <input type="submit" class="btn btn-primary pull-right" value="Add"/>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
@stop