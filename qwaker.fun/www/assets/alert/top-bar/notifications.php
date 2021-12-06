<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/only-load.php';
?>
<?php
	$usid = $_COOKIE['USID'];
?>
<ol class="popup arrow bar-top-alert notify" id="bar-top-alert" onclick="event.stopPropagation()">
	<h3><?php echo $string['title_notifications']; ?></h3>
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
</ol>