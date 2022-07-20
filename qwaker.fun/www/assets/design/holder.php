<?php
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
?>
<header class="holder">
	<!-- <a href="/about.php"><h4><?php echo $string['action_about']; ?></h4></a> -->
	<!-- <a href="https://m.qwaker.fun"><h4><?php echo $string['action_mobile_version']; ?></h4></a> -->
	<a href="/privacy.php"><h4><?php echo $string['action_privacy']; ?></h4></a>
	<a href="/terms.php"><h4><?php echo $string['action_terms']; ?></h4></a>
	<!-- <a href="/doc.php"><h4><?php echo $string['action_for_developers']; ?></h4></a> -->
	<!-- <a href="/donate.php"><h4><?php echo $string['action_donate']; ?></h4></a> -->
	<a href="https://github.com/mixno35/Social-Network" target="_blank"><h4><?php echo $string['action_open_source']; ?></h4></a>
	<h4 onended="closePopups()">&copy; QWAKER.fun, <?php echo date('Y'); ?></h4>
	<a href="https://t.me/mixno35_dev" target="_blank"><h4 onended="closePopups()">Creator by. Alexander Mikhno</h4></a>
	<a href="https://fonts.google.com/" target="_blank"><h4>Fonts & Icons: Google Fonts.</h4></a>
</header>