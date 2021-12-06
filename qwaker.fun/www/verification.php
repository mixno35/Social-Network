<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/only-load.php';
?>
<?php
	$url_user = $default_api.'/user/data.php?id='.$_COOKIE['USID'].'&token='.$_COOKIE['USID'];
	$result_user = json_decode(file_get_contents($url_user, false), true);
?>
<?php
	function getVerificationType($value='') {
		include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';

		switch ($value) {
			case 'popular':
				return $string_message_verification_type_popular;
				break;
			case 'blogger':
				return $string_message_verification_type_blogger;
				break;
			case 'developer':
				return $string_message_verification_type_developer;
				break;
			case 'developer_friend':
				return $string_message_verification_type_developer_friend;
				break;
			
			default:
				return '';
				break;
		}
	}
?>
<!DOCTYPE html>
<html lang="<?php echo $langTAG; ?>" class="<?php echo $default_theme; ?>">
<head>
	<title><?php echo $string['title_verification']; ?></title>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/style.php'; ?>
	<link rel="stylesheet" type="text/css" href="<?php echo $default_theme_site; ?>verification.css?v=<?php echo time(); ?>">
	<link rel="shortcut icon" href="/assets/images/qak-favicon.png" type="image/png">
	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/script.php'; ?>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/meta.php'; ?>
</head>
<body>

	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/placeholder.php'; ?>

	<?php
		if ($_COOKIE['USID'] == '') {
			?>
				<script type="text/javascript">
					window.location.replace("/");
				</script>
			<?php
		}
	?>

	<center>
		<div class="qak-verify-container">
			<?php if ($result_user['user_verification'] == 1) { ?>
				<!-- <img src="/assets/images/qak-verification-v2.png" class="qak-verify-logo verify" draggable="false"> -->

				<h2 class="title-qak-text" id="title"><?php echo $string['title_verification']; ?></h2>
				<h2 class="subtitle-qak-text" id="subtitle"><?php echo str_replace('%1s', getVerificationType($result_user['user_verification_type']), $string['message_verification_subtext_v2']); ?></h2>
			<?php } else { ?>
				<?php if ($result_user['user_verification'] == 2) { ?>
					<!-- <img src="/assets/images/qak-verification-v3.png" class="qak-verify-logo verify" draggable="false"> -->

					<h2 class="title-qak-text" id="title"><?php echo $string['title_verification']; ?></h2>
					<h2 class="subtitle-qak-text" id="subtitle"><?php echo $string['message_verification_subtext_v3']; ?></h2>
				<?php } else { ?>
					<!-- <img src="/assets/images/qak-verification-v1.png" class="qak-verify-logo verify" draggable="false"> -->

					<h2 class="title-qak-text" id="title"><?php echo $string['title_verification']; ?></h2>
					<h2 class="subtitle-qak-text" id="subtitle"><?php echo $string['message_verification_subtext_v1']; ?></h2>

					<hr>

					<h5 class="qak-puncts-title"><?php echo $string['title_verification_puncts_v1']; ?></h5>
					<ul class="qak-verify-puncts">
						<li><?php echo $string['verification_punct_1']; ?></li>
						<!-- <li><?php echo $string['verification_punct_2']; ?></li> -->
						<li><?php echo $string['verification_punct_3']; ?></li>
						<li><?php echo $string['verification_punct_7']; ?></li>
					</ul>

					<hr>

					<h5 class="qak-puncts-title"><?php echo $string['title_verification_puncts_v2']; ?></h5>
					<ul class="qak-verify-puncts">
						<li><?php echo $string['verification_punct_4']; ?></li>
						<li><?php echo $string['verification_punct_5']; ?></li>
						<li><?php echo $string['verification_punct_6']; ?></li>
					</ul>

					<!-- <input type="url" id="data" placeholder="<?php echo $string['hint_data_verification']; ?>" style="margin-top: 20px;"> -->
					<button style="margin-top: 20px;" onclick="goVerify()"><?php echo $string['action_verification_profile']; ?></button>

					<script type="text/javascript">
						function goVerify() {
							if (confirm(stringOBJ['message_verification_account_are'])) {
								$.ajax({
									type: "POST", 
									url: "<?php echo $default_api; ?>/user/edit/verify.php", 
									data: {token: '<?php echo $_COOKIE['USID'] ?>'}, 
							    	success: function(result){
										// console.log(result);
										var jsonOBJ = JSON.parse(result);
										alert(jsonOBJ['message']);
										if (jsonOBJ['type'] == 'success') {
											window.location.reload();
										}
									}
								});
							}
						}
					</script>
				<?php } ?>
			<?php } ?>
		</div>
	</center>

	<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/design/holder.php'; ?>

</body>
</html>