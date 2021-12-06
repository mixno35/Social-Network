<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/only-load.php';
?>
<?php
	$text = trim(strval($_GET['text']));
	$limit = intval($_GET['limit']);
?>
<?php
	$url_find = $default_api.'/find/user.php?text='.$text.'&limit='.$limit.'&token='.$_COOKIE['USID'];
	$result_find = json_decode(file_get_contents($url_find, false), true);
?>
<?php $num_finds = intval(sizeof($result_find)); ?>
<?php if (sizeof($result_find) == 0) { ?>
	<h2 class="message-find-users"><?php echo $string['message_no_find_users']; ?></h2>
<?php } else { ?>
	<?php foreach($result_find as $key => $value) { ?>
		<?php $num_finds = $num_finds - 1; ?>
		<div class="find-item-user" onclick="showUserPopup('<?php echo $value['login']; ?>',this.id)">
			<img src="<?php echo $value['avatar']; ?>" class="avatar-user-find" onerror="this.src = '/assets/images/qak-avatar-v3.png'" draggable="false">
			<div class="data-find-item-user">
				<h2 class="find-users-title">
					<?php echo $value['login']; ?>
					<?php if (intval($value['verification']) == 1) { ?>
						<verification-user></verification-user>
					<?php } ?>
				</h2>
				<h2 class="find-users-subtitle">
					<?php echo $value['name']; ?>
				</h2>
			</div>
		</div>
		<?php if ($num_finds > 0) { ?>
			<hr class="qak-alert-archive-divider find-users">
		<?php } ?>
	<?php } ?>
	<h5 class="find-users-result"><?php echo str_replace('%1s', intval(sizeof($result_find)), $string['text_find_result_users']); ?></h5>
<?php } ?>
