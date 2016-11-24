$(function(){
    $(document).on('click', '.cancel_upload', function (e) {
        e.preventDefault();
        var url = $(this).data('url');
        var wrap = $(this).parent();
        var action = $(this).data('action');

        if (!confirm('Are you sure, you want to delete attachment?')) return false;

        if (action == 'compose') {
            $.ajax({
                url: appUrl + 'file/delete',
                type: 'GET',
                dataType: 'json',
                data: {file: url, folder:'attachment'}
            })
                .done(function (response) {
                    if (response.status == 1) {
                        wrap.remove();
                    }
                    else {
                        alert(response.data.error);
                    }
                })
                .fail(function () {
                    alert("Connect error!");
                })
        }
        else {
            wrap.remove();
        }

    });
});