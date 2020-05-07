<?php
	$pathIndex = "/app";
	require $_SERVER['DOCUMENT_ROOT'].$pathIndex."/static/php/db_connect.php";
?>

<!DOCTYPE html>

<html lang="ru">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<meta name="robots" content="index,follow">

			<title>Tinder #2 - Подтверждение почты</title>

		<meta name="description" content="">
		
		<!-- <link rel="shortcut icon" type="image/x-icon" href=""> -->
		<!-- <link rel="stylesheet" href=""> -->
		
		<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    
	    <!--[if lt IE 9]>
	      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	    <![endif]-->
	</head>
	<body>

		<?php 
			include $_SERVER['DOCUMENT_ROOT'].$pathIndex."/templates/header/header.php"; 
		?>

		<?php

			$key = $_GET['key'];

			function checkActivateLink($key) {
				$DB_ACTIVATE = R::load('userpassword', $_SESSION['logged_user']->id);
				return $DB_ACTIVATE->activation === $key;
			}

			function activateUser() {
				$DB_ACTIVATE = R::load('userpassword', $_SESSION['logged_user']->id);
				$DB_ACTIVATE->activation = NULL;
				R::store($DB_ACTIVATE);
			}

			if(checkActivateLink($key)) {
				activateUser();
				$url_redirect = $pathIndex.'/templates/edit';
				echo '<script>$(function(){window.location.href = "'.$url_redirect.'";})</script>';
			} else {
				echo "Ошибка при попытке подтверждения почты!";
			}

		?>

	</body>
</html>