<div class="col-md-6">
    <div class="">
        Agency Details

        <div class="">
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

            <?php /*<div class="form-group">
                <?php echo Form::label('company_database_name', 'Domain Name ', array('class' => 'col-sm-4 control-label')); ?>

                <div class="col-sm-8">
                    <span class="domain-suggestion"></span>
                </div>
            </div>*/ ?>

            <div class="form-group <?php if($errors->has('abn')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                <?php echo Form::label('abn', 'ABN *', array('class' => 'col-sm-4 control-label')); ?>

                <div class="col-sm-8">
                    <?php echo Form::text('abn', null, array('class' => 'form-control', 'id'=>'abn')); ?>

                    <?php if($errors->has('abn')): ?>
                        <?php echo $errors->first('abn', '<label class="control-label"
                                                          for="inputError">:message</label>'); ?>

                    <?php endif; ?>
                </div>
            </div>

            <div class="form-group <?php if($errors->has('email_id')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                <?php echo Form::label('email_id', 'Email Address *', array('class' => 'col-sm-4 control-label')); ?>

                <div class="col-sm-8">
                    <?php echo Form::text('email_id', null, array('class' => 'form-control', 'id'=>'email_id')); ?>

                    <?php if($errors->has('email_id')): ?>
                        <?php echo $errors->first('email_id', '<label class="control-label"
                                                               for="inputError">:message</label>'); ?>

                    <?php endif; ?>
                </div>
            </div>

            <div class="form-group <?php if($errors->has('phone_id')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                <?php echo Form::label('phone_id', 'Phone *', array('class' => 'col-sm-4 control-label')); ?>

                <div class="col-sm-8">
                    <?php echo Form::text('phone_id', null, array('class' => 'form-control', 'id'=>'phone_id')); ?>

                    <?php if($errors->has('phone_id')): ?>
                        <?php echo $errors->first('phone_id', '<label class="control-label"
                                                            for="inputError">:message</label>'); ?>

                    <?php endif; ?>
                </div>
            </div>

            <?php if(Request::segment(1) != 'register' && Request::segment(2) != 'agency'): ?>
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
                <?php echo Form::label('invoice_to_name', 'Invoice To', array('class' => 'col-sm-4 control-label')); ?>

                <div class="col-sm-8">
                    <?php echo Form::text('invoice_to_name', null, array('class' => 'form-control',
                    'id'=>'invoice_to_name')); ?>

                    <?php if($errors->has('invoice_to_name')): ?>
                        <?php echo $errors->first('invoice_to_name', '<label class="control-label"
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
            <?php endif; ?>

            <?php if(Request::segment(1) == 'register' && Request::segment(2) == 'agency'): ?>
                <div class="form-group <?php if($errors->has('g-recaptcha-response')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                <?php echo Form::label('g-recaptcha-response', 'Recaptcha *', array('class' => 'col-sm-4 control-label')); ?>

                <div class="col-sm-8">
                    <?php echo Recaptcha::render(); ?>

                    <?php if($errors->has('g-recaptcha-response')): ?>
                        <?php echo $errors->first('g-recaptcha-response', '<label class="control-label"
                                                                for="inputError">:message</label>'); ?>

                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="col-md-6">
    <?php /*Adresses*/ ?>
    <?php if(Request::segment(1) != 'register' && Request::segment(2) != 'agency'): ?>
    <div class="">
        Address Details
        <!-- /.box-header -->
        <div class="">
            <div class="form-group <?php if($errors->has('line1')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                <?php echo Form::label('line1', 'Line 1', array('class' => 'col-sm-4 control-label')); ?>

                <div class="col-sm-8">
                    <?php echo Form::text('line1', null, array('class' => 'form-control', 'id'=>'line1')); ?>

                    <?php if($errors->has('line1')): ?>
                        <?php echo $errors->first('line1', '<label class="control-label"
                                                            for="inputError">:message</label>'); ?>

                    <?php endif; ?>
                </div>
            </div>
            <div class="form-group <?php if($errors->has('line2')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                <?php echo Form::label('line2', 'Line 2', array('class' => 'col-sm-4 control-label')); ?>

                <div class="col-sm-8">
                    <?php echo Form::text('line2', null, array('class' => 'form-control', 'id'=>'line2')); ?>

                    <?php if($errors->has('line2')): ?>
                        <?php echo $errors->first('line2', '<label class="control-label"
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
                    <?php echo Form::select('country_id', config('constants.countries'), null, array('class' =>
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
    <?php endif; ?>
    <div>
        Subscription Details
        <div>
            <div class="form-group">
                <?php echo Form::label('subscription_type', 'Subscription Type (1 month trail)', array('class' => 'col-sm-4 control-label')); ?>

                <div class="col-sm-8">
                    <?php echo Form::select('subscription_type', ['Basic'], null, array('class' =>
                    'form-control', 'disabled' => 'disabled')); ?>

                </div>
            </div>
        </div>
    </div>
    <?php /*<div>
        Subscription Details
        <div>
            <div class="form-group <?php if($errors->has('subscription_type')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                <?php echo Form::label('subscription_type', 'Subscription Type', array('class' => 'col-sm-4 control-label')); ?>

                <div class="col-sm-8">
                    <?php echo Form::select('subscription_type', $subscriptions, null, array('class' =>
                    'form-control')); ?>

                    <?php if($errors->has('subscription_type')): ?>
                        <?php echo $errors->first('subscription_type', '<label class="control-label"
                                                              for="inputError">:message</label>'); ?>

                    <?php endif; ?>
                </div>
            </div>
            <div class="form-group <?php if($errors->has('subscription_years')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                <?php echo Form::label('subscription_years', 'Subscription Years', array('class' => 'col-sm-4 control-label')); ?>

                <div class="col-sm-8">
                    <?php echo Form::select('subscription_years', config('constants.subscription_years'), null, array('class' =>
                    'form-control')); ?>

                    <?php if($errors->has('subscription_years')): ?>
                        <?php echo $errors->first('subscription_years', '<label class="control-label"
                                                              for="inputError">:message</label>'); ?>

                    <?php endif; ?>
                </div>
            </div>
            <div class="form-group">
                <?php echo Form::label('payment_date', 'Payment Date', array('class' => 'col-sm-4 control-label')); ?>

                <div class="col-sm-8">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <?php echo Form::text('payment_date', null, array('class' =>
                        'form-control datemask', 'data-inputmask' => "'alias': 'dd/mm/yyyy'", 'data-mask'=> '')); ?>

                    </div>
                </div>
            </div>
            <div class="form-group">
                <?php echo Form::label('payment_type', 'Payment Type', array('class' => 'col-sm-4 control-label')); ?>

                <div class="col-sm-8">
                    <?php echo Form::select('payment_type', config('constants.payment_type'), null, array('class' =>
                    'form-control')); ?>

                </div>
            </div>
        </div>
    </div>*/ ?>
    <!--/.col (right) -->
</div>

<?php Condat::js("registration.js"); ?>