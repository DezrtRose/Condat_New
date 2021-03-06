@extends('layouts.tenant')
@section('title', 'Application COE Issued')
@section('heading', '<h1>Application - <small>COE Issued</small></h1>')
@section('breadcrumb')
    @parent
    <li><a href="{{url($tenant_id.'/clients')}}" title="All Applications"><i class="fa fa-users"></i> Applications</a>
    </li>
    <li>COE Issued</li>
@stop


@section('content')
    <div class="col-md-12">

        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Application Offer Details</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-7 col-md-offset-1">
                        {!! Form::model($application, ['class'=>'form-horizontal', 'method'=>'POST', 'route'=>['applications.action.update.coe.issued', $tenant_id, $application->application_id], 'files'=>true])!!}

                        <div class="form-group @if($errors->has('tuition_fee')) {{'has-error'}} @endif">
                            {!! Form::label('tuition_fee', 'Total Tuition Fee', ['class'=>'col-md-3 form-label text-right']) !!}
                            <div class="col-md-9">
                                {!!Form::text('tuition_fee', null, array('class' => 'form-control', 'id'=>'tuition_fee'))!!}
                                @if($errors->has('tuition_fee'))
                                    {!! $errors->first('tuition_fee', '<label class="control-label"
                                                                              for="inputError">:message</label>') !!}
                                @endif
                            </div>
                        </div>

                        <div class="form-group">

                            <label for="intake" class="col-sm-3 control-label">Select Intake</label>

                            <div class="col-sm-9">
                                {!!Form::select('intake_id', $intakes, null, array('class' => 'form-control intake', 'id' => 'intake'))!!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="end_date" class="col-sm-3 control-label">Finish Date</label>

                            <div class="col-sm-9">
                                <div class='input-group date'>
                                    @if(isset($application->end_date) && $application->end_date != null)
                                        {!!Form::text('end_date', format_date($application->end_date), array('class' => 'form-control datepicker', 'id'=>'end_date'))!!}
                                    @else
                                        {!!Form::text('end_date', null, array('class' => 'form-control datepicker', 'id'=>'end_date'))!!}
                                    @endif
                                    <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group @if($errors->has('document')) {{'has-error'}} @endif">
                            {{ Form::label('document', 'Upload COE', ['class'=>'col-md-3 form-label text-right'])}}
                            <div class="col-md-9">
                                {{ Form::file('document')}}
                                @if($errors->has('document'))
                                    {!! $errors->first('document', '<label class="control-label"
                                                                              for="inputError">:message</label>') !!}
                                @endif
                            </div>
                        </div>

                        <div class="form-group @if($errors->has('description')) {{'has-error'}} @endif">
                            {{ Form::label('description', 'Notes', ['class'=>'col-md-3 form-label text-right'])}}
                            <div class="col-md-9">
                                {{ Form::textarea('description', 'COE Issued', ['class'=>'form-control', 'placeholder'=>'Description'])}}
                                @if($errors->has('description'))
                                    {!! $errors->first('description', '<label class="control-label"
                                                                              for="inputError">:message</label>') !!}
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::submit('Submit',['class'=>'btn btn-primary pull-right'])}}
                            {{ Form::submit('Submit & Continue to Invoice',['class'=>'btn btn-success pull-left'])}}
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ Condat::js("$('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true,
        todayHighlight: true
    });"
    )
    }}
@stop




