@extends('layouts.tenant')
@section('title', 'Application Cancel')
@section('heading', '<h1>Application - <small>Cancel</small></h1>')
@section('breadcrumb')
    @parent
    <li><a href="{{url($tenant_id.'/clients')}}" title="All Applications"><i class="fa fa-users"></i> Applications</a>
    </li>
    <li>Cancel</li>
@stop


@section('content')
    <div class="col-md-12">

        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Application Cancel Details</h3>
            </div>
            <div class="box-body">
                {!! Form::model($application, [
                            'class'=>'form-horizontal',
                            'route'=>['application.cancel', $tenant_id, $application->application_id]
                ])!!}

                <div class="form-group">
                    {{ Form::label('institute_name', 'Institute Name', ['class'=>'col-md-3 form-label text-right'])}}
                    <div class="col-md-9">
                        {{ $application->company_name }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('course_name', 'Course Name', ['class'=>'col-md-3 form-label text-right'])}}
                    <div class="col-md-9">
                        {{ $application->course_name }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('description', 'Notes', ['class'=>'col-md-3 form-label text-right'])}}
                    <div class="col-md-9">
                        {{ Form::textarea('description', null, ['class'=>'col-md-6','rows'=>5])}}
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-9 col-md-offset-3">
                        {{ Form::submit('Submit',['class'=>'btn btn-primary'])}}
                    </div>
                </div>

                {!! Form::close()!!}
            </div>
        </div>
    </div>
@stop
					 




