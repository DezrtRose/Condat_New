<div class="modal-body">
    <div class="form-group">
        <label for="intake_date" class="col-sm-3 control-label">Intake Date: *</label>

        <div class="col-sm-8">
            <div class="input-group date" id="intake_date">
                @if(isset($intake->intake_date))
                    {!!Form::text('intake_date', format_date($intake->intake_date), array('class' => 'form-control'))!!}
                @else
                    {!!Form::text('intake_date', null, array('class' => 'form-control', 'autocomplete' => 'off'))!!}
                @endif
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="description" class="col-sm-3 control-label">Description: *</label>

        <div class="col-sm-8">
            {{--{!!Form::textarea('description', null, array('class' => 'form-control', 'id' => 'description'))!!}--}}
            {!!Form::text('description', null, array('class' => 'form-control', 'id' => 'description', 'placeholder' => 'T1 '.date("F", mktime(0, 0, 0, get_today_datetime()->month, 1)).' '. get_today_datetime()->year))!!}
        </div>
    </div>
</div>
<script type="text/javascript">
    $("#intake_date").datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy'
    });

</script>
{!! Condat::registerModal() !!}
