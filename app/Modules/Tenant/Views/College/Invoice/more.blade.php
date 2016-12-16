<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Add More Invoice</h4>
</div>
{!!Form::open(['route' => ['tenant.application.storeInvoice', $tenant_id, $application_id], 'id' => 'add-invoice', 'class' => 'form-horizontal form-left'])!!}
<div class="modal-body">
    <div class="form-group">
        {!!Form::label('num', 'Number Of Invoices', array('class' => 'col-sm-4 control-label')) !!}
        <div class="col-sm-8">
            {!!Form::number('num', null, array('class' => 'form-control', 'id'=>'num'))!!}
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
<div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
    <button type="submit" class="btn btn-success">Create</button>
</div>
{!!Form::close()!!}