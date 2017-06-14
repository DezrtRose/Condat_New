@extends('layouts.min')
@section('title', 'Login')
@section('content')
    <!-- Datatable css -->
    <link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/filter.css')}}" rel="stylesheet" type="text/css"/>

    <div class="login-box" style="width: 1200px">
        <div class="login-logo">
            <a href="">Consultancy Database</a>
        </div>

        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Find a link for your company to Log in.</p>

            {{--<table class="table" id="agencies">
                <thead>
                <tr>
                    <th>Company Name</th>
                    <th>Link</th>
                </tr>
                </thead>
                @foreach($agencies as $key => $agency)
                    <tr>
                        <td>{{ $agency->name }}</td>
                        <td><a href="{{ route('tenant.login', $agency->agency_id) }}">{{ route('tenant.login', $agency->agency_id) }}</a></td>
                    </tr>
                @endforeach
            </table>--}}

            <div class="container">
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
                                    <span class="info-box-icon bg-aqua"><i class="ion ion-ios-people-outline"></i></span>
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

        </div>
        <div class="login-box-footer">
            <p class="text-center">
                <small>&copy; copyright {{date('Y')}} | Condat</small>
            </p>
        </div>
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
