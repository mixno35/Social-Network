<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/only-load.php';

	$url_user = $default_api.'/user/data.php?token='.$_COOKIE['USID'];
	$result_user = json_decode(file_get_contents($url_user, false), true);

	$result_status = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/assets/json/status-list.json', false), true);
?>
<div class="qak-alert-container-v2" id="qak-alert-container">
	<div class="qak-alert-close-v2" onclick="document.getElementById('qak-alert-container').remove()"></div>
	
	<center class="qak-alert-container-holder-v2">
		<h2><?php echo $string['title_select_status']; ?></h2>
		<?php if (sizeof($result_status) > 0) { ?>
			<div class="list-status">
				<?php foreach($result_status as $key => $value) { ?>
					<?php
						$name = $value['name'];
						$desc = $value['description'];
					?>
					<div style="display: inline-block;">
						<div class="item <?php if($result_user['ustatus']==$key){echo 'active';} ?>" id="item-status-<?php echo $key; ?>" onclick="selectStatus(<?php echo $key; ?>, '<?php echo $value['key']; ?>')" status-name="<?php echo $string["$name"]; ?>" status-description="<?php echo $string["$desc"]; ?>">
							<img src="<?php echo '/assets/icons/status/'.$value['key'].'.png'; ?>">
						</div>
					</div>
				<?php } ?>
			</div>
		<?php } else { ?>
			<h4><?php echo $string['message_error_load_list_status']; ?></h4>
		<?php } ?>
	</center>

	<script type="text/javascript">
		function selectStatus(argument, argument2) {
			var testElements = document.getElementsByClassName('item');
			Array.prototype.filter.call(testElements, function(testElement){
			    document.getElementById(testElement.id).classList.remove('active');
			});

			document.getElementById('item-status-'+argument).classList.add('active');

			$.ajax({
				type: "POST", 
				url: "<?php echo $default_api; ?>/user/edit/status.php", 
				data: {token: '<?php echo $_COOKIE['USID'] ?>', status: argument}, 
		    	success: function(result){
					// console.log(result);
					var jsonOBJ = JSON.parse(result);
					toast(jsonOBJ['message']);
					if (jsonOBJ['type'] == 'error') {
						alert(jsonOBJ['message']);
					} if (jsonOBJ['type'] == 'success') {
						toast(jsonOBJ['message']);

						document.getElementById('qak-user-status-image').src = '/assets/icons/status/' + argument2 + '.png';
						document.getElementById('qak-user-status').setAttribute('title', document.getElementById('item-status-' + argument).getAttribute('status-description'));
					}
				}, 
				error: function(result){
					// console.log(result);
				}
			});
		}
	</script>
</div>