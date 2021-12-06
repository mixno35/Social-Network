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
	<label for="online">
		<div class="qak-sign-container check">
			<div style="width: 100%;">
				<h4 class="qak-short-hint title"><?php echo $string['hint_edit_online']; ?></h4>
				<h4 class="qak-short-hint message sub"><?php echo $string['message_edit_online']; ?></h4>
			</div>
			<input type="checkbox" <?php if($result_user['show_online']==1){echo 'checked';} ?> name="online" id="online" class="qak-input-check" autocomplete="off" placeholder="<?php echo $string['hint_edit_online']; ?>">
		</div>
	</label>
	<hr>
	<label for="private">
		<div class="qak-sign-container check">
			<div style="width: 100%;">
				<h4 class="qak-short-hint title"><?php echo $string['hint_edit_private']; ?></h4>
				<h4 class="qak-short-hint message sub"><?php echo $string['message_edit_private']; ?></h4>
			</div>
			<input type="checkbox" <?php if($result_user['private']==1){echo 'checked';} ?> name="private" id="private" class="qak-input-check" autocomplete="off" placeholder="<?php echo $string['hint_edit_private']; ?>">
		</div>
	</label>
	<hr>
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
	<label for="show_url">
		<div class="qak-sign-container check">
			<div style="width: 100%;">
				<h4 class="qak-short-hint title"><?php echo $string['hint_edit_show_url']; ?></h4>
				<h4 class="qak-short-hint message sub"><?php echo $string['message_edit_show_url']; ?></h4>
			</div>
			<input type="checkbox" <?php if($result_user['show_url']==1){echo 'checked';} ?> name="show_url" id="show_url" class="qak-input-check" autocomplete="off" placeholder="<?php echo $string['hint_edit_show_url']; ?>">
		</div>
	</label>
	<hr>
	<label for="find_me">
		<div class="qak-sign-container check">
			<div style="width: 100%;">
				<h4 class="qak-short-hint title"><?php echo $string['hint_edit_find_me']; ?></h4>
				<h4 class="qak-short-hint message sub"><?php echo $string['message_edit_find_me']; ?></h4>
			</div>
			<input type="checkbox" <?php if($result_user['find_me']==1){echo 'checked';} ?> name="find_me" id="find_me" class="qak-input-check" autocomplete="off" placeholder="<?php echo $string['hint_edit_find_me']; ?>">
		</div>
	</label>
	<hr>
	<label for="private_message">
		<div class="qak-sign-container check">
			<div style="width: 100%;">
				<h4 class="qak-short-hint title"><?php echo $string['hint_edit_private_message']; ?></h4>
				<h4 class="qak-short-hint message sub"><?php echo $string['message_edit_private_message']; ?></h4>
			</div>
			<input type="checkbox" <?php if($result_user['private_message']==1){echo 'checked';} ?> name="private_message" id="private_message" class="qak-input-check" autocomplete="off" placeholder="<?php echo $string['hint_edit_private_message']; ?>">
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
	<?php echo str_replace('%1s', '<a href="/delete-account">'.$string['action_delete_account'].'</a>', $string['text_delete_account']); ?>
</h5>
<script type="text/javascript">
	function saveConf() {
		var online = document.getElementById('online').checked;
		var private = document.getElementById('private').checked;
		var email_auth = document.getElementById('email_auth').checked;
		var show_url = document.getElementById('show_url').checked;
		var find_me = document.getElementById('find_me').checked;
		var private_message = document.getElementById('private_message').checked;
		var restore_password = document.getElementById('restore_password').checked;
		$.ajax({
			type: "POST", 
			url: "<?php echo $default_api; ?>/user/edit/conf.php", 
			data: {token: '<?php echo $_COOKIE['USID'] ?>', online: online, private: private, email_auth: email_auth, show_url: show_url, find_me: find_me, private_message: private_message, restore_password: restore_password}, 
	    	success: function(result){
				// console.log(result);
				var jsonOBJ = JSON.parse(result);
				alert(jsonOBJ['message']);
				if (jsonOBJ['type'] == 'success') {
					// alert(jsonOBJ['message']);
					// name = jsonOBJ['name_new'];
					// email = jsonOBJ['email_new'];
				}
			}
		});
	}
</script>