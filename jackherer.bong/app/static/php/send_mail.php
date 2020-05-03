<?php
	$name = $_POST["name"];
	$phone = $_POST["phone"];
	$email = $_POST["email"];
	$text = $_POST["text"];

	$to = "...";

	$subject = "Новая заявка с сайта: ...";

	$message = "Имя пользователя: ".htmlspecialchars($name)."<br />
				Телефон: ".htmlspecialchars($phone)."<br />
				Почта: ".htmlspecialchars($email)."<br />
				".htmlspecialchars($text);

	$headers = "From: ... <".htmlspecialchars($email).">\r\nContent-type: text/html; charset=UTF-8 \r\n";

	mail($to, $subject, $message, $headers);
	exit();
?>