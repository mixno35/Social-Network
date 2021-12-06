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
?>
<?php
	$check_post = mysqli_query($connect, "SELECT * FROM `posts` WHERE `id` = '$id' LIMIT 1");
	if (mysqli_num_rows($check_post) > 0) {
		$post = mysqli_fetch_assoc($check_post);
		$post_id = intval($post['id']);
		$post_user_id = intval($post['user_id']);
		$post_message = strval($post['message']);
	} else {
		$check_post = mysqli_query($connect, "SELECT * FROM `posts` WHERE `post_id` = '$id' LIMIT 1");
		if (mysqli_num_rows($check_post) > 0) {
			$post = mysqli_fetch_assoc($check_post);
			$post_id = intval($post['id']);
			$post_user_id = intval($post['user_id']);
			$post_message = strval($post['message']);
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
	if (mysqli_num_rows($check_post) == 0) {
		echo normJsonStr(json_encode(array(
			"id" => "id_post_empty",
			"type" => "error", 
			"task" => "post:remove:empty", 
			"camp" => "user", 
			"message" => 'Такой записи не существует!',
			"error_value" => $id,
			"time" => $serverTIME
		)));
		exit();
	}

	if ($user_id == $post_user_id) {} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_post_empty",
			"type" => "error", 
			"task" => "post:archive:empty2", 
			"camp" => "user", 
			"message" => 'Ошибка доступа к записи!',
			"error_value" => $id,
			"time" => $serverTIME
		)));
		exit();
	}
?>
<?php
	if (mysqli_query($connect, "UPDATE `posts` SET `date_view`=0 WHERE `user_id`='$user_id' AND `id`='$id'")) {
		echo normJsonStr(json_encode(array(
			"id" => "id_post_deffred_public_success",
			"type" => "success", 
			"task" => "post:deffred-public:success", 
			"camp" => "server", 
			"message" => 'Запись успешно опубликована!',
			"error_value" => $id,
			"time" => $serverTIME
		)));
		exit();
	} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_post_deffred_public_error",
			"type" => "error", 
			"task" => "post:deffred-public:error", 
			"camp" => "server", 
			"message" => 'Нам не удалось опубликовать эту запись. Попробуйте позже!',
			"error_value" => $id,
			"time" => $serverTIME
		)));
		exit();
	}
?>