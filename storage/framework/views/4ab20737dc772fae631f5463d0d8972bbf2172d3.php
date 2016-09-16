<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Locations in Australia</h3>
    </div>
    <div class="box-body">
        <table id="addresses" class="table table-hover">
            <thead>
            <tr>
                <th>Address</th>
                <th>State</th>
                <th>Phone</th>
                <th>Email</th>
                <th></th>
            </tr>
            </thead>
        </table>
    </div>
    <div class="box-footer">
        <button class="btn btn-success pull-right" data-toggle="modal" data-target="#addressModal"><i
                    class="glyphicon glyphicon-plus-sign"></i> Address
        </button>
    </div>
</div>

<!-- Add Address Modal -->
<div id="addressModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Address</h4>
            </div>
            <?php echo Form::open(['url' => 'tenant/institutes/'.$institute->institution_id.'/address/store', 'id' =>
            'add-address', 'class' => 'form-horizontal form-left']); ?>

            <div class="modal-body">

                <div class="form-group">
                    <?php echo Form::label('street', 'Street', array('class' => 'col-sm-4 control-label')); ?>

                    <div class="col-sm-8">
                        <?php echo Form::text('street', null, array('class' => 'form-control', 'id'=>'street')); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo Form::label('suburb', 'Suburb', array('class' => 'col-sm-4 control-label')); ?>

                    <div class="col-sm-8">
                        <?php echo Form::text('suburb', null, array('class' => 'form-control', 'id'=>'suburb')); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo Form::label('state', 'State', array('class' => 'col-sm-4 control-label')); ?>

                    <div class="col-sm-8">
                        <?php echo Form::text('state', null, array('class' => 'form-control', 'id'=>'state')); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo Form::label('postcode', 'Postcode', array('class' => 'col-sm-4 control-label')); ?>

                    <div class="col-sm-8">
                        <?php echo Form::text('postcode', null, array('class' => 'form-control', 'id'=>'postcode')); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo Form::label('number', 'Phone Number *', array('class' => 'col-sm-4 control-label')); ?>

                    <div class="col-sm-8">
                        <?php echo Form::text('number', null, array('class' => 'form-control phone-input', 'id'=>'number')); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo Form::label('email', 'Email Address *', array('class' => 'col-sm-4 control-label')); ?>

                    <div class="col-sm-8">
                        <?php echo Form::email('email', null, array('class' => 'form-control', 'id'=>'email')); ?>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i>
                    Add
                </button>
            </div>
            <?php echo Form::close(); ?>

        </div>

    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        aTable = $('#addresses').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": appUrl + "/tenant/institutes/<?= $institute->institution_id ?>/addresses",
            "columns": [
                {data: 'address', name: 'address'},
                {data: 'state', name: 'state'},
                {data: 'number', name: 'number'},
                {data: 'email', name: 'email'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });
</script>

