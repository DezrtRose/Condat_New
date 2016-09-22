@extends('layouts.tenant')
@section('title', 'Group Invoice')
@section('heading', 'Invoice - <small>Group</small>')
@section('breadcrumb')
    @parent
    <li><a href="{{url('tenant/clients')}}" title="All Clients"><i class="fa fa-users"></i> Clients</a></li>
    <li>Invoices</li>
@stop

@section('content')
    <div class="col-md-12">

        @include('flash::message')
        <div class="box box-primary">
            {!!Form::model($search_attributes, array('route' => 'college.invoice.groupInvoice', 'method' => 'post', 'class' => ''))!!}
            <div class="box-header">
                <h3 class="box-title">Filter Options</h3>
                <input type="submit" class="btn btn-primary pull-right" value="Search"/>
            </div>

            <div class="box-body">

                <div class="form-group col-md-4 col-xs-12">
                    {!!Form::label('college_name', 'Invoice To', array('class' => 'control-label')) !!}
                    {!!Form::select('college_name[]', $colleges, null, array('class' => 'form-control select2', 'multiple' => 'multiple'))!!}
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
            </div>
            <div class="box-footer clearfix">
                <strong>Note : </strong>Search will Display Pending Invoices Only.
                <input type="submit" class="btn btn-primary pull-right" value="Search"/>
            </div>
            {!!Form::close()!!}
        </div>

        <div class="box box-primary">
            <div class="box-body">
                <?php $is_group = true ?>
                @include('Tenant::InvoiceReport/CollegeInvoice/partial/table')
            </div>
            <div class="box-footer clearfix">
                <input type="reset" class="btn btn-primary pull-left" value="Check All"/>
                <input type="submit" class="btn btn-primary pull-right" value="Generate Group Invoice"/>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#invoice_report_table').DataTable({
                "pageLength": 10
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
        });
    </script>
@stop