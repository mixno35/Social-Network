<?php
	$url_rec = $default_api.'/user/recomendation/list.php?token='.$_COOKIE['USID'];
	$result_rec = json_decode(file_get_contents($url_rec, false), true);
?>
<div class="container-select-rec-list" id="cont-rec-id-select">
	<h2><?php echo $string['title_select_rec']; ?></h2>
	<ul id="srl-container-list">
		<li id="srl-0"><?php echo $string["post_category_" . 0]; ?></li>
		<?php for ($i = 1; $i < 25; $i++) { ?>
			<li onclick="selectRec(<?php echo $i; ?>)" id="srl-<?php echo $i; ?>"><?php echo $string["post_category_" . $i]; ?></li>
		<?php } ?>
		<li id="srl-999"><?php echo $string["post_category_" . 999]; ?></li>
	</ul>
	<div class="btm-container">
		<button onclick="hideRecContainer()"><?php echo $string['action_hide_popup_categories']; ?></button>
	</div>
</div>

<hr class="container-select-rec-divider" id="container-select-rec-divider" <?php if (isMobile()) { ?>style="width: -webkit-fill-available;margin: 30px 0;"<?php } ?>>

<script type="text/javascript">
	function selectRecOffline(argument) {
		try {
			if (document.getElementById('srl-'+argument).classList.contains('selected') == true) {
				document.getElementById('srl-'+argument).classList.remove('selected');
			} else {
				document.getElementById('srl-'+argument).classList.add('selected');
			}
		} catch (exx) {
			console.log(exx);
		}
	}
	function selectRec(argument) {
		document.getElementById('srl-container-list').style.opacity = '.5';
		$.ajax({
			type: "POST", 
			url: "<?php echo $default_api; ?>/user/recomendation/save.php", 
			data: {token: '<?php echo $_COOKIE['USID'] ?>', id: argument}, 
	    	success: function(result){
				// console.log(result);
				var jsonOBJ = JSON.parse(result);
				toast(jsonOBJ['message']);
				selectRecOffline(jsonOBJ['category']);
				document.getElementById('srl-container-list').style.opacity = '1';
			}
		});
	}
	function hideRecContainer() {
		document.getElementById('cont-rec-id-select').remove();
		document.getElementById('container-select-rec-divider').remove();
		setHidePopupRec(true);
	}

	<?php foreach($result_rec['list'] as $key => $value) { ?>
		selectRecOffline(<?php echo $value; ?>);
	<?php } ?>
</script>