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
	<!-- <hr> -->
	<label for="chat_invite" style="display:none;">
		<div class="qak-sign-container check">
			<div style="width: 100%;">
				<h4 class="qak-short-hint title"><?php echo $string['hint_edit_chat_invite']; ?></h4>
				<h4 class="qak-short-hint message sub"><?php echo $string['message_edit_chat_invite']; ?></h4>
			</div>
			<input type="checkbox" <?php if($result_user['chat_invite']==1){echo 'checked';} ?> name="chat_invite" id="chat_invite" class="qak-input-check" autocomplete="off" placeholder="<?php echo $string['hint_edit_chat_invite']; ?>">
		</div>
	</label>
	<div class="qak-cs">
		<div style="width: 100%;"></div>
		<button onclick="savePrivate()"><?php echo $string['action_save']; ?></button>
	</div>
</div>
<script type="text/javascript">
	function savePrivate() {
		var online = document.getElementById('online').checked;
		var private = document.getElementById('private').checked;
		var show_url = document.getElementById('show_url').checked;
		var find_me = document.getElementById('find_me').checked;
		var private_message = document.getElementById('private_message').checked;
		var chat_invite = document.getElementById('chat_invite').checked;
		showProgressBar();
		$.ajax({
			type: "POST", 
			url: "<?php echo $default_api; ?>/user/edit/private.php", 
			data: {token: '<?php echo $_COOKIE['USID'] ?>', online: online, private: private,  show_url: show_url, find_me: find_me, private_message: private_message, chat_invite: chat_invite}, 
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