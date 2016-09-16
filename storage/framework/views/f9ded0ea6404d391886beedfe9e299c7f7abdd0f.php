<div class="box-body">
    <div class="col-md-6">
        <div class="">
            Company Details

            <div class="">
                <div class="form-group <?php if($errors->has('short_name')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                    <?php echo Form::label('short_name', 'Short Name', array('class' => 'col-sm-4 control-label')); ?>

                    <div class="col-sm-8">
                        <?php echo Form::text('short_name', null, array('class' => 'form-control', 'id'=>'short_name')); ?>

                        <?php if($errors->has('short_name')): ?>
                            <?php echo $errors->first('short_name', '<label class="control-label"
                                                                     for="inputError">:message</label>'); ?>

                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group <?php if($errors->has('name')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                    <?php echo Form::label('name', 'Company Name *', array('class' => 'col-sm-4 control-label')); ?>

                    <div class="col-sm-8">
                        <?php echo Form::text('name', null, array('class' => 'form-control', 'id'=>'name')); ?>

                        <?php if($errors->has('name')): ?>
                            <?php echo $errors->first('name', '<label class="control-label"
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
                            <?php echo Form::text('number', null, array('class' => 'form-control phone-input', 'id'=>'phone')); ?>

                        </div>
                        <?php if($errors->has('number')): ?>
                            <?php echo $errors->first('number', '<label class="control-label"
                                                                for="inputError">:message</label>'); ?>

                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group <?php if($errors->has('abn')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                    <?php echo Form::label('abn', 'ABN', array('class' => 'col-sm-4 control-label')); ?>

                    <div class="col-sm-8">
                        <?php echo Form::text('abn', null, array('class' => 'form-control', 'id'=>'abn')); ?>

                        <?php if($errors->has('abn')): ?>
                            <?php echo $errors->first('abn', '<label class="control-label"
                                                              for="inputError">:message</label>'); ?>

                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group <?php if($errors->has('acn')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                    <?php echo Form::label('acn', 'ACN', array('class' => 'col-sm-4 control-label')); ?>

                    <div class="col-sm-8">
                        <?php echo Form::text('acn', null, array('class' => 'form-control', 'id'=>'acn')); ?>

                        <?php if($errors->has('acn')): ?>
                            <?php echo $errors->first('acn', '<label class="control-label"
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
                    <?php echo Form::label('invoice_to_name', 'Invoice To Whom', array('class' => 'col-sm-4 control-label')); ?>

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

    <div class="col-md-12">
        <div class="form-group <?php if($errors->has('description')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
            <?php echo Form::label('description', 'Agent Description', array('class' => 'col-sm-2 control-label')); ?>

            <div class="col-sm-8">
                <?php echo Form::textarea('description', null, array('class' => 'form-control')); ?>

                <?php if($errors->has('description')): ?>
                    <?php echo $errors->first('country_id', '<label class="control-label"
                                                             for="inputError">:message</label>'); ?>

                <?php endif; ?>
            </div>
        </div>
    </div>
</div>