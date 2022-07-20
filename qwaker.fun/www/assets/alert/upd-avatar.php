<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/only-load.php';
?>
<?php
	$maxSIZEAVATAR = intval(1); /* -- MB -- */

	$url_user_upd = $default_api.'/user/data.php?token='.$_COOKIE['USID'];
	$result_user_upd = json_decode(file_get_contents($url_user_upd, false), true);
?>
<div class="qak-alert-container" id="qak-alert-container">
	<div class="qak-alert-container-holder">
		<h2 class="qak-alert-container-holder-title"><?php echo $string['title_user_photo_update']; ?></h2>
		<div class="qak-alert-close" onclick="document.getElementById('qak-alert-container').remove();openedAlertPost = false"></div>
		<div class="qak-alert-container-data">
			<center class="qak-alert-container-data-center-avatar-preview">
				<img src="<?php echo $result_user_upd['avatar']; ?>" class="qak-alert-container-data-avatar-preview" id="qak-alert-container-data-avatar-preview" onerror="this.src = '/assets/images/qak-avatar-v3.png'">
				<h4 class="qak-alert-upd-avatar-mess-click" onclick="document.getElementById('profile_pic').click();"><?php echo $string['text_click_go_choose_picture']; ?></h4>
				<input type="file" id="profile_pic" name="profile_pic" onchange="updPreview(this)" accept=".jpg, .jpeg, .png" style="display: none;">
				<h4 style="margin-top: 5px;" class="qak-short-hint">
					<span class="material-symbols-outlined">info</span>
					<?php echo str_replace('%1s', $maxSIZEAVATAR, $string['message_user_photo_update_valid_format']); ?>
				</h4>
				<button style="margin-top: 20px;" id="a-s" onclick="updAvatar('upd')"><?php echo $string['action_save']; ?></button>
				<button style="margin-top: 20px;" id="a-s-2" onclick="updAvatar('remove')"><?php echo $string['action_user_photo_remove']; ?></button>

				<center style="margin-top: 20px;display: none;" id="p-s-avatar">
					<div id="qak-progress-div-avatar" class="qak-progress-div"><div id="qak-progress-bar-avatar" class="qak-progress-bar"></div></div>
				</center>
			</center>
		</div>
	</div>

	<script type="text/javascript">
		var fileTypes = [
		  'image/jpeg',
		  'image/pjpeg',
		  'image/png'
		];

		function updAvatar(argument) {
			var fl = document.getElementById('profile_pic');
			var formdata = new FormData();

			formdata.append('type', argument);
			formdata.append('token', '<?php echo $_COOKIE['USID']; ?>');
			formdata.append('file[]', fl.files[0]);

			// console.log(formdata);

			if (argument != 'remove') {
				if (validFileType(fl.files[0])) {
					if (validateSize(fl)) {
						// alert('Все ок: '+window.URL.createObjectURL(fl.files[0]));
					} else {
						alert(stringOBJ['message_user_photo_update_invalid_maxsize_limit'].replace("%1s", (fl.files[0].size / 1024 / 1024 - 4).toFixed(2)+'MB'));
						return;
					}
				} else {
					alert(stringOBJ['message_user_photo_update_invalid_file_format']);
					return;
				}
			}

			document.getElementById('p-s-avatar').style.display = 'block';
			document.getElementById('a-s').style.display = 'none';
			document.getElementById('a-s-2').style.display = 'none';
			$.ajax({
				xhr: function() {
	                var xhr = new window.XMLHttpRequest();
	                xhr.upload.addEventListener("progress", function(evt) {
	                    if (evt.lengthComputable) {
	                        var percentComplete = ((evt.loaded / evt.total) * 100);
	                        $("#qak-progress-bar-avatar").animate({
						    	width: percentComplete + '%'
						    }, {
						    	duration: 500
						    });
	                    }
	                }, false);
	                return xhr;
	            },
				type: "POST", 
				url: "<?php echo $default_api; ?>/user/edit/avatar.php", 
				data: formdata, 
		    	contentType: false,
		    	processData: false,
		    	success: function(result){
					// console.log(result);
					var jsonOBJ = JSON.parse(result);
					
					document.getElementById('p-s-avatar').style.display = 'none';
					document.getElementById('a-s').style.display = 'inline-block';
					document.getElementById('a-s-2').style.display = 'inline-block';

					toast(jsonOBJ['message']);
					if (jsonOBJ['type'] == 'success') {
						document.getElementById('qak-alert-container').remove();
						document.getElementById('qak-avatar-user').src = jsonOBJ['result'];
					}
					$("#qak-progress-bar-avatar").animate({
				    	width: 0 + '%'
				    }, {
				    	duration: 500
				    });
				}, 
				error: function(result){
					// console.log(result);
				}
			});
		}

		function validateSize(file) {
	        var FileSize = file.files[0].size / 1024 / 1024; // in MiB
	        if (FileSize > <?php echo $maxSIZEAVATAR; ?>) {
	            return false;
	        } else {
	        	return true;
	        }
	    }
	    function validFileType(file) {
			for(var i = 0; i < fileTypes.length; i++) {
			    if(file.type === fileTypes[i]) {
			    	return true;
			    }
			}

			return false;
		}

	    function updPreview(argument) {
	    	document.getElementById('qak-alert-container-data-avatar-preview').src = window.URL.createObjectURL(argument.files[0]);
	    }
	</script>
</div>