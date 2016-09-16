<?php $__env->startSection('title', 'Application Apply COE'); ?>
<?php $__env->startSection('heading', '<h1>Application - <small>Apply COE</small></h1>'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    @parent
    <li><a href="<?php echo e(url('tenant/clients')); ?>" title="All Clients"><i class="fa fa-users"></i> Clients</a></li>
    <li>Apply COE</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="col-md-12">

        <?php echo $__env->make('Tenant::ApplicationStatus/partial/navbar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Application Offer Details</h3>
            </div>
            <div class="box-body">
                <?php echo Form::model($application,[
                    'class'=>'form-horizontal',
                    'files'=>true,
                    'method'=>'POST',
                    'route'=>['applications.update.applied.coe', $application->application_id]
                    ]); ?>


                <div class="form-group">
                    <?php echo e(Form::label('total_fee', 'Total Fee', ['class'=>'col-md-3 form-label text-right'])); ?>

                    <div class="col-md-8">
                        <?php echo e($application->tuition_fee); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('intake_date', 'Intake Date', ['class'=>'col-md-3 form-label text-right'])); ?>

                    <div class="col-md-8">
                        <?php echo e(format_date($application->intake_date)); ?>

                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-3 form-label text-right"><strong>Student ID</strong></div>
                    <div class="col-md-8">
                        <?php echo e($application->student_id); ?>

                    </div>
                </div>

                <div class="form-group <?php if($errors->has('fee_for_coe')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                    <?php echo e(Form::label('fee_for_coe', 'Fee Paid For COE', ['class'=>'col-md-3 form-label text-right'])); ?>

                    <div class="col-md-8">
                        <div id="total_tuition_fee" class="input-group">
                            <span class="input-group-addon">$</span>
                            <?php echo e(Form::text('fee_for_coe', null, ['class'=>'form-control col-md-12','placeholder'=>'COE Fee'])); ?>

                            <span class="input-group-addon">.00</span>
                        </div>
                        <?php if($errors->has('fee_for_coe')): ?>
                            <?php echo $errors->first('fee_for_coe', '<label class="control-label"
                                                                      for="inputError">:message</label>'); ?>

                        <?php endif; ?>

                        <a href="<?php echo e($offer_letter->shelf_location); ?>" target="_blank">View Offer Letter</a><br>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-8 col-md-offset-3">
                        <?php echo e(Form::submit('Submit',['class'=>'btn btn-primary'])); ?>

                    </div>
                </div>

                <?php echo Form::close(); ?>

            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>
					 





<?php echo $__env->make('layouts.tenant', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>