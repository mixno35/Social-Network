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
?>
<?php
	$check_user2 = mysqli_query($connect, "SELECT * FROM `users` WHERE `token` = '$token' LIMIT 1");
	if (mysqli_num_rows($check_user2) > 0) {
		$user2 = mysqli_fetch_assoc($check_user2);
		$user2_id = intval($user2['id']);

		mysqli_query($connect, "UPDATE `users` SET `online`='$timeUSER' WHERE `id`='$user2_id'");
	} else {
		exit();
	}

	if ($user2['banned'] == 1) {
		exit();
	}
?>
<?php 
	$check_post = mysqli_query($connect, "SELECT * FROM `posts` WHERE `id` = '$id' AND `user_id` = '$user2_id' AND `creator_id` = '$user2_id'");

	if (mysqli_num_rows($check_post) > 0) {
		$post = mysqli_fetch_assoc($check_post);

		$array_images = array();
		$array_images_num = 0;
		if ($post['image1'] != '') {
			$array_images += array($array_images_num=>strval($post['image1']));
			$array_images_num = $array_images_num+1;
		} if ($post['image2'] != '') {
			$array_images += array($array_images_num=>strval($post['image2']));
			$array_images_num = $array_images_num+1;
		} if ($post['image3'] != '') {
			$array_images += array($array_images_num=>strval($post['image3']));
			$array_images_num = $array_images_num+1;
		}

		echo normJsonStr(json_encode(array(
			"id" => intval($post['id']),
			"post_id" => strval($post['post_id']),
			"post_message" => strval(htmlspecialchars($post['message'])),
			"post_title" => strval(htmlspecialchars($post['title'])),
			"post_date_public" => strval($post['date_public']),
			"post_language" => strval($post['language']),
			"post_images" => json_encode($array_images)
		)));
		exit();
	}
?>