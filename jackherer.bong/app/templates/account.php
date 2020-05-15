<?php
	$pathIndex = "/app";
	require $_SERVER['DOCUMENT_ROOT'].$pathIndex."/static/php/db_connect.php";
	ob_start();
?>

<!DOCTYPE html>

<html lang="ru">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<meta name="robots" content="index,follow">

			<title>Tinder #2 - Личный Кабинет</title>

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
		
		<hr>
		<br>

		<?php
			$userinfo = R::load('userinfo', $_SESSION['logged_user']->id);
		?>

		<?php

			$dir = $_SERVER['DOCUMENT_ROOT'].$GLOBALS['pathIndex']."/static/img/portfolio/".$_SESSION['logged_user']->id."/";

			if(!is_dir($dir)) {
				mkdir($dir, 0777, true);
			}

			function can_upload($file, $i) {
				if($file['name'][$i] == '')
					return 'Вы не выбрали файл.';

				if($file['size'][$i] == 0)
					return 'Файл слишком большой.';

				$getMime = explode('.', $file['name'][$i]);
				$mime = strtolower(end($getMime));
				$types = array('jpg', 'png', 'gif', 'bmp', 'jpeg');

				if(!in_array($mime, $types))
					return 'Недопустимый тип файла.';

				return true;
			}

			function make_upload($file, $i) {
				$name = mt_rand(0, 100000) . $file['name'][$i];
				move_uploaded_file($_FILES['image']['tmp_name'][$i], $GLOBALS['dir'].$name);
			}
			

		?>

	    <?php

			if(isset($_FILES['image']))
				for($i = 0; $i < count($_FILES['image']['tmp_name']); $i++)
					$check = can_upload($_FILES['image'], $i);

			if($check === true) {
				for($i = 0; $i < count($_FILES['image']['tmp_name']); $i++)
					make_upload($_FILES['image'], $i);
				echo "<strong>Файлы успешно добавлены в портфолио!</strong>";
				header('Location: '.$_SERVER['HTTP_REFERER']);
			} else {
				echo "<strong>$check</strong>";  
			}

	    ?>

		<?php 
			echo "
				<article>
					<h1>$userinfo->name, </h1> <span>$userinfo->age</span>
					<h2>$userinfo->profession</h2>
					<span>$userinfo->city</span>
					<p>$userinfo->about_me</p>
					<a href='$userinfo->url'>Мой проект: $userinfo->url</a>
				</article>
			";
		?>

		<a href="<?php echo $pathIndex.'/templates/edit' ?>">Редактировать общую информацию</a>
	
		<h3>Портфолио: </h3>

		<form method="post" enctype="multipart/form-data">
			<input type="file" name="image[]" multiple>
			<input type="submit" value="Добавить фото в портфолио">
		</form>

		<div id="portfolio">
			<?php 

			  $dir = "../static/img/portfolio/".$_SESSION['logged_user']->id."/";

			  $indir = array_filter(scandir($dir), function($item) {
			    return !is_dir($dir . $item);
			  });

			  foreach ($indir as $file) 
			    $files[$file] = filemtime("$dir/$file");

			  if (!empty($files))
			  {
			  	arsort($files); $files = array_keys($files);
			    foreach ($files as $value)
			    	echo '<img src="'.$dir.$value.'" alt="" width="150px" height="150px">';
			  }
			  else
			    echo "Файлов нет";
			?>

		</div>

		<script>
			$("#account").css("color", "#333333");
		</script>

	</body>
</html>