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

	function encrypt($decrypted, $key) {
		$ekey = hash('SHA256', $key, true);
		srand(); $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC), MCRYPT_RAND);
		if (strlen($iv_base64 = rtrim(base64_encode($iv), '=')) != 22) return false;
		$encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $ekey, $decrypted . md5($decrypted), MCRYPT_MODE_CBC, $iv));
		return $iv_base64 . $encrypted;
	}
?>
<?php
	$token = trim(mysqli_real_escape_string($connect, $_POST['token']));
	$id = intval($_POST['id']);
	$message = trim(mysqli_real_escape_string($connect, $_POST['message']));

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
	$check_dialog_messages = mysqli_query($connect, "SELECT * FROM `dialog_messages` WHERE `id` = '$id' OR `uid` = '$user2_id' LIMIT 1");
	if (mysqli_num_rows($check_dialog_messages) > 0) {
		$dialog_message = mysqli_fetch_assoc($check_dialog_messages);
		$dialog_id = intval($dialog_message['did']);
		
	} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_dialog_send_private_empty",
			"type" => "error", 
			"task" => "dialog:private:send-empty", 
			"camp" => "server", 
			"message" => 'Такого сообщения не существует!',
			"time" => $serverTIME
		)));
		exit();
	}

	$check_dialog = mysqli_query($connect, "SELECT * FROM `dialog` WHERE `id` = '$dialog_id' LIMIT 1");

	if (mysqli_num_rows($check_dialog) > 0) {
		$dialog = mysqli_fetch_assoc($check_dialog);
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

	if (!trim($message)) {
		echo normJsonStr(json_encode(array(
			"id" => "id_dialog_send_message_empty",
			"type" => "error", 
			"task" => "dialog:send:message:empty", 
			"camp" => "user", 
			"message" => 'Сообщение не может быть пустым!',
			"error_value" => $message,
			"time" => $serverTIME
		)));
		exit();
	}

	if (mb_strlen($message, 'utf8') < 1 or mb_strlen($message, 'utf8') > 250) {
		echo normJsonStr(json_encode(array(
			"id" => "id_dialog_send_message_сharset",
			"type" => "error", 
			"task" => "dialog:send:message:сharset", 
			"camp" => "user", 
			"message" => 'Сообщение не может быть короче 1 или длинее 250 смоволов!',
			"error_value" => $message,
			"time" => $serverTIME
		)));
		exit();
	}

	$message = encrypt($message, md5($dialog['key'].$user2['token']));
?>
<?php
	$upd_message = mysqli_query($connect, "UPDATE `dialog_messages` SET `text`='$message' WHERE `id` = '$id' AND `uid` = '$user2_id'");
	if ($upd_message) {
		echo normJsonStr(json_encode(array(
			"id" => "id_dialog_private_edit_success",
			"type" => "success", 
			"task" => "dialog:private:edit:success", 
			"camp" => "server",
			"message" => 'Сообщение успешно изменено!',
			"time" => $serverTIME
		)));
		exit();
	} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_dialog_private_edit_error",
			"type" => "error", 
			"task" => "dialog:private:edit:error", 
			"camp" => "server",
			"message" => 'Что-то пошло не так. Повторите попытку позже!',
			"time" => $serverTIME
		)));
		exit();
	}
?>