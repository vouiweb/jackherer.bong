<?php 

	function checkEmail($input) {
		if (empty($input)) {
	    	array_push($GLOBALS['errors'], "Не заполнено обязательное поле - E-Mail");
	  	} elseif ( filter_var($input, FILTER_VALIDATE_EMAIL) === false) { 
	    	array_push($GLOBALS['errors'], "Формат почтового ящика неправильный");
	  	}
	}

	function checkPassword($input) {
		if (strlen($input) < 7) {
			array_push($GLOBALS['errors'], "Пароль должен иметь длину не менее 7 знаков!");
		}
	}
	
?>