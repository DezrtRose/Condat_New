<?php $__env->startSection('title', 'Renew Agency Subscription'); ?>
<?php $__env->startSection('heading', 'Renew Agency Subscription'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    @parent
    <li><a href="<?php echo e(url('agency')); ?>" title="All Agencies"><i class="fa fa-Agencies"></i> Agencies</a></li>
    <li>Subscription</li>
    <li>Renew</li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Subscription Renew</h3>
            </div>
            <?php echo $__env->make('flash::message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php echo Form::open(array('method' => 'post', 'class' => 'form-horizontal form-left')); ?>

            <div class="box-body">
                <div class="col-md-6">
                    <div class="form-group">
                        <?php echo Form::label('amount', 'Total Amount', array('class' => 'col-sm-4 control-label')); ?>

                        <div class="col-sm-8">
                            $<span class="subscription-amount">0</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo Form::label('renewal_date', 'Renewal Date', array('class' => 'col-sm-4 control-label')); ?>

                        <div class="col-sm-8">
                            <?php echo e(format_date(get_today_date())); ?>

                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo Form::label('subscription_years', 'Years', array('class' => 'col-sm-4 control-label')); ?>

                        <div class="col-sm-8">
                            <?php echo Form::select('subscription_years', config('constants.subscription_years'), null, array('class' =>
                            'form-control')); ?>

                        </div>
                    </div>
                    <div class="form-group <?php if($errors->has('payment_date')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                        <?php echo Form::label('payment_date', 'Payment Date', array('class' => 'col-sm-4 control-label')); ?>

                        <div class="col-sm-8">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <?php echo Form::text('payment_date', null, array('class' =>
                                'form-control datemask', 'data-inputmask' => "'alias': 'dd/mm/yyyy'", 'data-mask'=> '')); ?>

                                <?php if($errors->has('payment_date')): ?>
                                    <?php echo $errors->first('payment_date', '<label class="control-label"
                                                                              for="inputError">:message</label>'); ?>

                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo Form::label('', 'Payment Type', array('class' => 'col-sm-4 control-label')); ?>

                        <div class="col-sm-8">
                            <?php foreach(config('constants.payment_type') as $key => $value): ?>
                                <?php echo Form::label($key, $value, array('class' => 'control-label')); ?>

                                <?php echo Form::radio('payment_type', $key, false, ['id' => $key]); ?>

                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo Form::label('subscription_type', 'Type', array('class' => 'col-sm-4 control-label')); ?>

                        <div class="col-sm-8">
                            <?php echo Form::select('subscription_type', config('constants.subscription_type'), null, array('class' =>
                            'form-control')); ?>

                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer clearfix">
                <input type="submit" class="btn btn-primary pull-right" value="Renew" />
            </div>
            <?php echo Form::close(); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>
<script>
    window.onload = function() {
        var CSRF_TOKEN = "<?php echo csrf_token() ?>";
        $('#subscription_years, #subscription_type').on('change', function (e) {
            e.preventDefault();
            var subscription_years = $('#subscription_years').val();
            var subscription_type = $('#subscription_type').val();
            $.post("<?php echo url('agency/get_subscription_amount') ?>", {'subscription_years': subscription_years, 'subscription_type': subscription_type, _token: CSRF_TOKEN})
            .done(function(resp) {
                if(resp != 'false') {
                    $('.subscription-amount').html(resp);
                }
            })
        });
        $('#subscription_years').trigger('change');
    }
</script>
<?php echo $__env->make('layouts.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>