(function ($) {

    var form = $("#signup-form");
    form.steps({
        headerTag: "h3",
        bodyTag: "fieldset",
        transitionEffect: "fade",
        labels: {
            previous: 'Kembali',
            next: 'Selanjutnya',
            finish: 'See all price list available for you',
            current: ''
        },
        titleTemplate: '<h3 class="title">#title#</h3>',
        // onStepChanging: function (event, currentIndex, newIndex) {
        //     form.validate().settings.ignore = ":disabled,:hidden";
        //     return form.valid();
        // },
        onFinished: function (event, currentIndex) {
            $("#signup-form").submit();
        },
    });

    var form = $("#choose-form");
    form.steps({
        headerTag: "h3",
        bodyTag: "fieldset",
        transitionEffect: "fade",
        labels: {
            previous: 'Kembali',
            next: 'Selanjutnya',
            finish: 'Selanjutnya',
            current: 'Ketentuan Pre-sale'
        },
        titleTemplate: '<h3 class="title">#title#</h3>',
        onStepChanging: function (event, currentIndex, newIndex) {

        },
        onFinished: function (event, currentIndex) {
            if ($('#package_membership_id').val() == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please select the package!',
                });
            } else {
                $("#choose-form").submit();
            }
        },
    });
})(jQuery);