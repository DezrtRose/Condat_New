<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Locations in Australia</h3>
        <button class="btn btn-success pull-right" data-toggle="modal" data-target="#addressModal"><i
                    class="glyphicon glyphicon-plus-sign"></i> Address
        </button>
    </div>
    <div class="box-body">
        <table id="addresses" class="table table-hover">
            <thead>
            <tr>
                <th>Address</th>
                <th>State</th>
                <th>Phone</th>
                <th>Email</th>
                <th></th>
            </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Add Address Modal -->
<div id="addressModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Address</h4>
            </div>
            {!!Form::open(['url' => $tenant_id.'/institutes/'.$institute->institution_id.'/address/store', 'id' =>
            'add-address', 'class' => 'form-horizontal form-left form-address'])!!}
            <div class="modal-body">
                @include('Tenant::Address/form')
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
        aTable = $('#addresses').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": appUrl + "/institutes/<?= $institute->institution_id ?>/addresses",
            "columns": [
                {data: 'address', name: 'address'},
                {data: 'state', name: 'state'},
                {data: 'number', name: 'number'},
                {data: 'email', name: 'email'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            order: [[0, 'desc']]
        });

        $(document).on("submit", ".form-address", function (event) {
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
                                $('.form-address').find('#' + i).after('<label class="error ">' + v + '</label>').closest('.form-group').addClass('has-error');
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

