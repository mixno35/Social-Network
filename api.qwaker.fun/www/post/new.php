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

	function validateDate($date, $format = 'Y-m-d H:i:s') {
	    $d = DateTime::createFromFormat($format, $date);
	    return $d && $d->format($format) == $date;
	}
?>
<?php
	$title = trim(mysqli_real_escape_string($connect, $_POST['title']));
	$message = trim(mysqli_real_escape_string($connect, $_POST['message']));
	$category = intval($_POST['category']);
	$date_view = intval($_POST['deffred']);
	$token = trim(mysqli_real_escape_string($connect, $_POST['token']));
	$image1 = $_FILES['image1'];
	$image2 = $_FILES['image2'];
	$image3 = $_FILES['image3'];

	// $timePublic = time();

	$maxIMAGESIZE = intval(1); // MB

	$check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `token` = '$token'LIMIT 1");
	if (mysqli_num_rows($check_user) > 0) {
		$user = mysqli_fetch_assoc($check_user);
		$user_id = intval($user['id']);

		mysqli_query($connect, "UPDATE `users` SET `online`='$timeUSER' WHERE `id`='$user_id'");
	} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_user_empty",
			"type" => "error", 
			"task" => "post:new", 
			"camp" => "user", 
			"message" => 'Для публикации новых записей, нужен действительный токен пользователя!',
			"error_value" => 'User unknown',
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

	if ($user['public_post'] == 0) {
		echo normJsonStr(json_encode(array(
			"id" => "id_user_public_post_off",
			"type" => "error", 
			"task" => "user:public-post-off", 
			"camp" => "server", 
			"message" => 'Вам запрещено публиковать новые публикации!',
			"time" => $serverTIME
		)));
		exit();
	}

	if ($category != 999) {
		if ($category > 24 or $category < 0) {
			echo normJsonStr(json_encode(array(
				"id" => "id_user_public_post_unknown_category",
				"type" => "error", 
				"task" => "user:public-post-unknown-category", 
				"camp" => "server", 
				"message" => 'Выбрана недопустимая категория. Выберите категорию!',
				"time" => $serverTIME
			)));
			exit();
		}
	}

	$check_user_posts = mysqli_query($connect, "SELECT * FROM `posts` WHERE `user_id` = '$user_id'");
	if (mysqli_num_rows($check_user_posts) < intval($user['limit_post'])) {} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_user_public_limit_max",
			"type" => "error", 
			"task" => "user:public-post-limit-max", 
			"camp" => "server", 
			"message" => 'Вы достигли максимума, вы больше не можете опубликовать новую публикацию! Удалите ненужные публикации.',
			"time" => $serverTIME
		)));
		exit();
	}

	sleep(1);

	if ($date_view == 0) {
		$date_view = time();
	} else {
		// if (validateDate($date_view)) {
		// 	// $d = strtotime(date('Y-m-d 00:00:00', $date_view));
		// 	// if ($d) {} else {
		// 	//     echo normJsonStr(json_encode(array(
		// 	// 		"id" => "id_post_date_view_convert_error",
		// 	// 		"type" => "error", 
		// 	// 		"task" => "post:date-view:convert", 
		// 	// 		"camp" => "user", 
		// 	// 		"message" => 'Нам не удалось конвертировать ваше время в нужный формат. Проверьте правильность отправленных данных! `'.$date_view.'`',
		// 	// 		"error_value" => $title,
		// 	// 		"time" => $serverTIME
		// 	// 	)));
		// 	// 	exit();
		// 	// }

			
		// } else {
		// 	echo normJsonStr(json_encode(array(
		// 		"id" => "id_post_date_view_invalid_time_error",
		// 		"type" => "error", 
		// 		"task" => "post:date-view:invalid-time", 
		// 		"camp" => "user", 
		// 		"message" => 'Отправленное время неправильного формата! `'.$date_view.'`',
		// 		"error_value" => $title,
		// 		"time" => $serverTIME
		// 	)));
		// 	exit();
		// }

		if (intval($date_view) > intval($timeUSER)) {} else {
			echo normJsonStr(json_encode(array(
				"id" => "id_post_date_view_time_error",
				"type" => "error", 
				"task" => "post:date-view:time", 
				"camp" => "user", 
				"message" => 'Выбранное время не может быть меньше текущего! `'.$date_view.'`',
				"error_value" => $title,
				"time" => $serverTIME
			)));
			exit();
		}
	}

	

	if (!trim($title)) {} else {
		if (mb_strlen($title, 'utf8') > 50) {
			echo normJsonStr(json_encode(array(
				"id" => "id_post_title_characters",
				"type" => "error", 
				"task" => "post:new:title", 
				"camp" => "user", 
				"message" => 'Заголовок записи не должен превышать 50 символов!',
				"error_value" => $title,
				"time" => $serverTIME
			)));
			exit();
		}
	}

	if (!trim($message)) {
		echo normJsonStr(json_encode(array(
			"id" => "id_post_message_empty",
			"type" => "error", 
			"task" => "post:new:message", 
			"camp" => "user", 
			"message" => 'Комментарий не должен быть пустой!',
			"error_value" => $message,
			"time" => $serverTIME
		)));
		exit();
	}

	if ($category == '') {
		$category = 0;
	}

	if (mb_strlen($message, 'utf8') < 1 or mb_strlen($message, 'utf8') > 500) {
		echo normJsonStr(json_encode(array(
			"id" => "id_post_message_characters",
			"type" => "error", 
			"task" => "post:new:message", 
			"camp" => "user", 
			"message" => 'Комментарий записи не должен превышать 500 символов или быть меньше 1 символа!',
			"error_value" => $message,
			"time" => $serverTIME
		)));
		exit();
	}

	$photo1 = '';
	$photo2 = '';
	$photo3 = '';

	$fileSIZE1 = $image1['size'][0] / 1024 / 1024;
	$fileSIZE2 = $image2['size'][0] / 1024 / 1024;
	$fileSIZE3 = $image3['size'][0] / 1024 / 1024;

	$result_path = str_replace('api.', 'sun.', $_SERVER['DOCUMENT_ROOT']);

	$domain_path = 'https://sun.qwaker.fun';

	sleep(1);

	if ($image1['name'][0] == '') {} else {
		if ($fileSIZE1 > $maxIMAGESIZE) {
			echo normJsonStr(json_encode(array(
				"id" => "id_edit_post_image_maxsize",
				"type" => "error", 
				"task" => "post:new:image:maxsize", 
				"camp" => "user", 
				"message" => 'Изображение[1] слишком тяжелое. Допустимый вес для изображения '.$maxIMAGESIZE.'МБ!',
				"time" => $serverTIME
			)));
			exit();
		}

		if ($image1['type'][0] == 'image/jpeg' or $image1['type'][0] == 'image/jpg' or $image1['type'][0] == 'image/png') {} else {
			echo normJsonStr(json_encode(array(
				"id" => "id_edit_user_avatar_type",
				"type" => "error", 
				"task" => "post:new:image:type", 
				"camp" => "user", 
				"message" => 'Изображение[1] содержит недопустимый формат!',
				"time" => $serverTIME
			)));
			exit();
		}

		$newname1 = $user['login'].'-POST-'.date('YmdHis', time()).'-'.rand(10000,999999).'.png';
		$newdir1 = '/uploads/'.$newname1;
		$photo1 = $domain_path.$newdir1;

		if (move_uploaded_file($image1['tmp_name'][0], $result_path.$newdir1)) {
			mysqli_query($connect, "INSERT INTO `uploaded_files`(`uid`, `full_url`, `short_url`, `type`) VALUES ('$user_id', '$photo1', '$newdir1', 'post_image1')");
		} else {
			echo normJsonStr(json_encode(array(
				"id" => "id_edit_user_avatar_error",
				"type" => "error", 
				"task" => "post:new:iamge:error", 
				"camp" => "server", 
				"message" => 'Нам не удалось загрузить новое изображение[1]. Повторите попытку позже!',
				"time" => $serverTIME
			)));
			exit();
		}
	} 

	sleep(1);

	if ($image2['name'][0] == '') {} else {
		if ($fileSIZE2 > $maxIMAGESIZE) {
			echo normJsonStr(json_encode(array(
				"id" => "id_edit_post_image_maxsize",
				"type" => "error", 
				"task" => "post:new:image:maxsize", 
				"camp" => "user", 
				"message" => 'Изображение[2] слишком тяжелое. Допустимый вес для изображения '.$maxIMAGESIZE.'МБ!',
				"time" => $serverTIME
			)));
			exit();
		}

		if ($image2['type'][0] == 'image/jpeg' or $image2['type'][0] == 'image/jpg' or $image2['type'][0] == 'image/png') {} else {
			echo normJsonStr(json_encode(array(
				"id" => "id_edit_user_avatar_type",
				"type" => "error", 
				"task" => "post:new:image:type", 
				"camp" => "user", 
				"message" => 'Изображение[2] содержит недопустимый формат!',
				"time" => $serverTIME
			)));
			exit();
		}

		$newname2 = $user['login'].'-POST-'.date('YmdHis', time()).'-'.rand(10000,999999).'.png';
		$newdir2 = '/uploads/'.$newname2;
		$photo2 = $domain_path.$newdir2;

		if (move_uploaded_file($image2['tmp_name'][0], $result_path.$newdir2)) {
			mysqli_query($connect, "INSERT INTO `uploaded_files`(`uid`, `full_url`, `short_url`, `type`) VALUES ('$user_id', '$photo2', '$newdir2', 'post_image2')");
		} else {
			echo normJsonStr(json_encode(array(
				"id" => "id_edit_user_avatar_error",
				"type" => "error", 
				"task" => "post:new:iamge:error", 
				"camp" => "server", 
				"message" => 'Нам не удалось загрузить новое изображение[2]. Повторите попытку позже!',
				"time" => $serverTIME
			)));
			exit();
		}
	} 

	sleep(1);

	if ($image3['name'][0] == '') {} else {
		if ($fileSIZE3 > $maxIMAGESIZE) {
			echo normJsonStr(json_encode(array(
				"id" => "id_edit_post_image_maxsize",
				"type" => "error", 
				"task" => "post:new:image:maxsize", 
				"camp" => "user", 
				"message" => 'Изображение[3] слишком тяжелое. Допустимый вес для изображения '.$maxIMAGESIZE.'МБ!',
				"time" => $serverTIME
			)));
			exit();
		}

		if ($image3['type'][0] == 'image/jpeg' or $image3['type'][0] == 'image/jpg' or $image3['type'][0] == 'image/png') {} else {
			echo normJsonStr(json_encode(array(
				"id" => "id_edit_user_avatar_type",
				"type" => "error", 
				"task" => "post:new:image:type", 
				"camp" => "user", 
				"message" => 'Изображение[3] содержит недопустимый формат!',
				"time" => $serverTIME
			)));
			exit();
		}

		$newname3 = $user['login'].'-POST-'.date('YmdHis', time()).'-'.rand(10000,999999).'.png';
		$newdir3 = '/uploads/'.$newname3;
		$photo3 = $domain_path.$newdir3;

		if (move_uploaded_file($image3['tmp_name'][0], $result_path.$newdir3)) {
			mysqli_query($connect, "INSERT INTO `uploaded_files`(`uid`, `full_url`, `short_url`, `type`) VALUES ('$user_id', '$photo3', '$newdir3', 'post_image3')");
		} else {
			echo normJsonStr(json_encode(array(
				"id" => "id_edit_user_avatar_error",
				"type" => "error", 
				"task" => "post:new:iamge:error", 
				"camp" => "server", 
				"message" => 'Нам не удалось загрузить новое изображение[3]. Повторите попытку позже!',
				"time" => $serverTIME
			)));
			exit();
		}
	}

	$post_id = substr(str_shuffle(str_repeat("0123456789QWERTYUIOPASDFGHJKLZXCVBNMabcdefghijklmnopqrstuvwxyz_", 30)), 0, 30);

	$public_post = mysqli_query($connect, "INSERT INTO `posts`(`post_id`, `user_id`, `creator_id`, `title`, `message`, `date_public`, `language`, `image1`, `image2`, `image3`, `category`, `date_view`) VALUES ('$post_id', '$user_id', '$user_id', '$title', '$message', '$serverTIME', '$userLANGUAGE', '$photo1', '$photo2', '$photo3', '$category', '$date_view')");
	if ($public_post) {
		echo normJsonStr(json_encode(array(
			"id" => "id_post_success_public",
			"type" => "success", 
			"task" => "post:new:success", 
			"camp" => "server", 
			"message" => 'Новая запись успешно опубликована!',
			"post_id" => $post_id,
			"user_name" => htmlspecialchars($user['name']),
			"user_login" => $user['login'],
			"user_avatar" => $user['avatar'],
			"time" => $serverTIME
		)));

		// sleep(3);

		// $check_new_post = mysqli_query($connect, "SELECT * FROM `posts` WHERE `user_id` = '$user_id' AND `message` = '$message' LIMIT 1");
		// if (mysqli_num_rows($check_new_post) > 0) {
		// 	$post = mysqli_fetch_assoc($check_new_post);
		// 	$post_id = intval($post['id']);
		// }

		if (preg_match_all('~@+\S+~', $message, $user_link)) {
			$limit_user_noted = 6;
			foreach($user_link[0] as $userNewLink) {
				if ($limit_user_noted !== 0) {
					$nameLink = str_replace('@', '', $userNewLink);
					$messageLink = str_replace($userNewLink.' ', '', $message);
					$check_user_link = mysqli_query($connect, "SELECT * FROM `users` WHERE `login` = '$nameLink' LIMIT 1");
					if (mysqli_num_rows($check_user_link) > 0) {
						$link_user = mysqli_fetch_assoc($check_user_link);
						$limit_user_noted = $limit_user_noted - 1;
						$link_user_id = intval($link_user['id']);
						if ($link_user_id == $user_id) {} else {
							mysqli_query($connect, "INSERT INTO `notifications`(`user_id`, `sender_id`, `type`, `category`, `message`, `message2`, `date_public`) VALUES ('$link_user_id', '$user_id', 'post', 'user-marker', '$post_id', '$message', '$serverTIME')");
						}
					}
				}
			}
		}

		exit();
	} else {
		echo normJsonStr(json_encode(array(
			"id" => "id_post_error_public",
			"type" => "error", 
			"task" => "post:new:error", 
			"camp" => "server", 
			"message" => 'Ошибка публикации записи. Повторите попытку позже...',
			"error_value" => $token.' -> '.$title.' -> '.$message,
			"time" => $serverTIME
		)));
		exit();
	}
?>