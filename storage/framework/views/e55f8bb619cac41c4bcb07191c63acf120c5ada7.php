<?php $__env->startSection('title', 'Client Documents'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    @parent
    <li><a href="<?php echo e(url('client')); ?>" title="All Clients"><i class="fa fa-users"></i> Clients</a></li>
    <li><i class="fa fa-file"></i> Documents</li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <div class="container">
        <div class="row">
        <?php echo $__env->make('Tenant::Client/client_header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 
        </div>
    </div>

    <div class="pad margin no-print">
        <div class="callout callout-info" style="margin-bottom: 0!important;">
            <h4><i class="fa fa-info"></i> Note:</h4>
            The supported mime types for the documents are Images, Word, TXT, PDF and Excel files.
        </div>
    </div>
    <div class="col-xs-12 mainContainer">
        <?php echo $__env->make('flash::message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <div class="col-md-4 col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Upload File</h3>
                </div>

                <div class="box-body">
                    <?php echo Form::open(['files' => true, 'method' => 'post']); ?>

                    <div class="form-group <?php if($errors->has('type')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                        <?php echo Form::label('type', 'Document Type *', array('class' => '')); ?>

                        <?php echo Form::text('type', null, array('class' => 'form-control')); ?>

                        <?php if($errors->has('type')): ?>
                            <?php echo $errors->first('type', '<label class="control-label"
                                                               for="inputError">:message</label>'); ?>

                        <?php endif; ?>
                    </div>
                    <div class="form-group <?php if($errors->has('description')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                        <?php echo Form::label('description', 'Description *', array('class' => '')); ?>

                        <?php echo Form::textarea('description', null, array('class' => 'form-control')); ?>

                        <?php if($errors->has('description')): ?>
                            <?php echo $errors->first('description', '<label class="control-label"
                                                                      for="inputError">:message</label>'); ?>

                        <?php endif; ?>
                    </div>
                    <div class="form-group <?php if($errors->has('document')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
                        <?php echo Form::label('document', 'File *', array('class' => '')); ?>

                        <?php echo Form::file('document', null, array('class' => 'form-control')); ?>

                        <?php if($errors->has('document')): ?>
                            <?php echo $errors->first('document', '<label class="control-label"
                                                                   for="inputError">:message</label>'); ?>

                        <?php endif; ?>
                    </div>

                    <div class="form-group pull-right clearfix">
                        <?php echo Form::submit('Upload', ['class' => "btn btn-primary"]); ?>

                    </div>
                    <?php echo Form::close(); ?>


                    <div class="clearfix"></div>
                    <?php if(count($errors) > 0): ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php foreach($errors->all() as $error): ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-8 col-xs-12">
            <div class="box box-primary">
                <div class="box-body table-responsive">
                    <h3 class="text-center">Uploaded Files</h3>
                    <hr/>
                    <?php if(count($documents) > 0): ?>
                    <table id="table-lead" class="table table-hover">
                        <thead>
                        <tr>
                            <th>Uploaded On</th>
                            <th>Uploaded By</th>
                            <th>Filename</th>
                            <th>Document Type</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($documents as $key => $document): ?>
                            <tr>
                                <td><?php echo e(format_datetime($document->document->created_at)); ?></td>
                                <td><?php echo e(get_tenant_name($document->document->user_id)); ?></td>
                                <td><?php echo e($document->document->name); ?></td>
                                <td><?php echo e($document->document->type); ?></td>
                                <td><?php echo e($document->document->description); ?></td>
                                <td><a href="<?php echo e($document->document->shelf_location); ?>"
                                       target="_blank"><i class="fa fa-eye"></i> View</a>
                                    <a href="<?php echo e(route('tenant.client.document.download', $document->document_id)); ?>"
                                       target="_blank"><i class="fa fa-download"></i> Download</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                        <p class="text-muted well">
                            No documents uploaded yet.
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php echo Condat::js('client/document.js');; ?>

    <script type="text/javascript">
        $(function() {
            $('#profile-image').on('click', function() {
                $('#profile-image-upload').click();
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.tenant', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>