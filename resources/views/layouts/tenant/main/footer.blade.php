<footer class="main-footer">
    <strong>Copyright © <a href="{{ url('/') }}">Condat</a>.</strong> All rights
    reserved.
</footer>

<!-- Datatable JS -->
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>

<script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>

<!-- iCheck -->
<script src="{{ asset('assets/plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script>
<!-- InputMask -->
<script src="{{ asset('assets/plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ asset('assets/plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
<script src="{{ asset('assets/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('assets/plugins/fastclick/fastclick.js') }}"></script>
<!-- Slim Scroll for Fixed Layout -->
<script src="{{ asset('assets/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ asset('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
<!-- Select 2 Dropdown -->
<script src="{{ asset('assets/plugins/select2/select2.full.min.js') }}"></script>
<!-- Bootstrap Datepicker Range -->
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
<!-- AdminLTE App -->
<script src="{{ asset('assets/js/app.js') }}"></script>
<script src="{{ asset('assets/js/tenant.js') }}"></script>
<script>
    var fn = function () {
        $.ajax({
            url: appUrl + '/subscription/check',
            type: 'get',
            success: function (resp) {
                if (resp == 0 || resp == 2) {
                    $('#renew-subscription').show();
                } else if (resp == 1) {
                    $('#renew-subscription').hide();
                }
            }
        });
    };
    fn();
</script>
{{-- Load additional JS --}}
<?php Condat::loadJS();?>

{!! Condat::loadModal() !!}