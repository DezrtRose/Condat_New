@extends('layouts.tenant')
@section('title', 'College Invoice Advanced Search')
@section('heading', '<h1>College Invoice - <small>Advanced Search</small></h1>')
@section('breadcrumb')
    @parent
    <li><a href="{{url($tenant_id.'/clients')}}" title="All College Invoices"><i class="fa fa-users"></i> Institute
            Invoices</a></li>
    <li>Advanced Search</li>
@stop

@section('content')
    <div class="col-md-12">
        @include('Tenant::InvoiceReport/CollegeInvoice/partial/navbar')
        @include('flash::message')
    </div>

    <div class="col-md-12 col-xs-12">
        <div class="box box-primary">
            {!!Form::model($search_attributes, array('route' => ['college.invoice', $tenant_id], 'method' => 'post', 'class' => ''))!!}
            <div class="box-header">
                <h3 class="box-title">Filter Options</h3>
                <input type="submit" class="btn btn-primary pull-right" value="Search"/>
            </div>

            <div class="box-body">

                <div class="form-group col-md-4 col-xs-12">
                    {!!Form::label('status', 'Status', array('class' => 'control-label')) !!}
                    {!!Form::select('status', $status, null, array('class' => 'form-control select2'))!!}
                </div>

                <div class="form-group col-md-4 col-xs-12">
                    {!!Form::label('invoice_to', 'Super Agent', array('class' => 'control-label')) !!}
                    {!!Form::select('invoice_to', $invoice_to_list, null, array('class' => 'form-control select2'))!!}
                </div>

                <div class="form-group col-md-4 col-xs-12">
                    {!!Form::label('college_name', 'Institute Name', array('class' => 'control-label')) !!}
                    {!!Form::select('college_name[]', $colleges, null, array('class' => 'form-control select2', 'multiple' => 'multiple'))!!}
                </div>


                <div class="form-group col-md-4 col-xs-12">
                    {!!Form::label('client_name', 'Client Name', array('class' => 'control-label')) !!}
                    {!!Form::select('client_name[]', $clients, null, array('class' => 'form-control select2', 'multiple' => 'multiple'))!!}
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
                    {!!Form::label('amount', 'Total Amount', array('class' => 'control-label')) !!}
                    <div class="row">
                        <div class="col-xs-6"> {!!Form::number('from', null, array('class' => 'form-control', 'placeholder' => 'From', 'id'=>'from'))!!}</div>
                        <div class="col-xs-6"> {!!Form::number('to', null, array('class' => 'form-control', 'placeholder' => 'To', 'id'=>'to'))!!}</div>
                    </div>
                </div>
            </div>
            {!!Form::close()!!}
        </div>
    </div>

    <div class="col-md-12 col-xs-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Filtered College Invoices</h3>
            </div>
            <div class="box-body table-responsive">
                @if(isset($invoice_reports))
                    @include('Tenant::InvoiceReport/CollegeInvoice/partial/table')
                @else
                    <div class="callout callout-warning">
                        <h4>No Filtered Records!</h4>

                        <p>You can search for the applications by providing the details in the form.</p>
                    </div>
                @endif
            </div>
        </div>

    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#invoice_report_table').DataTable({
                "pageLength": 50,
                order: [[0, 'desc']],
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });

            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true
            });

            $('.dateranger').daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY'
                },
                autoUpdateInput: false
            });

            $('.dateranger').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            });

            $('.dateranger').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        });
    </script>
@stop