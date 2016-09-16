<footer class="main-footer">
    <strong>Copyright © <a href="<?php echo e(url('/')); ?>">Webunisoft</a>.</strong> All rights
    reserved.
</footer>

<!-- Datatable JS -->
<script src="<?php echo e(asset('assets/plugins/datatables/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/plugins/datatables/dataTables.bootstrap.min.js')); ?>"></script>
<!-- iCheck -->
<script src="<?php echo e(asset('assets/plugins/iCheck/icheck.min.js')); ?>" type="text/javascript"></script>
<!-- InputMask -->
<script src="<?php echo e(asset('assets/plugins/input-mask/jquery.inputmask.js')); ?>"></script>
<script src="<?php echo e(asset('assets/plugins/input-mask/jquery.inputmask.date.extensions.js')); ?>"></script>
<script src="<?php echo e(asset('assets/plugins/input-mask/jquery.inputmask.extensions.js')); ?>"></script>
<!-- FastClick -->
<script src="<?php echo e(asset('assets/plugins/fastclick/fastclick.js')); ?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo e(asset('assets/js/app.js')); ?>"></script>

<?php /* Load additional JS */ ?>
<?php Condat::loadJS();?>

<?php echo Condat::loadModal(); ?>