<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';

	$url_user = $default_api.'/user/edit/data.php?token='.$_COOKIE['USID'];
	$result_user = json_decode(file_get_contents($url_user, false), true);
?>
<h3 class="qak-edit-title"><?php echo $string['edit_title_1']; ?></h3>
<div class="qak-container-data">
	<div class="qak-sign-container">
		<h4 class="qak-short-hint"><?php echo $string['hint_edit_name']; ?></h4>
		<input type="name" name="name" id="name" class="qak-input" autocomplete="off" placeholder="<?php echo $string['hint_edit_name']; ?>" value="<?php echo $result_user['name']; ?>">
	</div>
	<div class="qak-sign-container">
		<h4 class="qak-short-hint"><?php echo $string['hint_edit_email']; ?></h4>
		<input type="email" name="email" id="email" class="qak-input" autocomplete="off" placeholder="<?php echo $string['hint_edit_email']; ?>" value="<?php echo $result_user['email']; ?>">
		<h4 class="qak-short-hint message"><?php echo $string['message_edit_email']; ?></h4>
	</div>
	<div class="qak-sign-container" style="display: none; pointer-events: none;">
		<h4 class="qak-short-hint"><?php echo $string['hint_edit_nickname']; ?></h4>
		<input type="login" name="nickname" id="nickname" class="qak-input" autocomplete="off" placeholder="<?php echo $string['hint_edit_nickname']; ?>" value="<?php echo $result_user['nickname']; ?>">
		<h4 class="qak-short-hint message"><?php echo $string['message_edit_nickname']; ?></h4>
	</div>
	<div class="qak-sign-container">
		<h4 class="qak-short-hint"><?php echo $string['hint_edit_about']; ?></h4>
		<input type="about" name="about" id="about" class="qak-input" autocomplete="off" placeholder="<?php echo $string['hint_edit_about']; ?>" value="<?php echo $result_user['about']; ?>">
		<h4 class="qak-short-hint message"><?php echo $string['message_edit_about']; ?></h4>
	</div>
	<div class="qak-cs">
		<div style="width: 100%;"></div>
		<button onclick="saveDef()"><?php echo $string['action_save']; ?></button>
	</div>
</div>
<script type="text/javascript">
	function saveDef() {
		var name = document.getElementById('name').value;
		var email = document.getElementById('email').value;
		var nickname = document.getElementById('nickname').value;
		var about = document.getElementById('about').value;
		showProgressBar();
		$.ajax({
			type: "POST", 
			url: "<?php echo $default_api; ?>/user/edit/def.php", 
			data: {token: '<?php echo $_COOKIE['USID'] ?>', name: name, email: email, nickname: nickname, about: about}, 
	    	success: function(result){
				// console.log(result);
				hideProgressBar();
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