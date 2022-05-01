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

	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/data.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php'; ?>
<?php
	function normJsonStr($str){
	    $str = preg_replace_callback('/\\\\u([a-f0-9]{4})/i', create_function('$m345', 'return chr(hexdec($m345[1])-1072+224);'), $str);
	    return iconv('cp1251', 'utf-8', $str);
	}

	function encrypt($decrypted, $key) {
		$ekey = hash('SHA256', $key, true);
		srand(); $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC), MCRYPT_RAND);
		if (strlen($iv_base64 = rtrim(base64_encode($iv), '=')) != 22) return false;
		$encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $ekey, $decrypted . md5($decrypted), MCRYPT_MODE_CBC, $iv));
		return $iv_base64 . $encrypted;
	}

	if (!function_exists('str_contains')) {
	    function str_contains($haystack, $needle) {
	        return $needle !== '' && mb_strpos($haystack, $needle) !== false;
	    }
	}
?>
<?php
	$token = trim(mysqli_real_escape_string($connect, $_POST['token']));
	$id = trim(mysqli_real_escape_string($connect, $_POST['id']));
	$gif_static = trim(mysqli_real_escape_string($connect, $_POST['static']));
	$gif_url = trim(mysqli_real_escape_string($connect, $_POST['url']));

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
		echo normJsonStr(json_encode(array(
			"id" => "id_user_token_empty",
			"type" => "error", 
			"task" => "token:empty", 
			"camp" => "user", 
			"message" => 'Токен должен быть действительным!',
			"error_value" => $token,
			"time" => $serverTIME
		)));
		exit();
	}

	if ($user2['banned'] == 1) {
		echo normJsonStr(json_encode(array(
			"id" => "id_user_banned",
			"type" => "error", 
			"task" => "user:banned", 
			"camp" => "server", 
			"message" => 'Аккаунт заблокирован, действие не может быть выполненно!',
			"time" => $serverTIME
		)));
		exit();
	}
?>
<?php
	$check_dialog = mysqli_query($connect, "SELECT * FROM `dialog` WHERE `id` = '$id' OR `did` = '$id' LIMIT 1");
	if (mysqli_num_rows($check_dialog) > 0) {
		$dialog = mysqli_fetch_assoc($check_dialog);
		$dialog_id = $dialog['id'];
		$user_id = 0;
		if ($user2_id == $dialog['uid']) {} else { $user_id = $dialog['uid']; }
		if ($user2_id == $dialog['uid2']) {} else { $user_id = $dialog['uid2']; }
	} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_dialog_send_private_empty",
			"type" => "error", 
			"task" => "dialog:private:send-empty", 
			"camp" => "server", 
			"message" => 'Такого диалога не существует!',
			"time" => $serverTIME
		)));
		exit();
	}

	if ($dialog['uid'] == $user2_id or $dialog['uid2'] == $user2_id) {} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_dialog_send_private_no_joined",
			"type" => "error", 
			"task" => "dialog:private:send-no-joined", 
			"camp" => "server", 
			"message" => 'Вы не состоите в этом диалоге!',
			"time" => $serverTIME
		)));
		exit();
	}
?>
<?php
	$check_blacklist = mysqli_query($connect, "SELECT * FROM `black_list` WHERE `user_blocker` = '$user2_id' AND `user_blocked` = '$user_id' LIMIT 1");
	if (mysqli_num_rows($check_blacklist) > 0) {
		echo normJsonStr(json_encode(array(
			"id" => "id_message_chat_user_block",
			"type" => "error", 
			"task" => "message:chat-user-block", 
			"camp" => "server", 
			"message" => 'Вы не можете написать этому пользователю, Вы добавили его в черный список!',
			"time" => $serverTIME
		)));
		exit();
	}

	$check_blacklist2 = mysqli_query($connect, "SELECT * FROM `black_list` WHERE `user_blocker` = '$user_id' AND `user_blocked` = '$user2_id' LIMIT 1");
	if (mysqli_num_rows($check_blacklist2) > 0) {
		echo normJsonStr(json_encode(array(
			"id" => "id_message_chat_user_block_you",
			"type" => "error", 
			"task" => "message:chat-user-block-you", 
			"camp" => "server", 
			"message" => 'Вы не можете написать этому пользователю, Вас добавили в черный список!',
			"time" => $serverTIME
		)));
		exit();
	}
?>
<?php
	if (str_contains($gif_static, "giphy.com/media/") and str_contains($gif_static, "100_s.gif") and str_contains($gif_url, "giphy.com/media/") and str_contains($gif_url, "giphy.gif")) {} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_message_gif_error",
			"type" => "error", 
			"task" => "message:gif-error", 
			"camp" => "user", 
			"message" => 'Что-то не так с GIF анимацией. Попробуйте отправить другую или повторить попытку позже!',
			"time" => $serverTIME
		)));
		exit();
	}

	$generateGIFJSON = json_encode(array("static" => $gif_static, "url" => $gif_url));

	$send_message = mysqli_query($connect, "INSERT INTO `dialog_messages`(`did`, `uid`, `source`, `type`, `date`) VALUES ('$dialog_id', '$user2_id', '$generateGIFJSON', 'gif', '$timeUSER')");
	if ($send_message) {
		mysqli_query($connect, "UPDATE `dialog` SET `send`='$user2_id',`status`=0,`recive`='$user_id',`date2`='$timeUSER' WHERE `id`='$dialog_id'");
		echo normJsonStr(json_encode(array(
			"id" => "id_dialog_private_send_success",
			"type" => "success", 
			"task" => "dialog:private:send:success", 
			"camp" => "server",
			"time" => $serverTIME
		)));
		exit();
	} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_dialog_private_send_error",
			"type" => "error", 
			"task" => "dialog:private:send:error", 
			"camp" => "server",
			"message" => 'Нам не удалось отправить сообщение. Повторите попытку позже!',
			"time" => $serverTIME
		)));
		exit();
	}
?>