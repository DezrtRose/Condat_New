(function ($) {
    //Datemask dd/mm/yyyy
    $(".datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});

    if ($('#email_ids').length) {
        $.fn.select2.amd.require([
            'select2/utils',
            'select2/dropdown',
            'select2/dropdown/attachBody'
        ], function (Utils, Dropdown, AttachBody) {
            function SelectAll() {
            }

            SelectAll.prototype.render = function (decorated) {
                var $rendered = decorated.call(this);
                var self = this;

                var $selectAll = $(
                    '<button type="button">Select All</button>'
                );

                $rendered.find('.select2-dropdown').prepend($selectAll);

                $selectAll.on('click', function (e) {
                    var $results = $rendered.find('.select2-results__option[aria-selected=false]');

                    // Get all results that aren't selected
                    $results.each(function () {
                        var $result = $(this);

                        // Get the data object for it
                        var data = $result.data('data');

                        // Trigger the select event
                        self.trigger('select', {
                            data: data
                        });
                    });

                    self.trigger('close');
                });

                return $rendered;
            };
            $('#email_ids').select2({
                allowClear: true,
                containerCssClass: "email-ids",
                placeholder: "Select email recipients",
                dropdownAdapter: Utils.Decorate(
                    Utils.Decorate(
                        Dropdown,
                        AttachBody
                    ),
                    SelectAll
                ),
            });
        });
    }
}(jQuery));