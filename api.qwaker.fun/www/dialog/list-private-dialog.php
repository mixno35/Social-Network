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
	$limit = intval($_GET['limit']);

	if ($limit == 0 or $limit < 0) {
		$limit = 250;
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
	$check_dialogs = mysqli_query($connect, "SELECT * FROM `dialog` WHERE `uid` = '$user_id' OR `uid2` = '$user_id' ORDER BY date2 DESC LIMIT $limit");

	$num_dialogs = mysqli_num_rows($check_dialogs);

	echo('[');
	while($row = mysqli_fetch_assoc($check_dialogs)) {
		$user_login = '{user_unknown}';
		$user_avatar = 'null';
		$user_dialog_id = $user_id;
		$dialog_id = $row['id'];
		if ($row['uid'] == $user_id) {} else { $user_dialog_id = $row['uid']; }
		if ($row['uid2'] == $user_id) {} else { $user_dialog_id = $row['uid2']; }
		$check_dialog_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '$user_dialog_id' LIMIT 1");
		if (mysqli_num_rows($check_dialog_user) > 0) {
			$user_dialog = mysqli_fetch_assoc($check_dialog_user);

			$user_login = $user_dialog['login'];

			if ($user_dialog['banned'] == 0) {
				$user_avatar = $user_dialog['avatar'];
			}
		}

		$check_status_messages = mysqli_query($connect, "SELECT * FROM `dialog_messages` WHERE `uid` = '$user_dialog_id' AND `status` = 0 AND `did` = '$dialog_id'");

		$dialog_status = intval(1);
		if ($row['status'] == 0 and $row['recive'] == $user_id) {
			$dialog_status = intval(0);
		}

		$dialog_send = 'other';
		if ($row['send'] == $user_id) {
			$dialog_send = 'you';
		} if ($row['send'] == 0) {
			$dialog_send = 'none';
		}

		$num_dialogs = $num_dialogs - 1;

		echo normJsonStr(json_encode(array(
			"id" => intval($row['id']),
			"did" => strval(htmlspecialchars($row['did'])),
			"status" => intval($dialog_status),
			"status_int" => intval(mysqli_num_rows($check_status_messages)),
			"date" => strval(htmlspecialchars($row['date'])),
			"date2" => strval(htmlspecialchars($row['date2'])),
			"send" => strval($dialog_send),
			"uid" => intval($user_dialog['id']),
			"ulogin" => strval(htmlspecialchars($user_login)),
			"uavatar" => strval(htmlspecialchars($user_avatar)),
			"uverification" => intval($user_dialog['verification'])
		)));

		if ($num_dialogs != 0) {
			echo(',');
		}
	}
	echo(']');
?>	