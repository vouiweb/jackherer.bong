<!-- <link rel="stylesheet" href="<?php // echo $pathIndex.'/static/css/header/header.css' ?>"> -->

<header>
	<h1><a href="/">Tinder #2 - Придумать название!</a></h1>
	<nav>
		<?php if ( isset($_SESSION['logged_user']) ) : ?>
			<a href="<?php echo $pathIndex.'/templates/account' ?>">Личный Кабинет</a>
			<a href="<?php echo $pathIndex.'/templates/logout' ?>">Выход</a>
		<?php else : ?> 
			<a href="<?php echo $pathIndex.'/templates/login' ?>" id="login">Авторизация</a>
			<a href="<?php echo $pathIndex.'/templates/signup' ?>" id="registration">Регистрация</a>
		<?php endif; ?>
	</nav>
</header>

<!-- <script src="<?php // echo $pathIndex.'/static/js/header/header.js' ?>"></script> -->