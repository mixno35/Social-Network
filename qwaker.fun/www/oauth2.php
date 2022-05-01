<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/only-load.php';
?>
<?php
	$redirect = $_GET['redirect'];

	$url_user = $default_api.'/user/data?token='.$_COOKIE['USID'];
	$result_user = json_decode(file_get_contents($url_user, false), true);

	// $url_at = $default_api.'/oauth/create-access-token?token='.$_COOKIE['USID'];
	// $result_at = json_decode(file_get_contents($url_at, false), true);
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

	<?php if (trim($_COOKIE['USID']) == '') {} else { ?>
		<center>
			<h1 class="title">OAuth</h1>

			<div class="qak-auth-container">
				<img src="<?php echo $result_user['avatar']; ?>" class="avatar-user" id="avatar-user" onerror="this.src = '/assets/images/qak-avatar-v3.png'">
				<h2 class="name-user" id="name-user"><?php echo $result_user['name']; ?></h2>
				<h3 class="sub-name-user" id="sub-name-user"><?php echo $result_user['login']; ?></h3>

				<hr>

				<button onclick="goOtherAuth()" class="button-next"><?php echo $string['action_oauth_continue']; ?></button>
			</div>

		</center>

		<script type="text/javascript">
			function goOtherAuth() {
				var urlRes = updParam2('<?php echo $redirect; ?>', 'access_token', '<?php echo $_COOKIE['USID']; ?>');
				urlRes = updParam2(urlRes, 'id', '<?php echo $result_user['id_user']; ?>');
				window.location.replace(urlRes);
			}

			function updParam2(url, param, paramVal) {
			    var newAdditionalURL = "";
			    var tempArray = url.split("?");
			    var baseURL = tempArray[0];
			    var additionalURL = tempArray[1];
			    var temp = "";
			    if (additionalURL) {
			        tempArray = additionalURL.split("&");
			        for (var i=0; i<tempArray.length; i++){
			            if(tempArray[i].split('=')[0] != param){
			                newAdditionalURL += temp + tempArray[i];
			                temp = "&";
			            }
			        }
			    }

			    var rows_txt = temp + "" + param + "=" + paramVal;
			    return baseURL + "?" + newAdditionalURL + rows_txt;
			    // window.history.replaceState('', '', baseURL + "?" + newAdditionalURL + rows_txt);
			}
		</script>
	<?php } ?>

	<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/design/holder.php'; ?>

</body>
</html>