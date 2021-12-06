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
	$online = trim(mysqli_real_escape_string($connect, $_POST['online']));
	$private = trim(mysqli_real_escape_string($connect, $_POST['private']));
	$email_auth = trim(mysqli_real_escape_string($connect, $_POST['email_auth']));
	$show_url = trim(mysqli_real_escape_string($connect, $_POST['show_url']));
	$find_me = trim(mysqli_real_escape_string($connect, $_POST['find_me']));
	$private_message = trim(mysqli_real_escape_string($connect, $_POST['private_message']));
	$restore_password = trim(mysqli_real_escape_string($connect, $_POST['restore_password']));
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
?>
<?php
	if ($online == 'true' or $online == 'false') {} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_online_edit_unvalid",
			"type" => "error", 
			"task" => "user:edit:online", 
			"camp" => "user", 
			"message" => 'Недопустимое значение для функции: [online]!',
			"error_value" => $online,
			"time" => $serverTIME
		)));
		exit();
	}
	if ($private == 'true' or $private == 'false') {} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_private_edit_unvalid",
			"type" => "error", 
			"task" => "user:edit:private", 
			"camp" => "user", 
			"message" => 'Недопустимое значение для функции: [private]!',
			"error_value" => $private,
			"time" => $serverTIME
		)));
		exit();
	}
	if ($email_auth == 'true' or $email_auth == 'false') {} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_email_auth_edit_unvalid",
			"type" => "error", 
			"task" => "user:edit:email_auth", 
			"camp" => "user", 
			"message" => 'Недопустимое значение для функции: [email_auth]!',
			"error_value" => $email_auth,
			"time" => $serverTIME
		)));
		exit();
	}
	if ($email_auth == 'true') {
		if (!filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
			echo normJsonStr(json_encode(array(
				"id" => "id_email_unvalid_auth",
				"type" => "error", 
				"task" => "user:edit:email", 
				"camp" => "user", 
				"message" => 'Двухэтапная аутентификация не может быть включена, по причине: Почта указана неверно. Формат почты должен быть таким: [email@email.com]!',
				"error_value" => $user['email'],
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
				"message" => 'Данному аккаунту нельзя включить двухэтапную аутентификацию!',
				"time" => $serverTIME
			)));
			exit();
		}
	}
	if ($show_url == 'true' or $show_url == 'false') {} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_private_edit_unvalid",
			"type" => "error", 
			"task" => "user:edit:show_url", 
			"camp" => "user", 
			"message" => 'Недопустимое значение для функции: [show_url]!',
			"error_value" => $show_url,
			"time" => $serverTIME
		)));
		exit();
	}

	if ($find_me == 'true' or $find_me == 'false') {} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_private_edit_unvalid",
			"type" => "error", 
			"task" => "user:edit:find_me", 
			"camp" => "user", 
			"message" => 'Недопустимое значение для функции: [find_me]!',
			"error_value" => $find_me,
			"time" => $serverTIME
		)));
		exit();
	}

	if ($restore_password == 'true' or $restore_password == 'false') {} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_private_edit_unvalid",
			"type" => "error", 
			"task" => "user:edit:restore_password", 
			"camp" => "user", 
			"message" => 'Недопустимое значение для функции: [restore_password]!',
			"error_value" => $restore_password,
			"time" => $serverTIME
		)));
		exit();
	}

	if ($private_message == 'true' or $private_message == 'false') {} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_private_edit_unvalid",
			"type" => "error", 
			"task" => "user:edit:private_message", 
			"camp" => "user", 
			"message" => 'Недопустимое значение для функции: [private_message]!',
			"error_value" => $private_message,
			"time" => $serverTIME
		)));
		exit();
	}

	if ($online == 'true') {
		$online = 1;
	} if ($online == 'false') {
		$online = 0;
	} 

	if ($private == 'true') {
		$private = 1;
	} if ($private == 'false') {
		$private = 0;
	} 

	if ($email_auth == 'true') {
		$email_auth = 1;
	} if ($email_auth == 'false') {
		$email_auth = 0;
	}

	if ($show_url == 'true') {
		$show_url = 1;
	} if ($show_url == 'false') {
		$show_url = 0;
	} 

	if ($find_me == 'true') {
		$find_me = 1;
	} if ($find_me == 'false') {
		$find_me = 0;
	} 

	if ($private_message == 'true') {
		$private_message = 1;
	} if ($private_message == 'false') {
		$private_message = 0;
	} 

	if ($restore_password == 'true') {
		$restore_password = 1;
	} if ($restore_password == 'false') {
		$restore_password = 0;
	} 

	if ($user['verification'] == 1) {
		if ($email_auth == 1) {} else {
			echo normJsonStr(json_encode(array(
				"id" => "id_email_auth_edit_verify",
				"type" => "error", 
				"task" => "user:edit:email_auth:verify", 
				"camp" => "user", 
				"message" => 'Ваш аккаунт верифицирован. Вы не можете отключить двухэтапную аутентификацию!',
				"error_value" => $email_auth,
				"time" => $serverTIME
			)));
			exit();
		}
	}

	if (mysqli_query($connect, "UPDATE `users` SET `show_online`='$online', `private`='$private', `email_authorization`='$email_auth', `show_url`='$show_url', `find_me`='$find_me', `private_message`='$private_message', `restore_password`='$restore_password' WHERE `id`='$user_id'")) {
		echo normJsonStr(json_encode(array(
			"id" => "id_edit_success",
			"type" => "success", 
			"task" => "user:edit:success", 
			"camp" => "server", 
			"message" => 'Изменения успешно сохранены!',
			"error_value" => $online.' | '.$private.' | '.$email_auth.' | '.$show_url.' | '.$find_me.' | '.$private_message.' | '.$restore_password,
			"time" => $serverTIME
		)));
		exit();
	} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_edit_error",
			"type" => "error", 
			"task" => "user:edit:error", 
			"camp" => "server", 
			"message" => 'Нам не удалось сохранить изменения. Повторите попытку позже!',
			"error_value" => $online.' | '.$private.' | '.$email_auth.' | '.$show_url.' | '.$find_me.' | '.$private_message.' | '.$restore_password,
			"time" => $serverTIME
		)));
		exit();
	}
?>