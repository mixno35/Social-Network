<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/only-load.php';
?>
<div id="modalContainer" onclick="closeGifAlert()">
	<div id="alertBox" onclick=" event.stopPropagation();">
		<h1><?php echo $string['title_gifs_alert']; ?></h1>
		<input type="search" id="qak-gif-search-dialog" style="margin: 15px;" placeholder="<?php echo $string['hint_gifs_search']; ?>">
		<div class="dialog-qak-gif-container">
			<div class="content" id="gifs-content">
				<h2 class="message"><?php echo $string['message_please_wait']; ?></h2>
			</div>
		</div>

		<script type="text/javascript">
			findGifDialog('', 5);
			
			function findGifDialog(argument, argument2) {
				document.getElementById('gifs-content').style.opacity = '.5';
				$.ajax({type: "GET", url: "/assets/content/page-gifs-anim.php", data: {s: argument, limit: argument2}, success: function(result) {
						$("#gifs-content").empty();
						$("#gifs-content").append(result);
						document.getElementById('gifs-content').style.opacity = '1';
					}
				});
			}

			document.getElementById("qak-gif-search-dialog").addEventListener("keyup", function(event) {
				if (event.keyCode === 13) {
					alert('Enter pressed!');
					return false;
				}
			});

			function sendGifMessage(argument, argument2) {
				if (argument.trim() != '' && argument2.trim() != '') {
					$.ajax({
						type: "POST", 
						url: "<?php echo $default_api; ?>/dialog/send-message-gif-private.php", 
						data: {token: '<?php echo $_COOKIE['USID'] ?>', id: dialogID, static: argument, url: argument2}, 
				    	success: function(result){
							// console.log(result);
							var jsonOBJ = JSON.parse(result);
							if (jsonOBJ['type'] == 'success') {
								loadMessages(dialogID);
								closeGifAlert();
							} if (jsonOBJ['type'] == 'error') {
								toast(jsonOBJ['message']);
							}
						}
					});
				} else {
					toast(stringOBJ['message_enter_message']);
				}
			}

			function playGifAnim(argument, argument2) {
				document.getElementById(argument).src = argument2;
			}

			function closeGifAlert() {
				document.getElementById('modalContainer').remove();
			}
		</script>
	</div>
</div>