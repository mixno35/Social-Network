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
	$token = trim(mysqli_real_escape_string($connect, $_GET['token']));
	$type = trim(mysqli_real_escape_string($connect, $_GET['type']));
	$limit = intval($_GET['limit']);

	if ($type == 'all') {
		$type = '';
	}

	if ($type == 'post' or $type == 'system' or $type == 'user') {} else {
		$type = '';
	}

	if ($limit > 75 or $limit < 1) {
		$limit = 75;
	}
?>
<?php
	$check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `token` = '$token' LIMIT 1");
	if (mysqli_num_rows($check_user) > 0) {
		$user = mysqli_fetch_assoc($check_user);
		$user_id = intval($user['id']);

		mysqli_query($connect, "UPDATE `users` SET `online`='$timeUSER' WHERE `id`='$user_id'");
	} else {
		exit();
	}

	if ($user['banned'] == 1) {
		exit();
	}
?>
<?php
	if ($type == '') {
		$check_nofifications = mysqli_query($connect, "SELECT * FROM `notifications` WHERE `user_id` = '$user_id' ORDER BY date_public DESC LIMIT $limit");
	} else {
		$check_nofifications = mysqli_query($connect, "SELECT * FROM `notifications` WHERE `user_id` = '$user_id' AND `type` = '$type' ORDER BY date_public DESC LIMIT $limit");
	}

	if (mysqli_num_rows($check_nofifications) > 0) {} else {
		exit();
	}

	$num_notifications = mysqli_num_rows($check_nofifications);
	
	echo('[');
	while($row = mysqli_fetch_assoc($check_nofifications)) {
		$user_id_notify = intval($row['sender_id']);
		$id_notify = intval($row['id']);

		$check_user_notify = mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '$user_id_notify' LIMIT 1");
		
		if (mysqli_num_rows($check_user_notify) > 0) {
			$user_notify = mysqli_fetch_assoc($check_user_notify);
			if ($user_notify['banned'] == 0) {
				$user_notify_id = intval($user_notify['id']);
				$user_notify_login = strval($user_notify['login']);
				$user_notify_name = strval($user_notify['name']);
				$user_notify_avatar = strval($user_notify['avatar']);
				$user_notify_language = strval($user_notify['language']);
				$user_notify_verification = intval($user_notify['verification']);
			} else {
				$user_notify_id = null;
				$user_notify_login = 'unknown';
				$user_notify_name = 'Unknown';
				$user_notify_avatar = 'unknown';
				$user_notify_language = 'en';
				$user_notify_verification = intval(0);
			}
		} else {
			$user_notify_id = null;
			$user_notify_login = 'unknown';
			$user_notify_name = 'Unknown';
			$user_notify_avatar = 'unknown';
			$user_notify_language = 'en';
			$user_notify_verification = intval(0);
		}

		$num_notifications = $num_notifications - 1;
		echo json_encode(array(
			"id" => intval($row['id']),
			"notify_date" => strval($row['date_public']),
			"notify_readed" => intval($row['readed']),
			"notify_sender" => intval($row['sender_id']),
			"notify_type" => strval($row['type']),
			"notify_category" => strval($row['category']),
			"notify_message" => htmlspecialchars($row['message']),
			"notify_message2" => htmlspecialchars($row['message2']),
			"notify_message3" => htmlspecialchars($row['message3']),
			"user_id" => intval($user_notify_id),
			"user_login" => $user_notify_login,
			"user_name" => htmlspecialchars($user_notify_name),
			"user_avatar" => $user_notify_avatar,
			"user_language" => $user_notify_language,
			"user_verification" => $user_notify_verification
		), 128);
		if ($num_notifications != 0) {
			echo(',');
		}
	}
	echo(']');
?>