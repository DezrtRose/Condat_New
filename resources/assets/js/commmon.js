(function ($) {
    //Datemask dd/mm/yyyy
    $(".datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});

    if($('#email_ids').length) {
        $('#email_ids').select2({
            containerCssClass : "email-ids",
            placeholder: "Select email recipients"
        });
    }
}(jQuery));