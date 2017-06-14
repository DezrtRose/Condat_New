@extends('layouts.new_design')
@section('title', 'Register Agency')
@section('heading', 'Register Agency')
@section('breadcrumb')
    @parent
    <li><a href="{{url('agency')}}" title="All Agencies"><i class="fa fa-Agencies"></i> Agencies</a></li>
    <li>Register</li>
@stop
@section('content')
    <div class="upper-wrapper">
        <!-- ******HEADER****** -->
        <header class="header">
            <div class="container">
                <h1 class="logo">
                    <a href="http://condat.com.au"><span class="logo-icon"></span><span class="text">Condat</span></a>
                </h1><!--//logo-->

            </div><!--//container-->
        </header><!--//header-->

        <!-- ******Signup Section****** -->
        <section class="signup-section access-section section">
            <div class="container">
                <div class="row">
                    <div class="form-box col-md-12 col-sm-12 col-xs-12 col-md-offset-0 col-sm-offset-0 xs-offset-0">
                        <div class="form-box-inner">
                            <h2 class="title text-center">Sign up now</h2>
                            <div class="form-container">
                                @include('flash::message')
                                {!!Form::open(array('class' => 'form-horizontal form-left'))!!}
                                @include('Agency::form')
                                <button type="submit" class="btn btn-block btn-cta-primary">Sign up</button>
                                <p class="note">By signing up, you agree to our terms of services and privacy policy.</p>
                                {{--<p class="lead">Already have an account? <a class="login-link" id="login-link" href="login.html">Log in</a></p>--}}
                                {!!Form::close()!!}
                            </div>
                        </div><!--//form-box-inner-->
                    </div><!--//form-box-->
                </div><!--//row-->
            </div><!--//container-->
        </section><!--//signup-section-->
    </div>
@stop
