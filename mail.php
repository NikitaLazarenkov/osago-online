<?php

// переменные.
$to[]='nik.boost@gmail.com'; // Куда отправлять почту (Адрес админа), брать из формы? ну.. не есть хорошо.. ибо могут подменить.
//$to[]='repair333@yandex.ru'; // Для проверки мое мыло.


$from='no-reply@osago.webcoders.pro'; // Обратный адрес, должен содерждать имя домена! иначе в спам бюудет попадать.
$Subject=$_POST['form_subject']; // тема письма, берем из формы


$msg='';
$msg_adm='';
// Проверка
if (isset($_POST['form_subject']) && isset($_POST['name']) ) {} else {echo 'Какая то ошибка.'; die;}

$msg.='Заявка на оформление ОСАГО<br><br>';
$msg.='IP Adress: <br>';
$msg.='ФИО: '.$_POST['name'].'<br>';
$msg.='Телефон: '.$_POST['phone'].'<br>';
$msg.='Email: '.$_POST['email'].'<br><br>';
$msg.='Данные для ОСАГО<br>';
$msg.='Владелец: '.$_POST['send_owner'].'<br>';
$msg.='Место регистрации собственника: '.$_POST['send_mesto_register'].'<br>';
$msg.='Уточнение места регистрации: '.$_POST['send_more_mesto_register'].'<br>';
$msg.='Тип транспортного средства: '.$_POST['send_transport_type'].'<br>';
$msg.='Уточнение типа транспортного средства: '.$_POST['send_more_type'].'<br>';
$msg.='Мощность двигателя (л.с.): '.$_POST['send_power'].'<br>';
$msg.='Прицеп: '.$_POST['send_pritsep'].'<br>';
$msg.='Срок страхования (период использования автомоблиля): '.$_POST['send_srok'].'<br>';
$msg.='Лица, допущенные к управлению: '.$_POST['send_dopusk'].'<br>';
$msg.='Возраст и водительский стаж: '.$_POST['send_staj'].'<br>';
$msg.='Скидка за безаварийную езду: '.$_POST['send_kbm'].'<br>';
$msg.='Стоимость полиса по предварительному расчету составляет: '.$_POST['send_summ1'].'<br>';
$msg.='Итого с оформлением полиса ОСАГО (+ от 1000 рублей за услуги): '.$_POST['send_summ2'].'<br><br>';
$msg.='Данные для Диагностической карты<br>';
$msg.='Диагностическая карта: '.$_POST['send_diagnostic'].'<br>';
$msg.='Марка шин Вашего ТС:: '.$_POST['diagnostic_tires'].'<br>';
$msg.='Пробег ТС: '.$_POST['diagnostic_probeg'].'<br>';
$msg.='Тип двигателя: '.$_POST['engine_type'].'<br>';
$msg.='Стоимость полиса ОСАГО с оформлением диагностической карты + (1000 рублей за услуги) по предварительному расчёту составит: '.$_POST['send_summ3'].'<br><br>';
$msg.='Выберите способ получения полиса: '.$_POST['osago_dostavka'].'<br>';



include ('smtp.php');
$m= new Mail('utf-8');  // можно сразу указать кодировку, можно ничего не указывать ($m= new Mail;)
// Каталог, в который мы будем принимать файл:

$uploaddir = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR;
$uploadfile = $uploaddir . basename($_FILES['file1']['name']);
$m->Attach( $uploadfile);


$m->From($from); // от кого
$m->To($to);   // кому
$m->Subject( $Subject );
$cdf=$msg.$msg_adm;
$m->Body($cdf);
$m->Priority(3) ;	// установка приоритета

$m->Send();	// отправка


if ($m){
	 // Все ок, всем усе ушло
	 echo 'Письмо отправлено';

	 } else {
		 echo 'Какая то ошибка при отправке.';
		 @unlink($uploadfile);
		 die;

	 }



// Проверка
//echo "Письмо отправлено, вот исходный текст письма:<br><pre>", $m->Get(), "</pre>";
@unlink($uploadfile);



/*
 *
 * project_name	Заказ+ремонта
admin_email	nik.boost@gmail.com
form_subject	Заявка+с+сайта+fixremont
name	КАк+обращаться
phone	+7+(111)+111-1111
email	repair333@yandex.ru
client_send	1
 *
 *
 * */
