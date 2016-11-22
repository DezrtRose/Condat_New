$(function () {

    $('.com-reminder').on('ifChecked', function (event) {
        var confirmed = confirm('Are you sure you want to mark the reminder as complete?');
        if (!confirmed) {
            setTimeout(function () {
                $(".com-reminder").iCheck('uncheck');
            }, 0.5);
            return false;
        }
        var id = $(this).attr('id');
        var parentLi = $(this).closest('li');
        $.ajax({
            url: appUrl + '/reminder/' + id,
            type: 'get',
            success: function (response) {
                if (response.status == 1) {
                    parentLi.slideUp('slow');
                    var count = parseInt($('.reminder-count').first().text());
                    $('.reminder-count').html(count - 1);
                }
            }
        });
    });

    'use strict';
    var fn = function () {
        $.ajax({
            url: appUrl + '/subscription/check',
            type: 'get',
            success: function (resp) {
                if (resp == 0 || resp == 2) {
                    $('#renew-subscription').show();
                } else if (resp == 1) {
                    $('#renew-subscription').hide();
                }
            }
        })
    };
    fn();

    $('.slimscroll').slimscroll({
        allowPageScroll: true
    });
});

$(document).ajaxComplete(function () {
    $(".icheck").iCheck({
        checkboxClass: 'icheckbox_square-blue',
        increaseArea: '20%' // optional
    });
    $('[data-tooltip="tooltip"]').tooltip();
    $(".date-picker").datepicker({'format': 'dd/mm/yyyy'});
});

$('body').on('focus',".date-picker", function(){
    $(this).datepicker();
});
