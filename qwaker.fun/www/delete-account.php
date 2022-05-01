<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/only-load.php';
?>
<!DOCTYPE html>
<html lang="<?php echo $langTAG; ?>" class="<?php echo $default_theme; ?>">
<head>
	<title><?php echo $string['title_delete_account']; ?></title>
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
			<div class="container-padding">
				<!-- <img src="/assets/images/qak-delete-account-v1.png" class="qak-verify-logo delete-account" draggable="false"> -->

				<h2 class="title-qak-text" id="title"><?php echo $string['title_delete_account']; ?></h2>
				<h2 class="subtitle-qak-text" id="subtitle"><?php echo $string['message_delete_account']; ?></h2>

				<hr>

				<h5 class="qak-puncts-title"><?php echo $string['message_delete_account_short']; ?></h5>
				<ul class="qak-verify-puncts">
					<li><?php echo $string['delete_account_item_1']; ?></li>
					<li><?php echo $string['delete_account_item_2']; ?></li>
					<li><?php echo $string['delete_account_item_3']; ?></li>
					<li><?php echo $string['delete_account_item_4']; ?></li>
				</ul>

				<input type="password" id="data" placeholder="<?php echo $string['hint_delete_account_rpeat_password']; ?>" style="margin-top: 20px;">
				<button style="margin-top: 20px;" onclick="goDeleteAccount()"><?php echo $string['action_delete_account']; ?></button>
			</div>

			<h3 class="small-message"><?php echo $string['message_delete_account_long']; ?></h3>

			<script type="text/javascript">
				function goDeleteAccount() {
					if (confirm(stringOBJ['message_delete_account_are'])) {
						showProgressDialog();
						$.ajax({
							type: "POST", 
							url: "<?php echo $default_api; ?>/user/delete-account.php", 
							data: {
								token: '<?php echo $_COOKIE['USID'] ?>',
								password: document.getElementById('data').value
							}, 
					    	success: function(result){
								// console.log(result);
								hideProgressDialog();
								var jsonOBJ = JSON.parse(result);
								alert(jsonOBJ['message']);
								if (jsonOBJ['type'] == 'success') {
									window.location.replace("/");
								}
							}
						});
					}
				}
			</script>
		</div>
	</center>

	<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/design/holder.php'; ?>

</body>
</html>