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
?>
<?php
	$check_session = mysqli_query($connect, "SELECT * FROM `user_sessions` WHERE `sid` = '$token' LIMIT 1");
	if (mysqli_num_rows($check_session) > 0) {
		$session = mysqli_fetch_assoc($check_session);

		mysqli_query($connect, "UPDATE `user_sessions` SET `lasttime`='$timeUSER' WHERE `sid`='$token'");
	}
?>
<?php
	if (mysqli_num_rows($check_session) > 0 and intval($session['maxtime']) > intval(time())) {
		echo 'true';
		exit();
	} else {
		echo 'false';
		exit();
	}
?>