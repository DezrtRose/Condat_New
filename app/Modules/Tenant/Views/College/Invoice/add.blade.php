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
            {!!Form::open(array('route' => ['tenant.application.storeInvoice', $tenant_id, $application_id], 'class' => 'form-horizontal form-left', 'autocomplete' => 'off'))!!}
            @include('Tenant::College/Invoice/form')
            <div class="box-footer clearfix">
                {{--<a class="btn btn-success pull-left" data-toggle="modal" data-target="#condat-modal" data-url="{{ route('tenant.college.moreInvoice', [$tenant_id, $application_id]) }}">Submit & Create More Invoices</a>--}}
                <input type="submit" name="more" class="btn btn-success pull-left" value="Submit & Create More Invoices"/>
                <input type="submit" name="submit" class="btn btn-primary pull-right" value="Submit"/>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
    {!! Condat::registerModal() !!}
@stop