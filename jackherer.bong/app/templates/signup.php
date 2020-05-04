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

			<title>Tinder #2 - Регистрация</title>

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
			# Подключение Header
			include $_SERVER['DOCUMENT_ROOT'].$pathIndex."/templates/header/header.php"; 
		?>

		<?php

			# Регистрация пользователя

			$data = $_POST;
			
			if (isset($data['do_signup'])) {
				
				$errors = array();

				// Проверка на пустоту каждого поля, на случай если валидация формы не сработает
				// Добавить ограничения для "Имя":
				/* 
					не менее 3-х букв, и не более 13 букв
					Только русские и латинские буквы(регуляркой)
					запретить символы и цифры
				*/

				// Добавить верификацию для E-mail
				
				// Добавить ограничения для "Пароль":
				/*
					Не менее 7-и символов, Русские или Латинские буквы, хотя бы 1 цифра
				*/


				if ($data['password_2'] != $data['password_1']) {
					$errors[] = 'Пароли не совпадают!';
				}

				if(R::count('userpassword', 'email = ?', array($data['email'])) > 0) {
					$errors[] = 'Такой E-mail уже используется другим пользователем!';
				}

				if(empty($errors)) {

					$userinfo = R::dispense('userinfo');
					$userinfo->name = $data['name'];
					$userinfo->gender = $data['gender'];
					$userinfo->age = $data['age'];
					$userinfo->profession = $data['profession'];
					R::store($userinfo);

					$userpassword = R::dispense('userpassword');
					$userpassword->email = $data['email'];
					$userpassword->password = md5($data['password_1']);
					R::store($userpassword);

					echo '<script>$(function(){$(".form__status").html("Вы успешно зарегистрировались!");})</script>';
					$url_redirect = $pathIndex.'/templates/login';
					echo '<script>$(function(){window.location.href = "'.$url_redirect.'";})</script>';

				} else {
					echo '<script>$(function(){$(".form__status").html("'.array_shift($errors).'");})</script>';
				}

			}
		?>

		<form action="signup.php" method="POST" class="form">
			<p>
				<p><strong>Ваше имя: </strong></p>
				<input type="text" name="name" value="<?php echo @$data['name']; ?>" required>
			</p>
			<p>
				<p><strong>Ваш пол: </strong></p>
			   <input type="radio" name="gender" value="парень" required> Я парень<Br>
			   <input type="radio" name="gender" value="девушка" required> Я девушка</p>
			</p>
			<p>
				<p><strong>Ваш E-mail: </strong></p>
				<input type="email" name="email" value="<?php echo @$data['email']; ?>" required>
			</p>
			<p>
				<p><strong>Ваш возраст: </strong></p>
				<input type="number" name="age" value="<?php echo @$data['age']; ?>" required>
			</p>
			<p>
				<p><strong>Какая у вас профессия: </strong></p>
				<input type="text" name="profession" value="<?php echo @$data['profession']; ?>" required>
			</p>
			<p>
				<p><strong>Введите пароль: </strong></p>
				<input type="password" name="password_1" value="<?php echo @$data['password_1']; ?>" required>
			</p>
			<p>
				<p><strong>Повторите пароль: </strong></p>
				<input type="password" name="password_2" value="<?php echo @$data['password_2']; ?>" required>
			</p>
			<button type="submit" name="do_signup">Зарегистрироваться</button>
			<span class="form__status"></span>
		</form>

		<script>
			$("#registration").css("color", "#333333");
		</script>

	</body>
</html>