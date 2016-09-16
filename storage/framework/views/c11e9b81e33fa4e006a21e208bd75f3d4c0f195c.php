<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Add Payment</h4>
</div>
<?php echo Form::open(['id' => 'add-payment', 'class' => 'form-horizontal form-left']); ?>

<div class="modal-body">
    <?php if($type == 1): ?>
        <?php $pay_type = 3; //for different payment method ?>
        <?php echo $__env->make('Tenant::College/Payment/form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php elseif($type == 2): ?>
        <?php echo $__env->make('Tenant::Student/Payment/form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php else: ?>
        <?php echo $__env->make('Tenant::SubAgent/Payment/form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php endif; ?>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
    <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i>
        Add
    </button>
</div>
<?php echo Form::close(); ?>