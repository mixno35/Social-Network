<?php
	header('Access-Control-Allow-Origin: *');
	header('Vary: Accept-Encoding, Origin');
	header('Content-Length: 235');
	header('Keep-Alive: timeout=2, max=99');
	header('Access-Control-Allow-Methods: GET');
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
	$data = trim(mysqli_real_escape_string($connect, $_POST['data']));
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

	sleep(0.2);

	if (mysqli_num_rows($check_user) > 0) {} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_report_user_empty",
			"type" => "error", 
			"task" => "report:user:empty", 
			"camp" => "user", 
			"message" => 'Такого пользователя не существует!',
			"error_value" => $id,
			"time" => $serverTIME
		)));
		exit();
	}
?>
<?php
	if ($data == 'spam' or $data == 'scam' or $data == 'violence' or $data == '18plus' or $data == 'offense' or $data == 'harassment' or $data == 'ads' or $data == 'propaganda') {} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_user_report_data",
			"type" => "error", 
			"task" => "user:report:data", 
			"camp" => "server", 
			"message" => 'Тема жалобы выбрана неверено. Попробуйте выбрать другую!',
			"time" => $serverTIME
		)));
		exit();
	}

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

	if ($user2['report_posts'] == 0) {
		echo normJsonStr(json_encode(array(
			"id" => "id_user_report_post",
			"type" => "error", 
			"task" => "user:report-user", 
			"camp" => "server", 
			"message" => 'Вам запрещено отправлять новые жалобы. Обратитесь в поддержку!',
			"time" => $serverTIME
		)));
		exit();
	}
?>
<?php
	$check_report = mysqli_query($connect, "SELECT * FROM `reports_user` WHERE `user_id` = '$user2_id' AND `rep_id` = '$user_id' LIMIT 1");
	if (mysqli_num_rows($check_report) > 0) {
		echo normJsonStr(json_encode(array(
			"id" => "id_user_report_sended",
			"type" => "error", 
			"task" => "user:report:sended", 
			"camp" => "server", 
			"message" => 'Вы уже пожаловались на этого пользователя!',
			"time" => $serverTIME
		)));
		exit();
	}

	if ($data == 'spam' or $data == 'scam' or $data == 'violence' or $data == '18plus' or $data == 'lgbt') {} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_user_report_data",
			"type" => "error", 
			"task" => "user:report:data", 
			"camp" => "server", 
			"message" => 'Тема жалобы выбрана неверено. Попробуйте выбрать другую!',
			"time" => $serverTIME
		)));
		exit();
	}

	$public_report = mysqli_query($connect, "INSERT INTO `reports_user`(`rep_id`, `user_id`, `message`, `data`, `date_reported`) VALUES ('$user_id', '$user2_id', '$message', '$data', '$serverTIME')");
	if ($public_report) {
		echo normJsonStr(json_encode(array(
			"id" => "id_user_report_success",
			"type" => "success", 
			"task" => "user:report:success", 
			"camp" => "server", 
			"message" => 'Жалоба успешно отправлена. Ожидайте ответа от администрации!',
			"time" => $serverTIME
		)));
		exit();
	} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_user_report_error",
			"type" => "error", 
			"task" => "user:report:error", 
			"camp" => "server", 
			"message" => 'Нам не удалось отправить жалобу на этого пользователя. Повторите попытку позже!..',
			"time" => $serverTIME
		)));
		exit();
	}
?>