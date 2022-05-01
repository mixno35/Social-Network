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
	$repARRAY = mysqli_query($connect, "SELECT * FROM `reports_comments` ORDER BY `date_reported` DESC LIMIT $limit");
	$repARRAYALL = mysqli_query($connect, "SELECT * FROM `reports_comments`");
?>
<h5 class="content-title">Жалобы (<?php echo intval(mysqli_num_rows($repARRAY)); ?>/<?php echo intval(mysqli_num_rows($repARRAYALL)); ?>)</h5>
<div class="page-content">
	<?php while($row = mysqli_fetch_assoc($repARRAY)) { ?>
		<?php 
			$uid = intval($row['user_id']);
			$cid = intval($row['comment_id']);
			$repUSER = mysqli_query($connect, "SELECT * FROM `users` WHERE `id`='$uid' LIMIT 1");
			$userLOGIN = 'unknown';
			if (mysqli_num_rows($repUSER) > 0) {
				$dataREP = mysqli_fetch_assoc($repUSER);
				$userLOGIN = $dataREP['login'];
			}

			$repCOMMENT = mysqli_query($connect, "SELECT * FROM `comments` WHERE `id`='$cid' LIMIT 1");
			if (mysqli_num_rows($repCOMMENT) > 0) {
				$dataCOMMENT = mysqli_fetch_assoc($repCOMMENT);
			}
		?>
		<div class="item-user">
			<div class="c2">
				<?php if (mysqli_num_rows($repCOMMENT) === 0) { ?>
					<i class="mess">Пользователь удалил комментарий.</i>
				<?php } ?>
				<h4>ID: <i><?php echo $row['id']; ?></i></h4>
				<h4>User ID: <i><?php echo $uid; ?></i></h4>
				<h4>Comment ID: <i><?php echo $cid; ?></i></h4>
				<h4>Причина жалобы: <i><?php echo $row['data']; ?></i></h4>
				<h4>Комментарий к жалобе: <i>-<?php echo $row['message']; ?></i></h4>
				<h4>Время отправки жалобы: <i><?php echo $row['date_reported']; ?></i></h4>
				<button onclick="hideOpenMore('more-item-rep-<?php echo $row['id']; ?>')">Подробнее...</button>
				<div id="more-item-rep-<?php echo $row['id']; ?>" class="more-user-content" style="display: none;">
					<h4>Комментарий: <i><?php echo $row['comment_message']; ?></i></h4>
				</div>
				<h2>Пожаловался: <i><a href="/user.php?id=<?php echo $userLOGIN; ?>" target="_blank">@<?php echo $userLOGIN; ?><b>ID:<?php echo $uid; ?></b></a></i></h2>
			</div>
		</div>
	<?php } ?>
</div>
<center>
	<button class="show-more" onclick="openPage(openedPage, <?php echo $limitMAX; ?>)">Показать еще...</button>
</center>
<script type="text/javascript">
	function hideOpenMore(argument) {
		if (document.getElementById(argument).style.display == 'none') {
			document.getElementById(argument).style.display = 'block';
		} else {
			document.getElementById(argument).style.display = 'none';
		}
	}
</script>