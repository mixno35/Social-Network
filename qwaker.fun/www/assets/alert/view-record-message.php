<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/only-load.php';
?>
<ol class="view-user" id="view-user">
	<center>
		<div onclick="event.stopPropagation()">
			<div class="close" onclick="closePopups()"></div>
			<img src="/assets/images/voice-record.png?v=2" class="image-voice-record">
			<h5 class="voice-record"><?php echo $string['text_voicing']; ?></h5>
		</div>
	</center>
</ol>