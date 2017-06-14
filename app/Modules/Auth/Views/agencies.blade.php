@extends('layouts.new_design')
@section('title', 'Find And Login Agency')
@section('heading', 'Find And Agency')
@section('content')


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link href="{{ asset('assets/css/AdminLTE.css') }}" rel="stylesheet" type="text/css"/>

    {{-- Load Essential JS --}}
    <script src="{{ asset('assets/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>

    <!-- Filter css -->
    <link href="{{ asset('assets/css/filter.css')}}" rel="stylesheet" type="text/css"/>

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
                            <h3 class="title text-center">Find a link for your company to Log in.</h3>

                            <div class="form-container">
                                <!-- Sort Controls -->
                                <div class="row">
                                    <div class="col-md-6 col-xs-12">
                                        <ul class="sortandshuffle">
                                            Sort controls:
                                            <!-- Basic sort controls consisting of asc/desc button and a select -->
                                            <li class="sort-btn active" data-sortAsc>Asc</li>
                                            <li class="sort-btn" data-sortDesc>Desc</li>
                                            <select data-sortOrder>
                                                {{--<option value="domIndex">
                                                    Position
                                                </option>--}}
                                                <option value="name">
                                                    Agency Name
                                                </option>
                                                <option value="agid">
                                                    Agency ID
                                                </option>
                                            </select>
                                        </ul>
                                    </div>

                                    <div class="col-md-6 col-xs-12">
                                        <!-- Search control -->
                                        <div class="row search-row pull-right">
                                            Search control:
                                            <input type="text" class="filtr-search" name="filtr-search" data-search>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- This is the set up of a basic gallery, your items must have the categories they belong to in a data-category
                                    attribute, which starts from the value 1 and goes up from there -->
                                    <div class="filtr-container">
                                        @foreach($agencies as $key => $agency)
                                            <div class="col-xs-6 col-sm-4 col-md-3 filtr-item" data-category="1, 5" data-name="{{ $agency->name }}" data-agid="{{ format_id($agency->agency_id, 'AG') }}">
                                                <div class="info-box">
                                                    <span class="info-box-icon bg-aqua"><a href="{{ route('tenant.login', $agency->agency_id) }}"><i class="ion ion-ios-people-outline" style="color: #ffffff"></i></a></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text"><a href="{{ route('tenant.login', $agency->agency_id) }}"><strong>ID</strong> {{ format_id($agency->agency_id, 'AG') }}</a></span>
                                                        <span class="info-box-number"><a href="{{ route('tenant.login', $agency->agency_id) }}"><span class="">{{ $agency->name }}</span></a></span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                            </div>
                        </div><!--//form-box-inner-->
                    </div><!--//form-box-->
                </div><!--//row-->
            </div><!--//container-->
        </section><!--//signup-section-->
    </div>

    <!-- Datatable JS -->
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.filterizr.js') }}"></script>

    <script type="text/javascript">
        //$("#agencies").DataTable();

        $(document).ready(function() {
            //Simple filter controls
            $('.simplefilter li').click(function() {
                $('.simplefilter li').removeClass('active');
                $(this).addClass('active');
            });
            //Multifilter controls
            $('.multifilter li').click(function() {
                $(this).toggleClass('active');
            });
            //Sort controls
            $('.sort-btn').click(function() {
                $('.sort-btn').removeClass('active');
                $(this).addClass('active');
            });

            //Initialize filterizr with default options
            $('.filtr-container').filterizr();
        });
    </script>
@stop
