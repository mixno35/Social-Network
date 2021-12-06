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
	$token = trim(mysqli_real_escape_string($connect, $_GET['token']));
	$id = trim(mysqli_real_escape_string($connect, $_GET['id']));
?>
<?php
	$check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '$id' LIMIT 1");
	if (mysqli_num_rows($check_user) > 0) {
		$user = mysqli_fetch_assoc($check_user);
		$user_id = intval($user['id']);
	} else {
		$check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `login` = '$id' LIMIT 1");
		if (mysqli_num_rows($check_user) > 0) {
			$user = mysqli_fetch_assoc($check_user);
			$user_id = intval($user['id']);
		} else {
			$check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `token` = '$id' LIMIT 1");
			if (mysqli_num_rows($check_user) > 0) {
				$user = mysqli_fetch_assoc($check_user);
				$user_id = intval($user['id']);
			}
		}
	}
?>
<?php
	$check_user2 = mysqli_query($connect, "SELECT * FROM `users` WHERE `token` = '$token' LIMIT 1");
	if (mysqli_num_rows($check_user2) > 0) {
		$user2 = mysqli_fetch_assoc($check_user2);
		$user2_id = intval($user2['id']);

		mysqli_query($connect, "UPDATE `users` SET `online`='$timeUSER' WHERE `id`='$user2_id'");
	}
?>
<?php
	$check_post = mysqli_query($connect, "SELECT * FROM `posts` WHERE `user_id` = '$user_id' AND `archive` = 0 AND `date_view` < '$timeUSER'");
	$user_posts = intval(mysqli_num_rows($check_post));
?>
<?php
	$check_followers = mysqli_query($connect, "SELECT * FROM `follows` WHERE `followed_id` = '$user_id' AND `confirm` = 1");
	$user_followers = intval(mysqli_num_rows($check_followers));
?>
<?php
	$check_following = mysqli_query($connect, "SELECT * FROM `follows` WHERE `follower_id` = '$user_id' AND `confirm` = 1");
	$user_following = intval(mysqli_num_rows($check_following));
?>
<?php
	$user_notifications = intval(0);
	$user_notifications_r = intval(0);

	if ($user_id == $user2_id) {
		$check_notifications = mysqli_query($connect, "SELECT * FROM `notifications` WHERE `user_id` = '$user_id'");
		$user_notifications = intval(mysqli_num_rows($check_notifications));

		$check_notifications_r = mysqli_query($connect, "SELECT * FROM `notifications` WHERE `user_id` = '$user_id' AND `readed` = 0");
		$user_notifications_r = intval(mysqli_num_rows($check_notifications_r));
	}

?>
<?php
	$check_follow_1 = mysqli_query($connect, "SELECT * FROM `follows` WHERE `followed_id` = '$user_id' AND `follower_id` = '$user2_id' AND `confirm` = 1");
	$check_follow_0 = mysqli_query($connect, "SELECT * FROM `follows` WHERE `followed_id` = '$user_id' AND `follower_id` = '$user2_id' AND `confirm` = 0");

	$result_follow = 'unfollowed';
	if (mysqli_num_rows($check_follow_1) > 0) {
		$result_follow = 'followed';
	} if (mysqli_num_rows($check_follow_0) > 0) {
		$result_follow = 'follow_wait';
	}

	$check_follow_to_you = mysqli_query($connect, "SELECT * FROM `follows` WHERE `followed_id` = '$user_id' AND `confirm` = 0");
	if ($user_id == $user2_id) {
		$value_followed_wait_toyou = mysqli_num_rows($check_follow_to_you);
	} else {
		$value_followed_wait_toyou = 0;
	}
