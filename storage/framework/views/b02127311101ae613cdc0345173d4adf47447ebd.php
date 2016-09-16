<?php $__env->startSection('title', 'Login'); ?>
<?php $__env->startSection('content'); ?>
    <div class="login-box">
        <div class="login-logo">
            <a href="">Consultancy Database</a>
        </div>

        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Sign in</p>
            <?php if(Session::has('message')): ?>
                <div class="callout callout-danger">
                    <h4>Invalid Login</h4>

                    <p><?php echo e(Session::get('message')); ?></p>
                </div>
            <?php endif; ?>
            <?php if(Session::has('message_success')): ?>
                <div class="callout callout-success">

                    <p><?php echo e(Session::get('message_success')); ?></p>
                </div>
            <?php endif; ?>
            <form action="" method="post">

                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

                <div class="form-group has-feedback <?php if($errors->has('email')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                    <input type="text" class="form-control" name="email" placeholder="Email"
                           value="<?php echo e(old('email')); ?>"/>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    <?php if($errors->has('email')): ?>
                        <?php echo $errors->first('email', '<label class="control-label" for="inputError">:message</label>
                        '); ?>

                    <?php endif; ?>

                </div>
                <div class="form-group has-feedback <?php if($errors->has('password')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                    <input type="password" name="password" class="form-control" placeholder="Password"/>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    <?php if($errors->has('password')): ?>
                        <?php echo $errors->first('password', '<label class="control-label"
                                                               for="inputError">:message</label>'); ?>

                    <?php endif; ?>
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox icheck">
                            <label>
                                <input type="checkbox" name="remember" value=1> Remember Me
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <a href="<?php echo e(url('forgot-password')); ?>">
                <small>I forgot my password</small>
            </a><br>
            <a href="register" class="text-center">Register a new membership</a>
        </div>
        <div class="login-box-footer">
            <p class="text-center">
                <small>&copy; copyright 2015 | Webunisoft</small>
            </p>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.min', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>