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

	if (mysqli_num_rows($check_user) > 0) {} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_user_empty",
			"type" => "error", 
			"task" => "user:empty", 
			"camp" => "user", 
			"message" => 'Такого пользователя не существует!',
			"error_value" => $id,
			"time" => $serverTIME
		)));
		exit();
	}

	if ($user['banned'] == 1) {
		echo normJsonStr(json_encode(array(
			"id" => "id_user_banned_other",
			"type" => "error", 
			"task" => "user:banned:other", 
			"camp" => "server", 
			"message" => 'Аккаунт пользователя заблокирован, действие не может быть выполненно!',
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
	if ($user2['chat_creating'] == 0) {
		echo normJsonStr(json_encode(array(
			"id" => "id_message_chat_creating",
			"type" => "error", 
			"task" => "message:chat-creating", 
			"camp" => "server", 
			"message" => 'Вам запрещено создавать новые диалоги!',
			"time" => $serverTIME
		)));
		exit();
	}

	$check_dialog = mysqli_query($connect, "SELECT * FROM `dialog` WHERE `uid` = '$user_id' AND `uid2` = '$user2_id' OR `uid2` = '$user_id' AND `uid` = '$user2_id' LIMIT 1");

	$check_blacklist = mysqli_query($connect, "SELECT * FROM `black_list` WHERE `user_blocker` = '$user2_id' AND `user_blocked` = '$user_id' LIMIT 1");
	if (mysqli_num_rows($check_blacklist) > 0) {
		echo normJsonStr(json_encode(array(
			"id" => "id_message_chat_user_block",
			"type" => "error", 
			"task" => "message:chat-user-block", 
			"camp" => "server", 
			"message" => 'Вы не можете написать этому пользователю, Вы добавили его в черный список!',
			"time" => $serverTIME
		)));
		exit();
	}

	$check_blacklist2 = mysqli_query($connect, "SELECT * FROM `black_list` WHERE `user_blocker` = '$user_id' AND `user_blocked` = '$user2_id' LIMIT 1");
	if (mysqli_num_rows($check_blacklist2) > 0) {
		echo normJsonStr(json_encode(array(
			"id" => "id_message_chat_user_block_you",
			"type" => "error", 
			"task" => "message:chat-user-block-you", 
			"camp" => "server", 
			"message" => 'Вы не можете написать этому пользователю, Вас добавили в черный список!',
			"time" => $serverTIME
		)));
		exit();
	}
?>
<?php
	$did = substr(str_shuffle(str_repeat("0123456789QWERTYUIOPASDFGHJKLZXCVBNMabcdefghijklmnopqrstuvwxyz", 30)), 0, 30);
	$key = substr(str_shuffle(str_repeat("0123456789QWERTYUIOPASDFGHJKLZXCVBNMabcdefghijklmnopqrstuvwxyz", 50)), 0, 50);

	if (mysqli_num_rows($check_dialog) > 0) {
		$dialog = mysqli_fetch_assoc($check_dialog);

		echo normJsonStr(json_encode(array(
			"id" => "id_message_dialog_open_success",
			"type" => "success", 
			"task" => "message:dialog-open-success", 
			"camp" => "server",
			"dialog_id" => $dialog['did'],
			"time" => $serverTIME
		)));
		exit();
	}

	if ($user['private_message'] == 0) {
		echo normJsonStr(json_encode(array(
			"id" => "id_message_chat_private_message",
			"type" => "error", 
			"task" => "message:chat-private-message", 
			"camp" => "server", 
			"message" => 'Пользователь запретил начинать личную переписку с ним!',
			"time" => $serverTIME
		)));
		exit();
	}

	$create_dialog = mysqli_query($connect, "INSERT INTO `dialog`(`did`, `uid`, `uid2`, `date`, `date2`, `key`) VALUES ('$did', '$user_id', '$user2_id', '$serverTIME', '$timeUSER', '$key')");
	if ($create_dialog) {
		echo normJsonStr(json_encode(array(
			"id" => "id_message_dialog_created_success",
			"type" => "success", 
			"task" => "message:dialog-created-success", 
			"camp" => "server",
			"dialog_id" => $did,
			"time" => $serverTIME
		)));
		exit();
	} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_message_dialog_created_error",
			"type" => "error", 
			"task" => "message:dialog-created-error", 
			"camp" => "server",
			"message" => 'Нам не удалось создать новый диалог. Повторите попытку позже!',
			"time" => $serverTIME
		)));
		exit();
	}
?>