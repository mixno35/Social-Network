<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/only-load.php';
?>
<?php
	$id = $_GET['id'];

	$url_dt = $default_api.'/auth/session/list.php?token='.$_COOKIE['USID'];
	$result_session = json_decode(file_get_contents($url_dt, false), true);

	function getDeviceSession($value='') {
		if (preg_match("/(android|webos|avantgo|iphone|ipad|ipod|blackberry|iemobile|bolt|boost|cricket|docomo|fone|hiptop|mini|opera mini|kitkat|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $value)) {
			if (preg_match("/(iphone|ipad|ipod|ios)/i", $value)) {
				return "iOS";
			}
			if (preg_match("/(android|tablet)/i", $value)) {
				return "Android";
			}
			return "Mobile";
		}
		return "PC";
	}
?>

<div class="qak-alert-container" id="qak-alert-container">
	<div class="qak-alert-container-holder">
		<h2 class="qak-alert-container-holder-title"><?php echo $string['title_sessions_alert']; ?></h2>
		<div class="qak-alert-close" onclick="document.getElementById('qak-alert-container').remove()"></div>
		<?php $num_sessions = intval(sizeof($result_session)); ?>
		<?php if (sizeof($result_session) == 0) { ?>
			<h2 class="qak-alert-message"><?php echo $string['message_no_sessions']; ?></h2>
		<?php } else { ?>
			<div class="qak-alert-list-follows">
				<div class="qak-alert-list-items-names-titles">
					<h4 style="width: 20px;" title="<?php echo $string['title_sessions_id']; ?>"><?php echo $string['title_sessions_id']; ?></h4>
					<h4 style="width: 60px;" title="<?php echo $string['title_sessions_active']; ?>"><?php echo $string['title_sessions_active']; ?></h4>
					<h4 style="width: 80px;" title="<?php echo $string['title_sessions_created']; ?>"><?php echo $string['title_sessions_created']; ?></h4>
					<h4 style="width: 80px;" title="<?php echo $string['title_sessions_updated']; ?>"><?php echo $string['title_sessions_updated']; ?></h4>
					<h4 style="width: 80px;" title="<?php echo $string['title_sessions_timemax']; ?>"><?php echo $string['title_sessions_timemax']; ?></h4>
					<h4 style="width: 30px;" title="<?php echo $string['title_sessions_device']; ?>"><?php echo $string['title_sessions_device']; ?></h4>
				</div>
				<div style="max-height: 400px; overflow-y: auto;" class="scroll-new">
					<?php foreach($result_session as $key => $value) { ?>
						<?php $num_sessions = $num_sessions - 1; ?>
						<div class="qak-alert-item-session" id="item-session-<?php echo $value['id']; ?>">
							<!-- <div class="c1">
								<div class="ua pc"></div>
							</div> -->
							<div class="c2">
								<!-- <div class="top-s">
									
								</div> -->
								<h3 style="width: 20px;"><?php echo $value['id']; ?></h3>
								<h3 style="width: 60px;">
									<?php if (intval($value['active']) == 1) { ?>
										<?php echo $string['text_session_active']; ?>
									<?php } ?>
								</h3>
								<h3 style="width: 80px;"><?php echo convertTimeRus(date('d.m.Y H:i:s', $value['time'])); ?></h3>
								<h3 style="width: 80px;"><?php echo convertTimeRus(date('d.m.Y H:i:s', $value['lasttime'])); ?></h3>
								<h3 style="width: 80px;"><?php echo convertTimeRus(date('d.m.Y H:i:s', $value['maxtime'])); ?></h3>
								<h3 style="width: 30px;"><?php echo getDeviceSession($value['uagent']); ?></h3>
							</div>
							<div class="bottom-s">
								<h5 onclick="closeSession(<?php echo $value['id']; ?>, <?php echo $value['active']; ?>)" title="<?php echo $string['tooltip_session_close']; ?>"><?php echo $string['action_sessions_close']; ?></h5>
							</div>
						</div>

						<?php if ($num_sessions > 0) { ?>
							<hr>
						<?php } ?>
					<?php } ?>
				</div>
			</div>
			<script type="text/javascript">
				var strARESESSIONCLOSE = stringOBJ['message_session_are'];

				function closeSession(argument, argument2) {
					if (argument2 == 1) {
						strARESESSIONCLOSE = stringOBJ['message_session_active_are'];
					} else {
						strARESESSIONCLOSE = stringOBJ['message_session_are'];
					}
					if (confirm(strARESESSIONCLOSE)) {
						$.ajax({
							type: "POST", 
							url: "<?php echo $default_api; ?>/auth/session/close.php", 
							data: {
								token: '<?php echo $_COOKIE['USID']; ?>', 
								id: argument
							}, 
							success: function(result) {
								// console.log(result);
								if (result == 'success') {
									try {
										document.getElementById('item-session-'+argument).remove();
									} catch (exx) {} 
									toast(stringOBJ['message_session_closed'].replace("%1s", argument));
									if (argument2 == 1) {
										window.location.reload();
									}
								} if (result == 'error') {
									toast(stringOBJ['message_session_error_closed'].replace("%1s", argument));
								}
							}
						});
					}
				}
			</script>
		<?php } ?>
	</div>
</div>