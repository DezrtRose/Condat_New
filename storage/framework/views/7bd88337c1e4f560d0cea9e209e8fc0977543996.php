<?php $__env->startSection('title', 'Client View'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    @parent
    <li><a href="<?php echo e(url('tenant/client')); ?>" title="All Clients"><i class="fa fa-users"></i> Clients</a></li>
    <li>View</li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <div class="container">
        <div class="row">
            <div class="client-navbar">
                <div class="col-sm-12 col-md-2">
                    <div class="container">
                        <img src="https://scontent-lax3-1.xx.fbcdn.net/v/t1.0-9/1936510_10207216981375364_4596889339024157957_n.jpg?oh=f3031e9add8769ca489e5865a54b6bc4&oe=57B0E02E"
                             class="img-rounded" alt="Cinque Terre" width="150" height="150">
                    </div>
                </div>
                <div class="col-sm-12 col-md-10">
                    <div class="row">

                        <h4><?php echo e($client->first_name); ?> <?php echo e($client->middle_name); ?> <b><?php echo e($client->last_name); ?></b></h4>

                        <p>University of Western Sydney</p>

                        <p>
                            Graduate Diploma of Professional Accounting
                        </p>
                    </div>
                    <div class="row">
                        <div id="navbar" class="navbar-collapse collapse">
                            <ul class="nav navbar-nav">
                                <li><a href=<?php echo e(url("tenant/clients/$client->client_id")); ?>>Dashboard</a></li>
                                <li><a href=<?php echo e(url("tenant/clients/$client->client_id/personal_details")); ?>>Personal
                                        Details</a></li>
                                <li class="active"><a href=<?php echo e(url("tenant/clients/$client->client_id/applications")); ?>>College
                                        Application</a></li>
                                <li><a href=<?php echo e(url("tenant/clients/$client->client_id/accounts")); ?>>Accounts</a></li>
                                <li><a href=<?php echo e(url("tenant/clients/$client->client_id/document")); ?>>Documents</a></li>
                                <li><a href=<?php echo e(url("tenant/clients/$client->client_id/notes")); ?>>Notes</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

    <div class="content">
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#navbar"
                        aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand visible-xs" href="#">AMS</a>
                <a class="navbar-brand menu-toggle" href="#"><i class="fa fa-user"></i> Show Client Menu</a>
            </div>

            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Dashboard</a></li>
                    <li><a href="#">Application Details</a></li>
                    <li><a href="#">College Invoice</a></li>
                    <li><a href="#">Students Payments</a></li>
                    <li><a href="#">Sub Agent Payments</a></li>
                    <li><a href="<?php echo e(url("tenant/clients/$client->client_id/innerdocument")); ?>">Documents</a></li>
                    <li><a href="<?php echo e(url("tenant/clients/$client->client_id/innernotes")); ?>">Notes</a></li>
                </ul>
            </div>
            <!--/.nav-collapse -->

        </div>
        <!--/.container-fluid -->
    </nav>

   
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
     <script class="cssdeck" type="text/javascript">
        $(".menu-toggle").click(function () {
        $(".client-navbar").slideToggle();
    });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.tenant', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>