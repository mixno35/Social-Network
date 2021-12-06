<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/only-load.php';
?>
<?php 
	$title_page = $string['title_home'];

	$posts_type = strval($_GET['act']);
	$posts_limit = intval(100);

	if ($posts_type == 'sub' or $posts_type == 'rec') {} else {
		$posts_type = 'sub';
	}
?>
<!DOCTYPE html>
<html lang="<?php echo $langTAG; ?>" class="<?php echo $default_theme; ?>">
<head>
	<title><?php echo $string['title_home']; ?></title>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/style.php'; ?>
	<link rel="stylesheet" type="text/css" href="<?php echo $default_theme_site; ?>p.css?v=<?php echo time(); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo $default_theme_site; ?>user.css?v=<?php echo time(); ?>">
	<link rel="shortcut icon" href="/assets/images/qak-favicon.png" type="image/png">
	<link rel="stylesheet" type="text/css" href="<?php echo $default_theme_site; ?>index.css?v=2">
	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/script.php'; ?>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/meta.php'; ?>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/js/u.php'; ?>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/js/p.php'; ?>
</head>
<body>

	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/auth_check.php'; ?>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/placeholder.php'; ?>
	<?php if ($_COOKIE['load-dialogs-b'] === 'true') { ?>
		<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/alert/view-bottom-list-dialogs.php'; ?>
	<?php } ?>

	<?php if (intval($_GET['view-post']) != '') { ?>
		<script type="text/javascript" id="goRUNALERT">
			goAlertPost(<?php echo intval($_GET['view-post']); ?>, <?php echo intval($_GET['comment']); ?>);
			document.getElementById('goRUNALERT').remove();
		</script>
	<?php } ?>

	<center style="margin-top: 0px;">
		<center style="position: sticky;top: 0;z-index: 10;padding: 20px 0;background: linear-gradient(180deg, var(--color-html-background), transparent);">
			<ul class="tablayout-qak">
				<li id="sub" onclick="openType('sub', posts_limit)"><?php echo $string['action_tab_follow']; ?></li>
				<li id="rec" onclick="openType('rec', posts_limit)"><?php echo $string['action_tab_recomendation']; ?></li>
			</ul>
		</center>

		<div id="container-data-index">
			<h2 class="qak-index-message"><?php echo $string['message_please_wait']; ?></h2>
		</div>
	</center>

	<script type="text/javascript">
		var posts_type = 'rec';
		var posts_limit = <?php echo $posts_limit; ?>

		function openType(arguments, arguments2) {
			if (arguments == 'sub') {
				document.getElementById('sub').classList.add('active');
				document.getElementById('rec').classList.remove('active');
			} if (arguments == 'rec') {
				document.getElementById('rec').classList.add('active');
				document.getElementById('sub').classList.remove('active');
			}
			if (arguments.trim() == '') {
				arguments = 'rec';
			}

			if (arguments2 < 100) {
				arguments2 = 100;
			}

			posts_limit = arguments2;
			posts_type = arguments;

			updParam('act', arguments);
			updParam('limit', arguments2);
			try {
				document.getElementById('container-data-index').style.opacity = '0.4';
			} catch (exx) {}
			$.ajax({type: "GET", url:  '/post/'+arguments+'.php', data: {limit: posts_limit}, success: function(result) {
					$('#container-data-index').empty();
					$('#container-data-index').append(result);
					try {
						document.getElementById('container-data-index').style.opacity = '1';
					} catch (exx) {}
				}
			});
		}
	</script>

	<script type="text/javascript">
		openType('<?php echo $posts_type; ?>', posts_limit);
	</script>	

	<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/design/bar.php'; ?>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/design/holder.php'; ?>

</body>
</html>