<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Add Payment</h4>
</div>
{!!Form::open(['id' => 'add-payment', 'class' => 'form-horizontal form-left'])!!}
<div class="modal-body">
    @if($type == 1)
        <?php $pay_type = 3; //for different payment method ?>
        @include('Tenant::College/Payment/form')
    @elseif($type == 2)
        @include('Tenant::Student/Payment/form')
    @else
        @include('Tenant::SubAgent/Payment/form')
    @endif
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
    <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i>
        Add
    </button>
</div>
{!!Form::close()!!}

<script type="text/javascript">
    $(document).on('submit', '#add-payment', function (e) {
        e.preventDefault();
        var form = $(this);

        var doing = false;
        form.find('.btn-success').val('Loading...');
        form.find('.btn-success').attr('disabled', true);

        form.find('.has-error').removeClass('has-error');
        form.find('label.error').remove();
        form.find('.callout').remove();

        var formData = form.serialize();
        var formAction = form.attr('action');

        if (doing == false) {
            doing = true;

            $.ajax({
                url: formAction,
                type: 'POST',
                data: formData,
                dataType: 'json'
            })
                    .done(function (response) {
                        if (response.status == 0) {
                            $.each(response.data.errors, function (i, v) {
                                $('.modal-body #' + i).parent().addClass('has-error');
                                $('.modal-body #' + i).after('<label class="error error-' + i + '">' + v + '<label>');
                                //form.closest('form').find('input[name=' + i + ']').after('<label class="error">' + v + '</label>');
                            });
                        }

                        if (response.status == 1) {
                            $('#condat-modal').modal('hide');
                            $('.mainContainer .box').before(notify('success', response.message));
                            setTimeout(function () {
                                $('.callout').remove()
                            }, 2500);
                            window.location.reload();
                        } //success
                    })
                    .fail(function () {
                        alert('Something Went Wrong! Please Try Again Later.');
                    })
                    .always(function () {
                        doing = false;
                        form.find('.btn-success').removeAttr('disabled');
                        form.find('.btn-success').val('<i class="fa fa-plus-circle"></i> Add');
                    });
        }

    });

    function notify(type, text) {
        return '<div class="callout callout-' + type + '"><p>' + text + '</p></div>';
    }
</script>