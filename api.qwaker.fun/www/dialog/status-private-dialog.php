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
	$status = intval($_POST['status']);

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

	if ($dialog['uid'] == $user2_id or $dialog['uid2'] == $user2_id) {} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_dialog_send_private_empty",
			"type" => "error", 
			"task" => "dialog:private:send-empty", 
			"camp" => "server", 
			"message" => '[2] Такого диалога не существует!',
			"time" => $serverTIME
		)));
		exit();
	}

	if ($status == 1 or $status == 0) {} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_dialog_private_change_status-value",
			"type" => "error", 
			"task" => "dialog:private:change-status-value", 
			"camp" => "server", 
			"message" => 'Неверное значение статуса!',
			"time" => $serverTIME
		)));
		exit();
	}

	if ($dialog['recive'] != $user2_id) {
		echo normJsonStr(json_encode(array(
			"id" => "id_dialog_private_change_status",
			"type" => "error", 
			"task" => "dialog:private:change-status", 
			"camp" => "server", 
			"message" => 'Вы не являетесь получателем. Смена статуса диалога невозможна!',
			"time" => $serverTIME
		)));
		exit();
	}

	$change_status = mysqli_query($connect, "UPDATE `dialog` SET `status`='$status' WHERE `id`='$dialog_id'");
	if ($change_status) {
		// ТАКЖЕ ЧИТАЕМ СООБЩЕНИЯ
		if ($status == 1) {
			mysqli_query($connect, "UPDATE `dialog_messages` SET `status`=1 WHERE `did`='$dialog_id'");
		}
		echo normJsonStr(json_encode(array(
			"id" => "id_dialog_change_status_success",
			"type" => "success", 
			"task" => "dialog:change-status:success", 
			"camp" => "server",
			"message" => 'Статус диалога успешно изменен!',
			"time" => $serverTIME
		)));
		exit();
	} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_dialog_change_status_error",
			"type" => "error", 
			"task" => "dialog:change-status:error", 
			"camp" => "server",
			"message" => 'Что-то пошло не так. Повторите попытку позже!',
			"time" => $serverTIME
		)));
		exit();
	}
?>