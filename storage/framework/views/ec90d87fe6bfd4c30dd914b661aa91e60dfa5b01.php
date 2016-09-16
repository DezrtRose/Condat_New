<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Assign To Invoice</h4>
</div>
<?php echo Form::open(['url' => 'tenant/payment/'.$payment_id.'/assign', 'id' => 'add-invoice', 'class' => 'form-horizontal form-left']); ?>

<div class="modal-body">
    <div class="form-group">
        <?php echo Form::label('invoice_id', 'Invoice', array('class' => 'col-sm-4 control-label')); ?>

        <div class="col-sm-8">
            <?php echo Form::select('invoice_id', $invoice_array, null, array('class' => 'form-control', 'id'=>'invoice_id')); ?>

        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
    <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i>
        Assign
    </button>
</div>
<?php echo Form::close(); ?>