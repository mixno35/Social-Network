<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/only-load.php';
?>
<?php
	$code = $_GET['code'];
?>
<?php
	$url_user = $default_api.'/auth/secure/restored-pass.php?code='.$code;
	$result_user = json_decode(file_get_contents($url_user, false), true);
?>
<!DOCTYPE html>
<html lang="<?php echo $langTAG; ?>" class="<?php echo $default_theme; ?>">
<head>
	<title><?php echo $title_index; ?></title>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/style.php'; ?>
	<link rel="stylesheet" type="text/css" href="<?php echo $default_theme_site; ?>restore-password.css?v=<?php echo time(); ?>">
	<link rel="shortcut icon" href="/assets/images/qak-favicon.png" type="image/png">
	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/script.php'; ?>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/meta.php'; ?>
</head>
<body>

	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/placeholder.php'; ?>

	<center>
		<div class="qak-rp-container">
			<!-- <img src="/assets/images/qak-favicon-v3.png" class="qak-rp-logo rp" draggable="false"> -->
			<h2 class="title-qak-text" id="title"><?php echo $string['title_restore_password']; ?></h2>
			<?php if ($result_user['login'] == '' and $result_user['password'] == '') { ?>
				<h2 class="message"><?php echo $string['message_restored_password_invalid_code']; ?></h2>
			<?php } else { ?>
				<ul class="qak-rp-puncts">
					<li><?php echo $string['hint_short_login']; ?>: <?php echo $result_user['login']; ?></li>
					<li><?php echo $string['hint_short_password']; ?>: <?php echo $result_user['password']; ?></li>
				</ul>

				<a href="/auth.php?t=in&login=<?php echo $result_user['login']; ?>&pass=<?php echo $result_user['password']; ?>">
					<button><?php echo $string['action_sign_in']; ?></button>
				</a>

				<h5 class="qak-puncts-title"><?php echo $string['message_restored_password']; ?></h5>
			<?php } ?>
		</div>
	</center>

	<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/design/holder.php'; ?>

</body>
</html>