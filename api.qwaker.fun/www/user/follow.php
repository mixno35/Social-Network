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
	if (mysqli_num_rows($check_user) > 0 and mysqli_num_rows($check_user2) > 0) {

		$check_blacklist = mysqli_query($connect, "SELECT * FROM `black_list` WHERE `user_blocker` = '$user_id' AND `user_blocked` = '$user2_id' LIMIT 1");
		if (mysqli_num_rows($check_blacklist) > 0) {
			echo normJsonStr(json_encode(array(
				"id" => "id_user_blacklist",
				"type" => "error", 
				"task" => "user:blocklist", 
				"camp" => "server", 
				"message" => 'Вы не можете продолжить. Пользователь добавил Вас в черный список!',
				"time" => $serverTIME
			)));
			exit();
		}

		$check_follow = mysqli_query($connect, "SELECT * FROM `follows` WHERE `follower_id` = '$user2_id' AND `followed_id` = '$user_id' LIMIT 1");

		if ($user['banned'] == 0 or $user2['banned'] == 0) {} else {
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

		if ($user['private'] == 1) {
			$result_confirm = 0;
			$time_confirm = '';
			$id_result_follow = 'followed_wait';
			$message = 'Запрос на подписку отправлен пользователю: @'.$user['login'].'. Пожалуйста, ожидайте подтверждения или отклонения запроса!';
		} else {
			$result_confirm = 1;
			$time_confirm = $serverTIME;
			$id_result_follow = 'followed';
			$message = 'Вы подписались на пользователя: @'.$user['login'];
		}

		if (mysqli_num_rows($check_follow) > 0) {
			$query_result = mysqli_query($connect, "DELETE FROM `follows` WHERE `follower_id` = '$user2_id' AND `followed_id` = '$user_id'");
			$result_id = 'unfollowed';
			$result_message = 'Вы больше не подписаны на пользователя: @'.$user['login'];
		} else {
			$query_result = mysqli_query($connect, "INSERT INTO `follows`(`follower_id`, `followed_id`, `date_follow`, `date_confirm`, `confirm`) VALUES ('$user2_id', '$user_id', '$serverTIME', '$time_confirm', '$result_confirm')");
			$result_id = $id_result_follow;
			$result_message = $message;
		}

		if ($query_result) {
			sleep(0.1);
			$check_followers = mysqli_query($connect, "SELECT * FROM `follows` WHERE `followed_id` = '$user2_id' AND `confirm` = 1");
			$user_followers = intval(mysqli_num_rows($check_followers));

			$check_following = mysqli_query($connect, "SELECT * FROM `follows` WHERE `follower_id` = '$user2_id' AND `confirm` = 1");
			$user_following = intval(mysqli_num_rows($check_following));
			sleep(0.1);
			echo normJsonStr(json_encode(array(
				"id" => "id_user_follow_success_".$result_id,
				"type" => "success", 
				"task" => "follow:success:".$result_id, 
				"camp" => "server", 
				"message" => $result_message,
				"m_followers" => intval($user_followers),
				"m_following" => intval($user_following),
				"time" => $serverTIME
			)));
			
			if ($user_id == $user2_id) {} else {
				if ($result_id == 'followed' or $result_id == 'unfollowed') {
					mysqli_query($connect, "INSERT INTO `notifications`(`user_id`, `sender_id`, `type`, `category`, `date_public`) VALUES ('$user_id', '$user2_id', 'user', '$result_id', '$serverTIME')");
				}
			}

			exit();
		} else {
			echo normJsonStr(json_encode(array(
				"id" => "id_user_follow_error",
				"type" => "error", 
				"task" => "follow:error", 
				"camp" => "server", 
				"message" => 'Что-то пошло не так, не удалось выполнить задачу!',
				"time" => $serverTIME
			)));
			exit();
		}

	} else {
		exit();
	}
?>