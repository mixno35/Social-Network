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

	function detect_cyr_utf8($content) {
		return preg_match('/[^а-яА-ЯёЁa-zA-Z\s]/u', $content);
	}
?>
<?php
	$token = trim(mysqli_real_escape_string($connect, $_POST['token']));
	$name = trim(mysqli_real_escape_string($connect, $_POST['name']));
	$email = trim(mysqli_real_escape_string($connect, $_POST['email']));
	$nickname = trim(strtolower(mysqli_real_escape_string($connect, $_POST['nickname'])));
	$about = trim(strtolower(mysqli_real_escape_string($connect, $_POST['about'])));

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
?>
<?php
	if (trim($name) == '' and mb_strlen($name, 'utf8') == 0) {} else {
		if(detect_cyr_utf8($name)) {
			echo normJsonStr(json_encode(array(
				"id" => "id_name_cyr_failed",
				"type" => "error", 
				"task" => "user:edit:name", 
				"camp" => "user", 
				"message" => 'Имя не должно содержать запрещенные смволы. Доступные символы: [A-Za-zА-Яа-я ]!',
				"error_value" => $name,
				"time" => $serverTIME
			)));
			exit();
		}
		if (mb_strlen($name, 'utf8') < 4 or mb_strlen($name, 'utf8') > 20) {
			echo normJsonStr(json_encode(array(
				"id" => "id_name_characters",
				"type" => "error", 
				"task" => "user:edit:name", 
				"camp" => "user", 
				"message" => 'Имя не может быть короче 4 или длинее 20 символов!',
				"error_value" => $name,
				"time" => $serverTIME
			)));
			exit();
		}
	}

	if (trim($email) == '' and mb_strlen($email, 'utf8') == 0) {} else {
		if (mb_strlen($email, 'utf8') < 8 or mb_strlen($email, 'utf8') > 100) {
			echo normJsonStr(json_encode(array(
				"id" => "id_email_characters",
				"type" => "error", 
				"task" => "user:edit:email", 
				"camp" => "user", 
				"message" => 'Почта не должна быть короче 8 или длинее 100 символов!',
				"error_value" => $email,
				"time" => $serverTIME
			)));
			exit();
		}
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			echo normJsonStr(json_encode(array(
				"id" => "id_email_unvalid",
				"type" => "error", 
				"task" => "user:edit:email", 
				"camp" => "user", 
				"message" => 'Почта указана неверно. Формат почты должен быть таким: [email@email.com]!',
				"error_value" => $email,
				"time" => $serverTIME
			)));
			exit();
		}

		if ($user['email'] == $email) {} else {
			$check_user_email = mysqli_query($connect, "SELECT * FROM `users` WHERE `email` = '$email' LIMIT 1");
			if (mysqli_num_rows($check_user_email) > 0) {
				echo normJsonStr(json_encode(array(
					"id" => "id_email_used",
					"type" => "error", 
					"task" => "user:edit:email", 
					"camp" => "user", 
					"message" => 'Эта почта уже используется!',
					"error_value" => $email,
					"time" => $serverTIME
				)));
				exit();
			}
		}
	}

	if (trim($about) == '' and mb_strlen($about, 'utf8') == 0) {} else {
		if (mb_strlen($about, 'utf8') < 10 or mb_strlen($about, 'utf8') > 150) {
			echo normJsonStr(json_encode(array(
				"id" => "id_about_characters",
				"type" => "error", 
				"task" => "user:edit:about", 
				"camp" => "user", 
				"message" => 'Информация о себе не должная быть короче 10 или длинее 150 символов!',
				"error_value" => $about,
				"time" => $serverTIME
			)));
			exit();
		}
	}

	if (mysqli_query($connect, "UPDATE `users` SET `name`='$name', `email`='$email', `nickname`='$nickname', `about`='$about' WHERE `id`='$user_id'")) {
		echo normJsonStr(json_encode(array(
			"id" => "id_edit_success",
			"type" => "success", 
			"task" => "user:edit:success", 
			"camp" => "server", 
			"message" => 'Изменения успешно сохранены!',
			"time" => $serverTIME
		)));
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			mysqli_query($connect, "UPDATE `users` SET `email_authorization`=0 WHERE `id`='$user_id'");
		}
		exit();
	} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_edit_error",
			"type" => "error", 
			"task" => "user:edit:error", 
			"camp" => "server", 
			"message" => 'Нам не удалось сохранить изменения. Повторите попытку позже!',
			"time" => $serverTIME
		)));
		exit();
	}
?>