<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';

	$url_user = $default_api.'/user/edit/data.php?token='.$_COOKIE['USID'];
	$result_user = json_decode(file_get_contents($url_user, false), true);
?>
<h3 class="qak-edit-title"><?php echo $string['edit_title_2']; ?></h3>
<div class="qak-container-data">
	<label for="email_auth">
		<div class="qak-sign-container check">
			<div style="width: 100%;">
				<h4 class="qak-short-hint title"><?php echo $string['hint_edit_two_auth']; ?></h4>
				<h4 class="qak-short-hint message sub"><?php echo $string['message_edit_two_auth']; ?></h4>
			</div>
			<input type="checkbox" <?php if($result_user['email_authorization']==1){echo 'checked';} ?> name="email_auth" id="email_auth" class="qak-input-check" autocomplete="off" placeholder="<?php echo $string['hint_edit_two_auth']; ?>">
		</div>
	</label>
	<hr>
	<label for="restore_password">
		<div class="qak-sign-container check">
			<div style="width: 100%;">
				<h4 class="qak-short-hint title"><?php echo $string['hint_edit_restore_password']; ?></h4>
				<h4 class="qak-short-hint message sub"><?php echo $string['message_edit_restore_password']; ?></h4>
			</div>
			<input type="checkbox" <?php if($result_user['restore_password']==1){echo 'checked';} ?> name="restore_password" id="restore_password" class="qak-input-check" autocomplete="off" placeholder="<?php echo $string['hint_edit_restore_password']; ?>">
		</div>
	</label>
	<div class="qak-cs">
		<div style="width: 100%;"></div>
		<button onclick="saveConf()"><?php echo $string['action_save']; ?></button>
	</div>
</div>
<div class="qak-container-data">
	<div class="qak-sign-container check">
		<div style="width: 100%;">
			<h4 class="qak-short-hint title"><?php echo $string['hint_edit_update_password']; ?></h4>
			<h4 class="qak-short-hint message sub"><?php echo $string['message_edit_update_password']; ?></h4>
		</div>
		<button class="go" onclick="updatePasswordAlert()" title="<?php echo $string['action_change_password']; ?>"></button>
	</div>
</div>
<h5 class="message-bottom">
	<?php echo str_replace('%1s', '<a href="/delete-account.php">'.$string['action_delete_account'].'</a>', $string['text_delete_account']); ?>
</h5>
<script type="text/javascript">
	function saveConf() {
		var email_auth = document.getElementById('email_auth').checked;
		var restore_password = document.getElementById('restore_password').checked;
		showProgressBar();
		$.ajax({
			type: "POST", 
			url: "<?php echo $default_api; ?>/user/edit/conf.php", 
			data: {token: '<?php echo $_COOKIE['USID'] ?>', email_auth: email_auth, restore_password: restore_password}, 
	    	success: function(result){
				// console.log(result);
				hideProgressBar();
				var jsonOBJ = JSON.parse(result);
				alert(jsonOBJ['message']);
				if (jsonOBJ['type'] == 'success') {

				}
			}
		});
	}
</script>