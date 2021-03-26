<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';

$mail = new PHPMailer(true);
$mail->CharSet = 'UTF-8';
$mail->setLanguage('php','phpmailer/language/');
$mail->IsHTML(true);

// ОТ кого
$mail->setForm('email','name');
//Кому
$mail->addAddress('ani.netali00101@gmail.com');
//Тема письма
$mail->Subject = 'Свободная';

// Рука
$hand = "Правая";
if($_POST['hand'] == "left") {
	$hand = "Левая";
}

//Тело письма
$body = '<h1>Письмо от клиента!</h1>';

if (trim(!empty($_POST['name']))) {
	$body.='<p><strong>Имя:</strong>'.$_POST['name'].'</p>';
}
if (trim(!empty($_POST['email']))) {
	$body.='<p><strong>E-mail:</strong>'.$_POST['email'].'</p>';
}
if (trim(!empty($_POST['hand']))) {
	$body.='<p><strong>Рука:</strong>'.$hand.'</p>';
}
/*if (trim(!empty($_POST['age']))) {
	$body.='<p><strong>Возраст:</strong>'.$_POST['age'].'</p>';
}*/

if (trim(!empty($_POST['message']))) {
	$body.='<p><strong>Сообщение:</strong>'.$_POST['message'].'</p>';
}

//Прикрепить фаил
if (!empty($_FILES['image']['tmp_name'])) {
	//Путь загрузки файла
	$filePath = __DIR__ . "/files/" . $_FILES['image']['name'];
	//Грузим фаил
	if (copy($_FILES['image']['tmp_name'], $filePath)) {
		$fileAttach = $filePath;
		$body.='<p><strong>Фото в приложении</strong>';
		$mail->addAttachment($fileAttach);
	}
}

$mail->Body = $body;

//Отправляем
if (!$mail->send()) {
	$message = 'Ошибка';
}else {
	$message = 'Данные отправлены!';
}

$response = ['message' => $message];

header('Content-type: application/json');
echo json_encode($response);
?>
