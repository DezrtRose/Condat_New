<?php $__env->startSection('title', 'Client View'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    @parent
    <li><a href="<?php echo e(url('tenant/clients')); ?>" title="All Clients"><i class="fa fa-users"></i> Clients</a></li>
    <li>View</li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="container">
      
      <div class="row">
        <div class="col-sm-3">
          <div class="container">         
              <img src="https://scontent-lax3-1.xx.fbcdn.net/v/t1.0-9/1936510_10207216981375364_4596889339024157957_n.jpg?oh=f3031e9add8769ca489e5865a54b6bc4&oe=57B0E02E" class="img-rounded" alt="Cinque Terre" width="150" height="150"> 
          </div>
        </div>
        <div class="col-sm-9">
            <div class="row">
                <h4><?php echo e($client->first_name); ?> <?php echo e($client->middle_name); ?> <b><?php echo e($client->last_name); ?></b></h4>
                <p>E <?php echo e($client->email); ?> | P <?php echo e($client->number); ?></p>
                <p>
                    <?php echo e($client->street); ?>

                    <?php echo e($client->suburb); ?>

                    <?php echo e($client->state); ?>

                    <?php echo e($client->postcode); ?> 
                    <?php echo e(get_country($client->country_id)); ?>

                </p>


           </div>
            <div class="row">
                 <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand visible-xs" href="#">AMS</a>
                        </div>

                        <?php echo $__env->make('Tenant::Client/navbar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div><!--/.container-fluid -->
                </nav>
          
            </div>


        </div>
        
      </div>
      <div class="row">
<!-- About Me Box -->
    <div class="col-md-3">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">General Information</h3>
            </div>
        
        <!-- /.box-header -->
            <div class="box-body">
                
                <strong><i class="fa fa-file-text-o margin-r-5"></i> Client ID</strong>
                <p class="text-muted"><?php echo e(format_id($client->client_id, 'C')); ?></p>
                
                <strong><i class="fa fa-calendar margin-r-5"></i> Created At</strong>
                <p class="text-muted"><?php echo e(format_datetime($client->created_at)); ?></p>
                
                <strong><i class="fa fa-file-text-o margin-r-5"></i> Due Amount</strong>
                <p class="text-muted">200</p>

                <strong><i class="fa fa-file-text-o margin-r-5"></i> Referred By</strong>
                <p class="text-muted">Echha Dangol</p>
                
                <strong><i class="fa fa-file-text-o margin-r-5"></i> Description</strong>
                <p class="text-muted"><?php echo e($client->description); ?></p>
                
                
            </div>
        </div>
    </div>
    <!-- /.box-body -->
    <div class="col-md-9">
            <div class="row">
            
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Personal Details</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th style="width: 34%;">Client ID</th>
                                <td><?php echo e(format_id($client->client_id, 'C')); ?></td>
                            </tr>
                            <tr>
                                <th>First Name</th>
                                <td><?php echo e($client->first_name); ?></td>
                            </tr>
                            <tr>
                                <th>Middle Name</th>
                                <td><?php echo e($client->middle_name); ?></td>
                            </tr>
                            <tr>
                                <th>Last Name</th>
                                <td><?php echo e($client->last_name); ?></td>
                            </tr>
                            <tr>
                                <th>Sex</th>
                                <td><?php echo e($client->sex); ?></td>
                            </tr>
                            <tr>
                                <th>DOB</th>
                                <td><?php echo e(format_date($client->dob)); ?></td>
                            </tr>
                            <tr>
                                <th>Passport No.</th>
                                <td><?php echo e($client->passport_no); ?></td>
                            </tr>
                            <tr>
                                <th>Email Address</th>
                                <td><?php echo e($client->email); ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-map-marker"></i> Address Details</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th style="width: 34%;">Line 1</th>
                            <td><?php echo e($client->line1); ?></td>
                        </tr>
                        <tr>
                            <th>Line 2</th>
                            <td><?php echo e($client->line2); ?></td>
                        </tr>
                        <tr>
                            <th>Street</th>
                            <td><?php echo e($client->street); ?></td>
                        </tr>
                        <tr>
                            <th>Suburb</th>
                            <td><?php echo e($client->suburb); ?></td>
                        </tr>
                        <tr>
                            <th>Postcode</th>
                            <td><?php echo e($client->postcode); ?></td>
                        </tr>
                        <tr>
                            <th>State</th>
                            <td><?php echo e($client->state); ?></td>
                        </tr>
                        <tr>
                            <th>Country</th>
                            <td><?php echo e(get_country($client->country_id)); ?></td>
                        </tr>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </div>
</div>
</div>


    


    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.tenant', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>