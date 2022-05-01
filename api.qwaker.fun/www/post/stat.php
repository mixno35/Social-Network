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
	$id = intval($_GET['id']);

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

	if ($user['report_posts'] == 0) {
		exit();
	}
?>
<?php
	$check_post = mysqli_query($connect, "SELECT * FROM `posts` WHERE `id` = '$id' AND `user_id` = '$user_id' LIMIT 1");
	if (mysqli_num_rows($check_post) > 0) {
		$post = mysqli_fetch_assoc($check_post);
		$post_id = intval($post['id']);
		$post_user_id = intval($post['user_id']);
		$post_message = strval($post['message']);
		$post_category = intval($post['category']);
		$post_language = strval($post['language']);
		$post_commented = intval($post['commented']);

		$check_users_lang = mysqli_query($connect, "SELECT * FROM `users` WHERE `language` = '$post_language'");
		$check_emotions = mysqli_query($connect, "SELECT * FROM `post_emotions` WHERE `pid` = '$post_id'");
		$check_comments = mysqli_query($connect, "SELECT * FROM `comments` WHERE `post_id` = '$post_id'");
		$check_comments_likes = mysqli_query($connect, "SELECT * FROM `comments_likes` WHERE `pid` = '$post_id'");
		$check_post_views = mysqli_query($connect, "SELECT * FROM `post_views` WHERE `pid` = '$post_id'");

		$array_settings = array();
		$array_settings += array("commented"=>$post_commented);

		echo normJsonStr(json_encode(array(
			"id" => $post_id,
			"category" => $post_category, 
			"message" => $post_message, 
			"language" => $post_language, 
			"coverage" => mysqli_num_rows($check_users_lang),
			"views" => mysqli_num_rows($check_post_views),
			"emotions" => mysqli_num_rows($check_emotions),
			"comments" => mysqli_num_rows($check_comments),
			"comments_likes" => mysqli_num_rows($check_comments_likes),
			"settings" => json_decode(json_encode($array_settings))
		)));
	} else {
		exit();
	}
?>