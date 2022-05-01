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
	$id = trim(mysqli_real_escape_string($connect, $_POST['id']));

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
	$check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '$id' LIMIT 1");
	if (mysqli_num_rows($check_user) > 0) {
		$user = mysqli_fetch_assoc($check_user);
		$user_id = intval($user['id']);
	} else {
		$check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `login` = '$id' LIMIT 1");
		if (mysqli_num_rows($check_user) > 0) {
			$user = mysqli_fetch_assoc($check_user);
			$user_id = intval($user['id']);
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
	if (mysqli_num_rows($check_user) > 0) {} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_user_empty",
			"type" => "error", 
			"task" => "user:follow:reject:user-empty", 
			"camp" => "user", 
			"message" => 'Такого пользователя не существует!',
			"error_value" => $id,
			"time" => $serverTIME
		)));
		exit();
	}

	$check_follow = mysqli_query($connect, "SELECT * FROM `follows` WHERE `follower_id` = '$user_id' AND `followed_id` = '$user2_id' AND `confirm` = 0 LIMIT 1");
	if (mysqli_num_rows($check_follow) > 0) {} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_follow_user_no",
			"type" => "error", 
			"task" => "user:follow:reject:no", 
			"camp" => "user", 
			"message" => 'Этот пользователь не ожидает вашего действия!',
			"error_value" => $id,
			"time" => $serverTIME
		)));
		exit();
	}

	if (mysqli_query($connect, "DELETE FROM `follows` WHERE `follower_id` = '$user_id' AND `followed_id` = '$user2_id' AND `confirm` = 0")) {
		echo normJsonStr(json_encode(array(
			"id" => "id_follow_reject_success",
			"type" => "success", 
			"task" => "user:follow:reject:success", 
			"camp" => "server", 
			"message" => 'Отлично. Вы отклонили запрос на подписку пользвателя "@'.$user['login'].'"!',
			"error_value" => $id,
			"time" => $serverTIME
		)));

		mysqli_query($connect, "INSERT INTO `notifications`(`user_id`, `sender_id`, `type`, `category`, `date_public`) VALUES ('$user_id', '$user2_id', 'follow', 'reject', '$serverTIME')");

		exit();
	} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_follow_reject_error",
			"type" => "error", 
			"task" => "user:follow:reject:error", 
			"camp" => "server", 
			"message" => 'Произошла ошибка. Нам не удалось отклонить подписку!',
			"error_value" => $id,
			"time" => $serverTIME
		)));
		exit();
	}
?>