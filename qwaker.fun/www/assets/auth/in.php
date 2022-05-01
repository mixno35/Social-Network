<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
?>

<div class="qak-sign-container-other-auth">
	<img src="/assets/icons/other-auth/vk.png" title="<?php echo str_replace('%1s', 'ВКонтакте', $string['tooltip_sign_in_auth_with']); ?>" onclick="oauthVK()">
</div>

<h3 class="qak-alert-container-message-or"><?php echo $string['short_text_auth_or']; ?></h3>

<div class="qak-sign-container" id="qak-sign-container-login">
	<h4 class="qak-short-hint"><?php echo $string['hint_long_login']; ?></h4>
	<input type="login" name="login" value="<?php echo $_GET['login']; ?>" id="login" class="qak-input" autocomplete="off" placeholder="<?php echo $string['hint_short_login']; ?>">
</div>

<div class="qak-sign-container" id="qak-sign-container-password">
	<h4 class="qak-short-hint"><?php echo $string['hint_long_password']; ?></h4>
	<input type="password" name="password" value="<?php echo $_GET['pass']; ?>" id="password" class="qak-input" autocomplete="off" placeholder="<?php echo $string['hint_short_password']; ?>">
</div>

<div class="qak-sign-container" id="qak-sign-container-code" style="display: none;">
	<h4 class="qak-short-hint"><?php echo $string['hint_long_code']; ?></h4>
	<input type="code" name="code" id="code" class="qak-input" autocomplete="off" placeholder="<?php echo $string['hint_short_code']; ?>">

	<h3 class="qak-sign-container-messane-sign-up"><?php echo $string['message_sign_in_code_info']; ?></h3>
</div>

<button class="qak-sign-button" onclick="goSign()"><?php echo $string['action_sign_in']; ?></button>
<center>
	<h2 class="qak-restore-password-button" onclick="restorePass()"><?php echo $string['action_restore_password']; ?></h2>
</center>

<script type="text/javascript">
	function goSign() {
		var arguments = document.getElementById('login').value;
		var arguments2 = document.getElementById('password').value;
		var arguments3 = document.getElementById('code').value;

		if (arguments2 != '') {
			showProgressBar();
			$.ajax({type: "POST", url: "<?php echo $default_api; ?>/auth/in.php", data: {login: arguments, password: arguments2, code: arguments3}, success: function(result) {
					var jsonOBJ = JSON.parse(result);
					// console.log(result);
					hideProgressBar();
					if (jsonOBJ['type'] == 'success') {
						alert(jsonOBJ['message']);
						if (jsonOBJ['task'] == 'auth:in:success-email') {
							document.getElementById('qak-sign-container-code').style.display = 'block';
							document.getElementById('qak-sign-container-login').style.display = 'none';
							document.getElementById('qak-sign-container-password').style.display = 'none';
							return;
						}
						document.cookie = "USID=" + jsonOBJ['token'] + "; path=/; SameSite=Strict; domain=<?php echo $_SERVER['SERVER_NAME']; ?>; expires=Tue, <?php echo intval(date('d')); ?> <?php echo date('M'); ?> <?php echo intval(date('Y')+1); ?> 00:00:00 GMT";
						document.cookie = "sid=" + jsonOBJ['sid'] + "; path=/; SameSite=Strict; domain=<?php echo $_SERVER['SERVER_NAME']; ?>; expires=Tue, <?php echo intval(date('d')); ?> <?php echo date('M'); ?> <?php echo intval(date('Y')+1); ?> 00:00:00 GMT";
						window.location = '/';
					} if (jsonOBJ['type'] == 'error') {
						alert(jsonOBJ['message']);
						return;
					}
				}
			});
		} else {
			alert(stringOBJ['message_no_valid_empty_password']);
		}
	}

	function restorePass() {
		$.ajax({type: "GET", url:  '/assets/alert/view-restore-password.php', data: "req=ok", success: function(result) {
				$('body').append(result);
			}
		});
	}

	function oauthVK() {
		document.location = 'https://oauth.vk.com/authorize?client_id=<?php echo $vk_client_id; ?>&redirect_uri=<?php echo $default_domain; ?>/oauth.php?service=vk&display=page&response_type=token';
	}
</script>