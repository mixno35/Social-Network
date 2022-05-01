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
	$id = intval($_POST['id']);
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
	$check_post = mysqli_query($connect, "SELECT * FROM `posts` WHERE `id` = '$id' LIMIT 1");
	if (mysqli_num_rows($check_post) > 0) {
		$post = mysqli_fetch_assoc($check_post);
		$post_id = intval($post['id']);
		$post_user_id = intval($post['user_id']);
		$post_message = strval($post['message']);
		$post_image1 = strval($post['image1']);
		$post_image2 = strval($post['image2']);
		$post_image3 = strval($post['image3']);
	} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_post_empty",
			"type" => "error", 
			"task" => "post:empty", 
			"camp" => "user", 
			"message" => 'Такого поста нет!',
			"error_value" => $id,
			"time" => $serverTIME
		)));
		exit();
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

	if ($user['report_posts'] == 0) {
		echo normJsonStr(json_encode(array(
			"id" => "id_user_report_post",
			"type" => "error", 
			"task" => "user:report-post", 
			"camp" => "server", 
			"message" => 'Вам запрещено отправлять новые жалобы. Обратитесь в поддержку!',
			"time" => $serverTIME
		)));
		exit();
	}
?>
<?php
	$check_report = mysqli_query($connect, "SELECT * FROM `reports_post` WHERE `user_id` = '$user_id' AND `post_id` = '$post_id' LIMIT 1");
	if (mysqli_num_rows($check_report) > 0) {
		echo normJsonStr(json_encode(array(
			"id" => "id_post_report_sended",
			"type" => "error", 
			"task" => "post:report:sended", 
			"camp" => "server", 
			"message" => 'Вы уже пожаловались на этот пост!',
			"time" => $serverTIME
		)));
		exit();
	}

	if ($data == 'spam' or $data == 'scam' or $data == 'violence' or $data == '18plus' or $data == 'ads' or $data == 'propaganda' or $data == 'lgbt' or $data == 'maral') {} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_post_report_data",
			"type" => "error", 
			"task" => "post:report:data", 
			"camp" => "server", 
			"message" => 'Тема жалобы выбрана неверено. Попробуйте выбрать другую!',
			"time" => $serverTIME
		)));
		exit();
	}

	$public_report = mysqli_query($connect, "INSERT INTO `reports_post`(`post_id`, `user_id`, `message`, `data`, `date_reported`, `post_message`, `post_image1`, `post_image2`, `post_image3`) VALUES ('$post_id', '$user_id', '$message', '$data', '$serverTIME', '$post_message', '$post_image1', '$post_image2', '$post_image3')");
	if ($public_report) {
		echo normJsonStr(json_encode(array(
			"id" => "id_post_report_success",
			"type" => "success", 
			"task" => "post:report:success", 
			"camp" => "server", 
			"message" => 'Жалоба успешно отправлена. Ожидайте ответа от администрации!',
			"time" => $serverTIME
		)));
		exit();
	} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_post_report_error",
			"type" => "error", 
			"task" => "post:report:error", 
			"camp" => "server", 
			"message" => 'Нам не удалось отправить жалобу на этот пост. Повторите попытку позже!..',
			"time" => $serverTIME
		)));
		exit();
	}
?>