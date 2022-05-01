<?php include $_SERVER['DOCUMENT_ROOT'].'/admin-panel/vendor/data.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/admin-panel/vendor/connect.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/admin-panel/page/check.php'; ?>
<?php
	function getRangName($value='') {
		if ($value == 1) {
			return "Пользователь";
		} if ($value == 2) {
			return "Модератор";
		} if ($value == 3) {
			return "Администратор";
		} if ($value == 4) {
			return "Разработчик";
		}
		return $value;
	}
?>
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
	$usersARRAY = mysqli_query($connect, "SELECT * FROM `users` WHERE `type_auth`='site' ORDER BY `online` DESC LIMIT $limit");
	$usersARRAYALL = mysqli_query($connect, "SELECT * FROM `users` WHERE `type_auth`='site'");
?>
<h5 class="content-title">Пользователи (<?php echo intval(mysqli_num_rows($usersARRAY)); ?>/<?php echo intval(mysqli_num_rows($usersARRAYALL)); ?>)</h5>
<div class="page-content">
	<?php while($row = mysqli_fetch_assoc($usersARRAY)) { ?>
		<div class="item-user">
			<div class="c1"><img src="<?php echo $row['avatar']; ?>"></div>
			<div class="c2">
				<a href="/user.php?id=<?php echo $row['login']; ?>" target="_blank"><h2><?php echo $row['login']; ?><b>LINK</b></h2></a>
				<h4>ID: <i><?php echo $row['id']; ?></i></h4>
				<h4>Логин: <i><?php echo $row['login']; ?></i></h4>
				<h4>Ник-нейм: <i><?php echo $row['nickname']; ?></i></h4>
				<h4>Имя: <i><?php echo $row['name']; ?></i></h4>
				<h4>Ранг: <i><?php echo getRangName($row['rang']); ?>(<?php echo $row['rang']; ?>)</i></h4>
				<button onclick="hideOpenMore('more-user-content-<?php echo $row['id']; ?>')">Подробнее...</button>
				<div class="more-user-content" id="more-user-content-<?php echo $row['id']; ?>" style="display: none;">
					<h4>О себе: <i>-<?php echo $row['about']; ?></i></h4>
					<h4>Статус: <i><?php echo $row['status']; ?></i></h4>
					<h4>Сайт: <i><?php echo $row['url_site']; ?></i></h4>
					<h4>Соц. сеть: <i><?php echo $row['url_social']; ?></i></h4>
					<h4>Телефон: <i><?php echo $row['url_phone']; ?></i></h4>
					<h4>Почта: <i><?php echo $row['url_email']; ?></i></h4>
					<h4>Последняя активность: <i><?php echo date("Y-m-d H:i:s", $row['online']); ?></i></h4>
					<h4>Верификация(1-есть/0-нету): <i><?php echo $row['verification']; ?></i></h4>
					<h4>Двух этапная авторизация(1-вкл/0-выкл): <i><?php echo $row['email_authorization']; ?></i></h4>
					<h4>Приватный профиль(1-вкл/0-выкл): <i><?php echo $row['private']; ?></i></h4>
					<h4>Скам(1-вкл/0-выкл): <i><?php echo $row['scam']; ?></i></h4>
					<h4>Блокировка аккаунта(1-заблокирован/0-разблокирван): <i><?php echo $row['banned']; ?></i></h4>
					<h4>Создание чатов(1-вкл/0-выкл): <i><?php echo $row['chat_creating']; ?></i></h4>
					<h4>Присоединение к чату(1-вкл/0-выкл): <i><?php echo $row['chat_joined']; ?></i></h4>
					<h4>Дата регистрации: <i><?php echo $row['date_registration']; ?></i></h4>
					<h4>Язык: <i><?php echo $row['language']; ?></i></h4>
					<h4>Токен: <i><?php echo $row['token_public']; ?></i></h4>
				</div>
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