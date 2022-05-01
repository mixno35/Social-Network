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
	<title><?php echo $string['title_index']; ?> | <?php echo $string['string_term_title_1']; ?></title>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/style.php'; ?>
	<link rel="stylesheet" type="text/css" href="<?php echo $default_theme_site; ?>privacy-terms.css?v=<?php echo time(); ?>">
	<link rel="shortcut icon" href="/assets/images/qak-favicon.png" type="image/png">
	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/meta.php'; ?>
</head>
<body>
	<center>
		<div class="qak-pt-container">
			<h1><?php echo $string['string_term_title_1']; ?></h1>

			<p><?php echo $string['string_term_1']; ?></p>
			<p><?php echo $string['string_term_2']; ?></p>

			<h2><?php echo $string['string_term_title_2']; ?></h2>

			<p><?php echo $string['string_term_3']; ?></p>
			<p><?php echo $string['string_term_4']; ?></p>
			<p><?php echo $string['string_term_5']; ?></p>

			<h2><?php echo $string['string_term_title_4']; ?></h2>

			<p><?php echo $string['string_term_9']; ?></p>

			<h2><?php echo $string['string_term_title_3']; ?></h2>

			<p><?php echo $string['string_term_6']; ?></p>
			<p><?php echo $string['string_term_7']; ?></p>
			<p><?php echo $string['string_term_8']; ?></p>
			<p><?php echo $string['string_term_10']; ?></p>
			<p><?php echo $string['string_term_11']; ?></p>
			<p><?php echo $string['string_term_14']; ?></p>

			<h2><?php echo $string['string_term_title_5']; ?></h2>

			<p><?php echo $string['string_term_12']; ?></p>
			<p><?php echo $string['string_term_13']; ?></p>
		</div>
	</center>
</body>
</html>