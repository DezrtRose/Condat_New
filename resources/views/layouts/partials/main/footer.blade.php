<footer class="main-footer">
    <strong>Copyright © <a href="{{ url('/') }}">Webunisoft</a>.</strong> All rights
    reserved.
</footer>

<!-- Datatable JS -->
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>

<!-- InputMask -->
<script src="{{ asset('assets/plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ asset('assets/plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
<script src="{{ asset('assets/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>

<!-- FastClick -->
<script src="{{ asset('assets/plugins/fastclick/fastclick.js') }}"></script>

<!-- AdminLTE App -->
<script src="{{ asset('assets/js/app.js') }}"></script>

<!-- Common JS -->
<script src="{{ asset('assets/js/commmon.js') }}"></script>

{{-- Load additional JS --}}
<?php Condat::loadJS();?>