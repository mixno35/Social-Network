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
	$id = intval($_POST['id']);

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
	$check_user2 = mysqli_query($connect, "SELECT * FROM `users` WHERE `token` = '$token' LIMIT 1");
	if (mysqli_num_rows($check_user2) > 0) {
		$user2 = mysqli_fetch_assoc($check_user2);
		$user2_id = intval($user2['id']);

		mysqli_query($connect, "UPDATE `users` SET `online`='$timeUSER' WHERE `id`='$user2_id'");
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

	if ($user2['banned'] == 1) {
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
	if ($id == 0) {
		if (mysqli_query($connect, "UPDATE `notifications` SET `readed`=1 WHERE `user_id`='$user2_id'")) {
			echo normJsonStr(json_encode(array(
				"id" => "id_notify_read_all_success",
				"type" => "success", 
				"task" => "notification:read:success", 
				"camp" => "server", 
				"message" => 'Все уведомления были прочитаны!',
				"error_value" => $id,
				"time" => $serverTIME
			)));
			exit();
		} else {
			echo normJsonStr(json_encode(array(
				"id" => "id_notify_read_all_error",
				"type" => "error", 
				"task" => "notification:read:error", 
				"camp" => "server", 
				"message" => 'Не удалось прочитать все уведомления. Неизвестная ошибка!',
				"error_value" => $id,
				"time" => $serverTIME
			)));
			exit();
		}
	}

	$check_notify = mysqli_query($connect, "SELECT * FROM `notifications` WHERE `id` = '$id' AND `user_id` = '$user2_id' LIMIT 1");
	if (mysqli_num_rows($check_notify) > 0) {
		$notify = mysqli_fetch_assoc($check_notify);
	} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_notify_read_error_no_notify",
			"type" => "error", 
			"task" => "notification:read:no-notify", 
			"camp" => "server", 
			"message" => 'Такого уведомления нет!',
			"error_value" => $id,
			"time" => $serverTIME
		)));
		exit();
	}

	if (mysqli_query($connect, "UPDATE `notifications` SET `readed`=1 WHERE `user_id`='$user2_id' AND `id`='$id'")) {
		echo normJsonStr(json_encode(array(
			"id" => "id_notify_read_success",
			"type" => "success", 
			"task" => "notification:read:success", 
			"camp" => "server", 
			"message" => 'Уведомление было прочитано!',
			"error_value" => $id,
			"time" => $serverTIME
		)));
		exit();
	} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_notify_read_error",
			"type" => "error", 
			"task" => "notification:read:error", 
			"camp" => "server", 
			"message" => 'Не удалось прочитать уведомление. Неизвестная ошибка!',
			"error_value" => $id,
			"time" => $serverTIME
		)));
		exit();
	}
?>