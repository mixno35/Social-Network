<div class="qak-page-full-screnn" id="qak-page-full-screen-menu">
	<?php
		include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
		include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
		include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
		include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
		include $_SERVER['DOCUMENT_ROOT'].'/vendor/only-load.php';
	?>
	<?php 
		$title_page = $string['title_menu'];

		$usid = $_COOKIE['USID'];

		$url_user = $default_api.'/user/data.php?token='.$usid;
		$result_user = json_decode(file_get_contents($url_user, false), true);
	?>

	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/auth_check.php'; ?>

	<?php if ($usid != '') { ?>
		<h1 class="qak-title-page" onclick="document.getElementById('qak-page-full-screen-menu').remove()"><?php echo $string['action_back']; ?></h1>

		<div class="qak-container-user" onclick="window.location = '/user.php?id=<?php echo $result_user['login']; ?>'">
			<img src="<?php echo $result_user['avatar']; ?>" draggable="false" onerror="this.src = '/assets/images/qak-avatar-v3.png'">
			<div class="other-content">
				<h1><?php echo $result_user['login']; ?></h1>
				<h2><?php echo $result_user['name']; ?></h2>
			</div>
		</div>

		<ul class="qak-menu-user-menu">
			<li onclick="window.location = '/edit.php'"><?php echo $string['action_edit']; ?></li>
			<li onclick="openAlertBar('view-archive')"><?php echo $string['action_list_archive']; ?></li>
			<li onclick="openAlertBar('view-black-list')"><?php echo $string['action_black_list']; ?></li>
			<li onclick="openAlertBar('view-deffred-list')"><?php echo $string['action_deffred_posts']; ?></li>
			<hr>
			<li onclick="openAlertBar('view-sessions')"><?php echo $string['action_sessions']; ?></li>
			<li onclick="openAlertBar('view-settings')"><?php echo $string['action_settings']; ?></li>
			<?php if (intval($result_user['urang']) >= 2) { ?>
				<hr>
				<li onclick="window.location = '/admin-panel/index.php'"><?php echo $string['action_admin_panel']; ?></li>
				<hr>
			<?php } ?>
			<li onclick="exitAccount()" class="red"><?php echo $string['action_sign_out']; ?></li>
		</ul>
	<?php } else { ?>
		<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/content/no-account.php'; ?>
	<?php } ?>
</div>