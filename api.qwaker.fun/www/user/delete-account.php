<?php
	header('Access-Control-Allow-Origin: http://qwaker.com');
	header('Vary: Accept-Encoding, Origin');
	header('Content-Length: 235');
	header('Keep-Alive: timeout=2, max=99');
	header('Access-Control-Allow-Methods: POST');
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
	$token = trim(mysqli_real_escape_string($connect, $_POST['token']));
	$password = trim(mysqli_real_escape_string($connect, $_POST['password']));

	$passwordMD5 = md5($password);

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
		echo normJsonStr(json_encode(array(
			"id" => "id_user_token_pass_empty",
			"type" => "error", 
			"task" => "token:pass:empty", 
			"camp" => "user", 
			"message" => 'Введены неверные данные. Мы сомневаемся что вы владелец аккаунта или доверенное лицо. Проверьте введенные данные и повторите попытку!',
			"error_value" => $token,
			"time" => $serverTIME
		)));
		exit();
	}

	if ($user['type_auth'] == 'site') {
		if ($user['token'] == $token and $user['password'] == $passwordMD5) {} else {
			echo normJsonStr(json_encode(array(
				"id" => "id_user_token_pass_empty",
				"type" => "error", 
				"task" => "token:pass:empty", 
				"camp" => "user", 
				"message" => 'Введены неверные данные. Проверьте введенные данные и повторите попытку!',
				"error_value" => $token,
				"time" => $serverTIME
			)));
			exit();
		}
	}
?>
<?php
	mysqli_query($connect, "DELETE FROM `black_list` WHERE `user_blocker` = '$user_id' OR `user_blocked` = '$user_id'");
	mysqli_query($connect, "DELETE FROM `comments` WHERE `user_id` = '$user_id'");
	mysqli_query($connect, "DELETE FROM `comments_likes` WHERE `uid` = '$user_id'");
	mysqli_query($connect, "DELETE FROM `dialog` WHERE `uid` = '$user_id' OR `uid2` = '$user_id'");
	mysqli_query($connect, "DELETE FROM `dialog_messages` WHERE `uid` = '$user_id'");
	mysqli_query($connect, "DELETE FROM `follows` WHERE `follower_id` = '$user_id' OR `followed_id` = '$user_id'");
	mysqli_query($connect, "DELETE FROM `notifications` WHERE `user_id` = '$user_id' OR `sender_id` = '$user_id'");
	mysqli_query($connect, "DELETE FROM `posts` WHERE `user_id` = '$user_id'");
	// mysqli_query($connect, "DELETE FROM `post_likes` WHERE `user_id` = '$user_id'");
	// mysqli_query($connect, "DELETE FROM `post_dislikes` WHERE `user_id` = '$user_id'");
	mysqli_query($connect, "DELETE FROM `post_emotions` WHERE `uid` = '$user_id'");
	mysqli_query($connect, "DELETE FROM `reports_comments` WHERE `user_id` = '$user_id'");
	mysqli_query($connect, "DELETE FROM `reports_post` WHERE `user_id` = '$user_id'");

	$check_uploaded_files = mysqli_query($connect, "SELECT * FROM `uploaded_files` WHERE `uid` = '$user_id'");
	if (mysqli_num_rows($check_uploaded_files) > 0) {
		while($row = mysqli_fetch_assoc($check_uploaded_files)) {
			$user_image_data = $row['full_url'];
			$result_path = str_replace('api.', 'sun.', $_SERVER['DOCUMENT_ROOT']);
			$result_upath = $result_path.$row['short_url'];
			if (unlink($result_upath)) {
				mysqli_query($connect, "DELETE FROM `uploaded_files` WHERE `full_url` = '$user_image_data'");
			}
		}
	}

	if (mysqli_query($connect, "DELETE FROM `users` WHERE `id` = '$user_id'")) {
		echo normJsonStr(json_encode(array(
			"id" => "id_user_token_passsuccess",
			"type" => "success", 
			"task" => "token:pass:success", 
			"camp" => "server", 
			"message" => 'Аккаунт успешно удален!',
			"error_value" => $token,
			"time" => $serverTIME
		)));
		exit();
	}

	echo normJsonStr(json_encode(array(
		"id" => "id_user_token_pass",
		"type" => "error", 
		"task" => "token:pass", 
		"camp" => "server", 
		"message" => 'Ошибка удаления аккаунта. Повторите попытку позже!',
		"error_value" => $token,
		"time" => $serverTIME
	)));
	exit();
?>