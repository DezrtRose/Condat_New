<?php $__env->startSection('title', 'Bank Details'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    @parent
    <li>Bank Details</li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="col-xs-12">
        <?php echo $__env->make('flash::message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Bank Details</h3>
            </div>
            <?php echo Form::model($bank, array('route' => ['tenant.bank.store'], 'class' => 'form-horizontal form-left')); ?>

            <div class="box-body">
                <div class="form-group <?php if($errors->has('name')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                    <?php echo Form::label('name', 'Bank Name *', array('class' => 'col-sm-2 control-label')); ?>

                    <div class="col-sm-6">
                        <?php echo Form::text('name', null, array('class' => 'form-control', 'id'=>'name')); ?>

                        <?php if($errors->has('name')): ?>
                            <?php echo $errors->first('name', '<label class="control-label"
                                                               for="inputError">:message</label>'); ?>

                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group <?php if($errors->has('account_name')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                    <?php echo Form::label('account_name', 'Account Name *', array('class' => 'col-sm-2 control-label')); ?>

                    <div class="col-sm-6">
                        <?php echo Form::text('account_name', null, array('class' => 'form-control', 'id'=>'account_name')); ?>

                        <?php if($errors->has('account_name')): ?>
                            <?php echo $errors->first('account_name', '<label class="control-label"
                                                                for="inputError">:message</label>'); ?>

                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group <?php if($errors->has('number')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                    <?php echo Form::label('number', 'Account Number *', array('class' => 'col-sm-2 control-label')); ?>

                    <div class="col-sm-6">
                        <?php echo Form::text('number', null, array('class' => 'form-control', 'id'=>'number')); ?>

                        <?php if($errors->has('number')): ?>
                            <?php echo $errors->first('number', '<label class="control-label"
                                                                for="inputError">:message</label>'); ?>

                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group <?php if($errors->has('bsb')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                    <?php echo Form::label('bsb', 'BSB', array('class' => 'col-sm-2 control-label')); ?>

                    <div class="col-sm-6">
                        <?php echo Form::text('bsb', null, array('class' => 'form-control', 'id'=>'bsb')); ?>

                        <?php if($errors->has('bsb')): ?>
                            <?php echo $errors->first('bsb', '<label class="control-label"
                                                                  for="inputError">:message</label>'); ?>

                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="box-footer clearfix">
                <input type="submit" class="btn btn-primary pull-right" value="Update"/>
            </div>
            <?php echo Form::close(); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.tenant', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>