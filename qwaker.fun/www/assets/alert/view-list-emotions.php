<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/only-load.php';
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

	$id = $_GET['id'];
?>
<div class="qak-alert-container" id="qak-alert-container">
	<div class="qak-alert-container-holder">
		<h2 class="qak-alert-container-holder-title"><?php echo $string['title_post_emotions']; ?></h2>
		<div class="qak-alert-close" onclick="document.getElementById('qak-alert-container').remove()"></div>
		<div id="qak-alert-list-archive">
			<h2 class="qak-alert-message"><?php echo $string['message_please_wait']; ?></h2>
		</div>

		<script type="text/javascript">

			loadEmotions();

			function loadEmotions(argument) {
				$.ajax({type: "GET", url: "/assets/content/list-post-emotions.php", data: {id: '<?php echo $id; ?>', type: argument}, success: function(result) {
						$("#qak-alert-list-archive").empty();
						$("#qak-alert-list-archive").append(result);
					}
				});
			}
		</script>
	</div>
</div>