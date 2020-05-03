<?php
	header('Content-Type: text/html; charset=utf-8');
	require $_SERVER['DOCUMENT_ROOT'].$pathIndex."/static/libs/rb-mysql.php";
	R::setup( 'mysql:host=localhost;dbname=jackherer', 'admin', 'ckb7gcm1m4');
	session_start();
?>