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
?>
<?php
	$login = trim(strtolower(mysqli_real_escape_string($connect, $_POST['login'])));
	$password = trim(mysqli_real_escape_string($connect, $_POST['password']));
	$code = intval($_POST['code']);

	// Проверяем является ли значение "login" пустым, если да - запрещаем дальнейшую проверку....................................................
	if (!trim($login)) {
		echo normJsonStr(json_encode(array(
			"id" => "id_login_empty",
			"type" => "error", 
			"task" => "auth:in:login", 
			"camp" => "user", 
			"message" => 'Логин не может быть пустым!',
			"error_value" => $login,
			"time" => $serverTIME
		)));
		exit();
	}

	// Проверяем количество символов в значении "login", если значение не корректное - запрещаем дальнейшую проверку.............................
	if (mb_strlen($login, 'utf8') < 3 or mb_strlen($login, 'utf8') > 15) {
		echo normJsonStr(json_encode(array(
			"id" => "id_login_characters",
			"type" => "error", 
			"task" => "auth:in:login", 
			"camp" => "user", 
			"message" => 'Логин не может быть короче 3 или длинее 15 символов!',
			"error_value" => $login,
			"time" => $serverTIME
		)));
		exit();
	}

	// Проверяем начинается ли значение "login" с цифры, если да - запрещаем дальнейшую проверку.................................................
	if (startsWithNumber($login)) {
		echo normJsonStr(json_encode(array(
			"id" => "id_no_support_login_contains_first_number_value",
			"type" => "error", 
			"task" => "auth:in:login", 
			"camp" => "user", 
			"message" => 'Логин не должен содержать первый символ в виде числа!',
			"error_value" => $login,
			"time" => $serverTIME
		)));
		exit();
	}

	// Проверяем значение "login" на запрещённые символы, если такие имеются - запрещаем дальнейшую проверку.....................................
	if(!preg_match("/^[a-z0-9\d_]+$/", $login)) {
		echo normJsonStr(json_encode(array(
			"id" => "id_contains_symbols_no_support",
			"type" => "error", 
			"task" => "auth:in:login", 
			"camp" => "user", 
			"message" => 'Логин содержит запрещенные символы. Разрешенные символы `[a-z], [0-9], _`!',
			"error_value" => $login,
			"time" => $serverTIME
		)));
		exit();
	}



	$passwordMD5 = md5($password);



	// Проверяем является ли значение "password" пустым, если да - запрещаем дальнейшую проверку.................................................
	if (!trim($password)) {
		echo normJsonStr(json_encode(array(
			"id" => "id_password_empty",
			"type" => "error", 
			"task" => "auth:in:password", 
			"camp" => "user", 
			"message" => 'Пароль не может быть пустым!',
			"error_value" => $passwordMD5,
			"time" => $serverTIME
		)));
		exit();
	}

	// Проверяем количество символов в значении "password", если значение не корректное - запрещаем дальнейшую проверку..........................
	if (mb_strlen($password, 'utf8') < 6 or mb_strlen($password, 'utf8') > 50) {
		echo normJsonStr(json_encode(array(
			"id" => "id_password_characters",
			"type" => "error", 
			"task" => "auth:in:password", 
			"camp" => "user", 
			"message" => 'Пароль не может быть короче 6 или длинее 50 символов!',
			"error_value" => $passwordMD5,
			"time" => $serverTIME
		)));
		exit();
	}




	// Проверяем пользователя, его существование в базе данных...................................................................................
	$check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$passwordMD5' LIMIT 1");
	if (mysqli_num_rows($check_user) > 0) {
		$user = mysqli_fetch_assoc($check_user);
		$user_id = intval($user['id']);

		if (intval($user['banned']) == 1) {
			echo normJsonStr(json_encode(array(
				"id" => "id_auth_user_banned",
				"type" => "error", 
				"task" => "auth:in:user-banned", 
				"camp" => "auth", 
				"message" => 'Аккаунт заблокирован, вход в аккаунт невозможен!',
				"token" => 'null',
				"time" => $serverTIME
			)));
			exit();
		}

		if (intval($user['email_authorization']) == 1) {
			if (md5($code) != $user['email_authorization_code']) {
				$timeLast = $user['date_last_send_code'] + 300;
				if ($timeUSER < $timeLast) {
					echo normJsonStr(json_encode(array(
						"id" => "id_auth_last_error",
						"type" => "error", 
						"task" => "auth:in:date-last", 
						"camp" => "user", 
						"message" => 'Вы ввели неверный код, поэтому была попытка отправить код повторно. Войти сейчас не представляется возможным.<br>Новый код можно получить снова через 5 мин. Следующая отправка кода будет доступна <b>'.date("d M Y H:i", $timeLast).'</b>',
						"token" => 'null',
						"time" => $serverTIME
					)));
					exit();
				}

				$code_generate = substr(str_shuffle(str_repeat("0123456789", 6)), 0, 6);
				$code_generateMD5 = md5($code_generate);

				$to = $user['email'];
				$subject = 'Код авторизации';
				$message_result = '<html style="
									    padding: 20px;
									    margin: 0;
									    width: -webkit-fill-available;
									    background: lightgray;
									">
									<head>
										<meta name="viewport" content="width=device-width, initial-scale=1">
									</head>
									<body style="
									    padding: 20px;
									    margin: 0;
									    width: -webkit-fill-available;
									    background: white;
									    border-radius: 10px;
									    box-shadow: 0 10px 30px rgba(0,0,0,.1);
									"><font style="text-align:center;width: -webkit-fill-available;display: block;padding: 0;margin: 0;font-size: 16px;font-weight: 600;font-family: system-ui;">Ваш секректный код авторизации<b style="
									    font-weight: 800;
									    font-size: 27px;
									    margin: 10px;
									    display: block;
									">%1s</b><font style="font-size:12px;display: block;opacity: .5;">Произведена попытка входа в аккаунт "%2s", если это были не вы - просто проигнорируйте это сообщение или смените логин/пароль.</font>

									<font style="display: block;margin-top: 20px;font-weight: 500;font-family: system-ui;font-size: 14px;opacity: .8;">Код действует один раз</font>
									<font style="
									    font-size: 12px;
									    opacity: .4;
									    display: block;
									    margin-top: 20px;
									    padding-top: 20px;
									    border-top: 1px solid rgba(0,0,0,.2);
									">Время отправки: %3s</font>
									<font style="
									    font-size: 12px;
									    opacity: .4;
									    display: block;
									    margin-top: 20px;
									    padding-top: 20px;
									    border-top: 1px solid rgba(0,0,0,.2);
									">IP-адрес: %4s</font></font></body></html>';

				$message = str_replace('%1s', $code_generate, $message_result);
				$message = str_replace('%2s', $user['login'], $message);
				$message = str_replace('%3s', $serverTIME, $message);
				$message = str_replace('%4s', $userIP, $message);
				$headers = 'From: no-reply <' . $emailSENDER . ">\r\n" . 'Content-Type: text/html; charset=UTF-8';

				if (mail($to, $subject, $message, $headers, "-f" .$emailSENDER)) {
					mysqli_query($connect, "UPDATE `users` SET `date_last_send_code`='$timeUSER' WHERE `id`='$user_id'");
					mysqli_query($connect, "UPDATE `users` SET `email_authorization_code`='$code_generateMD5' WHERE `id`='$user_id'");
					$user_email = $user['email'];
					$length = strpos($user_email, '@') - 2;
					$asterisk = '*';
					for ($i = 1; $i < $length; $i++) {
						$asterisk .= '*'; 
					}
					$user_email = substr_replace($user_email, $asterisk, 1, $length);
					echo normJsonStr(json_encode(array(
						"id" => "id_auth_in_success_email",
						"type" => "success", 
						"task" => "auth:in:success-email", 
						"camp" => "auth", 
						"message" => 'На почту "'.$user_email.'" было отправлено письмо с кодом!',
						"token" => 'null',
						"time" => $serverTIME
					)));
				} else {
					echo normJsonStr(json_encode(array(
						"id" => "id_auth_in_error_email",
						"type" => "error", 
						"task" => "auth:in:error-email", 
						"camp" => "auth", 
						"message" => 'К аккаунту привязана авторизация через почту. Нам не удалось отправить сообщение с кодом на почту. Повторите попытку позже!..',
						"token" => 'null',
						"time" => $serverTIME
					)));
				}
				exit();
			}
		}

		mysqli_query($connect, "UPDATE `users` SET `online`='$timeUSER' WHERE `id`='$user_id'");
		if (intval($user['email_authorization']) == 1) {
			mysqli_query($connect, "UPDATE `users` SET `email_authorization_code`=NULL WHERE `id`='$user_id'");
			mysqli_query($connect, "UPDATE `users` SET `email_restore_password_code`=NULL WHERE `id`='$user_id'");
		}

		$uid = $user['id'];
		$utoken = md5($user['token']);
		$timeSession = $timeUSER;
		$timeSessionMax = intval($timeUSER+315300); 
		$sid = substr(str_shuffle(str_repeat("0123456789QWERTYUIOPASDFGHJKLZXCVBNMabcdefghijklmnopqrstuvwxyz", 70)), 0, 70);

		// удаляем все сессии пользователя и создаем одну.
		// mysqli_query($connect, "DELETE FROM `user_sessions` WHERE `uid` = '$uid' AND `utoken` = '$utoken'");
		// sleep(0.1);
		mysqli_query($connect, "INSERT INTO `user_sessions`(`uid`, `utoken`, `time`, `maxtime`, `lasttime`, `uagent`, `uip`, `type`, `sid`) VALUES ('$uid', '$utoken', '$timeSession', '$timeSessionMax', '$timeSession', '$useragent', '$userIP', 'site', '$sid')");

		echo normJsonStr(json_encode(array(
			"id" => "id_auth_in_success",
			"type" => "success", 
			"task" => "auth:in:success", 
			"camp" => "auth", 
			"message" => 'Вы успешно вошли. Добро пожаловать, '.$login.'!',
			"token" => $sid,
			"time" => $serverTIME
		)));

		$usAG = $login = trim(mysqli_real_escape_string($connect, $useragent));

		mysqli_query($connect, "INSERT INTO `notifications`(`user_id`, `sender_id`, `type`, `category`, `message`, `message2`, `date_public`) VALUES ('$user_id', 0, 'secure', 'sign-in', '$userIP', '$usAG', '$serverTIME')");
	} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_auth_in_error",
			"type" => "error", 
			"task" => "auth:in:error", 
			"camp" => "auth", 
			"message" => 'Данного пользователя не существует. Проверьте логин/пароль и повторите попытку!',
			"error_value" => $login." -> ".$passwordMD5,
			"time" => $serverTIME
		)));
	}
?>