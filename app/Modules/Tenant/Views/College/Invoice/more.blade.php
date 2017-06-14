@extends('layouts.tenant')
@section('title', 'Add More College Invoices')
@section('breadcrumb')
    @parent
    <li><a href="{{url($tenant_id.'/clients')}}" title="All Clients"><i class="fa fa-users"></i> Clients</a></li>
    <li>Add</li>
@stop
@section('content')

    <div class="col-xs-12">
        @include('flash::message')

        {!!Form::model($invoice, ['route' => ['tenant.college.storeMoreInvoice', $tenant_id, $invoice->course_application_id], 'id' => 'add-invoice', 'class' => 'form-horizontal form-left'])!!}
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Add More College Invoices</h3>
            </div>
            <div class="box-body">
                <div class="form-group">
                    {!!Form::label('num', 'Number Of Invoices', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::select('num', [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10], 1, array('class' => 'form-control input-xs', 'id' => 'num'))!!}
                        {{--{!!Form::number('num', null, array('class' => 'form-control', 'id'=>'num', 'min'=>1))!!}--}}
                    </div>
                </div>
                <div class="form-group">
                    {!!Form::label('duration', 'Duration (Months)', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {{--{!!Form::number('duration', null, array('class' => 'form-control input-xs', 'id' => 'duration', 'placeholder' => 'Months'))!!}--}}
                        {!!Form::select('duration', [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, 11 => 11, 12 => 12, 13 => 13, 14 => 14, 15 => 15, 16 => 16, 17 => 17, 18 => 18, 19 => 19, 20 => 20, 21 => 21, 22 => 22, 23 => 23, 24 => 24], 1, array('class' => 'form-control input-xs', 'id' => 'duration'))!!}
                    </div>
                </div>
                <div class="form-group @if($errors->has('start_date')) {{'has-error'}} @endif">
                    {!!Form::label('start_date', 'Start Date *', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        <div class="input-group" id="start_date">
                            {!!Form::text('start_date', null, array('class' => 'form-control date-picker', 'autocomplete' => 'off'))!!}
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                        </div>

                        @if($errors->has('start_date'))
                            {!! $errors->first('start_date', '<label class="control-label"
                                                                     for="inputError">:message</label>') !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">College Invoices Details</h3>
            </div>
            <div class="box-body">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="panel-title">Commission on Tuition Fee</span>
                        <a href="#" class="btn btn-warning btn-collapse btn-flat btn-xs pull-right"><i
                                    class="fa fa-minus-circle"></i> Remove</a>
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-6">

                            <div class="form-group @if($errors->has('tuition_fee')) {{'has-error'}} @endif">
                                {!!Form::label('tuition_fee', 'Tuition Fee *', array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$</span>
                                        {!!Form::text('tuition_fee', null, array('class' => 'form-control', 'id'=>'tuition_fee'))!!}
                                    </div>
                                    @if($errors->has('tuition_fee'))
                                        {!! $errors->first('tuition_fee', '<label class="control-label"
                                                                               for="inputError">:message</label>') !!}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group @if($errors->has('enrollment_fee')) {{'has-error'}} @endif">
                                {!!Form::label('enrollment_fee', 'Enrollment Fee *', array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$</span>
                                        {!!Form::text('enrollment_fee', null, array('class' => 'form-control', 'id'=>'enrollment_fee',))!!}
                                    </div>
                                    @if($errors->has('enrollment_fee'))
                                        {!! $errors->first('enrollment_fee', '<label class="control-label"
                                                                                 for="inputError">:message</label>') !!}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group @if($errors->has('material_fee')) {{'has-error'}} @endif">
                                {!!Form::label('material_fee', 'Material Fee *', array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$</span>
                                        {!!Form::text('material_fee', null, array('class' => 'form-control', 'id'=>'material_fee'))!!}
                                    </div>
                                    @if($errors->has('material_fee'))
                                        {!! $errors->first('material_fee', '<label class="control-label"
                                                                                 for="inputError">:message</label>') !!}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group @if($errors->has('coe_fee')) {{'has-error'}} @endif">
                                {!!Form::label('coe_fee', 'COE Fee *', array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$</span>
                                        {!!Form::text('coe_fee', null, array('class' => 'form-control', 'id'=>'coe_fee'))!!}
                                    </div>
                                    @if($errors->has('coe_fee'))
                                        {!! $errors->first('coe_fee', '<label class="control-label"
                                                                                 for="inputError">:message</label>') !!}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group @if($errors->has('other_fee')) {{'has-error'}} @endif">
                                {!!Form::label('other_fee', 'Other Fee*', array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$</span>
                                        {!!Form::text('other_fee', null, array('class' => 'form-control', 'id'=>'other_fee'))!!}
                                    </div>
                                    @if($errors->has('other_fee'))
                                        {!! $errors->first('other_fee', '<label class="control-label"
                                                                                 for="inputError">:message</label>') !!}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group @if($errors->has('sub_total')) {{'has-error'}} @endif">
                                {!!Form::label('sub_total', 'Sub Total *', array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$</span>
                                        {!!Form::text('sub_total', null, array('class' => 'form-control', 'id'=>'sub_total','placeholder'=>'click to calculate'))!!}
                                    </div>
                                    @if($errors->has('sub_total'))
                                        {!! $errors->first('sub_total', '<label class="control-label"
                                                                                 for="inputError">:message</label>') !!}
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">

                            <div class="form-group @if($errors->has('description')) {{'has-error'}} @endif">
                                {!!Form::label('description', 'Description *', array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    {!!Form::text('description', null, array('class' => 'form-control', 'id'=>'description'))!!}
                                    @if($errors->has('description'))
                                        {!! $errors->first('description', '<label class="control-label"
                                                                                for="inputError">:message</label>') !!}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group @if($errors->has('commission_percent')) {{'has-error'}} @endif">
                                {!!Form::label('commission_percent', 'Commission Percent *', array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    <div class="input-group">

                                        {!!Form::text('commission_percent', null, array('class' => 'form-control', 'id'=>'commission_percent'))!!}
                                        <span class="input-group-addon">%</span>
                                    </div>
                                    @if($errors->has('commission_percent'))
                                        {!! $errors->first('commission_percent', '<label class="control-label"
                                                                                 for="inputError">:message</label>') !!}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group @if($errors->has('commission_amount')) {{'has-error'}} @endif">
                                {!!Form::label('commission_amount', 'Commission Amount *', array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$</span>
                                        {!!Form::text('commission_amount', null, array('class' => 'form-control', 'id'=>'commission_amount','placeholder'=>'click to calculate'))!!}
                                    </div>
                                    @if($errors->has('commission_amount'))
                                        {!! $errors->first('commission_amount', '<label class="control-label"
                                                                                 for="inputError">:message</label>') !!}
                                    @endif
                                </div>
                            </div>
                            <div class="form-group @if($errors->has('tuition_fee_gst')) {{'has-error'}} @endif">
                                {!!Form::label('tuition_fee_gst', 'Commission GST *', array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$</span>
                                        {!!Form::text('tuition_fee_gst', null, array('class' => 'form-control', 'id'=>'tuition_fee_gst','placeholder'=>'10% of Commission Amount','readonly' => 'true'))!!}
                                        <span class="input-group-addon">
                                        {{ Form::checkbox('gst_checker_tuition_fee', 'incentive', true, array('id'=>'gst_checker_tuition_fee')) }}
                                            GST
                            </span>
                                    </div>
                                    @if($errors->has('tuition_fee_gst'))
                                        {!! $errors->first('tuition_fee_gst', '<label class="control-label"
                                                                                 for="inputError">:message</label>') !!}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="panel-title">Other Commission</span>
                        <a href="#" class="btn btn-warning btn-collapse-incentive btn-flat btn-xs pull-right"><i
                                    class="fa fa-minus-circle"></i> Remove</a>
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-6">

                            <div class="form-group @if($errors->has('incentive')) {{'has-error'}} @endif">
                                {!!Form::label('incentive', 'Amount *', array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$</span>
                                        {!!Form::text('incentive', null, array('class' => 'form-control', 'id'=>'incentive'))!!}
                                    </div>
                                    @if($errors->has('incentive'))
                                        {!! $errors->first('incentive', '<label class="control-label"
                                                                                 for="inputError">:message</label>') !!}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group @if($errors->has('incentive_gst')) {{'has-error'}} @endif">
                                {!!Form::label('incentive_gst', 'GST *', array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$</span>
                                        {!!Form::text('incentive_gst', null, array('class' => 'form-control', 'id'=>'incentive_gst','placeholder'=>'10% of Incentive','readonly' => 'true'))!!}
                                        <span class="input-group-addon">
                               {{ Form::checkbox('gst_checker_incentive', 'incentive', true,array('id'=>'gst_checker_incentive')) }}
                                            GST
                            </span>
                                    </div>
                                    @if($errors->has('incentive_gst'))
                                        {!! $errors->first('incentive_gst', '<label class="control-label"
                                                                                 for="inputError">:message</label>') !!}
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group @if($errors->has('other_description')) {{'has-error'}} @endif">
                                {!!Form::label('other_description', 'Description *', array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    {!!Form::text('other_description', null, array('class' => 'form-control', 'id'=>'other_description'))!!}
                                    @if($errors->has('other_description'))
                                        {!! $errors->first('other_description', '<label class="control-label"
                                                                                for="inputError">:message</label>') !!}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="panel-title">Total Commission</span>
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-6">
                            <div class="form-group @if($errors->has('total_commission')) {{'has-error'}} @endif">
                                {!!Form::label('total_commission', 'Sub Total *', array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$</span>
                                        {!!Form::text('total_commission', null, array('class' => 'form-control', 'id'=>'total_commission','placeholder'=>'sum of Commission Amount and Amount','readonly' => 'true'))!!}
                                    </div>
                                    @if($errors->has('total_commission'))
                                        {!! $errors->first('total_commission', '<label class="control-label"
                                                                                 for="inputError">:message</label>') !!}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group @if($errors->has('total_gst')) {{'has-error'}} @endif">
                                {!!Form::label('total_gst', 'Total GST *', array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$</span>
                                        {!!Form::text('total_gst', null, array('class' => 'form-control', 'id'=>'total_gst','placeholder'=>'sum of Commission GST and GST','readonly' => 'true'))!!}
                                    </div>
                                    @if($errors->has('total_gst'))
                                        {!! $errors->first('total_gst', '<label class="control-label"
                                                                                 for="inputError">:message</label>') !!}
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group @if($errors->has('final_total')) {{'has-error'}} @endif">
                                {!!Form::label('final_total', 'Total with GST', array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$</span>
                                        {!!Form::text('final_total', null, array('class' => 'form-control', 'id'=>'final_total','placeholder'=>'sum of Total Amount and Total GST','readonly' => 'true'))!!}
                                    </div>
                                    @if($errors->has('final_total'))
                                        {!! $errors->first('final_total', '<label class="control-label"
                                                                                 for="inputError">:message</label>') !!}
                                    @endif
                                </div>
                            </div>
                            <div class="form-group @if($errors->has('payable_to_college')) {{'has-error'}} @endif">
                                {!!Form::label('payable_to_college', 'Payable To College', array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$</span>
                                        {!!Form::text('payable_to_college', null, array('class' => 'form-control', 'id'=>'payable_to_college','placeholder'=>'Sub Total - Final Total','readonly' => 'true'))!!}
                                    </div>
                                    @if($errors->has('payable_to_college'))
                                        {!! $errors->first('payable_to_college', '<label class="control-label"
                                                                                 for="inputError">:message</label>') !!}
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <a href="{{ route('tenant.application.college', [$tenant_id, $invoice->course_application_id]) }}" class="btn btn-danger pull-left">Cancel</a>
                {{--<button type="reset" class="btn btn-danger pull-left">Cancel</button>--}}
                <button type="submit" class="btn btn-success btn-sub pull-right">Submit</button>
            </div>
        </div>
        {!!Form::close()!!}
    </div>

    <script src="{{ asset('assets/js/college_invoice.js') }}"></script>
@stop