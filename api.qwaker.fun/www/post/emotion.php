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
	if ($type == 'like' or $type == 'dislike' or $type == 'heart' or $type == 'respect' or $type == 'shit') {} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_emotion_unknown",
			"type" => "error", 
			"task" => "emotion:unknown", 
			"camp" => "server", 
			"message" => 'Вы не можете использовать эту эмоцию. Оставьте другую!',
			"time" => $serverTIME
		)));
		exit();
	}
?>
<?php
	$check_my_emotion = mysqli_query($connect, "SELECT * FROM `post_emotions` WHERE `pid` = '$post_id' AND `uid` = '$user_id' AND `type` = '$type' LIMIT 1");
	if (mysqli_num_rows($check_my_emotion) > 0) {
		if (mysqli_query($connect, "DELETE FROM `post_emotions` WHERE `pid` = '$post_id' AND `uid` = '$user_id' AND `type` = '$type'")) {
			echo normJsonStr(json_encode(array(
				"id" => "id_emotion_delete_".$type."_success",
				"type" => "success", 
				"task" => "emotion:delete:".$type.":success", 
				"camp" => "server", 
				"message" => 'Вы отменили свою эмоцию!',
				"time" => $serverTIME
			)));
			exit();
		}
	} else {
		if (mysqli_query($connect, "INSERT INTO `post_emotions`(`pid`, `uid`, `type`, `date_pub`) VALUES ('$post_id', '$user_id', '$type', '$serverTIME')")) {
			echo normJsonStr(json_encode(array(
				"id" => "id_emotion_set_".$type."_success",
				"type" => "success", 
				"task" => "emotion:set:".$type.":success", 
				"camp" => "server", 
				"message" => 'Вы оставили эмоцию!',
				"time" => $serverTIME
			)));

			if ($post['user_id'] == $user['id']) {} else {
				mysqli_query($connect, "INSERT INTO `notifications`(`user_id`, `sender_id`, `type`, `category`, `message`, `message2`, `message3`, `date_public`) VALUES ('$post_user_id', '$user_id', 'post', 'emotion', '$post_id', '$post_message', '$type', '$serverTIME')");
			}

			$check_post_category = mysqli_query($connect, "SELECT * FROM `post_category_favourites` WHERE `uid` = '$user_id' AND `category` = '$post_category' LIMIT 1");
			if (mysqli_num_rows($check_post_category) > 0) {} else {
				if ($post_category == 0 or $post_category == 999) {} else {
					mysqli_query($connect, "INSERT INTO `post_category_favourites`(`uid`, `category`, `time`) VALUES ('$user_id', '$post_category', '$timeUSER')");
				}
			}

			exit();
		}
	}

	echo normJsonStr(json_encode(array(
		"id" => "id_emotion_error",
		"type" => "error", 
		"task" => "emotion:error", 
		"camp" => "server", 
		"message" => 'Ошибка. Повторите попытку позже!',
		"time" => $serverTIME
	)));
	exit();
?>