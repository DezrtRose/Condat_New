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
            <form action="{{url('tenant/complete')}}" method="post">

                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input type="hidden" name="tenant" value="{{$_GET['tenant']}}">

                <div class="form-group has-feedback">
                    <input type="text" class="form-control" name="email" placeholder="Email"
                           value="{{$agent_email}}" readonly/>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

                </div>
                <div class="form-group has-feedback @if($errors->has('password')) {{'has-error'}} @endif">
                    <input type="password" name="password" class="form-control" placeholder="Password"/>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @if($errors->has('password'))
                        {!! $errors->first('password', '<label class="control-label"
                                                               for="inputError">:message</label>') !!}
                    @endif
                </div>
                <div class="form-group has-feedback @if($errors->has('repassword')) {{'has-error'}} @endif">
                    <input type="password" name="repassword" class="form-control" placeholder="Re-enter Password"/>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @if($errors->has('repassword'))
                        {!! $errors->first('repassword', '<label class="control-label"
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
                <small>&copy; copyright 2015 | Webunisoft</small>
            </p>
        </div>
    </div>
@stop
