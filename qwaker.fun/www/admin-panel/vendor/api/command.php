<?php include $_SERVER['DOCUMENT_ROOT'].'/admin-panel/vendor/data.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/admin-panel/vendor/connect.php'; ?>
<?php
	if (!function_exists('str_starts_with')) {
	    function str_starts_with($haystack, $needle) {
	        return (string)$needle !== '' && strncmp($haystack, $needle, strlen($needle)) === 0;
	    }
	}
?>
<?php
	$token = trim(mysqli_real_escape_string($connect, $_COOKIE['USID']));
	$sessionUTOKEN = "";
	$dataUSER = "";
	$mid = 0;

	$checkSESSION = mysqli_query($connect, "SELECT * FROM `user_sessions` WHERE `sid` = '$token' LIMIT 1");
	if (mysqli_num_rows($checkSESSION) > 0) {
		$session = mysqli_fetch_assoc($checkSESSION);
		$sessionUTOKEN = $session['utoken'];
	} else {
		echo("Неизвестная сессия");
		exit();
	}

	$checkUSER = mysqli_query($connect, "SELECT * FROM `users` WHERE `token_public` = '$sessionUTOKEN' LIMIT 1");
	if (mysqli_num_rows($checkUSER) > 0) {
		$dataUSER = mysqli_fetch_assoc($checkUSER);
		$mid = intval($dataUSER['id']);
	} else {
		echo("Неизвестный пользователь");
		exit();
	}

	if ($dataUSER['rang'] > 1) {} else {
		echo("Нет доступа. Нет привелегий");
		exit();
	}

	if ($dataUSER['banned'] == 1) {
		echo("Нет доступа. Аккаунт заблокирован");
		exit();
	}

	if ($dataUSER['scam'] == 1) {
		echo("Нет доступа. Скам");
		exit();
	}
