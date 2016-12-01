<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Contact Person</h3>

        <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#contactModal"><i
                    class="glyphicon glyphicon-plus-sign"></i> Contacts
        </button>
    </div>

    <div class="box-body">
        <table id="contacts" class="table table-hover dataTable">
            <thead>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Phone</th>
                <th>Email</th>
                <th></th>
            </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Add Contact Modal -->
<div id="contactModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Contact</h4>
            </div>
            {!!Form::open(['url' => $tenant_id.'/institutes/'.$institute->institution_id.'/contact/store', 'id' => 'add-contact', 'class' => 'form-horizontal form-left form-contact'])!!}
            <div class="modal-body">

                <div class="form-group">
                    {!!Form::label('first_name', 'First Name *', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::text('first_name', null, array('class' => 'form-control', 'id'=>'first_name'))!!}
                    </div>
                </div>

                <div class="form-group">
                    {!!Form::label('middle_name', 'Middle Name', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::text('middle_name', null, array('class' => 'form-control', 'id'=>'middle_name'))!!}
                    </div>
                </div>

                <div class="form-group">
                    {!!Form::label('last_name', 'Last Name *', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::text('last_name', null, array('class' => 'form-control', 'id'=>'last_name'))!!}
                    </div>
                </div>

                <div class="form-group">
                    {!!Form::label('sex', 'Sex *', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        <label>
                            {!!Form::radio('sex', 'Male', true, array('class' => 'iCheck', 'checked'=>'checked'))!!}
                            Male
                        </label>
                        <label>
                            {!!Form::radio('sex', 'Female', array('class' => 'iCheck'))!!} Female
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    {!!Form::label('position', 'Position *', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::text('position', null, array('class' => 'form-control', 'id'=>'position'))!!}
                    </div>
                </div>

                <div class="form-group">
                    {!!Form::label('number', 'Phone Number *', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::text('number', null, array('class' => 'form-control phone-input', 'id'=>'number'))!!}
                    </div>
                </div>

                <div class="form-group">
                    {!!Form::label('email', 'Email Address *', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::email('email', null, array('class' => 'form-control', 'id'=>'email'))!!}
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i>
                    Add
                </button>
            </div>
            {!!Form::close()!!}
        </div>

    </div>
</div>

<script type="text/javascript">

    $(document).ready(function () {
        oTable = $('#contacts').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": appUrl + "/institutes/<?= $institute->institution_id ?>/contacts",
            "columns": [
                {data: 'name', name: 'name'},
                {data: 'position', name: 'position'},
                {data: 'number', name: 'number'},
                {data: 'email', name: 'email'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            order: [[0, 'desc']]
        });

        $(document).on("submit", ".form-contact", function (event) {
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
                            window.location.reload();
                        }
                        else {
                            $.each(result.data.errors, function (i, v) {
                                $('.form-contact').find('#' + i).after('<label class="error ">' + v + '</label>').closest('.form-group').addClass('has-error');
                            });
                        }
                        setTimeout(function () {
                            $('.callout').remove()
                        }, 2500);
                    });
            event.preventDefault();
        });
    });
</script>