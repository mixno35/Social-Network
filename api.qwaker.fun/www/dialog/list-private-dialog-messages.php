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

	error_reporting(0);
?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/data.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php'; ?>
<?php
	function normJsonStr($str){
	    $str = preg_replace_callback('/\\\\u([a-f0-9]{4})/i', create_function('$m345', 'return chr(hexdec($m345[1])-1072+224);'), $str);
	    return iconv('cp1251', 'utf-8', $str);
	}

	function decrypt($encrypted, $key) {
		$ekey = hash('SHA256', $key, true);
		$iv = base64_decode(substr($encrypted, 0, 22) . '==');
		$encrypted = substr($encrypted, 22);
		$decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $ekey, base64_decode($encrypted), MCRYPT_MODE_CBC, $iv), "\0\4");
		$hash = substr($decrypted, -32);
		$decrypted = substr($decrypted, 0, -32);
		if (md5($decrypted) != $hash) return false;
		return $decrypted;
	}
?>
<?php
	$token = trim(mysqli_real_escape_string($connect, $_GET['token']));
	$id = trim(mysqli_real_escape_string($connect, $_GET['id']));
?>
<?php
	$check_user2 = mysqli_query($connect, "SELECT * FROM `users` WHERE `token` = '$token' LIMIT 1");
	if (mysqli_num_rows($check_user2) > 0) {
		$user2 = mysqli_fetch_assoc($check_user2);
		$user2_id = intval($user2['id']);

		mysqli_query($connect, "UPDATE `users` SET `online`='$timeUSER' WHERE `id`='$user2_id'");
	} else {
		exit();
	}

	if ($user2['banned'] == 1) {
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
		exit();
	}

	if ($dialog['uid'] == $user2_id or $dialog['uid2'] == $user2_id) {} else {
		exit();
	}
?>
<?php
	$check_messages = mysqli_query($connect, "SELECT * FROM `dialog_messages` WHERE `did` = '$dialog_id' ORDER BY date DESC LIMIT 120");

	if ($user2['chat_read'] == 1) {
		// ПОМЕЧАЕМ ДИАЛОГ КАК ПРОЧИТАННЫЙ
		mysqli_query($connect, "UPDATE `dialog` SET `status`=1 WHERE `id`='$dialog_id' AND `recive`='$user2_id'");

		// ЧИТАЕМ СООБЩЕНИЯ СОБЕСЕДНИКА
		mysqli_query($connect, "UPDATE `dialog_messages` SET `status`=1 WHERE `did`='$dialog_id' AND `uid`='$user_id'");
	}

	$num_messages = mysqli_num_rows($check_messages);

	echo('[');
	while($row = mysqli_fetch_assoc($check_messages)) {
		$user_id = $row['uid'];
		$message = $row['text'];
		$user_login = 'unknown';
		$user_avatar = 'null';
		$user_token = rand(11111, 99999);
		$reply = $row['reply'];

		$check_user_message = mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '$user_id' LIMIT 1");
		if (mysqli_num_rows($check_user_message) > 0) {
			$user_message = mysqli_fetch_assoc($check_user_message);

			$user_login = $user_message['login'];
			$user_avatar = $user_message['avatar'];
			$user_token = $user_message['token'];
		}

		$message_you = 0;
		if ($user2_id == $user_id) {
			$message_you = 1;
		}

		if ($row['text'] === '') {} else {
			$message = decrypt($row['text'], md5($dialog['key'].$user_token));
		}

		$num_messages = $num_messages - 1;

		echo json_encode(array(
			"id" => intval($row['id']),
			"type" => strval($row['type']),
			"text" => strval(htmlspecialchars($message)),
			"source" => strval($row['source']),
			"you" => intval($message_you),
			"status" => intval($row['status']),
			"date" => strval(htmlspecialchars($row['date'])),
			"reply" => intval($reply),
			"uid" => intval($user_id),
			"ulogin" => strval(htmlspecialchars($user_login)),
			"uavatar" => strval(htmlspecialchars($user_avatar))
		), 128);

		if ($num_messages != 0) {
			echo(',');
		}
	}
	echo(']');
?>