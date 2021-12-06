<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/only-load.php';
?>
<?php
	$url_dialogs = $default_api.'/dialog/list-private-dialog.php?token='.$_COOKIE['USID'];
	$result_dialogs = json_decode(file_get_contents($url_dialogs, false), true);
?>
<?php
	function getSend($value='', $user='', $message='') {
		include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
		$result = str_replace('%1s', '', $string_message_dialog_sent_none);
		switch ($value) {
			case 'other':
				$result = str_replace('%1s', $user, $string['text_dialog_sent_other']);
				$result = str_replace('%2s', $message, $result);
				break;
			case 'you':
				$result = str_replace('%1s', $user, $string['text_dialog_sent_you']);
				$result = str_replace('%2s', $message, $result);
				break;
			
			default:
				$result = str_replace('%1s', '', $string['text_dialog_sent_none']);
				break;
		}
		return $result;
	}
?>
<?php if (sizeof($result_dialogs) > 0) { ?>
	<?php $num_dialogs = intval(sizeof($result_dialogs)); ?>
	<?php foreach($result_dialogs as $key => $value) { ?>
		<?php $num_dialogs = $num_dialogs - 1; ?>
		<div class="qak-dialog-item-container" id="qak-dialog-item-<?php echo $value['did']; ?>" onclick="openDialog('<?php echo $value['did']; ?>', '<?php echo $value['ulogin']; ?>', '<?php echo $value['uavatar']; ?>')">
			<div class="content-1">
				<img src="<?php echo $value['uavatar']; ?>" draggable="false" onerror="this.src = '/assets/images/qak-avatar-v3.png'">
			</div>
			<div class="content-2">
				<h1>
					<?php echo $value['ulogin']; ?>
					<?php if (intval($value['uverification']) == 1) { ?>
						<verification-user></verification-user>
					<?php } ?>
					<font><?php echo showDateOnlineUser($value['date2']); ?></font>
				</h1>
				<h2><?php echo getSend($value['send'], $value['ulogin'], '******************') ?></h2>
			</div>
			<?php if ($value['status'] == 0) { ?>
				<status-new class="<?php if($value['status_int']>0){echo 'int';} ?>">
					<?php if($value['status_int']>0){echo $value['status_int'];} ?>
				</status-new>
			<?php } ?>
		</div>
		<?php if ($num_dialogs > 0) { ?>
			<hr class="qak-alert-archive-divider">
		<?php } ?>
	<?php } ?>
<?php } else { ?>
	<h2 class="message"><?php echo $string['text_no_dialogs']; ?></h2>
<?php } ?>