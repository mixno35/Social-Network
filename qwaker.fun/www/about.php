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
	<title><?php echo $string['title_index']; ?> | <?php echo $string['title_about_site']; ?></title>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/style.php'; ?>
	<link rel="stylesheet" type="text/css" href="<?php echo $default_theme_site; ?>privacy-terms.css?v=<?php echo time(); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo $default_theme_site; ?>about.css?v=<?php echo time(); ?>">
	<link rel="shortcut icon" href="/assets/images/qak-favicon.png" type="image/png">
</head>
<body>
	<center>
		<div class="qak-pt-container">
			<h1><?php echo $string['title_about_site']; ?></h1>

			<p><?php echo $string['string_about_1']; ?></p>
			<p><?php echo $string['string_about_2']; ?></p>
			<p><?php echo $string['string_about_3']; ?></p>
			<p><?php echo $string['string_about_4']; ?></p>
			<p><?php echo $string['string_about_5']; ?></p>
			
		</div>
	</center>
</body>
</html>