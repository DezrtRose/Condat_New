@extends('layouts.tenant')
@section('title', 'Bulk Email')
@section('heading', 'Bulk Email')
@section('breadcrumb')
    @parent
@stop
@section('content')
    <div class="col-xs-12">
        @include('flash::message')
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Bulk Email</h3>
            </div>
            {!!Form::open(['id' => 'bulk-mail', 'class' => 'form-horizontal form-left', 'files' => true])!!}
            <div class="box-body">
                <div class="form-group">
                    <label for="to" class="col-xs-3 control-label">To</label>

                    <div class="col-sm-8">
                        {!!Form::select('to[]', $email_list, null, array('class' => 'form-control email', 'id' => 'to', 'multiple' => 'multiple'))!!}
                        - OR - <br/>
                                <input type="checkbox" id="sendAll" name="sendAll" class="icheck" />
                                <label for="sendAll" class="control-label"> Send To All</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="cc" class="col-xs-3 control-label">Cc</label>

                    <div class="col-sm-8">
                        {!!Form::select('cc[]', $email_list, null, array('class' => 'form-control email', 'id' => 'cc', 'multiple' => 'multiple'))!!}
                    </div>
                </div>

                <div class="form-group">
                    <label for="sendBcc" class="col-xs-3 control-label">Send a copy to</label>

                    <div class="col-xs-9 form-control-wrapper" id="bcc">
                        <input type="checkbox" id="sendBcc" name="sendBcc" checked="checked" class="icheck">
                        <label class="control-label"> {{ $current_user->email }}</label>
                    </div>
                </div>


                <div class="form-group">

                    <label class="col-xs-3 control-label" for="subject">Subject</label>

                    <div class="col-xs-9 form-control-wrapper" data-id="" data-widget="TextInput" data-name="subject">
                        <input
                                id="subject" name="subject" type="text" class="form-control "
                                value="Your invoice from {{ $current_user->email }}" autocomplete="off" delay="off">
                    </div>
                </div>


                <div class="form-group">
                    <label for="body" class="col-xs-3 control-label">Message</label>

                    <div class="col-xs-9 form-control-wrapper">
                        <div data-id="body" data-widget="AutosizeTextarea" data-name="body" data-maxlength="10000"
                             data-autosize="false" data-rows="10" data-cols="50"><textarea rows="10" id="body"
                                                                                           name="body"
                                                                                           data-widget="AutosizeTextarea"
                                                                                           class="wys form-control">
                                <p></p>

                    <address>Regards,<br/>
                        <strong>{{ $company['company_name'] or '' }}</strong><br/>
                        {{ $current_user->email }}<br/>
                        {{ $company['phone_number'] or '' }}<br/>
                        {{ $company['website'] or '' }}
                    </address>
                </textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="emailFile" class="col-xs-3 control-label">Attachments</label>

                    <div class="col-xs-9 form-control-wrapper">
                        {!! Form::file('attachment', null, array('title' => "Add attachments")) !!}
                        {{--<input type="file" id="attachFileInput" name="attachmentFileInput" title="Add attachments" multiple="" style="display: none;">
                        <button id="attachFileButton" name="attachFileButton" class="btn btn-default attach-file-btn"><i class="fa fa-paperclip"></i>  Add attachments</button>--}}
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-success pull-right"><i class="fa fa-paper-plane"></i>
                    Send Mail
                </button>
            </div>
            {!!Form::close()!!}
        </div>
    </div>

    <script type="text/javascript">

        $(document).ready(function () {
            $(".email").select2({
                tags: true,
                tokenSeparators: [',', ' '],
                placeholder: "Enter an email address",
                allowClear: true,
                createTag: function (params) {
                    var value = params.term;
                    if (validateEmail(value)) {
                        return {
                            id: value,
                            text: value
                        };
                    }
                    return null;
                }
            });

            $(".wys").wysihtml5();

            $('#sendAll').on('ifChecked', function(event){
                $("#to").attr("disabled", "disabled");
            });

            $('#sendAll').on('ifUnchecked', function(event){
                $("#to").removeAttr("disabled");
            });
        });

        function validateEmail(email) {
            var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        }
    </script>
@stop