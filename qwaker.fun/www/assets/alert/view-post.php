<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/only-load.php';
?>
<?php
	$id = strval($_GET['id']);
	$comment = intval($_GET['comment']);
?>
<?php
	$url_post = $default_api.'/post/data.php?id='.$id.'&token='.$_COOKIE['USID'];
	$result_post = json_decode(file_get_contents($url_post, false), true);
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
?>
<div class="qak-alert-container" id="qak-alert-container">
	<div class="qak-alert-container-holder">
		<h2 class="qak-alert-container-holder-title"><?php echo $string['title_view_post']; ?></h2>
		<div class="qak-alert-close" onclick="document.getElementById('qak-alert-container').remove();removeParam('view-post');removeParam('comment')"></div>
		<?php if ($result_post == 0) { ?>
			<h2 class="qak-alert-message"><?php echo $string['message_post_for_private_account']; ?></h2>
		<?php } else { ?>
			<div class="qak-alert-container-data">
				<div class="qak-alert-comment-container">
					<div class="qak-alert-comment-container-top">
						<img src="<?php echo $result_post['user_avatar']; ?>" class="qak-alert-comment-data-avatar" onerror="this.src = '/assets/images/qak-avatar-v3.png'">
						<div class="qak-alert-comment-data-nd">
							<h2 class="qak-alert-comment-data-name">
								<?php echo $result_post['user_login']; ?>
								<?php if (intval($result_post['user_verification']) == 1) { ?>
									<verification-user></verification-user>
								<?php } ?>
							</h2>
							<h2 class="qak-alert-comment-data-date"><?php echo convertTimeRus($result_post['post_date_public']); ?></h2>
						</div>
					</div>
					<div class="qak-alert-comment-container-bottom">
						<?php
							$message = $result_post['post_message'];

							if (preg_match_all('~@+\S+~', $message, $user_link)) {
								$limit_user_noted = 2;
								foreach($user_link[0] as $userNewLink) {
									if ($limit_user_noted !== 0) {
										$nameLink = str_replace('@', '', $userNewLink);
										$message = str_replace($userNewLink, '<user-marked onclick="showUserPopup(\''.$nameLink.'\')">'.$userNewLink.'</user-marked>', $message);
									}
								}
							}
						?>
						<h2 class="qak-alert-comment-data-message"><?php echo nl2br($message, true); ?></h2>
						<?php if (sizeof(json_decode($result_post['post_images'])) > 0) { ?>
							<?php $nmImage = 0; ?>
							<h6 class="qak-alert-comment-documents"><?php echo str_replace('%1s', sizeof(json_decode($result_post['post_images'])), $string['text_post_documents_images']); ?>
								<div class="qak-alert-list-documanets">
									<?php foreach (json_decode($result_post['post_images']) as $val) { ?>
										<div tooltip="<?php echo $string['tooltip_click_to_zoom']; ?>" class="qak-alert-content-image-item" onclick="viewPhoto('<?php echo $val; ?>', '<?php echo htmlspecialchars($result_post['post_images']); ?>', <?php echo $nmImage; ?>)">
											<img src="<?php echo $val; ?>" class="qak-alert-image-item">
										</div>
										<?php $nmImage = $nmImage + 1; ?>
									<?php } ?>
								</div>
							</h6>
						<?php } ?>
					</div>
				</div>
				<?php if (intval($result_post['post_commented']) == 1) { ?>
					<hr class="qak-alert">
					<div class="qak-alert-new-comment">
						<input class="qak-alert-new-comment" type="message" name="message" id="message_comment" autocomplete="off" autosave="off" placeholder="<?php echo $string['hint_entar_a_comment']; ?>">
						<button class="qak-alert-new-comment" onclick="goComment()"><?php echo $string['action_post_comment_send']; ?></button>
					</div>
					<hr class="qak-alert">
				<?php } else { ?>
					<h2 class="qak-alert-message-info"><?php echo $string['text_post_commented_off']; ?></h2>
				<?php } ?> 
				<div class="qak-alert-list-comments" id="qak-alert-list-comments" style="opacity: 1;transition: opacity .2s;">
					<h2 class="qak-alert-data-error"><?php echo $string['message_please_wait']; ?></h2>
				</div>
			</div>
		<?php } ?>
	</div>

	<?php if ($result_post == 0) {} else { ?>
		<script type="text/javascript">
			var commentID = <?php echo $comment; ?>;

			function goComment() {
				var arguments = document.getElementById('message_comment').value;

				if (arguments != '') {
					$.ajax({type: "POST", url: "<?php echo $default_api; ?>/post/comment/new.php", data: {message: arguments, id: '<?php echo $id; ?>', token: '<?php echo $_COOKIE['USID']; ?>'}, success: function(result) {
							var jsonOBJ = JSON.parse(result);
							// console.log(result);
							if (jsonOBJ['type'] == 'success') {
								// alert(jsonOBJ['message']);
								document.getElementById('message_comment').value = '';
								loadComments();
							} if (jsonOBJ['type'] == 'error') {
								alert(jsonOBJ['message']);
							}
						}
					});
				} else {
					alert(stringOBJ['message_no_valid_empty_post_message']);
				}
			}

			loadComments();

			function loadComments() {
				document.getElementById('qak-alert-list-comments').style.opacity = '.5';
				$.ajax({type: "GET", url: "/assets/content/list-comments.php", data: {post: '<?php echo $id; ?>'}, success: function(result) {
						$("#qak-alert-list-comments").empty();
						$("#qak-alert-list-comments").append(result);
						document.getElementById('qak-alert-list-comments').style.opacity = '1';
						if (commentID > 0) {
							goScollToComment(commentID);
						}
					}
				});
			}

			function removeComment(argument) {
				let isRemoveComment = confirm(stringOBJ['message_remove_post_comment_are']);
				if (isRemoveComment) {
					$.ajax({type: "POST", url: "<?php echo $default_api; ?>/post/comment/remove.php", data: {id: argument, post: '<?php echo $id; ?>', token: '<?php echo $_COOKIE['USID']; ?>'}, success: function(result) {
							var jsonOBJ = JSON.parse(result);
							// console.log(result);
							if (jsonOBJ['type'] == 'success') {
								// alert(jsonOBJ['message']);
								// document.getElementById('qak-alert-comment-container-'+argument).remove();
								loadComments();
							} if (jsonOBJ['type'] == 'error') {
								alert(jsonOBJ['message']);
							}
						}
					});
				}
			}

			function reportComment(argument) {
				$.ajax({
					type: "GET", 
					url:  '/assets/alert/view-report-comment.php', 
					data: {id: argument}, 
					success: function(result) {
						$('body').append(result);
					}
				});
			}

			function goScollToComment(argument) {
				document.getElementById('qak-alert-comment-container-'+argument).scrollIntoView();
				document.getElementById('qak-alert-comment-container-'+argument).classList.add('selected');
				commentID = 0;
			}

			function shareComment(argument, argument2, argument3) {
				$.ajax({
					type: "GET", 
					url:  '/assets/alert/view-share.php', 
					data: {url: argument, text: argument2, name: argument3}, 
					success: function(result) {
						$('body').append(result);
					}
				});
			}
		</script>
	<?php } ?>
</div>