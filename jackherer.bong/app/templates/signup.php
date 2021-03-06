<?php
	$pathIndex = "/app";
	require $_SERVER['DOCUMENT_ROOT'].$pathIndex."/static/php/db_connect.php";
	require $_SERVER['DOCUMENT_ROOT'].$pathIndex."/templates/functions/checki/checki.php";
	require $_SERVER['DOCUMENT_ROOT'].$pathIndex."/templates/functions/checki/-signup/checki-signup.php";
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
			
			if (isset($_POST['do_signup'])) {
				
				$errors = array();

				checkPassword($_POST['password_1']);
				checkPasswordMatch($_POST['password_1'], $_POST['password_2']);
				checkEmailRepeat($_POST['email']);

				if(empty($errors)) {

					$userinfo = R::dispense('userinfo');
					$userinfo->name = NULL;
					R::store($userinfo);

					function getActivateLink($login) {
						$key = "777";
						return md5($key.$login);
					}

					$userpassword = R::dispense('userpassword');
					$userpassword->email = $_POST['email'];
					$userpassword->password = md5($_POST['password_1']);
					$userpassword->activation = getActivateLink($_POST['email']);
					R::store($userpassword);

					mail($_POST['email'], "Регистрация на сайте!", $_SERVER['HTTP_HOST'].$pathIndex."/templates/activate.php?login=".$_POST['email']."&key=$userpassword->activation");

					#echo '<script>$(function(){$(".form__status").html("Вы успешно зарегистрировались!");})</script>';

					$user = R::findOne('userpassword', 'email = ?', array($_POST['email']));
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
			<input type="email" name="email" value="<?php echo @$_POST['email']; ?>" required>
			<p><strong>Введите пароль: </strong></p>
			<input type="password" name="password_1" value="<?php echo @$_POST['password_1']; ?>" required>
			<p><strong>Повторите пароль: </strong></p>
			<input type="password" name="password_2" value="<?php echo @$_POST['password_2']; ?>" required>
			<br>
			<button type="submit" name="do_signup">Зарегистрироваться</button>
			<span class="form__status"></span>
		</form>

		<script>
			$("#registration").css("color", "#333333");
		</script>

	</body>
</html>