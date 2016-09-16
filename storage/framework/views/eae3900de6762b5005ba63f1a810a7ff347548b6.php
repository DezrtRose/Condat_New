<?php $__env->startSection('title', 'Client Notes'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    @parent
    <li><a href="<?php echo e(url('tenant/clients')); ?>" title="All Clients"><i class="fa fa-users"></i> Clients</a></li>
    <li>Notes</li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <div class="container">
        <div class="row">
            <div class="col-sm-2">
                <div class="container">
                    <img src="https://scontent-lax3-1.xx.fbcdn.net/v/t1.0-9/1936510_10207216981375364_4596889339024157957_n.jpg?oh=f3031e9add8769ca489e5865a54b6bc4&oe=57B0E02E"
                         class="img-rounded" alt="Cinque Terre" width="150" height="150">
                </div>
            </div>
            <div class="col-sm-10">
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

    <div class="col-md-3">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Add Notes:</h3>
            </div>

            <!-- /.box-header -->
            <div class="box-body">

                <form action='' method="POST">
                    <div class="form-group">
                        <textarea name="filter" class="form-control" id="filter"></textarea>
                    </div>
                    <div class="checkbox form-group">
                        <label><input type="checkbox" id="remind"> Add to Reminder</label>
                    </div>
                    <div id="reminderDate" style="display: none">
                        <div class="form-group">
                            <label for="reminder_date" class="control-label">Reminder Date</label>

                            <div class="">
                                <div class='input-group date'>
                                    <input type="text" name="reminder_date" class="form-control datepicker"
                                           id="reminder_date" placeholder="yyyy-mm-dd">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>


            </div>
        </div>
        <!-- /.box -->
    </div>

    <div class="col-xs-9">
        <div class="box box-primary">
            <div class="box-header with-border">

                <b>

                    <div class="col-md-6">Notes</div>
                    <div class="col-md-2">Remind Me</div>
                    <div class="col-md-2">Added By</div>
                    <div class="col-md-2">Processing</div>

                </b>
            </div>

            <div class="box-body">
                <!-- data -->

                <div class="row">
                    <div class="col-md-6">Request offer letter from CQU</div>
                    <div class="col-md-2"><i class="glyphicon glyphicon-ok"></i> (20/09/2015)</div>
                    <div class="col-md-2">Krita Maharjan</div>
                    <div class="col-md-2">
                        <div>
                            <a href="#" title="Edit" class="btn"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                            <a href="#" title="Delete" class="btn"><i class="glyphicon glyphicon-trash"></i>
                                Delete</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">Create Payment invoice of Amount $1000</div>
                    <div class="col-md-2"><i class="glyphicon glyphicon-remove"></i></div>
                    <div class="col-md-2">Krita Maharjan</div>
                    <div class="col-md-2">
                        <div>
                            <a href="#" title="Edit" class="btn"><i class="glyphicon glyphicon-pencil"></i>Edit</a>
                            <a href="#" title="Delete" class="btn"><i class="glyphicon glyphicon-trash"></i>Delete</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Bootstrap date picker -->
    <script type="text/javascript">
        $(function () {
            $('.datepicker').datepicker({
                format: "yyyy-mm-dd",
                startDate: '+0d',
                autoclose: true,
                todayHighlight: true
            });

        });

        $(document).ready(function () {
            $('#remind').change(function () {
                if (this.checked)
                    $('#reminderDate').fadeIn('slow');
                else
                    $('#reminderDate').fadeOut('slow');

            });
        });

    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.tenant', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>