<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/only-load.php';
?>
<?php 
	$title_page = $title_edit_text;

	$url_user = $default_api.'/user/edit/data.php?token='.$_COOKIE['USID'];
	$result_user = json_decode(file_get_contents($url_user, false), true);

	$act = $_GET['act'];

	if ($act == 'default' or $act == 'link' or $act == 'secure' or $act == 'account') {} else {
		$act = 'default';
	}
?>
<!DOCTYPE html>
<html lang="<?php echo $langTAG; ?>" class="<?php echo $default_theme; ?>">
<head>
	<title><?php echo $string['title_edit_account']; ?></title>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/style.php'; ?>
	<link rel="shortcut icon" href="/assets/images/qak-favicon.png" type="image/png">
	<link rel="stylesheet" type="text/css" href="<?php echo $default_theme_site; ?>user.css?v=<?php echo time(); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo $default_theme_site; ?>edit.css?v=<?php echo time(); ?>">
	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/script.php'; ?>
	<script src="/assets/js/edit/password.js?v=2"></script>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/meta.php'; ?>
</head>
<body>

	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/auth_check.php'; ?>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/placeholder.php'; ?>

	<center>
		<?php if ($_COOKIE['USID'] == '') { ?>
			<div class="qak-container-error">
				<h2 class="qak-user-title"><?php echo $string['message_edit_unknown_title']; ?></h2>
				<h2 class="qak-user-message"><?php echo $string['message_edit_unknown_message']; ?></h2>
				<button id="action-follow-user-2" onclick="window.location = '/auth.php?t=in'" style="margin-top: 10px;"><?php echo $string['action_sign_in']; ?></button>
			</div>
		<?php } else { ?>
			<?php if ($result_user['id'] != 'id_user_data_banned') { ?>

				<center style="margin: 20px 0;">
					<ul class="tablayout-qak" >
						<div class="tl" id="tl-item-default" tooltip="<?php echo $string['edit_title_1']; ?>" onclick="swipePage('default')">
							<div class="tl-item default"></div>
						</div>
						<div class="tl" id="tl-item-link" tooltip="<?php echo $string['edit_title_4']; ?>" onclick="swipePage('link')">
							<div class="tl-item link"></div>
						</div>
						<div class="tl" id="tl-item-account" tooltip="<?php echo $string['edit_title_3']; ?>" onclick="swipePage('account')">
							<div class="tl-item account"></div>
						</div>
						<div class="tl" id="tl-item-secure" tooltip="<?php echo $string['edit_title_2']; ?>" onclick="swipePage('secure')">
							<div class="tl-item secure"></div>
						</div>
					</ul>
				</center>

				<div class="qak-container-data-two">
					<div>
						<div id="container-content">
							
						</div>
					</div>
					<div>
						
					</div>
				</div>

				<script type="text/javascript">
					var generateStringTitle = 'edit_title_1';
					function swipePage(argument) {
						var resultSwipePage = '1';
						if (argument == 'default') {
							resultSwipePage = '1';
						} if (argument == 'link') {
							resultSwipePage = '4';
						} if (argument == 'secure') {
							resultSwipePage = '2';
						} if (argument == 'account') {
							resultSwipePage = '3';
						}

						updParam('act', argument);

						generateStringTitle = 'edit_title_' + resultSwipePage; 
						document.title = stringOBJ['title_edit_account'] + ' | ' + stringOBJ[generateStringTitle];

						var testElements = document.getElementsByClassName('tl');
						Array.prototype.filter.call(testElements, function(testElement){
						    document.getElementById(testElement.id).classList.remove('active');
						});

						document.getElementById('tl-item-' + argument).classList.add('active');

						document.getElementById('container-content').style.opacity = '0.5';
						$.ajax({type: "GET", url: "/edit-page/"+resultSwipePage+".php", data: {req: 'ok'}, success: function(result) {
								document.getElementById('container-content').style.opacity = '1.0';
								$("#container-content").empty();
								$("#container-content").append(result);
							}
						});
					}

					swipePage('<?php echo $act; ?>');
				</script>
			<?php } else { ?>
				<div class="qak-container-error">
					<h2 class="qak-user-title"><?php echo $string['message_edit_banned_title']; ?></h2>
					<h2 class="qak-user-message"><?php echo $string['message_edit_banned_message']; ?></h2>
				</div>
			<?php } ?>
		<?php } ?>
	</center>

	<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/design/bar.php'; ?>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/design/holder.php'; ?>

</body>
</html>