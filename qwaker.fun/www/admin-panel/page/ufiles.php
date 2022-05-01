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
	$ufilesARRAY = mysqli_query($connect, "SELECT * FROM `uploaded_files` ORDER BY `time` DESC LIMIT $limit");
	$ufilesARRAYALL = mysqli_query($connect, "SELECT * FROM `uploaded_files`");
?>
<h5 class="content-title">Файлы (<?php echo intval(mysqli_num_rows($ufilesARRAY)); ?>/<?php echo intval(mysqli_num_rows($ufilesARRAYALL)); ?>)</h5>
<div class="page-content">
	<?php while($row = mysqli_fetch_assoc($ufilesARRAY)) { ?>
		<?php 
			$uid = intval($row['uid']);
			$fileUSER = mysqli_query($connect, "SELECT * FROM `users` WHERE `id`='$uid' LIMIT 1");
			$userLOGIN = 'unknown';
			if (mysqli_num_rows($fileUSER) > 0) {
				$dataFILEUSER = mysqli_fetch_assoc($fileUSER);
				$userLOGIN = $dataFILEUSER['login'];
			}
		?>
		<div class="item-user">
			<div class="c2">
				<h4>ID: <i><?php echo $row['id']; ?></i></h4>
				<h4>User ID: <i><?php echo $row['uid']; ?></i></h4>
				<h4>Ссылка: <i><a href="<?php echo $row['full_url']; ?>" target="_blank"><?php echo $row['full_url']; ?></a></i></h4>
				<h4>Короткая ссылка: <i><a href="<?php echo $row['full_url']; ?>" target="_blank"><?php echo $row['short_url']; ?></a></i></h4>
				<h4>Тип: <i><?php echo $row['type']; ?></i></h4>
				<h4>Дата загрузки: <i><?php echo $row['time']; ?></i></h4>
				<h2>Загрузил: <i><a href="/user.php?id=<?php echo $userLOGIN; ?>" target="_blank">@<?php echo $userLOGIN; ?><b>ID:<?php echo $row['uid']; ?></b></a></i></h2>
			</div>
		</div>
	<?php } ?>
</div>
<center>
	<button class="show-more" onclick="openPage(openedPage, <?php echo $limitMAX; ?>)">Показать еще...</button>
</center>