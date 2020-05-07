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

			// Добавить верификацию для E-mail
			
			if (isset($data['do_save'])) {

				$errors = array();

				//проверка почты

				if (empty($data['email'])) {
			    	$errors[] = "Не заполнено обязательное поле - email";
			  	} elseif ( filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) === false) { 
			    	$errors[] = "формат почтового ящика неправильный";
			  	}

				// проверка пароля

				if (!empty($data['password_1'])) {
					if (strlen($data['password_1']) < 7) {
						$errors[] = 'Пароль должен иметь длину не менее 7 знаков';
					}
					if (md5($data['password_1']) != $userpassword->password) {
						$errors[] = 'Неправильный пароль!';
					}
				}

				// проверка имени

				if (strlen($data['name']) < 3 OR strlen($data['name']) > 13) {
					$errors[] = 'Имя должно содержать не менее 3, и не более 13 букв!';
				}
				if(!preg_match("/^[a-zA-Zа-яА-Я]+$/ui",$data['name'])) {
				    $errors[] = 'Имя должно содержать только буквы русского или английского алфавита!';
				}

				// проверка фамилии

				if (!empty($data['surname'])) {
					if (strlen($data['surname']) < 4 OR strlen($data['surname']) > 15) {
						$errors[] = 'Фамилия должна содержать не менее 4, и не более 15 букв!';
					}
					if(!preg_match("/^[a-zA-Zа-яА-Я]+$/ui",$data['surname'])) {
					    $errors[] = 'Фамилия должна содержать только буквы русского или английского алфавита!';
					}
				}

				// Проверка возраста

				if (empty($data['age']) OR preg_match("/[^\d]{1}/",$data['age']) OR strlen($data['age']) > 3)
				{
					$errors[] = 'Укажите настоящий возраст!';
				}
				if ($data['age'] < 16)
				{
					$errors[] = 'У нашего приложения возрастное ограничение! 16+!';
				}

				// Проверка города

				if(!preg_match("/^[a-zA-Zа-яА-Я]+$/ui",$data['city']) OR strlen($data['city']) / 2 < 3) {
				    $errors[] = 'Такого города не существует на нашей карте!';
				}

				// Проверка профессии

				if (empty($data['profession'])) {
					$errors[] = 'Укажите вашу профессию!';
				}

				if(empty($errors)) {
					#preg_replace('/\s/', '', $data['...']);
					$userinfo->name = $data['name'];
					$userinfo->surname = $data['surname'];
					$userinfo->gender = $data['gender'];
					$userinfo->age = $data['age'];
					$userinfo->city = $data['city'];
					$userinfo->location = $x.';'.$y;
					$userinfo->profession = $data['profession'];
					$userinfo->about_me = $data['about_me'];
					$userinfo->url = $data['url'];
					$userinfo->status_account = "default";
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

		<?php if ( $userpassword->activation == NULL ) : ?>
			<form action="edit.php" method="POST" class="form">

				<h1>Основное: </h1>

				<p><strong>Ваше имя: </strong></p>
				<input type="text" name="name" value="<?php echo empty($userinfo->name == NULL) ? $userinfo->name : @$data['name']; ?>" required>

				<p><strong>Ваше Фамилия: </strong></p>
				<input type="text" name="surname" value="<?php echo empty($userinfo->surname == NULL) ? $userinfo->surname : @$data['surname']; ?>">

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
				<input type="number" name="age" value="<?php echo empty($userinfo->age == NULL) ? $userinfo->age : @$data['age']; ?>" required>

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
					<input type="text" name="city" value="<?php echo empty($userinfo->city == NULL) ? $userinfo->city : @$data['city']; ?>" required>
				<?php endif; ?>

				<p><strong>Какая у вас профессия: </strong></p>

				<select name="profession" required>
					<option selected="selected" disabled>Выберите из предложенного списка</option>
					<option value="Фотограф">Фотограф</option>
					<option value="Актёр">Актёр</option>
				</select>
				<br>
				<p><?php echo empty($userinfo->profession == NULL) ? "Вы: ".$userinfo->profession : "" ?></p>	

				<p><strong>Расскажите о себе: </strong></p>
				<textarea name="about_me" id="" cols="30" rows="10"><?php echo empty($userinfo->about_me == NULL) ? $userinfo->about_me : @$data['about_me']; ?></textarea>

				<p><strong>Ссылка на ваше Портфолио/Блог: </strong></p>
				<input type="url" name="url" value="<?php echo empty($userinfo->url == NULL) ? $userinfo->url : @$data['url']; ?>">

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
				
				<br>
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