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
	$check_follows = mysqli_query($connect, "SELECT * FROM `follows` WHERE `followed_id` = '$user_id' AND `confirm` = 0 ORDER BY date_follow DESC");

	if (mysqli_num_rows($check_follows) > 0) {} else {
		exit();
	}

	$num_follows = mysqli_num_rows($check_follows);

	
	echo('[');
	while($row = mysqli_fetch_assoc($check_follows)) {
		$user_id_follow = intval($row['follower_id']);
		$id_follow = intval($row['id']);

		$check_user_comment = mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '$user_id_follow' LIMIT 1");
		
		if (mysqli_num_rows($check_user_comment) > 0) {
			$user_follow = mysqli_fetch_assoc($check_user_comment);
			if ($user_follow['banned'] == 0) {
				$user_follow_id = intval($user_follow['id']);
				$user_follow_login = strval($user_follow['login']);
				$user_follow_name = strval($user_follow['name']);
				$user_follow_avatar = strval($user_follow['avatar']);
				$user_follow_language = strval($user_follow['language']);
				$user_follow_verification = intval($user_follow['verification']);
			} else {
				$user_follow_id = null;
				$user_follow_login = 'unknown';
				$user_follow_name = 'Unknown';
				$user_follow_avatar = 'unknown';
				$user_follow_language = 'en';
				$user_follow_verification = intval(0);
			}
		} else {
			$user_follow_id = null;
			$user_follow_login = 'unknown';
			$user_follow_name = 'Unknown';
			$user_follow_avatar = 'unknown';
			$user_follow_language = 'en';
			$user_follow_verification = intval(0);
		}

		$num_follows = $num_follows - 1;
		echo json_encode(array(
			"id" => intval($row['id']),
			"follow_date_confirm" => strval($row['date_comfirm']),
			"follow_confirm" => intval($row['confirm']),
			"follow_date" => strval($row['date_follow']),
			"user_id" => intval($user_follow_id),
			"user_login" => $user_follow_login,
			"user_name" => htmlspecialchars($user_follow_name),
			"user_avatar" => $user_follow_avatar,
			"user_language" => $user_follow_language,
			"user_verification" => $user_follow_verification
		), 128);
		if ($num_follows != 0) {
			echo(',');
		}
	}
	echo(']');
?>