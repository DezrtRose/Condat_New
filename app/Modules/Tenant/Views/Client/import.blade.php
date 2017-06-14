@extends('layouts.tenant')
@section('title', 'Import Clients')
@section('breadcrumb')
    @parent
    <li><a href="{{url('client')}}" title="All Clients"><i class="fa fa-dashboard"></i> Clients</a></li>
@stop
@section('content')

    <div class="pad margin no-print">
        <div class="callout callout-info" style="margin-bottom: 0!important;">
            <h4><i class="fa fa-info"></i> Note:</h4>
            The supported mime types for the document are Excel files. <br/>
            Please refer the <strong><a href="{{ asset('assets/sample/SampleClientImport.xlsx') }}" target="_blank">sample
                    document</a></strong> for the acceptable column format for the data import.
        </div>
    </div>

    <div class="col-xs-12">
        @include('flash::message')
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Import Client Excel</h3>
            </div>
            {!!Form::open(array('route' => ['tenant.client.postImport', $tenant_id], 'class' => 'form-horizontal form-left', 'files' => true, 'id' => 'upload-form'))!!}
            <div class="box-body">
                <div class="row">
                <div class="col-md-6">
                    <div class="form-group @if($errors->has('import_file')) {{'has-error'}} @endif">
                        {!!Form::label('import_file', 'Upload File *', array('class' => 'col-sm-4 control-label')) !!}
                        <div class="col-sm-8">
                            {!!Form::file('import_file', null, array('class' => 'form-control', 'id'=>'import_file'))!!}
                            @if($errors->has('import_file'))
                                {!! $errors->first('import_file', '<label class="control-label"
                                                                         for="inputError">:message</label>') !!}
                            @endif
                        </div>
                    </div>
                </div>
                </div>
                <div class="summary">
                </div>
            </div>
            <div class="box-footer clearfix">
                <input type="submit" class="btn btn-primary pull-right btn-submit" value="Upload"/>
            </div>
            {!!Form::close()!!}
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            var file;
            $('.btn-submit').on('click', function (e) {
                e.preventDefault();
                var form = $('#upload-form');

                form.find('.btn-submit').val('Loading...');
                form.find('.btn-submit').attr('disabled', true);

                var actionUrl = form.attr('action');
                var data = new FormData(form[0]);
                file = data;
                //var data = form.serialize();
                $.ajax({
                    url: actionUrl,
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST'
                })
                        .done(function (response) {
                            if (response.status == 0) {
                                $('.summary').html(response.data.template);
                                form.find('.btn-submit').val('Upload');
                            }

                            if (response.status == 1) {
                                $('.summary').html(response.data.template);
                                form.find('.btn-submit').before('<input type="button" class="btn btn-success btn-import" value="Confirm & Import"/>');
                                form.find('.btn-submit').val('Discard & Upload New');
                            } //success
                        })

                        .fail(function () {
                            alert('Something Went Wrong! Please Try Again Later.');
                            form.find('.btn-submit').val('Upload');
                        })
                        .always(function () {
                            doing = false;
                            form.find('.btn-submit').removeAttr('disabled');

                        });
                return false;
            });

            /* Confirm And Upload Client */
            $('body').on('click', '.btn-import', function (e) {
                e.preventDefault();
                var form = $('#upload-form');

                form.find('.btn-import').val('Importing...');
                form.find('.btn-import').attr('disabled', true);

                var actionUrl = appUrl + '/confirmImport';
                $.ajax({
                    url: actionUrl,
                    data: file,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST'
                })
                        .done(function (response) {
                            if (response.status == 0) {
                                $('.mainContainer .box').before(notify('error', response.data.message));
                                form.find('.btn-import').val('Confirm & Import');
                            }

                            if (response.status == 1) {
                                $('.summary').html(response.data.template);
                                $('.mainContainer .box').before(notify('success', response.data.message));
                                setTimeout(function () {
                                    $('.callout').remove()
                                }, 2500);
                                form.find('.btn-submit').val('Upload');
                            } //success
                        })

                        .fail(function () {
                            alert('Something Went Wrong! Please Try Again Later.');
                            form.find('.btn-import').val('Confirm & Import');
                        })
                        .always(function () {
                            doing = false;
                            form.find('.btn-import').removeAttr('disabled');
                            form.find('.btn-import').val('Confirm & Import');
                        });
                return false;
            });

            $.ajaxSetup({
                headers: { 'X-CSRF-Token': $('input[name="_token"]').val() }
            });
        });
        function notify(type, text) {
            return '<div class="callout callout-' + type + '"><p>' + text + '</p></div>';
        }
    </script>
@stop
