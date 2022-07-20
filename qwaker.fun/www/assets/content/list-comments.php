<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/only-load.php';
?>
<?php
	$id = strval($_GET['post']);
	$comment = intval($_GET['comment']);
?>

<?php
	function convertTimePublicComment($originalDate) {
		$day = date("d", strtotime($originalDate));
		$mounth = date("M", strtotime($originalDate));
		$year = date("Y", strtotime($originalDate));
		$hour = date("H", strtotime($originalDate));
		$minute = date("i", strtotime($originalDate));
		$second = date("s", strtotime($originalDate));

		return $day . ' ' . $mounth . ' ' . $year . ' ' . $hour . ':' . $minute;
	}

	function str_replace2($find, $replacement, $subject, $limit = 0){
		if ($limit == 0)
			return str_replace($find, $replacement, $subject);
		$ptn = '/' . preg_quote($find,'/') . '/';
		return preg_replace($ptn, $replacement, $subject, $limit);
	}
?>

<?php
	$url_comment = $default_api.'/post/comment/list.php?id='.$id.'&token='.$_COOKIE['USID'];
	$result_comment = json_decode(file_get_contents($url_comment, false), true);
?>

<?php
	// echo $url_comment.$result_comment;
?>

<?php if (sizeof($result_comment) > 0) { ?>
	<?php $num_comments = intval(sizeof($result_comment)); ?>
	<?php foreach($result_comment as $key => $value) { ?>
		<?php $num_comments = $num_comments - 1; ?>
		<div class="qak-alert-comment-container" id="qak-alert-comment-container-<?php echo $value['id']; ?>">
			<div class="qak-alert-comment-container-top">
				<div style="position: relative;" id="qak-comment-avatar-<?php echo $value['id']; ?>" onclick="showUserPopup('<?php echo $value['user_login']; ?>',this.id)">
					<img src="<?php echo $value['user_avatar']; ?>" class="qak-alert-comment-data-avatar" onerror="this.src = '/assets/images/qak-avatar-v3.png'">
				</div>
				<div class="qak-alert-comment-data-nd">
					<h2 class="qak-alert-comment-data-name">
						<?php echo $value['user_login']; ?>
						<?php if (intval($value['user_verification']) == 1) { ?>
							<!-- <verification-user></verification-user> -->
							<span class="material-symbols-outlined verification">verified</span>
						<?php } ?>
					</h2>
					<h2 class="qak-alert-comment-data-date"><?php echo convertTimeRus($value['comment_date_public']); ?></h2>
				</div>
				<div class="qak-alert-comment-menu" onclick="showMenu('qak-alert-comment-menu-<?php echo $value['id']; ?>')"></div>
				<olx class="popup center" id="qak-alert-comment-menu-<?php echo $value['id']; ?>" style="display: none;" onclick="this.style.display = 'none'">
					<div class="container">
						<li onclick="replyComment('@<?php echo $value['user_login']; ?>')"><?php echo $string['action_post_comment_reply']; ?></li>
						<li onclick="shareComment('<?php echo $default_domain."?view-post=".$id."&comment=".$value["id"]; ?>', '<?php echo $value['comment_message']; ?>', '<?php echo $value['user_login']; ?>')"><?php echo $string['action_post_comment_share']; ?></li>
						<?php if ($value['comment_you'] == 0) { ?>
							<li onclick="reportComment(<?php echo $value['id']; ?>)"><?php echo $string['action_post_comment_report']; ?></li>
						<?php } ?>
						<?php if ($value['comment_you'] == 1) { ?>
							<li onclick="removeComment(<?php echo $value['id']; ?>)"><?php echo $string['action_post_comment_remove']; ?></li>
						<?php } ?>
					</div>
				</olx>
			</div>
			<div class="qak-alert-comment-container-bottom">
				<?php
					$text = $value['comment_message'];
					// CHECK USERS
					if (preg_match_all('~@+\S+~', $text, $user_link)) {
						$limit_user_noted = 1;
						foreach($user_link[0] as $newUserLink) {
							if ($limit_user_noted !== 0) {
								$nameLink = str_replace('@', '', htmlspecialchars($newUserLink));
								$limit_user_noted = $limit_user_noted - 1;
								$text = str_replace2($newUserLink, '<b class="user-link-post-comment" id="ulpc-'.$nameLink.'-'.$value['id'].'" href="/user?id='.$nameLink.'" onclick="showUserPopup(\''.$nameLink.'\',this.id)" target="_blank">'.$newUserLink.'</b>', $text, 1);
							}
						}
					}
				?>
				<h2 class="qak-alert-comment-data-message"><?php echo $text; ?></h2>
			</div>
			<div class="qak-alert-comment-container-likes">
				<div onclick="likeCommnet(<?php echo $value['id']; ?>)">
					<?php
						$result_image_like = '/assets/icons/comments/ic_like.png';
						$result_class_liked = '';
						if ($value['comment_like_you'] > 0) {
							$result_image_like = '/assets/icons/comments/ic_liked.png';
							$result_class_liked = 'liked';
						}
					?>
					<img src="<?php echo $result_image_like; ?>">
					<font class="<?php echo $result_class_liked; ?>"><?php echo $value['comment_likes'] ?></font>
				</div>
			</div>
		</div>
		<?php if ($num_comments > 0) { ?>
			<hr class="qak-alert">
		<?php } ?>
	<?php } ?>

	<script type="text/javascript">
		function replyComment(argument) {
			document.getElementById('message_comment').value = argument+' ';
			document.getElementById('message_comment').focus();
		}

		function likeCommnet(argument) {
			$.ajax({type: "POST", url: "<?php echo $default_api; ?>/post/comment/like.php", data: {id: argument, token: '<?php echo $_COOKIE['USID']; ?>'}, success: function(result) {
					var jsonOBJ = JSON.parse(result);
					// console.log(result);
					if (jsonOBJ['type'] == 'success') {
						toast(jsonOBJ['message']);
						loadComments();
					} if (jsonOBJ['type'] == 'error') {
						toast(jsonOBJ['message']);
					}
				}
			});
		}
	</script>
<?php } else { ?>
	<h2 class="qak-alert-data-error"><?php echo $string['message_post_no_comments']; ?></h2>
<?php } ?>