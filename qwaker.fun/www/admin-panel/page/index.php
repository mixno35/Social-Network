<?php include $_SERVER['DOCUMENT_ROOT'].'/admin-panel/vendor/data.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/admin-panel/vendor/connect.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/admin-panel/page/check.php'; ?>
<?php
	$usersINT = intval(mysqli_num_rows(mysqli_query($connect, "SELECT * FROM `users`")));
	$postsINT = intval(mysqli_num_rows(mysqli_query($connect, "SELECT * FROM `posts`")));
	$ufilesINT = intval(mysqli_num_rows(mysqli_query($connect, "SELECT * FROM `uploaded_files`")));
	$repusersINT = intval(mysqli_num_rows(mysqli_query($connect, "SELECT * FROM `reports_user`")));
	$reppostsINT = intval(mysqli_num_rows(mysqli_query($connect, "SELECT * FROM `reports_post`")));
	$repcommentsINT = intval(mysqli_num_rows(mysqli_query($connect, "SELECT * FROM `reports_comments`")));
	$acommandsINT = intval(mysqli_num_rows(mysqli_query($connect, "SELECT * FROM `admin_command`")));
?>
<ul class="list-data">
	<li onclick="openPage('users', 5)">Пользователей: <?php echo $usersINT; ?></li>
	<li onclick="openPage('posts', 5)">Публикаций: <?php echo $postsINT; ?></li>
	<li onclick="openPage('ufiles', 5)">Загружено файлов: <?php echo $ufilesINT; ?></li>
	<li onclick="openPage('repusers', 5)">Жалобы на пользователей: <?php echo $repusersINT; ?></li>
	<li onclick="openPage('repposts', 5)">Жалобы на публикации: <?php echo $reppostsINT; ?></li>
	<li onclick="openPage('repcomments', 5)">Жалобы на комментарии: <?php echo $repcommentsINT; ?></li>
	<li onclick="openPage('acommands', 5)">Выполнено админ команд: <?php echo $acommandsINT; ?></li>
</ul>