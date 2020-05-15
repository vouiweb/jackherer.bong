<?php
	$pathIndex = "/app";
	require $_SERVER['DOCUMENT_ROOT'].$pathIndex."/static/php/db_connect.php";
	require $_SERVER['DOCUMENT_ROOT'].$pathIndex."/templates/functions/checki/checki.php";
	require $_SERVER['DOCUMENT_ROOT'].$pathIndex."/templates/functions/checki/-edit/checki-edit.php";
?>

<!DOCTYPE html>

<html lang="ru">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<meta name="robots" content="index,follow">

			<title>Tinder #2 - Редактирование учётной записи</title>

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
			$userinfo = R::load('userinfo', $_SESSION['logged_user']->id);
			$userpassword = R::load('userpassword', $_SESSION['logged_user']->id);
		?>

		<?php

			# Регистрация пользователя

			// Добавить верификацию для E-mail
			
			if (isset($_POST['do_save'])) {

				$errors = array();

				checkEmail($_POST['email']);

				// ПРОВЕРКА ПАРОЛЯ

			  	if (!empty($_POST['password_1'])) {
			  		checkPassword($_POST['password_2']);
					if (md5($_POST['password_1']) != $userpassword->password) {
						$errors[] = 'Неправильно введён пароль! Повторите попытку.';
					}
			  	}

				checkName($_POST['name']);
				checkSurname($_POST['surname']);
				checkAge($_POST['age']);
				checkCity($_POST['city']);
				checkProfession($_POST['profession']);

				if(empty($errors)) {
					#preg_replace('/\s/', '', $_POST['...']);
					$userinfo->name = $_POST['name'];
					$userinfo->surname = $_POST['surname'];
					$userinfo->gender = $_POST['gender'];
					$userinfo->age = $_POST['age'];
					$userinfo->city = $_POST['city'];
					$userinfo->location = $x.';'.$y;
					$userinfo->profession = $_POST['profession'];
					$userinfo->about_me = $_POST['about_me'];
					$userinfo->url = $_POST['url'];
					$userinfo->status_account = "default";
					R::store($userinfo);

					$userpassword->email = $_POST['email'];
					$userpassword->password = md5($_POST['password_2']);
					R::store($userpassword);

					echo '<script>$(function(){$(".form__status").html("Сохранено!");})</script>';

				} else {
					echo '<script>$(function(){$(".form__status").html("'.array_shift($errors).'");})</script>';
				}

			}
		?>

		<?php if ( $userpassword->activation == NULL ) : ?>
			<form action="edit.php" method="POST" class="form">

				<h1>Основное: </h1>
				
				<p><strong>Ваше имя: </strong></p>
				<input type="text" name="name" value="<?php echo empty($userinfo->name == NULL) ? $userinfo->name : @$_POST['name']; ?>" required>

				<p><strong>Ваше Фамилия: </strong></p>
				<input type="text" name="surname" value="<?php echo empty($userinfo->surname == NULL) ? $userinfo->surname : @$_POST['surname']; ?>">

				<p><strong>Ваш пол: </strong></p>
				<?php 
					if ($userinfo->gender == "девушка") {

						printf('<input type="radio" name="gender" value="парень" required> Я парень <input type="radio" name="gender" value="девушка" required checked> Я девушка');
					} else if ($userinfo->gender == "парень") {
						printf('<input type="radio" name="gender" value="парень" required checked> Я парень <input type="radio" name="gender" value="девушка" required> Я девушка');
					} else {
						printf('<input type="radio" name="gender" value="парень" required> Я парень <input type="radio" name="gender" value="девушка" required> Я девушка');
					}
				?>

				<p><strong>Ваш возраст: </strong></p>
				<input type="number" name="age" value="<?php echo empty($userinfo->age == NULL) ? $userinfo->age : @$_POST['age']; ?>" required>

				<p><strong>Ваш город: </strong></p>

				<?php 
				    if (!empty($_SERVER['HTTP_CLIENT_IP']))
				    {
				        $ip=$_SERVER['HTTP_CLIENT_IP'];
				    }
				    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
				    {
				        $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
				    }
				    else
				    {
				        $ip=$_SERVER['REMOTE_ADDR'];
				    }
				    $result = file_get_contents("http://ipgeobase.ru:7020/geo?ip=".$ip);
					$xml = new SimpleXMLElement($result);
				?>

				<?php if ( !empty($xml->ip->city) ) : ?>
					<input type="text" name="city" value="<?php echo empty($userinfo->city == NULL) ? $xml->ip->city : $userinfo->city ?>" required>
				<?php else : ?> 
					<input type="text" name="city" value="<?php echo empty($userinfo->city == NULL) ? $userinfo->city : @$_POST['city']; ?>" required>
				<?php endif; ?>

				<p><strong>Какая у вас профессия: </strong></p>

				<select name="profession" required>
					<option selected="selected" disabled>Выберите из предложенного списка</option>
					<option value="Фотограф" <?= $userinfo->profession == 'Фотограф' ? ' selected' : '' ?>>Фотограф</option>
					<option value="Актёр" <?= $userinfo->profession == 'Актёр' ? ' selected' : '' ?>>Актёр</option>
				</select>
				<br>
				<p><?php echo empty($userinfo->profession == NULL) ? "Вы: ".$userinfo->profession : "" ?></p>	

				<p><strong>Расскажите о себе: </strong></p>
				<textarea name="about_me" id="" cols="30" rows="10"><?php echo empty($userinfo->about_me == NULL) ? $userinfo->about_me : @$_POST['about_me']; ?></textarea>

				<p><strong>Ссылка на ваше Портфолио/Блог: </strong></p>
				<input type="url" name="url" value="<?php echo empty($userinfo->url == NULL) ? $userinfo->url : @$_POST['url']; ?>">

				<br>
				<strong>Изменить E-mail: </strong>
				<p><strong>Ваш E-mail: </strong></p>
				<input type="text" name="email" value="<?php echo $userpassword->email ?>">

				<br>
				<strong>Изменить пароль: </strong>
				<p><strong>Введите старый пароль: </strong></p>
				<input type="password" name="password_1">
				<p><strong>Повторите новый пароль: </strong></p>
				<input type="password" name="password_2">
				
				<br><br>
				<button type="submit" name="do_save">Сохранить изменения</button>
				<span class="form__status"></span>
			</form>

			<br>
			<button type="submit" name="do_buy">Купить Premium</button>
		<?php else : ?> 
			Подтвердите почту для продолжения регистрации!
		<?php endif; ?>

		<script>
			// пока сюда это определим, это определение местоположения пользователя
			$(document).ready(function() {
				  navigator.geolocation.getCurrentPosition(sendPosition);
				  function sendPosition(position) {
					    $.ajax({
					        url : 'signup.php',
					        type : 'POST',
					        x : position.coords.latitude,
					        y : position.coords.longitude,
					    });
				  }

			});
		</script>

<!-- 		<script>
			$("#edit").css("color", "#333333");
		</script> -->

	</body>
</html>