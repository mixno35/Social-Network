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

	$tokenHIS = $token;

	$checkSESSION = mysqli_query($connect, "SELECT * FROM `user_sessions` WHERE `sid` = '$token' LIMIT 1");
	if (mysqli_num_rows($checkSESSION) > 0) {
		$session = mysqli_fetch_assoc($checkSESSION);
		$sessionUTOKEN = $session['utoken'];
		$check_u = mysqli_query($connect, "SELECT * FROM `users` WHERE `token_public` = '$sessionUTOKEN' LIMIT 1");
		if (mysqli_num_rows($check_u) > 0) {
			$sUSER = mysqli_fetch_assoc($check_u);
			$token = $sUSER['token'];
			$tokenMD5 = $sUSER['token_public'];
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

	if ($user2['banned'] == 1) {
		exit();
	}
?>
<?php
	$check_sessions = mysqli_query($connect, "SELECT * FROM `user_sessions` WHERE `utoken` = '$tokenMD5' ORDER BY lasttime DESC LIMIT 20");
	$num_session = mysqli_num_rows($check_sessions);

	echo('[');
	while($row = mysqli_fetch_assoc($check_sessions)) {
		$num_session = $num_session - 1;

		$session_active = 0;
		if ($row['sid'] == $tokenHIS) {
			$session_active = 1;
		}

		echo json_encode(array(
			"id" => intval($row['id']),
			"type" => strval($row['type']),
			"active" => intval($session_active),
			"uagent" => strval($row['uagent']),
			"uip" => strval($row['uip']),
			"time" => $row['time'],
			"lasttime" => $row['lasttime'],
			"maxtime" => $row['maxtime']
		), 128);

		if ($num_session != 0) {
			echo(',');
		}
	}
	echo(']');
?>