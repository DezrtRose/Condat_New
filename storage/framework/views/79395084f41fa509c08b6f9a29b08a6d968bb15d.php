<?php $__env->startSection('title', 'Client View'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    @parent
    <li><a href="<?php echo e(url('tenant/clients')); ?>" title="All Clients"><i class="fa fa-users"></i> Clients</a></li>
    <li>View</li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <div class="container">
        <div class="row">
            <div class="col-sm-2">
                <div class="container">
                    <img src="https://scontent-lax3-1.xx.fbcdn.net/v/t1.0-9/1936510_10207216981375364_4596889339024157957_n.jpg?oh=f3031e9add8769ca489e5865a54b6bc4&oe=57B0E02E"
                         class="img-rounded" alt="Cinque Terre" width="150" height="150">
                </div>
            </div>
            <div class="col-sm-10">
                <div class="row">

                    <h4><?php echo e($client->first_name); ?> <?php echo e($client->middle_name); ?> <b><?php echo e($client->last_name); ?></b></h4>

                    <p>E <?php echo e($client->email); ?> | P <?php echo e($client->number); ?></p>

                    <p>
                        <?php echo e($client->street); ?>

                        <?php echo e($client->suburb); ?>

                        <?php echo e($client->state); ?>

                        <?php echo e($client->postcode); ?>

                        <?php echo e(get_country($client->country_id)); ?>

                    </p>


                </div>
                <div class="row">
                    <nav class="navbar navbar-default">
                        <div class="container-fluid">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                        data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <a class="navbar-brand visible-xs" href="#">AMS</a>
                            </div>

                            <?php echo $__env->make('Tenant::Client/navbar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </div>
                        <!--/.container-fluid -->
                    </nav>

                </div>


            </div>

        </div>
        <div class="col-md-3">


            <div class="row">
                <!-- About Me Box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">General Information</h3>
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">

                        <strong><i class="fa fa-file-text-o margin-r-5"></i> Client ID</strong>

                        <p class="text-muted"><?php echo e(format_id($client->client_id, 'C')); ?></p>

                        <strong><i class="fa fa-calendar margin-r-5"></i> Created At</strong>

                        <p class="text-muted"><?php echo e(format_datetime($client->created_at)); ?></p>

                        <strong><i class="fa fa-calendar margin-r-5"></i> Created By</strong>

                        <p class="text-muted"><?php echo e(format_datetime($client->created_at)); ?></p>

                        <strong><i class="fa fa-file-text-o margin-r-5"></i> Due Amount</strong>

                        <p class="text-muted">200</p>

                        <strong><i class="fa fa-file-text-o margin-r-5"></i> Referred By</strong>

                        <p class="text-muted">Echha Dangol</p>


                    </div>
                </div>
            </div>
            <!-- /.box-body -->

            <div class="row">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Reminders</h3>
                    </div>
                    <!-- Recent Payments -->
                    <div class="box-body">

                        <strong><i class="fa fa-file-text-o margin-r-5"></i> Request offer letter from CQU</strong>

                        <p class="text-muted">20/12/2016</p>

                        <strong><i class="fa fa-file-text-o margin-r-5"></i> Create Payment invoice of Amount
                            $1000</strong>

                        <p class="text-muted">12/08/2016</p>

                        <strong><i class="fa fa-file-text-o margin-r-5"></i> Request offer letter from CQU</strong>

                        <p class="text-muted">20/12/2016</p>

                        <strong><i class="fa fa-file-text-o margin-r-5"></i> Create Payment invoice of Amount
                            $1000</strong>

                        <p class="text-muted">12/08/2016</p>


                    </div>
                </div>


            </div>

            <!-- /.box -->
        </div>
        <div class="col-xs-9">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Recent Activities</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-9">
                            <div class="row">
                                <div class="col-xs-8">
                                    Enrolled in Diploma in Information Technology from Hogwards University
                                </div>
                                <div class="col-xs-2">
                                    12/07/2015
                                </div>
                                <div class="col-xs-2">
                                    Krita Maharjan
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-9">
                            <div class="row">
                                <div class="col-xs-8">
                                    Enrolled in Diploma in Information Technology from Hogwards University
                                </div>
                                <div class="col-xs-2">
                                    12/07/2015
                                </div>
                                <div class="col-xs-2">
                                    Krita Maharjan
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.tenant', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>