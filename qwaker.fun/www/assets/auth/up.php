<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
?>

<hr class="up">

<div class="qak-sign-container">
	<h4 class="qak-short-hint"><?php echo $string['hint_long_login']; ?></h4>
	<input type="login" name="login" id="login" class="qak-input" autocomplete="off" placeholder="<?php echo $string['hint_short_login']; ?>">
</div>

<div class="qak-sign-container">
	<h4 class="qak-short-hint"><?php echo $string['hint_long_name']; ?></h4>
	<input type="name" name="name" id="name" class="qak-input" autocomplete="off" placeholder="<?php echo $string['hint_short_name']; ?>">
</div>

<div class="qak-sign-container">
	<h4 class="qak-short-hint"><?php echo $string['hint_long_password']; ?></h4>
	<input type="password" name="password" id="password" class="qak-input" autocomplete="off" placeholder="<?php echo $string['hint_short_password']; ?>">
</div>

<div class="qak-sign-container">
	<h4 class="qak-short-hint"><?php echo $string['hint_long_confirm_password']; ?></h4>
	<input type="password" name="confirm_password" id="confirm_password" class="qak-input" autocomplete="off" placeholder="<?php echo $string['hint_short_confirm_password']; ?>">
</div>
<div class="qak-sign-container">
	<h4 class="qak-short-hint"><?php echo $string['hint_long_invite_code']; ?></h4>
	<input type="invite" name="invite" id="invite" class="qak-input" autocomplete="off" placeholder="<?php echo $string['hint_short_invite_code']; ?>">
	<h5 class="qak-input-what" onclick="openWhatInvite()"><?php echo $string['action_what_is']; ?></h5>
</div>

<h3 class="qak-sign-container-messane-sign-up" style="display: none;" id="container-invite"><?php echo $string['message_sign_up_invate']; ?></h3>
<h3 class="qak-sign-container-messane-sign-up"><?php echo $string['message_sign_up_privacy_terms_checked']; ?></h3>

<button class="qak-sign-button" onclick="goSign()"><?php echo $string['action_sign_up']; ?></button>

<script type="text/javascript">
	function goSign() {
		var arguments = document.getElementById('login').value;
		var arguments2 = document.getElementById('name').value;
		var arguments3 = document.getElementById('password').value;
		var arguments4 = document.getElementById('confirm_password').value;
		var arguments5 = document.getElementById('invite').value;

		if (arguments3 != '' && arguments4 != '') {
			if (arguments3 == arguments4) {
				$.ajax({type: "POST", url: "<?php echo $default_api; ?>/auth/up.php", data: {login: arguments, name: arguments2, password: arguments3, invite: arguments5}, success: function(result) {
						var jsonOBJ = JSON.parse(result);
						// console.log(result);
						if (jsonOBJ['type'] == 'success') {
							openSign('in');
							alert(jsonOBJ['message']);
						} if (jsonOBJ['type'] == 'error') {
							alert(jsonOBJ['message']);
						}
					}
				});
			} else {
				alert(stringOBJ['message_no_valid_confirm_password']);
			}
		} else {
			alert(stringOBJ['message_no_valid_empty_password']);
		}
	}

	function openWhatInvite() {
		if (document.getElementById('container-invite').style.display == 'none') {
			document.getElementById('container-invite').style.display = 'block';
		} else {
			document.getElementById('container-invite').style.display = 'none';
		}
	}
</script>