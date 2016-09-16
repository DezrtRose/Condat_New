<?php $__env->startSection('title', 'Application Enquiry'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    @parent
    <li><a href="<?php echo e(url('tenant/clients')); ?>" title="All Clients"><i class="fa fa-users"></i> Clients</a></li>
    <li>Notes</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container">
		<div class="row">
			<div class="col-md-12">
				<?php if(count($errors)>0): ?>
					<div class="alert alert-waring">
						<ul>
						<?php foreach($errors->all() as $error): ?>
							<li><?php echo e($error); ?></li>
						<?php endforeach; ?>
						</ul>
					</div>
				<?php endif; ?>
				<h1 class="margin-down"><?php echo e($applications->first_name); ?> - <small>Cancel Application</small></h1>
				
				 <?php echo $__env->make('Tenant::ApplicationStatus/partial/navbar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
				
				<div class="box box-primary">
					<div class="box-body">
						<?php echo Form::open([
									'class'=>'form-horizontal',
									'route'=>['applications.cancel', $applications->course_application_id]
						]); ?>	
						
							<div class="form-group">
								<?php echo e(Form::label('institute_name', 'Institute Name',['class'=>'col-md-3 form-label text-right'])); ?>

								<div class="col-md-9">
									<?php echo e($applications->company); ?>	
								</div>
							</div>

							<div class="form-group">
								<?php echo e(Form::label('course_name', 'Course Name',['class'=>'col-md-3 form-label text-right'])); ?>

								<div class="col-md-9">
								<?php echo e($applications->name); ?>	
								</div>
							</div>

							<div class="form-group">
								<?php echo e(Form::label('notes', 'Notes', ['class'=>'col-md-3 form-label text-right'])); ?>

								<div class="col-md-9">
								<?php echo e(Form::textarea('notes', '', ['class'=>'col-md-6','rows'=>5])); ?>	
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-9 col-md-offset-3">
								<?php echo e(Form::submit('Cancel',['class'=>'btn btn-primary'])); ?>

								</div>
							</div>

						<?php echo Form::close(); ?>

					</div>
				</div>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>
					 





<?php echo $__env->make('layouts.tenant', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>