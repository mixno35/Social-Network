<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
?>
<?php
	$usid = $_COOKIE['USID'];

	$url_user_bar = $default_api.'/user/data.php?id='.$usid.'&token='.$usid;
	$result_user_bar = json_decode(file_get_contents($url_user_bar, false), true);
?>
<?php
	function getNumNotify($value='') {
		if ($value > 99) {
			return intval(99).'+';
		} else {
			return intval($value);
		}
	}
?>
<header class="qak-bar" id="qak-bar">
	<div class="bar-logo-container" onclick="window.location = '/'">
		<h5 class="title-bar">QWAKER<small>.fun</small><h5 class="title-bar-other"><?php echo $title_page; ?></h5></h5>
	</div>
	<!-- <h6 class="find-user-bar" id="find-user-bar" onclick="openBarTopAlert('find-users', '#find-user-bar')"><?php echo $string_hint_find_users; ?></h6> -->
	<div style="width: -webkit-fill-available;"></div>
	<?php if ($_COOKIE['USID'] != '') { ?>
		<div class="qak-bar-menu-content">
			<div class="qak-bar-menu-content-item" onclick="window.location = '/dialog.php'" data-tooltip="<?php echo str_replace('%1s', $result_user_bar['user_dialog_no_read'], $string['tooltip_bar_messages']); ?>">
				<!-- <img src="/assets/icons/icons8-secured-letter-30.png" class="qak-bar-menu-content-item"> -->
				<h1 class="qak-bar-menu-content-name"><?php echo $string['action_bar_message']; ?></h1>
				<?php if ($result_user_bar['user_dialog_no_read'] > 0) {  ?>
					<h2 class="qak-bar-menu-content-item v2"><?php echo getNumNotify($result_user_bar['user_dialog_no_read']); ?></h2>
				<?php } ?>
			</div>
			<div class="qak-bar-menu-content-item" id="bar-r-c" onclick="openBarTopAlert('followed_wait_toyou', '#bar-r-c')" data-tooltip="<?php echo str_replace('%1s', $result_user_bar['user_followed_toyou_wait'], $string['tooltip_bar_requests']); ?>">
				<!-- <img src="/assets/icons/icons8-followed_wait_toyou-30.png" class="qak-bar-menu-content-item"> -->
				<h1 class="qak-bar-menu-content-name"><?php echo $string['action_bar_request']; ?></h1>
				<?php if ($result_user_bar['user_followed_toyou_wait'] > 0) { ?>
					<h2 class="qak-bar-menu-content-item v2" id="qak-bar-top-follow-you-indicator"><?php echo getNumNotify($result_user_bar['user_followed_toyou_wait']); ?></h2>
				<?php } ?>
			</div>
			<div class="qak-bar-menu-content-item" id="bar-n-c" onclick="openBarTopAlert('notifications', '#bar-n-c')" data-tooltip="<?php echo str_replace('%1s', $result_user_bar['user_notifications_r'], $string['tooltip_bar_notifications']); ?>">
				<!-- <img src="/assets/icons/icons8-notifications-30.png" class="qak-bar-menu-content-item"> -->
				<h1 class="qak-bar-menu-content-name"><?php echo $string['action_bar_notofication']; ?></h1>
				<?php if ($result_user_bar['user_notifications_r'] > 0) { ?>
					<h2 class="qak-bar-menu-content-item v2" id="qak-bar-top-notification-indicator"><?php echo getNumNotify($result_user_bar['user_notifications_r']); ?></h2>
				<?php } ?>
			</div>
			<!-- <div class="qak-bar-menu-content-item" onclick="window.location = '/post/new'" data-tooltip="<?php echo $tooltip_new_post; ?>">
				<img src="/assets/icons/icons8-plus-30.png" class="qak-bar-menu-content-item">
				<h2 class="qak-bar-menu-content-item">0</h2>
			</div> -->
		</div>

		<div class="qak-bar-find-action" id="find-all-bar" onclick="openBarTopAlert('find-all', '#find-all-bar')"></div>

		<div class="qak-bar-avatar-user" onclick="closePopups();popupWindow('bar-top-popup')">
			<img src="<?php echo $result_user_bar['avatar']; ?>" class="qak-bar-avatar-user" id="qak-bar-avatar-user" draggable="false" onerror="this.src = '/assets/images/qak-avatar-v3.png'">
			<!-- <div class="qak-bar-avatar-user-arrow"></div> -->
		</div>

		<ol class="popup arrow bar-top-popup" id="bar-top-popup" style="display: none;">
			<li onclick="window.location = '/user.php?id=<?php echo $result_user_bar['login']; ?>'"><?php echo $string['action_my_account']; ?></li>
			<li onclick="openArchivePost()"><?php echo $string['action_list_archive']; ?></li>
			<li onclick="blackList()"><?php echo $string['action_black_list']; ?></li>
			<li onclick="deffredList()"><?php echo $string['action_deffred_posts']; ?></li>
			<hr>
			<li onclick="window.location = '/edit.php'"><?php echo $string['action_edit']; ?></li>
			<li onclick="openAlertBar('view-settings')"><?php echo $string['action_settings']; ?></li>
			<li onclick="exitAccount()"><?php echo $string['action_sign_out']; ?></li>
			<?php if (intval($result_user_bar['urang']) >= 2) { ?>
				<hr>
				<li onclick="window.location = 'http://admin.qwaker.com'"><?php echo $string['action_admin_panel']; ?></li>
			<?php } ?>
		</ol>
	<?php } else { ?>
		<a href="/auth.php?t=in"><button class="border qak-user-auth-button-border-null"><?php echo $string['action_sign_in']; ?></button></a>
		<a href="/auth.php"><button class="border qak-user-auth-button-border-null"><?php echo $string['action_sign_up']; ?></button></a>
	<?php } ?>

	<script type="text/javascript" id="script-bar-padding">
		document.body.style.paddingTop = 'var(--default-bar-size)';
		document.getElementById('script-bar-padding').remove();
	</script>
	<script type="text/javascript">
		function openBarTopAlert(argument, argument2) {
			$.ajax({type: "GET", url:  '/assets/alert/top-bar/'+argument+'.php', data: "req=ok", success: function(result) {
					$(argument2).append(result);
				}
			});
		}

		function openAlertBar(argument) {
			$.ajax({type: "GET", url:  '/assets/alert/'+argument+'.php', data: "req=ok", success: function(result) {
					$('body').append(result);
				}
			});
		}

		function openArchivePost() {
			$.ajax({type: "GET", url:  '/assets/alert/view-archive.php', data: "req=ok", success: function(result) {
					$('body').append(result);
				}
			});
		}

		function exitAccount() {
			document.cookie = "USID=" + '' + "; path=/; domain=<?php echo $_SERVER['SERVER_NAME']; ?>; expires=Tue, <?php echo intval(date('d')); ?> <?php echo date('M'); ?> <?php echo intval(date('Y')+1); ?> 00:00:00 GMT";
			window.location.reload();
		}

		function blackList() {
			$.ajax({type: "GET", url:  '/assets/alert/view-black-list.php', data: "req=ok", success: function(result) {
					$('body').append(result);
				}
			});
		}

		function deffredList() {
			$.ajax({type: "GET", url:  '/assets/alert/view-deffred-list.php', data: "req=ok", success: function(result) {
					$('body').append(result);
				}
			});
		}
	</script>
</header>