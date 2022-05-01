<div class="qak-page-full-screnn" id="qak-page-full-screen-notify">
	<?php
		include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
		include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
		include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
		include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
		include $_SERVER['DOCUMENT_ROOT'].'/vendor/only-load.php';
	?>
	<?php 
		$title_page = $string['title_notifications'];

		$usid = $_COOKIE['USID'];
	?>

	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/auth_check.php'; ?>

	<h1 class="qak-title-page" onclick="document.getElementById('qak-page-full-screen-notify').remove()"><?php echo $string['action_back']; ?></h1>

	<div class="container-notify" id="qak-popup-container-notify">
		<h2 class="message_popup"><?php echo $string['message_please_wait']; ?></h2>
	</div>

	<script type="text/javascript">
        function readNotofy(argument) {
            $.ajax({type: "POST", url: "<?php echo $default_api; ?>/user/notification/read.php?id="+argument+"&token=<?php echo $usid; ?>", data: {id: argument, token: '<?php echo $usid; ?>'}, success: function(result) {
                    var jsonOBJ = JSON.parse(result);
                    // console.log(result);
                }
            });
        }

        readNotofy(0);
        loadListNotofications('all', 50);

        try {
        	document.getElementById('qak-bar-top-notification-indicator').remove();
        } catch (exx) {}
        try {
        	document.getElementById('bar-n-c').setAttribute('data-tooltip', stringOBJ['tooltip_bar_notifications'].replace("%1s", 0));
        } catch (exx) {}

        function loadListNotofications(argument, argument2) {
        	$.ajax({type: "GET", url: "/assets/content/list-notifications.php", data: {type: argument, limit: argument2}, success: function(result) {
					$("#qak-popup-container-notify").empty();
					$("#qak-popup-container-notify").append(result);
				}
			});
        }
    </script>
</div>