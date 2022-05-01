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
	// $data = trim(mysqli_real_escape_string($connect, $_POST['data']));

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
	if (!filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
		echo normJsonStr(json_encode(array(
			"id" => "id_edit_verify_data",
			"type" => "error", 
			"task" => "edit:verify:unvalid_data", 
			"camp" => "server", 
			"message" => 'Что-то не так с почтой!',
			"time" => $serverTIME
		)));
		exit();
	}

	if ($user['verification'] == 0) {} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_edit_verify_0",
			"type" => "error", 
			"task" => "edit:verify:0", 
			"camp" => "server", 
			"message" => 'Вы уже отправили заявку или Ваш аккаунт уже верифицирован!',
			"time" => $serverTIME
		)));
		exit();
	}

	if ($user['email_authorization'] == 0) {
		echo normJsonStr(json_encode(array(
			"id" => "id_edit_verify_email_auth",
			"type" => "error", 
			"task" => "edit:verify:email_auth", 
			"camp" => "server", 
			"message" => 'Вы должны включить двухэтапную аутентификацию!',
			"time" => $serverTIME
		)));
		exit();
	}

	$check_followers = mysqli_query($connect, "SELECT * FROM `follows` WHERE `followed_id` = '$user_id' AND `confirm` = 1");
	if (mysqli_num_rows($check_followers) > 999) {} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_edit_verify_followed",
			"type" => "error", 
			"task" => "edit:verify:followed", 
			"camp" => "server", 
			"message" => 'У вас недостаточно подписчиков!',
			"time" => $serverTIME
		)));
		exit();
	}

	$check_following = mysqli_query($connect, "SELECT * FROM `follows` WHERE `follower_id` = '$user_id' AND `confirm` = 1");
	if (mysqli_num_rows($check_following) > 19) {} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_edit_verify_following",
			"type" => "error", 
			"task" => "edit:verify:following", 
			"camp" => "server", 
			"message" => 'Вам стоит подписаться на болеше аккаунтов!',
			"time" => $serverTIME
		)));
		exit();
	}

	if (mysqli_query($connect, "UPDATE `users` SET `verification`=1, `date_verification`='$serverTIME', `url_social`='$data' WHERE `id`='$user_id'")) {
		echo normJsonStr(json_encode(array(
			"id" => "id_edit_verify_seccess",
			"type" => "success", 
			"task" => "edit:verify:success", 
			"camp" => "server", 
			"message" => 'Отлично! Ваш аккаунт верифицирован.',
			"time" => $serverTIME
		)));
		exit();
	} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_edit_verify_error",
			"type" => "error", 
			"task" => "edit:verify:error", 
			"camp" => "server", 
			"message" => 'Что-то пошло не так, попробуйте позже!',
			"time" => $serverTIME
		)));
		exit();
	}
?>