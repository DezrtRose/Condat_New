<?php $current = Request::segment(4); ?>
<div class="container">
    <div class="row">
        <div class="client-navbar" style="display: none;">
            <div class="col-sm-12 col-md-2">
                <div class="container">
                    <img src="https://scontent-lax3-1.xx.fbcdn.net/v/t1.0-9/1936510_10207216981375364_4596889339024157957_n.jpg?oh=f3031e9add8769ca489e5865a54b6bc4&oe=57B0E02E"
                         class="img-rounded" alt="Cinque Terre" width="150" height="150">
                </div>
            </div>
            <div class="col-sm-12 col-md-10">
                <div class="row">

                    <h4><?php echo e($client->first_name); ?> <?php echo e($client->middle_name); ?> <b><?php echo e($client->last_name); ?></b></h4>

                    <p>University of Western Sydney</p>

                    <p>
                        Graduate Diploma of Professional Accounting
                    </p>
                </div>
                <div class="row">
                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                            <li><a href=<?php echo e(url("tenant/clients/$application->client_id")); ?>>Dashboard</a></li>
                            <li><a href=<?php echo e(url("tenant/clients/$application->client_id/personal_details")); ?>>Personal
                                    Details</a></li>
                            <li class="active"><a href=<?php echo e(url("tenant/clients/$application->client_id/applications")); ?>>College
                                    Application</a></li>
                            <li><a href=<?php echo e(url("tenant/clients/$application->client_id/accounts")); ?>>Accounts</a></li>
                            <li><a href=<?php echo e(url("tenant/clients/$application->client_id/document")); ?>>Documents</a></li>
                            <li><a href=<?php echo e(url("tenant/clients/$application->client_id/notes")); ?>>Notes</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <span class="btn btn-success btn-small btn-flat menu-toggle"><i class="fa fa-bars"></i> Toggle Client Menu</span>
    </div>
    <div class="row">
        <?php /*<div class="menu-opener">
            <span class="menu-opener-inner"></span>
        </div>*/ ?>
    </div>

    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#navbar"
                        aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand visible-xs" href="#">AMS</a>
            </div>

            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="<?php echo e(($current == 'show')? 'active' : ''); ?>"><a href="#">Dashboard</a></li>
                    <li><a href="#">Application Details</a></li>
                    <li class="<?php echo e(($current == 'college')? 'active' : ''); ?>"><a href="<?php echo e(route('tenant.application.college', $application->application_id)); ?>">College Accounts</a></li>
                    <li class="<?php echo e(($current == 'students')? 'active' : ''); ?>"><a href="<?php echo e(route('tenant.application.students', $application->application_id)); ?>">Students Accounts</a></li>
                    <li class="<?php echo e(($current == 'subagents')? 'active' : ''); ?>"><a href="<?php echo e(route('tenant.application.subagents', $application->application_id)); ?>">Sub Agent Accounts</a></li>
                    <li><a href="#">Documents</a></li>
                    <li><a href="#">Notes</a></li>
                </ul>
            </div>
            <!--/.nav-collapse -->

        </div>
        <!--/.container-fluid -->
    </nav>

    <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total Invoice Amount</span>
                    <span class="info-box-number">$<?php echo e($stats['invoice_amount']); ?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-google-plus"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total Paid Amount</span>
                    <span class="info-box-number">$<?php echo e($stats['total_paid']); ?></span>
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
                    <span class="info-box-number">$<?php echo e($stats['due_amount']); ?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div>
    <?php echo $__env->make('flash::message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</div>

<script class="cssdeck" type="text/javascript">
    /*$(".menu-opener").click(function () {
        $(".menu-opener").toggleClass("active");
        $(".client-navbar, .menu-opener-inner").slideToggle();
    });*/

    $(".menu-toggle").click(function () {
        $(".client-navbar").slideToggle();
    });
</script>