<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/only-load.php';
?>
<?php
	function convertTimePublicPost($originalDate) {
		$day = date("d", strtotime($originalDate));
		$mounth = date("M", strtotime($originalDate));
		$year = date("Y", strtotime($originalDate));
		$hour = date("H", strtotime($originalDate));
		$minute = date("i", strtotime($originalDate));
		$second = date("s", strtotime($originalDate));

		return $day . ' ' . $mounth . ' ' . $year . ' ' . $hour . ':' . $minute;
	}
?>
<div class="qak-alert-container" id="qak-alert-container">
	<div class="qak-alert-container-holder">
		<h2 class="qak-alert-container-holder-title"><?php echo $string['title_list_archive']; ?></h2>
		<div class="qak-alert-close" onclick="document.getElementById('qak-alert-container').remove()"></div>
		<div id="qak-alert-list-archive">
			<h2 class="qak-alert-message"><?php echo $string['message_please_wait']; ?></h2>
		</div>

		<script type="text/javascript">
			function goEditPost(argument) {
				window.location = '/post/edit.php?id='+argument;
			}
			function goArchivePost(argument) {
				$.ajax({
					type: "POST", 
					url: "<?php echo $default_api; ?>/post/archive.php", 
					data: {token: '<?php echo $_COOKIE['USID'] ?>', id: argument}, 
			    	success: function(result){
						// console.log(result);
						var jsonOBJ = JSON.parse(result);
						toast(jsonOBJ['message']);
						if (jsonOBJ['type'] == 'success') {
							try {
								// document.getElementById('qak-alert-archive-item-'+argument).remove();
							} catch (exx) {}
							try {
								loadListArchive();
							} catch (exx) {}
							try {
								openType(posts_type, posts_limit, '');
							} catch (exx) {}
							try {
								loadUserPosts();
							} catch (exx) {}
						}
					}
				});
			}
			function goRemovePost(argument) {
				if (confirm(stringOBJ['message_remove_post_are'])) {
					$.ajax({
						type: "POST", 
						url: "<?php echo $default_api; ?>/post/remove.php", 
						data: {token: '<?php echo $_COOKIE['USID'] ?>', id: argument}, 
				    	success: function(result){
							// console.log(result);
							var jsonOBJ = JSON.parse(result);
							toast(jsonOBJ['message']);
							if (jsonOBJ['type'] == 'success') {
								try {
									// document.getElementById('qak-alert-archive-item-'+argument).remove();
								} catch (exx) {}
								try {
									loadListArchive();
								} catch (exx) {}
							}
						}
					});
				}
			}

			loadListArchive();

			function loadListArchive() {
				$.ajax({type: "GET", url: "/assets/content/list-archive-content.php", data: {id: '<?php echo $id; ?>'}, success: function(result) {
						$("#qak-alert-list-archive").empty();
						$("#qak-alert-list-archive").append(result);
					}
				});
			}
		</script>
	</div>
</div>