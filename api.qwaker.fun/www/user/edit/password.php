<?php
	header('Access-Control-Allow-Origin: *');
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
	function normJsonStr($str){
	    $str = preg_replace_callback('/\\\\u([a-f0-9]{4})/i', create_function('$m345', 'return chr(hexdec($m345[1])-1072+224);'), $str);
	    return iconv('cp1251', 'utf-8', $str);
	}
?>
<?php
	$token = trim(mysqli_real_escape_string($connect, $_POST['token']));
	$password_old = trim(mysqli_real_escape_string($connect, $_POST['po']));
	$password_new = trim(mysqli_real_escape_string($connect, $_POST['pn']));

	$checkSESSION = mysqli_query($connect, "SELECT * FROM `user_sessions` WHERE `sid` = '$token' LIMIT 1");
	if (mysqli_num_rows($checkSESSION) > 0) {
		$session = mysqli_fetch_assoc($checkSESSION);
		$sessionUTOKEN = $session['utoken'];
		$check_u = mysqli_query($connect, "SELECT * FROM `users` WHERE `token_public` = '$sessionUTOKEN' LIMIT 1");
		if (mysqli_num_rows($check_u) > 0) {
			$sUSER = mysqli_fetch_assoc($check_u);
			$token = $sUSER['token'];
		}
	}
?>
<?php
	$check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `token` = '$token' LIMIT 1");
	if (mysqli_num_rows($check_user) > 0) {
		$user = mysqli_fetch_assoc($check_user);
		$user_id = intval($user['id']);

		mysqli_query($connect, "UPDATE `users` SET `online`='$timeUSER' WHERE `id`='$user_id'");
	} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_user_token_empty",
			"type" => "error", 
			"task" => "token:empty", 
			"camp" => "user", 
			"message" => 'Токен должен быть действительным!',
			"error_value" => $token,
			"time" => $serverTIME
		)));
		exit();
	}

	if ($user['banned'] == 1) {
		echo normJsonStr(json_encode(array(
			"id" => "id_user_banned",
			"type" => "error", 
			"task" => "user:banned", 
			"camp" => "server", 
			"message" => 'Аккаунт заблокирован, действие не может быть выполненно!',
			"time" => $serverTIME
		)));
		exit();
	}

	if ($user['type_auth'] == 'site') {} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_user_type_auth",
			"type" => "error", 
			"task" => "user:type-auth", 
			"camp" => "server", 
			"message" => 'Данному аккаунту нельзя применить пароль!',
			"time" => $serverTIME
		)));
		exit();
	}
?>
<?php
	$password_oldMD5 = md5($password_old);
	$password_newMD5 = md5($password_new);

	if (!trim($password_old)) {
		echo normJsonStr(json_encode(array(
			"id" => "id_password_empty",
			"type" => "error", 
			"task" => "user:edit:password", 
			"camp" => "user", 
			"message" => 'Пароль не может быть пустым!',
			"error_value" => $password_oldMD5,
			"time" => $serverTIME
		)));
		exit();
	}

	if (mb_strlen($password_old, 'utf8') < 6 or mb_strlen($password_old, 'utf8') > 50) {
		echo normJsonStr(json_encode(array(
			"id" => "id_password_characters",
			"type" => "error", 
			"task" => "user:edit:password", 
			"camp" => "user", 
			"message" => 'Пароль не может быть короче 6 или длинее 50 символов!',
			"error_value" => $password_oldMD5,
			"time" => $serverTIME
		)));
		exit();
	}

	if (!trim($password_new)) {
		echo normJsonStr(json_encode(array(
			"id" => "id_password_empty",
			"type" => "error", 
			"task" => "user:edit:password", 
			"camp" => "user", 
			"message" => 'Пароль не может быть пустым!',
			"error_value" => $password_newMD5,
			"time" => $serverTIME
		)));
		exit();
	}

	if (mb_strlen($password_new, 'utf8') < 6 or mb_strlen($password_new, 'utf8') > 50) {
		echo normJsonStr(json_encode(array(
			"id" => "id_password_characters",
			"type" => "error", 
			"task" => "user:edit:password", 
			"camp" => "user", 
			"message" => 'Пароль не может быть короче 6 или длинее 50 символов!',
			"error_value" => $password_newMD5,
			"time" => $serverTIME
		)));
		exit();
	}

	if ($password_oldMD5 == $user['password']) {} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_password_incorrect",
			"type" => "error", 
			"task" => "user:edit:password", 
			"camp" => "user", 
			"message" => 'Текущий пароль не совпал с реальным паролем!',
			"error_value" => $password_oldMD5.' | '.$user['password'],
			"time" => $serverTIME
		)));
		exit();
	}

	if (mysqli_query($connect, "UPDATE `users` SET `password`='$password_newMD5', `date_upd_password`='$timeUSER' WHERE `id`='$user_id'")) {
		echo normJsonStr(json_encode(array(
			"id" => "id_password_success",
			"type" => "success", 
			"task" => "user:edit:password:success", 
			"camp" => "server", 
			"message" => 'Пароль успешно обновлен!',
			"error_value" => $password_oldMD5.' | '.$password_newMD5,
			"time" => $serverTIME
		)));
		exit();
	} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_password_error",
			"type" => "error", 
			"task" => "user:edit:password:error", 
			"camp" => "server", 
			"message" => 'Нам не удалось обновить пароль. Повторите попытку позже!',
			"error_value" => $password_oldMD5.' | '.$password_newMD5,
			"time" => $serverTIME
		)));
		exit();
	}
?>