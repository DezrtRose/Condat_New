@extends('layouts.tenant')
@section('title', 'Application Enquiry')
@section('heading', '<h1>' . $client_name . '- <small>Apply Offer</small></h1>')
@section('breadcrumb')
    @parent
    <li><a href="{{url($tenant_id.'/clients')}}" title="All Applications"><i class="fa fa-users"></i> Applications</a>
    </li>
    <li>Notes</li>
@stop

@section('content')
    <div class="col-md-12">

        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Application Offer Details</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-7 col-md-offset-1">
                        {!! Form::model($application, ['class'=>'form-horizontal', 'method'=>'POST', 'route'=>['applications.apply.update', $tenant_id, $application->application_id]])!!}

                        <div class="form-group">
                            {{ Form::label('institute_name', 'Institute Name', ['class'=>'col-md-3 form-label text-right'])}}
                            <div class="col-md-9">{{ $application->company_name }}</div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('course_name', 'Course Name', ['class'=>'col-md-3 form-label text-right'])}}
                            <div class="col-md-9">{{ $application->course_name }}</div>
                        </div>

                        <div class="form-group @if($errors->has('tuition_fee')) {{'has-error'}} @endif">
                            {!! Form::label('tuition_fee', 'Total Tuition Fee', ['class'=>'col-md-3 form-label text-right']) !!}
                            <div class="col-md-9">
                                {!!Form::text('tuition_fee', null, array('class' => 'form-control', 'id'=>'tuition_fee'))!!}
                                @if($errors->has('tuition_fee'))
                                    {!! $errors->first('tuition_fee', '<label class="control-label"
                                                                              for="inputError">:message</label>') !!}
                                @endif
                            </div>
                        </div>

                        <div class="form-group">

                            <label for="intake" class="col-sm-3 control-label">Select Intake</label>

                            <div class="col-sm-9">
                                {!!Form::select('intake_id', $intakes, null, array('class' => 'form-control intake', 'id' => 'intake'))!!}
                                <a class="btn btn-success btn-xs marginTop" data-toggle="modal"
                                   data-target="#condat-modal"
                                   data-url="{{ url($tenant_id.'/application/intake/add')}}"><i
                                            class="glyphicon glyphicon-plus-sign"></i> Add Intake</a>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-9 col-md-offset-3">
                                {{ Form::submit('Apply Now',['class'=>'btn btn-primary'])}}
                            </div>
                        </div>
                        {!! Form::close()!!}
                    </div>
                    <div class="col-md-4">
                        <h3>Institutes Documents</h3>
                        <br>
                        @if(count($documents) != 0)
                            @foreach($documents as $key => $inst_document)
                                <p><span class="text-xl">{{ $inst_document->document->type }}   </span>
                                    <a href="{{$inst_document->document->shelf_location}}" title="view"><i
                                                class="processing btn btn-primary btn-sm fa fa-eye"
                                                data-toggle="tooltip" data-placement="top" title="View Document"></i></a>
                                    <a href="{{route('tenant.client.document.download', [$tenant_id, $inst_document->document_id])}}" title="view"><i
                                                class="processing btn btn-primary btn-sm fa fa-download"
                                                data-toggle="tooltip" data-placement="top" title="Download Document"></i></a>
                            @endforeach
                        @else
                            <p class="text-muted well">
                                No documents uploaded yet.
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {!! Condat::registerModal() !!}

    <script type="text/javascript">
        $(document).on("submit", "#add-intake", function (event) {
            var formData = $(this).serialize();
            var institute_id = '<?php echo $application->institute_id ?>';
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

        function notify(type, text) {
            return '<div class="callout callout-' + type + '"><p>' + text + '</p></div>';
        }
    </script>

@stop
        
              
          
        
      
     
        


