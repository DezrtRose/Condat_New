<div class="box-body">
    <div class="col-md-6">
        <div class="">
            Client Details

            <div class="">
                <div class="form-group <?php if($errors->has('first_name')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                    <?php echo Form::label('first_name', 'First Name *', array('class' => 'col-sm-4 control-label')); ?>

                    <div class="col-sm-8">
                        <?php echo Form::text('first_name', null, array('class' => 'form-control', 'id'=>'first_name')); ?>

                        <?php if($errors->has('first_name')): ?>
                            <?php echo $errors->first('first_name', '<label class="control-label"
                                                                     for="inputError">:message</label>'); ?>

                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group <?php if($errors->has('middle_name')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                    <?php echo Form::label('middle_name', 'Middle Name', array('class' => 'col-sm-4 control-label')); ?>

                    <div class="col-sm-8">
                        <?php echo Form::text('middle_name', null, array('class' => 'form-control', 'id'=>'middle_name')); ?>

                        <?php if($errors->has('middle_name')): ?>
                            <?php echo $errors->first('middle_name', '<label class="control-label"
                                                                      for="inputError">:message</label>'); ?>

                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group <?php if($errors->has('last_name')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                    <?php echo Form::label('last_name', 'Last Name *', array('class' => 'col-sm-4 control-label')); ?>

                    <div class="col-sm-8">
                        <?php echo Form::text('last_name', null, array('class' => 'form-control', 'id'=>'last_name')); ?>

                        <?php if($errors->has('last_name')): ?>
                            <?php echo $errors->first('last_name', '<label class="control-label"
                                                                    for="inputError">:message</label>'); ?>

                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo Form::label('sex', 'Sex *', array('class' => 'col-sm-4 control-label')); ?>

                    <div class="col-sm-8">
                        <label>
                            <?php echo Form::radio('sex', 'Male', true, array('class' => 'iCheck', 'checked'=>'checked')); ?> Male
                        </label>
                        <label>
                            <?php echo Form::radio('sex', 'Female', array('class' => 'iCheck')); ?> Female
                        </label>
                    </div>
                </div>

                <div class="form-group <?php if($errors->has('dob')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                    <?php echo Form::label('dob', 'DOB *', array('class' => 'col-sm-4 control-label')); ?>

                    <div class="col-sm-8">
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <?php echo Form::text('dob', null, array('class' => 'form-control', 'id'=>'dob')); ?>

                        </div>
                        <?php if($errors->has('dob')): ?>
                            <?php echo $errors->first('dob', '<label class="control-label"
                                                              for="inputError">:message</label>'); ?>

                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group <?php if($errors->has('passport_no')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                    <?php echo Form::label('passport_no', 'Passport No. *', array('class' => 'col-sm-4 control-label')); ?>

                    <div class="col-sm-8">
                        <?php echo Form::text('passport_no', null, array('class' => 'form-control', 'id'=>'passport_no')); ?>

                        <?php if($errors->has('passport_no')): ?>
                            <?php echo $errors->first('passport_no', '<label class="control-label"
                                                                   for="inputError">:message</label>'); ?>

                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group <?php if($errors->has('number')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                    <?php echo Form::label('number', 'Phone Number *', array('class' => 'col-sm-4 control-label')); ?>

                    <div class="col-sm-8">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-phone"></i>
                            </div>
                            <?php echo Form::text('number', null, array('class' => 'form-control', 'id'=>'phone', 'data-inputmask' =>"'mask': ['999-999-9999 [x99999]', '+099 99 99 9999[9]-9999']", 'data-mask' => '')); ?>

                        </div>
                        <?php if($errors->has('number')): ?>
                            <?php echo $errors->first('number', '<label class="control-label"
                                                                   for="inputError">:message</label>'); ?>

                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group <?php if($errors->has('email')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                    <?php echo Form::label('email', 'Email Address *', array('class' => 'col-sm-4 control-label')); ?>

                    <div class="col-sm-8">
                        <?php echo Form::email('email', null, array('class' => 'form-control', 'id'=>'email')); ?>

                        <?php if($errors->has('email')): ?>
                            <?php echo $errors->first('email', '<label class="control-label"
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