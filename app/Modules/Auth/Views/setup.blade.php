@extends('layouts.min')
@section('title', 'Login')
@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href="">Consultancy Database</a>
        </div>

        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Setup Account</p>
            @if(Session::has('message'))
                <div class="callout callout-danger">
                    <h4>Invalid Login</h4>

                    <p>{{Session::get('message')}}</p>
                </div>
            @endif
            @if(Session::has('message_success'))
                <div class="callout callout-success">

                    <p>{{Session::get('message_success')}}</p>
                </div>
            @endif
            <form action="{{url($tenant_id.'/complete')}}" method="post">

                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input type="hidden" name="tenant" value="{{$tenant_id}}">

                <div class="form-group has-feedback">
                    <input type="text" class="form-control" name="email" placeholder="Email"
                           value="{{$agent_data->email}}" readonly/>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

                </div>
                <div class="form-group has-feedback @if($errors->has('first_name')) {{'has-error'}} @endif">
                    {!!Form::text('first_name', $agent_data->first_name, array('class' => 'form-control', 'id'=>'first_name', 'placeholder' => 'First Name *'))!!}
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    @if($errors->has('first_name'))
                        {!! $errors->first('first_name', '<label class="control-label"
                                                               for="inputError">:message</label>') !!}
                    @endif
                </div>
                <div class="form-group has-feedback @if($errors->has('last_name')) {{'has-error'}} @endif">
                    {!!Form::text('last_name', $agent_data->last_name, array('class' => 'form-control', 'id'=>'last_name', 'placeholder' => 'Last Name *'))!!}
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    @if($errors->has('last_name'))
                        {!! $errors->first('last_name', '<label class="control-label"
                                                               for="inputError">:message</label>') !!}
                    @endif
                </div>
                <div class="form-group has-feedback @if($errors->has('phone_id')) {{'has-error'}} @endif">
                    {!!Form::text('phone_id', $agent_data->number, array('class' => 'form-control', 'id'=>'phone_id', 'placeholder' => 'Phone Number *'))!!}
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    @if($errors->has('phone_id'))
                        {!! $errors->first('phone_id', '<label class="control-label"
                                                               for="inputError">:message</label>') !!}
                    @endif
                </div>
                <div class="form-group has-feedback @if($errors->has('street')) {{'has-error'}} @endif">
                    {!!Form::text('street', $agent_data->street, array('class' => 'form-control', 'id'=>'street', 'placeholder' => 'Street'))!!}
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    @if($errors->has('street'))
                        {!! $errors->first('street', '<label class="control-label"
                                                               for="inputError">:message</label>') !!}
                    @endif
                </div>
                <div class="form-group has-feedback @if($errors->has('suburb')) {{'has-error'}} @endif">
                    {!!Form::text('suburb', $agent_data->suburb, array('class' => 'form-control', 'id'=>'suburb', 'placeholder' => 'Suburb'))!!}
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    @if($errors->has('suburb'))
                        {!! $errors->first('suburb', '<label class="control-label"
                                                               for="inputError">:message</label>') !!}
                    @endif
                </div>
                <div class="form-group has-feedback @if($errors->has('postcode')) {{'has-error'}} @endif">
                    {!!Form::text('postcode', $agent_data->postcode, array('class' => 'form-control', 'id'=>'postcode', 'placeholder' => 'Postcode'))!!}
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    @if($errors->has('postcode'))
                        {!! $errors->first('postcode', '<label class="control-label"
                                                               for="inputError">:message</label>') !!}
                    @endif
                </div>
                <div class="form-group has-feedback @if($errors->has('state')) {{'has-error'}} @endif">
                    {!!Form::text('state', $agent_data->state, array('class' => 'form-control', 'id'=>'state', 'placeholder' => 'State'))!!}
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    @if($errors->has('state'))
                        {!! $errors->first('state', '<label class="control-label"
                                                               for="inputError">:message</label>') !!}
                    @endif
                </div>
                <div class="form-group has-feedback @if($errors->has('country_id')) {{'has-error'}} @endif">
                    {!!Form::select('country_id', config('constants.countries'), $agent_data->country_id, array('class' =>
                    'form-control'))!!}
                    @if($errors->has('country_id'))
                        {!! $errors->first('country_id', '<label class="control-label"
                                                              for="inputError">:message</label>') !!}
                    @endif
                </div>
                <div class="form-group has-feedback @if($errors->has('password')) {{'has-error'}} @endif">
                    <input type="password" name="password" class="form-control" placeholder="Password *"/>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @if($errors->has('password'))
                        {!! $errors->first('password', '<label class="control-label"
                                                               for="inputError">:message</label>') !!}
                    @endif
                </div>
                <div class="form-group has-feedback @if($errors->has('repassword')) {{'has-error'}} @endif">
                    <input type="password" name="repassword" class="form-control" placeholder="Re-enter Password *"/>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @if($errors->has('repassword'))
                        {!! $errors->first('repassword', '<label class="control-label"
                                                               for="inputError">:message</label>') !!}
                    @endif
                </div>
                <div class="form-group has-feedback @if($errors->has('sex')) {{'has-error'}} @endif">
                    {!!Form::label('sex', 'Sex *', array('class' => 'col-sm-4 control-label')) !!}
                    <label>
                        {!!Form::radio('sex', 'Male', null, array('class' => 'iCheck', 'checked'=>'checked'))!!} Male
                    </label>
                    <label>
                        {!!Form::radio('sex', 'Female', null, array('class' => 'iCheck'))!!} Female
                    </label>
                    @if($errors->has('sex'))
                        {!! $errors->first('sex', '<label class="control-label"
                                                               for="inputError">:message</label>') !!}
                    @endif
                </div>
                <div class="row">
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Complete</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
        <div class="login-box-footer">
            <p class="text-center">
                <small>&copy; copyright 2015 | Condat</small>
            </p>
        </div>
    </div>
@stop
