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
	$message_id = trim(mysqli_real_escape_string($connect, $_POST['message_id']));
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
	$check_dialog = mysqli_query($connect, "SELECT * FROM `dialog` WHERE `id` = '$id' OR `did` = '$id' LIMIT 1");
	if (mysqli_num_rows($check_dialog) > 0) {
		$dialog = mysqli_fetch_assoc($check_dialog);
		$dialog_id = $dialog['id'];
		$user_id = 0;
		if ($user2_id == $dialog['uid']) {} else { $user_id = $dialog['uid']; }
		if ($user2_id == $dialog['uid2']) {} else { $user_id = $dialog['uid2']; }
	} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_dialog_send_private_empty",
			"type" => "error", 
			"task" => "dialog:private:send-empty", 
			"camp" => "server", 
			"message" => 'Такого диалога не существует!',
			"time" => $serverTIME
		)));
		exit();
	}

	$check_message = mysqli_query($connect, "SELECT * FROM `dialog_messages` WHERE `id` = '$message_id' AND `did` = '$dialog_id' LIMIT 1");
	if (mysqli_num_rows($check_message) > 0) {
		$message = mysqli_fetch_assoc($check_message);
	}

	if ($message['type'] === 'image') {
		$check_dialog_image = mysqli_query($connect, "SELECT * FROM `dialog_messages` WHERE `did` = '$dialog_id' AND `type` = 'image'");
		if (mysqli_num_rows($check_dialog_image) > 0) {
			while($row = mysqli_fetch_assoc($check_dialog_image)) {
				$user_image_data = $row['source'];
				$check_image_file = mysqli_query($connect, "SELECT * FROM `uploaded_files` WHERE `full_url` = '$user_image_data'");
				if (mysqli_num_rows($check_image_file) > 0) {
					while($row = mysqli_fetch_assoc($check_image_file)) {
						$result_path = str_replace('api.', 'sun.', $_SERVER['DOCUMENT_ROOT']);
						$result_upath = $result_path.$row['short_url'];
						if (unlink($result_upath)) {
							mysqli_query($connect, "DELETE FROM `uploaded_files` WHERE `full_url` = '$user_image_data'");
						}
					}
				}
			}
		}
	}
?>
<?php
	$delete_message = mysqli_query($connect, "DELETE FROM `dialog_messages` WHERE `id`='$message_id' AND `uid`='$user2_id' AND `did`='$dialog_id'");
	if ($delete_message) {
		echo normJsonStr(json_encode(array(
			"id" => "id_dialog_private_delete_success",
			"type" => "success", 
			"task" => "dialog:private:delete:success", 
			"camp" => "server",
			"message" => 'Сообщение успешно удалено!',
			"time" => $serverTIME
		)));
		exit();
	} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_dialog_private_delete_error",
			"type" => "error", 
			"task" => "dialog:private:delete:error", 
			"camp" => "server",
			"message" => 'Что-то пошло не так. Повторите попытку позже!',
			"time" => $serverTIME
		)));
		exit();
	}
?>