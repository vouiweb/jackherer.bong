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

				if (empty($data['name']) or empty($data['email']) or empty($data['password_1']) or empty($data['password_2'])) {
					$errors[] = 'Заполните все поля!';
				}

				if ($data['password_2'] != $data['password_1']) {
					$errors[] = 'Пароли не совпадают!';
				}

				if(R::count('userpassword', 'email = ?', array($data['email'])) > 0) {
					$errors[] = 'Такой E-mail уже используется другим пользователем!';
				}

				if(empty($errors)) {

					$userinfo = R::dispense('userinfo');
					$userinfo->name = $data['name'];
					R::store($userinfo);

					$userpassword = R::dispense('userpassword');
					$userpassword->email = $data['email'];
					$userpassword->password = md5($data['password_1']);
					R::store($userpassword);

					echo '<script>$(function(){$(".form__status").html("Вы успешно зарегистрировались!");})</script>';

				} else {
					echo '<script>$(function(){$(".form__status").html("'.array_shift($errors).'");})</script>';
				}

			}
		?>

		<form action="signup.php" method="POST" class="form">
			<p>
				<p><strong>Ваше имя: </strong></p>
				<input type="text" name="name" value="<?php echo @$data['name']; ?>">
			</p>
			<p>
				<p><strong>Ваш E-mail: </strong></p>
				<input type="email" name="email" value="<?php echo @$data['email']; ?>" >
			</p>
			<p>
				<p><strong>Введите пароль: </strong></p>
				<input type="password" name="password_1" value="<?php echo @$data['password_1']; ?>" >
			</p>
			<p>
				<p><strong>Повторите пароль: </strong></p>
				<input type="password" name="password_2" value="<?php echo @$data['password_2']; ?>">
			</p>
			<button type="submit" name="do_signup">Зарегистрироваться</button>
			<span class="form__status"></span>
		</form>

		<script>
			$("#registration").css("color", "#333333");
		</script>

	</body>
</html>