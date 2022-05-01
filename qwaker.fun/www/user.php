<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/only-load.php';

	// require_once $_SERVER['DOCUMENT_ROOT'].'/data/online-checker.php';
?>
<?php 
	$title_page = $title_user;
?>
<?php
	$id = $_GET['id'];
?>
<?php
	$url_user = $default_api.'/user/data.php?token='.$_COOKIE['USID'].'&id='.$id;
	$url_user_post = $default_api.'/post/list.php?id='.$id.'&token='.$_COOKIE['USID'];
	// $data_user = array('token' => $_COOKIE['USID'], 'id' => $id);

	// $options_user = array(
	//     'http' => array(
	//         'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
	//         'method'  => 'GET',
	//         'content' => http_build_query($data_user)
	//     )
	// );
	// $context_user  = stream_context_create($options_user);
	$result_user = json_decode(file_get_contents($url_user, false), true);
	$result_user_post = json_decode(file_get_contents($url_user_post, false), true);

	$result_status = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/assets/json/status-list.json', false), true);

	// var_dump($result_user);

	$result_text_follow = $string['action_following'];
	$result_class_follow = '';
	if ($result_user['user_followed_you'] == 'followed') {
		$result_text_follow = $string['action_followed'];
		$result_class_follow = 'border';
	} if ($result_user['user_followed_you'] == 'follow_wait') {
		$result_text_follow = $string['action_follow_wait'];
		$result_class_follow = '';
	}

	$result_text_blacklist = $string['action_block'];
	if ($result_user['m_banned'] == 1) {
		$result_text_blacklist = $string['action_unblock'];
	}
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
<?php
	function showDate2($date) {
		include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';

		if ($date == 1039568400 or $date == 1239148800 or $date == 1023235200 or $date = 1041210000) {
			return date('d M Y'.$string_time_year, $date);
		} else {
			$stf = 0;
			$cur_time = time();
			$diff = $cur_time - $date;
			 
			$seconds = array($string_time_second_1, $string_time_second_2, $string_time_second_3);
			$minutes = array($string_time_minute_1, $string_time_minute_2, $string_time_minute_3);
			$hours = array($string_time_hour_1, $string_time_hour_2, $string_time_hour_3);
			$days = array($string_time_day_1, $string_time_day_2, $string_time_day_3);
			$weeks = array($string_time_week_1, $string_time_week_2, $string_time_week_3);
			$months = array($string_time_month_1, $string_time_month_2, $string_time_month_3);
			$years = array($string_time_year_1, $string_time_year_2, $string_time_year_3);
			// $decades = array( 'десятилетие', 'десятилетия', 'десятилетий' );
			 
			$phrase = array($seconds, $minutes, $hours, $days, $weeks, $months, $years);
			$length = array(1, 60, 3600, 86400, 604800, 2630880, 31570560);
			 
			for ($i = sizeof($length) - 1; ($i >= 0) && (($no = $diff/$length[ $i ]) <= 1 ); $i --) {
				;
			}
			if ($i < 0) {
				$i = 0;
			}
			$_time = $cur_time - ($diff % $length[$i]);
			$no = floor($no);
			$value = sprintf("%d %s ", $no, getPhrase($no, $phrase[ $i ]));
			 
			if (($stf == 1) && ($i >= 1) && (($cur_time - $_time) > 0)) {
				$value .= time_ago($_time);
			}
			 
			return $value . $string_time_ago;
		}
	}

	function getVerificationType($value='') {
		include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';

		switch ($value) {
			case 'popular':
				return $string_message_verification_type_popular;
				break;
			case 'blogger':
				return $string_message_verification_type_blogger;
				break;
			case 'developer':
				return $string_message_verification_type_developer;
				break;
			case 'developer_friend':
				return $string_message_verification_type_developer_friend;
				break;
			
			default:
				return '';
				break;
		}
	}
?>
<!DOCTYPE html>
<html lang="<?php echo $langTAG; ?>" class="<?php echo $default_theme; ?>">
<head>
	<title><?php echo $string['title_preview_user']; ?> | @<?php echo $result_user['login']; ?></title>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/style.php'; ?>
	<link rel="stylesheet" type="text/css" href="<?php echo $default_theme_site; ?>user.css?v=<?php echo time(); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo $default_theme_site; ?>p.css?v=<?php echo time(); ?>">
	<?php if (isMobile()) { ?>
		<link rel="stylesheet" type="text/css" href="<?php echo $default_theme_site; ?>mobile.css?v=<?php echo time(); ?>">
	<?php } ?>
	<link rel="shortcut icon" href="/assets/images/qak-favicon.png" type="image/png">
	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/script.php'; ?>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/js/p.php'; ?>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/js/u.php'; ?>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/meta.php'; ?>
