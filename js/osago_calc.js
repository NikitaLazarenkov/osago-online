jQuery(document).ready(function($) {
    $('#kasko_open').click(function () {
        $(this).addClass('active');
        $('#osago_open').removeClass('active');
        $('#osago_calc').hide();
        $('#kasko_calc').show();
    });
    $('#osago_open').click(function () {
        $(this).addClass('active');
        $('#kasko_open').removeClass('active');
        $('#osago_calc').show();
        $('#kasko_calc').hide();
    });
});