<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/only-load.php';
?>
<?php
	$id = intval($_GET['id']);

	$url_user = $default_api.'/user/data.php?token='.$_COOKIE['USID'];
	$result_user = json_decode(file_get_contents($url_user, false), true);

	$url_post = $default_api.'/post/edit/data.php?id='.$id.'&token='.$_COOKIE['USID'];
	$result_post = json_decode(file_get_contents($url_post, false), true);
?>
<!DOCTYPE html>
<html lang="<?php echo $langTAG; ?>" class="<?php echo $default_theme; ?>">
<head>
	<title><?php echo $string['title_post_edit']; ?> | <?php echo $result_post['post_message']; ?></title>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/style.php'; ?>
	<link rel="shortcut icon" href="/assets/images/qak-favicon.png" type="image/png">
	<link rel="stylesheet" type="text/css" href="<?php echo $default_theme_site; ?>post.css?v=<?php echo time(); ?>">
	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/script.php'; ?>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/meta.php'; ?>
</head>
<body>

	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/auth_check.php'; ?>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/placeholder.php'; ?>

	<?php
		if ($_COOKIE['USID'] == '') {
			?>
				<script type="text/javascript">
					window.location.replace("/");
				</script>
			<?php
			exit();
		}
	?>

	<center>
		<div class="qak-post-container" <?php if (isMobile()) { ?>style="width: -webkit-fill-available;margin: 0;"<?php } ?>>
			<center>
				<h2 class="title-qak-text"><?php echo $string['title_post_edit']; ?></h2>

				<div>
					<input type="title" name="title" id="title" class="qak-input-post" value="<?php echo $result_post['post_title']; ?>" placeholder="<?php echo $string['hint_post_title']; ?>">
					<textarea class="qak-textarea-post" id="message" value="" placeholder="<?php echo $string['hint_post_message']; ?>"><?php echo $result_post['post_message']; ?></textarea>
						<div style="width: -webkit-fill-available;"></div>
						<center style="margin-top: 20px;display: none;align-items: center;justify-content: center;" id="p-s">
							<div id="qak-progress-div" style="margin-top: -19px;width: 128px;"><div id="qak-progress-bar"></div></div>
						</center>
						<button id="btn-pub" style="margin-top: 10px;" class="qak-button-public-post <?php if ($result_user['public_post'] == 0) { echo 'border'; } ?>" <?php if ($result_user['public_post'] == 1) { ?>onclick="goPublicPost()"<?php } else { echo 'disabled'; } ?>><?php if ($result_user['public_post'] == 1) { echo $string['action_post_public']; } else { echo $string['action_post_public_disable']; } ?></button>
					</div>
				</div>
			</center>
		</div>
	</center>

	<?php if ($result_user['public_post'] == 1) { ?>
		<script type="text/javascript">
			function goPublicPost() {
				var arguments = document.getElementById('title').value;
				var arguments2 = document.getElementById('message').value;
				var formdata = new FormData();

				formdata.append('id', <?php echo $id; ?>);
				formdata.append('title', arguments);
				formdata.append('message', arguments2);
				formdata.append('token', '<?php echo $_COOKIE['USID']; ?>');

				if (arguments2 != '') {
					document.getElementById('p-s').style.display = 'flex';
					document.getElementById('btn-pub').style.display = 'none';
					$.ajax({
						xhr: function() {
			                var xhr = new window.XMLHttpRequest();
			                xhr.upload.addEventListener("progress", function(evt) {
			                    if (evt.lengthComputable) {
			                        var percentComplete = ((evt.loaded / evt.total) * 100);
			                        $("#qak-progress-bar").animate({
								    	width: percentComplete + '%'
								    }, {
								    	duration: 500
								    });
			                    }
			                }, false);
			                return xhr;
			            },
						type: "POST", 
						url: "<?php echo $default_api; ?>/post/edit/save.php", 
						data: formdata, 
				    	contentType: false,
				    	processData: false,
				    	success: function(result){
							// console.log(result);
							document.getElementById('p-s').style.display = 'none';
							document.getElementById('btn-pub').style.display = 'block';
							$("#qak-progress-bar").animate({
						    	width: 0 + '%'
						    }, {
						    	duration: 500
						    });
							var jsonOBJ = JSON.parse(result);
							alert(jsonOBJ['message']);
							if (jsonOBJ['type'] == 'success') {
								window.history.back();
							}
						}, 
						error: function(result){
							// console.log(result);
						}
					});
				} else {
					alert(stringOBJ['message_no_valid_empty_post_message']);
				}
			}
		</script>
	<?php } ?>

</body>
</html>