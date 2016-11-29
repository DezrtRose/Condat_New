@extends('layouts.tenant')
@section('title', 'Send Email')
@section('breadcrumb')
    @parent
    <li><a href="{{url($tenant_id.'/settings/send_email')}}" title="Send Email"><i class="fa fa-envelop"></i> Setting</a></li>
    <li>Send Email</li>
@stop
@section('content')

    <div class="container">
        <div class="col-md-12">
            @include('flash::message')
            {!! Form::open() !!}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Compose New Message</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group">
                        {{ Form::label('email_ids', 'Select email recipients', ['class' => 'control-label']) }}
                        {!! Form::select('email_ids[]', $email_ids, null,['class' => 'form-control select2', 'id' => 'email_ids', 'multiple' => 'multiple']) !!}
                    </div>
                    <div class="form-group">
                        {!!Form::text('subject', null, array('class' => 'form-control', 'id'=>'subject', 'placeholder' => "Subject:"))!!}
                        @if($errors->has('subject'))
                            {!! $errors->first('subject', '<label class="control-label"
                                                                     for="inputError">:message</label>') !!}
                        @endif
                    </div>
                    <div class="form-group">
                        {!!Form::textarea('body', null, array('class' => 'form-control', 'id'=>'compose-textarea', 'style' => "height: 300px"))!!}
                        @if($errors->has('body'))
                            {!! $errors->first('body', '<label class="control-label"
                                                                     for="inputError">:message</label>') !!}
                        @endif
                    </div>
                    {{--<div class="form-group">
                        <div class="btn btn-default btn-file">
                            <i class="fa fa-paperclip"></i> Attachment
                            <input type="file" name="attachment">
                        </div>
                        <p class="help-block">Max. 32MB</p>
                    </div>--}}
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="pull-right">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Send</button>
                    </div>
                    <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Discard</button>
                </div>
                <!-- /.box-footer -->
            </div>
        {!! Form::close() !!}
        <!-- /. box -->
        </div>
    </div>

    <script>
        $(function () {
            //Add text editor
            $("#compose-textarea").wysihtml5();
        });
    </script>
@stop