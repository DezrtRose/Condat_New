@extends('layouts.tenant')
@section('title', 'Group Invoice')
@section('heading', 'Invoice - <small>Group</small>')
@section('breadcrumb')
    @parent
    <li><a href="{{url($tenant_id.'/clients')}}" title="All Clients"><i class="fa fa-users"></i> Clients</a></li>
    <li>Invoices</li>
@stop

@section('content')
    <div class="col-md-12">

        @include('flash::message')
        <div class="box box-primary">
            {!!Form::model($search_attributes, array('route' => ['college.invoice.groupInvoice', $tenant_id], 'method' => 'post', 'class' => ''))!!}
            <div class="box-header">
                <h3 class="box-title">Filter Options</h3>
                <input type="submit" class="btn btn-primary pull-right" value="Search"/>
            </div>

            <div class="box-body">

                <div class="form-group col-md-4 col-xs-12">
                    {!!Form::label('invoice_to', 'Super Agent', array('class' => 'control-label')) !!}
                    {!!Form::select('invoice_to', $invoice_to_list, null, array('class' => 'form-control select2'))!!}
                </div>

                <div class="form-group col-md-4 col-xs-12">
                    {!!Form::label('college_name', 'Institute Name', array('class' => 'control-label')) !!}
                    {!!Form::select('college_name[]', $colleges, null, array('class' => 'form-control select2', 'multiple' => 'multiple'))!!}
                </div>

                <div class="form-group col-md-4 col-xs-12">
                    {!!Form::label('invoice_date', 'Invoice Date', array('class' => 'control-label')) !!}
                    <div class='input-group'>
                        {!!Form::text('invoice_date', null, array('class' => 'form-control dateranger', 'id'=>'invoice_date', 'placeholder' => "Select Date Range"))!!}
                        <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                    </div>
                </div>
                <div class="form-group col-md-4 col-xs-12">
                    {!!Form::label('amount', 'Amount', array('class' => 'control-label')) !!}
                    <div class="row">
                        <div class="col-xs-6"> {!!Form::number('from', null, array('class' => 'form-control', 'placeholder' => 'From', 'id'=>'from'))!!}</div>
                        <div class="col-xs-6"> {!!Form::number('to', null, array('class' => 'form-control', 'placeholder' => 'To', 'id'=>'to'))!!}</div>
                    </div>
                </div>
            </div>
            <div class="box-footer clearfix">
                <strong>Note : </strong>Search will Display Pending Invoices Only.
                <input type="submit" class="btn btn-primary pull-right" value="Search"/>
            </div>
            {!!Form::close()!!}
        </div>

        <div class="box box-info">
            <div class="box-body">
                <?php $is_group = true ?>
                @include('Tenant::InvoiceReport/CollegeInvoice/partial/table')
            </div>
            <div class="box-footer clearfix">
                <input type="button" class="btn btn-primary pull-left check" value="Check All"/>
                <a class="btn btn-primary pull-right" data-toggle="modal" data-target="#condat-modal" data-url="{{ url($tenant_id.'/invoice/group') }}"><i class="glyphicon glyphicon-plus-sign"></i> Generate Group Invoice</a>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#invoice_report_table').DataTable({
                "pageLength": 50,
                order: [[0, 'desc']]
            });

            $('.dateranger').daterangepicker({
                autoUpdateInput: false
            });

            $('.dateranger').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            });

            $('.dateranger').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });

            $(".icheck").iCheck({
                checkboxClass: 'icheckbox_square-blue'
            });

            $('.icheck').iCheck('uncheck');

            $('.check').on('click', function (event) {
                var $this = $(this);
                if ($('.icheck').filter(':checked').length == $('.icheck').length) {
                    $('.icheck').iCheck('uncheck');
                    $this.val('Check All');
                } else {
                    $('.icheck').iCheck('check');
                    $this.val('Uncheck All');
                }
            });

            // process the add invoice form
            $(document).on("submit", "#add-invoice", function (event) {
                //var groupIds = $('.group-ids').val();
                var groupIds = getSelectedValues();
                var formData = $(this).serializeArray();
                formData.push({name: 'group_ids', value: groupIds});
                $(this).find('.has-error').removeClass('has-error');
                $(this).find('label.error').remove();
                $(this).find('.callout').remove();
                var url = $(this).attr('action');

                // process the form
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: formData,
                    dataType: 'json',
                    encode: true
                })
                        .done(function (result) {
                            if (result.status == 1) {
                                $('#condat-modal').modal('hide');
                                $('.box-primary').before(notify('success', 'Added To Group Successfully!'));
                            }
                            else {
                                $.each(result.data.errors, function (i, v) {
                                    $('#add-invoice').find('#' + i).after('<label class="error ">' + v + '</label>').closest('.form-group').addClass('has-error');
                                });
                            }
                            setTimeout(function () {
                                $('.callout').remove()
                            }, 2500);
                        });
                event.preventDefault();
            });

            function getSelectedValues(){
                var chkArray = [];
                $(".group-ids:checked").each(function() {
                    chkArray.push($(this).val());
                });
                return chkArray;
            }
        });

        function notify(type, text) {
            return '<div class="callout callout-' + type + '"><p>' + text + '</p></div>';
        }
    </script>
    {!! Condat::registerModal('modal-lg') !!}
@stop