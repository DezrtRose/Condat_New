$(document).ready(function () {
    //domain suggestion
    $('#names').on('input', function () { //You can bind the 'input' event to the textbox. This would fire every time the input changes, so when you paste something (even with right click), delete and type anything.
        var company = $('#name').val();
        if (company) {
            var currentRequest = null;
            currentRequest = $.ajax({
                url: appUrl + "/domain/suggestion/" + company,
                beforeSend: function () {
                    if (currentRequest != null) {
                        //abort previous request
                        currentRequest.abort();
                    }
                },
                success: function (result) {
                    $('.domain-suggestion').html(result);
                }
            });

        }
        else {
            $('.domain-suggestion').html('name');
        }

    });
});