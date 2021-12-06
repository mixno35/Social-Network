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
	$sid = trim(mysqli_real_escape_string($connect, $_GET['sid']));
?>
<?php
	$check_sid = mysqli_query($connect, "SELECT * FROM `user_sessions` WHERE `sid` = '$sid' LIMIT 1");
	if (mysqli_num_rows($check_sid) > 0) {
		$data_sid = mysqli_fetch_assoc($check_sid);
		$uid_sid = $data_sid['uid'];

		mysqli_query($connect, "UPDATE `user_sessions` SET `lasttime`='$timeUSER' WHERE `sid`='$sid'");

		if (checkIP($data_sid['uip'])) {} else {
			echo('false');
			exit();
		}

		$check_user_sid = mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '$uid_sid' LIMIT 1");
		if (mysqli_num_rows($check_user_sid) > 0) {
			$user_sid = mysqli_fetch_assoc($check_user_sid);
			$token = $user_sid['token'];
		} else {
			echo('false');
			exit();
		}
	} else {
		echo('false');
		exit();
	}

	echo('true');
?>