<?php include $_SERVER['DOCUMENT_ROOT'].'/admin-panel/vendor/data.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/admin-panel/vendor/connect.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/admin-panel/page/check.php'; ?>
<?php 
	if ($dataUSER['rang'] > 2) {} else {
?>
	<div class="container-no-acc">
		<div>
			<h1>Доступ запрещен системой</h1>
			<h3>Ваш ранг аккаунта не позволяет находится здесь и управлять контентом</h3>
		</div>
	</div>
<?php exit(); } ?>

<?php
	$limit = intval($_POST['limit']);
	$limitMIN = intval($limit-5);
	$limitMAX = intval($limit+5);
?>
<?php
	$repARRAY = mysqli_query($connect, "SELECT * FROM `reports_user` ORDER BY `date_reported` DESC LIMIT $limit");
	$repARRAYALL = mysqli_query($connect, "SELECT * FROM `reports_user`");
?>
<h5 class="content-title">Жалобы (<?php echo intval(mysqli_num_rows($repARRAY)); ?>/<?php echo intval(mysqli_num_rows($repARRAYALL)); ?>)</h5>
<div class="page-content">
	<?php while($row = mysqli_fetch_assoc($repARRAY)) { ?>
		<?php 
			$uid = intval($row['user_id']);
			$uid2 = intval($row['rep_id']);
			$repUSER = mysqli_query($connect, "SELECT * FROM `users` WHERE `id`='$uid' LIMIT 1");
			$userLOGIN = 'unknown';
			if (mysqli_num_rows($repUSER) > 0) {
				$dataREP = mysqli_fetch_assoc($repUSER);
				$userLOGIN = $dataREP['login'];
			}

			$repUSER2 = mysqli_query($connect, "SELECT * FROM `users` WHERE `id`='$uid2' LIMIT 1");
			$userLOGIN2 = 'unknown';
			if (mysqli_num_rows($repUSER2) > 0) {
				$dataREP2 = mysqli_fetch_assoc($repUSER2);
				$userLOGIN2 = $dataREP2['login'];
			}
		?>
		<div class="item-user">
			<div class="c2">
				<h4>ID: <i><?php echo $row['id']; ?></i></h4>
				<h4>User ID: <i><?php echo $uid; ?></i></h4>
				<h4>Rep ID: <i><?php echo $uid2; ?></i></h4>
				<h4>Причина жалобы: <i><?php echo $row['data']; ?></i></h4>
				<h4>Комментарий к жалобе: <i>-<?php echo $row['message']; ?></i></h4>
				<h4>Время отправки жалобы: <i><?php echo $row['date_reported']; ?></i></h4>
				<h2>Пожаловался: <i><a href="/user.php?id=<?php echo $userLOGIN; ?>" target="_blank">@<?php echo $userLOGIN; ?><b>ID:<?php echo $uid; ?></b></a></i></h2>
				<h2>Пожаловался на: <i><a href="/user.php?id=<?php echo $userLOGIN2; ?>" target="_blank">@<?php echo $userLOGIN2; ?><b>ID:<?php echo $uid2; ?></b></a></i></h2>
			</div>
		</div>
	<?php } ?>
</div>
<center>
	<button class="show-more" onclick="openPage(openedPage, <?php echo $limitMAX; ?>)">Показать еще...</button>
</center>