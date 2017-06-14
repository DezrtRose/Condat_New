<header class="main-header">
    <!-- Logo -->
    <a href="{{ route('users.dashboard', $tenant_id) }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>C</b>S</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Condat</b> Solutions</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <ol class="tenant-breadcrumb">
            @section('breadcrumb')
                <li><a href="{{ route('users.dashboard', $tenant_id) }}" data-push="true"><i class="fa fa-dashboard"></i> Home </a></li>
            @show
        </ol>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-warning">{{ count($alerts) }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header"><i class="fa fa-warning text-yellow"></i> You have {{ count($alerts) }} alerts.</li>
                        <li>
                            <!-- inner menu: contains the actual data -->

                            <ul class="menu normal-wrap">
                                @foreach($alerts as $key => $alert)
                                <li>
                                    {!! $alert !!}
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        {{--<li class="footer"><a href="#">View all</a></li>--}}
                    </ul>
                </li>
                <li class="dropdown tasks-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                        <i class="fa fa-flag-o"></i>
                        <span class="label label-danger reminder-count">{{ count($reminders) }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have <span class="reminder-count">{{ count($reminders) }}</span>
                            reminder(s).
                        </li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                @if(count($reminders) > 0)
                                    @foreach($reminders as $key => $reminder)
                                        <li><!-- Task item -->
                                            <a href="{{route('tenant.client.show', [$tenant_id, $reminder->client_id])}}">
                                                <h3>
                                                    <input type="checkbox" class="icheck com-reminder" id="{{ $reminder->notes_id }}" />
                                                    <span data-toggle="tooltip" data-placement="bottom" title="{{$reminder->description}}">{{ trim(substr($reminder->description, 0, 40)) }}@if(strlen($reminder->description) > 40) {{'...'}}@endif</span>
                                                    <span class="col-md-12">
                                                        <span class="col-md-6"><small>{{$reminder->first_name . ' ' . $reminder->last_name}}</small></span>
                                                        <span class="col-md-6 text-right"><small>{{ format_date($reminder->reminder_date) }}</small></span>
                                                    </span>
                                                </h3>
                                            </a>
                                        </li>
                                    @endforeach
                                @else
                                    <p class="text-muted well">
                                        No upcoming reminders.
                                    </p>
                            @endif
                            <!-- end task item -->
                            </ul>
                        </li>
                        {{--<li class="footer">
                            <a href="#">View all tasks</a>
                        </li>--}}
                    </ul>
                </li>
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        {{--<img src="../../dist/img/user2-160x160.jpg" class="user-image" alt="User Image">--}}
                        <span class="hidden-xs">{{$current_user->full_name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <p>
                                {{ $current_user->full_name }}
                                <small>Member since {{shorten_date($current_user->created_at)}}</small>
                                <small>User ID {{format_id($current_user->user_id, 'U')}}</small>
                                <small>{{ $current_user->role_type }}</small> {{--fix this later--}}
                                <small>{{ $company['company_name'] or '' }}</small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{route('tenant.user.edit', [$tenant_id, $current_user->user_id])}}" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{route('tenant.logout', $tenant_id)}}" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>