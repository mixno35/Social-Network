<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';

	$url_user = $default_api.'/user/edit/data.php?token='.$_COOKIE['USID'];
	$result_user = json_decode(file_get_contents($url_user, false), true);

	if ($result_user['private'] == 1) {
		$message_lc_public = $string['message_link_contact_account_private'];
		$class_lc_public = 'info';
	} else {
		if ($result_user['show_url'] == 1) {
			$message_lc_public = $string['message_link_contact_true_public'];
			$class_lc_public = 'success';
		} else {
			$message_lc_public = $string['message_link_contact_false_public'];
			$class_lc_public = 'error';
		}
	}
?>
<h3 class="qak-edit-title"><?php echo $string['edit_title_4']; ?></h3>
<div class="qak-container-data">
	<h2 class="message-category <?php echo $class_lc_public; ?>" style="margin-bottom: 20px;"><?php echo $message_lc_public; ?></h2>

	<div class="qak-sign-container">
		<h4 class="qak-short-hint"><?php echo $string['hint_edit_url_site']; ?></h4>
		<input type="url" name="url_site" id="url_site" class="qak-input" autocomplete="off" placeholder="<?php echo $string['hint_edit_url_site']; ?>" value="<?php echo $result_user['url_site']; ?>">
	</div>
	<div class="qak-sign-container">
		<h4 class="qak-short-hint"><?php echo $string['hint_edit_url_social']; ?></h4>
		<input type="url" name="url_social" id="url_social" class="qak-input" autocomplete="off" placeholder="<?php echo $string['hint_edit_url_social']; ?>" value="<?php echo $result_user['url_social']; ?>">
	</div>
	<div class="qak-sign-container">
		<h4 class="qak-short-hint"><?php echo $string['hint_edit_url_phone']; ?></h4>
		<input type="phone" name="url_phone" id="url_phone" class="qak-input" autocomplete="off" placeholder="<?php echo $string['hint_edit_url_phone']; ?>" value="<?php echo $result_user['url_phone']; ?>">
	</div>
	<div class="qak-sign-container">
		<h4 class="qak-short-hint"><?php echo $string['hint_edit_url_email']; ?></h4>
		<input type="email" name="url_email" id="url_email" class="qak-input" autocomplete="off" placeholder="<?php echo $string['hint_edit_url_email']; ?>" value="<?php echo $result_user['url_email']; ?>">
	</div>
	
	<div class="qak-cs">
		<div style="width: 100%;"></div>
		<button onclick="saveUrl()"><?php echo $string['action_save']; ?></button>
	</div>
</div>
<script type="text/javascript">
	function saveUrl() {
		var url_site = document.getElementById('url_site').value;
		var url_social = document.getElementById('url_social').value;
		var url_phone = document.getElementById('url_phone').value;
		var url_email = document.getElementById('url_email').value;
		$.ajax({
			type: "POST", 
			url: "<?php echo $default_api; ?>/user/edit/url.php", 
			data: {token: '<?php echo $_COOKIE['USID'] ?>', site: url_site, social: url_social, phone: url_phone, email: url_email}, 
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