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
	$type = trim(mysqli_real_escape_string($connect, $_POST['type']));


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
		$post_category = intval($post['category']);
	} else {
		$check_post = mysqli_query($connect, "SELECT * FROM `posts` WHERE `post_id` = '$id' LIMIT 1");
		if (mysqli_num_rows($check_post) > 0) {
			$post = mysqli_fetch_assoc($check_post);
			$post_id = intval($post['id']);
			$post_user_id = intval($post['user_id']);
			$post_message = strval($post['message']);
			$post_category = intval($post['category']);
		}
	}

	if (mysqli_num_rows($check_post) > 0) {} else {
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
?>
<?php
	$check_emotions = mysqli_query($connect, "SELECT * FROM `post_emotions` WHERE `pid` = '$post_id'");
	if (strlen($type) > 2) {
		$check_emotions = mysqli_query($connect, "SELECT * FROM `post_emotions` WHERE `pid` = '$post_id' AND `type` = '$type'");
	}

	$num_array = mysqli_num_rows($check_emotions);

	echo "[";

	if (mysqli_num_rows($check_emotions) > 0) {


		while($row = mysqli_fetch_assoc($check_emotions)) {
			$userID = $row['uid'];
			$userName = 'unknown';
			$userAVATAR = null;

			$check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '$userID'");
			if (mysqli_num_rows($check_user) > 0) {
				$user = mysqli_fetch_assoc($check_user);
				$userName = $user['nickname'];
				$userAVATAR = $user['avatar'];
			}

			$userARRAY = json_encode(array(
				"id" => intval($userID),
				"nickname" => strval($userName),
				"avatar" => strval($userAVATAR)
			), 128);


			echo json_encode(array(
				"id" => intval($row['id']),
				"type" => strval($row['type']),
				"date_pub" => strval($row['date_pub']),
				"user" => json_decode($userARRAY)
			), 128);

			$num_array = $num_array - 1;
			if ($num_array != 0) {
				echo(',');
			}
		}
	}

	echo "]";
?>