</head>
<body>

	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/auth_check.php'; ?>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/placeholder.php'; ?>

	<?php if (intval($result_user['you']) == 1) { ?>
		<script src="/assets/js/edit/avatar.js?v=3"></script>
	<?php } ?>

	<?php if (intval($_GET['view-post']) != '') { ?>
		<script type="text/javascript" id="goRUNALERT">
			goAlertPost(<?php echo intval($_GET['view-post']); ?>, <?php echo intval($_GET['comment']); ?>);
			document.getElementById('goRUNALERT').remove();
		</script>
	<?php } ?>

	<center class="qak-center-container">
		<?php if ($result_user['type'] == 'success') { ?>
			<?php if ($result_user['id'] != 'id_user_data_banned') { ?>
				<?php if ($result_user['id'] !='id_user_data_private') { ?>
					<div class="qak-container-data-two">
						<!-- <img src="<?php echo $result_user['avatar']; ?>" class="qak-user-background-image"> -->
					
						<div class="qak-container-data-top-sticky">
							<div class="qak-container-data qak-container-data-user user-data">
								<div class="qak-user-content-align">
									<div class="qak-avatar-user" <?php if (isMobile()) { ?><?php if ($result_user['you']==1) { ?>onclick="updateAvatarAlert()"<?php } else { ?>onclick="viewPhoto(document.getElementById('qak-avatar-user').src)"<?php } ?><?php } ?>>
										<?php if (isMobile()==false) { ?>
											<ul class="qak-avatar-user-menu">
												<?php if (intval($result_user['you']) == 1) { ?>
													<li onclick="updateAvatarAlert()"><img src="/assets/icons/icons8-upload-24.png"><?php echo $string['action_user_photo_update']; ?></li>
												<?php } ?>
												<?php if ($result_user['avatar'] != '') { ?>
													<li onclick="viewPhoto(document.getElementById('qak-avatar-user').src)"><img src="/assets/icons/icons8-zoom-plus-24.png"><?php echo $string['action_user_photo_preview']; ?></li>
												<?php } ?>
											</ul>
										<?php } ?>
										<?php if (intval($result_user['you']) == 1 or $result_user['ustatus'] > 0) { ?>
											<?php
												$ustatus = intval($result_user['ustatus']);
											?>
											<div class="qak-user-status" <?php if (intval($result_user['you']) == 1) { echo 'onclick="updStatus()"'; } ?> id="qak-user-status" title="<?php echo $string[$result_status[$ustatus]['description']]; ?>">
												<img id="qak-user-status-image" src="/assets/icons/status/<?php echo $result_status[$ustatus]['key']; ?>.png" onerror="this.src = '/assets/icons/status/default.png?v=2'">
											</div>
										<?php }?>
										<img src="<?php echo $result_user['avatar']; ?>" class="qak-avatar-user" id="qak-avatar-user" draggable="false" onerror="this.src = '/assets/images/qak-avatar-v3.png'">
									</div>
									<div class="qak-user-content-data">
										<h2 class="qak-login-user" id="qak-login-user" <?php if(strlen($result_user['login'])>10){ ?>title="<?php echo $result_user['login']; ?>"<?php } ?>>
											<?php echo $result_user['login']; ?>
										<!-- <?php if (userOnline($result_user['online'])) { ?>
											<online><?php echo $string_message_online; ?></online>
										<?php } ?> -->
										<?php if (intval($result_user['user_verification']) == 1) { ?>
											<verification-user class="user">
												<h5 class="verification-user">
													<?php 
														// $result_text_verification = str_replace('%1s', $result_user['login'], $string_message_user_verified);
														// $result_text_verification = str_replace('%2s', getVerificationType($result_user['user_verification_type']), $result_text_verification);
														// echo $result_text_verification; 
													echo str_replace("%1s", $result_user['login'], $string['message_verify_user']);
													?>
													</h5>
											</verification-user>
										<?php } ?>
										<?php if (intval($result_user['scam']) == 1) { ?>
											<scam-user><?php echo $string['text_user_scam']; ?></scam-user>
										<?php } ?>
									</h2>
										<h2 class="qak-name-user" id="qak-name-user">
											<?php echo $result_user['name']; ?>
											<?php if (trim($result_user['name']) != '') { ?>
												<border-round-name></border-round-name>
											<?php } ?>
											<font title="<?php echo str_replace('%1s', showDateOnlineUser($result_user['online']), $string['text_last_active']); ?>">
												<?php if (userOnline($result_user['online'])) { ?>
													<?php echo $string['text_user_online']; ?>
												<?php } else { ?>
													<?php echo str_replace('%1s', showDateOnlineUser($result_user['online']), $string['text_user_offline']); ?>
												<?php }  ?>
											</font>
										</h2>
									</div>
									<?php if (intval($result_user['you']) == 1) { ?>
										<a href="/edit.php"><button class="border user-account"><?php echo $string['action_edit']; ?></button></a>
									<?php } ?>
									<?php if (intval($result_user['you']) == 0 and $_COOKIE['USID'] != '') { ?>
										<button class="user-account <?php echo $result_class_follow; ?>" onclick="followUser('<?php echo $result_user['login']; ?>', this.id, '')" id="action-follow-user-1"><?php echo $result_text_follow; ?></button>
									<?php } ?>
									<?php if (intval($result_user['you']) == 0 and $_COOKIE['USID'] != '') { ?>
										<button class="user-account border three" onclick="closePopups(); popupWindow('popup-window-user-other')">
											···
											<ol class="popup user-other" id="popup-window-user-other" style="display: none;">
												<?php if ($result_user['user_private_message'] == 1) { ?>
													<li onclick="goMessage('<?php echo $result_user['login']; ?>')"><?php echo $string['action_write_message']; ?></li>
												<?php } ?>
												<li class="user-account" id="action-baneed-user-1" onclick="blockUser('<?php echo $result_user['login']; ?>', this.id, '')"><?php echo $result_text_blacklist; ?></li>
												<?php if ($result_user['you'] == 0) { ?>
													<li onclick="reportUser(<?php echo $result_user['id_user']; ?>)"><?php echo $string['action_user_report']; ?></li>
												<?php } ?>
											</ol>
										</button>
									<?php } ?>
								</div>
							</div>

							<div class="qak-container-data qak-container-data-user other-data">
								<div class="qak-user-content-align content-data-top">
									<center class="qak-user-conent-data-top">
										<h3 class="qak-user-content-message-top"><?php echo $string['title_posts']; ?></h3>
										<h2 class="qak-user-content-title-top"><?php echo $result_user['user_posts']; ?></h2>
									</center>
									<?php $result_user_followers = json_decode($result_user['followers_list'], true); ?>
									<center class="qak-user-conent-data-top" onclick="openFollowersAlert()">
										<h3 class="qak-user-content-message-top"><?php echo $string['title_follows']; ?></h3>
										<?php if (sizeof($result_user_followers) > 0) { ?>
											<div class="qak-user-content-users-follow">
												<?php foreach($result_user_followers as $key => $value) { ?>
													<?php $result_user_follow_data = json_decode($value, true); ?>
													<div class="item-follow-user">
														<img src="<?php echo $result_user_follow_data['avatar']; ?>" onerror="this.src = '/assets/images/qak-avatar-v3.png'" draggable="false">
													</div>
												<?php } ?>
											</div>
										<?php } else { ?>
											<h2 class="qak-user-content-title-top"><?php echo $result_user['user_followers']; ?></h2>
										<?php } ?>
										
									</center>
									<?php $result_user_following = json_decode($result_user['following_list'], true); ?>
									<center class="qak-user-conent-data-top" onclick="openFollowedAlert()">
										<h3 class="qak-user-content-message-top"><?php echo $string['title_followed']; ?></h3>
										<?php if (sizeof($result_user_following) > 0) { ?>
											<div class="qak-user-content-users-follow">
												<?php foreach($result_user_following as $key => $value) { ?>
													<?php $result_user_follow_data = json_decode($value, true); ?>
													<div class="item-follow-user">
														<img src="<?php echo $result_user_follow_data['avatar']; ?>" onerror="this.src = '/assets/images/qak-avatar-v3.png'" draggable="false">
													</div>
												<?php } ?>
											</div>
										<?php } else { ?>
											<h2 class="qak-user-content-title-top"><?php echo $result_user['user_following']; ?></h2>
										<?php } ?>
									</center>
								</div>
								<?php if ($result_user['user_show_url'] == 1) { ?>
									<hr class="qak-user-contact-divider-top">
									<div class="qak-user-contact-container-top">
										<?php if (sizeof(json_decode($result_user['contacts'], true)) > 0) { ?>
											<button class="border user-contacts" onclick="goContacts()"><?php echo $string['action_go_to_contacts']; ?></button>
										<?php } else { ?>
											<h2 class="qak-user-contact-no-top"><?php echo $string['message_this_no_contacts']; ?></h2>
										<?php } ?>
									</div>
									<script type="text/javascript">
										function goContacts() {
											$.ajax({type: "GET", url:  '/assets/alert/view-contacts-user.php', data: "id=<?php echo $id; ?>", success: function(result) {
													$('body').append(result);
												}
											});
										}
									</script>
								<?php } ?>
							</div>
						</div>

						<?php if ($result_user['you'] == 0) { ?>
							<script type="text/javascript">
								function reportUser(argument) {
									showProgressBar();
									$.ajax({
										type: "GET", 
										url:  '/assets/alert/view-report-user.php', 
										data: {id: argument}, 
										success: function(result) {
											hideProgressBar();
											$('body').append(result);
										}
									});
								}
							</script>
						<?php } ?>

						<?php if ($result_user['user_private_message'] == 1) { ?>
							<script type="text/javascript">
								function goMessage(argument) {
									showProgressBar();
									$.ajax({
										type: "POST", 
										url: "<?php echo $default_api; ?>/dialog/create-private-dialog.php", 
										data: {token: '<?php echo $_COOKIE['USID'] ?>', id: argument}, 
								    	success: function(result){
											// console.log(result);
											hideProgressBar();
											var jsonOBJ = JSON.parse(result);
											if (jsonOBJ['type'] == 'success') {
												window.location = '/dialog.php?id=' + jsonOBJ['dialog_id'];
												// alert(jsonOBJ['dialog_id']);
											} if (jsonOBJ['type'] == 'error') {
												toast(jsonOBJ['message']);
											}
										}
									});
								}
							</script>
						<?php } ?>



						<script type="text/javascript">
							function openFollowersAlert() {
								showProgressBar();
								$.ajax({type: "GET", url:  '/assets/alert/view-followers.php', data: "id=<?php echo $id; ?>", success: function(result) {
										hideProgressBar();
										$('body').append(result);
									}
								});
							}

							function openFollowedAlert() {
								showProgressBar();
								$.ajax({type: "GET", url:  '/assets/alert/view-followed.php', data: "id=<?php echo $id; ?>", success: function(result) {
										hideProgressBar();
										$('body').append(result);
									}
								});
							}
						</script>




						<!--  -->

						<div class="qak-container-data-top-data-content">
							<?php if (intval($result_user['you']) == 1) { ?>
								<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/design/new-post.php'; ?>

								<script type="text/javascript">
									function updStatus() {
										event.stopPropagation();
										event.preventDefault();
										showProgressBar();
										$.ajax({type: "GET", url: "/assets/alert/upd-status.php", data: {req: 'ok'}, success: function(result) {
												hideProgressBar();
												$("body").append(result);
											}
										});
									}
								</script>
							<?php } ?>

							<div id="qak-user-post-container-data">
								<h2 class="qak-user-message-wait"><?php echo $string['message_please_wait']; ?></h2>
							</div>
						</div>

						<script type="text/javascript">
							loadUserPosts();

							function loadUserPosts() {
								showProgressBar();
								$.ajax({type: "GET", url: "/assets/content/user-page-posts.php", data: {id: '<?php echo $id; ?>'}, success: function(result) {
									hideProgressBar();
										$("#qak-user-post-container-data").empty();
										$("#qak-user-post-container-data").append(result);
									}
								});
							}
						</script>

					</div>
				<?php } else { ?>
					<div class="qak-container-error">
						<h2 class="qak-user-title"><?php echo $string['title_account_private']; ?></h2>
						<h2 class="qak-user-message"><?php echo $string['message_account_private']; ?></h2>
						<button class="<?php echo $result_class_follow; ?>" id="action-follow-user-2" onclick="followUser('<?php echo $result_user['login']; ?>', this.id, '<?php echo $_COOKIE['USID']; ?>')" style="margin-top: 10px;"><?php echo $result_text_follow; ?></button>
					</div>
				<?php } ?>
			<?php } else { ?>
				<div class="qak-container-error">
					<h2 class="qak-user-title"><?php echo $string['title_account_banned']; ?></h2>
					<h2 class="qak-user-message"><?php echo str_replace("%1s", "%1s", $string['message_account_banned']); ?></h2>
				</div>
			<?php } ?>
		<?php } else { ?>
			<div class="qak-container-error">
				<h2 class="qak-user-title"><?php echo $string['title_account_unknown']; ?></h2>
				<h2 class="qak-user-message"><?php echo $string['message_account_unknown']; ?></h2>
			</div>
		<?php } ?>
	</center>

	<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/design/bar.php'; ?>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/design/holder.php'; ?>

</body>
</html>