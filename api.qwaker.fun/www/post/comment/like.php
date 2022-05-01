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
	$id = intval(trim(mysqli_real_escape_string($connect, $_POST['id'])));

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
	$check_comment = mysqli_query($connect, "SELECT * FROM `comments` WHERE `id` = '$id' LIMIT 1");
	if (mysqli_num_rows($check_comment) > 0) {
		$comment = mysqli_fetch_assoc($check_comment);
		$pid = $comment['post_id'];
		$uid = $comment['user_id'];
		$cid = $comment['id'];
		$comment_message = $comment['message'];
	} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_comment_empty",
			"type" => "error", 
			"task" => "comment:empty", 
			"camp" => "user", 
			"message" => 'Такого комментария не существует!',
			"error_value" => $id,
			"time" => $serverTIME
		)));
		exit();
	}

	$check_post = mysqli_query($connect, "SELECT * FROM `posts` WHERE `id` = '$pid' LIMIT 1");
	if (mysqli_num_rows($check_post) > 0) {
		$post = mysqli_fetch_assoc($check_post);
		$post_id = intval($post['id']);
		$post_user_id = intval($post['user_id']);
		$post_message = strval($post['message']);
	} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_post_empty",
			"type" => "error", 
			"task" => "post:empty", 
			"camp" => "user", 
			"message" => 'Такой записи не существует!',
			"error_value" => $id,
			"time" => $serverTIME
		)));
		exit();
	}

	$check_blacklist = mysqli_query($connect, "SELECT * FROM `black_list` WHERE `user_blocker` = '$post_user_id' AND `user_blocked` = '$user2_id' LIMIT 1");
	if (mysqli_num_rows($check_blacklist) > 0) {
		echo normJsonStr(json_encode(array(
			"id" => "id_user_blacklist",
			"type" => "error", 
			"task" => "user:blocklist", 
			"camp" => "server", 
			"message" => 'Вы не можете продолжить. Автор публикации добавил Вас в черный список!',
			"time" => $serverTIME
		)));
		exit();
	}

	$check_like = mysqli_query($connect, "SELECT * FROM `comments_likes` WHERE `cid` = '$id' AND `pid` = '$pid' AND `uid` = '$user2_id' LIMIT 1");
	if (mysqli_num_rows($check_like) > 0) {
		if (mysqli_query($connect, "DELETE FROM `comments_likes` WHERE `cid` = '$id' AND `pid` = '$pid' AND `uid` = '$user2_id'")) {
			echo normJsonStr(json_encode(array(
				"id" => "id_comment_unliked",
				"type" => "success", 
				"task" => "comment:unliked", 
				"camp" => "server", 
				"message" => 'Вам больше не нравится этот комментарий!',
				"time" => $serverTIME
			)));
			exit();
		} else {
			echo normJsonStr(json_encode(array(
				"id" => "id_comment_unliked_error",
				"type" => "error", 
				"task" => "comment:unliked:error", 
				"camp" => "server", 
				"message" => 'Ошибка. Попробуйте позже!',
				"time" => $serverTIME
			)));
			exit();
		}
	} else {
		if (mysqli_query($connect, "INSERT INTO `comments_likes`(`uid`, `pid`, `cid`, `time`) VALUES ('$user2_id', '$pid', '$id', '$timeUSER')")) {
			echo normJsonStr(json_encode(array(
				"id" => "id_comment_liked",
				"type" => "success", 
				"task" => "comment:liked", 
				"camp" => "server", 
				"message" => 'Вам нравится этот комментарий!',
				"time" => $serverTIME
			)));

			if ($user2_id == $uid) {} else {
				mysqli_query($connect, "INSERT INTO `notifications`(`user_id`, `sender_id`, `type`, `category`, `message`, `message2`, `message3`, `date_public`) VALUES ('$uid', '$user2_id', 'comment', 'like', '$pid', '$cid', '$comment_message', '$serverTIME')");
			}
			exit();
		} else {
			echo normJsonStr(json_encode(array(
				"id" => "id_comment_liked_error",
				"type" => "error", 
				"task" => "comment:liked:error", 
				"camp" => "server", 
				"message" => 'Ошибка. Попробуйте позже!',
				"time" => $serverTIME
			)));
			exit();
		}
	}
?>