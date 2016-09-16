<div class="box-body">
    <div class="col-md-6">
        <div class="">

            <div class="">

                <div class="form-group <?php if($errors->has('name')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                    <?php echo Form::label('name', 'Institute Name *', array('class' => 'col-sm-4 control-label')); ?>

                    <div class="col-sm-8">
                        <?php echo Form::text('name', null, array('class' => 'form-control', 'id'=>'name')); ?>

                        <?php if($errors->has('name')): ?>
                            <?php echo $errors->first('name', '<label class="control-label"
                                                                      for="inputError">:message</label>'); ?>

                        <?php endif; ?>
                    </div>
                </div>


                <div class="form-group <?php if($errors->has('short_name')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                    <?php echo Form::label('short_name', 'Short Name *', array('class' => 'col-sm-4 control-label')); ?>

                    <div class="col-sm-8">
                        <?php echo Form::text('short_name', null, array('class' => 'form-control', 'id'=>'short_name')); ?>

                        <?php if($errors->has('short_name')): ?>
                            <?php echo $errors->first('short_name', '<label class="control-label"
                                                                     for="inputError">:message</label>'); ?>

                        <?php endif; ?>
                    </div>
                </div>



                <div class="form-group <?php if($errors->has('phone')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                    <?php echo Form::label('phone', 'Phone Number *', array('class' => 'col-sm-4 control-label')); ?>

                    <div class="col-sm-8">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-phone"></i>
                            </div>
                            <?php echo Form::text('phone', null, array('class' => 'form-control', 'id'=>'phone', 'data-inputmask' =>"'mask': ['999-999-9999 [x99999]', '+099 99 99 9999[9]-9999']", 'data-mask' => '')); ?>

                        </div>
                        <?php if($errors->has('phone')): ?>
                            <?php echo $errors->first('phone', '<label class="control-label"
                                                                for="inputError">:message</label>'); ?>

                        <?php endif; ?>
                    </div>
                </div>

                

                <div class="form-group <?php if($errors->has('website')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                    <?php echo Form::label('website', 'Website', array('class' => 'col-sm-4 control-label')); ?>

                    <div class="col-sm-8">
                        <?php echo Form::text('website', null, array('class' => 'form-control', 'id'=>'website')); ?>

                        <?php if($errors->has('website')): ?>
                            <?php echo $errors->first('website', '<label class="control-label"
                                                                   for="inputError">:message</label>'); ?>

                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group <?php if($errors->has('invoice_to_name')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                    <?php echo Form::label('invoice_to_name', 'Invoice To', array('class' => 'col-sm-4 control-label')); ?>

                    <div class="col-sm-8">
                        <?php echo Form::text('invoice_to_name', null, array('class' => 'form-control', 'id'=>'invoice_to_name')); ?>

                        <?php if($errors->has('invoice_to_name')): ?>
                            <?php echo $errors->first('invoice_to_name', '<label class="control-label"
                                                                   for="inputError">:message</label>'); ?>

                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <?php /*Adresses*/ ?>
        <div class="">
            Address Details
            <!-- /.box-header -->
            <div class="">
                <div class="form-group <?php if($errors->has('street')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                    <?php echo Form::label('street', 'Street', array('class' => 'col-sm-4 control-label')); ?>

                    <div class="col-sm-8">
                        <?php echo Form::text('street', null, array('class' => 'form-control', 'id'=>'street')); ?>

                        <?php if($errors->has('street')): ?>
                            <?php echo $errors->first('street', '<label class="control-label"
                                                                for="inputError">:message</label>'); ?>

                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-group <?php if($errors->has('suburb')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                    <?php echo Form::label('suburb', 'Suburb', array('class' => 'col-sm-4 control-label')); ?>

                    <div class="col-sm-8">
                        <?php echo Form::text('suburb', null, array('class' => 'form-control', 'id'=>'suburb')); ?>

                        <?php if($errors->has('suburb')): ?>
                            <?php echo $errors->first('suburb', '<label class="control-label"
                                                                 for="inputError">:message</label>'); ?>

                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-group <?php if($errors->has('state')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                    <?php echo Form::label('state', 'State', array('class' => 'col-sm-4 control-label')); ?>

                    <div class="col-sm-8">
                        <?php echo Form::text('state', null, array('class' => 'form-control', 'id'=>'state')); ?>

                        <?php if($errors->has('state')): ?>
                            <?php echo $errors->first('state', '<label class="control-label"
                                                                for="inputError">:message</label>'); ?>

                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-group <?php if($errors->has('postcode')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                    <?php echo Form::label('postcode', 'Postcode', array('class' => 'col-sm-4 control-label')); ?>

                    <div class="col-sm-8">
                        <?php echo Form::text('postcode', null, array('class' => 'form-control', 'id'=>'postcode')); ?>

                        <?php if($errors->has('postcode')): ?>
                            <?php echo $errors->first('postcode', '<label class="control-label"
                                                                   for="inputError">:message</label>'); ?>

                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group <?php if($errors->has('country_id')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                    <?php echo Form::label('country_id', 'Country', array('class' => 'col-sm-4 control-label')); ?>

                    <div class="col-sm-8">
                        <?php echo Form::select('country_id', $countries, null, array('class' =>
                        'form-control')); ?>

                        <?php if($errors->has('country_id')): ?>
                            <?php echo $errors->first('country_id', '<label class="control-label"
                                                                  for="inputError">:message</label>'); ?>

                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!--/.col (right) -->
    </div>
</div>

<script>
    $(function(){
        $('input').iCheck({
            radioClass: 'iradio_minimal-blue'
        });
        $("[data-mask]").inputmask();

        var date = new Date();
        $("#dob").datepicker({
            autoclose: true,
            endDate: date
        });
    });
</script>