$(function () {
    // alert notifications
    $('.alert-disappear').delay(2500).slideUp();

    // autofocus
    $('.focus').focus();

    $('form.delete-confirm').submit(function () {
        return userConfirmation($(this));
    });

    $('a.delete-confirm').click(function () {
        return userConfirmation($(this));
    });
});

function userConfirmation(element) {
    return confirm($(element).data('confirm'));
}
