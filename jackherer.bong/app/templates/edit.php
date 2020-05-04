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

			$data = $_POST;
			
			if (isset($data['do_save'])) {
				$errors = array();
				if (!empty($data['password_1']) && (md5($data['password_1']) != $userpassword->password)) {
					$errors[] = 'Неправильный пароль!';
				}

				if(empty($errors)) {

					$userinfo->name = $data['name'];
					$userinfo->surname = $data['surname'];
					$userinfo->gender = $data['gender'];
					$userinfo->about_me = $data['about_me'];
					$userinfo->age = $data['age'];
					$userinfo->city = $data['city'];
					$userinfo->url = $data['url'];
					$userinfo->profession = $data['profession'];
					R::store($userinfo);

					$userpassword->email = $data['email'];

					if (!empty($data['password_1'])) {
						$userpassword->password = md5($data['password_2']);
					}

					R::store($userpassword);

					echo '<script>$(function(){$(".form__status").html("Сохранено!");})</script>';

				} else {
					echo '<script>$(function(){$(".form__status").html("'.array_shift($errors).'");})</script>';
				}

			}
		?>
		<form action="edit.php" method="POST" class="form">
			<h1>Основное: </h1>
			<p>
				<p><strong>Ваше имя: </strong></p>
				<input type="text" name="name" value="<?php echo $userinfo->name; ?>" required>
			</p>
			<p>
				<p><strong>Ваше Фамилия: </strong></p>
				<input type="text" name="surname" value="<?php echo $userinfo->surname; ?>">
			</p>
			<p>
				<p><strong>Ваш возраст: </strong></p>
				<input type="number" name="age" value="<?php echo $userinfo->age; ?>" required>
			</p>
			<p>
				<p><strong>Ваш пол: </strong></p>
				<?php 
					if ($userinfo->gender == "девушка") {

						printf('<input type="radio" name="gender" value="парень" required> Я парень <input type="radio" name="gender" value="девушка" required checked> Я девушка');
					} else
					{
						printf('<input type="radio" name="gender" value="парень" required checked> Я парень <input type="radio" name="gender" value="девушка" required> Я девушка');
					}
				?>
			</p>

			<p>
				<p><strong>Ваш город: </strong></p>
				<input type="text" name="city" value="<?php echo $userinfo->city; ?>" required>
			</p>

			<p>
				<p><strong>Расскажите о себе: </strong></p>
				<textarea name="about_me" id="" cols="30" rows="10"><?php echo $userinfo->about_me; ?></textarea>
			</p>
			<p>
				<p><strong>Ссылка на ваше Портфолио/Блог: </strong></p>
				<input type="url" name="url" value="<?php echo $userinfo->url; ?>">
			</p>
			<p>
				<p><strong>Ваш E-mail: </strong></p>
				<input type="email" name="email" value="<?php echo $_SESSION['logged_user']->email ?>" required>
			</p>
			<p>
				<p><strong>Какая у вас профессия: </strong></p>
				<input type="text" name="profession" value="<?php echo $userinfo->profession;?>" required>
			</p>
			<br>
			<strong>Изменение пароля: </strong>
			<br>
			<p>
				<p><strong>Введите старый пароль: </strong></p>
				<input type="password" name="password_1">
			</p>
			<p>
				<p><strong>Повторите новый пароль: </strong></p>
				<input type="password" name="password_2">
			</p>
			<button type="submit" name="do_save">Сохранить изменения</button>
			<span class="form__status"></span>
		</form>
		<br>
		<button type="submit" name="do_buy">Купить Premium</button>

<!-- 		<script>
			$("#edit").css("color", "#333333");
		</script> -->

	</body>
</html>