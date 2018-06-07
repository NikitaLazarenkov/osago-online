jQuery(document).ready(function($) {

    $('#more_mesto_register').prop('disabled', true);

    // Кастомный радиоблок
    $('.radioblock').find('.radio').each(function(){
        $(this).click(function(){
            var valueRadio = $(this).html();
            $(this).parent().find('.radio').removeClass('active');
            $(this).addClass('active');
            $(this).parent().find('input').val(valueRadio);
        });
    });

    // Кастомный чекбокс
    $('.checkboxes').find('.check').click(function(){
        if( $(this).find('input').is(':checked') ) {
            $(this).removeClass('active');
            $(this).find('input').removeAttr('checked');
        } else {
            $(this).addClass('active');
            $(this).find('input').attr('checked', true);
        }
    });

    // Переключение вкладок ОСАГО и КАСКО
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

    // НАВИГАЦИЯ ПО СЛАЙДАМ
    // Переход с 1 слайдера на 2
    $('#step1_go1, #step1_go2').click(function () {
        $('#nav_position_1').removeClass('active');
        $('#nav_position_2').addClass('active');
        $('#osago_step_1_nav').hide();
        $('#osago_step_2_nav').css({'display' : 'flex'});
        $('.calc_sliders_container').css({'left' : 'calc(-100% - 25px'});
    });
    // Переход с 2 слайдера на 1
    $('#step2_back').click(function () {
        $('#nav_position_2').removeClass('active');
        $('#nav_position_1').addClass('active');
        $('#osago_step_2_nav').hide();
        $('#osago_step_1_nav').css({'display' : 'flex'});
        $('.calc_sliders_container').css({'left' : '0px'});
    });
    // Переход с 2 слайдера на 3
    $('#step2_go1, #step2_go2').click(function () {
        $('#nav_position_2').removeClass('active');
        $('#nav_position_3').addClass('active');
        $('#osago_step_2_nav').hide();
        $('#osago_step_3_nav').css({'display' : 'flex'});
        $('.calc_sliders_container').css({'left' : 'calc(-200% - 50px'});
    });
    // Переход с 3 слайдера на 2
    $('#step3_back').click(function () {
        $('#nav_position_3').removeClass('active');
        $('#nav_position_2').addClass('active');
        $('#osago_step_3_nav').hide();
        $('#osago_step_2_nav').css({'display' : 'flex'});
        $('.calc_sliders_container').css({'left' : 'calc(-100% - 25px'});
    });
    // Переход с 3 слайдера на 4
    
    $('#step3_go1, #step3_go2').click(function () {
        var a = $('#name').val();
        var b = $('#phone').val();
        var c = $('#email').val();
        var d = $('#osago_file_passport').val();
        if (a=="") {
            $('#name').attr('placeholder','Пожалуйста, заполните это поле!');
        } 
        if (b=="") {
            $('#phone').attr('placeholder','Пожалуйста, заполните это поле!');
        } 
        if (c=="") {
            $('#email').attr('placeholder','Пожалуйста, заполните это поле!');
        } 
        if (d=="") {
            $('#osago_passport').attr('value','Пожалуйста, заполните это поле!');
        }
        if (a!="" && b!="" && c!="" && d!="") {
            $('#nav_position_3').removeClass('active');
            $('#nav_position_4').addClass('active');
            $('#osago_step_3_nav').hide();
            $('#osago_step_4_nav').css({'display' : 'flex'});
            $('.calc_sliders_container').css({'left' : 'calc(-300% - 75px'});
        }
    });
    // Переход с 4 слайдера на 3
    $('#step4_back').click(function () {
        $('#nav_position_4').removeClass('active');
        $('#nav_position_3').addClass('active');
        $('#osago_step_4_nav').hide();
        $('#osago_step_3_nav').css({'display' : 'flex'});
        $('.calc_sliders_container').css({'left' : 'calc(-200% - 50px'});
    });
    // Переход с 4 слайдера на 5 или 6
    $('#step4_go1, #step4_go2').click(function () {
        var a = $('#osago_file_sts').val();
        var b = $('#osago_file_vu').val();
        var c = $('#osago_file_diagnostic').val();
        var d = $('#osago_have_diagnostic');
        if (d.is(":checked")) {
            if (a=="") {
                $('#osago_sts').attr('value','Пожалуйста, заполните это поле!');
            } 
            if (b=="") {
                $('#osago_vu').attr('value','Пожалуйста, заполните это поле!');
            }
            if (a!="" && b!="") {
                $('#p_result_diagnistic').show();
                $('#nav_position_4').removeClass('active');
                $('#nav_position_5').addClass('active');
                $('#osago_step_4_nav').hide();
                $('#osago_step_5_nav').css({'display' : 'flex'});
                $('.calc_sliders_container').css({'left' : 'calc(-400% - 100px'});
            }
        } else {
            if (a=="") {
                $('#osago_sts').attr('value','Пожалуйста, заполните это поле!');
            } 
            if (b=="") {
                $('#osago_vu').attr('value','Пожалуйста, заполните это поле!');
            }
            if (c=="") {
                $('#osago_diagnostic').attr('value','Пожалуйста, заполните это поле!');
            }
            if (a!="" && b!="" && c!="") {
                $('#p_result_diagnistic').hide();
                $('#nav_position_4').removeClass('active');
                $('#nav_position_6').addClass('active');
                $('#osago_step_4_nav').hide();
                $('#osago_step_6_nav').css({'display' : 'flex'});
                $('.calc_sliders_container').css({'left' : 'calc(-500% - 125px'});
            }
        }
    });
    // Переход с 5 слайдера на 4
    $('#step5_back').click(function () {
        $('#nav_position_5').removeClass('active');
        $('#nav_position_4').addClass('active');
        $('#osago_step_5_nav').hide();
        $('#osago_step_4_nav').css({'display' : 'flex'});
        $('.calc_sliders_container').css({'left' : 'calc(-300% - 75px'});
    });
    // Переход с 5 слайдера на 6
    $('#step5_go1, #step5_go2').click(function () {
        var a = $('#diagnostic_tires').val();
        var b = $('#diagnostic_probeg').val();
        var c = $('#engine_type').val();
        if (a=="") {
            $('#diagnostic_tires').attr('placeholder','Пожалуйста, заполните это поле!');
        } 
        if (b=="") {
            $('#diagnostic_probeg').attr('placeholder','Пожалуйста, заполните это поле!');
        }
        if (c==0) {
            $('#engine_type').css({'border' : '3px solid #ff0000'});
        }
        if (a!="" && b!="" && c!=0) {
            $('#nav_position_5').removeClass('active');
            $('#nav_position_6').addClass('active');
            $('#osago_step_5_nav').hide();
            $('#osago_step_6_nav').css({'display' : 'flex'});
            $('.calc_sliders_container').css({'left' : 'calc(-500% - 125px'});
        }
    });
    // Переход с 6 слайдера на 5 или 4
    $('#step6_back').click(function () {
        if ($('#osago_have_diagnostic').is(":checked")) {
            $('#nav_position_6').removeClass('active');
            $('#nav_position_5').addClass('active');
            $('#osago_step_6_nav').hide();
            $('#osago_step_5_nav').css({'display' : 'flex'});
            $('.calc_sliders_container').css({'left' : 'calc(-400% - 100px'});
        } else {
            $('#nav_position_6').removeClass('active');
            $('#nav_position_4').addClass('active');
            $('#osago_step_6_nav').hide();
            $('#osago_step_4_nav').css({'display' : 'flex'});
            $('.calc_sliders_container').css({'left' : 'calc(-300% - 75px'});
        }
    });

    // Блокировка пунктов
    $('#owner').change(function () {
        var a = $('#owner').val();
        if (a==2) {
            $('#osago_srok').prop('disabled', true);
            $('#osago_staj').prop('disabled', true);
            $('#osago_dopusk_container').css({'pointer-events' : 'none'});
            $('.id1203, .id1204, .id1205').css({'color' : '#cccccc'});
            $('.id1204').removeClass('active');
            $('.id1205').addClass('active');
            $('#send_owner').val('Юридическое лицо');
            $('#send_dopusk').val("без ограничений");
        } else {
            $('#osago_srok').prop('disabled', false);
            $('#osago_staj').prop('disabled', false);
            $('#osago_dopusk_container').css({'pointer-events' : 'all'});
            $('.id1203, .id1204, .id1205').css({'color' : '#ffffff'});
            $('.id1205').removeClass('active');
            $('.id1204').addClass('active');
            $('#send_owner').val('Физическое лицо');
            $('#send_dopusk').val("с ограничениями");
        }
        var b = $('#send_owner').val();
        console.log(b);
        console.log($('#send_dopusk').val());
    });

    $('.osago_dopusk').click(function () {
        var a = $('#osago_dopusk').val();
        var b = $('#owner').val();
        if (b==2) {
            $('#osago_staj').prop('disabled', true);
            $('#send_dopusk').val("без ограничений");
        } else {
            if (a=="Без ограничений") {
                $('#osago_staj').prop('disabled', true);
                $('#send_dopusk').val("без ограничений");
            } else {
                $('#osago_staj').prop('disabled', false);
                $('#send_dopusk').val("с ограничениями");
            }
        }
        console.log($('#send_dopusk').val());
    });
    
    // Блокировка дополнительного места регистрации
    $('#mesto_register').change(function () {
        var a = $('#mesto_register').val();
        if (a==85 || a==84 || a==83 || a==82 || a==81 || a==80 || a==20 || a==9 || a==50 || a==77 || a==78 || a==47 || a==1 || a==87) {
            $('#more_mesto_register').prop('disabled', true);
        } else {
            $('#more_mesto_register').prop('disabled', false);
        }

    });

    
    // Блокировка дополнительного типа транспортного средства
    $('#transport_type').change(function () {
        var a = $('#transport_type').val();
        if (a=='a' || a=='tramvai' || a=='trolleibus' || a=='traktor' ) {
            $('#more_type').prop('disabled', true);
        } else {
            $('#more_type').prop('disabled', false);
        }
    });

    // Отображение имени загруженного файла
    $(".file_osago_vu").change(function(){
        var f_name = [];
        for (var i = 0; i < $(this).get(0).files.length; ++i) {
            f_name.push(' ' + $(this).get(0).files[i].name);
        }
        $("#osago_vu").val(f_name.join(', '));
    });
    // Отображение имени загруженного файла
    $(".file_osago_passport").change(function(){
        var f_name = [];
        for (var i = 0; i < $(this).get(0).files.length; ++i) {
            f_name.push(' ' + $(this).get(0).files[i].name);
        }
        $("#osago_passport").val(f_name.join(', '));
    });
    // Отображение имени загруженного файла
    $(".file_osago_sts").change(function(){
        var f_name = [];
        for (var i = 0; i < $(this).get(0).files.length; ++i) {
            f_name.push(' ' + $(this).get(0).files[i].name);
        }
        $("#osago_sts").val(f_name.join(', '));
    });
    // Отображение имени загруженного файла
    $(".file_osago_diagnostic").change(function(){
        var f_name = [];
        for (var i = 0; i < $(this).get(0).files.length; ++i) {
            f_name.push(' ' + $(this).get(0).files[i].name);
        }
        $("#osago_diagnostic").val(f_name.join(', '));
    });

    function osagoCalc() {
        var owner = $('#owner').val(); // 1 - физическое лицо, 2 - юридическое лицо
        var type = $('#transport_type').val(); 
        var type2 = $('#more_type').val();
        var pritsep = $('#osago_pritsep');

        // Тип транспорта с коэффициентом на отправку
        var send_type = $('#transport_type').find(':selected').html(); // Тип транспорта
        var send_type2 = $('#more_type').find(':selected').html(); // Тип транспорта уточнение

        if (type=='a' || type=='tramvai' || type=='trolleibus' || type=='traktor') {
            var tb = $('#transport_type').find(':selected').data('val1');
            $('#send_transport_type').val(send_type + " (Бс=" + tb + ")");
            $('#send_more_type').val(send_type2);
        } else {
            tb = $('#more_type').find(':selected').data('val1');
            $('#send_transport_type').val(send_type);
            $('#send_more_type').val(send_type2 + " (Бс=" + tb + ")");
        }
        if (type=='b' && owner==2) {
            tb = $('#more_type').find(':selected').data('val2');
            $('#send_transport_type').val(send_type);
            $('#send_more_type').val(send_type2 + " (Бс=" + tb + ")");
        }
        console.log($('#send_transport_type').val());
        console.log($('#send_more_type').val());
        

        // смотрим коэффициент территории
        var kt1 = $('#mesto_register').find(':selected').data('val1');
        var kt2 = $('#mesto_register').find(':selected').data('val2');
        var kt_1 = $('#more_mesto_register').find(':selected').data('val1');
        var kt_2 = $('#more_mesto_register').find(':selected').data('val2');
        var kt = 0;

        var send_ter = $('#mesto_register').find(':selected').html(); // Территория
        var send_ter2 = $('#more_mesto_register').find(':selected').html(); // Территория уточнение


        if (type=='traktor') {
            if (kt1=='_' || kt2=='_') {
                kt = kt_2;
                $('#send_mesto_register').val(send_ter);
                $('#send_more_mesto_register').val(send_ter2 + " (Кт=" + kt + ")");
            } else {
                kt = kt2;
                $('#send_mesto_register').val(send_ter + " (Кт=" + kt + ")");
                $('#send_more_mesto_register').val(send_ter2);
            }
            
        } else {
            if (kt1=='_' || kt2=='_') {
                kt = kt_1;
                $('#send_mesto_register').val(send_ter);
                $('#send_more_mesto_register').val(send_ter2 + " (Кт=" + kt + ")");
            } else {
                kt = kt1;
                $('#send_mesto_register').val(send_ter + " (Кт=" + kt + ")");
                $('#send_more_mesto_register').val(send_ter2);
            }
        }
        console.log($('#send_mesto_register').val());
        console.log($('#send_more_mesto_register').val());

        var kpr = 1;
        if (pritsep.is(":checked")) {
            if ((owner==2 && type=='b') || type=='a') {
                kpr = 1.16;
            } else if (type2==3) {
                kpr = 1.40;
            } else if (type2==4) {
                kpr = 1.25;
            } else if (type=='traktor') {
                kpr = 1.24;
            } else {
                kpr = 1;
            }
            $('#send_pritsep').val("Да (" + kpr + ")");
        } else {
            kpr = 1;
            $('#send_pritsep').val("Нет (" + kpr + ")");
        }
        console.log($('#send_pritsep').val());

        var km = $('#osago_power').val();
        var kvs = $('#osago_staj').val();
        var kp = $('#osago_srok').val();
        var kbm = $('#osago_kbm').val();

        var send_power = $('#osago_power').find(':selected').html(); // Мощность двигателя
        $('#send_power').val(send_power);
        console.log($('#send_power').val());

        var send_staj = $('#osago_staj').find(':selected').html(); // Мощность двигателя
        $('#send_staj').val(send_staj);
        console.log($('#send_staj').val());

        var send_srok = $('#osago_srok').find(':selected').html(); // Мощность двигателя
        $('#send_srok').val(send_srok);
        console.log($('#send_srok').val());

        var send_kbm = $('#osago_kbm').find(':selected').html(); // Мощность двигателя
        $('#send_kbm').val(send_kbm);
        console.log($('#send_kbm').val());
        
        //console.log('------------------------------------');
        //console.log('Базовая ставка = ' + tb);
        //console.log('Коэффициент территории = ' + kt);
        //console.log('Коэффициент мощности = ' + km);
        //console.log('Коэффициент стажа = ' + kvs);
        //console.log('Коэффициент срока = ' + kp);
        //console.log('Бонус-малус = ' + kbm);
        //console.log('Коэффициент за прицеп = ' + kpr);
        //console.log('------------');
        if ($('#osago_have_diagnostic').is(":checked")) {
            $('#send_diagnostic').val("Нужна");
        } else {
            $('#send_diagnostic').val("Не нужна");
        }
        console.log($('#send_diagnostic').val());

        var summ = tb * kt * km * kvs * kp * kbm * kpr;
        
        var summ = summ.toFixed(0);

        var summ2 = Number(summ*1 + 1000);
        var summ2 = summ2.toFixed(0);
        
        var summ3 = Number(summ*1 + 1700);
        var summ3 = summ3.toFixed(0);
        
        //console.log('Стоимость ОСАГО = ' + summ);
        //console.log('+ 1000р. = ' + summ2);
        //console.log('+ 700р. = ' + summ3);

        $('.osago_summ').html(summ);
        $('.osago_summ2').html(summ2);
        $('.osago_summ3').html(summ3);

        $('.send_summ').val(summ + " рублей");
        $('.send_summ2').val(summ2 + " рублей");
        $('.send_summ3').val(summ3 + " рублей");
    }

    $('.check, .radio').click(function() {
        osagoCalc();
    });
    $('select').change(function() {
        osagoCalc();
    });
    
});