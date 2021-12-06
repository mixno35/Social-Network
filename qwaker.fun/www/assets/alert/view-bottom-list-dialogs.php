<?php
	$url_dialogs = $default_api.'/dialog/list-private-dialog.php?token='.$_COOKIE['USID'].'&limit=5';
	$result_dialogs = json_decode(file_get_contents($url_dialogs, false), true);
?>
<?php if (sizeof($result_dialogs) > 0) { ?>
	<div class="container-bootom-list-dialogs">
		<?php $num_dialogs = intval(sizeof($result_dialogs)); ?>
		<?php foreach($result_dialogs as $key => $value) { ?>
			<?php $num_dialogs = $num_dialogs - 1; ?>
			<a href="/dialog?id=<?php echo $value['did']; ?>">
				<div class="item" title="<?php echo str_replace("%1s", '@'.$value['ulogin'], $string['tooltip_go_to_dialog_user']); ?>">
					<img src="<?php echo $value['uavatar']; ?>" draggable="false" onerror="this.src = '/assets/images/qak-avatar-v3.png'">
					<?php if ($value['status'] == 0) { ?>
						<status-new class="<?php if($value['status_int']>0){echo 'int';} ?>">
							<?php if($value['status_int']>0){echo $value['status_int'];} ?>
						</status-new>
					<?php } ?>
				</div>
			</a>
			<?php if ($num_dialogs > 0) { ?>
				<!-- <hr class="qak-alert-archive-divider"> -->
			<?php } ?>
		<?php } ?>
	</div>
<?php } ?>