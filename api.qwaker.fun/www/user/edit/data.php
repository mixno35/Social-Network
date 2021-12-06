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

	if ($user['banned'] == 1) {
		exit();
	}
?>
<?php
	echo normJsonStr(json_encode(array(
		"id" => $user['id'],
		"type" => $user['type'], 
		"name" => $user['name'], 
		"avatar" => $user['avatar'], 
		"login" => $user['login'], 
		"nickname" => $user['nickname'], 
		"about" => $user['about'], 
		"email" => $user['email'], 
		"url_site" => $user['url_site'], 
		"url_social" => $user['url_social'], 
		"url_phone" => $user['url_phone'], 
		"url_email" => $user['url_email'], 
		"verification" => intval($user['verification']), 
		"email_authorization" => intval($user['email_authorization']), 
		"private" => intval($user['private']), 
		"private_message" => intval($user['private_message']), 
		"show_online" => intval($user['show_online']), 
		"show_url" => intval($user['show_url']), 
		"find_me" => intval($user['find_me']), 
		"restore_password" => intval($user['restore_password']), 
		"language" => $user['language'], 
		"time" => $serverTIME
	)));
	exit();
?>