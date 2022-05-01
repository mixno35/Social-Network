<?php include $_SERVER['DOCUMENT_ROOT'].'/admin-panel/vendor/data.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/admin-panel/vendor/connect.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/admin-panel/page/check.php'; ?>
<?php 
	if ($dataUSER['rang'] > 1) {} else {
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
	$ufilesARRAY = mysqli_query($connect, "SELECT * FROM `posts` ORDER BY `date_public` DESC LIMIT $limit");
	$ufilesARRAYALL = mysqli_query($connect, "SELECT * FROM `posts`");
?>
<h5 class="content-title">Публикации (<?php echo intval(mysqli_num_rows($ufilesARRAY)); ?>/<?php echo intval(mysqli_num_rows($ufilesARRAYALL)); ?>)</h5>
<div class="page-content">
	<?php while($row = mysqli_fetch_assoc($ufilesARRAY)) { ?>
		<?php 
			$uid = intval($row['user_id']);
			$cid = intval($row['creator_id']);
			$fileUSER = mysqli_query($connect, "SELECT * FROM `users` WHERE `id`='$uid' LIMIT 1");
			$fileUSERC = mysqli_query($connect, "SELECT * FROM `users` WHERE `id`='$cid' LIMIT 1");
			$userLOGIN = 'unknown';
			$userLOGINC = 'unknown';
			if (mysqli_num_rows($fileUSER) > 0) {
				$dataFILEUSER = mysqli_fetch_assoc($fileUSER);
				$userLOGIN = $dataFILEUSER['login'];
			} if (mysqli_num_rows($fileUSERC) > 0) {
				$dataFILEUSERC = mysqli_fetch_assoc($fileUSERC);
				$userLOGINC = $dataFILEUSERC['login'];
			}
		?>
		<div class="item-user">
			<div class="c2">
				<h4>ID: <i><?php echo $row['id']; ?></i></h4>
				<h4>ID2: <i><?php echo $row['post_id']; ?></i></h4>
				<h4>Просмотров: <i><?php echo $row['views']; ?></i></h4>
				<h4>Тип(ads-реклама/post-публикация): <i><?php echo $row['type']; ?></i></h4>
				<h4>Категория: <i><?php echo $row['category']; ?></i></h4>
				<h4>Архивировация(1-в архиве/0-не в архиве): <i><?php echo $row['archive']; ?></i></h4>
				<h4>Новые комментарии(1-разрешены/0-запрещены): <i><?php echo $row['commented']; ?></i></h4>
				<h4>Заголовок: <i><?php echo $row['title']; ?></i></h4>
				<h4>Комментарий: <i><?php echo $row['message']; ?></i></h4>
				<h4>Изображение[1]: <i><a href="<?php echo $row['image1']; ?>" target="_blank"><?php echo $row['image1']; ?></a></i></h4>
				<h4>Изображение[2]: <i><a href="<?php echo $row['image2']; ?>" target="_blank"><?php echo $row['image2']; ?></a></i></h4>
				<h4>Изображение[3]: <i><a href="<?php echo $row['image3']; ?>" target="_blank"><?php echo $row['image3']; ?></a></i></h4>
				<h4>Язык: <i><?php echo $row['language']; ?></i></h4>
				<h4>Время публикации: <i><?php echo $row['date_public']; ?></i></h4>
				<h4>Время последнего взаимодействия: <i><?php echo $row['date']; ?></i></h4>
				<h4>Время для пуб. просмотра: <i><?php echo date("Y-m-d H:i:s", $row['date_view']); ?></i></h4>
				
				<h2>Опубликовал: <i><a href="/user.php?id=<?php echo $userLOGIN; ?>" target="_blank">@<?php echo $userLOGIN; ?><b>ID:<?php echo $row['user_id']; ?></b></a></i></h2>
				<h2>Автор: <i><a href="/user.php?id=<?php echo $userLOGIN; ?>" target="_blank">@<?php echo $userLOGINC; ?><b>ID:<?php echo $row['creator_id']; ?></b></a></i></h2>
			</div>
		</div>
	<?php } ?>
</div>
<center>
	<button class="show-more" onclick="openPage(openedPage, <?php echo $limitMAX; ?>)">Показать еще...</button>
</center>