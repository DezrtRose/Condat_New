<?php $__env->startSection('title', 'Agent View'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    @parent
    <li><a href="<?php echo e(url('tenant/agents')); ?>" title="All Agents"><i class="fa fa-users"></i> Agents</a></li>
    <li>View</li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="col-md-4">

        <!-- Profile Image -->
        <div class="box box-primary">
            <div class="box-body box-profile">
                <?php /*<img class="profile-user-img img-responsive img-circle" src="../../dist/img/user4-128x128.jpg"
                     alt="User profile picture">*/ ?>

                <h3 class="profile-username text-center">Agent ID: <?php echo e(format_id($agent->agent_id, 'Ag')); ?></h3>

                <p class="text-muted text-center">System Agent</p>

                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                        <b>Followers</b> <a class="pull-right">1,322</a>
                    </li>
                    <li class="list-group-item">
                        <b>Following</b> <a class="pull-right">543</a>
                    </li>
                    <li class="list-group-item">
                        <b>Friends</b> <a class="pull-right">13,287</a>
                    </li>
                </ul>

                <a href="<?php echo e(route('tenant.agents.edit', $agent->agent_id)); ?>" class="btn btn-primary btn-block"><b>Update</b></a>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->

        <!-- About Me Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">General Information</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <strong><i class="fa fa-calendar margin-r-5"></i> Created At</strong>
                <p class="text-muted"><?php echo e(format_datetime($agent->created_at)); ?></p>
                <hr>
                <strong><i class="fa fa-file-text-o margin-r-5"></i> Description</strong>
                <p class="text-muted"><?php echo e($agent->description); ?></p>
                <hr>
                <strong><i class="fa fa-plus-square margin-r-5"></i> Added By</strong>
                <p class="text-muted"><?php echo e(get_tenant_name($agent->added_by)); ?></p>
                <hr>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <div class="col-xs-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Company Details</h3>
            </div>
            <div class="box-body">
                <table class="table table-hover">
                    <tbody>
                    <tr>
                        <th style="width: 34%;">Agent ID</th>
                        <td><?php echo e(format_id($agent->agent_id, 'Ag')); ?></td>
                    </tr>
                    <tr>
                        <th>Company Name</th>
                        <td><?php echo e($agent->name); ?></td>
                    </tr>
                    <tr>
                        <th>Phone Number</th>
                        <td><?php echo e($agent->number); ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?php echo e($agent->email); ?></td>
                    </tr>
                    <tr>
                        <th>Website</th>
                        <td><?php echo e($agent->website); ?></td>
                    </tr>
                    <tr>
                        <th>Invoice To Whom</th>
                        <td><?php echo e($agent->invoice_to_whom); ?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-xs-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-map-marker"></i> Address Details</h3>
            </div>
            <div class="box-body">
                <table class="table table-hover">
                <tbody>
                <tr style="width: 34%;">
                    <th>Street</th>
                    <td><?php echo e($agent->street); ?></td>
                </tr>
                <tr>
                    <th>Suburb</th>
                    <td><?php echo e($agent->suburb); ?></td>
                </tr>
                <tr>
                    <th>Postcode</th>
                    <td><?php echo e($agent->postcode); ?></td>
                </tr>
                <tr>
                    <th>State</th>
                    <td><?php echo e($agent->state); ?></td>
                </tr>
                <tr>
                    <th>Country</th>
                    <td><?php echo e(get_country($agent->country_id)); ?></td>
                </tr>
                </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.tenant', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>