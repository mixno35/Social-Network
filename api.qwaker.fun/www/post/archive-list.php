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
	$check_post = mysqli_query($connect, "SELECT * FROM `posts` WHERE `user_id` = '$user2_id' AND `archive` = 1 ORDER BY date_public DESC");

	$num_posts = mysqli_num_rows($check_post);

	if ($user2['banned'] == 0) {} else {
		exit();
	}

	echo('[');
	while($row = mysqli_fetch_assoc($check_post)) {
		$user_id_post = intval($row['user_id']);
		$id_post = intval($row['id']);

		$check_user_post = mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '$user_id_post' LIMIT 1");
		$check_comments_post = mysqli_query($connect, "SELECT * FROM `comments` WHERE `post_id` = '$id_post' LIMIT 1");
		$check_post_my_comment = mysqli_query($connect, "SELECT * FROM `comments` WHERE `post_id` = '$id_post' AND `user_id` = '$user_id_post' LIMIT 1");

		if (mysqli_num_rows($check_user_post) > 0) {
			$user_post = mysqli_fetch_assoc($check_user_post);
			if ($user_post['banned'] == 0) {
				$user_post_id = intval($user_post['id']);
				$user_post_login = strval($user_post['login']);
				$user_post_name = strval($user_post['name']);
				$user_post_avatar = strval($user_post['avatar']);
				$user_post_language = strval($user_post['language']);
				$user_post_verification = intval($user_post['verification']);
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

		$array_images = array();
		$array_images_num = 0;
		if ($row['image1'] != '') {
			$array_images += array($array_images_num=>strval($row['image1']));
			$array_images_num = $array_images_num+1;
		} if ($row['image2'] != '') {
			$array_images += array($array_images_num=>strval($row['image2']));
			$array_images_num = $array_images_num+1;
		} if ($row['image3'] != '') {
			$array_images += array($array_images_num=>strval($row['image3']));
			$array_images_num = $array_images_num+1;
		}

		$num_posts = $num_posts - 1;
		echo normJsonStr(json_encode(array(
			"id" => intval($row['id']),
			"post_id" => strval(htmlspecialchars($row['post_id'])),
			"post_message" => strval(htmlspecialchars($row['message'])),
			"post_title" => strval(htmlspecialchars($row['title'])),
			"post_date_public" => strval($row['date_public']),
			"post_language" => strval($row['language']),
			"post_you" => intval($value_you),
			"post_comments" => intval(mysqli_num_rows($check_comments_post)),
			"post_images" => json_encode($array_images),
			"post_my_comment" => mysqli_num_rows($check_post_my_comment),
			"post_views" => intval($row['views']),
			"user_id" => intval($user_post_id),
			"user_login" => $user_post_login,
			"user_name" => strval(htmlspecialchars($user_post_name)),
			"user_avatar" => $user_post_avatar,
			"user_language" => $user_post_language,
			"user_verification" => $user_post_verification
		)));
		if ($num_posts != 0) {
			echo(',');
		}
	}
	echo(']');
?>