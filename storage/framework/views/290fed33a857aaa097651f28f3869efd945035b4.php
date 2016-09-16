<aside class="main-sidebar">
    <section class="sidebar">

        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="treeview">
                <a href="<?php echo e(url('dashboard')); ?>">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>Clients</span>
                    <span class="label label-primary pull-right"><?php echo e(get_total_count('C')); ?></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo e(url('tenant/clients')); ?>"><i class="fa fa-circle-o"></i> View All</a></li>
                    <li><a href="<?php echo e(url('tenant/clients/create')); ?>"><i class="fa fa-circle-o"></i> Add</a></li>
                    <li><a href="<?php echo e(url('tenant/clients')); ?>"><i class="fa fa-circle-o"></i> Advanced Search</a></li>
                    <li><a href="<?php echo e(url('tenant/clients/create')); ?>"><i class="fa fa-circle-o"></i> Due Payments</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-money"></i>
                    <span>Enrollment</span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo e(url('payment')); ?>"><i class="fa fa-circle-o"></i> Enrollment List</a></li>
                    <li><a href="<?php echo e(url('payment/create')); ?>"><i class="fa fa-circle-o"></i> Filter Enrollment</a></li>
                    <li><a href="<?php echo e(url('payment/search')); ?>"><i class="fa fa-circle-o"></i> Enrollment Statistics</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-money"></i>
                    <span>Invoice</span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo e(url('payment')); ?>"><i class="fa fa-circle-o"></i> Invoice List</a></li>
                    <li><a href="<?php echo e(url('payment/create')); ?>"><i class="fa fa-circle-o"></i> Filter Invoices</a></li>
                    <li><a href="<?php echo e(url('payment/search')); ?>"><i class="fa fa-circle-o"></i> Invoice Statistics</a></li>
                    <li><a href="<?php echo e(url('payment/search')); ?>"><i class="fa fa-circle-o"></i> Group Invoice</a></li>
                    <li><a href="<?php echo e(url('payment/search')); ?>"><i class="fa fa-circle-o"></i> Create Group Invoice</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-building"></i>
                    <span>Institutions</span>
                    <span class="label label-primary pull-right"><?php echo e(get_total_count('I')); ?></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo e(url('tenant/institute')); ?>"><i class="fa fa-circle-o"></i> Institute List</a></li>
                    <li><a href="<?php echo e(url('tenant/institute/create')); ?>"><i class="fa fa-circle-o"></i> Add Institutes</a></li>
                    <li><a href="<?php echo e(url('tenant/institute/search')); ?>"><i class="fa fa-circle-o"></i> Search Course</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-money"></i>
                    <span>Reports</span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo e(url('payment')); ?>"><i class="fa fa-circle-o"></i> Payment Record</a></li>
                    <li><a href="<?php echo e(url('payment/create')); ?>"><i class="fa fa-circle-o"></i> Client Payment Due</a></li>
                    <li><a href="<?php echo e(url('payment/search')); ?>"><i class="fa fa-circle-o"></i> Students by SubAgent</a></li>
                    <li><a href="<?php echo e(url('payment/search')); ?>"><i class="fa fa-circle-o"></i> Financial Statistics</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>Agents</span>
                    <span class="label label-primary pull-right"><?php echo e(get_total_count('Ag')); ?></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo e(url('tenant/agents')); ?>"><i class="fa fa-circle-o"></i> View All</a></li>
                    <li><a href="<?php echo e(url('tenant/agents/create')); ?>"><i class="fa fa-circle-o"></i> Add</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>Users</span>
                    <span class="label label-primary pull-right"><?php echo e(get_total_count('U')); ?></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo e(url('tenant/user')); ?>"><i class="fa fa-circle-o"></i> View All</a></li>
                    <li><a href="<?php echo e(url('tenant/user/create')); ?>"><i class="fa fa-circle-o"></i> Add</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-gears"></i>
                    <span>Settings</span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo e(url('settings')); ?>"><i class="fa fa-circle-o"></i> Company Profile</a></li>
                    <li><a href="<?php echo e(url('settings/subscription')); ?>"><i class="fa fa-circle-o"></i> Agent Setup</a></li>
                    <li><a href="<?php echo e(url('settings/subscription')); ?>"><i class="fa fa-circle-o"></i> Email Setup</a></li>
                    <li><a href="<?php echo e(url('settings/subscription')); ?>"><i class="fa fa-circle-o"></i> Bank Details</a></li>
                    <li><a href="<?php echo e(url('settings/subscription')); ?>"><i class="fa fa-circle-o"></i> Subscription</a></li>
                </ul>
            </li>
            <li class="header">LABELS</li>
            <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
        </ul>
    </section>
</aside>