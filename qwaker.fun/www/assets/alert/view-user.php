<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/only-load.php';
?>
<?php
	$id = $_GET['id'];
?>
<?php
	$url_data = $default_api.'/user/data.php?id='.$id.'&token='.$_COOKIE['USID'];
	$result_user = json_decode(file_get_contents($url_data, false), true);
?>
<ol class="view-user" id="view-user">
	<center>
		<div onclick="event.stopPropagation()">
			<div class="close" onclick="closePopups()"></div>
			<img src="<?php echo $result_user['avatar']; ?>" onerror="this.src = '/assets/images/qak-avatar-v3.png'">
			<h2>
				<?php echo $result_user['login']; ?>
				<?php if (intval($result_user['user_verification']) == 1) { ?>
					<!-- <verification-user style="position: absolute;margin-top: 5px;margin-left: 4px;"></verification-user> -->
					<span class="material-symbols-outlined verification">verified</span>
				<?php } ?>
			</h2>
			<h3>
				<?php if (userOnline($result_user['online'])) { ?>
					<?php echo $string['text_user_online']; ?>
				<?php } else { ?>
					<?php echo str_replace('%1s', showDateOnlineUser($result_user['online']), $string['text_user_offline']); ?>
				<?php }  ?>
			</h3>
			<button class="border" onclick="window.location = '/user.php?id=<?php echo $result_user['login']; ?>'"><?php echo $string['action_go_to_profile']; ?></button>
		</div>
	</center>
</ol>