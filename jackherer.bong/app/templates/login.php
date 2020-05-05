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

			<title>Tinder #2 - Авторизация</title>

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
			$data = $_POST;
			if (isset($data['do_login'])) {
				
				$errors = array();
				
				$user = R::findOne('userpassword', 'email = ?', array($data['email']));
				
				if($user) {
					if (md5($data['password']) == $user->password) {
						$_SESSION['logged_user'] = $user;
						echo '<script>$(function(){$(".form__status").html("Вы авторизованы!");})</script>';
						$url_redirect = $pathIndex.'/templates/account';
						echo '<script>$(function(){window.location.href = "'.$url_redirect.'";})</script>';
					} else {
						$errors[] = 'Неверный пароль!';
					}
				} else {
					$errors[] = 'Пользователь с таким логином не найден!';
				}

				if(!empty($errors)) { 
					echo '<script>$(function(){$(".form__status").html("'.array_shift($errors).'");})</script>';
				}
			}
		?>

		<form action="login.php" method="POST" class="form">
			<p><strong>Ваш E-mail: </strong></p>
			<input type="email" name="email" value="<?php echo @$data['email']; ?>" >
			<p><strong>Введите пароль: </strong></p>
			<input type="password" name="password" value="<?php echo @$data['password']; ?>" >
			<br>
			<button type="submit" name="do_login">Авторизация</button>
			<span class="form__status"></span>
		</form>
		
		<script>
			$("#login").css("color", "#333333");
		</script>

	</body>
</html>