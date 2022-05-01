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
	$title = trim(mysqli_real_escape_string($connect, $_POST['title']));
	$message = trim(mysqli_real_escape_string($connect, $_POST['message']));
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

	if ($user['public_post'] == 0) {
		echo normJsonStr(json_encode(array(
			"id" => "id_user_public_post_off",
			"type" => "error", 
			"task" => "user:public-post-off", 
			"camp" => "server", 
			"message" => 'Вам запрещено публиковать новые записи!',
			"time" => $serverTIME
		)));
		exit();
	}

	if (!trim($title)) {} else {
		if (mb_strlen($title, 'utf8') > 50) {
			echo normJsonStr(json_encode(array(
				"id" => "id_post_title_characters",
				"type" => "error", 
				"task" => "post:new:title", 
				"camp" => "user", 
				"message" => 'Заголовок записи не должен превышать 50 символов!',
				"error_value" => $title,
				"time" => $serverTIME
			)));
			exit();
		}
	}

	if (!trim($message)) {
		echo normJsonStr(json_encode(array(
			"id" => "id_post_message_empty",
			"type" => "error", 
			"task" => "post:new:message", 
			"camp" => "user", 
			"message" => 'Комментарий не должен быть пустой!',
			"error_value" => $message,
			"time" => $serverTIME
		)));
		exit();
	}

	if (mb_strlen($message, 'utf8') < 1 or mb_strlen($message, 'utf8') > 500) {
		echo normJsonStr(json_encode(array(
			"id" => "id_post_message_characters",
			"type" => "error", 
			"task" => "post:new:message", 
			"camp" => "user", 
			"message" => 'Комментарий записи не должен превышать 500 символов или быть меньше 1 символа!',
			"error_value" => $message,
			"time" => $serverTIME
		)));
		exit();
	}

	if (mysqli_query($connect, "UPDATE `posts` SET `title`='$title', `message`='$message' WHERE `id`='$id' AND `user_id` = '$user_id' AND `creator_id` = '$user_id'")) {
		echo normJsonStr(json_encode(array(
			"id" => "id_post_success_public_edit",
			"type" => "success", 
			"task" => "post:edit:success", 
			"camp" => "server", 
			"message" => 'Запись успешно обновлена!',
			"post_id" => $post_id,
			"time" => $serverTIME
		)));
		exit();
	} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_post_error_public_edit",
			"type" => "error", 
			"task" => "post:edit:error", 
			"camp" => "server", 
			"message" => 'Ошибка публикации записи. Повторите попытку позже...',
			"error_value" => $token.' -> '.$title.' -> '.$message,
			"time" => $serverTIME
		)));
		exit();
	}
?>