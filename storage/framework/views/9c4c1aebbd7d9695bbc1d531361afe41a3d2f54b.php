<?php $__env->startSection('title', 'Register'); ?>

<?php $__env->startSection('content'); ?>
    <div class="login-box">
        <div class="register-logo">
            <a href="">Consultancy Database</a>
        </div>

        <div class="register-box">

            <div class="register-box-body">
                <p class="login-box-msg">Register a new membership</p>

                <form class="" role="form" method="POST" action="<?php echo e(url('/register')); ?>">
                    <?php echo csrf_field(); ?>


                    <div class="form-group has-feedback<?php echo e($errors->has('given_name') ? ' has-error' : ''); ?>">
                        <input type="text" class="form-control" placeholder="First name" name="given_name"
                               value="<?php echo e(old('given_name')); ?>">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        <?php if($errors->has('given_name')): ?>
                            <?php echo $errors->first('given_name', '<label class="control-label"
                                                                     for="inputError">:message</label>'); ?>

                        <?php endif; ?>
                    </div>
                    <div class="form-group has-feedback<?php echo e($errors->has('surname') ? ' has-error' : ''); ?>">
                        <input type="text" class="form-control" placeholder="Surname" name="surname"
                               value="<?php echo e(old('surname')); ?>">
                        <span class="glyphicon glyphicon-heart form-control-feedback"></span>
                        <?php if($errors->has('surname')): ?>
                            <?php echo $errors->first('surname', '<label class="control-label"
                                                                  for="inputError">:message</label>'); ?>

                        <?php endif; ?>
                    </div>
                    <div class="form-group has-feedback<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                        <input type="email" class="form-control" placeholder="Email" name="email"
                               value="<?php echo e(old('email')); ?>">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        <?php if($errors->has('email')): ?>
                            <?php echo $errors->first('email', '<label class="control-label"
                                                                for="inputError">:message</label>'); ?>

                        <?php endif; ?>
                    </div>
                    <div class="form-group has-feedback<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                        <input type="password" class="form-control" placeholder="Password" name="password">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        <?php if($errors->has('password')): ?>
                            <?php echo $errors->first('password', '<label class="control-label"
                                                                   for="inputError">:message</label>'); ?>

                        <?php endif; ?>
                    </div>
                    <div class="form-group has-feedback<?php echo e($errors->has('password_confirmation') ? ' has-error' : ''); ?>">
                        <input type="password" class="form-control" placeholder="Retype password"
                               name="password_confirmation">
                        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                        <?php if($errors->has('password_confirmation')): ?>
                            <?php echo $errors->first('password_confirmation', '<label class="control-label"
                                                                                for="inputError">:message</label>'); ?>

                        <?php endif; ?>
                    </div>

                    <div class="row">
                        <div class="col-xs-8">
                            <div class="checkbox icheck">
                                <label class="">
                                    <div class="checkbox icheck">
                                        <label>
                                            <input type="checkbox" name="terms" id="terms"> I agree to the <a href="#">terms</a>
                                        </label>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-4">
                            <button type="submit" class="btn btn-primary btn-block btn-flat" disabled="disabled"
                                    id="register">Register
                            </button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <?php /*<div class="social-auth-links text-center">
                    <p>- OR -</p>
                    <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i>
                        Sign up using
                        Facebook</a>
                    <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i>
                        Sign up using
                        Google+</a>
                </div>*/ ?>

                <a href="login" class="text-center">I already have a membership</a>
            </div>
            <!-- /.form-box -->
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#terms').on('ifChecked', function (event) {
                $("#register").removeAttr("disabled");
            });

            $('#terms').on('ifUnchecked', function (event) {
                $("#register").attr("disabled", "disabled");
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.min', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>