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
	$site = trim(mysqli_real_escape_string($connect, $_POST['site']));
	$social = trim(mysqli_real_escape_string($connect, $_POST['social']));
	$phone = trim(mysqli_real_escape_string($connect, $_POST['phone']));
	$email = trim(mysqli_real_escape_string($connect, $_POST['email']));
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
	if (trim($site) == '' and mb_strlen($site, 'utf8') == 0) {} else {
		if (!filter_var($site, FILTER_VALIDATE_URL)) {
			echo normJsonStr(json_encode(array(
				"id" => "id_url_site_unvalid",
				"type" => "error", 
				"task" => "user:edit:url-site", 
				"camp" => "user", 
				"message" => 'Что-то не так с ссылкой на сайт!',
				"error_value" => $site,
				"time" => $serverTIME
			)));
			exit();
		}
	}

	if (trim($social) == '' and mb_strlen($social, 'utf8') == 0) {} else {
		if (!filter_var($social, FILTER_VALIDATE_URL)) {
			echo normJsonStr(json_encode(array(
				"id" => "id_url_social_unvalid",
				"type" => "error", 
				"task" => "user:edit:url-social", 
				"camp" => "user", 
				"message" => 'Что-то не так с ссылкой на соц. сеть!',
				"error_value" => $social,
				"time" => $serverTIME
			)));
			exit();
		}
	}

	if (trim($phone) == '' and mb_strlen($phone, 'utf8') == 0) {} else {
		if (!filter_var($phone, FILTER_SANITIZE_NUMBER_INT)) {
			echo normJsonStr(json_encode(array(
				"id" => "id_url_phone_unvalid",
				"type" => "error", 
				"task" => "user:edit:url-phone", 
				"camp" => "user", 
				"message" => 'Что-то не так с номером телефона!',
				"error_value" => $phone,
				"time" => $serverTIME
			)));
			exit();
		}
	}

	if (trim($email) == '' and mb_strlen($email, 'utf8') == 0) {} else {
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			echo normJsonStr(json_encode(array(
				"id" => "id_url_email_unvalid",
				"type" => "error", 
				"task" => "user:edit:url-email", 
				"camp" => "user", 
				"message" => 'Что-то не так с почтой!',
				"error_value" => $email,
				"time" => $serverTIME
			)));
			exit();
		}
	}

	if (mysqli_query($connect, "UPDATE `users` SET `url_site`='$site', `url_social`='$social', `url_phone`='$phone', `url_email`='$email' WHERE `id`='$user_id'")) {
		echo normJsonStr(json_encode(array(
			"id" => "id_edit_success",
			"type" => "success", 
			"task" => "user:edit:success", 
			"camp" => "server", 
			"message" => 'Изменения успешно сохранены!',
			"error_value" => $site.' | '.$social.' | '.$phone.' | '.$email,
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
			"error_value" => $site.' | '.$social.' | '.$phone.' | '.$email,
			"time" => $serverTIME
		)));
		exit();
	}
?>