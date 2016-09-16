<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Add Intake</h4>
</div>
<?php echo Form::open(array('class' => 'form-horizontal form-left', 'id' => 'add-intake')); ?>

<div class="modal-body">
    <?php echo $__env->make('Tenant::Intake/form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
    <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i>
        Add
    </button>
</div>
<?php echo Form::close(); ?>