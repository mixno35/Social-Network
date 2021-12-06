<?php
	header('Access-Control-Allow-Origin: http://qwaker.fun');
	header('Vary: Accept-Encoding, Origin');
	header('Content-Length: 235');
	header('Keep-Alive: timeout=2, max=99');
	header('Access-Control-Allow-Methods: POST');
	header('Access-Control-Allow-Credentials: true');
	header('Access-Control-Max-Age: 604800');
	header('Connection: Keep-Alive');
	header('Content-Type: text/html; charset=utf-8');
?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/data.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php'; ?>
<?php
	function normJsonStr($string){
	    $str = preg_replace_callback('/\\\\u([a-f0-9]{4})/i', create_function('$m345', 'return chr(hexdec($m345[1])-1072+224);'), $string);
	    return iconv('cp1251', 'utf-8', $str);
	}

	function startsWithNumber($string) {
	    return strlen($string) > 0 && ctype_digit(substr($string, 0, 1));
	}

	function detect_cyr_utf8($content) {
		return preg_match('/[^а-яА-ЯёЁa-zA-Z\s]/u', $content);
	}
?>
<?php
	$login = trim(strtolower(mysqli_real_escape_string($connect, $_POST['login'])));
	$name = trim(mysqli_real_escape_string($connect, $_POST['name']));
	$password = trim(mysqli_real_escape_string($connect, $_POST['password']));
	// $invite = trim(mysqli_real_escape_string($connect, $_POST['invite']));

	// $inviteMD5 = md5($invite);

	// Проверяем корректность пригласительного кода................................................
	// $check_invite = mysqli_query($connect, "SELECT * FROM `invites` WHERE `invite` = '$invite' AND `activated` = 0 LIMIT 1");
	// if (mysqli_num_rows($check_invite) > 0) {} else {
	// 	echo normJsonStr(json_encode(array(
	// 		"id" => "id_invite_empty",
	// 		"type" => "error", 
	// 		"task" => "auth:invite:empty", 
	// 		"camp" => "user", 
	// 		"message" => 'Такого пригласительного кода нет или его уже активировали!',
	// 		"error_value" => $invite,
	// 		"time" => $serverTIME
	// 	)));
	// 	exit();
	// }

	// Проверяем является ли значение "login" пустым, если да - запрещаем дальнейшую проверку....................................................
	if (!trim($login)) {
		echo normJsonStr(json_encode(array(
			"id" => "id_login_empty",
			"type" => "error", 
			"task" => "auth:up:login", 
			"camp" => "user", 
			"message" => 'Логин не может быть пустым!',
			"error_value" => $login,
			"time" => $serverTIME
		)));
		exit();
	}

	// Проверяем количество символов в значении "login", если значение не корректное - запрещаем дальнейшую проверку.............................
	if (mb_strlen($login, 'utf8') < 3 or mb_strlen($login, 'utf8') > 15) {
		echo normJsonStr(json_encode(array(
			"id" => "id_login_characters",
			"type" => "error", 
			"task" => "auth:up:login", 
			"camp" => "user", 
			"message" => 'Логин не может быть короче 3 или длинее 15 символов!',
			"error_value" => $login,
			"time" => $serverTIME
		)));
		exit();
	}

	// Проверяем начинается ли значение "login" с цифры, если да - запрещаем дальнейшую проверку.................................................
	if (startsWithNumber($login)) {
		echo normJsonStr(json_encode(array(
			"id" => "id_no_support_login_contains_first_number_value",
			"type" => "error", 
			"task" => "auth:up:login", 
			"camp" => "user", 
			"message" => 'Логин не должен содержать первый символ в виде числа!',
			"error_value" => $login,
			"time" => $serverTIME
		)));
		exit();
	}

	// Проверяем значение "login" на запрещённые символы, если такие имеются - запрещаем дальнейшую проверку.....................................
	if(!preg_match("/^[a-z0-9\d_]+$/", $login)) {
		echo normJsonStr(json_encode(array(
			"id" => "id_contains_symbols_no_support",
			"type" => "error", 
			"task" => "auth:up:login", 
			"camp" => "user", 
			"message" => 'Логин содержит запрещенные символы. Разрешенные символы: [a-z0-9_]!',
			"error_value" => $login,
			"time" => $serverTIME
		)));
		exit();
	}

	// Проверяем пользователя, его существование в базе данных...................................................................................
	$check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `login` = '$login' LIMIT 1");
	if (mysqli_num_rows($check_user) > 0) {
		echo normJsonStr(json_encode(array(
			"id" => "id_login_used",
			"type" => "error", 
			"task" => "auth:up:login", 
			"camp" => "user", 
			"message" => "Текущий логин уже используется!",
			"error_value" => $login,
			"time" => $serverTIME
		)));
		exit();
	}



	// Проверяем значение "name" если все ок - продолжаем........................................................................................
	if (trim($name) == '' and mb_strlen($name, 'utf8') == 0) {} else {
		if(detect_cyr_utf8($name)) {
			echo normJsonStr(json_encode(array(
				"id" => "id_name_cyr_failed",
				"type" => "error", 
				"task" => "auth:up:name", 
				"camp" => "user", 
				"message" => 'Имя не должно содержать запрещенные смволы. Доступные символы [A-Za-zА-Яа-я ]!',
				"error_value" => $name,
				"time" => $serverTIME
			)));
			exit();
		}
		if (mb_strlen($name, 'utf8') < 4 or mb_strlen($name, 'utf8') > 20) {
			echo normJsonStr(json_encode(array(
				"id" => "id_name_characters",
				"type" => "error", 
				"task" => "auth:up:name", 
				"camp" => "user", 
				"message" => 'Имя не может быть короче 4 или длинее 20 символов!',
				"error_value" => $name,
				"time" => $serverTIME
			)));
			exit();
		}
	}



	// Проверяем значение "ip" если все ок - продолжаем........................................................................................
	$check_user_ip = mysqli_query($connect, "SELECT * FROM `users` WHERE `ip` = '$userIP' LIMIT 1");
	if (mysqli_num_rows($check_user_ip) > 0) {
		echo normJsonStr(json_encode(array(
			"id" => "id_ip_used",
			"type" => "error", 
			"task" => "auth:up:ip", 
			"camp" => "user", 
			"message" => 'На данный IP-адрес уже был зарегистрирован аккаунт!',
			"error_value" => $userIP,
			"time" => $serverTIME
		)));
		exit();
	}



	$passwordMD5 = md5($password);



	// Проверяем является ли значение "password" пустым, если да - запрещаем дальнейшую проверку.................................................
	if (!trim($password)) {
		echo normJsonStr(json_encode(array(
			"id" => "id_password_empty",
			"type" => "error", 
			"task" => "auth:up:password", 
			"camp" => "user", 
			"message" => 'Пароль не может быть пустым!',
			"error_value" => $passwordMD5,
			"time" => $serverTIME
		)));
		exit();
	}

	// Проверяем количество символов в значении "password", если значение не корректное - запрещаем дальнейшую проверку..........................
	if (mb_strlen($password, 'utf8') < 6 or mb_strlen($password, 'utf8') > 50) {
		echo normJsonStr(json_encode(array(
			"id" => "id_password_characters",
			"type" => "error", 
			"task" => "auth:up:password", 
			"camp" => "user", 
			"message" => 'Пароль не может быть короче 6 или длинее 50 символов!',
			"error_value" => $passwordMD5,
			"time" => $serverTIME
		)));
		exit();
	}



	$token = substr(str_shuffle(str_repeat("0123456789QWERTYUIOPASDFGHJKLZXCVBNMabcdefghijklmnopqrstuvwxyz", 70)), 0, 70);
	$tokenMD5 = md5($token);

	$generateINVITECHARS = '0123456789QWERTYUIOPASDFGHJKLZXCVBNM';
	$generateINVITE = substr(str_shuffle(str_repeat($generateINVITECHARS, 4)), 0, 4).'-'.substr(str_shuffle(str_repeat($generateINVITECHARS, 4)), 0, 4).'-'.substr(str_shuffle(str_repeat($generateINVITECHARS, 4)), 0, 4);



	// Регистрируем пользователя.................................................................................................................
	$registation_user = mysqli_query($connect, "INSERT INTO `users`(`nickname`, `login`, `password`, `name`, `language`, `date_registration`, `date_upd_login`, `token`, `token_public`) VALUES ('$login', '$login', '$passwordMD5', '$name', '$userLANGUAGE', '$serverTIME', '$timeUSER', '$token', '$tokenMD5')");
	if ($registation_user) {

		mysqli_query($connect, "UPDATE `invites` SET `date_activated` = '$timeUSER', `activated` = 1, `utoken` = '$tokenMD5' WHERE `invite` = '$inviteMD5'");

		echo normJsonStr(json_encode(array(
			"id" => "id_auth_up_success",
			"type" => "success", 
			"task" => "auth:up:success", 
			"camp" => "auth", 
			"message" => 'Регистрация прошла успешно!',
			"token" => "",
			"time" => $serverTIME
		)));
		exit();
	} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_auth_up_error",
			"type" => "error", 
			"task" => "auth:up:error", 
			"camp" => "auth", 
			"message" => 'Ошибка регистрации, повторите попытку позже!..',
			"error_value" => $login." -> ".$passwordMD5." -> ".$name,
			"time" => $serverTIME
		)));
		exit();
	}
?>