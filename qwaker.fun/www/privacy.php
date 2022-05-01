<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/only-load.php';
?>
<!DOCTYPE html>
<html lang="<?php echo $langTAG; ?>" class="<?php echo $default_theme; ?>">
<head>
	<title><?php echo $string['title_index']; ?> | <?php echo $string['string_privacy_title_1']; ?></title>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/style.php'; ?>
	<link rel="stylesheet" type="text/css" href="<?php echo $default_theme_site; ?>privacy-terms.css?v=<?php echo time(); ?>">
	<link rel="shortcut icon" href="/assets/images/qak-favicon.png" type="image/png">
	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/meta.php'; ?>
</head>
<body>
	<center>
		<div class="qak-pt-container">
			<h1><?php echo $string['string_privacy_title_1']; ?></h1>

			<p><?php echo $string['string_privacy_1']; ?></p>
			<p><?php echo $string['string_privacy_2']; ?></p>
			<p><?php echo $string['string_privacy_3']; ?></p>

			<h2><?php echo $string['string_privacy_title_2']; ?></h2>

			<p><?php echo $string['string_privacy_4']; ?></p>
			<p><?php echo $string['string_privacy_5']; ?></p>

			<h2><?php echo $string['string_privacy_title_3']; ?></h2>

			<p><?php echo $string['string_privacy_6']; ?></p>
			<p><?php echo $string['string_privacy_7']; ?></p>
			<p><?php echo $string['string_privacy_8']; ?></p>

			<h2><?php echo $string['string_privacy_title_4']; ?></h2>

			<p><?php echo $string['string_privacy_9']; ?></p>

			<ul>
				<li><?php echo $string['string_privacy_list_1']; ?></li>
				<li><?php echo $string['string_privacy_list_2']; ?></li>
				<li><?php echo $string['string_privacy_list_3']; ?></li>
				<li><?php echo $string['string_privacy_list_4']; ?></li>
			</ul>

			<h2><?php echo $string['string_privacy_title_5']; ?></h2>

			<p><?php echo $string['string_privacy_10']; ?></p>

			<h2><?php echo $string['string_privacy_title_6']; ?></h2>

			<p><?php echo $string['string_privacy_11']; ?></p>
			<p><?php echo $string['string_privacy_21']; ?></p>

			<h2><?php echo $string['string_privacy_title_7']; ?></h2>

			<p><?php echo $string['string_privacy_12']; ?></p>

			<p><?php echo $string['string_privacy_13']; ?></p>

			<h2><?php echo $string['string_privacy_title_8']; ?></h2>

			<p><?php echo $string['string_privacy_14']; ?></p>
			<ul>
				<li><?php echo $string['string_privacy_list_5']; ?></li>
				<li><?php echo $string['string_privacy_list_6']; ?></li>
				<li><?php echo $string['string_privacy_list_7']; ?></li>
			</ul>
			<p><?php echo $string['string_privacy_15']; ?></p>
			<p><?php echo $string['string_privacy_16']; ?></p>

			<h2><?php echo $string['string_privacy_title_9']; ?></h2>

			<p><?php echo $string['string_privacy_17']; ?></p>
			<ul>
				<li><?php echo $string['string_privacy_list_8']; ?></li>
				<li><?php echo $string['string_privacy_list_9']; ?></li>
				<li><?php echo $string['string_privacy_list_10']; ?></li>
				<li><?php echo $string['string_privacy_list_11']; ?></li>
				<li><?php echo $string['string_privacy_list_12']; ?></li>
				<li><?php echo $string['string_privacy_list_13']; ?></li>
			</ul>
			<p><?php echo $string['string_privacy_18']; ?></p>
			<p><?php echo $string['string_privacy_16']; ?></p>

			<h2><?php echo $string['string_privacy_title_10']; ?></h2>

			<p><?php echo $string['string_privacy_19']; ?></p>
			<p><?php echo $string['string_privacy_20']; ?></p>
			<p><?php echo $string['string_privacy_16']; ?></p>
		</div>
	</center>
</body>
</html>