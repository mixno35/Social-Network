<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/only-load.php';
?>
<?php
	$service = $_GET['service'];

	echo "Function is disabled!";

	exit();
?>
<!DOCTYPE html>
<html lang="<?php echo $langTAG; ?>" class="<?php echo $default_theme; ?>">
<head>
	<title>OAuth</title>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/style.php'; ?>
	<link rel="stylesheet" type="text/css" href="<?php echo $default_theme_site; ?>auth.css?v=<?php echo time(); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo $default_theme_site; ?>oauth.css?v=<?php echo time(); ?>">
	<link rel="shortcut icon" href="/assets/images/qak-favicon.png" type="image/png">
	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/script.php'; ?>
	<script type="text/javascript" src="https://vk.com/js/api/openapi.js?169"></script>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/meta.php'; ?>
</head>
<body>

	<center>

		<h1 class="title">OAuth</h1>
		
		<?php if ($service == 'vk') { ?>
			<script type="text/javascript">
				var hash = window.location.hash.substring(1).split('&');

				var user_id = hash[2].replace('user_id=', '');
				var access_token = hash[0].replace('access_token=', '');
				var nameUser = '';
				var avatarUser = '';

				var script = document.createElement('SCRIPT');
				script.src = "https://api.vk.com/method/users.get?user_ids="+user_id+"&access_token="+access_token+"&fields=photo_200&v=5.131&callback=callbackFunc";
				document.getElementsByTagName("head")[0].appendChild(script);
				function callbackFunc(result) {
					console.log(result);

					nameUser = result.response[0].first_name+' '+result.response[0].last_name;
					avatarUser = result.response[0].photo_200;

					document.getElementById('name-user').textContent = nameUser.trim();
					document.getElementById('sub-name-user').textContent = 'ВКонтакте';
					document.getElementById('type-avatar-user').src = '/assets/icons/other-auth/vk.png';
					document.getElementById('avatar-user').src = avatarUser;
				}
			</script>
		<?php } ?>

		<div class="qak-auth-container">
			<img src="" class="avatar-user" id="avatar-user" onerror="this.src = '/assets/images/qak-avatar-v3.png'">
			<img src="" id="type-avatar-user" class="type-avatar-user">
			<h2 class="name-user" id="name-user"></h2>
			<h3 class="sub-name-user" id="sub-name-user"></h3>

			<hr>

			<button onclick="goOtherAuth()" class="button-next"><?php echo $string['action_oauth_continue']; ?></button>
		</div>

		<h4 class="small-message"><?php echo $string['message_oauth_long']; ?></h4>

		<script type="text/javascript">
			function goOtherAuth() {
				$.ajax({
					type: "POST", 
					url: "<?php echo $default_api; ?>/oauth/<?php echo $service; ?>", 
					data: {
						id: user_id,
						name: nameUser,
						avatar: avatarUser,
						token: access_token
					}, 
			    	success: function(result){
						console.log(result);
						var jsonOBJ = JSON.parse(result);
						
						alert(jsonOBJ['message']);
						if (jsonOBJ['type'] == 'success') {
							document.cookie = "USID=" + jsonOBJ['token'] + "; path=/; SameSite=Strict; domain=<?php echo $_SERVER['SERVER_NAME']; ?>; expires=Tue, <?php echo intval(date('d')); ?> <?php echo date('M'); ?> <?php echo intval(date('Y')+1); ?> 00:00:00 GMT";
							document.cookie = "sid=" + jsonOBJ['sid'] + "; path=/; SameSite=Strict; domain=<?php echo $_SERVER['SERVER_NAME']; ?>; expires=Tue, <?php echo intval(date('d')); ?> <?php echo date('M'); ?> <?php echo intval(date('Y')+1); ?> 00:00:00 GMT";
							window.location = '/';
						}
					}
				});
			}
		</script>

	</center>

	<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/design/holder.php'; ?>

</body>
</html>