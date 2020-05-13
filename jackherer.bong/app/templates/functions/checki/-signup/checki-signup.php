<?php  
	function checkEmailRepeat($input) {
		if(R::count('userpassword', 'email = ?', array($input)) > 0) {
			array_push($GLOBALS['errors'], "Такой E-mail уже используется другим пользователем!");
		}
	}

	function checkPasswordMatch($psw1, $psw2) {
		if ($psw2 != $psw1) {
			array_push($GLOBALS['errors'], "Пароли не совпадают!");
		}
	}
?>