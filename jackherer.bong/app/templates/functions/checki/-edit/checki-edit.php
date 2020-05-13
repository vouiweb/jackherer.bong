<?php
	
	function checkName($input) { 
		if (strlen($input) < 3 OR strlen($input) > 13) {
			array_push($GLOBALS['errors'], "Имя должно содержать не менее 3, и не более 13 букв!");
		}
		if(!preg_match("/^[a-zA-Zа-яА-Я]+$/ui", $input)) {
		    array_push($GLOBALS['errors'], "Имя должно содержать только буквы русского или английского алфавита!");
		}
	}

	function checkSurname($input) { 
		if (!empty($input)) {
			if (strlen($input) < 4 OR strlen($input) > 15) {
				array_push($GLOBALS['errors'], "Фамилия должна содержать не менее 4, и не более 15 букв!");
			}
			if(!preg_match("/^[a-zA-Zа-яА-Я]+$/ui", $input)) {
			    array_push($GLOBALS['errors'], "Фамилия должна содержать только буквы русского или английского алфавита!");
			}
		}
	}

	function checkAge($input) {
		if (empty($input) OR preg_match("/[^\d]{1}/", $input) OR strlen($input) > 3) {
			array_push($GLOBALS['errors'], "Укажите настоящий возраст!");
		}
		if ($input < 16) {
			array_push($GLOBALS['errors'], "У нашего приложения возрастное ограничение! 16+!");
		}
	}

	function checkCity($input) {
		if(!preg_match("/^[a-zA-Zа-яА-Я]+$/ui",$input) OR strlen($input) / 2 < 3) {
		   array_push($GLOBALS['errors'], "Такого города не существует на нашей карте!");
		}
	}

	function checkProfession($input) {
		if (empty($input)) {
			array_push($GLOBALS['errors'], "Укажите вашу профессию!");
		}
	}

?>