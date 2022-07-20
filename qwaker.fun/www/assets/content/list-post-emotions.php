<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/only-load.php';
?>
<?php
	function httpPost($url, $data) {
	    $curl = curl_init($url);
	    curl_setopt($curl, CURLOPT_POST, true);
	    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    $response = curl_exec($curl);
	    curl_close($curl);
	    return $response;
	}

	$result_array = json_decode(httpPost($default_api.'/post/emotion/list.php', array("id" => $_GET['id'], "token" => $_COOKIE['USID'], "type" => $_GET['type'])), true);
?>
<?php $num_array = intval(sizeof($result_array)); ?>
<?php if (sizeof($result_array) == 0) { ?>
	<h2 class="qak-alert-message"><?php echo $string['message_no_list_emotions']; ?></h2>
<?php } else { ?>
	<div class="qak-alert-list-emotions scroll-new">
		<?php foreach($result_array as $key => $value) { ?>
			<div title="@<?php echo $value['user']['nickname']; ?>" onclick="showUserPopup('<?php echo $value['user']['id']; ?>',this.id)">
				<img src="<?php echo $value['user']['avatar']; ?>" onerror="this.src = '/assets/images/qak-avatar-v3.png'">
				<span>
					<img src="<?php echo '/assets/icons/emotions/'.$value['type'].'.png'; ?>">
				</span>
			</div>
		<?php } ?>
	</div>
<?php } ?>