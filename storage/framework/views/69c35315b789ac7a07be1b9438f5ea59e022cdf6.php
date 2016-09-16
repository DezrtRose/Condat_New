<?php $__env->startSection('title', 'Update User'); ?>
<?php $__env->startSection('heading', 'Update User'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    @parent
    <li><a href="<?php echo e(url('users')); ?>" title="All Users"><i class="fa fa-users"></i> Users</a></li>
    <li>Update</li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="col-md-3">

        <!-- Profile Image -->
        <div class="box box-primary">
            <div class="box-body box-profile">
                <?php /*<img class="profile-user-img img-responsive img-circle" src="../../dist/img/user4-128x128.jpg"
                     alt="User profile picture">*/ ?>

                <h3 class="profile-username text-center"><?php echo e($user->given_name . " " . $user->surname); ?></h3>

                <p class="text-muted text-center"><?php echo e(get_user_role($user->role)); ?></p>

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

                <?php /*<a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>*/ ?>
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
                <strong><i class="fa fa-calendar margin-r-5"></i> Member Since</strong>

                <p class="text-muted"><?php echo e(shorten_date($user->created_at)); ?></p>

                <hr>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <div class="col-xs-9">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Update User</h3>
            </div>
            <?php echo $__env->make('flash::message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php echo Form::model($user, array('route' => array('user.update', $user->id), 'class' => 'form-horizontal', 'method' => 'put')); ?>

            <?php echo $__env->make('User::form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="box-footer">
                <input type="submit" class="btn btn-primary pull-right" value="Update"/>
            </div>
            <?php echo Form::close(); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>