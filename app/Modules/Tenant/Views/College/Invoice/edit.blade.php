@extends('layouts.tenant')
@section('title', 'Update College Invoice')
@section('breadcrumb')
    @parent
    <li><a href="{{url($tenant_id.'/clients')}}" title="All Clients"><i class="fa fa-users"></i> Clients</a></li>
    <li>Add</li>
@stop
@section('content')

    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Update Invoice</h3>
            </div>
            @include('flash::message')
            {!!Form::model($invoice, array('route' => array('tenant.college.editInvoice', $tenant_id, $invoice->college_invoice_id), 'class' => 'form-horizontal form-left', 'method' => 'put'))!!}
            @include('Tenant::College/Invoice/form')
            <div class="box-footer clearfix">
                <input type="submit" class="btn btn-primary pull-right" value="Update"/>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#tuition_fee, #enrollment_fee, #material_fee, #coe_fee, #other_fee').trigger('keyup');
        });
    </script>
@stop