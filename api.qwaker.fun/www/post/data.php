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
	$id = trim(mysqli_real_escape_string($connect, $_GET['id']));
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
?>
<?php
	$check_post = mysqli_query($connect, "SELECT * FROM `posts` WHERE `id` = '$id' OR `post_id` = '$id' AND `archive` = 0 AND `date_view` < '$timeUSER'");

	if (mysqli_num_rows($check_post) > 0) {
		$post = mysqli_fetch_assoc($check_post);

		$post_views_upd = $post['views']+1;

		$user_id_post = intval($post['user_id']);
		$id_post = intval($post['id']);

		$check_user_post = mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '$user_id_post' LIMIT 1");
		$check_comments_post = mysqli_query($connect, "SELECT * FROM `comments` WHERE `post_id` = '$id_post' LIMIT 1");
		$check_post_my_comment = mysqli_query($connect, "SELECT * FROM `comments` WHERE `post_id` = '$id_post' AND `user_id` = '$user_id_post' LIMIT 1");

		$check_blacklist = mysqli_query($connect, "SELECT * FROM `black_list` WHERE `user_blocker` = '$user_id_post' AND `user_blocked` = '$user2_id' LIMIT 1");
		if (mysqli_num_rows($check_blacklist) > 0) {
			exit();
		}

		if (mysqli_num_rows($check_user_post) > 0) {
			$user_post = mysqli_fetch_assoc($check_user_post);
			$user_post_id = intval($user_post['id']);
			$user_post_login = strval($user_post['login']);
			$user_post_name = strval(htmlspecialchars($user_post['name']));
			$user_post_avatar = strval($user_post['avatar']);
			$user_post_language = strval($user_post['language']);
			$user_post_verification = intval($user_post['verification']);
		} else {
			$user_post_id = null;
			$user_post_login = 'unknown';
			$user_post_name = 'Unknown';
			$user_post_avatar = 'unknown';
			$user_post_language = 'en';
			$user_post_verification = intval(0);
			exit();
		}

		if ($user_post['private'] == 0 or $user_id_post == $user2_id) {} else {
			$check_follow = mysqli_query($connect, "SELECT * FROM `follows` WHERE `followed_id` = '$user_id_post' AND `follower_id` = '$user2_id' AND `confirm` = 1");
			if (mysqli_num_rows($check_follow) > 0) {} else {
				exit();
			}
		}


		$you_post = 0;
		if ($post['public_id'] == $user2_id) {
			$you_post = 1;
		}

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


		// EMOTIONS ------------------------------------------------------------------------------------------------------------------
		$emotions_like = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM `post_emotions` WHERE `pid` = '$id_post' AND `type` = 'like'"));
		$emotions_dislike = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM `post_emotions` WHERE `pid` = '$id_post' AND `type` = 'dislike'"));
		$emotions_heart = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM `post_emotions` WHERE `pid` = '$id_post' AND `type` = 'heart'"));
		$emotions_respect = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM `post_emotions` WHERE `pid` = '$id_post' AND `type` = 'respect'"));
		$emotions_shit = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM `post_emotions` WHERE `pid` = '$id_post' AND `type` = 'shit'"));

		$array_emotions = array();
		$array_emotions += array("likes"=>strval($emotions_like));
		$array_emotions += array("dislikes"=>strval($emotions_dislike));
		$array_emotions += array("hearts"=>strval($emotions_heart));
		$array_emotions += array("respects"=>strval($emotions_respect));
		$array_emotions += array("shits"=>strval($emotions_shit));
		// EMOTIONS ------------------------------------------------------------------------------------------------------------------

		// MY-EMOTIONS ---------------------------------------------------------------------------------------------------------------
		$my_emotion_like = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM `post_emotions` WHERE `pid` = '$id_post' AND `uid` = '$user2_id' AND `type` = 'like' LIMIT 1"));
		$my_emotion_dislike = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM `post_emotions` WHERE `pid` = '$id_post' AND `uid` = '$user2_id' AND `type` = 'dislike' LIMIT 1"));
		$my_emotion_heart = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM `post_emotions` WHERE `pid` = '$id_post' AND `uid` = '$user2_id' AND `type` = 'heart' LIMIT 1"));
		$my_emotion_respect = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM `post_emotions` WHERE `pid` = '$id_post' AND `uid` = '$user2_id' AND `type` = 'respect'"));
		$my_emotion_shit = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM `post_emotions` WHERE `pid` = '$id_post' AND `uid` = '$user2_id' AND `type` = 'shit' LIMIT 1"));

		$array_my_emotion = array();
		$array_my_emotion += array("like"=>strval($my_emotion_like));
		$array_my_emotion += array("dislike"=>strval($my_emotion_dislike));
		$array_my_emotion += array("heart"=>strval($my_emotion_heart));
		$array_my_emotion += array("respect"=>strval($my_emotion_respect));
		$array_my_emotion += array("shit"=>strval($my_emotion_shit));
		// MY-EMOTIONS ---------------------------------------------------------------------------------------------------------------


		if ($post['archive'] == 0 or $post['public_id'] == $user2_id) {
			echo json_encode(array(
				"type" => "success",
				"task" => "post:data:success", 
				"camp" => "server", 
				"id" => intval($post['id']),
				"post_id" => strval($post['post_id']),
				"post_message" => strval(htmlspecialchars($post['message'])),
				"post_title" => strval(htmlspecialchars($post['title'])),
				"post_date_public" => strval($post['date_public']),
				"post_language" => strval($post['language']),
				"post_commented" => intval($post['commented']),
				"post_you" => intval($you_post),
				"post_comments" => intval(mysqli_num_rows($check_comments_post)),
				"post_my_comment" => intval(mysqli_num_rows($check_post_my_comment)),
				"post_images" => json_encode($array_images),
				"post_views" => intval($post['views']),
				"post_emotions" => json_decode(json_encode($array_emotions)),
				"post_my_emotion" => json_decode(json_encode($array_my_emotion)),
				"user_id" => $user_post_id,
				"user_login" => $user_post_login,
				"user_name" => htmlspecialchars($user_post_name),
				"user_avatar" => $user_post_avatar,
				"user_language" => $user_post_language,
				"user_verification" => $user_post_verification
			), 128);

			mysqli_query($connect, "UPDATE `posts` SET `views`='$post_views_upd' WHERE `id`='$id_post'");

			// $post_category = $post['category'].' '.$user2['fav_posts'];
			// mysqli_query($connect, "UPDATE `users` SET `fav_posts`='$post_category' WHERE `id`='$user2_id'");

			exit();
		}



		echo normJsonStr(json_encode(array(
			"type" => "error",
			"task" => "post:data:error", 
			"camp" => "server", 
			"id" => intval(0),
			"post_id" => strval('null'),
			"post_title" => strval('null'),
			"post_message" => strval('Автор скрыл эту запись - просмотр не доступен!'),
			"post_title" => strval('null'),
			"post_date_public" => strval('1970-01-01 03.00.00'),
			"post_language" => strval('en'),
			"post_you" => intval(0),
			"post_likes" => intval(0),
			"post_my_like" => intval(0),
			"post_dislikes" => intval(0),
			"post_my_dislike" => intval(0),
			"post_my_comment" => intval(0),
			"post_images" => '',
			"post_views" => intval(0),
			"user_id" => intval(0),
			"user_login" => 'unknown',
			"user_name" => 'Unknown',
			"user_avatar" => 'unknown',
			"user_language" => 'en',
			"user_verification" => intval(0)
		)));
		exit();
	}
?>