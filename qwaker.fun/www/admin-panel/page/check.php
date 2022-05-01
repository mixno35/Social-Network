<?php
	$usid = trim(mysqli_real_escape_string($connect, $_COOKIE['USID']));
	$sessionUTOKEN = "";
	$dataUSER = "";
?>

<?php 
	$checkSESSION = mysqli_query($connect, "SELECT * FROM `user_sessions` WHERE `sid` = '$usid' LIMIT 1");
	if (mysqli_num_rows($checkSESSION) > 0) {
		$session = mysqli_fetch_assoc($checkSESSION);
		$sessionUTOKEN = $session['utoken'];
	} else {
?>
	<div class="container-no-acc">
		<div>
			<h1>Нет действующей сессии</h1>
			<h3>Нам не удалось найти действующую сессию. Войдите в аккаунт, чтобы получить сессию</h3>
		</div>
	</div>
<?php exit(); } ?>



<?php 
	$checkUSER = mysqli_query($connect, "SELECT * FROM `users` WHERE `token_public` = '$sessionUTOKEN' LIMIT 1");
	if (mysqli_num_rows($checkUSER) > 0) {
		$dataUSER = mysqli_fetch_assoc($checkUSER);
	} else {
?>
	<div class="container-no-acc">
		<div>
			<h1>Сессия является битой</h1>
			<h3>Данная сессия является битой или ее не существет</h3>
		</div>
	</div>
<?php exit(); } ?>

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
	if ($dataUSER['banned'] == 1) {
?>
	<div class="container-no-acc">
		<div>
			<h1>Доступ запрещен системой</h1>
			<h3>Ваш аккаунт был заблокирован, вы больше не можете управлять этим контентом</h3>
		</div>
	</div>
<?php exit(); } ?>

<?php 
	if ($dataUSER['scam'] == 1) {
?>
	<div class="container-no-acc">
		<div>
			<h1>Доступ запрещен системой</h1>
			<h3>Ваш аккаунт был замечен в участии или организации скам-проектах(ов), вам был ограничен доступ к этому контенту</h3>
		</div>
	</div>
<?php exit(); } ?>