<?php
	header('Access-Control-Allow-Origin: *');
	header('Vary: Accept-Encoding, Origin');
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

	function resizeImage($filename, $newwidth, $newheight) {
	    list($width, $height) = getimagesize($filename);

	    if($width > $height && $newheight < $height) {
	        $newheight = $height / ($width / $newwidth);
	    } else if ($width < $height && $newwidth < $width) {
	        $newwidth = $width / ($height / $newheight);   
	    } else {
	        $newwidth = $width;
	        $newheight = $height;
	    }

	    $thumb = imagecreatetruecolor($newwidth, $newheight);
	    $source = imagecreatefromjpeg($filename);

	    imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

	    return imagejpeg($thumb);
	}
?>
<?php
	$tp = strval($_POST['type']);
	$token = trim(mysqli_real_escape_string($connect, $_POST['token']));
	$file = $_FILES['file'];

	$maxIMAGESIZE = intval(1); // MB

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

	sleep(1);
?>
<?php
	$check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `token` = '$token' LIMIT 1");
	if (mysqli_num_rows($check_user) > 0) {
		$user = mysqli_fetch_assoc($check_user);
		$user_id = intval($user['id']);

		mysqli_query($connect, "UPDATE `users` SET `online`='$timeUSER' WHERE `id`='$user_id'");
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

	if ($user['banned'] == 1) {
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

	sleep(1);
?>
<?php

	if ($tp == 'remove') {
		$user_avatar_data = $user['avatar'];
		if (mysqli_query($connect, "UPDATE `users` SET `avatar`=NULL WHERE `id`='$user_id'")) {
			echo normJsonStr(json_encode(array(
				"id" => "id_edit_user_avatar_success",
				"type" => "success", 
				"task" => "edit:user:avatar:success", 
				"camp" => "server", 
				"message" => 'Фото профиля успешно удалено!',
				"result" => '',
				"time" => $serverTIME
			)));

			$check_ufile = mysqli_query($connect, "SELECT * FROM `uploaded_files` WHERE `full_url` = '$user_avatar_data' LIMIT 1");
			if (mysqli_num_rows($check_ufile)) {
				$ufile = mysqli_fetch_assoc($check_ufile);
				$result_path = str_replace('api.', 'sun.', $_SERVER['DOCUMENT_ROOT']);
				$result_upath = $result_path.$ufile['short_url'];
				if (unlink($result_upath)) {
					mysqli_query($connect, "DELETE FROM `uploaded_files` WHERE `full_url` = '$user_avatar_data'");
				}
			}
			exit();
		} else {
			echo normJsonStr(json_encode(array(
				"id" => "id_edit_user_avatar_error",
				"type" => "error", 
				"task" => "edit:user:avatar:error", 
				"camp" => "server", 
				"message" => 'Нам не удалось удалить фото профиля. Попробуйте позже!',
				"time" => $serverTIME
			)));
			exit();
		}
	}

	$last_upd_avatar_new = '';

	if ($user['verification'] == 1) {
		$last_upd_avatar = intval($user['date_upd_avatar']);
		if ($user['date_upd_avatar'] == '') {
			$last_upd_avatar = intval(time());
		}

		$last_upd_avatar_new = intval(time() + 604800);

		if (time() < intval($user['date_upd_avatar'])) {
			echo normJsonStr(json_encode(array(
				"id" => "id_edit_user_avatar_error_date",
				"type" => "error", 
				"task" => "edit:user:avatar:error", 
				"camp" => "server", 
				"message" => 'Вы совсем недавно меняли фото профиля. Следующее изменение фото будет доступно: <b>'.date("d M Y H:i", $last_upd_avatar).'</b>',
				"time" => $serverTIME
			)));
			exit();
		}
	}

	$fileSIZE = $file['size'][0] / 1024 / 1024;

	sleep(1);

	if ($fileSIZE > $maxIMAGESIZE) {
		echo normJsonStr(json_encode(array(
			"id" => "id_edit_user_avatar_maxsize",
			"type" => "error", 
			"task" => "edit:user:avatar:maxsize", 
			"camp" => "user", 
			"message" => 'Изображение слишком тяжелое. Допустимый вес для изображения '.$maxIMAGESIZE.'МБ!',
			"time" => $serverTIME
		)));
		exit();
	}

	if ($file['type'][0] == 'image/jpeg' or $file['type'][0] == 'image/jpg' or $file['type'][0] == 'image/png') {} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_edit_user_avatar_type",
			"type" => "error", 
			"task" => "edit:user:avatar:type", 
			"camp" => "user", 
			"message" => 'Изображение содержит недопустимый формат!',
			"time" => $serverTIME
		)));
		exit();
	}

	$result_path = str_replace($defaultDOMAINSTORAGE_START, $defaultDOMAINSTORAGE_END, $_SERVER['DOCUMENT_ROOT']);

	$newname = $user['login'].'-'.date('YmdHis', time()).rand(10000,999999).'.jpg';
	$newdir = '/avatars/'.$newname;
	$result_newdir = $defaultDOMAINSTORAGE_URL.$newdir;

	if (move_uploaded_file($file['tmp_name'][0], $result_path.$newdir)) {} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_edit_user_avatar_error",
			"type" => "error", 
			"task" => "edit:user:avatar:error", 
			"camp" => "server", 
			"message" => 'Нам не удалось загрузить новое изображение. Повторите попытку позже!.. [1]',
			"time" => $serverTIME
		)));
		exit();
	}

	$user_avatar_data = $user['avatar'];
	if (mysqli_query($connect, "UPDATE `users` SET `avatar`='$result_newdir', `avatar_small`='$result_newdir' WHERE `id`='$user_id'")) {
		echo normJsonStr(json_encode(array(
			"id" => "id_edit_user_avatar_success",
			"type" => "success", 
			"task" => "edit:user:avatar:success", 
			"camp" => "server", 
			"message" => 'Фото профиля успешно обновлено!',
			"result" => $result_newdir,
			"time" => $serverTIME
		)));
		if ($tp != 'remove') {
			mysqli_query($connect, "UPDATE `users` SET `date_upd_avatar`='$last_upd_avatar_new' WHERE `id`='$user_id'");
		}

		$check_ufile = mysqli_query($connect, "SELECT * FROM `uploaded_files` WHERE `full_url` = '$user_avatar_data' LIMIT 1");
		if (mysqli_num_rows($check_ufile)) {
			$ufile = mysqli_fetch_assoc($check_ufile);
			$result_path = str_replace('api.', 'sun.', $_SERVER['DOCUMENT_ROOT']);
			$result_upath = $result_path.$ufile['short_url'];
			if (unlink($result_upath)) {
				mysqli_query($connect, "DELETE FROM `uploaded_files` WHERE `full_url` = '$user_avatar_data'");
			}
		}

		mysqli_query($connect, "INSERT INTO `uploaded_files`(`uid`, `full_url`, `short_url`, `type`) VALUES ('$user_id', '$result_newdir', '$newdir', 'avatar')");
		exit();
	} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_edit_user_avatar_error",
			"type" => "error", 
			"task" => "edit:user:avatar:error", 
			"camp" => "server", 
			"message" => 'Нам не удалось загрузить новое изображение. Повторите попытку позже!.. [2]',
			"time" => $serverTIME
		)));
		exit();
	}
?>