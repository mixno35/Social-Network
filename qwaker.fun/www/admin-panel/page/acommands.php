<?php include $_SERVER['DOCUMENT_ROOT'].'/admin-panel/vendor/data.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/admin-panel/vendor/connect.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/admin-panel/page/check.php'; ?>
<?php 
	if ($dataUSER['rang'] > 3) {} else {
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
	$acommandARRAY = mysqli_query($connect, "SELECT * FROM `admin_command` ORDER BY `time` ASC LIMIT $limit");
	$acommandARRAYALL = mysqli_query($connect, "SELECT * FROM `admin_command`");
?>
<h5 class="content-title">Команды (<?php echo intval(mysqli_num_rows($acommandARRAY)); ?>/<?php echo intval(mysqli_num_rows($acommandARRAYALL)); ?>)</h5>
<div class="page-content">
	<?php while($row = mysqli_fetch_assoc($acommandARRAY)) { ?>
		<?php 
			$uid = intval($row['uid']);
			$acUSER = mysqli_query($connect, "SELECT * FROM `users` WHERE `id`='$uid' LIMIT 1");
			$userLOGIN = 'unknown';
			$userRANG = 0;
			if (mysqli_num_rows($acUSER) > 0) {
				$dataAC = mysqli_fetch_assoc($acUSER);
				$userLOGIN = $dataAC['login'];
				$userRANG = $dataAC['rang'];
			}
		?>
		<div class="item-user">
			<div class="c2">
				<h4>ID: <i><?php echo $row['id']; ?></i></h4>
				<h4>User ID: <i><?php echo $row['uid']; ?></i></h4>
				<h4>Команда: <i><?php echo $row['command']; ?></i></h4>
				<h4>Время выполнения: <i><?php echo date("Y-m-d H:i:s", $row['time']); ?></i></h4>
				<h2>Выполнил: <i><a href="/user.php?id=<?php echo $userLOGIN; ?>" target="_blank">@<?php echo $userLOGIN; ?><b>ID:<?php echo $row['uid']; ?></b><b>Ранг:<?php echo $userRANG; ?></b></a></i></h2>
			</div>
		</div>
	<?php } ?>
</div>
<center>
	<button class="show-more" onclick="openPage(openedPage, <?php echo $limitMAX; ?>)">Показать еще...</button>
</center>