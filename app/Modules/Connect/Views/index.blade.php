@extends('layouts.main')
@section('title', 'Send Emails')
@section('heading', 'Send Emails')
@section('breadcrumb')
    @parent
    <li><a href="{{url('connect')}}" title="Send Emails"><i class="fa fa-paper-plane"></i> Send Emails</a></li>
@stop
@section('content')
    <div class="col-xs-12">
        @include('flash::message')
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Send Emails</h3>
            </div>
            {!! Form::open(['url' => 'connect/index', 'method' => 'post']) !!}
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('email_ids', 'Select email recipients', ['class' => 'control-label']) }}
                            {!! Form::select('email_ids[]', $email_ids, null,['class' => 'form-control', 'id' => 'email_ids', 'multiple' => 'multiple']) !!}
                        </div>
                        <div class="form-group">
                            {{ Form::label('subject', 'Email subject', ['class' => 'control-label']) }}
                            {!! Form::text('subject', '', ['class' => 'form-control', 'id' => 'subject']) !!}
                        </div>
                        <div class="form-group">
                            {{ Form::label('message', null, ['class' => 'control-label']) }}
                            {!! Form::textarea('message', '', ['class' => 'form-control', 'id' => 'message']) !!}
                        </div>
                        <div class="form-group">
                            {{ Form::submit('Send', ['class' => 'btn btn-primary']) }}
                        </div>
                    </div>
                </div>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
@stop