?>
<?php
	if ($user_id == $user2_id) {
		$value_you = 1;
	} else {
		$value_you = 0;
	}

	$user_dialog_no_read = 0;

	if ($user_id == $user2_id) {
		$check_dialog_no_read = mysqli_query($connect, "SELECT * FROM `dialog` WHERE `uid` = '$user_id' AND `recive` = '$user_id' AND `status` = 0 OR `uid2` = '$user_id' AND `recive` = '$user_id' AND `status` = 0");
		$user_dialog_no_read = mysqli_num_rows($check_dialog_no_read);
	}

	$onlineTIME = intval(1023235200);
	// $randNMDate = rand(1, 3);
	// if ($randNMDate == 1) {
	// 	$onlineTIME = intval(1039554000);
	// } if ($randNMDate == 2) {
	// 	$onlineTIME = intval(1239148800);
	// } if ($randNMDate == 3) {
	// 	$onlineTIME = intval(1023235200);
	// }
	if ($user_id == $user2_id or $user['show_online'] == 1) {
		$onlineTIME = intval($user['online']);
	}

	$check_blacklist = mysqli_query($connect, "SELECT * FROM `black_list` WHERE `user_blocker` = '$user2_id' AND `user_blocked` = '$user_id' LIMIT 1");
	$m_banned = mysqli_num_rows($check_blacklist);
