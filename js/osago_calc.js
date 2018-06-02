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

    $('#step1_go1, #step1_go2').click(function () {
        $('#nav_position_1').removeClass('active');
        $('#nav_position_2').addClass('active');
        $('#osago_step_1_nav').hide();
        $('#osago_step_2_nav').show();
    });

    $('#step2_back').click(function () {
        $('#nav_position_2').removeClass('active');
        $('#nav_position_1').addClass('active');
        $('#osago_step_2_nav').hide();
        $('#osago_step_1_nav').show();
    });
    $('#step2_go1, #step2_go2').click(function () {
        $('#nav_position_2').removeClass('active');
        $('#nav_position_3').addClass('active');
        $('#osago_step_2_nav').hide();
        $('#osago_step_3_nav').show();
    });

    $('#step3_back').click(function () {
        $('#nav_position_3').removeClass('active');
        $('#nav_position_2').addClass('active');
        $('#osago_step_3_nav').hide();
        $('#osago_step_2_nav').show();
    });
    $('#step3_go1, #step3_go2').click(function () {
        $('#nav_position_3').removeClass('active');
        $('#nav_position_4').addClass('active');
        $('#osago_step_3_nav').hide();
        $('#osago_step_4_nav').show();
    });

    $('#step4_back').click(function () {
        $('#nav_position_4').removeClass('active');
        $('#nav_position_3').addClass('active');
        $('#osago_step_4_nav').hide();
        $('#osago_step_3_nav').show();
    });
    $('#step4_go1, #step4_go2').click(function () {
        $('#nav_position_4').removeClass('active');
        $('#nav_position_5').addClass('active');
        $('#osago_step_4_nav').hide();
        $('#osago_step_5_nav').show();
    });

    $('#step5_back').click(function () {
        $('#nav_position_5').removeClass('active');
        $('#nav_position_4').addClass('active');
        $('#osago_step_5_nav').hide();
        $('#osago_step_4_nav').show();
    });

    /*$('.check_position').click(function () {

        if ($('.nav_position_1').hasClass('active')) {
            $('#osago_step_1_nav').show();
            $('#osago_step_2_nav').hide();
            $('#osago_step_3_nav').hide();
            $('#osago_step_4_nav').hide();
            $('#osago_step_5_nav').hide();
        } else {
            $('#osago_step_1_nav').hide();
        }

        if ($('.nav_position_2').hasClass('active')) {
            $('#osago_step_2_nav').show();
            $('#osago_step_1_nav').hide();
            $('#osago_step_3_nav').hide();
            $('#osago_step_4_nav').hide();
            $('#osago_step_5_nav').hide();
        } else {
            $('#osago_step_2_nav').hide();
        }

        if ($('.nav_position_3').hasClass('active')) {
            $('#osago_step_3_nav').show();
            $('#osago_step_1_nav').hide();
            $('#osago_step_2_nav').hide();
            $('#osago_step_4_nav').hide();
            $('#osago_step_5_nav').hide();
        } else {
            $('#osago_step_3_nav').hide();
        }

        if ($('.nav_position_4').hasClass('active')) {
            $('#osago_step_4_nav').show();
            $('#osago_step_1_nav').hide();
            $('#osago_step_2_nav').hide();
            $('#osago_step_3_nav').hide();
            $('#osago_step_5_nav').hide();
        } else {
            $('#osago_step_4_nav').hide();
        }

        if ($('.nav_position_5').hasClass('active')) {
            $('#osago_step_5_nav').show();
            $('#osago_step_1_nav').hide();
            $('#osago_step_2_nav').hide();
            $('#osago_step_3_nav').hide();
            $('#osago_step_4_nav').hide();
        } else {
            $('#osago_step_5_nav').hide();
        }
    });*/

    


    
});