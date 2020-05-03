<?php
	$pathIndex = "/app";
	require $_SERVER['DOCUMENT_ROOT'].$pathIndex."/static/php/db_connect.php";

	unset($_SESSION['logged_user']);
	header('Location: '.$pathIndex);
?>