?>
<?php
	if (mysqli_num_rows($check_user) > 0) {

		$show_m_url = intval($user['show_url']);
		if ($value_you == 1) {
			$show_m_url = intval(1);
		}

		if (mysqli_num_rows($check_user2) > 0) {} else {
			$show_m_url = intval(0);
		}

		$array_contacts = array();
		if ($show_m_url == 1) {
			if ($user['url_site'] != '') {
				$array_contacts += array("site"=>strval($user['url_site']));
			}
			if ($user['url_social'] != '') {
				$array_contacts += array("social"=>strval($user['url_social']));
			}
			if ($user['url_phone'] != '') {
				$array_contacts += array("phone"=>strval($user['url_phone']));
			}
			if ($user['url_email'] != '') {
				$array_contacts += array("email"=>strval($user['url_email']));
			}
		}

		if ($user['banned'] == 0) {} else {
			echo json_encode(array(
				"id" => "id_user_data_banned",
				"type" => "success", 
				"type_user" => "user", 
				"task" => "user:data:success", 
				"camp" => "server", 
				"message" => 'Этот аккаунт заблокирован!',
				"id_user" => 0,
				"login" => $user['login'],
				"name" => "Unknown",
				"avatar" => null,
				"status" => null,
				"date_registration" => "1970-01-01 00:00:01",
				"online" => $onlineTIME,
				"scam" => intval($user['scam']),
				"public_post" => intval($user['public_post']),
				"urang" => intval($user['urang']),
				"ustatus" => intval($user['status']),
				"you" => 0,
				"m_banned" => intval($m_banned),
				"contacts" => json_encode($array_contacts),
				"user_posts" => 0,
				"user_notifications" => 0,
				"user_notifications_r" => 0,
				"user_followers" => 0,
				"user_following" => 0,
				"user_followed_you" => $result_follow,
				"user_followed_toyou_wait" => 0,
				"user_verification" => intval(0),
				"user_verification_type" => strval('0'),
				"user_show_online" => intval(0),
				"user_private_message" => intval(0),
				"user_dialog_no_read" => intval(0),
				"user_show_url" => intval(0),
				"time" => $serverTIME
			), 128);
			exit();
		}


		if ($user['private'] == 0 or $user_id == $user2_id or mysqli_num_rows($check_follow_1) > 0) {} else {
			echo json_encode(array(
				"id" => "id_user_data_private",
				"type" => "success", 
				"type_user" => "user", 
				"task" => "user:data:success", 
				"camp" => "server", 
				"message" => 'Это приватный аккаунт, полная информация недоступна!',
				"id_user" => $user_id,
				"login" => $user['login'],
				"name" => "Unknown",
				"avatar" => strval($user['avatar']),
				"status" => strval($user['status']),
				"date_registration" => "1970-01-01 00:00:01",
				"online" => $onlineTIME,
				"scam" => intval($user['scam']),
				"public_post" => intval($user['public_post']),
				"urang" => intval($user['rang']),
				"ustatus" => intval($user['status']),
				"you" => $value_you,
				"m_banned" => intval($m_banned),
				"contacts" => json_encode($array_contacts),
				"user_posts" => intval($user_posts),
				"user_notifications" => intval($user_notifications),
				"user_notifications_r" => intval($user_notifications_r),
				"user_followers" => intval($user_followers),
				"user_following" => intval($user_following),
				"user_followed_you" => strval($result_follow),
				"user_followed_toyou_wait" => intval($value_followed_wait_toyou),
				"user_verification" => intval($user['verification']),
				"user_verification_type" => strval($user['verification_type']),
				"user_show_online" => intval($user['show_online']),
				"user_private_message" => intval($user['private_message']),
				"user_dialog_no_read" => intval($user_dialog_no_read),
				"user_show_url" => intval(0),
				"time" => $serverTIME
			), 128);
			exit();
		}


		echo json_encode(array(
			"id" => "id_user_data_success",
			"type" => "success", 
			"type_user" => "user", 
			"task" => "user:data:success", 
			"camp" => "server", 
			"message" => 'Полная информация о пользовотеле: @'.$user['login'],
			"id_user" => intval($user_id),
			"login" => $user['login'],
			"name" => htmlspecialchars($user['name']),
			"avatar" => $user['avatar'],
			"status" => strval($user['status']),
			"date_registration" => $user['date_registration'],
			"online" => $onlineTIME,
			"scam" => intval($user['scam']),
			"public_post" => intval($user['public_post']),
			"urang" => intval($user['rang']),
			"ustatus" => intval($user['status']),
			"you" => $value_you,
			"m_banned" => intval($m_banned),
			"contacts" => json_encode($array_contacts),
			"user_posts" => intval($user_posts),
			"user_notifications" => intval($user_notifications),
			"user_notifications_r" => intval($user_notifications_r),
			"user_followers" => intval($user_followers),
			"user_following" => intval($user_following),
			"user_followed_you" => strval($result_follow),
			"user_followed_toyou_wait" => intval($value_followed_wait_toyou),
			"user_verification" => intval($user['verification']),
			"user_verification_type" => strval($user['verification_type']),
			"user_show_online" => intval($user['show_online']),
			"user_private_message" => intval($user['private_message']),
			"user_dialog_no_read" => intval($user_dialog_no_read),
			"user_show_url" => $show_m_url,
			"time" => $serverTIME
		), 128);
		exit();


	} else {


		echo json_encode(array(
			"id" => "id_user_data_error",
			"type" => "error", 
			"type_user" => "unknown", 
			"task" => "user:data:error", 
			"camp" => "server", 
			"message" => 'Данного пользователя не существует!',
			"id_user" => "null",
			"login" => "unknown",
			"name" => "Unknown",
			"avatar" => null,
			"status" => null,
			"date_registration" => "1970-01-01 00:00:01",
			"online" => $onlineTIME,
			"scam" => intval($user['scam']),
			"public_post" => intval($user['public_post']),
			"urang" => intval($user['rang']),
			"ustatus" => intval($user['status']),
			"you" => 0,
			"m_banned" => intval($m_banned),
			"contacts" => json_encode($array_contacts),
			"user_posts" => 0,
			"user_notifications" => 0,
			"user_notifications_r" => 0,
			"user_followers" => 0,
			"user_following" => 0,
			"user_followed_you" => $result_follow,
			"user_followed_toyou_wait" => 0,
			"user_verification" => intval(0),
			"user_verification_type" => strval('0'),
			"user_show_online" => intval(0),
			"user_private_message" => intval(0),
			"user_dialog_no_read" => intval(0),
			"user_show_url" => intval(0),
			"time" => $serverTIME
		), 128);
		exit();


	}
?>