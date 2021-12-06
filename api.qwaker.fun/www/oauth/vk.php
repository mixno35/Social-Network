<?php
	header('Access-Control-Allow-Origin: *');
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

	function startsWithNumber($string) {
	    return strlen($string) > 0 && ctype_digit(substr($string, 0, 1));
	}

	function detect_cyr_utf8($content) {
		return preg_match('/[^а-яА-ЯёЁa-zA-Z\s]/u', $content);
	}

	exit();
?>
<?php
	$id = trim(mysqli_real_escape_string($connect, $_POST['id']));
	$token = trim(mysqli_real_escape_string($connect, $_POST['token']));
	$name = trim(mysqli_real_escape_string($connect, $_POST['name']));
	$avatar = trim(mysqli_real_escape_string($connect, $_POST['avatar']));

	$login = 'user'.$id;
	$userTypeAuth = 'vk';

	$idapp = 7933767;
	$secret = 'NrBsJih0ATYXUV2xFKqO';

	$usAG = trim(mysqli_real_escape_string($connect, $useragent));

	$urlSecure = 'https://oauth.vk.com/access_token?client_id='.$id.'&client_secret=' + CLIENT_SECRET + '&v=5.40&grant_type=client_credentials';

	$json = file_get_contents('https://api.vk.com/oauth/token?client_id='.$idapp.'&code='.$token.'&client_secret='.$secret);

	$obj = json_decode($json);
	$ololo = $obj->{'access_token'};
	$access_token=$ololo;

	echo 'Добро пожаловать: '.$access_token;

	$check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `oauth_id` = '$id' AND `type_auth` = '$userTypeAuth' LIMIT 1");
	if (mysqli_num_rows($check_user) > 0) {
		$user = mysqli_fetch_assoc($check_user);
		$user_id = intval($user['id']);

		$uid = $user['id'];
		$utoken = md5($user['token']);
		$timeSession = time();
		$timeSessionMax = time()+31536000; // +1 год. Сессия действительна 1 год.
		// $sid = substr(str_shuffle(str_repeat("0123456789QWERTYUIOPASDFGHJKLZXCVBNMabcdefghijklmnopqrstuvwxyz", 70)), 0, 70);

		echo normJsonStr(json_encode(array(
			"id" => "id_oauth_user_success",
			"type" => "success", 
			"task" => "oauth:in:user-success", 
			"camp" => "oauth", 
			"message" => 'Вход выполнен успешно. Добро пожаловать "'.$user['login'].'"!',
			"token" => $user['token'],
			"time" => $serverTIME
		)));

		// удаляем все сессии пользователя и создаем одну.
		// mysqli_query($connect, "DELETE FROM `user_sessions` WHERE `uid` = '$uid' AND `utoken` = '$utoken'");
		// sleep(0.1);
		// mysqli_query($connect, "INSERT INTO `user_sessions`(`uid`, `utoken`, `time`, `maxtime`, `lasttime`, `uagent`, `uip`, `type`, `sid`) VALUES ('$uid', '$utoken', '$timeSession', '$timeSessionMax', '$timeSession', '$useragent', '$userIP', '$userTypeAuth', '$sid')");

		mysqli_query($connect, "INSERT INTO `notifications`(`user_id`, `sender_id`, `type`, `category`, `message`, `message2`, `message3`, `date_public`) VALUES ('$user_id', 0, 'system', 'sign-in-other', '$userIP', '$usAG', '$userTypeAuth', '$serverTIME')");
		exit();
	}

	$check_user2 = mysqli_query($connect, "SELECT * FROM `users` WHERE `login` = '$login' LIMIT 1");
	if (mysqli_num_rows($check_user2) > 0) {
		$login += substr(str_shuffle(str_repeat("0123456789QWERTYUIOPASDFGHJKLZXCVBNMabcdefghijklmnopqrstuvwxyz", 6)), 0, 6);
	}

	$token = $userTypeAuth.substr(str_shuffle(str_repeat("0123456789QWERTYUIOPASDFGHJKLZXCVBNMabcdefghijklmnopqrstuvwxyz", 55)), 0, 55);
	$tokenMD5 = md5($token);

	$registation_user = mysqli_query($connect, "INSERT INTO `users`(`oauth_id`, `type_auth`, `ip`, `nickname`, `login`, `name`, `avatar`, `language`, `date_registration`, `date_upd_login`, `token`, `token_public`) VALUES ('$id', '$userTypeAuth', '$userIP', '$login', '$login', '$name', '$avatar', '$userLANGUAGE', '$serverTIME', '$timeUSER', '$token', '$tokenMD5')");
	if ($registation_user) {
		echo normJsonStr(json_encode(array(
			"id" => "id_oauth_up_success",
			"type" => "success", 
			"task" => "oauth:up:success", 
			"camp" => "oauth", 
			"message" => 'Регистрация прошла успешно!',
			"token" => $token,
			"time" => $serverTIME
		)));
		exit();
	} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_oauth_up_error",
			"type" => "error", 
			"task" => "oauth:up:error", 
			"camp" => "oauth", 
			"message" => 'Ошибка регистрации, повторите попытку позже!..',
			"time" => $serverTIME
		)));
		exit();
	}
?>