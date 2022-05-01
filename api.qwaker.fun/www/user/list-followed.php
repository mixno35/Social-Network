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
	$id = trim(mysqli_real_escape_string($connect, $_GET['id']));

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
		exit();
	}
?>
<?php
	if ($user['id'] == $user2['id']) {
		$value_you = 1;
	} else {
		$value_you = 0;
	}
?>
<?php
	$check_blacklist = mysqli_query($connect, "SELECT * FROM `black_list` WHERE `user_blocker` = '$user_id' AND `user_blocked` = '$user2_id' LIMIT 1");
	if (mysqli_num_rows($check_blacklist) > 0) {
		exit();
	}
	
	$check_follows = mysqli_query($connect, "SELECT * FROM `follows` WHERE `follower_id` = '$user_id' AND `confirm` = 1 ORDER BY date_follow DESC");

	$check_follow = mysqli_query($connect, "SELECT * FROM `follows` WHERE `follower_id` = '$user2_id' AND `followed_id` = '$user_id' AND `confirm` = 1 LIMIT 1");

	$num_follows = mysqli_num_rows($check_follows);

	if ($user['banned'] == 0) {} else {
		exit();
	}

	if ($user['private'] == 0 or $user_id == $user2_id or mysqli_num_rows($check_follow) > 0) {} else {
		exit();
	}

	echo '[';
	while($row = mysqli_fetch_assoc($check_follows)) {
		$follower_id = intval($row['follower_id']);
		$followed_id = intval($row['followed_id']);

		$check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '$followed_id' LIMIT 1");

		if (mysqli_num_rows($check_user) > 0) {
			$user_follow = mysqli_fetch_assoc($check_user);
			if ($user_follow['banned'] == 0) {
				$user_post_id = intval($user_follow['id']);
				$user_post_login = strval($user_follow['login']);
				$user_post_name = strval($user_follow['name']);
				$user_post_avatar = strval($user_follow['avatar']);
				$user_post_language = strval($user_follow['language']);
				$user_post_verification = intval($user_follow['verification']);
				$user_post_about = strval($user_follow['about']);
			} else {
				$user_post_id = null;
				$user_post_login = strval($user_follow['login']);
				$user_post_name = 'Unknown';
				$user_post_avatar = 'unknown';
				$user_post_language = 'en';
				$user_post_verification = intval(0);
				$user_post_about = null;
			}
		} else {
			$user_post_id = null;
			$user_post_login = strval($user_follow['login']);
			$user_post_name = 'Unknown';
			$user_post_avatar = 'unknown';
			$user_post_language = 'en';
			$user_post_verification = intval(0);
			$user_post_about = null;
		}

		$num_follows = $num_follows - 1;
		echo json_encode(array(
			"id" => intval($row['id']),
			"user_id" => intval($user_post_id),
			"user_login" => $user_post_login,
			"user_name" => strval(htmlspecialchars($user_post_name)),
			"user_avatar" => $user_post_avatar,
			"user_language" => $user_post_language,
			"user_verification" => $user_post_verification,
			"user_about" => $user_post_about,
			"follow_you" => $value_you,
			"follow_confirm" => intval($row['confirm']),
			"follow_date" => strval($row['date_follow']),
			"follow_date_confirm" => strval($row['date_confirm'])
		), 128);
		if ($num_follows != 0) {
			echo(',');
		}
	}
	echo ']';
?>