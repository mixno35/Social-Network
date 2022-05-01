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
	$check_post = mysqli_query($connect, "SELECT * FROM `posts` WHERE `id` = '$id' OR `post_id` = '$id'");

	if (mysqli_num_rows($check_post) > 0) {
		$post = mysqli_fetch_assoc($check_post);
		$post_id = intval($post['id']);
	} else {
		exit();
	}

	$check_comment = mysqli_query($connect, "SELECT * FROM `comments` WHERE `post_id` = '$post_id' ORDER BY date_public ASC");

	if (mysqli_num_rows($check_comment) > 0) {
		
	} else {
		exit();
	}

	

	// $check_post = mysqli_query($connect, "SELECT * FROM `posts` WHERE `id` = '$id'");
	// if (mysqli_num_rows($check_post) > 0) {
	// 	$post = mysqli_fetch_assoc($check_post);
	// 	$user_id_post = intval($post['user_id']);
	// } else {
	// 	exit();
	// }

	// if ($user_post['private'] == 0 or $user_id_post == $user2_id) {} else {
	// 	$check_follow = mysqli_query($connect, "SELECT * FROM `follows` WHERE `followed_id` = '$user_id_post' AND `follower_id` = '$user2_id' AND `confirm` = 1");
	// 	if (mysqli_num_rows($check_follow) > 0) {} else {
	// 		exit();
	// 	}
	// }

	$num_comments = mysqli_num_rows($check_comment);

	
	echo('[');
	while($row = mysqli_fetch_assoc($check_comment)) {
		$user_id_comment = intval($row['user_id']);
		$id_post = intval($row['post_id']);
		$id_comment = intval($row['id']);

		$check_user_comment = mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '$user_id_comment' LIMIT 1");

		$check_comment_likes = mysqli_query($connect, "SELECT * FROM `comments_likes` WHERE `pid` = '$post_id' AND `cid` = '$id_comment'");
		$check_comment_like_my = mysqli_query($connect, "SELECT * FROM `comments_likes` WHERE `pid` = '$post_id' AND `cid` = '$id_comment' AND `uid` = '$user2_id' LIMIT 1");
		
		if (mysqli_num_rows($check_user_comment) > 0) {
			$user_comment = mysqli_fetch_assoc($check_user_comment);
			if ($user_comment['banned'] == 0) {
				$user_comment_id = intval($user_comment['id']);
				$user_comment_login = strval($user_comment['login']);
				$user_comment_name = strval($user_comment['name']);
				$user_comment_avatar = strval($user_comment['avatar']);
				$user_comment_language = strval($user_comment['language']);
				$user_comment_verification = intval($user_comment['verification']);
			} else {
				$user_comment_id = null;
				$user_comment_login = 'unknown';
				$user_comment_name = 'Unknown';
				$user_comment_avatar = 'unknown';
				$user_comment_language = 'en';
				$user_comment_verification = intval(0);
			}
		} else {
			$user_comment_id = null;
			$user_comment_login = 'unknown';
			$user_comment_name = 'Unknown';
			$user_comment_avatar = 'unknown';
			$user_comment_language = 'en';
			$user_comment_verification = intval(0);
		}

		$you_comment = 0;
		if ($user_id_comment == $user2_id) {
			$you_comment = 1;
		}

		$num_comments = $num_comments - 1;
		echo json_encode(array(
			"id" => intval($row['id']),
			"comment_message" => strval(htmlspecialchars($row['message'])),
			"comment_date_public" => strval($row['date_public']),
			"comment_you" => intval($you_comment),
			"comment_likes" => intval(mysqli_num_rows($check_comment_likes)), 
			"comment_like_you" => intval(mysqli_num_rows($check_comment_like_my)), 
			"user_id" => $user_comment_id,
			"user_login" => $user_comment_login,
			"user_name" => htmlspecialchars($user_comment_name),
			"user_avatar" => $user_comment_avatar,
			"user_language" => $user_comment_language,
			"user_verification" => $user_comment_verification
		), 128);
		if ($num_comments != 0) {
			echo(',');
		}
	}
	echo(']');
?>