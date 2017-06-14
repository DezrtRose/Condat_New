@extends('layouts.new_design')
@section('title', 'Condat - 404 Page')
@section('heading', 'Condat - 404 Page')
@section('content')


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link href="{{ asset('assets/css/AdminLTE.css') }}" rel="stylesheet" type="text/css"/>

    {{-- Load Essential JS --}}
    <script src="{{ asset('assets/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>


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
                    <div class="error-page">
                        <h2 class="headline text-yellow"> 404</h2>

                        <div class="error-content text-white" style="padding: 15px;">
                            <h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>

                            <p>
                                We could not find the page you were looking for. It might have been deleted.
                                <br/><br/>Meanwhile, you may <a href="javascript:history.back()">return back</a>.
                            </p>
                        </div>
                        <!-- /.error-content -->
                    </div>
                    </div>
                </div><!--//row-->
            </div><!--//container-->
        </section><!--//signup-section-->
    </div>
@stop
