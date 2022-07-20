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
	$limit = intval($_GET['limit']);
	$hashtag = trim(mysqli_real_escape_string($connect, $_GET['hashtag']));
	if ($limit < 100) {
		$limit = 100;
	}

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
	$check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `token` = '$token' LIMIT 1");
	if (mysqli_num_rows($check_user) > 0) {
		$user = mysqli_fetch_assoc($check_user);
		$user_id = intval($user['id']);

		mysqli_query($connect, "UPDATE `users` SET `online`='$timeUSER' WHERE `id`='$user_id'");
	} else {
		exit();
	}

	if ($user['banned'] == 0) {} else {
		exit();
	}
?>
<?php

	$check_category = mysqli_query($connect, "SELECT * FROM `post_category_favourites` WHERE `uid` = '$user_id'");

	$result_category = array();
	$result_category[] = intval(0);
	$result_category[] = intval(999);
	while($row = mysqli_fetch_assoc($check_category)) {
		$result_category[] = intval($row['category']);
	}

	$user_like = $user['like_posts'];
	$user_language = $user['language'];

	sleep(1);

	$postTAGNUM = 0;

	if (strlen($hashtag) > 3) {
		if (preg_match_all('~#+\S+~', $hashtag, $postTAG)) {
			foreach($postTAG[0] as $usedTAG) {
				$postTAGNUM = intval($postTAGNUM + 1);
			}
		}
	}

	// $check_post = mysqli_query($connect, "SELECT * FROM `posts` WHERE `category` LIKE '$user_like' AND `archive` = 0 ORDER BY date_public DESC");
	if (strlen($hashtag) > 3) {
		$check_post = mysqli_query($connect, "SELECT * FROM `posts` WHERE `message` LIKE '%hashtag%' AND `archive` = 0 AND `date_view` < '$timeUSER' ORDER BY date_public DESC LIMIT $limit");
	} else {
		$check_post = mysqli_query($connect, "SELECT * FROM `posts` WHERE `language` = '$user_language' AND `category` IN('" . implode("','", $result_category) . "') AND `archive` = 0 AND `date_view` < '$timeUSER' ORDER BY date_public DESC LIMIT $limit");
	}

	$num_posts = mysqli_num_rows($check_post);
?>
<?php
	echo('[');
	while($row = mysqli_fetch_assoc($check_post)) {
		$user_id_post = intval($row['user_id']);
		$id_post = intval($row['id']);

		$check_user_post = mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '$user_id_post' LIMIT 1");
		$check_comments_post = mysqli_query($connect, "SELECT * FROM `comments` WHERE `post_id` = '$id_post'");
		$check_post_my_comment = mysqli_query($connect, "SELECT * FROM `comments` WHERE `post_id` = '$id_post' AND `user_id` = '$user_id_post' LIMIT 1");

		if (mysqli_num_rows($check_user_post) > 0) {
			$user_post = mysqli_fetch_assoc($check_user_post);
			if ($user_post['banned'] == 0) {
				$user_post_id = intval($user_post['id']);
				$user_post_login = strval($user_post['login']);
				$user_post_name = strval($user_post['name']);
				$user_post_avatar = strval($user_post['avatar']);
				$user_post_language = strval($user_post['language']);
				$user_post_verification = intval($user_post['verification']);
			} else {
				$user_post_id = null;
				$user_post_login = strval($user_post['login']);
				$user_post_name = 'Unknown';
				$user_post_avatar = 'unknown';
				$user_post_language = 'en';
				$user_post_verification = intval(0);
			}
		} else {
			$user_post_id = null;
			$user_post_login = strval($user_post['login']);
			$user_post_name = 'Unknown';
			$user_post_avatar = 'unknown';
			$user_post_language = 'en';
			$user_post_verification = intval(0);
		}

		$value_you = 0;
		if ($user_id_post == $user_id) {
			$value_you = 1;
		}

		$array_images = array();
		$array_images_num = 0;
		if ($row['image1'] != '') {
			$array_images += array($array_images_num=>strval($row['image1']));
			$array_images_num = $array_images_num+1;
		} if ($row['image2'] != '') {
			$array_images += array($array_images_num=>strval($row['image2']));
			$array_images_num = $array_images_num+1;
		} if ($row['image3'] != '') {
			$array_images += array($array_images_num=>strval($row['image3']));
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
		$my_emotion_like = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM `post_emotions` WHERE `pid` = '$id_post' AND `uid` = '$user_id' AND `type` = 'like' LIMIT 1"));
		$my_emotion_dislike = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM `post_emotions` WHERE `pid` = '$id_post' AND `uid` = '$user_id' AND `type` = 'dislike' LIMIT 1"));
		$my_emotion_heart = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM `post_emotions` WHERE `pid` = '$id_post' AND `uid` = '$user_id' AND `type` = 'heart' LIMIT 1"));
		$my_emotion_respect = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM `post_emotions` WHERE `pid` = '$id_post' AND `uid` = '$user_id' AND `type` = 'respect'"));
		$my_emotion_shit = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM `post_emotions` WHERE `pid` = '$id_post' AND `uid` = '$user_id' AND `type` = 'shit' LIMIT 1"));

		$array_my_emotion = array();
		$array_my_emotion += array("like"=>strval($my_emotion_like));
		$array_my_emotion += array("dislike"=>strval($my_emotion_dislike));
		$array_my_emotion += array("heart"=>strval($my_emotion_heart));
		$array_my_emotion += array("respect"=>strval($my_emotion_respect));
		$array_my_emotion += array("shit"=>strval($my_emotion_shit));
		// MY-EMOTIONS ---------------------------------------------------------------------------------------------------------------

		$videoARRAY = json_encode(array(
			"url" => strval($row['video1'])
		), 128);

		$num_posts = $num_posts - 1;
		echo json_encode(array(
			"id" => intval($row['id']),
			"post_id" => strval(htmlspecialchars($row['post_id'])),
			"post_message" => strval(htmlspecialchars($row['message'])),
			"post_title" => strval(htmlspecialchars($row['title'])),
			"post_date_public" => strval($row['date_public']),
			"post_date_view" => intval($row['date_view']),
			"post_language" => strval($row['language']),
			"post_type" => strval($row['type']),
			"post_you" => intval($value_you),
			"post_clip" => intval($row['clip']),
			"post_comments" => intval(mysqli_num_rows($check_comments_post)),
			"post_images" => json_encode($array_images),
			"post_my_comment" => mysqli_num_rows($check_post_my_comment),
			"post_views" => intval($row['views']),
			"post_emotions" => json_decode(json_encode($array_emotions)),
			"post_my_emotion" => json_decode(json_encode($array_my_emotion)),
			"post_video" => json_decode($videoARRAY),
			"user_id" => intval($user_post_id),
			"user_login" => $user_post_login,
			"user_name" => strval(htmlspecialchars($user_post_name)),
			"user_avatar" => $user_post_avatar,
			"user_language" => $user_post_language,
			"user_verification" => $user_post_verification
		), 128);
		if ($num_posts != 0) {
			echo(',');
		}
	}
	echo(']');
?>