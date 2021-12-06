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
		} else {
			$check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `token` = '$id' LIMIT 1");
			if (mysqli_num_rows($check_user) > 0) {
				$user = mysqli_fetch_assoc($check_user);
				$user_id = intval($user['id']);
			}
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
	if ($user_id == $user2_id) {
		echo normJsonStr(json_encode(array(
			"id" => "id_user_block_no_m_block_support",
			"type" => "error", 
			"task" => "user:block:no-m-block-support", 
			"camp" => "user", 
			"message" => 'Вы не можете заблокировать самого себя!',
			"error_value" => $user_id.' | '.$user2_id,
			"time" => $serverTIME
		)));
		exit();
	}

	$check_blocked = mysqli_query($connect, "SELECT * FROM `black_list` WHERE `user_blocker` = '$user2_id' AND `user_blocked` = '$user_id'");
	if (mysqli_num_rows($check_blocked) > 0) {
		$result_fun = 'unblocked';
		$result_sql = mysqli_query($connect, "DELETE FROM `black_list` WHERE `user_blocker` = '$user2_id' AND `user_blocked` = '$user_id'");
		$result_fun2 = 'разблокирован';
	} else {
		$result_fun = 'blocked';
		$result_sql = mysqli_query($connect, "INSERT INTO `black_list`(`user_blocker`, `user_blocked`) VALUES ('$user2_id', '$user_id')");
		$result_fun2 = 'заблокирован';
	}

	if ($result_sql) {
		echo normJsonStr(json_encode(array(
			"id" => "id_user_block_success_".$result_fun,
			"type" => "success", 
			"task" => "user:block:success", 
			"camp" => "server", 
			"message" => 'Пользователь @'.$user['login'].' успешно '.$result_fun2.'!',
			"time" => $serverTIME
		)));
		if ($result_fun == 'blocked') {
			mysqli_query($connect, "DELETE FROM `follows` WHERE `follower_id` = '$user2_id' AND `followed_id` = '$user_id'");
			mysqli_query($connect, "DELETE FROM `follows` WHERE `follower_id` = '$user_id' AND `followed_id` = '$user2_id'");
		}
		exit();
	} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_user_block_error_".$result_fun,
			"type" => "error", 
			"task" => "user:block:error", 
			"camp" => "server", 
			"message" => 'Пользователь @'.$user['login'].' не был '.$result_fun2.' из-за проблем на нашей стороне. Повторите попытку позже!',
			"time" => $serverTIME
		)));
		exit();
	}
?>