<!-- <link rel="stylesheet" href="<?php // echo $pathIndex.'/static/css/header/header.css' ?>"> -->

<header>
	<h1><a href="<?php echo $pathIndex ?>">Tinder #2 - Придумать название!</a></h1>
	<nav>
		<?php if ( isset($_SESSION['logged_user']) ) : ?>
			<?php
				if (basename($_SERVER['PHP_SELF'], ".php") != "activate")
					{
					if (R::load('userinfo', $_SESSION['logged_user']->id)->name == NULL) {
						if (basename($_SERVER['PHP_SELF'], ".php") != "edit") {
							$url_redirect = $pathIndex.'/templates/edit';
							echo '<script>$(function(){window.location.href = "'.$url_redirect.'";})</script>';
						}
					}
				}
			 ?>
			<a href="<?php echo $pathIndex.'/templates/account' ?>" id="account">Личный Кабинет</a>
			<a href="<?php echo $pathIndex.'/templates/logout' ?>">Выход</a>
		<?php else : ?> 
			<a href="<?php echo $pathIndex.'/templates/login' ?>" id="login">Авторизация</a>
			<a href="<?php echo $pathIndex.'/templates/signup' ?>" id="registration">Регистрация</a>
		<?php endif; ?>
	</nav>
</header>

<!-- <script src="<?php // echo $pathIndex.'/static/js/header/header.js' ?>"></script> -->