<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Mail Invoice PDF</h4>
</div>
{!!Form::open(['id' => 'mail-payment', 'class' => 'form-horizontal form-left'])!!}
{{--<div class="modal-body">

    <div class="form-group">
        {!!Form::label('email', 'Email Address *', array('class' => 'col-sm-4 control-label')) !!}
        <div class="col-sm-8">
            {!!Form::email('email', $student->email, array('class' => 'form-control', 'id' => 'email', 'required' => 'required'))!!}
        </div>
    </div>
</div>--}}
<div class="modal-body">
    <div class="form-group">
        <label for="to" class="col-xs-3 control-label">To</label>

        <div class="col-sm-8">
            {!!Form::select('to[]', $email_list, $student->email, array('class' => 'form-control email', 'id' => 'to', 'multiple' => 'multiple'))!!}
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
            <input type="checkbox" id="sendBcc" name="sendBcc" checked="checked">
            <label class="control-label">{{ $current_user->email }}</label>
        </div>
    </div>


    <div class="form-group">

        <label class="col-xs-3 control-label" for="subject">Subject</label>

        <div class="col-xs-9 form-control-wrapper" data-id="" data-widget="TextInput" data-name="subject"><input
                    id="subject" name="subject" type="text" class="form-control "
                    value="Your invoice from {{ $company['company_name'] }}" autocomplete="off" delay="off">
        </div>
    </div>


    <div class="form-group">
        <label for="body" class="col-xs-3 control-label">Message</label>

        <div class="col-xs-9 form-control-wrapper">
            <div data-id="body" data-widget="AutosizeTextarea" data-name="body" data-maxlength="10000"
                 data-autosize="false" data-rows="10" data-cols="50"><textarea rows="10" id="body" name="body"
                                                                               data-widget="AutosizeTextarea"
                                                                               class="wys form-control">Dear <strong>{{ $student->fullname }}</strong>,

<p>We've attached invoice <strong>{{ format_id($invoice->invoice_id, 'I') }}</strong> for {{ format_price($invoice->invoice_amount) }}. <br/>
Payment is due by {{ format_date($invoice->due_date) }}.</p>
<p>Please get in touch if you've got any questions.</p>

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
    <div id="attachments" class="form-group">
        <div><label for="emailFile" class="col-xs-3 control-label">Attachments</label>

            <div class="col-xs-9">
                <div class="required-attachment"><i class="fa fa-paperclip" style="font-size: 1.4em;"></i>  {{ format_id($invoice->invoice_id, 'I') }}.pdf
                </div>
            </div>
            <div class="col-xs-18 form-control-wrapper email-attachments-wrapper">
                <ul id="filesUploaded"></ul>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
    <button type="submit" class="btn btn-success"><i class="fa fa-paper-plane"></i>
        Send Invoice
    </button>
</div>
{!!Form::close()!!}

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
    });

    function validateEmail(email) {
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }
</script>