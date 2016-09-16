<?php $__env->startSection('title', 'Application COE Issued'); ?>
<?php $__env->startSection('heading', '<h1>Application - <small>COE Issued</small></h1>'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    @parent
    <li><a href="<?php echo e(url('tenant/clients')); ?>" title="All Applications"><i class="fa fa-users"></i> Applications</a></li>
    <li>COE Issued</li>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <div class="col-md-12">
        <?php echo $__env->make('Tenant::ApplicationStatus/partial/navbar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Application Offer Details</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-7 col-md-offset-1">
                        <?php echo Form::model($application, ['class'=>'form-horizontal', 'method'=>'POST', 'route'=>['applications.action.update.coe.issued', $application->application_id], 'files'=>true]); ?>


                        <div class="form-group <?php if($errors->has('tuition_fee')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                            <?php echo Form::label('tuition_fee', 'Total Tuition Fee', ['class'=>'col-md-3 form-label text-right']); ?>

                            <div class="col-md-9">
                                <?php echo Form::text('tuition_fee', null, array('class' => 'form-control', 'id'=>'tuition_fee')); ?>

                                <?php if($errors->has('tuition_fee')): ?>
                                    <?php echo $errors->first('tuition_fee', '<label class="control-label"
                                                                              for="inputError">:message</label>'); ?>

                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group">

                            <label for="intake" class="col-sm-3 control-label">Select Intake</label>

                            <div class="col-sm-9">
                                <?php echo Form::select('intake_id', $intakes, null, array('class' => 'form-control intake', 'id' => 'intake')); ?>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="end_date" class="col-sm-3 control-label">Finish Date</label>

                            <div class="col-sm-9">
                                <div class='input-group date'>
                                    <input type="text" name="end_date" class="form-control datepicker" id="end_date">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group <?php if($errors->has('document')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                            <?php echo e(Form::label('document', 'Upload Offer Letter', ['class'=>'col-md-3 form-label text-right'])); ?>

                            <div class="col-md-9">
                                <?php echo e(Form::file('document')); ?>

                                <?php if($errors->has('document')): ?>
                                    <?php echo $errors->first('document', '<label class="control-label"
                                                                              for="inputError">:message</label>'); ?>

                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group <?php if($errors->has('student_id')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                            <?php echo e(Form::label('student_id', 'Notes', ['class'=>'col-md-3 form-label text-right'])); ?>

                            <div class="col-md-9">
                                <?php echo e(Form::text('student_id', null, ['class'=>'form-control', 'placeholder'=>'Student ID'])); ?>

                                <?php if($errors->has('student_id')): ?>
                                    <?php echo $errors->first('student_id', '<label class="control-label"
                                                                              for="inputError">:message</label>'); ?>

                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php echo e(Form::submit('Submit',['class'=>'btn btn-primary pull-right'])); ?>

                            <?php echo e(Form::submit('Submit & Continue to Invoice',['class'=>'btn btn-success pull-left'])); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo e(Condat::js("$('.datepicker').datepicker({
                    format: 'dd/mm/yyyy',
                    autoclose: true,
                    todayHighlight: true
                });"
                )); ?>

<?php $__env->stopSection(); ?>





<?php echo $__env->make('layouts.tenant', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>