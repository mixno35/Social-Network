<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/only-load.php';
?>
<?php
	$id = $_GET['id'];

	$url_user = $default_api.'/user/data.php?id='.$id.'&token='.$_COOKIE['USID'];
	$result_user = json_decode(file_get_contents($url_user, false), true);

	$contacts = json_decode($result_user['contacts'], true);
?>
<?php
	function getKeyContact($value='') {
		return $value;
	}
?>
<div class="qak-alert-container" id="qak-alert-container">
	<div class="qak-alert-container-holder">
		<h2 class="qak-alert-container-holder-title"><?php echo $string['title_contacts_and_links']; ?></h2>
		<div class="qak-alert-close" onclick="document.getElementById('qak-alert-container').remove()"></div>
		<?php if (sizeof($contacts) > 0) { ?>
			<?php $num_contacts = intval(sizeof($contacts)); ?>
			<div class="qak-alert-conatiner-contacts">
				<?php foreach($contacts as $key => $value) { ?>
					<?php $num_contacts = $num_contacts - 1; ?>
					<div class="item-container-contact">
						<h1><?php echo getKeyContact($key); ?></h1>
						<h2><?php echo $value; ?></h2>
					</div>
					<?php if ($num_contacts > 0) { ?>
						<hr class="qak-alert">
					<?php } ?>
				<?php } ?>
			</div>
			<h2 class="qak-alert-container-holder-title-bottom-message">
				<?php echo str_replace('%1s', sizeof($contacts), $string['message_user_set_contacts']); ?>
			</h2>
		<?php } else { ?>
			<h2 class="qak-alert-message"><?php echo $string['message_user_no_contacts']; ?></h2>
		<?php } ?>
	</div>
</div>