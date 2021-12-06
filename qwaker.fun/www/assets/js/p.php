<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
?>
<script type="text/javascript">
	function postEmotion(argument, argument2) {
		event.stopPropagation();
		event.preventDefault();
		$.ajax({type: "POST", url: "<?php echo $default_api; ?>/post/emotion.php", data: {id: argument, type: argument2, token: '<?php echo $_COOKIE['USID'] ?>'}, success: function(result) {
				var jsonOBJ = JSON.parse(result);
				// console.log(result);
				toast(jsonOBJ['message']);
				if (jsonOBJ['type'] == 'success') {
					try {
						openType(posts_type, posts_limit);
					} catch (exx) {}
					try {
						loadUserPosts();
					} catch (exx) {}
				}
			}
		});
	}

	function showAlertPost(id) {
		event.stopPropagation();
		event.preventDefault();
		updParam('view-post', id);
		goAlertPost(id);
	}
	function goAlertPost(id, comment) {
		$.ajax({type: "GET", url: "/assets/alert/view-post.php", data: {id: id, comment: comment}, success: function(result) {
				$("body").append(result);
			}
		});
	}
</script>