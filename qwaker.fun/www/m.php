<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/only-load.php';
?>
<?php 
	$title_page = $title_dialog_text;

	$id = trim($_GET['id']);

	$choose_dialog_html = '<h2 class="message v2">'.$string['text_choose_dialog'].'</h2>';
	$please_wait_html = '<h2 class="message v2">'.$string['message_please_wait'].'</h2>';

	$interval_m = intval($_COOKIE['interval-m']);

	if ($interval_m < 1000) {
		$interval_m = 10000;
	}
?>
<!DOCTYPE html>
<html lang="<?php echo $langTAG; ?>" class="<?php echo $default_theme; ?>">
<head>
	<title><?php echo $string['title_dialog']; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo $default_theme_site; ?>dialog.css?v=<?php echo time(); ?>">
	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/style.php'; ?>
	<link rel="stylesheet" type="text/css" href="<?php echo $default_theme_site; ?>p.css?v=<?php echo time(); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo $default_theme_site; ?>user.css?v=<?php echo time(); ?>">
	<link rel="shortcut icon" href="/assets/images/qak-favicon.png" type="image/png">
	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/script.php'; ?>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/meta.php'; ?>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/js/u.php'; ?>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/js/p.php'; ?>
</head>
<body>

	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/auth_check.php'; ?>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/placeholder.php'; ?>

	<div class="qak-dialog-screen-progress" id="qak-dialog-screen-progress" style="display: none;">
		<div id="qak-progress-div" class="qak-progress-div" style="margin: 0;margin-top: -19px;width: 128px;"><div style="margin: 0;" id="qak-progress-bar" class="qak-progress-bar"></div></div>
	</div>

	<?php if (intval($_GET['view-post']) != '') { ?>
		<script type="text/javascript" id="goRUNALERT">
			goAlertPost(<?php echo intval($_GET['view-post']); ?>, <?php echo intval($_GET['comment']); ?>);
			document.getElementById('goRUNALERT').remove();
		</script>
	<?php } ?>

	<?php if ($_COOKIE['USID'] !== '') { ?>

		<?php if (isMobile()) { ?>
			<h1 class="qak-title-page" onclick="window.history.back()"><?php echo $string['title_dialog']; ?></h1>
		<?php } ?>

		<center style="margin-top: 20px;">
			<div class="qak-dialog-container-home">
				<div id="container-data-1-content" class="scroll-new">
					<h2 class="message"><?php echo $string['message_please_wait']; ?></h2>
				</div>
			</div>
		</center>

		<script type="text/javascript">
			function openDialog(argument, argument2, argument3) {
				window.location = "/dialog.php?id="+argument;
				
				document.cookie = "dialog-avatar=" + argument3 + "; path=/; domain=<?php echo $_SERVER['SERVER_NAME']; ?>; expires=Tue, <?php echo intval(date('d')); ?> <?php echo date('M'); ?> <?php echo intval(date('Y')+1); ?> 00:00:00 GMT";
				document.cookie = "dialog-name=" + argument2 + "; path=/; domain=<?php echo $_SERVER['SERVER_NAME']; ?>; expires=Tue, <?php echo intval(date('d')); ?> <?php echo date('M'); ?> <?php echo intval(date('Y')+1); ?> 00:00:00 GMT";
			}

			<?php if ($id == '') {} else { ?>
				openDialog('<?php echo $id; ?>', '<?php echo $_COOKIE['dialog-name'] ?>', '<?php echo $_COOKIE['dialog-avatar'] ?>');
			<?php } ?>

			function loadDialogs() {
				document.getElementById('container-data-1-content').style.opacity = '.5';
				showProgressBar();
				$.ajax({type: "GET", url: "/assets/content/list-dialogs.php", data: {token: '<?php echo $_COOKIE['USID']; ?>'}, success: function(result) {
						hideProgressBar();
						$("#container-data-1-content").empty();
						$("#container-data-1-content").append(result);
						document.getElementById('container-data-1-content').style.opacity = '1';
					}
				});
			}

			loadDialogs();
		</script>

	<?php } ?>

	<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/design/bar.php'; ?>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/design/holder.php'; ?>

</body>
</html>