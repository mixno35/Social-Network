<?php
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
?>
<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
?>

<script type="text/javascript">
	function followUser(id, button, token) {
		showProgressBar();
		$.ajax({type: "POST", url: "<?php echo $default_api; ?>/user/follow.php", data: {id: id, token: '<?php echo $_COOKIE['USID']; ?>'}, success: function(result) {
				// console.log(result);
				hideProgressBar();
				var jsonOBJ = JSON.parse(result);
				if (jsonOBJ['type'] == 'success') {
					if (jsonOBJ['id'] == 'id_user_follow_success_unfollowed') {
						document.getElementById(button).textContent = stringOBJ['action_following'];
						document.getElementById(button).classList.remove("border");
						return;
					} if (jsonOBJ['id'] == 'id_user_follow_success_followed') {
						document.getElementById(button).textContent = stringOBJ['action_followed'];
						document.getElementById(button).classList.add("border");
						return;
					} if (jsonOBJ['id'] == 'id_user_follow_success_followed_wait') {
						document.getElementById(button).textContent = stringOBJ['action_follow_wait'];
						document.getElementById(button).classList.remove("border");
						return;
					}
					return;
				} if (jsonOBJ['type'] == 'error') {
					alert(jsonOBJ['message']);
					return;
				}
			}
		});
	}

	function blockUser(id, button, token) {
		let isBlockUser = confirm(stringOBJ['message_user_ban_unban_description_confirm']);
		if (isBlockUser) {
			showProgressBar();
			$.ajax({type: "POST", url: "<?php echo $default_api; ?>/user/block.php", data: {id: id, token: '<?php echo $_COOKIE['USID']; ?>'}, success: function(result) {
					// console.log(result);
					hideProgressBar();
					var jsonOBJ = JSON.parse(result);
					if (jsonOBJ['type'] == 'success') {
						if (jsonOBJ['id'] == 'id_user_block_success_blocked') {
							document.getElementById(button).textContent = stringOBJ['action_unblock'];
							return;
						} if (jsonOBJ['id'] == 'id_user_block_success_unblocked') {
							document.getElementById(button).textContent = stringOBJ['action_block'];
							return;
						}
						return;
					} if (jsonOBJ['type'] == 'error') {
						alert(jsonOBJ['message']);
						return;
					}
				}
			});
		}
	}
</script>