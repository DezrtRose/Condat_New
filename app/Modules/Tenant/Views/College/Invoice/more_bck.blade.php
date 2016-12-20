<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Add More Invoice</h4>
</div>
{!!Form::model($invoice, ['route' => ['tenant.application.storeInvoice', $tenant_id, $application_id], 'id' => 'add-invoice', 'class' => 'form-horizontal form-left'])!!}
<div class="modal-body">
    <div class="step1">
        <div class="form-group">
            {!!Form::label('num', 'Number Of Invoices', array('class' => 'col-sm-4 control-label')) !!}
            <div class="col-sm-8">
                {!!Form::number('num', null, array('class' => 'form-control', 'id'=>'num', 'min'=>1))!!}
            </div>
        </div>
        <div class="form-group">
            {!!Form::label('duration', 'Duration', array('class' => 'col-sm-4 control-label')) !!}
            <div class="col-sm-8">
                {!!Form::number('duration', null, array('class' => 'form-control input-xs', 'id' => 'duration', 'placeholder' => 'Months'))!!}
            </div>
        </div>
        <div class="form-group">
            {!!Form::label('start_date', 'Start Date', array('class' => 'col-sm-4 control-label')) !!}
            <div class="col-sm-8">
                <div class="input-group" id="start_date">
                    {!!Form::text('start_date', null, array('class' => 'form-control date-picker'))!!}
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="step2" style="display: none">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="panel-title">Commission on Tuition Fee</span>
                <a href="#" class="btn btn-warning btn-collapse btn-flat btn-xs pull-right"><i
                            class="fa fa-minus-circle"></i> Remove</a>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    {!!Form::label('tuition_fee', 'Tuition Fee *', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            {!!Form::text('tuition_fee', null, array('class' => 'form-control', 'id'=>'tuition_fee'))!!}
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    {!!Form::label('enrollment_fee', 'Enrollment Fee *', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            {!!Form::text('enrollment_fee', null, array('class' => 'form-control', 'id'=>'enrollment_fee',))!!}
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    {!!Form::label('material_fee', 'Material Fee *', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            {!!Form::text('material_fee', null, array('class' => 'form-control', 'id'=>'material_fee'))!!}
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    {!!Form::label('coe_fee', 'COE Fee *', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            {!!Form::text('coe_fee', null, array('class' => 'form-control', 'id'=>'coe_fee'))!!}
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    {!!Form::label('other_fee', 'Other Fee*', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            {!!Form::text('other_fee', null, array('class' => 'form-control', 'id'=>'other_fee'))!!}
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    {!!Form::label('sub_total', 'Sub Total *', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            {!!Form::text('sub_total', null, array('class' => 'form-control', 'id'=>'sub_total','placeholder'=>'click to calculate'))!!}
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    {!!Form::label('description', 'Description *', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::text('description', isset($invoice) ? null : 'Commission on tuition Fee', array('class' => 'form-control', 'id'=>'description'))!!}
                    </div>
                </div>

                <div class="form-group">
                    {!!Form::label('commission_percent', 'Commission Percent *', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        <div class="input-group">

                            {!!Form::text('commission_percent', null, array('class' => 'form-control', 'id'=>'commission_percent'))!!}
                            <span class="input-group-addon">%</span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    {!!Form::label('commission_amount', 'Commission Amount *', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            {!!Form::text('commission_amount', null, array('class' => 'form-control', 'id'=>'commission_amount','placeholder'=>'click to calculate'))!!}
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    {!!Form::label('tuition_fee_gst', 'Commission GST *', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            {!!Form::text('tuition_fee_gst', null, array('class' => 'form-control', 'id'=>'tuition_fee_gst','placeholder'=>'10% of Commission Amount','readonly' => 'true'))!!}
                            <span class="input-group-addon">
                               {{ Form::checkbox('gst_checker_tuition_fee', 'incentive', true,array('id'=>'gst_checker_tuition_fee')) }}
                                GST
                            </span>
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
                <div class="form-group">
                    {!!Form::label('incentive', 'Amount *', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            {!!Form::text('incentive', null, array('class' => 'form-control', 'id'=>'incentive'))!!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
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
                    </div>
                </div>
                <div class="form-group">
                    {!!Form::label('other_description', 'Description *', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::text('other_description', null, array('class' => 'form-control', 'id'=>'other_description'))!!}
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="panel-title">Total Commission</span>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    {!!Form::label('total_commission', 'Total Amount *', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            {!!Form::text('total_commission', null, array('class' => 'form-control', 'id'=>'total_commission','placeholder'=>'sum of Commission Amount and Amount','readonly' => 'true'))!!}
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    {!!Form::label('total_gst', 'Total GST *', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            {!!Form::text('total_gst', null, array('class' => 'form-control', 'id'=>'total_gst','placeholder'=>'sum of Commission GST and GST','readonly' => 'true'))!!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    {!!Form::label('final_total', 'Total with GST', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            {!!Form::text('final_total', null,
                            array('class' => 'form-control', 'id'=>'final_total','placeholder'=>'sum of Total Amount and Total GST','readonly' => 'true'))!!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    {!!Form::label('payable_to_college', 'Payable To College', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            {!!Form::text('payable_to_college', null, array('class' => 'form-control', 'id'=>'payable_to_college','placeholder'=>'Sub Total - Final Total','readonly' => 'true'))!!}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancel</button>
    <button type="button" class="btn btn-success next">Next</button>
</div>
{!!Form::close()!!}

<script type="text/javascript">
    $(document).on('click', '.next', function (e) {
        $('.step1').hide('slow');
        $('.step2').show('slow');
        $('.next').removeClass('next').addClass('back').html('Back').after('<button type="submit" class="btn btn-primary btn-sub">Create</button>');
    });
    $(document).on('click', '.back', function (e) {
        $('.step2').hide('slow');
        $('.step1').show('slow');
        $('.back').removeClass('back').addClass('next').html('Next');
        $('.btn-sub').remove();
    });
</script>