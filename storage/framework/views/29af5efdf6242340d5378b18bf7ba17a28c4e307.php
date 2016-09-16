<div class="box-body">
    <div class="col-md-6">

        <div class="form-group <?php if($errors->has('invoice_date')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
            <?php echo Form::label('invoice_date', 'Invoice Date *', array('class' => 'col-sm-4 control-label')); ?>

            <div class="col-sm-8">
                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <?php echo Form::text('invoice_date', null, array('class' => 'form-control', 'id'=>'invoice_date')); ?>

                </div>
                <?php if($errors->has('invoice_date')): ?>
                    <?php echo $errors->first('invoice_date', '<label class="control-label"
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

        <div class="form-group <?php if($errors->has('discount')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
            <?php echo Form::label('discount', 'Discount *', array('class' => 'col-sm-4 control-label')); ?>

            <div class="col-sm-8">
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    <?php echo Form::text('discount', null, array('class' => 'form-control', 'id'=>'discount')); ?>

                </div>
                <?php if($errors->has('discount')): ?>
                    <?php echo $errors->first('discount', '<label class="control-label"
                                                              for="inputError">:message</label>'); ?>

                <?php endif; ?>
            </div>
        </div>

        <div class="form-group <?php if($errors->has('invoice_amount')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
            <?php echo Form::label('invoice_amount', 'Invoice Amount *', array('class' => 'col-sm-4 control-label')); ?>

            <div class="col-sm-8">
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    <?php echo Form::text('invoice_amount', null, array('class' => 'form-control', 'id'=>'invoice_amount')); ?>

                </div>
                <?php if($errors->has('invoice_amount')): ?>
                    <?php echo $errors->first('invoice_amount', '<label class="control-label"
                                                           for="inputError">:message</label>'); ?>

                <?php endif; ?>
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

        <div class="form-group <?php if($errors->has('due_date')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
            <?php echo Form::label('due_date', 'Due Date *', array('class' => 'col-sm-4 control-label')); ?>

            <div class="col-sm-8">
                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <?php echo Form::text('due_date', null, array('class' => 'form-control', 'id'=>'due_date')); ?>

                </div>
                <?php if($errors->has('due_date')): ?>
                    <?php echo $errors->first('due_date', '<label class="control-label"
                                                      for="inputError">:message</label>'); ?>

                <?php endif; ?>
            </div>
        </div>


    </div>
</div>


<script>
    $(function () {
        $("#invoice_date").datepicker({
            autoclose: true
        });

        $("#due_date").datepicker({
            autoclose: true
        });
    });
</script>