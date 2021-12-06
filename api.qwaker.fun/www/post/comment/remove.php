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
	$post_id = intval(trim(mysqli_real_escape_string($connect, $_POST['post_id'])));
	$id = intval(trim(mysqli_real_escape_string($connect, $_POST['id'])));
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
	$check_cm1 = mysqli_query($connect, "SELECT * FROM `comments` WHERE `id` = '$id' AND `user_id` = '$user2_id' LIMIT 1");
	if (mysqli_num_rows($check_cm1) > 0) {} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_post_comment_remove_not_you_comment",
			"type" => "error", 
			"task" => "post:comment:remove", 
			"camp" => "user", 
			"message" => 'Вы не можете удалить этот комментарий!',
			"time" => $serverTIME
		)));
		exit();
	}

	if (mysqli_query($connect, "DELETE FROM `comments` WHERE `id` = '$id' AND `user_id` = '$user2_id'")) {
		echo normJsonStr(json_encode(array(
			"id" => "id_post_comment_remove_success",
			"type" => "success", 
			"task" => "post:comment:remove", 
			"camp" => "server", 
			"message" => 'Комментарий успешно удален!',
			"time" => $serverTIME
		)));
		exit();
	} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_post_comment_remove_error",
			"type" => "error", 
			"task" => "post:comment:remove", 
			"camp" => "server", 
			"message" => 'Нам не удалось удалить комментарий. Повторите попытку позже!',
			"time" => $serverTIME
		)));
		exit();
	}
?>