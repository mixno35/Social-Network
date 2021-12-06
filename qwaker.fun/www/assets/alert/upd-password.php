<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/only-load.php';
?>
<div class="qak-alert-container" id="qak-alert-container">
	<div class="qak-alert-container-holder">
		<h2 class="qak-alert-container-holder-title"><?php echo $string['title_change_password']; ?></h2>
		<div class="qak-alert-close" onclick="document.getElementById('qak-alert-container').remove()"></div>
		<div class="qak-alert-container-data">
			<input type="password" name="password_old" id="password_old" autocomplete="nope" placeholder="<?php echo $string['hint_upd_password_old']; ?>" style="margin: 0 10px;margin-top: 10px;">
			<input type="password" name="password_new" id="password_new" autocomplete="new-password" placeholder="<?php echo $string['hint_upd_password_new']; ?>" style="margin: 0 10px;margin-top: 10px;">
			<center style="margin-top: 20px;" >
				<button onclick="updPassword()"><?php echo $string['action_change_password_save']; ?></button>
			</center>
		</div>
	</div>

	<script type="text/javascript">
		function updPassword() {
			if (confirm(stringOBJ['message_realy_save_password_are'])) {
				var po = document.getElementById('password_old').value;
				var pn = document.getElementById('password_new').value;
				if (po == '' || pn == '') {
					alert(stringOBJ['message_save_password_empty']);
				} else {
					$.ajax({
						type: "POST", 
						url: "<?php echo $default_api; ?>/user/edit/password.php", 
						data: {token: '<?php echo $_COOKIE['USID']; ?>', po: po, pn: pn}, 
				    	success: function(result){
							// console.log(result);
							var jsonOBJ = JSON.parse(result);
							alert(jsonOBJ['message']);
							if (jsonOBJ['type'] == 'success') {
								document.getElementById('qak-alert-container').remove();
							}
						}
					});
				}
			}
		}
	</script>
</div>