<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Create Group Invoice</h4>
</div>
{!!Form::open(['method' => 'post', 'id' => 'add-invoice', 'class' => 'form-horizontal form-left'])!!}
<div class="modal-body">
    <div class="form-group">
        {!!Form::label('description', 'Invoice To', array('class' => 'col-sm-4 control-label')) !!}
        <div class="col-sm-8">
            {!!Form::text('description', null, array('class' => 'form-control', 'id'=>'description'))!!}
        </div>
    </div>
    <div class="form-group">
        {!!Form::label('date', 'Date', array('class' => 'col-sm-4 control-label')) !!}
        <div class="col-sm-8">
            <div class='input-group date'>
                <input type="text" name="date" class="form-control datepicker" id="date">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
            </div>
        </div>
    </div>
    {{--<div class="form-group">
        {!!Form::label('due_date', 'Due Date', array('class' => 'col-sm-4 control-label')) !!}
        <div class="col-sm-8">
            <div class='input-group date'>
                <input type="text" name="due_date" class="form-control datepicker" id="due_date">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
            </div>
        </div>
    </div>--}}
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
    <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i>
        Create
    </button>
</div>
{!!Form::close()!!}

<script type="text/javascript">
    $(document).ready(function () {
        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true
        });
    });
</script>