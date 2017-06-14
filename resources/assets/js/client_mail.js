$(document).ready(function () {
    $(document).on('submit', '#mail-payment', function (e) {
        e.preventDefault();
        var form = $(this);

        var doing = false;
        form.find('.btn-success').html('Sending...');
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
                    form.find('.btn-success').html('<i class="fa fa-paper-plane"></i> Send Invoice');
                });
        }

    });

    function notify(type, text) {
        return '<div class="callout callout-' + type + '"><p>' + text + '</p></div>';
    }
});