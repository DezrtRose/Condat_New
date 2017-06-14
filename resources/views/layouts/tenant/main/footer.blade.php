<!-- contact form start -->
<div class="modal fade" id="contactModal" tabindex="-1" role="dialog" aria-labelledby="contactModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Send us your queries</h4>
            </div>
            {!! Form::open(array('class' => 'form enquiry-form')) !!}
            <div class="modal-body">

                <div class="form-group">
                    <label for="subject">Subject *</label>
                    <input type="text" class="form-control" name="subject" id="subject" placeholder="Enter Subject" required />
                </div>

                <div class="form-group">
                    <label for="message">Message *</label>
                    <textarea class="form-control" id="message" name="message" placeholder="Enter Message" required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-info pull-right">Submit</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<!-- contact form end -->

<!--Start of Tawk.to Script-->
{{--<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/58f9a5d24ac4446b24a6b5f1/default';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
    })();
</script>--}}
<!--End of Tawk.to Script-->

<footer class="main-footer">
    <strong>Copyright © <a href="{{ url('/') }}">Condat</a>.</strong> All rights
    reserved.
    <button type="button" class="btn btn-primary btn-flat pull-right" data-toggle="modal" data-target="#contactModal">
        Get Support
    </button>
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
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css"/>
<!-- AdminLTE App -->
<script src="{{ asset('assets/js/app.js') }}"></script>
<script src="{{ asset('assets/js/tenant.js') }}"></script>
{{-- Load additional JS --}}
<?php Condat::loadJS();?>

{!! Condat::loadModal() !!}