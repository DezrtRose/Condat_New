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
<!-- Slim Scroll for Fixed Layout -->
<script src="<?php echo e(asset('assets/plugins/slimScroll/jquery.slimscroll.min.js')); ?>"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo e(asset('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')); ?>"></script>
<!-- Select 2 Dropdown -->
<script src="<?php echo e(asset('assets/plugins/select2/select2.full.min.js')); ?>"></script>
<!-- Bootstrap Datepicker Range -->
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
<!-- AdminLTE App -->
<script src="<?php echo e(asset('assets/js/app.js')); ?>"></script>

<?php /* Load additional JS */ ?>
<?php Condat::loadJS();?>

<?php echo Condat::loadModal(); ?>