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
?>
<?php
	
	$check_blocks = mysqli_query($connect, "SELECT * FROM `black_list` WHERE `user_blocker` = '$user_id' ORDER BY date_public DESC");

	$num_blocks = mysqli_num_rows($check_blocks);

	if ($user['banned'] == 0) {} else {
		exit();
	}

	echo '[';
	while($row = mysqli_fetch_assoc($check_blocks)) {
		$blocker_id = intval($row['user_blocker']);
		$blocked_id = intval($row['user_blocked']);

		$check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '$blocked_id' LIMIT 1");

		if (mysqli_num_rows($check_user) > 0) {
			$user_follow = mysqli_fetch_assoc($check_user);
			if ($user_follow['banned'] == 0) {
				$user_post_id = intval($user_follow['id']);
				$user_post_login = strval($user_follow['login']);
				$user_post_name = strval($user_follow['name']);
				$user_post_avatar = strval($user_follow['avatar']);
				$user_post_language = strval($user_follow['language']);
				$user_post_verification = intval($user_follow['verification']);
			} else {
				$user_post_id = null;
				$user_post_login = 'unknown';
				$user_post_name = 'Unknown';
				$user_post_avatar = 'unknown';
				$user_post_language = 'en';
				$user_post_verification = intval(0);
			}
		} else {
			$user_post_id = null;
			$user_post_login = 'unknown';
			$user_post_name = 'Unknown';
			$user_post_avatar = 'unknown';
			$user_post_language = 'en';
			$user_post_verification = intval(0);
		}

		$num_blocks = $num_blocks - 1;
		echo json_encode(array(
			"id" => intval($row['id']),
			"user_id" => intval($user_post_id),
			"user_login" => $user_post_login,
			"user_name" => strval(htmlspecialchars($user_post_name)),
			"user_avatar" => $user_post_avatar,
			"user_language" => $user_post_language,
			"user_verification" => $user_post_verification,
			"block_date" => strval($row['date_public'])
		), 128);
		if ($num_blocks != 0) {
			echo(',');
		}
	}
	echo ']';
?>