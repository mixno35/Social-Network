<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/only-load.php';
?>
<?php
	$url_post = $default_api.'/post/archive-list.php?token='.$_COOKIE['USID'];
	$result_post = json_decode(file_get_contents($url_post, false), true);
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
<?php $num_posts = intval(sizeof($result_post)); ?>
<?php if (sizeof($result_post) == 0) { ?>
	<h2 class="qak-alert-message"><?php echo $string['message_no_archive_post']; ?></h2>
<?php } else { ?>
	<?php foreach($result_post as $key => $value) { ?>
		<?php $num_posts = $num_posts - 1; ?>
		<div class="qak-alert-archive-item" id="qak-alert-archive-item-<?php echo $value['id']; ?>">
			<div>
				<img src="<?php echo $value['user_avatar']; ?>" class="qak-alert-image-archive" onerror="this.src = '/assets/images/qak-avatar-v3.png'">
			</div>
			<div class="qak-alert-data-2">
				<div class="qak-alert-container-top-archive-data">
					<h2>
						<?php echo $value['user_login']; ?>
						<div class="qak-alert-comment-menu archive" onclick="showMenu('qak-alert-comment-menu-<?php echo $value['id']; ?>')"></div>
						<olx class="popup center" id="qak-alert-comment-menu-<?php echo $value['id']; ?>" style="display: none;" onclick="this.style.display = 'none'">
							<div class="container">
								<li onclick="goArchivePost(<?php echo $value['id']; ?>)"><?php echo $string['action_post_unarchive']; ?></li>
								<li onclick="goEditPost(<?php echo $value['id']; ?>)"><?php echo $string['action_post_edit']; ?></li>
								<li onclick="goRemovePost(<?php echo $value['id']; ?>)"><?php echo $string['action_post_remove']; ?></li>
							</div>
						</olx>
					</h2>
					<h3><?php echo convertTimeRus($value['post_date_public']); ?></h3>
				</div>
				<h4><?php echo $value['post_message']; ?></h4>
				<?php if (sizeof(json_decode($value['post_images'])) > 0) { ?>
					<?php $nmImage = 0; ?>
					<h6 class="qak-alert-comment-documents"><?php echo str_replace('%1s', sizeof(json_decode($value['post_images'])), $string['text_post_documents_images']); ?>
						<div class="qak-alert-list-documanets">
							<?php foreach (json_decode($value['post_images']) as $val) { ?>
								<div tooltip="<?php echo $string['tooltip_click_to_zoom']; ?>" class="qak-alert-content-image-item" onclick="viewPhoto('<?php echo $val; ?>', '<?php echo htmlspecialchars($value['post_images']); ?>', <?php echo $nmImage; ?>)">
									<img src="<?php echo $val; ?>" class="qak-alert-image-item">
								</div>
								<?php $nmImage = $nmImage + 1; ?>
							<?php } ?>
						</div>
					</h6>
				<?php } ?>
				<div style="display: none;align-items: center;">
					<button class="border qak-button-archive" onclick="goArchivePost(<?php echo $value['id']; ?>)"><?php echo $string['action_post_unarchive']; ?></button>
					<button class="border qak-button-archive" onclick="goEditPost(<?php echo $value['id']; ?>)"><?php echo $string['action_post_edit']; ?></button>
					<button class="border qak-button-archive" onclick="goRemovePost(<?php echo $value['id']; ?>)"><?php echo $string['action_post_remove']; ?></button>
				</div>
			</div>
		</div>
		<?php if ($num_posts != 0) { ?>
			<hr class="qak-alert-archive-divider">
		<?php } ?>
	<?php } ?>
<?php } ?>