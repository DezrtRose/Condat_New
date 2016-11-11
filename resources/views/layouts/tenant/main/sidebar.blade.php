<aside class="main-sidebar">
    <section class="sidebar">

        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="treeview">
                <a href="{{url($tenant_id.'/users/dashboard')}}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>Clients</span>
                    <span class="label label-primary pull-right">{{get_total_count('C')}}</span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{url($tenant_id.'/clients')}}"><i class="fa fa-circle-o"></i> View All</a></li>
                    <li><a href="{{url($tenant_id.'/clients/create')}}"><i class="fa fa-circle-o"></i> Add</a></li>
                    <li><a href="{{url($tenant_id.'/clients')}}"><i class="fa fa-circle-o"></i> Advanced Search</a></li>
                    <li><a href="{{url($tenant_id.'/clients/create')}}"><i class="fa fa-circle-o"></i> Due Payments</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-money"></i>
                    <span>Enrollment</span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{url($tenant_id.'/applications/enquiry')}}"><i class="fa fa-circle-o"></i> Enrollment List</a></li>
                    <li><a href="{{url('payment/create')}}"><i class="fa fa-circle-o"></i> Filter Enrollment</a></li>
                    <li><a href="{{url('payment/search')}}"><i class="fa fa-circle-o"></i> Enrollment Statistics</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-money"></i>
                    <span>Accounts</span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{url($tenant_id.'/client_invoice_report/invoice_pending')}}"><i class="fa fa-circle-o"></i> Client Invoices</a></li>
                    <li><a href="{{url($tenant_id.'/college_invoice_report/invoice_pending')}}"><i class="fa fa-circle-o"></i> Institute Invoices</a></li>
                    <li><a href="{{url($tenant_id.'/client/payments')}}"><i class="fa fa-circle-o"></i> Payments</a></li>
                    <li><a href="{{url($tenant_id.'/college_invoice_report/group_invoice')}}"><i class="fa fa-circle-o"></i> Group Invoice</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-building"></i>
                    <span>Institutions</span>
                    <span class="label label-primary pull-right">{{get_total_count('I')}}</span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{url($tenant_id.'/institute')}}"><i class="fa fa-circle-o"></i> Institute List</a></li>
                    <li><a href="{{url($tenant_id.'/institute/create')}}"><i class="fa fa-circle-o"></i> Add Institutes</a></li>
                    <li><a href="{{url($tenant_id.'/institute/search')}}"><i class="fa fa-circle-o"></i> Search Course</a></li>
                </ul>
            </li>
            {{--<li class="treeview">
                <a href="#">
                    <i class="fa fa-money"></i>
                    <span>Reports</span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{url('payment')}}"><i class="fa fa-circle-o"></i> Payment Record</a></li>
                    <li><a href="{{url('payment/create')}}"><i class="fa fa-circle-o"></i> Client Payment Due</a></li>
                    <li><a href="{{url('payment/search')}}"><i class="fa fa-circle-o"></i> Students by SubAgent</a></li>
                    <li><a href="{{url('payment/search')}}"><i class="fa fa-circle-o"></i> Financial Statistics</a></li>
                </ul>
            </li>--}}
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>Agents</span>
                    <span class="label label-primary pull-right">{{get_total_count('Ag')}}</span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{url($tenant_id.'/agents')}}"><i class="fa fa-circle-o"></i> View All</a></li>
                    <li><a href="{{url($tenant_id.'/agents/create')}}"><i class="fa fa-circle-o"></i> Add</a></li>
                </ul>
            </li>
            {{--<li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>Mailbox</span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{url($tenant_id.'/agents')}}"><i class="fa fa-circle-o"></i> Compose</a></li>
                    <li><a href="{{url($tenant_id.'/agents/create')}}"><i class="fa fa-circle-o"></i> All Sent</a></li>
                </ul>
            </li>--}}
            @if($current_user->role_type != 'staff')
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-users"></i>
                        <span>Users</span>
                        <span class="label label-primary pull-right">{{get_total_count('TU')}}</span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{url($tenant_id.'/user')}}"><i class="fa fa-circle-o"></i> View All</a></li>
                        <li><a href="{{url($tenant_id.'/user/create')}}"><i class="fa fa-circle-o"></i> Add</a></li>
                    </ul>
                </li>
            @endif
            @if($current_user->role_type != 'staff')
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-gears"></i>
                        <span>Settings</span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{url($tenant_id.'/settings/company')}}"><i class="fa fa-circle-o"></i> Company Profile</a></li>
                        <li><a href="{{url('settings/subscription')}}"><i class="fa fa-circle-o"></i> Agent Setup</a></li>
                        <li><a href="{{url('settings/subscription')}}"><i class="fa fa-circle-o"></i> Email Setup</a></li>
                        <li><a href="{{url($tenant_id.'/settings/bank')}}"><i class="fa fa-circle-o"></i> Bank Details</a></li>
                        <li><a href="{{url('settings/subscription')}}"><i class="fa fa-circle-o"></i> Subscription</a></li>
                    </ul>
                </li>
            @endif
            <li id="renew-subscription">
                <a href="{{url($tenant_id.'/subscription/renew')}}"><i class="fa fa-warning"></i><span>Add/Renew Subscription</span></a>
            </li>
        </ul>
    </section>
</aside>