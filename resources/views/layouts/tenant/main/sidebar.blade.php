<aside class="main-sidebar">
    <section class="sidebar">

        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            @if($current_user->level_value > 4) {{-- Not Accountant --}}
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
                    {{--<li><a href="{{url($tenant_id.'/clients')}}"><i class="fa fa-circle-o"></i> Advanced Search</a></li>--}}
                    <li><a href="{{url($tenant_id.'/import')}}"><i class="fa fa-circle-o"></i> Import</a></li>
                    <li><a href="{{url($tenant_id.'/client/due')}}"><i class="fa fa-circle-o"></i> Due Payments</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-money"></i>
                    <span>Applications</span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{url($tenant_id.'/applications/enquiry')}}"><i class="fa fa-circle-o"></i> Application List</a></li>
                    <li><a href="{{route('applications.search.index', $tenant_id)}}"><i class="fa fa-circle-o"></i> Filter Application</a></li>
                </ul>
            </li>
            @endif
            @if($current_user->level_value != 6) {{-- Except Consultant--}}
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-money"></i>
                    <span>Accounts</span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{url($tenant_id.'/client_invoice_report/invoice_pending')}}"><i class="fa fa-circle-o"></i> Client Invoices</a></li>
                    <li><a href="{{url($tenant_id.'/college_invoice_report/invoice_pending')}}"><i class="fa fa-circle-o"></i> Institute Invoices</a></li>
                    <li><a href="{{url($tenant_id.'/client/payments')}}"><i class="fa fa-circle-o"></i> Payments</a></li>
                    <li><a href="{{url($tenant_id.'/college_invoice_report/invoice_grouped')}}"><i class="fa fa-circle-o"></i> Group Invoice</a></li>
                </ul>
            </li>
            @endif
            @if($current_user->level_value > 4) {{-- Not Accountant --}}
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-building"></i>
                    <span>Institutions</span>
                    <span class="label label-primary pull-right">{{get_total_count('I')}}</span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{url($tenant_id.'/institute')}}"><i class="fa fa-circle-o"></i> Institute List</a></li>
                    <li><a href="{{url($tenant_id.'/institute/create')}}"><i class="fa fa-circle-o"></i> Add Institutes</a></li>
                    <li><a href="{{url($tenant_id.'/course/search')}}"><i class="fa fa-circle-o"></i> Search Course</a></li>
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
            @if($current_user->level_value > 8) {{-- Only Admin --}}
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>Users </span>
                    <span class="label label-primary pull-right">{{get_total_count('TU')}}</span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{url($tenant_id.'/user')}}"><i class="fa fa-circle-o"></i> View All</a></li>
                    <li><a href="{{url($tenant_id.'/user/create')}}"><i class="fa fa-circle-o"></i> Add</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="{{url($tenant_id.'/email')}}">
                    <i class="fa fa-envelope"></i> <span>Bulk Email</span>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-gears"></i>
                    <span>Settings</span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{url($tenant_id.'/settings/company')}}"><i class="fa fa-circle-o"></i> Company Profile</a></li>
                    {{--<li><a href="{{url('settings/subscription')}}"><i class="fa fa-circle-o"></i> Agent Setup</a></li>--}}
                    <li><a href="{{url($tenant_id.'/settings/send_email')}}"><i class="fa fa-circle-o"></i> Send Email</a></li>
                    <li><a href="{{url($tenant_id.'/settings/bank')}}"><i class="fa fa-circle-o"></i> Bank Details</a></li>
                    <li id="renew-subscription"><a href="{{url($tenant_id.'/subscription/renew')}}"><i class="fa fa-circle-o"></i> Renew Subscription</a></li>
                </ul>
            </li>
            @endif
        @endif
            {{--<li id="renew-subscription">
                <a href="{{url($tenant_id.'/subscription/renew')}}"><i class="fa fa-warning"></i><span>Add/Renew Subscription</span></a>
            </li>--}}
        </ul>
    </section>
</aside>