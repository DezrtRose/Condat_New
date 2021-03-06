<?php $current = Request::segment(4); ?>

<div class="container">
    <div class="row">
        <div class="client-navbar" style="display: none;">
            @include('Tenant::Client/client_header')
        </div>
    </div>
    {{--<span class="btn btn-success btn-small btn-flat menu-toggle"><i class="fa fa-bars"></i> Toggle Client Menu</span>--}}

    <div class="row">
        {{--<div class="menu-opener">
            <span class="menu-opener-inner"></span>
        </div>--}}
    </div>

    <div id="cssmenu">
        <ul>
            <li class="brand"><a class="menu-toggle" href="#" target="_blank"><i class="fa fa-user"></i> Show Client
                    Menu</a></li>
            @if($application->application_id)
                <li class="{{($current == 'show')? 'active' : ''}}"><a
                            href="{{route('tenant.application.show', [$tenant_id, $application->application_id])}}">Dashboard</a>
                </li>
                <li class="{{($current == 'details')? 'active' : ''}}"><a
                            href="{{route('tenant.application.details', [$tenant_id, $application->application_id])}}">Application
                        Details</a></li>
                @if($current_user->level_value > 6) {{-- No access to Consultant and Accountant --}}
                <li class="{{($current == 'college')? 'active' : ''}}"><a
                            href="{{route('tenant.application.college', [$tenant_id, $application->application_id])}}">College
                        Accounts</a></li>
                @endif
                <li class="{{($current == 'students')? 'active' : ''}}"><a
                            href="{{route('tenant.application.students', [$tenant_id, $application->application_id])}}">Students
                        Accounts</a></li>
                <li class="{{($current == 'subagents')? 'active' : ''}}"><a
                            href="{{route('tenant.application.subagents', [$tenant_id, $application->application_id])}}">Sub
                        Agent
                        Accounts</a></li>
                <li class="{{($current == 'document')? 'active' : ''}}"><a
                            href="{{route("tenant.application.document", [$tenant_id, $application->application_id])}}">
                        Documents</a></li>
                <li class="{{($current == 'notes')? 'active' : ''}}"><a
                            href="{{route('tenant.application.notes', [$tenant_id, $application->application_id])}}">Notes</a>
                </li>
            @endif
        </ul>
    </div>

    @if(isset($stats))
        <br/>
        <div class="row">
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-file-text"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Total Invoice Amount</span>
                        <span class="info-box-number">{{ format_price($stats['invoice_amount']) }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="ion ion-cash"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Total Paid Amount</span>
                        <span class="info-box-number">{{ format_price($stats['total_paid']) }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Due Amount</span>
                        <span class="info-box-number">{{ format_price($stats['due_amount']) }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>
    @endif
    <br/>
    @include('flash::message')
</div>

<script class="cssdeck" type="text/javascript">
    /*$(".menu-opener").click(function () {
     $(".menu-opener").toggleClass("active");
     $(".client-navbar, .menu-opener-inner").slideToggle();
     });*/

    $(".menu-toggle").click(function (e) {
        e.preventDefault();
        $(".client-navbar").slideToggle();
    });
</script>