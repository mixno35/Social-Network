<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/only-load.php';
?>
<?php
	$id = strval($_GET['id']);
?>
<?php
	$url_post = $default_api.'/post/settings/data.php?id='.$id.'&token='.$_COOKIE['USID'];
	$result_post = json_decode(file_get_contents($url_post, false), true);
?>
<?php
	function convertTimePublicComment($originalDate) {
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
		<h2 class="qak-alert-container-holder-title"><?php echo $string['title_post_settings']; ?></h2>
		<div class="qak-alert-close" onclick="document.getElementById('qak-alert-container').remove()"></div>
		<div class="qak-alert-container-data">
			<div class="qak-alert-container-data-settings-post">
				<label for="commented">
					<div class="qak-sign-container check">
						<div style="width: 100%;">
							<h4 class="qak-short-hint title"><?php echo $string['hint_post_settings_commented']; ?></h4>
							<h4 class="qak-short-hint message sub"><?php echo $string['message_post_settings_commented']; ?></h4>
						</div>
						<input type="checkbox" <?php if($result_post['commented']==1){echo 'checked';} ?> name="commented" id="commented" class="qak-input-check" autocomplete="off" placeholder="<?php echo $string['hint_post_settings_commented']; ?>">
					</div>
				</label>
			</div>
			<h2 class="qak-alert-report-message-small"><?php echo $string['message_post_settings_info']; ?></h2>
		</div>
	</div>
	<script type="text/javascript">
		function saveSettingsPost() {
			// body...
		}
	</script>
</div>