<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
?>
<?php
	$url_user_new_p = $default_api.'/user/data.php?token='.$_COOKIE['USID'];
	$result_user_new_p = json_decode(file_get_contents($url_user_new_p, false), true);
?>
<?php if ($_COOKIE['USID'] != '') { ?>
	<div class="qak-container-data new-post-container">
		<div class="new-post-container-v1" onclick="openNewPostContainerPage()">
			<img src="<?php echo $result_user_new_p['avatar']; ?>" draggable="false" onerror="this.src = '/assets/images/qak-avatar-v3.png'">
			<h5><?php echo $string['message_click_to_new_post']; ?></h5>
		</div>
		<div class="new-post-container-v2" id="new-post-container-v2" style="display: none;">
			<?php include $_SERVER['DOCUMENT_ROOT'].'/post/content/new.php'; ?>
		</div>
	</div>

	<script type="text/javascript">
		function openNewPostContainerPage() {
			if (document.getElementById('new-post-container-v2').style.display == 'none') {
				document.getElementById('new-post-container-v2').style.display = 'block';
				try {
					document.getElementById('message-new-post').focus();
				} catch (exx) {}
			} else {
				document.getElementById('new-post-container-v2').style.display = 'none';
			}
		}
	</script>
<?php } ?>