<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/only-load.php';
?>
<div class="qak-alert-container" id="qak-alert-container">
	<div class="qak-alert-container-holder">
		<h2 class="qak-alert-container-holder-title"><?php echo $string['title_alert_restore_password']; ?></h2>
		<div class="qak-alert-close" onclick="document.getElementById('qak-alert-container').remove()"></div>
		<div class="container-restore-password-alert">
			<input type="email" name="" id="password-restore" placeholder="<?php echo $string['hint_enter_email_restore_password']; ?>">
			<center>
				<button onclick="goRestorePass()"><?php echo $string['action_restore_password']; ?></button>
			</center>
		</div>
	</div>

	<script type="text/javascript">
		function goRestorePass() {
			var arguments = document.getElementById('password-restore').value;

			if (arguments == '') {
				alert(stringOBJ['message_restore_pass_enter']);
			} else {
				$.ajax({type: "POST", url: "<?php echo $default_api; ?>/auth/secure/restore-pass.php", data: {login: arguments}, success: function(result) {
						var jsonOBJ = JSON.parse(result);
						// console.log(result);
						alert(jsonOBJ['message']);
						if (jsonOBJ['type'] == 'success') {
							document.getElementById('qak-alert-container').remove();
						}
					}
				});
			}
		}
	</script>
</div>