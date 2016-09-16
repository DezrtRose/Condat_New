<?php $__env->startSection('title', 'Client View'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    @parent
    <li><a href="<?php echo e(url('tenant/clients')); ?>" title="All Clients"><i class="fa fa-users"></i> Clients</a></li>
    <li>View</li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <div class="container">
        <div class="row">
        <?php echo $__env->make('Tenant::Client/client_header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>  
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

                        <p class="text-muted"><?php echo e($client->referred_by); ?></p>


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

                        <strong><i class="fa fa-file-text-o margin-r-5"></i> Request offer for holmes...</strong>

                        <p class="text-muted">20/12/2016</p>

                        <strong><i class="fa fa-file-text-o margin-r-5"></i> Create Payment 
                            $1000...</strong>

                        <p class="text-muted">12/08/2016</p>

                        <strong><i class="fa fa-file-text-o margin-r-5"></i> Request offer coe...</strong>

                        <p class="text-muted">20/12/2016</p>

                        <strong><i class="fa fa-file-text-o margin-r-5"></i> Create Payment 
                            $1000...</strong>

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