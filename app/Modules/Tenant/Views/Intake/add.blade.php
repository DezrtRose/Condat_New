@extends('layouts.tenant')
@section('title', 'Add Intake')
@section('breadcrumb')
    @parent
    <li><a href="{{url($tenant_id.'/intake')}}" title="All Intakes"><i class="fa fa-graduation-cap"></i> Intakes</a></li>
    <li>Add</li>
@stop
@section('content')
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Intake Details</h3>
            </div>
            @include('flash::message')
            {!!Form::open(array('route' => ['tenant.intake.store', $tenant_id, $institution_id], 'class' => 'form-horizontal form-left form-intake'))!!}
            @include('Tenant::Course/form')
            <div class="box-footer clearfix">
                <input type="submit" class="btn btn-primary pull-right" value="Add"/>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
@stop