?>
<?php
	$command = trim(mysqli_real_escape_string($connect, $_POST['command']));
	$command_archive = $command;
	$command = explode(" ", $command, 4);

	if (trim($command[0]) == "") {
		echo("Комана не может быть пустой");
		exit();
	}

	if (str_starts_with($command[0], "/")) {} else {
		echo("Комана должна начинаться с \"/\"");
		exit();
	}

	// USERS ------------------------------------------------------------------------------------------------------------

	if ($command[0] === "/ban") { // User ban
		if ($dataUSER['rang'] < 3) {
			echo("Ваш ранг слишком мал для использвания команды \"".$command[0]."\"");
			exit();
		}
		$uid = intval($command[1]);
		if ($uid == $mid) {
			echo("Нельзя управлять собой же");
			exit();
		}
		$checkUSERCOM = mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '$uid' LIMIT 1");
		if (mysqli_num_rows($checkUSERCOM) > 0) {
			$dataUSERCOM = mysqli_fetch_assoc($checkUSERCOM);
			if (mysqli_query($connect, "UPDATE `users` SET `banned`=1, `date_banned`='$serverTIME' WHERE `id`='$uid'")) {
				echo("Пользователь @".$dataUSERCOM['login']." заблокирован");
				mysqli_query($connect, "INSERT INTO `admin_command`(`command`, `uid`, `time`) VALUES ('$command_archive', '$mid', '$timeUSER')");
			} else {
				echo("Ошибка выполнения команды \"".$command[0]."\". Повторите попытку позже");
			}
		} else {
			echo("Пользователя под id$uid не существует");
		}
		
		exit();
	} 
	if ($command[0] === "/unban") { // User unban
		if ($dataUSER['rang'] < 3) {
			echo("Ваш ранг слишком мал для использвания команды \"".$command[0]."\"");
			exit();
		}
		$uid = intval($command[1]);
		if ($uid == $mid) {
			echo("Нельзя управлять собой же");
			exit();
		}
		$checkUSERCOM = mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '$uid' LIMIT 1");
		if (mysqli_num_rows($checkUSERCOM) > 0) {
			$dataUSERCOM = mysqli_fetch_assoc($checkUSERCOM);
			if (mysqli_query($connect, "UPDATE `users` SET `banned`=0 WHERE `id`='$uid'")) {
				echo("Пользователь @".$dataUSERCOM['login']." разблокирован");
				mysqli_query($connect, "INSERT INTO `admin_command`(`command`, `uid`, `time`) VALUES ('$command_archive', '$mid', '$timeUSER')");
			} else {
				echo("Ошибка выполнения команды \"".$command[0]."\". Повторите попытку позже");
			}
		} else {
			echo("Пользователя под id$uid не существует");
		}

		exit();
	}

	if ($command[0] === "/scam") { // User scam
		if ($dataUSER['rang'] < 3) {
			echo("Ваш ранг слишком мал для использвания команды \"".$command[0]."\"");
			exit();
		}
		$uid = intval($command[1]);
		if ($uid == $mid) {
			echo("Нельзя управлять собой же");
			exit();
		}
		$checkUSERCOM = mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '$uid' LIMIT 1");
		if (mysqli_num_rows($checkUSERCOM) > 0) {
			$dataUSERCOM = mysqli_fetch_assoc($checkUSERCOM);
			if (mysqli_query($connect, "UPDATE `users` SET `scam`=1 WHERE `id`='$uid'")) {
				echo("Пользователю @".$dataUSERCOM['login']." выдана отметка \"Скам\"");
				mysqli_query($connect, "INSERT INTO `admin_command`(`command`, `uid`, `time`) VALUES ('$command_archive', '$mid', '$timeUSER')");
			} else {
				echo("Ошибка выполнения команды \"".$command[0]."\". Повторите попытку позже");
			}
		} else {
			echo("Пользователя под id$uid не существует");
		}

		exit();
	} 
	if ($command[0] === "/unscam") { // User unscam
		if ($dataUSER['rang'] < 3) {
			echo("Ваш ранг слишком мал для использвания команды \"".$command[0]."\"");
			exit();
		}
		$uid = intval($command[1]);
		if ($uid == $mid) {
			echo("Нельзя управлять собой же");
			exit();
		}
		$checkUSERCOM = mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '$uid' LIMIT 1");
		if (mysqli_num_rows($checkUSERCOM) > 0) {
			$dataUSERCOM = mysqli_fetch_assoc($checkUSERCOM);
			if (mysqli_query($connect, "UPDATE `users` SET `scam`=0 WHERE `id`='$uid'")) {
				echo("Для пользователя @".$dataUSERCOM['login']." убрана отметка \"Скам\"");
				mysqli_query($connect, "INSERT INTO `admin_command`(`command`, `uid`, `time`) VALUES ('$command_archive', '$mid', '$timeUSER')");
			} else {
				echo("Ошибка выполнения команды \"".$command[0]."\". Повторите попытку позже");
			}
		} else {
			echo("Пользователя под id$uid не существует");
		}
		
		exit();
	} 

	if ($command[0] === "/rang") { // User rang 1-4
		if ($dataUSER['rang'] < 4) {
			echo("Ваш ранг слишком мал для использвания команды \"".$command[0]."\"");
			exit();
		}
		$uid = intval($command[1]);
		if ($uid == $mid) {
			echo("Нельзя управлять собой же");
			exit();
		}
		$rang = intval($command[2]);
		if ($rang < 1 or $rang > 4) {
			echo("Некорректное значение для ранга. Используйте ранг от 1 до 4");
			exit();
		}
		$checkUSERCOM = mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '$uid' LIMIT 1");
		if (mysqli_num_rows($checkUSERCOM) > 0) {
			$dataUSERCOM = mysqli_fetch_assoc($checkUSERCOM);
			if (mysqli_query($connect, "UPDATE `users` SET `rang`='$rang' WHERE `id`='$uid'")) {
				echo("Для пользователя @".$dataUSERCOM['login']." установлен ".$rang." ранг");
				mysqli_query($connect, "INSERT INTO `admin_command`(`command`, `uid`, `time`) VALUES ('$command_archive', '$mid', '$timeUSER')");
			} else {
				echo("Ошибка выполнения команды \"".$command[0]."\". Повторите попытку позже");
			}
		} else {
			echo("Пользователя под id$uid не существует");
		}
		
		exit();
	} 

	if ($command[0] === "/verification") { // User verification
		if ($dataUSER['rang'] < 4) {
			echo("Ваш ранг слишком мал для использвания команды \"".$command[0]."\"");
			exit();
		}
		$uid = intval($command[1]);
		if ($uid == $mid) {
			echo("Нельзя управлять собой же");
			exit();
		}
		$status = intval($command[2]);
		$statusTEXT = "убрана";
		if ($status < 0 or $status > 1) {
			$status = 0;
		} if ($status == 1) {
			$statusTEXT = "установлена";
		}
		$checkUSERCOM = mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '$uid' LIMIT 1");
		if (mysqli_num_rows($checkUSERCOM) > 0) {
			$dataUSERCOM = mysqli_fetch_assoc($checkUSERCOM);
			if (mysqli_query($connect, "UPDATE `users` SET `verification`='$status' WHERE `id`='$uid'")) {
				echo("Для пользователя @".$dataUSERCOM['login']." ".$statusTEXT." верификация");
				mysqli_query($connect, "INSERT INTO `admin_command`(`command`, `uid`, `time`) VALUES ('$command_archive', '$mid', '$timeUSER')");
			} else {
				echo("Ошибка выполнения команды \"".$command[0]."\". Повторите попытку позже");
			}
		} else {
			echo("Пользователя под id$uid не существует");
		}
		
		exit();
	} 

	if ($command[0] === "/upubpost") { // User public post
		if ($dataUSER['rang'] < 3) {
			echo("Ваш ранг слишком мал для использвания команды \"".$command[0]."\"");
			exit();
		}
		$uid = intval($command[1]);
		if ($uid == $mid) {
			echo("Нельзя управлять собой же");
			exit();
		}
		$status = intval($command[2]);
		$statusTEXT = "убрана";
		if ($status < 0 or $status > 1) {
			$status = 0;
		} if ($status == 1) {
			$statusTEXT = "установлена";
		}
		$checkUSERCOM = mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '$uid' LIMIT 1");
		if (mysqli_num_rows($checkUSERCOM) > 0) {
			$dataUSERCOM = mysqli_fetch_assoc($checkUSERCOM);
			if (mysqli_query($connect, "UPDATE `users` SET `public_post`='$status' WHERE `id`='$uid'")) {
				echo("Для пользователя @".$dataUSERCOM['login']." ".$statusTEXT." возможнасть публиковать новые публикации");
				mysqli_query($connect, "INSERT INTO `admin_command`(`command`, `uid`, `time`) VALUES ('$command_archive', '$mid', '$timeUSER')");
			} else {
				echo("Ошибка выполнения команды \"".$command[0]."\". Повторите попытку позже");
			}
		} else {
			echo("Пользователя под id$uid не существует");
		}
		
		exit();
	} 

	if ($command[0] === "/uchatj") { // User chat joined
		if ($dataUSER['rang'] < 3) {
			echo("Ваш ранг слишком мал для использвания команды \"".$command[0]."\"");
			exit();
		}
		$uid = intval($command[1]);
		if ($uid == $mid) {
			echo("Нельзя управлять собой же");
			exit();
		}
		$status = intval($command[2]);
		$statusTEXT = "убрана";
		if ($status < 0 or $status > 1) {
			$status = 0;
		} if ($status == 1) {
			$statusTEXT = "установлена";
		}
		$checkUSERCOM = mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '$uid' LIMIT 1");
		if (mysqli_num_rows($checkUSERCOM) > 0) {
			$dataUSERCOM = mysqli_fetch_assoc($checkUSERCOM);
			if (mysqli_query($connect, "UPDATE `users` SET `chat_joined`='$status' WHERE `id`='$uid'")) {
				echo("Для пользователя @".$dataUSERCOM['login']." ".$statusTEXT." возможнасть присоединяться к чатам");
				mysqli_query($connect, "INSERT INTO `admin_command`(`command`, `uid`, `time`) VALUES ('$command_archive', '$mid', '$timeUSER')");
			} else {
				echo("Ошибка выполнения команды \"".$command[0]."\". Повторите попытку позже");
			}
		} else {
			echo("Пользователя под id$uid не существует");
		}
		
		exit();
	} 

	if ($command[0] === "/uchatc") { // User chat creating
		if ($dataUSER['rang'] < 3) {
			echo("Ваш ранг слишком мал для использвания команды \"".$command[0]."\"");
			exit();
		}
		$uid = intval($command[1]);
		if ($uid == $mid) {
			echo("Нельзя управлять собой же");
			exit();
		}
		$status = intval($command[2]);
		$statusTEXT = "убрана";
		if ($status < 0 or $status > 1) {
			$status = 0;
		} if ($status == 1) {
			$statusTEXT = "установлена";
		}
		$checkUSERCOM = mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '$uid' LIMIT 1");
		if (mysqli_num_rows($checkUSERCOM) > 0) {
			$dataUSERCOM = mysqli_fetch_assoc($checkUSERCOM);
			if (mysqli_query($connect, "UPDATE `users` SET `chat_creating`='$status' WHERE `id`='$uid'")) {
				echo("Для пользователя @".$dataUSERCOM['login']." ".$statusTEXT." возможнасть создавать новые чаты");
				mysqli_query($connect, "INSERT INTO `admin_command`(`command`, `uid`, `time`) VALUES ('$command_archive', '$mid', '$timeUSER')");
			} else {
				echo("Ошибка выполнения команды \"".$command[0]."\". Повторите попытку позже");
			}
		} else {
			echo("Пользователя под id$uid не существует");
		}
		
		exit();
	} 
	if ($command[0] === "/makerequestfollow") { // User request
		if ($dataUSER['rang'] < 4) {
			echo("Ваш ранг слишком мал для использвания команды \"".$command[0]."\"");
			exit();
		}

		if ($command[1] === $command[2]) {
			echo "Вы не можете подписать себя на самого себя.";
			exit();
		}

		$follower_id = intval($command[2]);
		$followed_id = intval($command[1]);
		$confirm = intval($command[3]);

		$checkUser1 = mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '$follower_id' LIMIT 1");
		if (mysqli_num_rows($checkUser1) > 0) {
			$dataUser1 = mysqli_fetch_assoc($checkUser1);
		} else {
			echo "Пользователя под ID-".$follower_id." не существует.";
			exit();
		}

		$checkUser2 = mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '$followed_id' LIMIT 1");
		if (mysqli_num_rows($checkUser2) > 0) {
			$dataUser2 = mysqli_fetch_assoc($checkUser2);
		} else {
			echo "Пользователя под ID-".$followed_id." не существует.";
			exit();
		}

		$confirmDate = '';
		$confirmMess = 'не подтвержденным';
		if ($confirm == 1) {
			$confirmDate = $timeUSER;
			$confirmMess = 'подтвержденным';
		}

		$checkFollow = mysqli_query($connect, "SELECT * FROM `follows` WHERE `followed_id` = '$followed_id' AND `follower_id` = '$follower_id' LIMIT 1");
		if (mysqli_num_rows($checkFollow) > 0) {
			echo "Пользователь @".$dataUser1['login']." уже подписан на пользователя @".$dataUser2['login'].".";
			exit();
		}

		if (mysqli_query($connect, "INSERT INTO `follows`(`follower_id`, `followed_id`, `date_follow`, `confirm`, `date_confirm`) VALUES ('$follower_id', '$followed_id', '$timeUSER', '$confirm', '$confirmDate')")) {
			$resultTEXT = "Пользователь @".$dataUser1['login']." успешно подписан на пользователя @".$dataUser2['login']." с ".$confirmMess." состоянием.";
			echo $resultTEXT;

			mysqli_query($connect, "INSERT INTO `notifications`(`user_id`, `sender_id`, `type`, `category`, `message`, `date_public`) VALUES ('$follower_id', '$mid', 'system', 'admin', '$resultTEXT', '$serverTIME')");
			mysqli_query($connect, "INSERT INTO `notifications`(`user_id`, `sender_id`, `type`, `category`, `message`, `date_public`) VALUES ('$followed_id', '$mid', 'system', 'admin', '$resultTEXT', '$serverTIME')");

			mysqli_query($connect, "INSERT INTO `admin_command`(`command`, `uid`, `time`) VALUES ('$command_archive', '$mid', '$timeUSER')");
			exit();
		} else {
			echo "Нам не удалось подписать пользователя @".$dataUser1['login']." на пользователя @".$dataUser2['login'].". Повторите попытку позже или проверьте корректность ID.";
			exit();
		}
	}

	if ($command[0] === '/sendnotify') {
		if ($dataUSER['rang'] < 3) {
			echo("Ваш ранг слишком мал для использвания команды \"".$command[0]."\"");
			exit();
		}

		$usID = intval($command[1]);

		$checkUser1 = mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '$usID' LIMIT 1");
		if (mysqli_num_rows($checkUser1) > 0) {
			$dataUser1 = mysqli_fetch_assoc($checkUser1);
		} else {
			echo "Пользователя под ID-".$usID." не существует.";
			exit();
		}

		$resultTEXT = trim(str_replace($command[0].' '.$command[1].' ', '', strval($command_archive)));

		if (mb_strlen($resultTEXT, 'utf8') < 20 or mb_strlen($resultTEXT, 'utf8') > 200) {
			echo 'Текст не должен быть короче 20 или длинее 200 символов.';
			exit();
		}

		if (mysqli_query($connect, "INSERT INTO `notifications`(`user_id`, `sender_id`, `type`, `category`, `message`, `date_public`) VALUES ('$usID', '$mid', 'system', 'admin', '$resultTEXT', '$serverTIME')")) {
			echo 'Уведомление пользователю @'.$dataUser1['login'].' с текстом "'.$resultTEXT.'" успешно отправлено.';
			mysqli_query($connect, "INSERT INTO `admin_command`(`command`, `uid`, `time`) VALUES ('$command_archive', '$mid', '$timeUSER')");
			exit();
		} else {
			echo 'Нам не удалось отправить уведомление пользователю @'.$dataUser1['login'].' с текстом "'.$resultTEXT.'".';
			exit();
		}
		exit();
	}

	// POST --------------------------------------------------------------------------------------------------------------

	if ($command[0] === "/archive") { // Post archive
		if ($dataUSER['rang'] < 2) {
			echo("Ваш ранг слишком мал для использвания команды \"".$command[0]."\"");
			exit();
		}
		$pid = intval($command[1]);
		$status = strval($command[2]);
		$statusTEXT = "убрана из архива";
		if ($status < 0 or $status > 1) {
			$status = 0;
		} if ($status == 1) {
			$statusTEXT = "перемещена в архив";
		}
		$checkPOSTCOM = mysqli_query($connect, "SELECT * FROM `posts` WHERE `id` = '$pid' LIMIT 1");
		if (mysqli_num_rows($checkPOSTCOM) > 0) {
			$dataPOSTCOM = mysqli_fetch_assoc($checkPOSTCOM);
			if (mysqli_query($connect, "UPDATE `posts` SET `archive`='$status' WHERE `id`='$pid'")) {
				echo("Публикация \"".mb_strimwidth($dataPOSTCOM['message'], 0, 40, "...", "UTF-8")."\" была ".$statusTEXT);
				mysqli_query($connect, "INSERT INTO `admin_command`(`command`, `uid`, `time`) VALUES ('$command_archive', '$mid', '$timeUSER')");
			} else {
				echo("Ошибка выполнения команды \"".$command[0]."\". Повторите попытку позже");
			}
		} else {
			echo("Публикации под id$pid не существует");
		}
		
		exit();
	} 

	if ($command[0] === "/type") { // Post type
		if ($dataUSER['rang'] < 4) {
			echo("Ваш ранг слишком мал для использвания команды \"".$command[0]."\"");
			exit();
		}
		$pid = intval($command[1]);
		$type = strval($command[2]);
		if ($type == 'post' or $type == 'ads') {} else {
			$type = 'post';
		}
		$checkPOSTCOM = mysqli_query($connect, "SELECT * FROM `posts` WHERE `id` = '$pid' LIMIT 1");
		if (mysqli_num_rows($checkPOSTCOM) > 0) {
			$dataPOSTCOM = mysqli_fetch_assoc($checkPOSTCOM);
			if (mysqli_query($connect, "UPDATE `posts` SET `type`='$type' WHERE `id`='$pid'")) {
				echo("Для публикации \"".mb_strimwidth($dataPOSTCOM['message'], 0, 40, "...", "UTF-8")."\" был изменен тип на ".$type);
				mysqli_query($connect, "INSERT INTO `admin_command`(`command`, `uid`, `time`) VALUES ('$command_archive', '$mid', '$timeUSER')");
			} else {
				echo("Ошибка выполнения команды \"".$command[0]."\". Повторите попытку позже");
			}
		} else {
			echo("Публикации под id$pid не существует");
		}
		
		exit();
	} 

	if ($command[0] === "/commented") { // Post archive
		if ($dataUSER['rang'] < 2) {
			echo("Ваш ранг слишком мал для использвания команды \"".$command[0]."\"");
			exit();
		}
		$pid = intval($command[1]);
		$status = strval($command[2]);
		$statusTEXT = "запрещено";
		if ($status < 0 or $status > 1) {
			$status = 0;
		} if ($status == 1) {
			$statusTEXT = "разрешено";
		}
		$checkPOSTCOM = mysqli_query($connect, "SELECT * FROM `posts` WHERE `id` = '$pid' LIMIT 1");
		if (mysqli_num_rows($checkPOSTCOM) > 0) {
			$dataPOSTCOM = mysqli_fetch_assoc($checkPOSTCOM);
			if (mysqli_query($connect, "UPDATE `posts` SET `commented`='$status' WHERE `id`='$pid'")) {
				echo("Под публикацией \"".mb_strimwidth($dataPOSTCOM['message'], 0, 40, "...", "UTF-8")."\" ".$statusTEXT." оставлять новые комментарии");
				mysqli_query($connect, "INSERT INTO `admin_command`(`command`, `uid`, `time`) VALUES ('$command_archive', '$mid', '$timeUSER')");
			} else {
				echo("Ошибка выполнения команды \"".$command[0]."\". Повторите попытку позже");
			}
		} else {
			echo("Публикации под id$pid не существует");
		}
		
		exit();
	} 

	if ($command[0] === "/removepost") { // Post remove
		if ($dataUSER['rang'] < 2) {
			echo("Ваш ранг слишком мал для использвания команды \"".$command[0]."\"");
			exit();
		}
		$pid = intval($command[1]);
		$checkPOSTCOM = mysqli_query($connect, "SELECT * FROM `posts` WHERE `id` = '$pid' LIMIT 1");
		if (mysqli_num_rows($checkPOSTCOM) > 0) {
			$dataPOSTCOM = mysqli_fetch_assoc($checkPOSTCOM);
			$post_image1 = $dataPOSTCOM['image1'];
			$post_image2 = $dataPOSTCOM['image2'];
			$post_image3 = $dataPOSTCOM['image3'];
			$result_path = str_replace('qwaker.fun', 'sun.qwaker.fun', $_SERVER['DOCUMENT_ROOT']);
			if (mysqli_query($connect, "DELETE FROM `posts` WHERE `id`='$pid'")) {
				mysqli_query($connect, "DELETE FROM `comments` WHERE `post_id`='$pid'");
				mysqli_query($connect, "DELETE FROM `post_emotions` WHERE `pid` = '$pid'");
				mysqli_query($connect, "DELETE FROM `comments_likes` WHERE `pid` = '$pid'");

				$check_ufile1 = mysqli_query($connect, "SELECT * FROM `uploaded_files` WHERE `full_url` = '$post_image1' LIMIT 1");
				if (mysqli_num_rows($check_ufile1)) {
					$ufile1 = mysqli_fetch_assoc($check_ufile1);
					$result_upath1 = $result_path.$ufile1['short_url'];
					if (unlink($result_upath1)) {
						mysqli_query($connect, "DELETE FROM `uploaded_files` WHERE `full_url` = '$post_image1'");
					}
				}

				$check_ufile2 = mysqli_query($connect, "SELECT * FROM `uploaded_files` WHERE `full_url` = '$post_image2' LIMIT 1");
				if (mysqli_num_rows($check_ufile2)) {
					$ufile2 = mysqli_fetch_assoc($check_ufile2);
					$result_upath2 = $result_path.$ufile2['short_url'];
					if (unlink($result_upath2)) {
						mysqli_query($connect, "DELETE FROM `uploaded_files` WHERE `full_url` = '$post_image2'");
					}
				}

				$check_ufile3 = mysqli_query($connect, "SELECT * FROM `uploaded_files` WHERE `full_url` = '$post_image3' LIMIT 1");
				if (mysqli_num_rows($check_ufile3)) {
					$ufile3 = mysqli_fetch_assoc($check_ufile3);
					$result_upath3 = $result_path.$ufile3['short_url'];
					if (unlink($result_upath3)) {
						mysqli_query($connect, "DELETE FROM `uploaded_files` WHERE `full_url` = '$post_image3'");
					}
				}

				echo("Публикация \"".mb_strimwidth($dataPOSTCOM['message'], 0, 40, "...", "UTF-8")."\" успешно удалена");
				mysqli_query($connect, "INSERT INTO `admin_command`(`command`, `uid`, `time`) VALUES ('$command_archive', '$mid', '$timeUSER')");
			} else {
				echo("Ошибка выполнения команды \"".$command[0]."\". Повторите попытку позже");
			}
		} else {
			echo("Публикации под id$pid не существует");
		}
		
		exit();
	} 

	// COMMENTS ---------------------------------------------------------------------------------------------------------

	if ($command[0] === "/removecomm") { // Post comment remove
		if ($dataUSER['rang'] < 2) {
			echo("Ваш ранг слишком мал для использвания команды \"".$command[0]."\"");
			exit();
		}
		$cid = intval($command[1]);
		$checkPOSTCOM = mysqli_query($connect, "SELECT * FROM `comments` WHERE `id` = '$cid' LIMIT 1");
		if (mysqli_num_rows($checkPOSTCOM) > 0) {
			$dataPOSTCOM = mysqli_fetch_assoc($checkPOSTCOM);
			if (mysqli_query($connect, "DELETE FROM `comments` WHERE `id`='$cid'")) {
				mysqli_query($connect, "DELETE FROM `comments_likes` WHERE `cid` = '$cid'");
				echo("Комментарий \"".mb_strimwidth($dataPOSTCOM['message'], 0, 40, "...", "UTF-8")."\" успешно удален");
				mysqli_query($connect, "INSERT INTO `admin_command`(`command`, `uid`, `time`) VALUES ('$command_archive', '$mid', '$timeUSER')");
			} else {
				echo("Ошибка выполнения команды \"".$command[0]."\". Повторите попытку позже");
			}
		} else {
			echo("Комментария под id$cid не существует");
		}
		
		exit();
	} 

	// INVITES -----------------------------------------------------------------------------------------------------------

	if ($command[0] === "/createinvite") { // Create invite
		if ($dataUSER['rang'] < 4) {
			echo("Ваш ранг слишком мал для использвания команды \"".$command[0]."\"");
			exit();
		}
		$cid = intval($command[1]);
		$generateINVITECHARS = '0123456789QWERTYUIOPASDFGHJKLZXCVBNM';
		if ($cid === 'int') {
			$generateINVITECHARS = '0123456789';
		} if ($cid === 'str') {
			$generateINVITECHARS = 'QWERTYUIOPASDFGHJKLZXCVBNM';
		}
		$generateINVITE = substr(str_shuffle(str_repeat($generateINVITECHARS, 4)), 0, 4).'-'.substr(str_shuffle(str_repeat($generateINVITECHARS, 4)), 0, 4).'-'.substr(str_shuffle(str_repeat($generateINVITECHARS, 4)), 0, 4);
		$inviteCODE = $generateINVITE;
		$inviteCODEMD5 = md5($inviteCODE);
		if (mysqli_query($connect, "INSERT INTO `invites`(`invite`, `date`, `uid`) VALUES ('$inviteCODEMD5', '$timeUSER', '$mid')")) {
			echo("Инвайт код \"".$inviteCODE."\" успешно создан");
			mysqli_query($connect, "INSERT INTO `admin_command`(`command`, `uid`, `time`) VALUES ('$command_archive', '$mid', '$timeUSER')");
		} else {
			echo("Ошибка выполнения команды \"".$command[0]."\". Повторите попытку позже");
		}
		
		exit();
	} 

	if ($command[0] === "/removeinvite") { // Remove invite
		if ($dataUSER['rang'] < 4) {
			echo("Ваш ранг слишком мал для использвания команды \"".$command[0]."\"");
			exit();
		}
		$cid = intval($command[1]);
		$checkINVITECOM = mysqli_query($connect, "SELECT * FROM `invites` WHERE `id` = '$cid' LIMIT 1");
		if (mysqli_num_rows($checkINVITECOM) > 0) {
			$dataINVITECOM = mysqli_fetch_assoc($checkINVITECOM);
			if (mysqli_query($connect, "DELETE FROM `invites` WHERE `id`='$cid'")) {
				echo("Инвайт код \"".$dataINVITECOM['invite']."\" успешно удален");
				mysqli_query($connect, "INSERT INTO `admin_command`(`command`, `uid`, `time`) VALUES ('$command_archive', '$mid', '$timeUSER')");
			} else {
				echo("Ошибка выполнения команды \"".$command[0]."\". Повторите попытку позже");
			}
		} else {
			echo("Инвайт кода под id$cid не существует");
		}
		
		exit();
	} 

	// COMMANDS ----------------------------------------------------------------------------------------------------------

	if ($command[0] === "/clearcommands") { // Clear all commands
		if ($dataUSER['rang'] < 4) {
			echo("Ваш ранг слишком мал для использвания команды \"".$command[0]."\"");
			exit();
		}
		if (mysqli_query($connect, "DELETE FROM `admin_command`")) {
			echo("Список выполненых админ команд успешно очистен");
			// mysqli_query($connect, "INSERT INTO `admin_command`(`command`, `uid`, `time`) VALUES ('$command_archive', '$mid', '$timeUSER')");
		} else {
			echo("Ошибка выполнения команды \"".$command[0]."\". Повторите попытку позже");
		}
		
		exit();
	} 

	// -------------------------------------------------------------------------------------------------------------------

	echo("Неизвестная команда \"".$command[0]."\"");
	exit();
?>