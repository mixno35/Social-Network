<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/only-load.php';
?>
<?php 
	$title_page = $title_dialog_text;

	$id = trim($_GET['id']);

	$choose_dialog_html = '<h2 class="message v2">'.$string['text_choose_dialog'].'</h2>';
	$please_wait_html = '<h2 class="message v2">'.$string['message_please_wait'].'</h2>';

	$interval_m = intval($_COOKIE['interval-m']);

	if ($interval_m < 1000) {
		$interval_m = 10000;
	}
?>
<!DOCTYPE html>
<html lang="<?php echo $langTAG; ?>" class="<?php echo $default_theme; ?>">
<head>
	<title><?php echo $string['title_dialog']; ?></title>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/style.php'; ?>
	<link rel="stylesheet" type="text/css" href="<?php echo $default_theme_site; ?>p.css?v=<?php echo time(); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo $default_theme_site; ?>user.css?v=<?php echo time(); ?>">
	<link rel="shortcut icon" href="/assets/images/qak-favicon.png" type="image/png">
	<link rel="stylesheet" type="text/css" href="<?php echo $default_theme_site; ?>dialog.css?v=<?php echo time(); ?>">
	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/script.php'; ?>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/meta.php'; ?>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/js/u.php'; ?>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/js/p.php'; ?>
