<div class="container">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-sm-2">

                <img src="<?php echo e(($client->image != null)? $client->image : asset('assets/img/default-user.png')); ?>"
                     class="img-rounded"
                     alt="<?php echo e($client->first_name); ?> <?php echo e($client->middle_name); ?> <?php echo e($client->last_name); ?>"
                     height="150">

            </div>
            <div class="col-sm-10">
                <div class="container">
                    <div class="pull-right">
                        <a href="<?php echo e(route('tenant.client.compose', $client->client_id)); ?>"
                           class="btn btn-flat btn-success"><i class="fa fa-envelope"></i> Email</a>
                        <a href="<?php echo e(route('tenant.client.edit', $client->client_id)); ?>"
                           class="btn btn-flat btn-primary"><i class="fa fa-edit"></i> Edit</a>
                    </div>
                    <h4><?php echo e($client->first_name); ?> <?php echo e($client->middle_name); ?> <b><?php echo e($client->last_name); ?></b></h4>
                    <i class="fa fa-phone"></i> <?php echo e($client->number); ?> | <i
                            class="fa fa-envelope"></i> <?php echo e($client->email); ?> </br>
                    <address>
                        <?php echo e($client->street); ?>&nbsp;,
                        <?php echo e($client->suburb); ?>&nbsp;
                        <?php echo e($client->state); ?>&nbsp;
                        <?php echo e($client->postcode); ?>&nbsp;
                        <strong><?php echo e(get_country($client->country_id)); ?></strong>
                    </address>
                </div>
                <div class="container">
                    <nav class="navbar navbar-default">
                        <div class="container-fluid">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                        data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <a class="navbar-brand visible-xs" href="#">AMS</a>
                            </div>

                            <?php echo $__env->make('Tenant::Client/navbar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </div>
                        <!--/.container-fluid -->
                    </nav>

                </div>
            </div>
        </div>
    </div>

</div>