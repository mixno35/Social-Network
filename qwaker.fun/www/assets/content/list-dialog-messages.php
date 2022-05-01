<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/only-load.php';
?>
<?php
	$url_messages = $default_api.'/dialog/list-private-dialog-messages.php?token='.$_COOKIE['USID'].'&id='.$_GET['id'];
	$result_messages = json_decode(file_get_contents($url_messages, false), true);
?>
<?php
	function str_starts_with($haystack, $needle) {
		return strpos($haystack, $needle) === 0;
	}

	function str_replace2($find, $replacement, $subject, $limit = 0){
		if ($limit == 0)
			return str_replace($find, $replacement, $subject);
		$ptn = '/' . preg_quote($find,'/') . '/';
		return preg_replace($ptn, $replacement, $subject, $limit);
	}
?>
<?php if (sizeof($result_messages) > 0) { ?>
	<?php $num_mesages = intval(sizeof($result_messages)); ?>
	<?php foreach($result_messages as $key => $value) { ?>
		<?php
			if ($value['type'] == 'text') {
				$text = $value['text'];
				$text2 = $value['text'];

				if (preg_match_all('~@+\S+~', $text, $user_link)) {
					foreach($user_link[0] as $userNewLink) {
						$nameLink = str_replace('@', '', $userNewLink);
						$text = str_replace($userNewLink, '<user-marked onclick="showUserPopup(\''.$nameLink.'\')">'.$userNewLink.'</user-marked>', $text);
					}
				}

				if (preg_match_all('/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i', $text, $user_link)) {
					$limit_user_noted = 1;
					foreach($user_link[0] as $newUserLink) {
						if ($limit_user_noted !== 0) {
							$start_http = "";
							if (str_starts_with($newUserLink, "www.")) {
								$start_http = "http://";
							}
							$text = str_replace($newUserLink, '<a href="/redirect.php?url='.urlencode($start_http.$newUserLink).'">'.$newUserLink.'</a>', $text);
						}
					}
				}

				if (str_starts_with($value['text'], "Resend: @")) {
					$text2 = str_replace('Resend: ', '', $text2);
					$text = str_replace('Resend: ', '', $text);
				}
			}
		?>
		<div class="qak-dialog-message-item <?php if($value['you']==1){echo('you');} ?>" id="qak-dialog-message-item-container-<?php echo $value['id']; ?>">
			<?php if ($value['you'] == 0) {?>
				<div class="container-1">
					<img src="<?php echo $value['uavatar']; ?>" draggable="false" onerror="this.src = '/assets/images/qak-avatar-v3.png'">
				</div>
			<?php } ?>
			<?php if ($value['type'] == 'text') { ?>
				<div class="container <?php if($value['you']==1){echo('you');} ?>" id="qak-dialog-message-item-<?php echo $value['id']; ?>" onclick="openMenuMessage(this.id, '<?php echo $value['id']; ?>', <?php echo $value['you']; ?>, '<?php echo $value['ulogin']; ?>', '<?php echo $text2; ?>')">
					<div class="container-2">
						<?php if (str_starts_with($value['text'], "Resend: @")) { ?>
							<h4 class="resend-message"><?php echo $string['text_message_resend']; ?></h4>
						<?php } ?>
						<h2 class="<?php if($value['you']==1){echo('you');} ?>">
							<?php echo $text; ?>
						</h2>
						<h3 class="<?php if($value['you']==1){echo('you');} ?>">
							<?php echo showDateOnlineUser($value['date']); ?>
							<?php if ($value['status'] == 1) { ?>
								<font><?php echo $string['text_message_readed']; ?></font>
							<?php } ?>
						</h3>
					</div>
				</div>
			<?php } ?>
			<?php if ($value['type'] == 'image') { ?>
				<div class="image-view">
					<img onclick="viewPhoto(this.src)" src="<?php echo $value['source']; ?>" date="<?php echo showDateOnlineUser($value['date']); ?>">
					<font onclick="event.stopPropagation(); deleteMessage('<?php echo $value['id']; ?>')"><?php echo $string['action_message_delete']; ?></font>
				</div>
			<?php } ?>
			<?php if ($value['type'] == 'gif') { ?>
				<?php
					$gif = json_decode($value['source'], true);
				?>
				<div class="image-view gif" onmouseover="document.getElementById('img-gif-<?php echo $value['id']; ?>').src = '<?php echo $gif['url']; ?>'" onmouseout="document.getElementById('img-gif-<?php echo $value['id']; ?>').src = '<?php echo $gif['static']; ?>'" onclick="viewPhoto('<?php echo $gif['url']; ?>');">
					<img id="img-gif-<?php echo $value['id']; ?>" src="<?php echo $gif['static']; ?>">
					<font onclick="event.stopPropagation(); deleteMessage('<?php echo $value['id']; ?>')"><?php echo $string['action_message_delete']; ?></font>
				</div>
			<?php } ?>
		</div>
	<?php } ?>
<?php } else { ?>
	<h2 class="message v2"><?php echo $string['text_no_messages']; ?></h2>
<?php } ?>