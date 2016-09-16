<?php $__env->startSection('title', 'Subscription Fee Settings'); ?>
<?php $__env->startSection('heading', 'Subscription Fee Settings'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    @parent
    <li><a href="<?php echo e(url('settings')); ?>" title="Settings"><i class="fa fa-cog"></i> Settings</a></li>
    <li>Subscription Fee</li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="col-xs-12">
        <?php echo $__env->make('flash::message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php if($errors->has()): ?>
            <ul class="alert alert-danger">
                <?php foreach($errors->all() as $error): ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
    <div class="col-md-4">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Basic Subscription</h3>
            </div>
            <!-- /.box-header -->
            <?php echo Form::model($basic, array('class' => 'form-horizontal')); ?>

            <?php echo Form::hidden('name', 'basic'); ?>

            <div class="box-body">
                <div class="form-group">
                    <div class="col-sm-5 text-right"><strong>Subscription Type</strong></div>
                    <div class="col-sm-7">Basic</div>
                </div>
                <div class="form-group">
                    <div class="col-sm-5 text-right"><strong>Duration</strong></div>
                    <div class="col-sm-7">1 Year</div>
                </div>
                <div class="form-group">
                    <?php echo Form::label('basic_amount', 'Amount *', array('class' => 'col-sm-5 control-label')); ?>

                    <div class="col-sm-7">
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <?php echo Form::text('basic_amount', $basic->amount, array('class' => 'form-control', 'id'=>'amount')); ?>

                            <span class="input-group-addon">.00</span>
                        </div>
                    </div>

                </div>
            </div>
            <div class="box-footer">
                <input type="submit" class="btn btn-primary pull-right" value="Update"/>
            </div>
            <?php echo Form::close(); ?>


        </div>
    </div>

    <div class="col-md-4">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Standard Subscription</h3>
            </div>
            <!-- /.box-header -->
            <?php echo Form::model($standard, array('class' => 'form-horizontal')); ?>

            <?php echo Form::hidden('name', 'standard'); ?>

            <div class="box-body">
                <div class="form-group">
                    <div class="col-sm-5 text-right"><strong>Subscription Type</strong></div>
                    <div class="col-sm-7">Standard</div>
                </div>
                <div class="form-group">
                    <div class="col-sm-5 text-right"><strong>Duration</strong></div>
                    <div class="col-sm-7">1 Year</div>
                </div>
                <div class="form-group">
                    <?php echo Form::label('standard_amount', 'Amount *', array('class' => 'col-sm-5 control-label')); ?>

                    <div class="col-sm-7">
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <?php echo Form::text('standard_amount', $standard->amount, array('class' => 'form-control', 'id'=>'amount')); ?>

                            <span class="input-group-addon">.00</span>
                        </div>
                    </div>

                </div>
            </div>
            <div class="box-footer">
                <input type="submit" class="btn btn-primary pull-right" value="Update"/>
            </div>
            <?php echo Form::close(); ?>


        </div>
    </div>

    <div class="col-md-4">
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Premium Subscription</h3>
            </div>
            <!-- /.box-header -->
            <?php echo Form::model($premium, array('class' => 'form-horizontal')); ?>

            <?php echo Form::hidden('name', 'premium'); ?>

            <div class="box-body">
                <div class="form-group">
                    <div class="col-sm-5 text-right"><strong>Subscription Type</strong></div>
                    <div class="col-sm-7">Premium</div>
                </div>
                <div class="form-group">
                    <div class="col-sm-5 text-right"><strong>Duration</strong></div>
                    <div class="col-sm-7">1 Year</div>
                </div>
                <div class="form-group">
                    <?php echo Form::label('premium_amount', 'Amount *', array('class' => 'col-sm-5 control-label')); ?>

                    <div class="col-sm-7">
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <?php echo Form::text('premium_amount', $premium->amount, array('class' => 'form-control', 'id'=>'amount')); ?>

                            <span class="input-group-addon">.00</span>
                        </div>
                    </div>

                </div>
            </div>
            <div class="box-footer">
                <input type="submit" class="btn btn-primary pull-right" value="Update"/>
            </div>
            <?php echo Form::close(); ?>


        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>