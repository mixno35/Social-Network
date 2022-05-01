<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/only-load.php';

	error_reporting(0);
?>
<!DOCTYPE html>
<html lang="<?php echo $langTAG; ?>" class="<?php echo $default_theme; ?>">
<head>
	<title><?php echo $string['title_donate']; ?></title>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/style.php'; ?>
	<link rel="stylesheet" type="text/css" href="<?php echo $default_theme_site; ?>donate.css?v=<?php echo time(); ?>">
	<link rel="shortcut icon" href="/assets/images/qak-favicon.png" type="image/png">
	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/script.php'; ?>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/meta.php'; ?>
</head>
<body>
	<center>
		<div class="qak-container-data">
			<h2 class="qak-container-data-title"><?php echo $string['string_donate_title']; ?></h2>
			<h5 class="qak-container-data-message"><?php echo $string['string_donate_message']; ?></h5>
			<hr>
			<ul class="list-donate">
				<li>Bitcoin: 3EgHdoNcnYSsCGDLqxZyCXhCPZrqDUayho</li>
				<li>WME: E721558707620</li>
				<li>WMZ: Z178194978131</li>
				<li>WMB: B735984048596</li>
				<li>Payeer: P1068237878</li>
				<li>YMoney: 4100117381445741</li>
				<li>QIWI: <a href="https://qiwi.com/n/MIXNO35">MIXNO35</a></li>
			</ul>
		</div>
	</center>
</body>