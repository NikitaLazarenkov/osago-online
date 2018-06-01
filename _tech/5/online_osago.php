<?php
function ValidateEmail($email)
{
   $pattern = '/^([0-9a-z]([-.\w]*[0-9a-z])*@(([0-9a-z])+([-\w]*[0-9a-z])*\.)+[a-z]{2,6})$/i';
   return preg_match($pattern, $email);
}
function RecursiveMkdir($path)
{
   if (!file_exists($path))
   {
      RecursiveMkdir(dirname($path));
      mkdir($path, 0777);
   }
}
function ReplaceVariables($code)
{
   foreach ($_POST as $key => $value)
   {
      if (is_array($value))
      {
         $value = implode(",", $value);
      }
      $name = "$" . $key;
      $code = str_replace($name, $value, $code);
   }
   $code = str_replace('$ipaddress', $_SERVER['REMOTE_ADDR'], $code);
   return $code;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['formid']) && $_POST['formid'] == 'form1')
{
   $mailto = 'souzosago@yandex.ru';
   $mailfrom = isset($_POST['email']) ? $_POST['email'] : $mailto;
   $subject = 'Заявка на оформление ОСАГО';
   $message = 'Заявка на оформление ОСАГО';
   $success_url = './online_osago_otpravleno.php';
   $error_url = '';
   $error = '';
   $eol = "\n";
   $max_filesize = 100000*1024;
   $upload_folder = "upload";
   $upload_folder = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME'])."/".$upload_folder;

   $boundary = md5(uniqid(time()));

   $header  = 'From: '.$mailfrom.$eol;
   $header .= 'Reply-To: '.$mailfrom.$eol;
   $header .= 'MIME-Version: 1.0'.$eol;
   $header .= 'Content-Type: multipart/mixed; boundary="'.$boundary.'"'.$eol;
   $header .= 'X-Mailer: PHP v'.phpversion().$eol;
   if (!ValidateEmail($mailfrom))
   {
      $error .= "The specified email address is invalid!\n<br>";
   }

   $i = 0;
   while (list ($key, $val) = each ($_FILES))
   {
      if ($_FILES[$key]['name'] != "" and file_exists($_FILES[$key]['tmp_name']) and $_FILES[$key]['size'] > 0)
      {
         $upload_DstName[$i] = $_FILES[$key]['name'];
         $upload_SrcName[$i] = $_FILES[$key]['name'];
         $upload_Size[$i] = ($_FILES[$key]['size']);
         $upload_Temp[$i] = ($_FILES[$key]['tmp_name']);
         $upload_URL[$i] = "$upload_folder/$upload_DstName[$i]";
         $upload_FieldName[$i] = $key;
      }
      if ($upload_Size[$i] >= $max_filesize)
      {
         $error .= "The size of $key (file: $upload_SrcName[$i]) is bigger than the allowed " . $max_filesize/1024 . " Kbytes!\n";
      }
      $i++;
   }

   if (!empty($error))
   {
      $errorcode = file_get_contents($error_url);
      $replace = "##error##";
      $errorcode = str_replace($replace, $error, $errorcode);
      echo $errorcode;
      exit;
   }

   $uploadfolder = basename($upload_folder);
   for ($i = 0; $i < count($upload_DstName); $i++)
   {
      $uploadFile = $uploadfolder . "/" . $upload_DstName[$i];
      if (!is_dir(dirname($uploadFile)))
      {
         RecursiveMkdir(dirname($uploadFile));
      }
      move_uploaded_file($upload_Temp[$i] , $uploadFile);
      chmod($uploadFile, 0644);
      $name = "$" . $upload_FieldName[$i];
      $message = str_replace($name, $upload_URL[$i], $message);
   }

   $internalfields = array ("submit", "reset", "send", "filesize", "formid", "captcha_code", "recaptcha_challenge_field", "recaptcha_response_field", "g-recaptcha-response");
   $message .= $eol;
   $message .= "IP Address : ";
   $message .= $_SERVER['REMOTE_ADDR'];
   $message .= $eol;
   $logdata = '';
   foreach ($_POST as $key => $value)
   {
      if (!in_array(strtolower($key), $internalfields))
      {
         if (!is_array($value))
         {
            $message .= ucwords(str_replace("_", " ", $key)) . " : " . $value . $eol;
         }
         else
         {
            $message .= ucwords(str_replace("_", " ", $key)) . " : " . implode(",", $value) . $eol;
         }
      }
   }
   if (count($upload_SrcName) > 0)
   {
      $message .= "\nThe following files have been uploaded:\n";
      for ($i = 0; $i < count($upload_SrcName); $i++)
      {
         $message .= $upload_SrcName[$i] . ": " . $upload_URL[$i] . "\n";
      }
   }
   $body  = 'This is a multi-part message in MIME format.'.$eol.$eol;
   $body .= '--'.$boundary.$eol;
   $body .= 'Content-Type: text/plain; charset=UTF-8'.$eol;
   $body .= 'Content-Transfer-Encoding: 8bit'.$eol;
   $body .= $eol.stripslashes($message).$eol;
   $body .= '--'.$boundary.'--'.$eol;
   if ($mailto != '')
   {
      mail($mailto, $subject, $body, $header);
   }
   $successcode = file_get_contents($success_url);
   $successcode = ReplaceVariables($successcode);
   echo $successcode;
   exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['formid']) && $_POST['formid'] == 'form2')
{
   $mailto = 'souzosago@yandex.ru';
   $mailfrom = isset($_POST['email']) ? $_POST['email'] : $mailto;
   $subject = 'Заявка на оформление ОСАГО';
   $message = 'Заявка на оформление ОСАГО';
   $success_url = './online_osago_otpravleno.php';
   $error_url = '';
   $error = '';
   $eol = "\n";
   $max_filesize = 100000*1024;
   $upload_folder = "upload";
   $upload_folder = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME'])."/".$upload_folder;

   $boundary = md5(uniqid(time()));

   $header  = 'From: '.$mailfrom.$eol;
   $header .= 'Reply-To: '.$mailfrom.$eol;
   $header .= 'MIME-Version: 1.0'.$eol;
   $header .= 'Content-Type: multipart/mixed; boundary="'.$boundary.'"'.$eol;
   $header .= 'X-Mailer: PHP v'.phpversion().$eol;
   if (!ValidateEmail($mailfrom))
   {
      $error .= "The specified email address is invalid!\n<br>";
   }

   $i = 0;
   while (list ($key, $val) = each ($_FILES))
   {
      if ($_FILES[$key]['name'] != "" and file_exists($_FILES[$key]['tmp_name']) and $_FILES[$key]['size'] > 0)
      {
         $upload_DstName[$i] = $_FILES[$key]['name'];
         $upload_SrcName[$i] = $_FILES[$key]['name'];
         $upload_Size[$i] = ($_FILES[$key]['size']);
         $upload_Temp[$i] = ($_FILES[$key]['tmp_name']);
         $upload_URL[$i] = "$upload_folder/$upload_DstName[$i]";
         $upload_FieldName[$i] = $key;
      }
      if ($upload_Size[$i] >= $max_filesize)
      {
         $error .= "The size of $key (file: $upload_SrcName[$i]) is bigger than the allowed " . $max_filesize/1024 . " Kbytes!\n";
      }
      $i++;
   }

   if (!empty($error))
   {
      $errorcode = file_get_contents($error_url);
      $replace = "##error##";
      $errorcode = str_replace($replace, $error, $errorcode);
      echo $errorcode;
      exit;
   }

   $uploadfolder = basename($upload_folder);
   for ($i = 0; $i < count($upload_DstName); $i++)
   {
      $uploadFile = $uploadfolder . "/" . $upload_DstName[$i];
      if (!is_dir(dirname($uploadFile)))
      {
         RecursiveMkdir(dirname($uploadFile));
      }
      move_uploaded_file($upload_Temp[$i] , $uploadFile);
      chmod($uploadFile, 0644);
      $name = "$" . $upload_FieldName[$i];
      $message = str_replace($name, $upload_URL[$i], $message);
   }

   $internalfields = array ("submit", "reset", "send", "filesize", "formid", "captcha_code", "recaptcha_challenge_field", "recaptcha_response_field", "g-recaptcha-response");
   $message .= $eol;
   $message .= "IP Address : ";
   $message .= $_SERVER['REMOTE_ADDR'];
   $message .= $eol;
   $logdata = '';
   foreach ($_POST as $key => $value)
   {
      if (!in_array(strtolower($key), $internalfields))
      {
         if (!is_array($value))
         {
            $message .= ucwords(str_replace("_", " ", $key)) . " : " . $value . $eol;
         }
         else
         {
            $message .= ucwords(str_replace("_", " ", $key)) . " : " . implode(",", $value) . $eol;
         }
      }
   }
   if (count($upload_SrcName) > 0)
   {
      $message .= "\nThe following files have been uploaded:\n";
      for ($i = 0; $i < count($upload_SrcName); $i++)
      {
         $message .= $upload_SrcName[$i] . ": " . $upload_URL[$i] . "\n";
      }
   }
   $body  = 'This is a multi-part message in MIME format.'.$eol.$eol;
   $body .= '--'.$boundary.$eol;
   $body .= 'Content-Type: text/plain; charset=UTF-8'.$eol;
   $body .= 'Content-Transfer-Encoding: 8bit'.$eol;
   $body .= $eol.stripslashes($message).$eol;
   $body .= '--'.$boundary.'--'.$eol;
   if ($mailto != '')
   {
      mail($mailto, $subject, $body, $header);
   }
   $successcode = file_get_contents($success_url);
   $successcode = ReplaceVariables($successcode);
   echo $successcode;
   exit;
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>ОСАГО онлайн в Тамбове. Калькулятор КАСКО и ОСАГО.</title>
<meta name="generator" content="WYSIWYG Web Builder 12 - http://www.wysiwygwebbuilder.com">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="favicon.png" rel="shortcut icon" type="image/x-icon">
<link href="style/wb.validation.css" rel="stylesheet">
<link href="style/souzosago.css" rel="stylesheet">
<link href="style/online_osago.css" rel="stylesheet">
<script src="js/jquery-1.12.4.min.js"></script>
<script src="js/wb.carousel.min.js"></script>
<script src="js/wb.validation.min.js"></script>
<script>
function ValidateCarousel1()
{
   var regexp;
   var Editbox5 = document.getElementById('Editbox5');
   if (!(Editbox5.disabled || Editbox5.style.display === 'none' || Editbox5.style.visibility === 'hidden'))
   {
      if (Editbox5.value == "")
      {
         alert("Пожалуйста заполните поле \"e-mail адрес\"!");
         Editbox5.focus();
         return false;
      }
      if (Editbox5.value.length < 4)
      {
         alert("Пожалуйста заполните поле \"e-mail адрес\"!");
         Editbox5.focus();
         return false;
      }
      if (Editbox5.value.length > 50)
      {
         alert("Пожалуйста заполните поле \"e-mail адрес\"!");
         Editbox5.focus();
         return false;
      }
   }
   var Editbox4 = document.getElementById('Editbox4');
   if (!(Editbox4.disabled || Editbox4.style.display === 'none' || Editbox4.style.visibility === 'hidden'))
   {
      if (Editbox4.value == "")
      {
         alert("Пожалуйста заполните поле \"Телефон\"!");
         Editbox4.focus();
         return false;
      }
      if (Editbox4.value.length < 2)
      {
         alert("Пожалуйста заполните поле \"Телефон\"!");
         Editbox4.focus();
         return false;
      }
      if (Editbox4.value.length > 50)
      {
         alert("Пожалуйста заполните поле \"Телефон\"!");
         Editbox4.focus();
         return false;
      }
   }
   var Editbox3 = document.getElementById('Editbox3');
   if (!(Editbox3.disabled || Editbox3.style.display === 'none' || Editbox3.style.visibility === 'hidden'))
   {
      if (Editbox3.value == "")
      {
         alert("Пожалуйста заполните поле \"Ф.И.О.\"!");
         Editbox3.focus();
         return false;
      }
      if (Editbox3.value.length < 2)
      {
         alert("Пожалуйста заполните поле \"Ф.И.О.\"!");
         Editbox3.focus();
         return false;
      }
      if (Editbox3.value.length > 100)
      {
         alert("Пожалуйста заполните поле \"Ф.И.О.\"!");
         Editbox3.focus();
         return false;
      }
   }
   var Editbox6 = document.getElementById('Editbox6');
   if (!(Editbox6.disabled || Editbox6.style.display === 'none' || Editbox6.style.visibility === 'hidden'))
   {
      if (Editbox6.value.length < 2)
      {
         alert("Пожалуйста заполните поле \"Марка шин\"!");
         Editbox6.focus();
         return false;
      }
      if (Editbox6.value.length > 100)
      {
         alert("Пожалуйста заполните поле \"Марка шин\"!");
         Editbox6.focus();
         return false;
      }
   }
   var Editbox7 = document.getElementById('Editbox7');
   if (!(Editbox7.disabled || Editbox7.style.display === 'none' || Editbox7.style.visibility === 'hidden'))
   {
      if (Editbox7.value.length < 2)
      {
         alert("Пожалуйста заполните поле \"Пробег\"!");
         Editbox7.focus();
         return false;
      }
      if (Editbox7.value.length > 100)
      {
         alert("Пожалуйста заполните поле \"Пробег\"!");
         Editbox7.focus();
         return false;
      }
   }
   var FileUpload2 = document.getElementById('FileUpload2');
   if (!(FileUpload2.disabled ||
         FileUpload2.style.display === 'none' ||
         FileUpload2.style.visibility === 'hidden'))
   {
      if (FileUpload2.value == "")
      {
         alert("Пожалуйста загрузите скан или фото СТС или ПТС! Поддерживаемые форматы: bmp, jpeg, jpg, ddf, png. Не более 5mb.");
         return false;
      }
      var ext = FileUpload2.value.substr(FileUpload2.value.lastIndexOf('.'));
      if ((ext.toLowerCase() != ".bmp") &&
          (ext.toLowerCase() != ".jpeg") &&
          (ext.toLowerCase() != ".jpg") &&
          (ext.toLowerCase() != ".pdf") &&
          (ext.toLowerCase() != ".png"))
      {
         alert("Пожалуйста загрузите скан или фото СТС или ПТС! Поддерживаемые форматы: bmp, jpeg, jpg, ddf, png. Не более 5mb.");
         return false;
      }
   }
   var FileUpload3 = document.getElementById('FileUpload3');
   if (!(FileUpload3.disabled ||
         FileUpload3.style.display === 'none' ||
         FileUpload3.style.visibility === 'hidden'))
   {
      var ext = FileUpload3.value.substr(FileUpload3.value.lastIndexOf('.'));
      if ((ext.toLowerCase() != ".bmp") &&
          (ext.toLowerCase() != ".jpeg") &&
          (ext.toLowerCase() != ".jpg") &&
          (ext.toLowerCase() != ".pdf") &&
          (ext.toLowerCase() != ".png") &&
          (ext != ""))
      {
         alert("Пожалуйста загрузите скан или фото ВУ всех лиц допущенных к управлению ТС! Поддерживаемые форматы: bmp, jpeg, jpg, ddf, png. Не более 5mb.");
         return false;
      }
   }
   var FileUpload4 = document.getElementById('FileUpload4');
   if (!(FileUpload4.disabled ||
         FileUpload4.style.display === 'none' ||
         FileUpload4.style.visibility === 'hidden'))
   {
      if (FileUpload4.value == "")
      {
         alert("Пожалуйста загрузите скан или фото диагностической карты ТС! Поддерживаемые форматы: bmp, jpeg, jpg, ddf, png. Не более 5mb.");
         return false;
      }
      var ext = FileUpload4.value.substr(FileUpload4.value.lastIndexOf('.'));
      if ((ext.toLowerCase() != ".bmp") &&
          (ext.toLowerCase() != ".jpeg") &&
          (ext.toLowerCase() != ".jpg") &&
          (ext.toLowerCase() != ".pdf") &&
          (ext.toLowerCase() != ".png"))
      {
         alert("Пожалуйста загрузите скан или фото диагностической карты ТС! Поддерживаемые форматы: bmp, jpeg, jpg, ddf, png. Не более 5mb.");
         return false;
      }
   }
   var Checkbox3 = document.getElementById('Checkbox3');
   if (!(Checkbox3.disabled ||
         Checkbox3.style.display === 'none' ||
         Checkbox3.style.visibility === 'hidden'))
   {
      if (Checkbox3.checked != true)
      {
         alert("Пожалуйста, дайте Ваше согласие на обработку Ваших персональных данных!");
         return false;
      }
   }
   return true;
}
</script>
<script>
function ValidateCarousel1()
{
   var regexp;
   var Editbox12 = document.getElementById('Editbox12');
   if (!(Editbox12.disabled || Editbox12.style.display === 'none' || Editbox12.style.visibility === 'hidden'))
   {
      if (Editbox12.value == "")
      {
         alert("Пожалуйста заполните поле \"Ф.И.О.\"!");
         Editbox12.focus();
         return false;
      }
      if (Editbox12.value.length < 2)
      {
         alert("Пожалуйста заполните поле \"Ф.И.О.\"!");
         Editbox12.focus();
         return false;
      }
      if (Editbox12.value.length > 100)
      {
         alert("Пожалуйста заполните поле \"Ф.И.О.\"!");
         Editbox12.focus();
         return false;
      }
   }
   var Editbox11 = document.getElementById('Editbox11');
   if (!(Editbox11.disabled || Editbox11.style.display === 'none' || Editbox11.style.visibility === 'hidden'))
   {
      if (Editbox11.value == "")
      {
         alert("Пожалуйста заполните поле \"Телефон\"!");
         Editbox11.focus();
         return false;
      }
      if (Editbox11.value.length < 2)
      {
         alert("Пожалуйста заполните поле \"Телефон\"!");
         Editbox11.focus();
         return false;
      }
      if (Editbox11.value.length > 50)
      {
         alert("Пожалуйста заполните поле \"Телефон\"!");
         Editbox11.focus();
         return false;
      }
   }
   var Editbox8 = document.getElementById('Editbox8');
   if (!(Editbox8.disabled || Editbox8.style.display === 'none' || Editbox8.style.visibility === 'hidden'))
   {
      if (Editbox8.value == "")
      {
         alert("Пожалуйста заполните поле \"e-mail адрес\"!");
         Editbox8.focus();
         return false;
      }
      if (Editbox8.value.length < 4)
      {
         alert("Пожалуйста заполните поле \"e-mail адрес\"!");
         Editbox8.focus();
         return false;
      }
      if (Editbox8.value.length > 50)
      {
         alert("Пожалуйста заполните поле \"e-mail адрес\"!");
         Editbox8.focus();
         return false;
      }
   }
   var FileUpload5 = document.getElementById('FileUpload5');
   if (!(FileUpload5.disabled ||
         FileUpload5.style.display === 'none' ||
         FileUpload5.style.visibility === 'hidden'))
   {
      if (FileUpload5.value == "")
      {
         alert("Пожалуйста загрузите скан или фото СТС или ПТС! Поддерживаемые форматы: bmp, jpeg, jpg, ddf, png. Не более 5mb.");
         return false;
      }
      var ext = FileUpload5.value.substr(FileUpload5.value.lastIndexOf('.'));
      if ((ext.toLowerCase() != ".bmp") &&
          (ext.toLowerCase() != ".jpeg") &&
          (ext.toLowerCase() != ".jpg") &&
          (ext.toLowerCase() != ".pdf") &&
          (ext.toLowerCase() != ".png"))
      {
         alert("Пожалуйста загрузите скан или фото СТС или ПТС! Поддерживаемые форматы: bmp, jpeg, jpg, ddf, png. Не более 5mb.");
         return false;
      }
   }
   var Editbox13 = document.getElementById('Editbox13');
   if (!(Editbox13.disabled || Editbox13.style.display === 'none' || Editbox13.style.visibility === 'hidden'))
   {
      if (Editbox13.value.length < 2)
      {
         alert("Пожалуйста заполните поле \"Марка шин\"!");
         Editbox13.focus();
         return false;
      }
      if (Editbox13.value.length > 100)
      {
         alert("Пожалуйста заполните поле \"Марка шин\"!");
         Editbox13.focus();
         return false;
      }
   }
   var FileUpload7 = document.getElementById('FileUpload7');
   if (!(FileUpload7.disabled ||
         FileUpload7.style.display === 'none' ||
         FileUpload7.style.visibility === 'hidden'))
   {
      if (FileUpload7.value == "")
      {
         alert("Пожалуйста загрузите скан или фото диагностической карты ТС! Поддерживаемые форматы: bmp, jpeg, jpg, ddf, png. Не более 5mb.");
         return false;
      }
      var ext = FileUpload7.value.substr(FileUpload7.value.lastIndexOf('.'));
      if ((ext.toLowerCase() != ".bmp") &&
          (ext.toLowerCase() != ".jpeg") &&
          (ext.toLowerCase() != ".jpg") &&
          (ext.toLowerCase() != ".pdf") &&
          (ext.toLowerCase() != ".png"))
      {
         alert("Пожалуйста загрузите скан или фото диагностической карты ТС! Поддерживаемые форматы: bmp, jpeg, jpg, ddf, png. Не более 5mb.");
         return false;
      }
   }
   var FileUpload6 = document.getElementById('FileUpload6');
   if (!(FileUpload6.disabled ||
         FileUpload6.style.display === 'none' ||
         FileUpload6.style.visibility === 'hidden'))
   {
      var ext = FileUpload6.value.substr(FileUpload6.value.lastIndexOf('.'));
      if ((ext.toLowerCase() != ".bmp") &&
          (ext.toLowerCase() != ".jpeg") &&
          (ext.toLowerCase() != ".jpg") &&
          (ext.toLowerCase() != ".pdf") &&
          (ext.toLowerCase() != ".png") &&
          (ext != ""))
      {
         alert("Пожалуйста загрузите скан или фото ВУ всех лиц допущенных к управлению ТС! Поддерживаемые форматы: bmp, jpeg, jpg, ddf, png. Не более 5mb.");
         return false;
      }
   }
   return true;
}
</script>
<script src="js/wwb12.min.js"></script>
<script>
$(document).ready(function()
{
   var Carousel1Opts =
   {
      delay: 500000,
      duration: 500,
      easing: 'swing',
      mode: 'forward',
      direction: '',
      scalemode: 2,
      pagination: false,
      start: 0
   };
   $("#Carousel1").carousel(Carousel1Opts);
   $("#RadioButton1").change(function()
   {
      if ($('#RadioButton1').is(':checked'))
      {
         ShowObject('Combobox7', 1);
         ShowObject('wb_Text13', 1);
      }
   });
   $("#RadioButton1").trigger('change');
   $("#RadioButton2").change(function()
   {
      if ($('#RadioButton2').is(':checked'))
      {
         ShowObject('Combobox7', 0);
         ShowObject('wb_Text22', 0);
      }
   });
   $("#RadioButton2").trigger('change');
   $("#Editbox1, #Combobox1, #Combobox2, #Combobox3, #Combobox4, #Combobox5, #Combobox6, #Combobox7, #RadioButton2, #RadioButton1, #RadioButton4, #RadioButton5").change(function()
   {
      $('#Editbox1').val(($('#Combobox1').val()*$('#Combobox2').val()*$('#Combobox3').val()*$('#Combobox4').val()*$('#Combobox5').val()*$('#Combobox6').val()*$('#Combobox7').val()*$('input[name="Лица, допущенные к управлению"]:checked').val()) .toFixed())
   });
   $("#Editbox1").trigger('change');
   $("#Editbox2, #Combobox1, #Combobox2, #Combobox3, #Combobox4, #Combobox5, #Combobox6, #Combobox7, #RadioButton2, #RadioButton1, #RadioButton4, #RadioButton5").change(function()
   {
      $('#Editbox2').val(($('#Combobox1').val()*$('#Combobox2').val()*$('#Combobox3').val()*$('#Combobox4').val()*$('#Combobox5').val()*$('#Combobox6').val()*$('#Combobox7').val()*$('input[name="Лица, допущенные к управлению"]:checked').val()+1000) .toFixed())
   });
   $("#Editbox2").trigger('change');
   $("#Editbox9, #Combobox1, #Combobox2, #Combobox3, #Combobox4, #Combobox5, #Combobox6, #Combobox7, #RadioButton2, #RadioButton1, #RadioButton4, #RadioButton5").change(function()
   {
      $('#Editbox9').val(($('#Combobox1').val()*$('#Combobox2').val()*$('#Combobox3').val()*$('#Combobox4').val()*$('#Combobox5').val()*$('#Combobox6').val()*$('#Combobox7').val()*$('input[name="Лица, допущенные к управлению"]:checked').val()+1000) .toFixed())
   });
   $("#Editbox9").trigger('change');
   $("#Editbox10, #Combobox1, #Combobox2, #Combobox3, #Combobox4, #Combobox5, #Combobox6, #Combobox7, #RadioButton2, #RadioButton1, #RadioButton4, #RadioButton5").change(function()
   {
      $('#Editbox10').val(($('#Combobox1').val()*$('#Combobox2').val()*$('#Combobox3').val()*$('#Combobox4').val()*$('#Combobox5').val()*$('#Combobox6').val()*$('#Combobox7').val()*$('input[name="Лица, допущенные к управлению"]:checked').val()+1700) .toFixed())
   });
   $("#Editbox10").trigger('change');
   $("#RadioButton3").change(function()
   {
      if ($('#RadioButton3').is(':checked'))
      {
         ShowObject('wb_Shape54', 1);
         $('#Carousel1').carousel('goto,5');;
      }
      if (!$('#RadioButton3').is(':checked'))
      {
         ShowObject('wb_Shape54', 0);
      }
   });
   $("#RadioButton3").trigger('change');
   var Carousel2Opts =
   {
      delay: 500000,
      duration: 500,
      easing: 'swing',
      mode: 'forward',
      direction: '',
      scalemode: 2,
      pagination: false,
      start: 0
   };
   $("#Carousel2").carousel(Carousel2Opts);
   $("#RadioButton4").change(function()
   {
      if ($('#RadioButton4').is(':checked'))
      {
         ShowObject('Combobox16', 1);
         ShowObject('wb_Text99', 1);
      }
   });
   $("#RadioButton4").trigger('change');
   $("#RadioButton5").change(function()
   {
      if ($('#RadioButton5').is(':checked'))
      {
         ShowObject('Combobox16', 0);
         ShowObject('wb_Text99', 0);
      }
   });
   $("#RadioButton5").trigger('change');
   $("#Editbox17, #Combobox10, #Combobox11, #Combobox12, #Combobox13, #Combobox14, #Combobox16, #Combobox17, #RadioButton5, #RadioButton1, #RadioButton2, #RadioButton4").change(function()
   {
      $('#Editbox17').val(($('#Combobox10').val()*$('#Combobox11').val()*$('#Combobox12').val()*$('#Combobox13').val()*$('#Combobox14').val()*$('#Combobox16').val()*$('#Combobox17').val()*$('input[name="Лица, допущенные к управлению"]:checked').val()+1000) .toFixed())
   });
   $("#Editbox17").trigger('change');
   $("#Editbox18, #Combobox10, #Combobox11, #Combobox12, #Combobox13, #Combobox14, #Combobox16, #Combobox17, #RadioButton5, #RadioButton1, #RadioButton2, #RadioButton4").change(function()
   {
      $('#Editbox18').val(($('#Combobox10').val()*$('#Combobox11').val()*$('#Combobox12').val()*$('#Combobox13').val()*$('#Combobox14').val()*$('#Combobox16').val()*$('#Combobox17').val()*$('input[name="Лица, допущенные к управлению"]:checked').val()+1700) .toFixed())
   });
   $("#Editbox18").trigger('change');
   $("#RadioButton6").change(function()
   {
      if ($('#RadioButton6').is(':checked'))
      {
         ShowObject('wb_Shape64', 1);
         $('#Carousel2').carousel('goto,6');;
      }
      if (!$('#RadioButton6').is(':checked'))
      {
         ShowObject('wb_Shape64', 0);
      }
   });
   $("#RadioButton6").trigger('change');
   $("#Editbox14").validate(
   {
      required: false,
      type: 'text',
      length_min: '2',
      length_max: '100',
      color_text: '#000000',
      color_hint: '#00FF00',
      color_error: '#FF0000',
      color_border: '#808080',
      nohint: false,
      font_family: 'Arial',
      font_size: '13px',
      position: 'topleft',
      offsetx: 0,
      offsety: 0,
      effect: 'none',
      error_text: 'Пожалуйста заполните поле \"Пробег\"!'
   });
   $("#RollOver3 a").hover(function(e)
   {
      $(this).children("span").stop().fadeTo(300, 0);
   }, function()
   {
      $(this).children("span").stop().fadeTo(300, 1);
   });
   $("#RollOver4 a").hover(function(e)
   {
      $(this).children("span").stop().fadeTo(300, 0);
   }, function()
   {
      $(this).children("span").stop().fadeTo(300, 1);
   });
   $("#Editbox16, #Combobox10, #Combobox11, #Combobox12, #Combobox13, #Combobox14, #Combobox16, #Combobox17, #RadioButton5, #RadioButton1, #RadioButton2, #RadioButton4").change(function()
   {
      $('#Editbox16').val(($('#Combobox10').val()*$('#Combobox11').val()*$('#Combobox12').val()*$('#Combobox13').val()*$('#Combobox14').val()*$('#Combobox16').val()*$('#Combobox17').val()*$('input[name="Лица, допущенные к управлению"]:checked').val()) .toFixed())
   });
   $("#Editbox16").trigger('change');
});
</script>
</head>
<body>
<div id="container">
<div id="wb_Form1">
<form name="forma1" method="post" action="<?php echo basename(__FILE__); ?>" enctype="multipart/form-data" accept-charset="UTF-8" id="Form1">
<input type="hidden" name="formid" value="form1">
<div id="wb_Carousel1">
<div id="Carousel1">
<div class="frame">
<div id="wb_Text12">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:24px;">Скидка за безаварийную езду:</span></div>
<select name="Мощность двигателя (л.с.)" size="1" id="Combobox4">
<option selected value="0.6">  до 50 включительно (Км = 0,6)</option>
<option value="1">  свыше 50 до 70 включительно (Км = 1)</option>
<option value="1.1">  свыше 70 до 100 включительно (Км = 1,1)</option>
<option value="1.2">  свыше 100 до 120 включительно (Км = 1,2)</option>
<option value="1.4">  свыше 120 до 150 включительно (Км = 1,4)</option>
<option value="1.6">  свыше 150 (КМ = 1,6)</option>
</select>
<div id="wb_Text9">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:24px;">Мощность двигателя (л.с.):</span></div>
<div id="wb_Text8">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:24px;">Тип транспортного средства:</span></div>
<div id="wb_Text11">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:24px;">Место регистрации собственника:</span></div>
<select name="Скидка за безаварийную езду" size="1" id="Combobox5">
<option selected value="1">  Страхование впервые (класс 3, кбм 1)</option>
<option value="0.95">  1 год без аварий (класс 4, кбм 0,95)</option>
<option value="0.9">  2 года без аварий (класс 5, кбм 0, 9)</option>
<option value="0.85">  3 года без аварий (класс 6, кбм 0, 85)</option>
<option value="0.8">  4 года без аварий (класс 7, кбм 0, 8)</option>
<option value="0.75">  5 лет без аварий (класс 8, кбм 0, 75)</option>
<option value="0.7">  6 лет без аварий (класс 9, кбм 0, 7)</option>
<option value="0.65">  7 лет без аварий (класс 10, кбм 0, 65)</option>
<option value="0.6">  8 лет без аварий (класс 11, кбм 0, 6)</option>
<option value="0.55">  9 лет без аварий (класс 12, кбм 0, 55)</option>
<option value="0.5">  10 лет без аварий (класс 13, кбм 0, 5)</option>
<option value="2.45">  (класс М, кбм 2,45)</option>
<option value="2.3">  (класс 0, кбм 2,3)</option>
<option value="1.55">  (класс 1, кбм 1,55)</option>
<option value="1.4">  (класс 2, кбм 1,4)</option>
</select>
<select name="Тип транспортного средства" size="1" id="Combobox3">
<option selected value="4118">  Легковой автомобиль</option>
<option value="4211">  Грузовой автомобиль</option>
<option value="6166">  Автобус</option>
<option value="1579">  Мотоцикл, мотороллер</option>
<option value="2101">  Трамвай</option>
<option value="3370">  Троллейбус</option>
<option value="1579">  Трактор, самоходная дорожно - строительная техника и прочее</option>
</select>
<select name="Место регистрации собственника" size="1" id="Combobox2">
<option value="1.7">  Алтайский край (22)</option>
<option value="1">  Амурская область (28)</option>
<option value="1.7">  Архангельская область (29)</option>
<option value="1.4">  Астраханская область (30)</option>
<option value="1.3">  Белгородская область (31)</option>
<option value="1.5">  Брянская область (32)</option>
<option value="1.6">  Владимирская область (33)</option>
<option value="1.3">  Волгоградская область (34)</option>
<option value="1.7">  Вологодская область (35)</option>
<option value="1.5">  Воронежская область (36)</option>
<option value="2">  Москва (77, 177, 99, 199)</option>
<option value="1.7">  Московская область (50)</option>
<option value="1">  Еврейская автономная область (79)</option>
<option value="1.8">  Забайкальский край (75)</option>
<option value="1.8">  Ивановская область (37)</option>
<option value="1.7">  Иркутская область (38)</option>
<option value="1">  Кабардино-Балкарская Республика (07)</option>
<option value="1.1">  Калининградская область  (39)</option>
<option value="1.2">  Калужская область (40)</option>
<option value="1.1">  Камчатский край (41)</option>
<option value="1.3">  Карачаево-Черкесская Республика (09)</option>
<option value="1.9">  Кемеровская область (42)</option>
<option value="1.4">  Кировская область (43)</option>
<option value="1.3">  Костромская область (44)</option>
<option value="1.8">  Краснодарский край (23)</option>
<option value="1.8">  Красноярский край (24)</option>
<option value="1.3">  Курганская область (45)</option>
<option value="1.2">  Курская область (46)</option>
<option value="1.6">  Ленинградская область (47)</option>
<option value="1.5">  Липецкая область (48)</option>
<option value="1.2">  Магаданская область (49)</option>
<option value="1.7">  Московская область (50)</option>
<option value="1.1">  Мурманская область (51)</option>
<option value="0.8">  Ненецкий автономный округ (83)</option>
<option value="1.8">  Нижегородская область (52)</option>
<option value="1">  Новгородская область (53)</option>
<option value="1.7">  Новосибирская область (54)</option>
<option value="1.6">  Омская область (55)</option>
<option value="1.7">  Оренбургская область (56)</option>
<option value="1">  Орловская область (57)</option>
<option value="1.4">  Пензенская область (58)</option>
<option value="2">  Пермский край (59)</option>
<option value="1.4">  Приморский край (25)</option>
<option value="1">  Псковская область (60)</option>
<option value="1.1">  Республика Адыгея (Адыгея) (01)</option>
<option value="1.3">  Республика Алтай (04)</option>
<option value="1.8">  Республика Башкортостан (02)</option>
<option value="1.3">  Республика Бурятия (03)</option>
<option value="1">  Республика Дагестан (05)</option>
<option value="1.2">  Республика Ингушетия (06)</option>
<option value="1.3">  Республика Калмыкия (08)</option>
<option value="1.3">  Республика Карелия (10)</option>
<option value="1.6">  Республика Коми (11)</option>
<option value="1.2">  Республика Крым (91)</option>
<option value="1">  Республика Марий Эл (12)</option>
<option value="1">  Республика Мордовия (13)</option>
<option value="1.3">  Республика Саха (Якутия) (14)</option>
<option value="1">  Республика Северная Осетия - Алания (15)</option>
<option value="2">  Республика Татарстан (Татарстан) (16)</option>
<option value="1">  Республика Тува (17)</option>
<option value="1">  Республика Хакасия (19)</option>
<option value="1.8">  Ростовская область (61)</option>
<option value="1.4">  Рязанская область (62)</option>
<option value="1.6">  Самарская область (63)</option>
<option value="1.8">  Санкт-Петербург (78, 178)</option>
<option value="1.6">  Саратовская область (64)</option>
<option value="1.5">  Сахалинская область (65)</option>
<option value="1.8">  Свердловская область (66)</option>
<option value="1">  Смоленская область (67)</option>
<option value="1">  Ставропольский край (26)</option>
<option selected value="1">  Тамбовская область (68)</option>
<option value="1.5">  Тверская область (69)</option>
<option value="1.6">  Томская область (70)</option>
<option value="1.5">  Тульская область (71)</option>
<option value="2">  Тюменская область (72)</option>
<option value="1.6">  Удмуртская Республика (18)</option>
<option value="1.4">  Ульяновская область (73)</option>
<option value="1.7">  Хабаровский край (27)</option>
<option value="2">  Ханты-Мансийский автономный округ - Югра (86)</option>
<option value="1.7">  Челябинская область (74)</option>
<option value="0.7">  Чеченская Республика (20)</option>
<option value="1.6">  Чувашская Республика - Чувашия (21)</option>
<option value="0.7">  Чукотский автономный округ (87)</option>
<option value="1">  Ямало-Ненецкий автономный округ (89)</option>
<option value="1.5">  Ярославская область (76)</option>
<option value="1.8">Иностранный гражданин (-)</option>
</select>
<select name="Владелец" size="1" id="Combobox1" title="$&#1042;&#1083;&#1072;&#1076;&#1077;&#1083;&#1077;&#1094;">
<option selected value="1">  Физическое лицо</option>
<option value="0.75">  Юридическое лицо</option>
</select>
<div id="wb_Text7">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:24px;">Владелец:</span></div>
<div id="wb_Shape9">
<img src="images/img0095.png" id="Shape9" alt=""></div>
<div id="wb_Text15">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:24px;">Прицеп</span></div>
<div id="wb_Image1">
<img src="images/auto-stic.png" id="Image1" alt=""></div>
<div id="wb_Shape16">
<div id="Shape16"></div></div>
<div id="wb_Text65">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:43px;"><strong>2</strong></span></div>
<div id="wb_Line18">
<img src="images/img0100.png" id="Line18" alt=""></div>
<div id="wb_Line20">
<img src="images/img0107.png" id="Line20" alt=""></div>
<div id="wb_Shape51">
<a href="#" onclick="$('#Carousel1').carousel('goto,2');PlayAudio('MediaPlayer1');return false;"><div id="Shape51"><div id="Shape51_text"><span style="color:#F15A0B;font-family:'Geometric 706';font-size:29px;"><strong>Поехали</strong></span></div></div></a></div>
<div id="wb_Checkbox1">
<input type="checkbox" id="Checkbox1" name="Прицеп" value="on"><label for="Checkbox1"></label></div>
<div id="wb_Shape10">
<div id="Shape10"></div></div>
<div id="wb_Line2">
<img src="images/img0119.png" id="Line2" alt=""></div>
<div id="wb_Shape2">
<div id="Shape2"></div></div>
<div id="wb_Text3">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:43px;"><strong>4</strong></span></div>
<div id="wb_Line3">
<img src="images/img0121.png" id="Line3" alt=""></div>
<div id="wb_Shape4">
<div id="Shape4"></div></div>
<div id="wb_Text56">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:43px;"><strong>5</strong></span></div>
<div id="wb_Image5">
<a href="#" onclick="$('#Carousel1').carousel('goto,2');return false;"><img src="images/doulbe_arrow_right.png" id="Image5" alt=""></a></div>
<div id="wb_Text2">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:43px;"><strong>3</strong></span></div>
</div>
<div class="frame">
<div id="wb_Text10">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:24px;">Срок страхования (период использования автомоблиля):</span></div>
<div id="wb_Image9">
<a href="#" onclick="$('#Carousel1').carousel('goto,1');return false;"><img src="images/left.png" id="Image9" alt=""></a></div>
<div id="wb_Shape33">
<div id="Shape33"></div></div>
<div id="wb_Text4">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:43px;"><strong>1</strong></span></div>
<div id="wb_Line19">
<img src="images/img0124.png" id="Line19" alt=""></div>
<div id="wb_Image8">
<img src="images/auto-stic.png" id="Image8" alt=""></div>
<div id="wb_Line1">
<img src="images/img0125.png" id="Line1" alt=""></div>
<div id="wb_Shape5">
<div id="Shape5"></div></div>
<div id="wb_Text5">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:43px;"><strong>3</strong></span></div>
<div id="wb_Line4">
<img src="images/img0127.png" id="Line4" alt=""></div>
<div id="wb_Shape6">
<div id="Shape6"></div></div>
<div id="wb_Text6">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:43px;"><strong>4</strong></span></div>
<div id="wb_Line5">
<img src="images/img0199.png" id="Line5" alt=""></div>
<div id="wb_Shape34">
<div id="Shape34"></div></div>
<div id="wb_Text57">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:43px;"><strong>5</strong></span></div>
<div id="wb_Text14">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:24px;">Лица, допущенные <br>к управлению:</span></div>
<div id="wb_Text24">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:24px;">С ограниченным списком</span></div>
<div id="wb_Text16">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:24px;">Без <br>ограничений</span></div>
<div id="wb_RadioButton1">
<input type="radio" id="RadioButton1" name="Лица, допущенные к управлению" value="1" checked><label for="RadioButton1"></label></div>
<div id="wb_RadioButton2">
<input type="radio" id="RadioButton2" name="Лица, допущенные к управлению" value="1.3"><label for="RadioButton2"></label></div>
<div id="wb_Text22">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:24px;">Возраст и водительский стаж:</span></div>
<select name="Возраст и водительский стаж" size="1" id="Combobox7" title="$&#1042;&#1086;&#1079;&#1088;&#1072;&#1089;&#1090; &#1080; &#1074;&#1086;&#1076;&#1080;&#1090;&#1077;&#1083;&#1100;&#1089;&#1082;&#1080;&#1081; &#1089;&#1090;&#1072;&#1078;">
<option value="1">  старше 22 лет, стаж свыше 3-х лет (Квс =1)</option>
<option value="1.7">  старше 22 лет, стаж до 3-х лет включительно (Квс =1,7)</option>
<option value="1.6">  до 22 лет включительно, стаж свыше 3-х лет (Квс =1,6)</option>
<option value="1.8">  до 22 лет включительно, стаж до 3-х лет включительно (Квс =1,8)</option>
</select>
<select name="Срок страхования (период использования автомоблиля)" size="1" id="Combobox6">
<option selected value="1">  1 Год</option>
<option value="0.95">  9 месяцев (Кс = 0,95)</option>
<option value="0.9">  8 месяцев (Кс = 0,9)</option>
<option value="0.8">  7 месяцев (Кс = 0,8)</option>
<option value="0.7">  6 месяцев (Кс = 0,7)</option>
<option value="0.65">  5 месяцев (Кс = 0,65)</option>
<option value="0.6">  4 месяца (Кс = 0,6)</option>
<option value="0.5">  3 месяца (Кс = 0,5)</option>
<option value="0.4">  2 месяца (Кс = 0,4)</option>
<option value="0.3">  от 16 дней до 1 месяца (Кс = 0,3)</option>
<option value="0.2">  от 5 дней до 15 дней (Кс = 0,2)</option>
</select>
<div id="wb_Image2">
<a href="#" onclick="$('#Carousel1').carousel('goto,3');return false;"><img src="images/doulbe_arrow_right.png" id="Image2" alt=""></a></div>
<div id="wb_Text13">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:24px;">Стоимость полиса по <br>предварительному расчёту составляет:</span></div>
<input type="text" id="Editbox1" name="Стоимость полиса" value="" autocomplete="off" spellcheck="false" placeholder="&#1048;&#1058;&#1054;&#1043;">
<div id="wb_Text66">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:27px;"><strong>рублей</strong></span></div>
<div id="wb_Text17">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:24px;">Итого с оформлением&nbsp; полиса <br>ОСАГО (+ от 1000 рублей за услуги):</span></div>
<input type="text" id="Editbox2" name="Стоимость оформления полиса с услугой" value="" autocomplete="off" spellcheck="false" placeholder="&#1048;&#1058;&#1054;&#1043;">
<div id="wb_Text18">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:27px;"><strong>рублей</strong></span></div>
<div id="wb_Shape52">
<a href="#" onclick="$('#Carousel1').carousel('goto,3');PlayAudio('MediaPlayer2');return false;"><div id="Shape52"><div id="Shape52_text"><span style="color:#F15A0B;font-family:'Geometric 706';font-size:29px;"><strong>Оформить полис</strong></span></div></div></a></div>
</div>
<div class="frame">
<div id="wb_Text21">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:24px;">Ваше имя (полностью):</span></div>
<input type="text" id="Editbox5" name="E-mail адрес" value="" spellcheck="false" placeholder="  kosmos@mail.ru">
<div id="wb_Text27">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:21px;"><u>Скан или фото паспорта РФ собственника ТС:</u></span></div>
<div id="wb_Text25">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:24px;">Ваш e-mail адрес:</span></div>
<div id="wb_Text23">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:24px;">Ваш телефон:</span></div>
<input type="text" id="Editbox4" name="Телефон" value="" spellcheck="false" placeholder="  +7(&#8226;&#8226;&#8226;) &#8226;&#8226;&#8226; &#8226;&#8226; &#8226;&#8226;">
<input type="text" id="Editbox3" name="ФИО" value="" spellcheck="false" placeholder="  &#1060;.&#1048;.&#1054;.">
<div id="wb_Text26">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:27px;"><strong>Необходимо загрузить документы для оформления <br>полиса ОСАГО</strong></span></div>
<div id="wb_Image3">
<img src="images/auto-stic.png" id="Image3" alt=""></div>
<div id="wb_Shape53">
<a href="#" onclick="$('#Carousel1').carousel('goto,4');PlayAudio('MediaPlayer2');return false;"><div id="Shape53"><div id="Shape53_text"><span style="color:#F15A0B;font-family:'Geometric 706';font-size:29px;"><strong>Далее</strong></span></div></div></a></div>
<div id="wb_Shape19">
<div id="Shape19"></div></div>
<div id="wb_Line6">
<img src="images/img0130.png" id="Line6" alt=""></div>
<div id="wb_Shape40">
<div id="Shape40"></div></div>
<div id="wb_Line26">
<img src="images/img0132.png" id="Line26" alt=""></div>
<div id="wb_Text19">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:43px;"><strong>1</strong></span></div>
<div id="wb_Text20">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:43px;"><strong>2</strong></span></div>
<div id="wb_Line7">
<img src="images/img0133.png" id="Line7" alt=""></div>
<div id="wb_Shape18">
<div id="Shape18"></div></div>
<div id="wb_Line22">
<img src="images/img0136.png" id="Line22" alt=""></div>
<div id="wb_Shape20">
<div id="Shape20"></div></div>
<div id="wb_Text45">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:43px;"><strong>4</strong></span></div>
<div id="wb_Text46">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:43px;"><strong>5</strong></span></div>
<div id="wb_Image7">
<a href="#" onclick="$('#Carousel1').carousel('goto,2');return false;"><img src="images/left.png" id="Image7" alt=""></a></div>
<div id="wb_Image11">
<a href="#" onclick="$('#Carousel1').carousel('goto,4');return false;"><img src="images/doulbe_arrow_right.png" id="Image11" alt=""></a></div>
<div id="wb_Shape36">
<div id="Shape36"></div></div>
<div id="wb_Text28">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:21px;line-height:25px;"><strong>1-я страница паспорта и страница с регистрацией</strong></span></div>
<input type="file" accept=".bmp,.jpeg,.jpg,.pdf,.png" name="Паспорт собственника ТС 1-я страница" id="FileUpload1" required multiple>
</div>
<div class="frame">
<div id="wb_Shape12">
<div id="Shape12"></div></div>
<div id="wb_Text31">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:21px;line-height:27px;"><strong>СТС или ПТС</strong></span></div>
<input type="file" accept=".bmp,.jpeg,.jpg,.pdf,.png" name="СТС или ПТС" id="FileUpload2">
<div id="wb_Text32">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:21px;line-height:28px;"><u>Скан или фото Водительского <br>удостоверения всех лиц, допущенных к управлению ТС:</u></span></div>
<div id="wb_Text33">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:21px;line-height:25px;"><strong>ВУ всех лиц допущенных к управлению ТС</strong></span></div>
<div id="wb_Shape13">
<div id="Shape13"></div></div>
<div id="wb_Text30">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:21px;line-height:28px;"><u>Скан или фото свидетельства о регистрации транспортного <br>средства (СТС) или паспорт транспортного средства (ПТС):</u></span></div>
<div id="wb_Shape28">
<a href="#" onclick="$('#Carousel1').carousel('goto,6');PlayAudio('MediaPlayer2');return false;"><div id="Shape28"><div id="Shape28_text"><span style="color:#F15A0B;font-family:'Geometric 706';font-size:29px;"><strong>Далее</strong></span></div></div></a></div>
<input type="file" accept=".bmp,.jpeg,.jpg,.pdf,.png" name="Водительские удостоверения всех лиц, допущенных к управлению ТС" id="FileUpload3" multiple>
<div id="wb_Image13">
<a href="#" onclick="$('#Carousel1').carousel('goto,3');return false;"><img src="images/left.png" id="Image13" alt=""></a></div>
<div id="wb_Shape21">
<div id="Shape21"></div></div>
<div id="wb_Line8">
<img src="images/img0139.png" id="Line8" alt=""></div>
<div id="wb_Shape35">
<div id="Shape35"></div></div>
<div id="wb_Line21">
<img src="images/img0141.png" id="Line21" alt=""></div>
<div id="wb_Line27">
<img src="images/img0201.png" id="Line27" alt=""></div>
<div id="wb_Text29">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:43px;"><strong>1</strong></span></div>
<div id="wb_Text47">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:43px;"><strong>3</strong></span></div>
<div id="wb_Text48">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:43px;"><strong>2</strong></span></div>
<div id="wb_Shape22">
<div id="Shape22"></div></div>
<div id="wb_Image10">
<img src="images/auto-stic.png" id="Image10" alt=""></div>
<div id="wb_Line9">
<img src="images/img0203.png" id="Line9" alt=""></div>
<div id="wb_Shape23">
<div id="Shape23"></div></div>
<div id="wb_Text49">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:43px;"><strong>5</strong></span></div>
<div id="wb_Shape54">
<a href="#" onclick="$('#Carousel1').carousel('goto,5');PlayAudio('MediaPlayer2');return false;"><div id="Shape54"><div id="Shape54_text"><span style="color:#F15A0B;font-family:'Geometric 706';font-size:29px;"><strong>Далее</strong></span></div></div></a></div>
<div id="wb_Text58">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:21px;line-height:28px;"><u>Если у Вас уже есть диагностическая карта, просто прикрепите её:</u></span></div>
<div id="wb_Text34">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:21px;line-height:27px;"><strong>Диагностическая карта ТС</strong></span></div>
<div id="wb_Shape24">
<div id="Shape24"></div></div>
<div id="wb_Text35">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:21px;">Если у Вас отсутствует диагностическая карта и <br>Вам нужно её оформить, поставьте отметку здесь:</span></div>
<div id="wb_Image14">
<a href="#" onclick="$('#Carousel1').carousel('goto,5');return false;"><img src="images/doulbe_arrow_right.png" id="Image14" alt=""></a></div>
<input type="file" accept=".bmp,.jpeg,.jpg,.pdf,.png" name="Диагностическая карта ТС" id="FileUpload4">
<div id="wb_RadioButton3">
<input type="radio" id="RadioButton3" name="Диагностическая карта" value="1.2"><label for="RadioButton3"></label></div>
</div>
<div class="frame">
<div id="wb_Text39">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:27px;"><strong>Для оформления диагностической карты заполните поля ниже</strong></span><span style="color:#FFFFFF;font-family:'Geometric 706';font-size:24px;"><strong> </strong></span></div>
<div id="wb_Text37">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:24px;">Марка шин Вашего ТС:</span></div>
<div id="wb_Text40">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:24px;">Пробег ТС:</span></div>
<div id="wb_Text41">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:24px;">Тип двигателя:</span></div>
<input type="text" id="Editbox6" name="Марка шин ТС" value="" spellcheck="false" placeholder="  Pirelli Ice Zerro 195/65/15">
<input type="text" id="Editbox7" name="Пробег ТС" value="" spellcheck="false" placeholder="  35000 &#1082;&#1084;">
<select name="Тип двигателя" size="1" id="Combobox8">
<option selected>  Бензин</option>
<option>  Дизельное топливо</option>
<option>  Сжатый газ</option>
<option>  Сжиженный газ</option>
<option>  Без топлива</option>
</select>
<div id="wb_Shape55">
<a href="#" onclick="$('#Carousel1').carousel('goto,6');PlayAudio('MediaPlayer2');return false;"><div id="Shape55"><div id="Shape55_text"><span style="color:#F15A0B;font-family:'Geometric 706';font-size:29px;"><strong>Далее</strong></span></div></div></a></div>
<div id="wb_Image15">
<a href="#" onclick="$('#Carousel1').carousel('goto,4');return false;"><img src="images/left.png" id="Image15" alt=""></a></div>
<div id="wb_Text52">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:24px;">Диагностическая карта автотранспортного средства<br>(заменяет талон технического осмотра в соответствии с ФЗ <br>№ 130 от 28.07.2012), если срок эксплуатации автомобиля больше 2,5 лет.</span></div>
<div id="wb_Image4">
<a href="#" onclick="$('#Carousel1').carousel('goto,6');return false;"><img src="images/doulbe_arrow_right.png" id="Image4" alt=""></a></div>
<div id="wb_Shape14">
<div id="Shape14"></div></div>
<div id="wb_Text36">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:43px;"><strong>1</strong></span></div>
<div id="wb_Line10">
<img src="images/img0143.png" id="Line10" alt=""></div>
<div id="wb_Shape25">
<div id="Shape25"></div></div>
<div id="wb_Text59">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:43px;"><strong>2</strong></span></div>
<div id="wb_Line12">
<img src="images/img0145.png" id="Line12" alt=""></div>
<div id="wb_Shape26">
<div id="Shape26"></div></div>
<div id="wb_Line23">
<img src="images/img0206.png" id="Line23" alt=""></div>
<div id="wb_Text67">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:43px;"><strong>3</strong></span></div>
<div id="wb_Image16">
<img src="images/auto-stic.png" id="Image16" alt=""></div>
<div id="wb_Line11">
<img src="images/img0146.png" id="Line11" alt=""></div>
<div id="wb_Shape27">
<div id="Shape27"></div></div>
<div id="wb_Text38">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:43px;"><strong>5</strong></span></div>
</div>
<div class="frame">
<div id="wb_Text44">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:24px;">Оформляя заявку на покупку страхового полиса, <br>Вы даёте согласие на обработку Ваших персональных:</span></div>
<div id="wb_Shape17">
<img src="images/img0108.png" id="Shape17" alt=""></div>
<div id="wb_Text42">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:24px;">Стоимость&nbsp; полиса ОСАГО <br>+ (1000 рублей за услуги) <br>по предварительному расчёту составит:</span></div>
<div id="wb_Image17">
<a href="#" onclick="$('#Carousel1').carousel('goto,5');return false;"><img src="images/left.png" id="Image17" alt=""></a></div>
<div id="wb_Text61">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:24px;">Стоимость&nbsp; полиса ОСАГО с оформлением диагностической карты + (1000 рублей за услуги) <br>по предварительному расчёту составит:</span></div>
<input type="submit" id="Button2" name="" value="Отправить заявку">
<div id="wb_Shape11">
<div id="Shape11"></div></div>
<div id="wb_Line13">
<img src="images/img0193.png" id="Line13" alt=""></div>
<div id="wb_Shape37">
<div id="Shape37"></div></div>
<div id="wb_Line14">
<img src="images/img0195.png" id="Line14" alt=""></div>
<div id="wb_Line15">
<img src="images/img0196.png" id="Line15" alt=""></div>
<div id="wb_Shape41">
<div id="Shape41"></div></div>
<div id="wb_Line28">
<img src="images/img0207.png" id="Line28" alt=""></div>
<div id="wb_Shape30">
<div id="Shape30"></div></div>
<div id="wb_Image12">
<img src="images/auto-stic.png" id="Image12" alt=""></div>
<div id="wb_Text60">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:43px;"><strong>4</strong></span></div>
<div id="wb_Text51">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:43px;"><strong>3</strong></span></div>
<div id="wb_Text50">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:43px;"><strong>2</strong></span></div>
<div id="wb_Text68">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:43px;"><strong>1</strong></span></div>
<input type="text" id="Editbox9" name="Стоимость  полиса ОСАГО плюс 1000 руб. за услуги" value="" autocomplete="off" spellcheck="false" placeholder="&#1048;&#1058;&#1054;&#1043;">
<div id="wb_Text53">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:27px;"><strong>рублей</strong></span></div>
<input type="text" id="Editbox10" name="Стоимость  полиса ОСАГО с оформлением диагностической карты плюс 1000 руб. за услуги" value="" autocomplete="off" spellcheck="false" placeholder="&#1048;&#1058;&#1054;&#1043;">
<div id="wb_Text43">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:27px;"><strong>рублей</strong></span></div>
<div id="wb_Text54">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:24px;">ВНИМАНИЕ! Итоговая стоимость полиса может незначительно отличаться от расчитанной стоимости&nbsp; на сайте т.к. тарифы в разных страховых компаниях отличаются!</span></div>
<div id="wb_Text55">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:24px;">Выберете способ получения полиса:</span></div>
<select name="Cпособ получения полиса" size="1" id="Combobox9">
<option selected>  На электронную почту</option>
<option>  Самовывоз</option>
</select>
<div id="wb_Checkbox3">
<input type="checkbox" id="Checkbox3" name="Согласие на обработку персональных данных" value="Да"><label for="Checkbox3"></label></div>
</div>
</div>
</div>
</form>
</div>
<div id="wb_Shape7">
<div id="Shape7"><div id="Shape7_text"><span style="color:#000000;font-family:'Geometric 706';font-size:32px;">ОСАГО</span></div></div></div>
<div id="wb_Shape3">
<a href="http://"><div id="Shape3"><div id="Shape3_text"><span style="color:#FFFFFF;font-family:'Geometric 706';font-size:32px;">КАСКО</span></div></div></a></div>
<div id="Layer1">
<div id="wb_Text1">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:48px;"><strong>Калькулятор ОСАГО</strong></span></div>
<div id="RollOver1">
<a href="./index.html">
<div class="image_container">
<div class="front"><img alt="" src="images/close.png"></div>
<div class="back"><img alt="" src="images/close.png"></div>
</div>
</a>
</div>
</div>
<div id="wb_MediaPlayer1">
<audio src="1.mp3" id="MediaPlayer1">
</audio>
</div>
<div id="wb_MediaPlayer2">
<audio src="2.mp3" id="MediaPlayer2">
</audio>
</div>
<div id="wb_Form2">
<form name="forma2" method="post" action="<?php echo basename(__FILE__); ?>" enctype="multipart/form-data" accept-charset="UTF-8" id="Form2">
<input type="hidden" name="formid" value="form2">
<div id="wb_Carousel2">
<div id="Carousel2">
<div class="frame">
<select name="Мощность двигателя (л.с.)" size="1" id="Combobox10">
<option selected value="0.6">  до 50 включительно (Км = 0,6)</option>
<option value="1">  свыше 50 до 70 включительно (Км = 1)</option>
<option value="1.1">  свыше 70 до 100 включительно (Км = 1,1)</option>
<option value="1.2">  свыше 100 до 120 включительно (Км = 1,2)</option>
<option value="1.4">  свыше 120 до 150 включительно (Км = 1,4)</option>
<option value="1.6">  свыше 150 (КМ = 1,6)</option>
</select>
<div id="wb_Text63">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:19px;">Мощность двигателя (л.с.):</span></div>
<div id="wb_Text64">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:19px;">Тип транспортного средства:</span></div>
<select name="Тип транспортного средства" size="1" id="Combobox12">
<option selected value="4118">  Легковой автомобиль</option>
<option value="4211">  Грузовой автомобиль</option>
<option value="6166">  Автобус</option>
<option value="1579">  Мотоцикл, мотороллер</option>
<option value="2101">  Трамвай</option>
<option value="3370">  Троллейбус</option>
<option value="1579">  Трактор, самоходная дорожно - строительная техника и прочее</option>
</select>
<select name="Владелец" size="1" id="Combobox14" autofocus title="$&#1042;&#1083;&#1072;&#1076;&#1077;&#1083;&#1077;&#1094;">
<option selected value="1">  Физическое лицо</option>
<option value="0.75">  Юридическое лицо</option>
</select>
<div id="wb_Shape39">
<a href="#" onclick="$('#Carousel2').carousel('goto,2');PlayAudio('MediaPlayer1');return false;"><div id="Shape39"><div id="Shape39_text"><span style="color:#F15A0B;font-family:'Geometric 706';font-size:24px;"><strong>Далее</strong></span></div></div></a></div>
<div id="wb_Image29">
<a href="#" onclick="$('#Carousel2').carousel('goto,2');return false;"><img src="images/doulbe_arrow_right.png" id="Image29" alt=""></a></div>
<div id="wb_Text70">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:19px;">Владелец:</span></div>
<div id="wb_Text69">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:19px;line-height:16px;">Место <br>регистрации собственника:</span></div>
<select name="Место регистрации собственника" size="1" id="Combobox13">
<option value="1.7">  Алтайский край (22)</option>
<option value="1">  Амурская область (28)</option>
<option value="1.7">  Архангельская область (29)</option>
<option value="1.4">  Астраханская область (30)</option>
<option value="1.3">  Белгородская область (31)</option>
<option value="1.5">  Брянская область (32)</option>
<option value="1.6">  Владимирская область (33)</option>
<option value="1.3">  Волгоградская область (34)</option>
<option value="1.7">  Вологодская область (35)</option>
<option value="1.5">  Воронежская область (36)</option>
<option value="2">  Москва (77, 177, 99, 199)</option>
<option value="1.7">  Московская область (50)</option>
<option value="1">  Еврейская автономная область (79)</option>
<option value="1.8">  Забайкальский край (75)</option>
<option value="1.8">  Ивановская область (37)</option>
<option value="1.7">  Иркутская область (38)</option>
<option value="1">  Кабардино-Балкарская Республика (07)</option>
<option value="1.1">  Калининградская область  (39)</option>
<option value="1.2">  Калужская область (40)</option>
<option value="1.1">  Камчатский край (41)</option>
<option value="1.3">  Карачаево-Черкесская Республика (09)</option>
<option value="1.9">  Кемеровская область (42)</option>
<option value="1.4">  Кировская область (43)</option>
<option value="1.3">  Костромская область (44)</option>
<option value="1.8">  Краснодарский край (23)</option>
<option value="1.8">  Красноярский край (24)</option>
<option value="1.3">  Курганская область (45)</option>
<option value="1.2">  Курская область (46)</option>
<option value="1.6">  Ленинградская область (47)</option>
<option value="1.5">  Липецкая область (48)</option>
<option value="1.2">  Магаданская область (49)</option>
<option value="1.7">  Московская область (50)</option>
<option value="1.1">  Мурманская область (51)</option>
<option value="0.8">  Ненецкий автономный округ (83)</option>
<option value="1.8">  Нижегородская область (52)</option>
<option value="1">  Новгородская область (53)</option>
<option value="1.7">  Новосибирская область (54)</option>
<option value="1.6">  Омская область (55)</option>
<option value="1.7">  Оренбургская область (56)</option>
<option value="1">  Орловская область (57)</option>
<option value="1.4">  Пензенская область (58)</option>
<option value="2">  Пермский край (59)</option>
<option value="1.4">  Приморский край (25)</option>
<option value="1">  Псковская область (60)</option>
<option value="1.1">  Республика Адыгея (Адыгея) (01)</option>
<option value="1.3">  Республика Алтай (04)</option>
<option value="1.8">  Республика Башкортостан (02)</option>
<option value="1.3">  Республика Бурятия (03)</option>
<option value="1">  Республика Дагестан (05)</option>
<option value="1.2">  Республика Ингушетия (06)</option>
<option value="1.3">  Республика Калмыкия (08)</option>
<option value="1.3">  Республика Карелия (10)</option>
<option value="1.6">  Республика Коми (11)</option>
<option value="1.2">  Республика Крым (91)</option>
<option value="1">  Республика Марий Эл (12)</option>
<option value="1">  Республика Мордовия (13)</option>
<option value="1.3">  Республика Саха (Якутия) (14)</option>
<option value="1">  Республика Северная Осетия - Алания (15)</option>
<option value="2">  Республика Татарстан (Татарстан) (16)</option>
<option value="1">  Республика Тува (17)</option>
<option value="1">  Республика Хакасия (19)</option>
<option value="1.8">  Ростовская область (61)</option>
<option value="1.4">  Рязанская область (62)</option>
<option value="1.6">  Самарская область (63)</option>
<option value="1.8">  Санкт-Петербург (78, 178)</option>
<option value="1.6">  Саратовская область (64)</option>
<option value="1.5">  Сахалинская область (65)</option>
<option value="1.8">  Свердловская область (66)</option>
<option value="1">  Смоленская область (67)</option>
<option value="1">  Ставропольский край (26)</option>
<option selected value="1">  Тамбовская область (68)</option>
<option value="1.5">  Тверская область (69)</option>
<option value="1.6">  Томская область (70)</option>
<option value="1.5">  Тульская область (71)</option>
<option value="2">  Тюменская область (72)</option>
<option value="1.6">  Удмуртская Республика (18)</option>
<option value="1.4">  Ульяновская область (73)</option>
<option value="1.7">  Хабаровский край (27)</option>
<option value="2">  Ханты-Мансийский автономный округ - Югра (86)</option>
<option value="1.7">  Челябинская область (74)</option>
<option value="0.7">  Чеченская Республика (20)</option>
<option value="1.6">  Чувашская Республика - Чувашия (21)</option>
<option value="0.7">  Чукотский автономный округ (87)</option>
<option value="1">  Ямало-Ненецкий автономный округ (89)</option>
<option value="1.5">  Ярославская область (76)</option>
<option value="1.8">Иностранный гражданин (-)</option>
</select>
</div>
<div class="frame">
<div id="wb_Text77">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:19px;">Срок страхования:</span></div>
<div id="wb_Image6">
<a href="#" onclick="$('#Carousel2').carousel('goto,1');return false;"><img src="images/left.png" id="Image6" alt=""></a></div>
<div id="wb_Text96">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:19px;line-height:21px;">Лица, допущенные к управлению ТС:</span></div>
<div id="wb_Text97">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:19px;">С ограниченным списком</span></div>
<div id="wb_Text98">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:19px;">Без ограничений</span></div>
<div id="wb_RadioButton4">
<input type="radio" id="RadioButton4" name="Лица, допущенные к управлению" value="1" checked><label for="RadioButton4"></label></div>
<div id="wb_RadioButton5">
<input type="radio" id="RadioButton5" name="Лица, допущенные к управлению" value="1.3"><label for="RadioButton5"></label></div>
<div id="wb_Text99">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:19px;">Возраст и водительский стаж:</span></div>
<select name="Возраст и водительский стаж" size="1" id="Combobox16" title="$&#1042;&#1086;&#1079;&#1088;&#1072;&#1089;&#1090; &#1080; &#1074;&#1086;&#1076;&#1080;&#1090;&#1077;&#1083;&#1100;&#1089;&#1082;&#1080;&#1081; &#1089;&#1090;&#1072;&#1078;">
<option value="1">  старше 22 лет, стаж свыше 3-х лет (Квс =1)</option>
<option value="1.7">  старше 22 лет, стаж до 3-х лет включительно (Квс =1,7)</option>
<option value="1.6">  до 22 лет включительно, стаж свыше 3-х лет (Квс =1,6)</option>
<option value="1.8">  до 22 лет включительно, стаж до 3-х лет включительно (Квс =1,8)</option>
</select>
<select name="Срок страхования (период использования автомоблиля)" size="1" id="Combobox17">
<option selected value="1">  1 Год</option>
<option value="0.95">  9 месяцев (Кс = 0,95)</option>
<option value="0.9">  8 месяцев (Кс = 0,9)</option>
<option value="0.8">  7 месяцев (Кс = 0,8)</option>
<option value="0.7">  6 месяцев (Кс = 0,7)</option>
<option value="0.65">  5 месяцев (Кс = 0,65)</option>
<option value="0.6">  4 месяца (Кс = 0,6)</option>
<option value="0.5">  3 месяца (Кс = 0,5)</option>
<option value="0.4">  2 месяца (Кс = 0,4)</option>
<option value="0.3">  от 16 дней до 1 месяца (Кс = 0,3)</option>
<option value="0.2">  от 5 дней до 15 дней (Кс = 0,2)</option>
</select>
<div id="wb_Text62">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:19px;">Скидка за безаварийность:</span></div>
<select name="Скидка за безаварийную езду" size="1" id="Combobox11">
<option selected value="1">  Страхование впервые (класс 3, кбм 1)</option>
<option value="0.95">  1 год без аварий (класс 4, кбм 0,95)</option>
<option value="0.9">  2 года без аварий (класс 5, кбм 0, 9)</option>
<option value="0.85">  3 года без аварий (класс 6, кбм 0, 85)</option>
<option value="0.8">  4 года без аварий (класс 7, кбм 0, 8)</option>
<option value="0.75">  5 лет без аварий (класс 8, кбм 0, 75)</option>
<option value="0.7">  6 лет без аварий (класс 9, кбм 0, 7)</option>
<option value="0.65">  7 лет без аварий (класс 10, кбм 0, 65)</option>
<option value="0.6">  8 лет без аварий (класс 11, кбм 0, 6)</option>
<option value="0.55">  9 лет без аварий (класс 12, кбм 0, 55)</option>
<option value="0.5">  10 лет без аварий (класс 13, кбм 0, 5)</option>
<option value="2.45">  (класс М, кбм 2,45)</option>
<option value="2.3">  (класс 0, кбм 2,3)</option>
<option value="1.55">  (класс 1, кбм 1,55)</option>
<option value="1.4">  (класс 2, кбм 1,4)</option>
</select>
<div id="wb_Image24">
<a href="#" onclick="$('#Carousel2').carousel('goto,3');return false;"><img src="images/doulbe_arrow_right.png" id="Image24" alt=""></a></div>
<div id="wb_Shape42">
<a href="#" onclick="$('#Carousel2').carousel('goto,3');PlayAudio('MediaPlayer2');return false;"><div id="Shape42"><div id="Shape42_text"><span style="color:#F15A0B;font-family:'Geometric 706';font-size:24px;"><strong>Далее</strong></span></div></div></a></div>
</div>
<div class="frame">
<div id="wb_Shape49">
<a href="#" onclick="$('#Carousel2').carousel('goto,4');PlayAudio('MediaPlayer2');return false;"><div id="Shape49"><div id="Shape49_text"><span style="color:#F15A0B;font-family:'Geometric 706';font-size:24px;"><strong>Оформить полис</strong></span></div></div></a></div>
<div id="wb_Text102">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:19px;">Стоимость полиса ОСАГО по <br>предварительному расчёту сотавит:</span></div>
<div id="wb_Text75">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:19px;">Ваш телефон:</span></div>
<div id="wb_Text74">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:19px;">Ваш e-mail адрес:</span></div>
<div id="wb_Text72">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:19px;">Ваше имя (полностью):</span></div>
<input type="text" id="Editbox12" name="ФИО" value="" spellcheck="false" placeholder="  &#1060;.&#1048;.&#1054;.">
<input type="text" id="Editbox11" name="Телефон" value="" spellcheck="false" placeholder="  +7(&#8226;&#8226;&#8226;) &#8226;&#8226;&#8226; &#8226;&#8226; &#8226;&#8226;">
<input type="text" id="Editbox8" name="E-mail адрес" value="" spellcheck="false" placeholder="  kosmos@mail.ru">
<div id="wb_Text71">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:19px;"><strong>Для оформления полиса заполните поля ниже: </strong></span></div>
<input type="text" id="Editbox16" name="Стоимость оформления полиса с услугой" value="" autocomplete="off" spellcheck="false" placeholder="&#1048;&#1058;&#1054;&#1043;">
<div id="wb_Text103">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:21px;"><strong>рублей</strong></span></div>
</div>
<div class="frame">
<div id="wb_Text73">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:17px;"><u>Скан или фото паспорта РФ собственника ТС:</u></span></div>
<div id="wb_Shape50">
<a href="#" onclick="$('#Carousel2').carousel('goto,5');PlayAudio('MediaPlayer2');return false;"><div id="Shape50"><div id="Shape50_text"><span style="color:#F15A0B;font-family:'Geometric 706';font-size:24px;"><strong>Далее</strong></span></div></div></a></div>
<div id="wb_Image30">
<a href="#" onclick="$('#Carousel2').carousel('goto,3');return false;"><img src="images/left.png" id="Image30" alt=""></a></div>
<div id="wb_Image31">
<a href="#" onclick="$('#Carousel2').carousel('goto,5');return false;"><img src="images/doulbe_arrow_right.png" id="Image31" alt=""></a></div>
<div id="wb_Text120">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:19px;line-height:21px;"><strong>1-я страница паспорта <br>и страница с регистрацией</strong></span></div>
<div id="wb_Text82">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:19px;line-height:23px;"><strong>СТС или ПТС</strong></span></div>
<div id="wb_Shape8">
<div id="Shape8"></div></div>
<div id="wb_Text85">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:17px;line-height:22px;"><u>Скан или фото СТС или ПТС:</u></span></div>
<input type="file" accept=".bmp,.jpeg,.jpg,.pdf,.png" name="СТС или ПТС" id="FileUpload5">
<div id="wb_Text86">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:19px;"><strong>Необходимо загрузить документы:</strong></span></div>
<div id="wb_Shape70">
<div id="Shape70"></div></div>
<input type="file" accept=".bmp,.jpeg,.jpg,.pdf,.png" name="Паспорт собственника ТС 1-я страница" id="FileUpload8" required multiple>
</div>
<div class="frame">
<div id="wb_Text83">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:17px;line-height:19px;"><u>Скан или фото Водительского <br>удостоверения всех лиц, допущенных к управлению ТС:</u></span></div>
<div id="wb_Shape15">
<div id="Shape15"></div></div>
<div id="wb_Shape31">
<a href="#" onclick="$('#Carousel2').carousel('goto,7');PlayAudio('MediaPlayer2');return false;"><div id="Shape31"><div id="Shape31_text"><span style="color:#F15A0B;font-family:'Geometric 706';font-size:24px;"><strong>Далее</strong></span></div></div></a></div>
<div id="wb_Shape64">
<a href="#" onclick="$('#Carousel2').carousel('goto,6');PlayAudio('MediaPlayer2');return false;"><div id="Shape64"><div id="Shape64_text"><span style="color:#F15A0B;font-family:'Geometric 706';font-size:24px;"><strong>Далее</strong></span></div></div></a></div>
<div id="wb_Text114">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:17px;line-height:20px;">Если диагностическая карта&nbsp; отсутствует, <br>поставьте отметку здесь:</span></div>
<div id="wb_Image26">
<a href="#" onclick="$('#Carousel2').carousel('goto,6');return false;"><img src="images/doulbe_arrow_right.png" id="Image26" alt=""></a></div>
<div id="wb_Text84">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:19px;line-height:23px;"><strong>ВУ всех лиц ТС</strong></span></div>
<div id="wb_Shape65">
<div id="Shape65"></div></div>
<div id="wb_RadioButton6">
<input type="radio" id="RadioButton6" name="Диагностическая карта" value="1.2"><label for="RadioButton6"></label></div>
<div id="wb_Text113">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:19px;line-height:23px;"><strong>Диагностическая карта ТС</strong></span></div>
<div id="wb_Image18">
<a href="#" onclick="$('#Carousel2').carousel('goto,4');return false;"><img src="images/left.png" id="Image18" alt=""></a></div>
<div id="wb_Text112">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:17px;line-height:18px;"><u>Если у Вас уже есть диагностичес-<br>кая карта, просто прикрепите её:</u></span></div>
<input type="file" accept=".bmp,.jpeg,.jpg,.pdf,.png" name="Диагностическая карта ТС" id="FileUpload7">
<input type="file" accept=".bmp,.jpeg,.jpg,.pdf,.png" name="Водительские удостоверения всех лиц, допущенных к управлению ТС" id="FileUpload6" multiple>
</div>
<div class="frame">
<div id="wb_Text78">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:19px;line-height:23px;"><strong>Для оформления диагностической карты заполните поля ниже:</strong></span></div>
<div id="wb_Text79">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:19px;">Марка шин Вашего ТС:</span></div>
<div id="wb_Text80">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:19px;">Пробег ТС:</span></div>
<div id="wb_Text81">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:19px;">Тип двигателя:</span></div>
<div id="wb_Shape32">
<a href="#" onclick="$('#Carousel2').carousel('goto,7');PlayAudio('MediaPlayer2');return false;"><div id="Shape32"><div id="Shape32_text"><span style="color:#F15A0B;font-family:'Geometric 706';font-size:24px;"><strong>Далее</strong></span></div></div></a></div>
<div id="wb_Image19">
<a href="#" onclick="$('#Carousel2').carousel('goto,4');return false;"><img src="images/left.png" id="Image19" alt=""></a></div>
<div id="wb_Image27">
<a href="#" onclick="$('#Carousel2').carousel('goto,7');return false;"><img src="images/doulbe_arrow_right.png" id="Image27" alt=""></a></div>
<input type="text" id="Editbox13" name="Марка шин ТС" value="" spellcheck="false" placeholder="  Pirelli Ice Zerro 195/65/15">
<input type="text" id="Editbox14" name="Пробег ТС" value="" spellcheck="false" placeholder="  35000 &#1082;&#1084;">
<select name="Тип двигателя" size="1" id="Combobox15">
<option selected>  Бензин</option>
<option>  Дизельное топливо</option>
<option>  Сжатый газ</option>
<option>  Сжиженный газ</option>
<option>  Без топлива</option>
</select>
</div>
<div class="frame">
<div id="wb_Text87">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:19px;line-height:21px;">Стоимость&nbsp; полиса ОСАГО <br>+(1000 рублей за услуги) по предварительному <br>расчёту составит:</span></div>
<div id="wb_Text88">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:19px;line-height:21px;">Стоимость&nbsp; полиса ОСАГО с оформлением диагностической карты <br>+ (1000 рублей за услуги) по предварительному расчёту составит:</span></div>
<input type="text" id="Editbox17" name="Стоимость  полиса ОСАГО плюс 1000 руб. за услуги" value="" autocomplete="off" spellcheck="false" placeholder="&#1048;&#1058;&#1054;&#1043;">
<input type="text" id="Editbox18" name="Стоимость  полиса ОСАГО с оформлением диагностической карты плюс 1000 руб. за услуги" value="" autocomplete="off" spellcheck="false" placeholder="&#1048;&#1058;&#1054;&#1043;">
<div id="wb_Text126">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:21px;"><strong>руб.</strong></span></div>
<div id="wb_Text128">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:19px;line-height:18px;">Выберете <br>способ получения полиса:</span></div>
<div id="wb_Image20">
<a href="#" onclick="$('#Carousel2').carousel('goto,6');return false;"><img src="images/left.png" id="Image20" alt=""></a></div>
<select name="Cпособ получения полиса" size="1" id="Combobox18">
<option selected>  На электронную почту</option>
<option>  Самовывоз</option>
</select>
<input type="submit" id="Button1" name="" value="Отправить заявку">
<div id="wb_Text125">
<span style="color:#FFFFFF;font-family:'Geometric 706';font-size:21px;"><strong>руб.</strong></span></div>
</div>
</div>
</div>
</form>
</div>
<div id="RollOver3">
<a href="">
<img class="hover" alt="" src="images/boot_osago.png">
<span><img alt="" src="images/boot_osago.png"></span>
</a>
</div>
<div id="RollOver4">
<a href="">
<img class="hover" alt="" src="images/boot_kasko.png">
<span><img alt="" src="images/boot_kasko2.png"></span>
</a>
</div>
<div id="wb_Shape38">
<img src="images/img0186.png" id="Shape38" alt=""></div>
<div id="RollOver2">
<a href="./index.html">
<div class="image_container">
<div class="front"><img alt="" src="images/close.png"></div>
<div class="back"><img alt="" src="images/close.png"></div>
</div>
</a>
</div>
</div>
</body>
</html>