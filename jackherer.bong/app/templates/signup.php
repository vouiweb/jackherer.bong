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

				if (strlen($data['password_1']) < 7) {
					$errors[] = 'Пароль должен иметь длину не менее 7 знаков';
				}

				if ($data['password_2'] != $data['password_1']) {
					$errors[] = 'Пароли не совпадают!';
				}

				if(R::count('userpassword', 'email = ?', array($data['email'])) > 0) {
					$errors[] = 'Такой E-mail уже используется другим пользователем!';
				}

				if (empty($data['email'])) {
			    	$errors[] = "Не заполнено обязательное поле - email";
			  	} elseif ( filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) === false) { 
			    	$errors[] = "формат почтового ящика неправильный";
			  	}

				if(empty($errors)) {

					$userinfo = R::dispense('userinfo');
					$userinfo->name = NULL;
					R::store($userinfo);

					function getActivateLink($login) {
						$key = "777";
						return md5($key.$login);
					}

					$userpassword = R::dispense('userpassword');
					$userpassword->email = $data['email'];
					$userpassword->password = md5($data['password_1']);
					$userpassword->activation = getActivateLink($data['email']);
					R::store($userpassword);

					mail($data['email'], "Регистрация на сайте!", $_SERVER['HTTP_HOST'].$pathIndex."/templates/activate.php?login=".$data['email']."&key=$userpassword->activation");

					#echo '<script>$(function(){$(".form__status").html("Вы успешно зарегистрировались!");})</script>';

					$user = R::findOne('userpassword', 'email = ?', array($data['email']));
					$_SESSION['logged_user'] = $user;

					$url_redirect = $pathIndex.'/templates/edit';
					echo '<script>$(function(){window.location.href = "'.$url_redirect.'";})</script>';

				} else {
					echo '<script>$(function(){$(".form__status").html("'.array_shift($errors).'");})</script>';
				}

			}
		?>

		<form action="signup.php" method="POST" class="form">
			<p><strong>Ваш E-mail: </strong></p>
			<input type="email" name="email" value="<?php echo @$data['email']; ?>" required>
			<p><strong>Введите пароль: </strong></p>
			<input type="password" name="password_1" value="<?php echo @$data['password_1']; ?>" required>
			<p><strong>Повторите пароль: </strong></p>
			<input type="password" name="password_2" value="<?php echo @$data['password_2']; ?>" required>
			<br>
			<button type="submit" name="do_signup">Зарегистрироваться</button>
			<span class="form__status"></span>
		</form>

		<script>
			$("#registration").css("color", "#333333");
		</script>

	</body>
</html>