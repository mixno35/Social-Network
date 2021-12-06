<?php
	header('Access-Control-Allow-Origin: http://qwaker.fun');
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
	$code = md5(trim(mysqli_real_escape_string($connect, $_GET['code'])));
?>
<?php
	$check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `email_restore_password_code` = '$code' LIMIT 1");
	if (mysqli_num_rows($check_user) > 0) {
		$user = mysqli_fetch_assoc($check_user);
		$user_id = intval($user['id']);
		$user_login = $user['login'];
	} else {
		$user_id = '-1';
		$user_login = '0login0';
		exit();
	}

	$password = substr(str_shuffle(str_repeat("0123456789QWERTYUIOPASDFGHJKLZXCVBNMabcdefghijklmnopqrstuvwxyz-+=!/", 15)), 0, 15);
	$passwordMD5 = md5($password);

	echo normJsonStr(json_encode(array(
		"id" => $user_id,
		"login" => $user_login,
		"password" => $password,
		"time" => $serverTIME
	)));

	if (mysqli_num_rows($check_user) > 0) {
		mysqli_query($connect, "UPDATE `users` SET `password`='$passwordMD5', `email_restore_password_code`=NULL WHERE `id`='$user_id'");
	}

	exit();
?>