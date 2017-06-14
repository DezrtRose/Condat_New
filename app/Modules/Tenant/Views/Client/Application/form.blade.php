<div class="form-group @if($errors->has('institute_id')) {{'has-error'}} @endif">
    {!!Form::label('institute_id', 'Select Institute *', array('class' => 'col-md-2 col-sm-12 control-label')) !!}
    <div class="col-md-10 col-sm-12">
        {!!Form::select('institute_id', $institutes, null, array('class' => 'form-control institute', 'id' => 'institute'))!!}
        <a class="btn btn-success btn-xs" data-toggle="modal" data-target="#condat-modal"
           data-url="{{ url($tenant_id.'/application/institute/add')}}"><i class="glyphicon glyphicon-plus-sign"></i> Add
            Institute</a>
        @if($errors->has('institute_id'))
                    {!! $errors->first('institute_id', '<label class="control-label"
                                                             for="inputError">:message</label>') !!}
                @endif
    </div>
</div>

<div class="form-group @if($errors->has('institution_course_id')) {{'has-error'}} @endif">
    {!!Form::label('institution_course_id', 'Select Course *', array('class' => 'col-md-2 col-sm-12 control-label')) !!}
    <div class="col-md-10 col-sm-12">
        {!!Form::select('institution_course_id', $courses, null, array('class' => 'form-control course', 'id' => 'course'))!!}
        <a class="btn btn-success btn-xs" data-toggle="modal" data-target="#condat-modal"
           data-url="{{ url($tenant_id.'/application/course/add')}}"><i class="glyphicon glyphicon-plus-sign"></i> Add
            Course</a>
        @if($errors->has('institution_course_id'))
                    {!! $errors->first('institution_course_id', '<label class="control-label"
                                                             for="inputError">:message</label>') !!}
                @endif
    </div>
</div>

<div class="form-group @if($errors->has('intake_id')) {{'has-error'}} @endif">
    <label for="intake" class="col-sm-2 control-label">Select Intake *</label>

    <div class="col-sm-10">
        {!!Form::select('intake_id', $intakes, null, array('class' =>
       'form-control intake', 'id' => 'intake'))!!}
        <a class="btn btn-success btn-xs" data-toggle="modal" data-target="#condat-modal"
           data-url="{{ url($tenant_id.'/application/intake/add')}}"><i class="glyphicon glyphicon-plus-sign"></i> Add
            Intake</a>
            @if($errors->has('intake_id'))
                    {!! $errors->first('intake_id', '<label class="control-label"
                                                             for="inputError">:message</label>') !!}
                @endif
    </div>
</div>
<div class="form-group">
    <label for="end_date" class="col-sm-2 control-label">Finish Date</label>

    <div class="col-sm-10">
        <div class='input-group date'>
            @if(!isset($application))
                {!! Form::text('end_date', null, array('class' => 'form-control datepicker', 'id' => 'end_date', 'placeholder' => "dd/mm/yyyy")) !!}
            @else
                {!! Form::text('end_date', format_date($application->end_date), array('class' => 'form-control datepicker', 'id' => 'end_date', 'placeholder' => "dd/mm/yyyy")) !!}
            @endif
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
        </div>
    </div>
</div>
<div class="form-group">
    <label for="tuition_fee" class="col-sm-2 control-label">Total Tuition Fee</label>

    <div class="col-sm-10">
        <input type="text" name="tuition_fee" class="form-control" id="fee" placeholder="Tuition Fee">
    </div>
</div>
<div class="form-group">
    <label for="student_id" class="col-sm-2 control-label">Student ID</label>

    <div class="col-sm-10">
        {!! Form::text('student_id', null, array('class' => 'form-control', 'id' => 'student_id', 'placeholder' => "Student ID")) !!}
    </div>
</div>
<div class="form-group">
    <label for="super_agent_id" class="col-sm-2 control-label">Add Super Agent</label>

    <div class="col-sm-10">
        {!!Form::select('super_agent_id', $agents, null, array('class' => 'form-control superagent', 'id' => 'superagent'))!!}
        <a class="btn btn-success btn-xs" data-toggle="modal" data-target="#condat-modal"
           data-url="{{ url($tenant_id.'/application/superagent/add')}}"><i class="glyphicon glyphicon-plus-sign"></i> Add
            Super Agent</a>
    </div>
</div>
<div class="form-group">
    <label for="sub_agent_id" class="col-sm-2 control-label">Add Sub Agent</label>

    <div class="col-sm-10">
        {!!Form::select('sub_agent_id', $agents, null, array('class' => 'form-control subagent', 'id' => 'subagent'))!!}
        <a class="btn btn-success btn-xs" data-toggle="modal" data-target="#condat-modal"
           data-url="{{ url($tenant_id.'/application/subagent/add')}}"><i class="glyphicon glyphicon-plus-sign"></i> Add
            Sub Agent</a>
    </div>
</div>

{!! Condat::registerModal('modal-lg') !!}

<script type="text/javascript">
    $("#institute").change(function () {
        getCourses();
        getIntakes();
    });

    $("#course").change(function () {
        getTuitionFee();
    });

    function getCourses() {
        var institute = $("#institute").val();
        $.ajax({
            url: appUrl + "/courses/" + institute,
            beforeSend: function () {
                $("#course").before('<div class="form-control course-loading"><i class = "fa fa-spinner fa-spin"></i> Loading...</div>');
                $('#course').hide();
            },
            success: function (result) {
                $("#course").html(result.data.options);
                {{--@if(Request::segment(4) == 'edit')
                $("#course").val({{$application->institution_course_id}});
                @endif--}}
                @if(old('institution_course_id'))
                    $("#course").val({{old('institution_course_id')}});
                @endif
                getTuitionFee();
            }
        }).complete(function () {
            $("#course").show();
            $('.course-loading').remove();
        });
    }

    function getIntakes() {
        var institute = $("#institute").val();
        $.ajax({
            url: appUrl + "/intakes/" + institute,
            beforeSend: function () {
                $("#intake").before('<div class="form-control intake-loading"><i class = "fa fa-spinner fa-spin"></i> Loading...</div>');
                $('#intake').hide();
            },
            success: function (result) {
                $("#intake").html(result.data.options);
                {{--@if(Request::segment(4) == 'edit')
                $("#intake").val({{$application->intake_id}});
                @endif--}}
                @if(old('intake_id'))
                    $("#intake").val({{old('intake_id')}});
                @endif
            }
        }).complete(function () {
            $("#intake").show();
            $('.intake-loading').remove();
        });
    }

    function getTuitionFee() {
        var course = $("#course").val();
        $.ajax({
            url: appUrl + "/course/fee/" + course,
            beforeSend: function () {
                $("#fee").before('<div class="form-control fee-loading"><i class = "fa fa-spinner fa-spin"></i> Loading...</div>');
                $('#fee').hide();
            },
            success: function (result) {
                $("#fee").val(result.data.fee);
            }
        }).complete(function () {
            $("#fee").show();
            $('.fee-loading').remove();
        });
    }

    $(document).ready(function () {
        getCourses();
        getIntakes();
    });

    $(document).on('focusout', '#add-institute #name', function() {
    //$('#add-institute #name').focusout(function() {
        var curVal = $('#invoice_to_name').val();
        var instName = $(this).val();
        if(curVal != '' || $('#invoice_to_name').is(':empty'))
        {
            $('#invoice_to_name').val(instName);
        }
    });

    // process the institute form
    $(document).on("submit", "#add-institute", function (event) {
        var formData = $(this).serialize();
        var url = $(this).attr('action');
        $(this).find('.has-error').removeClass('has-error');
        $(this).find('label.error').remove();
        $(this).find('.callout').remove();

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
                        var select = $('#institute');
                        select.append($("<option></option>").attr("value", result.data.institute_id).text(result.data.name));
                        select.val(result.data.institute_id);
                        getCourses();
                        getIntakes();
                        getTuitionFee();

                        if ($(".institute option[value='']").length > 0)
                            $(this).remove();

                        $('#condat-modal').modal('hide');
                        $('.container .box-primary').before(notify('success', 'Institute Added Successfully!'));
                    }
                    else {
                        $.each(result.data.errors, function (i, v) {
                            //$('#add-institute').find('input[name=' + i + ']').after('<label class="error ">' + v + '</label>').closest('.form-group').addClass('has-error');
                            /* Applicable for other elements like calender, phone */
                            $('#add-institute').find('#' + i).after('<label class="error ">' + v + '</label>').closest('.form-group').addClass('has-error');
                        });
                    }
                    setTimeout(function () {
                        $('.callout').remove()
                    }, 2500);
                });
        event.preventDefault();
    });

    $(document).on("submit", "#add-course", function (event) {
        var formData = $(this).serialize();
        var institute_id = $('#institute').val();
        var url = appUrl + '/course/' + institute_id + '/store';
        $(this).find('.has-error').removeClass('has-error');
        $(this).find('label.error').remove();
        $(this).find('.callout').remove();

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
                        var select = $('#course');
                        select.append($("<option></option>").attr("value", result.data.course_id).text(result.data.name));
                        select.val(result.data.course_id);
                        getTuitionFee();

                        if ($(".course option[value='']").length > 0)
                            $(this).remove();

                        $('#condat-modal').modal('hide');
                        $('.container .box-primary').before(notify('success', 'Course Added Successfully!'));
                    }
                    else {
                        $.each(result.data.errors, function (i, v) {
                            //$('#add-institute').find('input[name=' + i + ']').after('<label class="error ">' + v + '</label>').closest('.form-group').addClass('has-error');
                            /* Applicable for other elements like calender, phone */
                            $('#add-course').find('#' + i).after('<label class="error ">' + v + '</label>').closest('.form-group').addClass('has-error');
                        });
                    }
                    setTimeout(function () {
                        $('.callout').remove()
                    }, 2500);
                });
        event.preventDefault();
    });

    $(document).on("submit", "#add-intake", function (event) {
        var formData = $(this).serialize();
        var institute_id = $('#institute').val();
        var url = appUrl + '/intakes/' + institute_id + '/store';
        $(this).find('.has-error').removeClass('has-error');
        $(this).find('label.error').remove();
        $(this).find('.callout').remove();

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
                        var select = $('#intake');
                        select.append($("<option></option>").attr("value", result.data.intake_id).text(result.data.description));
                        select.val(result.data.intake_id);

                        if ($(".intake option[value='']").length != 0)
                            $(".intake option[value='']").remove();

                        $('#condat-modal').modal('hide');
                        $('.container .box-primary').before(notify('success', 'Intake Added Successfully!'));
                    }
                    else {
                        $.each(result.data.errors, function (i, v) {
                            //$('#add-institute').find('input[name=' + i + ']').after('<label class="error ">' + v + '</label>').closest('.form-group').addClass('has-error');
                            /* Applicable for other elements like calender, phone */
                            $('#add-intake').find('#' + i).after('<label class="error ">' + v + '</label>').closest('.form-group').addClass('has-error');
                        });
                    }
                    setTimeout(function () {
                        $('.callout').remove()
                    }, 2500);
                });
        event.preventDefault();
    });

    $(document).on("submit", "#add-subagent", function (event) {
        var formData = $(this).serialize();
        var url = $(this).attr('action');
        $(this).find('.has-error').removeClass('has-error');
        $(this).find('label.error').remove();
        $(this).find('.callout').remove();

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
                        var select = $('#subagent');
                        select.append($("<option></option>").attr("value", result.data.agent_id).text(result.data.name));
                        $('#superagent').append($("<option></option>").attr("value", result.data.agent_id).text(result.data.name));
                        select.val(result.data.agent_id);

                        if ($(".subagent option[value='']").length != 0)
                            $(".subagent option[value='']").remove();

                        $('#condat-modal').modal('hide');
                        $('.container .box-primary').before(notify('success', 'Sub Agent Added Successfully!'));
                    }
                    else {
                        $.each(result.data.errors, function (i, v) {
                            //$('#add-institute').find('input[name=' + i + ']').after('<label class="error ">' + v + '</label>').closest('.form-group').addClass('has-error');
                            /* Applicable for other elements like calender, phone */
                            $('#add-subagent').find('#' + i).after('<label class="error ">' + v + '</label>').closest('.form-group').addClass('has-error');
                        });
                    }
                    setTimeout(function () {
                        $('.callout').remove()
                    }, 2500);
                });
        event.preventDefault();
    });

    $(document).on("submit", "#add-superagent", function (event) {
        var formData = $(this).serialize();
        var url = $(this).attr('action');
        $(this).find('.has-error').removeClass('has-error');
        $(this).find('label.error').remove();
        $(this).find('.callout').remove();

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
                        var select = $('#superagent');
                        select.append($("<option></option>").attr("value", result.data.agent_id).text(result.data.name));
                        $('#subagent').append($("<option></option>").attr("value", result.data.agent_id).text(result.data.name));
                        select.val(result.data.agent_id);

                        if ($(".superagent option[value='']").length != 0)
                            $(".superagent option[value='']").remove();

                        $('#condat-modal').modal('hide');
                        $('.container .box-primary').before(notify('success', 'Sub Agent Added Successfully!'));
                    }
                    else {
                        $.each(result.data.errors, function (i, v) {
                            //$('#add-institute').find('input[name=' + i + ']').after('<label class="error ">' + v + '</label>').closest('.form-group').addClass('has-error');
                            /* Applicable for other elements like calender, phone */
                            $('#add-superagent').find('#' + i).after('<label class="error ">' + v + '</label>').closest('.form-group').addClass('has-error');
                        });
                    }
                    setTimeout(function () {
                        $('.callout').remove()
                    }, 2500);
                });
        event.preventDefault();
    });

    function notify(type, text) {
        return '<div class="callout callout-' + type + '"><p>' + text + '</p></div>';
    }

</script>
{{ Condat::js("$('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                startDate: '+0d',
                autoclose: true
            });"
            )
}}