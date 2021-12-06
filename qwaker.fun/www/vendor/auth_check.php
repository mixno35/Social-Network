<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
?>
<?php
	error_reporting(0);
?>

<?php
	$url_check_auth = $default_api.'/user/check.php?token='.$_COOKIE['USID'];
	$result_check_auth = file_get_contents($url_check_auth);

	if ($_COOKIE['USID'] != '') {
		if ($result_check_auth == 'false') {
			// setcookie('USID', null, -1, '/', '.qwaker.com');
			?>
			<script type="text/javascript">
				document.cookie = "USID=" + "; path=/; domain=<?php echo $_SERVER['SERVER_NAME']; ?>; expires=-1";
				// window.location = '/';
				window.location.reload();
			</script>
			<?php
		}
	}
?>