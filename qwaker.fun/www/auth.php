<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/only-load.php';
?>
<?php
	$t = $_GET['t'];
	if ($t == 'in' or $t == 'up') {} else {
		$t = 'up';
	}
?>
<!DOCTYPE html>
<html lang="<?php echo $langTAG; ?>" class="<?php echo $default_theme; ?>">
<head>
	<title><?php echo $title_index; ?></title>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/style.php'; ?>
	<link rel="stylesheet" type="text/css" href="<?php echo $default_theme_site; ?>auth.css?v=<?php echo time(); ?>">
	<link rel="shortcut icon" href="/assets/images/qak-favicon.png" type="image/png">
	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/script.php'; ?>
	<script type="text/javascript" src="https://vk.com/js/api/openapi.js?169"></script>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/meta.php'; ?>
</head>
<body>

	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/placeholder.php'; ?>

	<?php
		if ($_COOKIE['USID'] != '') {
			?>
				<script type="text/javascript">
					window.location.replace("/");
				</script>
			<?php
		}
	?>

	<center>
		<div class="qak-auth-container">
			<!-- <img src="/assets/images/qak-favicon-v2.png" class="qak-auth-logo" draggable="false"> -->

			<h2 class="title-qak-text" id="title"><?php echo $string['title_auth_sign_in']; ?></h2>

			<center>
				<ul class="tablayout-qak">
					<li id="in" onclick="openSign('in')"><?php echo $string['action_sign_in']; ?></li>
					<li id="up" onclick="openSign('up')"><?php echo $string['action_sign_up']; ?></li>
				</ul>
			</center>

			<div class="qak-auth-container-data" id="qak-auth-container-data" enabled="true">
				<h2 class="qak-auth-message"><?php echo $string['message_please_wait']; ?></h2>
			</div>
		</div>
		<div class="qak-auth-container-links">
			<a href="/privacy.php" target="_blank"><?php echo $string['action_privacy']; ?></a>
			<hr>
			<a href="/terms.php" target="_blank"><?php echo $string['action_terms']; ?></a>
		</div>
	</center>

	<script type="text/javascript">
		var signIn = stringOBJ['title_auth_sign_in'];
		var signUp = stringOBJ['title_auth_sign_up'];
		var signHistory = '';

		function openSign(arguments) {
			if (signHistory != arguments) {
				signHistory = arguments;
				if (arguments == 'in') {
					document.getElementById('title').textContent = signIn;
					loadSign('in');
					document.getElementById('in').classList.add('active');
					document.getElementById('up').classList.remove('active');
					document.title = stringOBJ['action_sign_in'];
				} if (arguments == 'up') {
					document.getElementById('title').textContent = signUp;
					loadSign('up');
					document.getElementById('up').classList.add('active');
					document.getElementById('in').classList.remove('active');
					document.title = stringOBJ['action_sign_up'];
				}
			}
		}

		function loadSign(arguments) {
			try {
				document.getElementById('qak-auth-container-data').style.opacity = '0.4';
			} catch (exx) {}
			showProgressBar();
			$.ajax({type: "GET", url:  '/assets/auth/'+arguments+'.php', data: "req=ok", success: function(result) {
					hideProgressBar();
					$('#qak-auth-container-data').empty();
					$('#qak-auth-container-data').append(result);
					try {
						document.getElementById('qak-auth-container-data').style.opacity = '1';
					} catch (exx) {}
				}
			});
		}
	</script>

	<script type="text/javascript">
		openSign('<?php echo $t; ?>');
	</script>

	<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/design/holder.php'; ?>

</body>
</html>