<div class="box-body">
    <div class="row">
        <div class="col-sm-6">
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
        </div>
        <div class="col-sm-6">
            <div class="form-group <?php if($errors->has('installment_no')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                <?php echo Form::label('installment_no *', 'Installment Number', array('class' => 'col-sm-4 control-label')); ?>

                <div class="col-sm-8">
                    <?php echo Form::text('installment_no', null, array('class' => 'form-control', 'id'=>'installment_no','placeholder'=>'T1')); ?>

                    <?php if($errors->has('installment_no')): ?>
                        <?php echo $errors->first('installment_no', '<label class="control-label"
                                                                for="inputError">:message</label>'); ?>

                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <span class="panel-title">Commission on Tuition Fee</span>
            <a href="#" class="btn btn-warning btn-collapse btn-flat btn-xs pull-right"><i class="fa fa-minus-circle"></i> Remove</a>
        </div>
        <div class="panel-body">
            <div class="col-sm-6">

                <div class="form-group <?php if($errors->has('invoice_amount')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                    <?php echo Form::label('tuition_fee', 'Tuition Fee *', array('class' => 'col-sm-4 control-label')); ?>

                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <?php echo Form::text('tuition_fee', null, array('class' => 'form-control', 'id'=>'tuition_fee')); ?>

                        </div>
                        <?php if($errors->has('tuition_fee')): ?>
                            <?php echo $errors->first('tuition_fee', '<label class="control-label"
                                                                   for="inputError">:message</label>'); ?>

                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group <?php if($errors->has('enrollment_fee')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                    <?php echo Form::label('enrollment_fee', 'Enrollment Fee *', array('class' => 'col-sm-4 control-label')); ?>

                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <?php echo Form::text('enrollment_fee', 0, array('class' => 'form-control', 'id'=>'enrollment_fee',)); ?>

                        </div>
                        <?php if($errors->has('enrollment_fee')): ?>
                            <?php echo $errors->first('enrollment_fee', '<label class="control-label"
                                                                     for="inputError">:message</label>'); ?>

                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group <?php if($errors->has('material_fee')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                    <?php echo Form::label('material_fee', 'Material Fee *', array('class' => 'col-sm-4 control-label')); ?>

                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <?php echo Form::text('material_fee', 0, array('class' => 'form-control', 'id'=>'material_fee')); ?>

                        </div>
                        <?php if($errors->has('material_fee')): ?>
                            <?php echo $errors->first('material_fee', '<label class="control-label"
                                                                     for="inputError">:message</label>'); ?>

                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group <?php if($errors->has('coe_fee')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                    <?php echo Form::label('coe_fee', 'COE Fee *', array('class' => 'col-sm-4 control-label')); ?>

                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <?php echo Form::text('coe_fee', 0, array('class' => 'form-control', 'id'=>'coe_fee')); ?>

                        </div>
                        <?php if($errors->has('coe_fee')): ?>
                            <?php echo $errors->first('coe_fee', '<label class="control-label"
                                                                     for="inputError">:message</label>'); ?>

                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group <?php if($errors->has('other_fee')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                    <?php echo Form::label('other_fee', 'Other Fee*', array('class' => 'col-sm-4 control-label')); ?>

                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <?php echo Form::text('other_fee', 0, array('class' => 'form-control', 'id'=>'other_fee')); ?>

                        </div>
                        <?php if($errors->has('other_fee')): ?>
                            <?php echo $errors->first('other_fee', '<label class="control-label"
                                                                     for="inputError">:message</label>'); ?>

                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group <?php if($errors->has('sub_total')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                    <?php echo Form::label('sub_total', 'Sub Total *', array('class' => 'col-sm-4 control-label')); ?>

                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <?php echo Form::text('sub_total', 0, array('class' => 'form-control', 'id'=>'sub_total','placeholder'=>'click to calculate')); ?>

                        </div>
                        <?php if($errors->has('sub_total')): ?>
                            <?php echo $errors->first('sub_total', '<label class="control-label"
                                                                     for="inputError">:message</label>'); ?>

                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">

                <div class="form-group <?php if($errors->has('description')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                    <?php echo Form::label('description', 'Description *', array('class' => 'col-sm-4 control-label')); ?>

                    <div class="col-sm-8">
                        <?php echo Form::text('description', 'Commission on tuition Fee', array('class' => 'form-control', 'id'=>'description')); ?>

                        <?php if($errors->has('description')): ?>
                            <?php echo $errors->first('description', '<label class="control-label"
                                                                    for="inputError">:message</label>'); ?>

                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group <?php if($errors->has('commission_percent')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                    <?php echo Form::label('commission_percent', 'Commission Percent *', array('class' => 'col-sm-4 control-label')); ?>

                    <div class="col-sm-8">
                        <div class="input-group">

                            <?php echo Form::text('commission_percent', 0, array('class' => 'form-control', 'id'=>'commission_percent')); ?>

                            <span class="input-group-addon">%</span>
                        </div>
                        <?php if($errors->has('commission_percent')): ?>
                            <?php echo $errors->first('commission_percent', '<label class="control-label"
                                                                     for="inputError">:message</label>'); ?>

                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group <?php if($errors->has('commission_amount')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                    <?php echo Form::label('commission_amount', 'Commission Amount *', array('class' => 'col-sm-4 control-label')); ?>

                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <?php echo Form::text('commission_amount', null, array('class' => 'form-control', 'id'=>'commission_amount','placeholder'=>'click to calculate')); ?>

                        </div>
                        <?php if($errors->has('commission_amount')): ?>
                            <?php echo $errors->first('commission_amount', '<label class="control-label"
                                                                     for="inputError">:message</label>'); ?>

                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-group <?php if($errors->has('tuition_fee_gst')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                    <?php echo Form::label('tuition_fee_gst', 'Commission GST *', array('class' => 'col-sm-4 control-label')); ?>

                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <?php echo Form::text('tuition_fee_gst', null, array('class' => 'form-control', 'id'=>'tuition_fee_gst','placeholder'=>'10% of Commission Amount','readonly' => 'true')); ?>

                            <span class="input-group-addon">
                               <?php echo e(Form::checkbox('gst_checker_tuition_fee', 'incentive', true,array('id'=>'gst_checker_tuition_fee'))); ?> GST
                            </span>
                        </div>
                        <?php if($errors->has('tuition_fee_gst')): ?>
                            <?php echo $errors->first('tuition_fee_gst', '<label class="control-label"
                                                                     for="inputError">:message</label>'); ?>

                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <span class="panel-title">Other Commission</span>
            <a href="#" class="btn btn-warning btn-collapse-incentive btn-flat btn-xs pull-right"><i class="fa fa-minus-circle"></i> Remove</a>
        </div>
        <div class="panel-body">
            <div class="col-sm-6">

                <div class="form-group <?php if($errors->has('incentive')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                    <?php echo Form::label('incentive', 'Amount *', array('class' => 'col-sm-4 control-label')); ?>

                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <?php echo Form::text('incentive', null, array('class' => 'form-control', 'id'=>'incentive')); ?>

                        </div>
                        <?php if($errors->has('incentive')): ?>
                            <?php echo $errors->first('incentive', '<label class="control-label"
                                                                     for="inputError">:message</label>'); ?>

                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group <?php if($errors->has('incentive_gst')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                    <?php echo Form::label('incentive_gst', 'GST *', array('class' => 'col-sm-4 control-label')); ?>

                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <?php echo Form::text('incentive_gst', null, array('class' => 'form-control', 'id'=>'incentive_gst','placeholder'=>'10% of Incentive','readonly' => 'true')); ?>

                            <span class="input-group-addon">
                               <?php echo e(Form::checkbox('gst_checker_incentive', 'incentive', true,array('id'=>'gst_checker_incentive'))); ?> GST
                            </span>
                        </div>
                        <?php if($errors->has('incentive_gst')): ?>
                            <?php echo $errors->first('incentive_gst', '<label class="control-label"
                                                                     for="inputError">:message</label>'); ?>

                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group <?php if($errors->has('description')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                    <?php echo Form::label('description', 'Description *', array('class' => 'col-sm-4 control-label')); ?>

                    <div class="col-sm-8">
                        <?php echo Form::text('description', null, array('class' => 'form-control', 'id'=>'description')); ?>

                        <?php if($errors->has('description')): ?>
                            <?php echo $errors->first('description', '<label class="control-label"
                                                                    for="inputError">:message</label>'); ?>

                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <span class="panel-title">Total Commission</span>
        </div>
        <div class="panel-body">
            <div class="col-sm-6">
                <div class="form-group <?php if($errors->has('total_commission')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                    <?php echo Form::label('total_commission', 'Total Amount *', array('class' => 'col-sm-4 control-label')); ?>

                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <?php echo Form::text('total_commission', null, array('class' => 'form-control', 'id'=>'total_commission','placeholder'=>'sum of Commission Amount and Amount','readonly' => 'true')); ?>

                        </div>
                        <?php if($errors->has('total_commission')): ?>
                            <?php echo $errors->first('total_commission', '<label class="control-label"
                                                                     for="inputError">:message</label>'); ?>

                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group <?php if($errors->has('total_gst')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                    <?php echo Form::label('total_gst', 'Total GST *', array('class' => 'col-sm-4 control-label')); ?>

                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <?php echo Form::text('total_gst', null, array('class' => 'form-control', 'id'=>'total_gst','placeholder'=>'sum of Commission GST and GST','readonly' => 'true')); ?>

                        </div>
                        <?php if($errors->has('total_gst')): ?>
                            <?php echo $errors->first('total_gst', '<label class="control-label"
                                                                     for="inputError">:message</label>'); ?>

                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group <?php if($errors->has('final_total')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                    <?php echo Form::label('final_total', 'Total with GST', array('class' => 'col-sm-4 control-label')); ?>

                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <?php echo Form::text('final_total', null, array('class' => 'form-control', 'id'=>'final_total','placeholder'=>'sum of Total Amount and Total GST','readonly' => 'true')); ?>

                        </div>
                        <?php if($errors->has('final_total')): ?>
                            <?php echo $errors->first('final_total', '<label class="control-label"
                                                                     for="inputError">:message</label>'); ?>

                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-group <?php if($errors->has('payable_to_college')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                    <?php echo Form::label('payable_to_college', 'Payable To College', array('class' => 'col-sm-4 control-label')); ?>

                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <?php echo Form::text('payable_to_college', null, array('class' => 'form-control', 'id'=>'payable_to_college','placeholder'=>'Sub Total - Final Total','readonly' => 'true')); ?>

                        </div>
                        <?php if($errors->has('payable_to_college')): ?>
                            <?php echo $errors->first('payable_to_college', '<label class="control-label"
                                                                     for="inputError">:message</label>'); ?>

                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        $("#invoice_date").datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true
        });

        $("#due_date").datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true
        });

        $(".btn-collapse").click(function(e) {
            $('#tuition_fee').val(0);
            $('#sub_total').val(0);
            $('#commission_amount').val(0);
            $('#tuition_fee_gst').val(0);
            reset_value();
            e.preventDefault();
            var $this = $(this);
            var parentHead = $this.parent();
            parentHead.parent().find(".panel-body").slideToggle( "slow", function() {
                parentHead.toggleClass('collapsed');
                if(!parentHead.hasClass('collapsed')){


                    $this.html('<i class="fa fa-minus-circle"></i> Remove');


                }
                else
                    $this.html('<i class="fa fa-plus-circle"></i> Add');
            });
        });

        $(".btn-collapse-incentive").click(function(e) {
            $('#incentive').val(0);
            $('#incentive_gst').val(0);
            reset_value();
            e.preventDefault();
            var $this = $(this);
            var parentHead = $this.parent();
            parentHead.parent().find(".panel-body").slideToggle( "slow", function() {
                parentHead.toggleClass('collapsed');
                if(!parentHead.hasClass('collapsed'))
                {

                    $this.html('<i class="fa fa-minus-circle"></i> Remove');

                }
                else
                    $this.html('<i class="fa fa-plus-circle"></i> Add');
            });
        });




        var total_commission=0;
        var total_gst=0;

        $('#tuition_fee, #enrollment_fee, #material_fee, #coe_fee, #other_fee').keyup(function() {
            var tuitionFee = parseFloat($('#tuition_fee').val());
            var enrollmentFee = parseFloat($('#enrollment_fee').val());
            var materialFee = parseFloat($('#material_fee').val());
            var coeFee = parseFloat($('#coe_fee').val());
            var otherFee = parseFloat($('#other_fee').val());
            var subTotal = parseFloat(tuitionFee + enrollmentFee + materialFee + coeFee + otherFee);
            $('#sub_total').val(subTotal);
            reset_value();
        });

        $('#commission_percent, #subTotal,#commissionAmount,#incentive').keyup(function() {
            reset_value();

        });


        $('#gst_checker_incentive').click(function(){
            if($(this).is(":checked")) // "this" refers to the element that fired the event
            {
                $('#incentive_gst').val(parseFloat($('#incentive').val()/10));
            }
            else
            {
                $('#incentive_gst').val(0);

            }
            gst_change();

        });

        $('#gst_checker_tuition_fee').click(function(){
            if($(this).is(":checked")) // "this" refers to the element that fired the event
            {

                $('#tuition_fee_gst').val(parseFloat($('#commission_amount').val()/10));
            }
            else
            {
                $('#tuition_fee_gst').val(0);

            }
            gst_change();
        });


        function gst_change(){
            var commissionPercent = parseFloat($('#commission_percent').val());
            var tuition_fee = parseFloat($('#tuition_fee').val());
            var commissionAmount = parseFloat(commissionPercent / 100 * tuition_fee);
            var tuition_fee_gst=parseFloat($('#tuition_fee_gst').val());


            var incentive = parseFloat($('#incentive').val());
            var incentive_gst = parseFloat($('#incentive_gst').val()); //10% of commission amount

            total_commission=commissionAmount+incentive;
            total_gst=tuition_fee_gst+incentive_gst;
            final_total=total_commission+total_gst;
            payable_to_college=$('#sub_total').val()-final_total;
            $('#total_commission').val(total_commission.toFixed(2));
            $('#total_gst').val(total_gst.toFixed(2));
            $('#final_total').val(final_total.toFixed(2));
            $('#payable_to_college').val(payable_to_college.toFixed(2));
        }



        function reset_value(){
            var commissionPercent = parseFloat($('#commission_percent').val());
            var tuition_fee = parseFloat($('#tuition_fee').val());
            var commissionAmount = parseFloat(commissionPercent / 100 * tuition_fee);
            $('#commission_amount').val(commissionAmount.toFixed(2));

            if($('#gst_checker_tuition_fee').is(":checked")) // "this" refers to the element that fired the event
            {
                var tuition_fee_gst=commissionAmount/10;

            }
            else
            {
                tuition_fee_gst=0;

            }
            $('#tuition_fee_gst').val(tuition_fee_gst.toFixed(2));


            var incentive = parseFloat($('#incentive').val());

            if($('#gst_checker_incentive').is(":checked")) // "this" refers to the element that fired the event
            {
                var incentive_gst = incentive /10; //10% of commission amount

            }
            else
            {
                var incentive_gst=0;

            }
            $('#incentive_gst').val(incentive_gst.toFixed(2));




            total_commission=commissionAmount+incentive;
            total_gst=tuition_fee_gst+incentive_gst;
            final_total=total_commission+total_gst;
            payable_to_college=$('#sub_total').val()-final_total;
            $('#total_commission').val(total_commission.toFixed(2));
            $('#total_gst').val(total_gst.toFixed(2));
            $('#final_total').val(final_total.toFixed(2));
            $('#payable_to_college').val(payable_to_college.toFixed(2));
        }




    });
</script>



