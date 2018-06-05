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

    //  Переход с 1 слайдера на 2
    $('#step1_go1, #step1_go2').click(function () {
        $('#nav_position_1').removeClass('active');
        $('#nav_position_2').addClass('active');
        $('#osago_step_1_nav').hide();
        $('#osago_step_2_nav').css({'display' : 'flex'});
        $('.calc_sliders_container').css({'left' : 'calc(-100% - 25px'});
    });
    //  Переход с 2 слайдера на 1
    $('#step2_back').click(function () {
        $('#nav_position_2').removeClass('active');
        $('#nav_position_1').addClass('active');
        $('#osago_step_2_nav').hide();
        $('#osago_step_1_nav').css({'display' : 'flex'});
        $('.calc_sliders_container').css({'left' : '0px'});
    });
    //  Переход с 2 слайдера на 3
    $('#step2_go1, #step2_go2').click(function () {
        $('#nav_position_2').removeClass('active');
        $('#nav_position_3').addClass('active');
        $('#osago_step_2_nav').hide();
        $('#osago_step_3_nav').css({'display' : 'flex'});
        $('.calc_sliders_container').css({'left' : 'calc(-200% - 50px'});
    });
    //  Переход с 3 слайдера на 2
    $('#step3_back').click(function () {
        $('#nav_position_3').removeClass('active');
        $('#nav_position_2').addClass('active');
        $('#osago_step_3_nav').hide();
        $('#osago_step_2_nav').css({'display' : 'flex'});
        $('.calc_sliders_container').css({'left' : 'calc(-100% - 25px'});
    });
    //  Переход с 3 слайдера на 4
    $('#step3_go1, #step3_go2').click(function () {
        $('#nav_position_3').removeClass('active');
        $('#nav_position_4').addClass('active');
        $('#osago_step_3_nav').hide();
        $('#osago_step_4_nav').css({'display' : 'flex'});
        $('.calc_sliders_container').css({'left' : 'calc(-300% - 75px'});
    });
    //  Переход с 4 слайдера на 3
    $('#step4_back').click(function () {
        $('#nav_position_4').removeClass('active');
        $('#nav_position_3').addClass('active');
        $('#osago_step_4_nav').hide();
        $('#osago_step_3_nav').css({'display' : 'flex'});
        $('.calc_sliders_container').css({'left' : 'calc(-200% - 50px'});
    });
    //  Переход с 4 слайдера на 5
    $('#step4_go1, #step4_go2').click(function () {
        $('#nav_position_4').removeClass('active');
        $('#nav_position_5').addClass('active');
        $('#osago_step_4_nav').hide();
        $('#osago_step_5_nav').css({'display' : 'flex'});
        $('.calc_sliders_container').css({'left' : 'calc(-400% - 100px'});
    });
    //  Переход с 5 слайдера на 4
    $('#step5_back').click(function () {
        $('#nav_position_5').removeClass('active');
        $('#nav_position_4').addClass('active');
        $('#osago_step_5_nav').hide();
        $('#osago_step_4_nav').css({'display' : 'flex'});
        $('.calc_sliders_container').css({'left' : 'calc(-300% - 75px'});
    });
    //  Переход с 5 слайдера на 6
    $('#step5_go1, #step5_go2').click(function () {
        $('#nav_position_5').removeClass('active');
        $('#nav_position_6').addClass('active');
        $('#osago_step_5_nav').hide();
        $('#osago_step_6_nav').css({'display' : 'flex'});
        $('.calc_sliders_container').css({'left' : 'calc(-500% - 125px'});
    });
    //  Переход с 6 слайдера на 5
    $('#step6_back').click(function () {
        $('#nav_position_6').removeClass('active');
        $('#nav_position_5').addClass('active');
        $('#osago_step_6_nav').hide();
        $('#osago_step_5_nav').css({'display' : 'flex'});
        $('.calc_sliders_container').css({'left' : 'calc(-400% - 100px'});
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

    

    // RadioButton
    $('.radioblock').find('.radio').each(function(){
        $(this).click(function(){
            // Заносим текст из нажатого дива в переменную
            var valueRadio = $(this).html();
            // Находим любой активный переключатель и убираем активность
            $(this).parent().find('.radio').removeClass('active');
            // Нажатому диву добавляем активность
            $(this).addClass('active');
            // Заносим значение объявленной переменной в атрибут скрытого инпута
            $(this).parent().find('input').val(valueRadio);
        });
    });

    // Checkbox
    // Отслеживаем событие клика по диву с классом check
    $('.checkboxes').find('.check').click(function(){
        // Пишем условие: если вложенный в див чекбокс отмечен
        if( $(this).find('input').is(':checked') ) {
            // то снимаем активность с дива
            $(this).removeClass('active');
            // и удаляем атрибут checked (делаем чекбокс не отмеченным)
            $(this).find('input').removeAttr('checked');

        // если же чекбокс не отмечен, то
        } else {
            // добавляем класс активности диву
            $(this).addClass('active');
            // добавляем атрибут checked чекбоксу
            $(this).find('input').attr('checked', true);
        }
    });

	$(document).ready(function() {
		$(".main_input_file").change(function(){
			var f_name = [];
			for (var i = 0; i < $(this).get(0).files.length; ++i) {
				f_name.push(' ' + $(this).get(0).files[i].name);
			}
			$("#osago_passport").val(f_name.join(', '));
		});
	});
    
});