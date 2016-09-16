<div class="box-body">
    <div class="col-md-6">

        <div class="form-group <?php if($errors->has('invoice_date')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
            <?php echo Form::label('invoice_date', 'Invoice Date *', array('class' => 'col-sm-4 control-label')); ?>

            <div class="col-sm-8">
                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <?php if(!isset($invoice) || $invoice->invoice_date == null): ?>
                        <?php echo Form::text('invoice_date', null, array('class' => 'form-control', 'id'=>'invoice_date')); ?>

                    <?php else: ?>
                        <?php echo Form::text('invoice_date', format_date($invoice->invoice_date), array('class' => 'form-control', 'id'=>'invoice_date')); ?>

                    <?php endif; ?>
                </div>
                <?php if($errors->has('invoice_date')): ?>
                    <?php echo $errors->first('invoice_date', '<label class="control-label"
                                                      for="inputError">:message</label>'); ?>

                <?php endif; ?>
            </div>
        </div>

        <div class="form-group <?php if($errors->has('amount')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
            <?php echo Form::label('amount', 'Tution Fee *', array('class' => 'col-sm-4 control-label')); ?>

            <div class="col-sm-8">
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    <?php echo Form::text('amount', null, array('class' => 'form-control', 'id'=>'amount','autocomplete'=>'off')); ?>

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
                    <?php echo Form::text('discount', 0, array('class' => 'form-control', 'id'=>'discount','autocomplete'=>'off')); ?>

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
                    <?php echo Form::text('invoice_amount', null, array('class' => 'form-control', 'id'=>'invoice_amount','readonly' => 'true')); ?>

                </div>
                <?php if($errors->has('invoice_amount')): ?>
                    <?php echo $errors->first('invoice_amount', '<label class="control-label"
                                                           for="inputError">:message</label>'); ?>

                <?php endif; ?>
            </div>
        </div>

        <div class="form-group <?php if($errors->has('total_gst')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
            <?php echo Form::label('total_gst', 'GST *', array('class' => 'col-sm-4 control-label')); ?>

            <div class="col-sm-8">
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    <?php echo Form::text('total_gst', null, array('class' => 'form-control', 'id'=>'gst','placeholder'=>'10% of Amount ','readonly' => 'true')); ?>

                    <span class="input-group-addon">
                               <?php echo e(Form::checkbox('gst_checker_incentive', 'incentive', false,array('id'=>'gst_checker_incentive'))); ?>

                        GST
                            </span>
                </div>
                <?php if($errors->has('total_gst')): ?>
                    <?php echo $errors->first('total_gst', '<label class="control-label"
                                                             for="inputError">:message</label>'); ?>

                <?php endif; ?>
            </div>
        </div>

        <div class="form-group <?php if($errors->has('final_total')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
            <?php echo Form::label('final_total', 'Final Total *', array('class' => 'col-sm-4 control-label')); ?>

            <div class="col-sm-8">
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    <?php echo Form::text('final_total', null, array('class' => 'form-control', 'id'=>'final_total','readonly' => 'true')); ?>

                </div>
                <?php if($errors->has('final_total')): ?>
                    <?php echo $errors->first('final_total', '<label class="control-label"
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
                    <?php if(!isset($invoice) || $invoice->due_date == null): ?>
                        <?php echo Form::text('due_date', null, array('class' => 'form-control', 'id'=>'due_date')); ?>

                    <?php else: ?>
                        <?php echo Form::text('due_date', format_date($invoice->due_date), array('class' => 'form-control', 'id'=>'due_date')); ?>

                    <?php endif; ?>
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

    $('#amount, #invoice_amount,#discount').keyup(function () {
        var amount = parseFloat($('#amount').val());
        var discount = parseFloat($('#discount').val());
        var invoice_amount = amount - discount;
        if ($('#gst_checker_tuition_fee').is(":checked")) // "this" refers to the element that fired the event
        {
            var gst = invoice_amount / 10;

        }
        else {
            gst = 0;

        }

        $('#invoice_amount').val(invoice_amount.toFixed(2));
        $('#gst').val(gst);

        final_total = invoice_amount + gst;
        $('#final_total').val(final_total.toFixed(2));

    });

    $('#gst_checker_incentive').click(function () {
        if ($(this).is(":checked")) // "this" refers to the element that fired the event
        {
            $('#gst').val(parseFloat($('#invoice_amount').val() / 10));
        }
        else {
            $('#gst').val(0);

        }
        gst_change();

    });

    function gst_change() {

        var invoice_amount = parseFloat($('#invoice_amount').val());
        var gst = parseFloat($('#gst').val()); //10% of commission amount
        $('#gst').val(gst.toFixed(2));
        final_total = invoice_amount + gst;
        $('#final_total').val(final_total.toFixed(2));
    }

    $(function () {
        $("#invoice_date").datepicker({
            autoclose: true,
            format: 'dd/mm/yyyy'
        });

        $("#due_date").datepicker({
            autoclose: true,
            format: 'dd/mm/yyyy'
        });
    });
</script>