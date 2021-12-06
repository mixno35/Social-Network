<?php
	header('Access-Control-Allow-Origin: http://qwaker.com');
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

	$check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `token` = '$token' LIMIT 1");
	if (mysqli_num_rows($check_user) > 0) {
		$user = mysqli_fetch_assoc($check_user);
		$user_id = intval($user['id']);

		$access_token = substr(str_shuffle(str_repeat("0123456789QWERTYUIOPASDFGHJKLZXCVBNMabcdefghijklmnopqrstuvwxyz", 70)), 0, 70);

		echo normJsonStr(json_encode(array(
			"type" => "success",
			"id" => $user_id,
			"access_token" => $access_token,
			"time" => $serverTIME
		)));

		mysqli_query($connect, "UPDATE `users` SET `token_access`='$access_token' WHERE `id`='$user_id'");
		exit();
	} else {
		echo normJsonStr(json_encode(array(
			"type" => "error",
			"id" => "",
			"access_token" => "",
			"time" => $serverTIME
		)));
	}
?>