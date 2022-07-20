<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/only-load.php';
?>
<?php
	$id = $_GET['id'];

	$url_dt = $default_api.'/user/list-black.php?token='.$_COOKIE['USID'];
	$result_follow = json_decode(file_get_contents($url_dt, false), true);
?>
<?php
	function convertTimePublicConfirm($originalDate) {
		$day = date("d", strtotime($originalDate));
		$mounth = date("M", strtotime($originalDate));
		$year = date("Y", strtotime($originalDate));
		$hour = date("H", strtotime($originalDate));
		$minute = date("i", strtotime($originalDate));
		$second = date("s", strtotime($originalDate));

		return $day . ' ' . $mounth . ' ' . $year . ' ' . $hour . ':' . $minute;
	}
?>
<div class="qak-alert-container" id="qak-alert-container">
	<div class="qak-alert-container-holder">
		<h2 class="qak-alert-container-holder-title"><?php echo $string['title_black_list']; ?></h2>
		<div class="qak-alert-close" onclick="document.getElementById('qak-alert-container').remove()"></div>
		<?php $num_follows = intval(sizeof($result_follow)); ?>
		<?php if (sizeof($result_follow) == 0) { ?>
			<h2 class="qak-alert-message"><?php echo $string['message_no_black_list']; ?></h2>
		<?php } else { ?>
			<div class="qak-alert-list-follows">
				<?php foreach($result_follow as $key => $value) { ?>
					<?php $num_follows = $num_follows - 1; ?>
					
						<div class="qak-follow-item">
							<div id="qak-follow-item-<?php echo $value['id']; ?>" style="position: relative;" onclick="showUserPopup('<?php echo $value['user_login']; ?>',this.id)">
								<img src="<?php echo $value['user_avatar']; ?>" draggable="false" onerror="this.src = '/assets/images/qak-avatar-v3.png'">
							</div>
							<div class="qak-follow-item-data">
								<h2>
									<?php echo $value['user_login']; ?>
									<?php if (intval($value['user_verification']) == 1) { ?>
										<!-- <verification-user></verification-user> -->
										<span class="material-symbols-outlined verification">verified</span>
									<?php } ?>
								</h2>
								<h3><?php echo str_replace('%1s', convertTimeRus($value['block_date']), $string['text_user_blocked_date']); ?></h3>
							</div>
							<button class="border" id="qak-block-button-<?php echo $value['id']; ?>" onclick="blockUser(<?php echo $value['user_id']; ?>, this.id, '')"><?php echo $string['action_unblock']; ?></button>
						</div>

					<?php if ($num_follows > 0) { ?>
						<hr class="qak-alert-archive-divider">
					<?php } ?>
				<?php } ?>
			</div>
		<?php } ?>
	</div>
</div>