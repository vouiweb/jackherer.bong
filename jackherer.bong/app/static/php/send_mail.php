<?php
	$name = $_POST["name"];
	$phone = $_POST["phone"];
	$email = $_POST["email"];
	$text = $_POST["text"];

	$to = "gsk.2013@mail.ru";

	$subject = "Новая заявка с сайта: kvartirayalta.com";

	$message = "Имя пользователя: ".htmlspecialchars($name)."<br />
				Телефон: ".htmlspecialchars($phone)."<br />
				Почта: ".htmlspecialchars($email)."<br />
				".htmlspecialchars($text);

	$headers = "From: kvartirayalta.com <".htmlspecialchars($email).">\r\nContent-type: text/html; charset=UTF-8 \r\n";

	mail($to, $subject, $message, $headers);
	exit();
?>