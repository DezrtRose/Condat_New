<?php $__env->startSection('title', 'Client Email'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    @parent
    <li><a href="<?php echo e(url('tenant/clients')); ?>" title="All Clients"><i class="fa fa-users"></i> Clients</a></li>
    <li>Email</li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <div class="container">
        <div class="row">
            <?php echo $__env->make('Tenant::Client/client_header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>

        <div class="col-md-12">
            <?php echo Form::open(array('files' => true)); ?>

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Compose New Message</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group">
                        <div class="form-control"><strong>To: </strong> <?php echo e($client->email); ?>

                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo Form::text('subject', null, array('class' => 'form-control', 'id'=>'subject', 'placeholder' => "Subject:")); ?>

                        <?php if($errors->has('subject')): ?>
                            <?php echo $errors->first('subject', '<label class="control-label"
                                                                     for="inputError">:message</label>'); ?>

                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <?php echo Form::textarea('body', null, array('class' => 'form-control', 'id'=>'compose-textarea', 'style' => "height: 300px")); ?>

                        <?php if($errors->has('body')): ?>
                            <?php echo $errors->first('body', '<label class="control-label"
                                                                     for="inputError">:message</label>'); ?>

                        <?php endif; ?>
                    </div>
                    <?php /*<div class="form-group">
                        <div class="btn btn-default btn-file">
                            <i class="fa fa-paperclip"></i> Attachment
                            <input type="file" name="attachment">
                        </div>
                        <p class="help-block">Max. 32MB</p>
                    </div>*/ ?>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="pull-right">
                        <button type="button" class="btn btn-default"><i class="fa fa-pencil"></i> Draft</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Send</button>
                    </div>
                    <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Discard</button>
                </div>
                <!-- /.box-footer -->
            </div>
            <?php echo Form::close(); ?>

            <!-- /. box -->
        </div>
    </div>

    <script>
        $(function () {
            //Add text editor
            $("#compose-textarea").wysihtml5();
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.tenant', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>