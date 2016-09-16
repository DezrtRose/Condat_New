<aside class="main-sidebar">
    <section class="sidebar">

        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="treeview">
                <a href="{{url('dashboard')}}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-industry"></i>
                    <span>Agencies</span>
                    <span class="label label-primary pull-right">{{get_total_count('A')}}</span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{url('agency')}}"><i class="fa fa-circle-o"></i> View All</a></li>
                    <li><a href="{{url('agency/create')}}"><i class="fa fa-circle-o"></i> Add</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-money"></i>
                    <span>Payment</span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{url('payment')}}"><i class="fa fa-circle-o"></i> List Payment</a></li>
                    <li><a href="{{url('payment/create')}}"><i class="fa fa-circle-o"></i> Add Payment</a></li>
                    <li><a href="{{url('payment/search')}}"><i class="fa fa-circle-o"></i> Advanced Search</a></li>
                    <li><a href="{{url('payment/recent')}}"><i class="fa fa-circle-o"></i> Recent Payment</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>Users</span>
                    <span class="label label-primary pull-right">{{get_total_count('U')}}</span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{url('user')}}"><i class="fa fa-circle-o"></i> View All</a></li>
                    <li><a href="{{url('user/create')}}"><i class="fa fa-circle-o"></i> Add</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-gears"></i>
                    <span>Settings</span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{url('settings/email')}}"><i class="fa fa-circle-o"></i> Email Settings</a></li>
                    <li><a href="{{url('settings/templates')}}"><i class="fa fa-circle-o"></i> Email Templates</a></li>
                    <li><a href="{{url('settings')}}"><i class="fa fa-circle-o"></i> Company Profile</a></li>
                    <li><a href="{{url('settings/subscription')}}"><i class="fa fa-circle-o"></i> Subscription Fee</a></li>
                </ul>
            </li>
            <li class="header">LABELS</li>
            <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
        </ul>
    </section>
</aside>