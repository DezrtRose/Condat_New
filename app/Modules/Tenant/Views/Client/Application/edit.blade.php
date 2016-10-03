@extends('layouts.tenant')
@section('title', 'Application Update')
@section('breadcrumb')
    @parent
    <li><a href="{{url('tenant/client')}}" title="All Clients"><i class="fa fa-users"></i> Clients</a></li>
    <li>View</li>
@stop
@section('content')

    <div class="container">
        <div class="row">
        @include('Tenant::Client/client_header') 
        </div>
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Application -
                        <small>Edit</small>
                    </h3>
                </div>
                {!!Form::model($application, array('route' => ['tenant.application.store', $application->course_application_id], 'class' => 'form-horizontal form-left'))!!}
                <div class="box-body">
                    @include('Tenant::Client/Application/form')
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right">Update</button>
                </div>
                {!!Form::close()!!}
            </div>
        </div>

    </div>

@stop
