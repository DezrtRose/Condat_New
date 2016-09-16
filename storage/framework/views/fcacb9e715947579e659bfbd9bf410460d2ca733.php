<div class="box-body">
    <div class="col-md-12">

        <div class="form-group <?php if($errors->has('date_paid')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
            <?php echo Form::label('date_paid', 'Payment Date *', array('class' => 'col-sm-4 control-label')); ?>

            <div class="col-sm-8">
                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <?php if(!isset($payment) || $payment->date_paid == null): ?>
                        <?php echo Form::text('date_paid', null, array('class' => 'form-control', 'id'=>'date_paid')); ?>

                    <?php else: ?>
                        <?php echo Form::text('date_paid', format_date($payment->date_paid), array('class' => 'form-control', 'id'=>'date_paid')); ?>

                    <?php endif; ?>
                </div>
                <?php if($errors->has('date_paid')): ?>
                    <?php echo $errors->first('date_paid', '<label class="control-label"
                                                      for="inputError">:message</label>'); ?>

                <?php endif; ?>
            </div>
        </div>

        <div class="form-group <?php if($errors->has('amount')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
            <?php echo Form::label('amount', 'Amount *', array('class' => 'col-sm-4 control-label')); ?>

            <div class="col-sm-8">
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    <?php echo Form::text('amount', null, array('class' => 'form-control', 'id'=>'amount')); ?>

                </div>
                <?php if($errors->has('amount')): ?>
                    <?php echo $errors->first('amount', '<label class="control-label"
                                                             for="inputError">:message</label>'); ?>

                <?php endif; ?>
            </div>
        </div>

        <div class="form-group <?php if($errors->has('payment_method')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
            <?php echo Form::label('payment_method', 'Payment Method *', array('class' => 'col-sm-4 control-label')); ?>

            <div class="col-sm-8">
                <?php echo Form::text('payment_method', null, array('class' => 'form-control', 'id'=>'payment_method')); ?>

                <?php if($errors->has('payment_method')): ?>
                    <?php echo $errors->first('payment_method', '<label class="control-label"
                                                              for="inputError">:message</label>'); ?>

                <?php endif; ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo Form::label('payment_type', 'Payment Type *', array('class' => 'col-sm-4 control-label')); ?>

            <div class="col-sm-8">
                <?php echo Form::select('payment_type', config('constants.student_payment_type'), null, array('class' => 'form-control', 'id'=>'payment_type')); ?>

            </div>
        </div>

        <div class="form-group <?php if($errors->has('description')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
            <?php echo Form::label('description', 'Description', array('class' => 'col-sm-4 control-label')); ?>

            <div class="col-sm-8">
                <?php echo Form::textarea('description', null, array('class' => 'form-control', 'id'=>'description')); ?>

                <?php if($errors->has('description')): ?>
                    <?php echo $errors->first('description', '<label class="control-label"
                                                            for="inputError">:message</label>'); ?>

                <?php endif; ?>
            </div>
        </div>


    </div>
</div>


<script>
    $(function () {
        var date = new Date();
        $("#date_paid").datepicker({
            autoclose: true,
            format: 'dd/mm/yyyy'
        });
    });
</script>