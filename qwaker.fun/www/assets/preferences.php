<?php
	$default_theme = 'theme-default-light';
	$default_theme_site = '/assets/css/';
	$default_api = 'https://api.qwaker.fun';
	$default_api2 = 'http://api.qwaker.fun';
	$default_domain = 'https://qwaker.fun';
	$default_name = 'QWAKER.fun';
?>
<?php if (trim($_COOKIE['color-scheme'])) {
	$default_theme = $_COOKIE['color-scheme'];
} ?>
<?php if (trim($_COOKIE['theme'])) {
	$default_theme_site = $_COOKIE['theme'];
} ?>
<?php
	$vk_client_id = '7933767';
?>