</head>
<body>

	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/auth_check.php'; ?>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/placeholder.php'; ?>

	<div class="qak-dialog-screen-progress" id="qak-dialog-screen-progress" style="display: none;">
		<div id="qak-progress-div" class="qak-progress-div" style="margin: 0;margin-top: -19px;width: 128px;"><div style="margin: 0;" id="qak-progress-bar" class="qak-progress-bar"></div></div>
	</div>

	<?php if (intval($_GET['view-post']) != '') { ?>
		<script type="text/javascript" id="goRUNALERT">
			goAlertPost(<?php echo intval($_GET['view-post']); ?>, <?php echo intval($_GET['comment']); ?>);
			document.getElementById('goRUNALERT').remove();
		</script>
	<?php } ?>

	<?php if ($_COOKIE['USID'] !== '') { ?>

		<center style="margin-top: 20px;">
			<div class="qak-dialog-container-home">
				<div class="container-data-1">
					<div class="container-data-1-top">
						<h1 class="title"><?php echo $string['title_dialog_small']; ?></h1>
					</div>
					<div id="container-data-1-content" class="scroll-new">
						<h2 class="message"><?php echo $string['message_please_wait']; ?></h2>
					</div>
				</div>
				<div class="container-data-2">
					<div class="container-data-2-top" id="dialog-top-bar" style="display: none;">
						<h1 id="dialog-top-bar-title"></h1>
						<img src="" id="dialog-top-bar-image" draggable="false" onerror="this.src = '/assets/images/qak-avatar-v3.png'">
						<button class="dialog-dialog-menu-button border" onclick="popupWindow('qak-popup-dialog-menu')">
							<?php echo '···'; ?>
							<ol class="popup arrow dialog-menu" id="qak-popup-dialog-menu" style="display: none;">
								<li onclick="window.location = '/user.php?id='+loginUSER"><?php echo $string['action_dialog_go_to_profile']; ?></li>
								<li onclick="statusDialog(0)"><?php echo $string['action_dialog_status_0']; ?></li>
								<hr>
								<li onclick="clearDialog()"><?php echo $string['action_dialog_clear']; ?></li>
								<li onclick="deleteDialog()"><?php echo $string['action_dialog_delete']; ?></li>
								<li onclick="openDialog('')"><?php echo $string['action_dialog_close']; ?></li>
							</ol>
						</button>
					</div>
					<div id="container-data-2-content" class="scroll-new">
						<?php echo $choose_dialog_html; ?>
					</div>
					<div class="container-data-2-bottom" id="dialog-bottom-bar" style="display: none;">
						<h6 class="reply-container" id="reply-container" style="display: none;" tooltip="<?php echo $action_message_reply_cancel; ?>" onclick="cancelReplyMessage()"></h6>
						<div class="default-container">
							<div class="qak-dialog-cut" title="<?php echo $string['tooltip_click_to_select_image_cut']; ?>" onclick="document.getElementById('pic').click();event.stopPropagation();event.preventDefault()">
								<img src="/assets/icons/ic-cut-image.png?v=2">
							</div>
							<div class="qak-dialog-cut" id="qak-dialog-cut" title="<?php echo $string['tooltip_click_to_select_image_gif']; ?>" onclick="goSelectGif()">
								<img src="/assets/icons/ic-gif-image.png">
							</div>
							<input type="file" name="pic[]" id="pic" multiple="1" onchange="sendMessageImage(this)" accept=".jpg, .jpeg, .png" style="display: none;">
							<input id="container-data-2-input" type="message" placeholder="<?php echo $string['hint_input_enter_message']; ?>" oninput="inputMessageValueData(this.value)" onchange="inputMessageValueData(this.value)">
							<button class="send-message cancel" id="send-message-cancel" style="display: none;" onclick="editMessageCancel()"><?php echo $string['action_message_edit_cencel']; ?></button>
							<button class="send-message" id="send-message" onclick="sendMessage()"><?php echo $string['action_send_message']; ?></button>
							<button class="send-message record" id="send-message-record" title="<?php echo $string_message_dialog_m_record; ?>" onclick="goRecordVoice()"><?php echo $string['action_dialog_message_record']; ?></button>
						</div>
					</div>
				</div>
			</div>
		</center>

		<script type="text/javascript">
			var dialogID = '';
			var replyMESSAGE = '';
			var loginUSER = '';
			var jsonMESSAGES = '';

			let timeRepeat = null;

			inputMessageValueData('');

			function inputMessageValueData(argument) {
				document.getElementById('container-data-2-input').value = argument;
				if (argument.length > 0) {
					document.getElementById('send-message').style.display = 'block';
					document.getElementById('send-message-record').style.display = 'none';
				} else {
					document.getElementById('send-message').style.display = 'none';
					document.getElementById('send-message-record').style.display = 'block';
				}
			}

			function cancelReplyMessage() {
				replyMESSAGE = '';
				document.getElementById('reply-container').style.display = 'none';
				document.getElementById('reply-container').textContent = '';
			}

			function openDialog(argument, argument2, argument3) {
				try {
					clearInterval(timeRepeat);
				} catch (exx) {}
				if (argument == '') {
					removeParam('id');
					document.getElementById('dialog-top-bar').style.display = 'none';
					document.getElementById('dialog-bottom-bar').style.display = 'none';
					loadMessages('');
					loadDialogs();
				} else {
					if (dialogID != argument) {
						$("#container-data-2-content").empty();
						$("#container-data-2-content").append('<?php echo $please_wait_html; ?>');

						updParam('id', argument);
						cancelReplyMessage();
						loadDialogs();
						// loadMessages(argument);
						try {
							timeRepeat = setInterval(() => loadMessages(argument), <?php echo $interval_m; ?>);
						} catch (exx) {}
						document.getElementById('dialog-top-bar').style.display = 'flex';
						document.getElementById('dialog-bottom-bar').style.display = 'block';
						document.getElementById('dialog-top-bar-image').src = argument3;
						document.getElementById('dialog-top-bar-title').textContent = '@'+argument2;
					}
				}

				dialogID = argument;
				loginUSER = argument2;
				jsonMESSAGES = '';
				document.cookie = "dialog-avatar=" + argument3 + "; path=/; domain=<?php echo $_SERVER['SERVER_NAME']; ?>; expires=Tue, <?php echo intval(date('d')); ?> <?php echo date('M'); ?> <?php echo intval(date('Y')+1); ?> 00:00:00 GMT";
				document.cookie = "dialog-name=" + argument2 + "; path=/; domain=<?php echo $_SERVER['SERVER_NAME']; ?>; expires=Tue, <?php echo intval(date('d')); ?> <?php echo date('M'); ?> <?php echo intval(date('Y')+1); ?> 00:00:00 GMT";
			}

			<?php if ($id == '') {} else { ?>
				openDialog('<?php echo $id; ?>', '<?php echo $_COOKIE['dialog-name'] ?>', '<?php echo $_COOKIE['dialog-avatar'] ?>');
			<?php } ?>

			function loadDialogs() {
				// document.getElementById('container-data-1-content').style.opacity = '.5';
				showProgressBar();
				$.ajax({type: "GET", url: "/assets/content/list-dialogs.php", data: {token: '<?php echo $_COOKIE['USID']; ?>'}, success: function(result) {
						hideProgressBar();
						$("#container-data-1-content").empty();
						$("#container-data-1-content").append(result);
						// document.getElementById('container-data-1-content').style.opacity = '1';
						if (dialogID != '') {
							try {
								document.getElementById('qak-dialog-item-'+dialogID).classList.add('open');
							} catch (exx) {}
						}
					}
				});
			}

			function goSelectGif() {
				event.stopPropagation();
				event.preventDefault();
				showProgressBar();
				$.ajax({type: "GET", url: "/assets/alert/view-gif-anim.php", data: {req: 'ok'}, success: function(result) {
						hideProgressBar();
						$("#dialog-bottom-bar").append(result);
					}
				});
			}

			function goRecordVoice() {
				showProgressBar();
				$.ajax({type: "GET", url: "/assets/alert/view-record-message.php", data: {req: 'ok'}, success: function(result) {
						hideProgressBar();
						$("body").append(result);
					}
				});
			}

			function loadMessages(argument) {
				if (argument == '') {
					$("#container-data-2-content").empty();
					$("#container-data-2-content").append('<?php echo $choose_dialog_html; ?>');
				} else {
					showProgressBar();
					$.ajax({type: "GET", url: "/assets/content/list-dialog-messages.php", data: {id: argument}, success: function(result) {
							hideProgressBar();
							if (jsonMESSAGES != result) {
								$("#container-data-2-content").empty();
								$("#container-data-2-content").append(result);

								jsonMESSAGES = result;
							}
						}
					});
				}
			}

			function sendGifMessage(argument, argument2) {
				if (message.value.trim() != '') {
					showProgressBar();
					$.ajax({
						type: "POST", 
						url: "<?php echo $default_api; ?>/dialog/send-message-gif-private.php", 
						data: {token: '<?php echo $_COOKIE['USID'] ?>', id: dialogID, static: argument, url: argument2}, 
				    	success: function(result){
				    		hideProgressBar();
							// console.log(result);
							var jsonOBJ = JSON.parse(result);
							if (jsonOBJ['type'] == 'success') {
								loadMessages(dialogID);
							} if (jsonOBJ['type'] == 'error') {
								toast(jsonOBJ['message']);
							}
						}
					});
				} else {
					toast(stringOBJ['message_enter_message']);
				}
			}

			function sendMessageImage(argument) {
				if (window.URL.createObjectURL(argument.files[0]) != null) {
					document.getElementById('qak-dialog-screen-progress').style.display = 'flex';
				}
				try {
					// showProgressBar();
					toast(stringOBJ['toast_dialog_image_selected']+' <img onclick="viewPhoto(this.src)" src="'+window.URL.createObjectURL(argument.files[0])+'">');
					var formdata = new FormData();
					formdata.append('token', '<?php echo $_COOKIE['USID']; ?>');
					formdata.append('id', dialogID);
					formdata.append('image1[]', argument.files[0]);

					$.ajax({
						xhr: function() {
			                var xhr = new window.XMLHttpRequest();
			                xhr.upload.addEventListener("progress", function(evt) {
			                    if (evt.lengthComputable) {
			                        var percentComplete = ((evt.loaded / evt.total) * 100);
			                        $("#qak-progress-bar").animate({
								    	width: percentComplete + '%'
								    }, {
								    	duration: 500
								    });
			                    }
			                }, false);
			                return xhr;
			            },
						type: "POST", 
						url: "<?php echo $default_api; ?>/dialog/send-message-image-private.php", 
						data: formdata, 
				    	contentType: false,
				    	processData: false,
				    	success: function(result){
				    		// hideProgressBar();
				    		// console.log(result);
							var jsonOBJ = JSON.parse(result);
							if (jsonOBJ['type'] == 'success') {
								loadMessages(dialogID);
								toast(stringOBJ['toast_dialog_image_uploaded']);
								try {
									argument.files[0] = null;
								} catch (exx) {}
							} if (jsonOBJ['type'] == 'error') {
								toast(jsonOBJ['message']);
							}
							$("#qak-progress-bar").animate({
						    	width: 0 + '%'
						    }, {
						    	duration: 500
						    });
						    document.getElementById('qak-dialog-screen-progress').style.display = 'none';
						}, 
						error: function(result){
							console.log(result);
							document.getElementById('qak-dialog-screen-progress').style.display = 'none';
						}
					});
				} catch (exx) {
					toast(stringOBJ['toast_dialog_image_unselected']);
				}
			}

			function sendMessage() {
				var message = document.getElementById('container-data-2-input');
				if (message.value.trim() != '') {
					showProgressBar();
					$.ajax({
						type: "POST", 
						url: "<?php echo $default_api; ?>/dialog/send-message-text-private-dialog.php", 
						data: {token: '<?php echo $_COOKIE['USID'] ?>', id: dialogID, message: message.value, reply: replyMESSAGE}, 
				    	success: function(result){
							// console.log(result);
							hideProgressBar();
							var jsonOBJ = JSON.parse(result);
							if (jsonOBJ['type'] == 'success') {
								inputMessageValueData('');
								replyID = 0;
								loadMessages(dialogID);
							} if (jsonOBJ['type'] == 'error') {
								toast(jsonOBJ['message']);
							}
						}
					});
				} else {
					toast(stringOBJ['message_enter_message']);
					inputMessageValueData('');
				}
			}

			function editMessageGo(id) {
				var message = document.getElementById('container-data-2-input');
				if (message.value.trim() != '') {
					showProgressBar();
					$.ajax({
						type: "POST", 
						url: "<?php echo $default_api; ?>/dialog/edit-message-private-dialog.php", 
						data: {token: '<?php echo $_COOKIE['USID'] ?>', id: id, message: message.value}, 
				    	success: function(result){
							// console.log(result);
							hideProgressBar();
							var jsonOBJ = JSON.parse(result);
							if (jsonOBJ['type'] == 'success') {
								editMessageCancel();
							}
							toast(jsonOBJ['message']);
						}
					});
				} else {
					toast(stringOBJ['message_enter_message']);
					inputMessageValueData('');
				}
			}

			loadDialogs();
		</script>
		<script type="text/javascript">
			function openMenuMessage(argument, argument2, argument3, argument4, argument5) {
				if (document.querySelector('#qak-dialog-message-item-popup') == null) {
					var elementMenu = document.getElementById(argument);

					var pxPlus = 100;

					var scrollTop = document.documentElement.scrollTop?document.documentElement.scrollTop:document.body.scrollTop;
					var scrollLeft = document.documentElement.scrollLeft?document.documentElement.scrollLeft:document.body.scrollLeft;

					// elementMenu.style.visibility = 'hidden';
					elementMenu.style.zIndex = '9999';

					var bottomPositionMenu = $("#" + argument).offset().top + scrollTop - pxPlus + 'px';
					var leftPositionMenu = $("#" + argument).offset().left + scrollLeft - pxPlus + 'px';

					$("body").append('<div id="qak-dialog-message-item-popup" onclick="closeMenuMessage(\'' + argument+'\')">' + '</div>');
					$("#"+argument).append('<div id="message-item-popup-container"></div>');

					// $("#message-item-popup-container").append('<li onclick="replyMessage(\''+argument4+'\', \''+argument5+'\')">'+stringOBJ['action_message_reply']+'</li>');
					if (argument3 == 1) {
						if (!argument5.startsWith('Resend: @')) {
							$("#message-item-popup-container").append('<li onclick="resendMessage(\''+argument2+'\', \''+argument4+'\', \''+argument5+'\')">'+stringOBJ['action_message_resend']+'</li>');
						}
						$("#message-item-popup-container").append('<li onclick="editMessage(\''+argument2+'\', \''+argument5+'\')">'+stringOBJ['action_message_edit']+'</li>');
						$("#message-item-popup-container").append('<li onclick="deleteMessage(\''+argument2+'\')">'+stringOBJ['action_message_delete']+'</li>');
					}

					document.getElementById('message-item-popup-container').style.top = "-" + document.getElementById('message-item-popup-container').offsetHeight - 13 + "px";
					document.getElementById('message-item-popup-container').style.left = "-20px";

					// if ($('#container-data-2-content').hasScrollBar().vertical) {
					// 	document.getElementById('container-data-2-content').style.paddingRight = '5px';
					// }
					// document.getElementById('container-data-2-content').style.overflowY = 'unset';
				}
			}
			function closeMenuMessage(argument) {
				try {
					document.getElementById('qak-dialog-message-item-popup').remove();
				} catch (exx) {}
				try {
					document.getElementById('message-item-popup-container').remove();
				} catch (exx) {}
				try {
					document.getElementById(argument).style.zIndex = '10';
				} catch (exx) {}
			}
		</script>

		<script type="text/javascript">
			function deleteMessage(argument) {
				if (confirm(stringOBJ['message_delete_are'])) {
					showProgressBar();
					$.ajax({
						type: "POST", 
						url: "<?php echo $default_api; ?>/dialog/delete-message-private-dialog.php", 
						data: {token: '<?php echo $_COOKIE['USID'] ?>', id: dialogID, message_id: argument}, 
				    	success: function(result){
							// console.log(result);
							hideProgressBar();
							var jsonOBJ = JSON.parse(result);
							toast(jsonOBJ['message']);
							closeMenuMessage('qak-dialog-message-item-'+argument);
							if (jsonOBJ['type'] == 'success') {
								loadMessages(dialogID);
							} if (jsonOBJ['type'] == 'error') {}
						}
					});
				}
			}

			function resendMessage(argument, argument2, argument3) {
				inputMessageValueData('Resend: @' + argument2 + ' > ' + argument3);
				closeMenuMessage(argument);
			}

			function replyMessage(argument, argument2) {
				replyMESSAGE = 'Reply: @' + argument + ' ||| ' + argument2;
				document.getElementById('reply-container').style.display = 'block';
				document.getElementById('reply-container').textContent = replyMESSAGE;
			}

			function editMessage(argument, argument2) {
				// alert('ID:'+argument+'\nMESSAGE:'+argument2);
				document.getElementById('send-message').setAttribute('onclick', 'editMessageGo('+argument+')');
				inputMessageValueData(argument2);
				document.getElementById('send-message').textContent = stringOBJ['action_message_edit'];
				document.getElementById('send-message-cancel').style.display = 'block';
			}
			function editMessageCancel() {
				document.getElementById('send-message').setAttribute('onclick', 'sendMessage()');
				inputMessageValueData('');
				document.getElementById('send-message').textContent = stringOBJ['action_send_message'];
				document.getElementById('send-message-cancel').style.display = 'none';
			}

			function deleteDialog() {
				if (confirm(stringOBJ['message_delete_dialog_are'])) {
					showProgressBar();
					$.ajax({
						type: "POST", 
						url: "<?php echo $default_api; ?>/dialog/delete-private-dialog.php", 
						data: {token: '<?php echo $_COOKIE['USID'] ?>', id: dialogID}, 
				    	success: function(result){
							// console.log(result);
							hideProgressBar();
							var jsonOBJ = JSON.parse(result);
							toast(jsonOBJ['message']);
							if (jsonOBJ['type'] == 'success') {
								openDialog('');
							} if (jsonOBJ['type'] == 'error') {}
						}
					});
				}
			}

			function clearDialog() {
				if (confirm(stringOBJ['message_clear_dialog_are'])) {
					showProgressBar();
					$.ajax({
						type: "POST", 
						url: "<?php echo $default_api; ?>/dialog/clear-private-dialog.php", 
						data: {token: '<?php echo $_COOKIE['USID'] ?>', id: dialogID}, 
				    	success: function(result){
							// console.log(result);
							hideProgressBar();
							var jsonOBJ = JSON.parse(result);
							toast(jsonOBJ['message']);
							if (jsonOBJ['type'] == 'success') {
								loadMessages(dialogID);
							} if (jsonOBJ['type'] == 'error') {}
						}
					});
				}
			}

			function statusDialog(argument) {
				showProgressBar();
				$.ajax({
					type: "POST", 
					url: "<?php echo $default_api; ?>/dialog/status-private-dialog.php", 
					data: {token: '<?php echo $_COOKIE['USID'] ?>', id: dialogID, status: argument}, 
			    	success: function(result){
						// console.log(result);
						hideProgressBar();
						var jsonOBJ = JSON.parse(result);
						toast(jsonOBJ['message']);
						if (jsonOBJ['type'] == 'success') {
							openDialog('');
						} if (jsonOBJ['type'] == 'error') {}
					}
				});
			}
		</script>

	<?php } ?>

	<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/design/bar.php'; ?>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/design/holder.php'; ?>

</body>
</html>