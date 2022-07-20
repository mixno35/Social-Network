<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/only-load.php';
?>
<?php
	$limit = $_GET['limit'];
	$hashtag = $_GET['hashtag'];

	$url_data = $default_api.'/post/list-rec.php?token='.$_COOKIE['USID'].'&limit='.$limit.'&hashtag='.$hashtag;
	$result_post = json_decode(file_get_contents($url_data, false), true);
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

	function declOfNum($num, $titles) {
	    $cases = array(2, 0, 1, 1, 1, 2);
	    return $num . " " . $titles[($num % 100 > 4 && $num % 100 < 20) ? 2 : $cases[min($num % 10, 5)]];
	}
?>

<?php if ($_COOKIE['hide-popup-rec'] === 'false') { ?>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/content/page-select-rec.php'; ?>
<?php } ?>

<?php if (sizeof($result_post) == 0) { ?>
	<h2 class="qak-index-message"><?php echo $string['message_no_content']; ?></h2>
<?php } else { ?>
	<div class="qak-container-data">
		<?php $num_posts = intval(sizeof($result_post)); ?>
		<?php foreach($result_post as $key => $value) { ?>
			<?php $num_posts = $num_posts - 1; ?>
			<div id="qak-p-<?php echo $value['id']; ?>" <?php if (isMobile()) { ?>style="position: relative;"<?php } ?>>
				
					
				<div class="qak-p-container-data" onclick="showAlertPost(<?php echo $value['id']; ?>)">
					<div class="qak-post-menu" onclick="closePopups(); popupWindow('qak-post-menu-popup-<?php echo $value['id']; ?>')">
						<ol class="popup arrow menu-post" id="qak-post-menu-popup-<?php echo $value['id']; ?>" style="display: none;">
							<li onclick="goSharePost('<?php echo $default_domain."?view-post=".$value["id"]; ?>', '<?php echo str_replace("\n", "", $value['post_message']); ?>', '<?php echo $value['user_login']; ?>')"><?php echo $string['action_post_share']; ?></li>
							<?php if ($value['post_you'] == 1) { ?>
								<li onclick="goEditPost(<?php echo $value['id']; ?>)"><?php echo $string['action_post_edit']; ?></li>
								<li onclick="goArchivePost(<?php echo $value['id']; ?>)"><?php echo $string['action_post_archive']; ?></li>
								<hr>
								<li onclick="goStatPost(<?php echo $value['id']; ?>)"><?php echo $string['action_post_stat']; ?></li>
								<li onclick="goRemovePost(<?php echo $value['id']; ?>)"><?php echo $string['action_post_remove']; ?></li>
							<?php } ?>
							<li onclick="goPostEmotions(<?php echo $value['id']; ?>)"><?php echo $string['action_post_emotions']; ?></li>
							<?php if ($value['post_you'] == 0) { ?>
								<li onclick="goReportPost(<?php echo $value['id']; ?>)"><?php echo $string['action_post_report']; ?></li>
							<?php } ?>
						</ol>
					</div>
					<div class="qak-p-content-top">
						<div style="position: relative;" id="qak-post-user-<?php echo $value['id']; ?>"  onclick="showUserPopup('<?php echo $value['user_login']; ?>',this.id)">
							<img src="<?php echo $value['user_avatar']; ?>" class="qak-p-avatar-user" id="qak-p-avatar-user" draggable="false" onerror="this.src = '/assets/images/qak-avatar-v3.png'">
						</div>
						<div class="qak-p-top-content-data">
							<h2 class="qak-p-login-user">
								<?php echo $value['user_login']; ?>
								<?php if (intval($value['user_verification']) == 1) { ?>
									<!-- <verification-user></verification-user> -->
									<span class="material-symbols-outlined verification">verified</span>
								<?php } ?>
							</h2>
							<!-- <bouble-divider></bouble-divider> -->
							<div class="p-date-cont">
								<h2 class="qak-p-date-public-user"><?php echo convertTimeRus(date('d.m.Y H:m:i', $value['post_date_view'])); ?></h2>
								<h2 class="qak-p-message-bottom-info">
									<?php echo declOfNum(intval($value['post_comments']), array($string['character_comment_1'], $string['character_comment_2'], $string['character_comment_3'])); ?>
								</h2>
							</div>
						</div>
					</div>
					<div class="qak-p-content-center">
						<?php if (sizeof(json_decode($value['post_images'])) > 0) { ?>
							<?php $nmImage = 0; ?>
							<div class="qak-p-content-images">
								<?php foreach (json_decode($value['post_images']) as $val) { ?>
									<div tooltip="<?php echo $string['tooltip_click_to_zoom']; ?>" class="qak-p-content-image-item" onclick="viewPhoto('<?php echo $val; ?>', '<?php echo htmlspecialchars($value['post_images']); ?>', <?php echo $nmImage; ?>)">
										<img src="<?php echo $val; ?>" class="qak-p-image-item">
									</div>
									<?php $nmImage = $nmImage + 1; ?>
								<?php } ?>
							</div>
						<?php } ?>
						<?php if (filter_var($value['post_video']['url'], FILTER_VALIDATE_URL)) { ?>
							<?php if (preg_match("/(youtube.com|youtu.be)\/(watch)?(\?v=)?(\S+)?/", $value['post_video']['url'], $match)) { ?>
								<div class="video-cont-youtube">
									<iframe src="https://www.youtube.com/embed/<?php echo str_replace('embed/', '', $match[4]); ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
								</div>
							<?php } ?>
						<?php } ?>
						<h2 class="qak-p-message">
							<?php
								$text = $value['post_message'];

								if (preg_match_all('~#+\S+~', $text, $postTAG)) {
									foreach($postTAG[0] as $usedTAG) {
										$text = str_replace($usedTAG, '<post-tag>'.$usedTAG.'</post-tag>', $text);
									}
								}
							?>
							<?php echo nl2br($text, true); ?>
						</h2>
						<?php if ($value['post_type'] == 'ads') { ?>
							<span class="post-ads"><?php echo $string['text_post_ads']; ?></span>
						<?php } ?>
					</div>
					<div class="qak-p-content-bottom">
						<div class="qak-p-container-emotions">
							<item onclick="postEmotion(<?php echo $value['id']; ?>, 'like')" class="<?php if ($value['post_my_emotion']['like'] == 1) {echo('pasted');} ?>">
								<img src="/assets/icons/emotions/like.png" draggable="false">
								<text><?php echo $value['post_emotions']['likes']; ?></text>
							</item>
							<hr>
							<item onclick="postEmotion(<?php echo $value['id']; ?>, 'dislike')" class="<?php if ($value['post_my_emotion']['dislike'] == 1) {echo('pasted');} ?>">
								<img src="/assets/icons/emotions/dislike.png" draggable="false">
								<text><?php echo $value['post_emotions']['dislikes']; ?></text>
							</item>
							<hr>
							<item onclick="postEmotion(<?php echo $value['id']; ?>, 'heart')" class="<?php if ($value['post_my_emotion']['heart'] == 1) {echo('pasted');} ?>">
								<img src="/assets/icons/emotions/heart.png" draggable="false">
								<text><?php echo $value['post_emotions']['hearts']; ?></text>
							</item>
							<hr>
							<item onclick="postEmotion(<?php echo $value['id']; ?>, 'respect')" class="<?php if ($value['post_my_emotion']['respect'] == 1) {echo('pasted');} ?>">
								<img src="/assets/icons/emotions/respect.png" draggable="false">
								<text><?php echo $value['post_emotions']['respects']; ?></text>
							</item>
							<hr>
							<item onclick="postEmotion(<?php echo $value['id']; ?>, 'shit')" class="<?php if ($value['post_my_emotion']['shit'] == 1) {echo('pasted');} ?>">
								<img src="/assets/icons/emotions/shit.png" draggable="false">
								<text><?php echo $value['post_emotions']['shits']; ?></text>
							</item>
						</div>
					</div>
				</div>

				
				<?php if ($num_posts != 0) { ?>
					<hr class="qak-p-divider">
				<?php } ?>
			</div>
		<?php } ?>
	</div>
	<?php if ($limit > sizeof($result_post)) {} else { ?>
		<button class="qak-button-post-load-more" onclick="loadMore()"><?php echo $string['action_post_more']; ?></button>
	<?php } ?>
	<script type="text/javascript">
		function loadMore() {
			var limitNum = posts_limit + 10;
			try {
				openType(posts_type, limitNum);
			} catch (exx) {}
		}
		function goEditPost(argument) {
			window.location = '/post/edit.php?id='+argument;
		}
		function goArchivePost(argument) {
			showProgressBar();
			$.ajax({
				type: "POST", 
				url: "<?php echo $default_api; ?>/post/archive.php", 
				data: {token: '<?php echo $_COOKIE['USID'] ?>', id: argument}, 
		    	success: function(result){
					// console.log(result);
					hideProgressBar();
					var jsonOBJ = JSON.parse(result);
					toast(jsonOBJ['message']);
					if (jsonOBJ['type'] == 'success') {
						try {
							document.getElementById('qak-p-'+argument).remove();
						} catch (exx) {}
						try {
							openType(posts_type, posts_limit);
						} catch (exx) {}
					}
				}
			});
		}
		function goRemovePost(argument) {
			if (confirm(stringOBJ['message_remove_post_are'])) {
				showProgressBar();
				$.ajax({
					type: "POST", 
					url: "<?php echo $default_api; ?>/post/remove.php", 
					data: {token: '<?php echo $_COOKIE['USID'] ?>', id: argument}, 
			    	success: function(result){
						// console.log(result);
						hideProgressBar();
						var jsonOBJ = JSON.parse(result);
						toast(jsonOBJ['message']);
						if (jsonOBJ['type'] == 'success') {
							try {
								document.getElementById('qak-p-'+argument).remove();
							} catch (exx) {}
							try {
								openType(posts_type, posts_limit);
							} catch (exx) {}
						}
					}
				});
			}
		}

		function goReportPost(argument) {
			showProgressBar();
			$.ajax({
				type: "GET", 
				url:  '/assets/alert/view-report-post.php', 
				data: {id: argument}, 
				success: function(result) {
					hideProgressBar();
					$('body').append(result);
				}
			});
		}

		function goStatPost(argument) {
			showProgressBar();
			$.ajax({
				type: "GET", 
				url:  '/assets/alert/view-stat-post.php', 
				data: {id: argument}, 
				success: function(result) {
					hideProgressBar();
					$('body').append(result);
				}
			});
		}

		function goPostEmotions(argument) {
			showProgressBar();
			$.ajax({
				type: "GET", 
				url:  '/assets/alert/view-list-emotions.php', 
				data: {id: argument}, 
				success: function(result) {
					hideProgressBar();
					$('body').append(result);
				}
			});
		}

		function goSharePost(argument, argument2, argument3) {
			showProgressBar();
			$.ajax({
				type: "GET", 
				url:  '/assets/alert/view-share.php', 
				data: {url: argument, text: argument2, name: argument3}, 
				success: function(result) {
					hideProgressBar();
					$('body').append(result);
				}
			});
		}
	</script>
<?php } ?>