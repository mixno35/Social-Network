<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
?>
<?php
	$url_user_post_c = $default_api.'/user/data.php?id='.$_COOKIE['USID'].'&token='.$_COOKIE['USID'];
	$result_user_post_c = json_decode(file_get_contents($url_user_post_c, false), true);
?>
<center>
	<div class="qak-post-container">
		<center>
			<h2 class="title-qak-text"><?php echo $string['title_new_post']; ?></h2>

			<div>
				<input type="title" name="title" id="title-new-post" class="qak-input-post" placeholder="<?php echo $string['hint_post_title']; ?>">
				<input type="file" name="pic[]" id="pic" multiple="3" onchange="updPreview(this)" accept=".jpg, .jpeg, .png" style="display: none;">
				<textarea class="qak-textarea-post" id="message-new-post" placeholder="<?php echo $string['hint_post_message']; ?>"></textarea>
				<?php if ($result_user_post_c['public_post'] == 1) { ?>
					<div class="qak-post-div-cntr-bottom">
						<h3 class="qak-container-popup-text" id="qak-container-popup-text" onclick="closePopups();popupWindow('post-category-popup')"><?php echo $string['post_category_0']; ?></h3>
						<ol class="popup scroll category scroll-new" id="post-category-popup" style="display: none;" onclick="event.stopPropagation();event.preventDefault()">
							<li class="category-post selected" id="category0" onclick="chooseCategory(0, this.textContent, this.id)"><?php echo $string['post_category_0']; ?></li>
							<hr>
							<li class="category-post" id="category1" onclick="chooseCategory(1, this.textContent, this.id)"><?php echo $string['post_category_1']; ?></li>
							<li class="category-post" id="category2" onclick="chooseCategory(2, this.textContent, this.id)"><?php echo $string['post_category_2']; ?></li>
							<li class="category-post" id="category3" onclick="chooseCategory(3, this.textContent, this.id)"><?php echo $string['post_category_3']; ?></li>
							<li class="category-post" id="category4" onclick="chooseCategory(4, this.textContent, this.id)"><?php echo $string['post_category_4']; ?></li>
							<li class="category-post" id="category11" onclick="chooseCategory(11, this.textContent, this.id)"><?php echo $string['post_category_11']; ?></li>
							<li class="category-post" id="category17" onclick="chooseCategory(17, this.textContent, this.id)"><?php echo $string['post_category_17']; ?></li>
							<li class="category-post" id="category5" onclick="chooseCategory(5, this.textContent, this.id)"><?php echo $string['post_category_5']; ?></li>
							<li class="category-post" id="category24" onclick="chooseCategory(24, this.textContent, this.id)"><?php echo $string['post_category_24']; ?></li>
							<li class="category-post" id="category15" onclick="chooseCategory(15, this.textContent, this.id)"><?php echo $string['post_category_15']; ?></li>
							<li class="category-post" id="category22" onclick="chooseCategory(22, this.textContent, this.id)"><?php echo $string['post_category_22']; ?></li>
							<li class="category-post" id="category6" onclick="chooseCategory(6, this.textContent, this.id)"><?php echo $string['post_category_6']; ?></li>
							<li class="category-post" id="category16" onclick="chooseCategory(16, this.textContent, this.id)"><?php echo $string['post_category_16']; ?></li>
							<li class="category-post" id="category7" onclick="chooseCategory(7, this.textContent, this.id)"><?php echo $string['post_category_7']; ?></li>
							<li class="category-post" id="category18" onclick="chooseCategory(18, this.textContent, this.id)"><?php echo $string['post_category_18']; ?></li>
							<li class="category-post" id="category12" onclick="chooseCategory(12, this.textContent, this.id)"><?php echo $string['post_category_12']; ?></li>
							<li class="category-post" id="category13" onclick="chooseCategory(13, this.textContent, this.id)"><?php echo $string['post_category_13']; ?></li>
							<li class="category-post" id="category8" onclick="chooseCategory(8, this.textContent, this.id)"><?php echo $string['post_category_8']; ?></li>
							<li class="category-post" id="category20" onclick="chooseCategory(20, this.textContent, this.id)"><?php echo $string['post_category_20']; ?></li>
							<li class="category-post" id="category19" onclick="chooseCategory(19, this.textContent, this.id)"><?php echo $string['post_category_19']; ?></li>
							<li class="category-post" id="category21" onclick="chooseCategory(21, this.textContent, this.id)"><?php echo $string['post_category_21']; ?></li>
							<li class="category-post" id="category9" onclick="chooseCategory(9, this.textContent, this.id)"><?php echo $string['post_category_9']; ?></li>
							<li class="category-post" id="category10" onclick="chooseCategory(10, this.textContent, this.id)"><?php echo $string['post_category_10']; ?></li>
							<li class="category-post" id="category14" onclick="chooseCategory(14, this.textContent, this.id)"><?php echo $string['post_category_14']; ?></li>
							<li class="category-post" id="category23" onclick="chooseCategory(23, this.textContent, this.id)"><?php echo $string['post_category_23']; ?></li>
							<hr>
							<li class="category-post" id="category999" onclick="chooseCategory(999, this.textContent, this.id)"><?php echo $string['post_category_999']; ?></li>
						</ol>
						<!-- <help-m data-tooltip="<?php echo $string_help_post_category; ?>" data-tooltip-position="bottom">?</help-m> -->
						<div style="width: -webkit-fill-available;"></div>
						<div style="position: relative;">
							<div style="display: flex;align-items: center;">
								<div class="qak-action-deffred-post" onclick="closePopups();popupWindow('post-deffred-popup')" title="<?php echo $string['tooltip_post_deffred']; ?>" ></div>
								<div class="qak-action-picture-add" onclick="closePopups();popupWindow('post-pic-list-popup')" title="<?php echo $string['tooltip_post_add_image']; ?>"></div>
							</div>
							<ol class="popup arrow post-pic-list-popup" id="post-pic-list-popup" style="display: none;" onclick="document.getElementById('pic').click(); event.stopPropagation();event.preventDefault()">
								<div>
									<img src="" class="post-pic-item" id="post-pic-item-1" src="/assets/images/qak-avatar-add-image.png">
									<img src="" class="post-pic-item" id="post-pic-item-2" src="/assets/images/qak-avatar-add-image.png">
									<img src="" class="post-pic-item" id="post-pic-item-3" src="/assets/images/qak-avatar-add-image.png">
								</div>
							</ol>
							<ol class="popup arrow post-deffred-popup" id="post-deffred-popup" style="display: none;" onclick="event.stopPropagation();event.preventDefault()">
								<div class="post-deffred-ddd-ttt">
									<h2 class="post-deffred-ddd"><?php echo $string['short_text_day']; ?></h2>
									<h2 class="post-deffred-ddd"><?php echo $string['short_text_month']; ?></h2>
									<h2 class="post-deffred-ddd"><?php echo $string['short_text_year']; ?></h2>
								</div>
								<div class="post-deffred-ddd-ccc">
									<input type="number" class="post-deffred-ddd" value="<?php echo date('d'); ?>" id="post-deffred-day" maxlength="2" max="31" min="1">
									<input type="number" class="post-deffred-ddd" value="<?php echo date('m'); ?>" id="post-deffred-month" maxlength="2" max="12" min="1">
									<input type="number" class="post-deffred-ddd" value="<?php echo date('Y'); ?>" id="post-deffred-year" maxlength="4" minlength="4" max="<?php echo date('Y')+1; ?>" min="<?php echo date('Y'); ?>">
								</div>
								<div class="post-deffred-ddd-ttt">
									<h2 class="post-deffred-ddd"><?php echo $string['short_text_hour']; ?></h2>
									<h2 class="post-deffred-ddd"><?php echo $string['short_text_minute']; ?></h2>
									<h2 class="post-deffred-ddd"><?php echo $string['short_text_second']; ?></h2>
								</div>
								<div class="post-deffred-ddd-ccc">
									<input type="number" class="post-deffred-ddd" value="<?php echo date('H'); ?>" id="post-deffred-hour" maxlength="2" max="23" min="0">
									<input type="number" class="post-deffred-ddd" value="<?php echo date('i'); ?>" id="post-deffred-min" maxlength="2" max="59" min="0">
									<input type="number" class="post-deffred-ddd" value="<?php echo date('s'); ?>" id="post-deffred-sec" maxlength="2" max="59" min="0">
								</div>
								<hr class="post-deffred-divider">
								<button class="post-deffred-aply" onclick="setTimeDeffPost()"><?php echo $string['action_post_deffred_apply']; ?></button>
								<button class="border post-deffred-aply" onclick="deleteTimeDeffPost()"><?php echo $string['action_post_deffred_cancel']; ?></button>
							</ol>
							<script type="text/javascript">
								
							</script>
						</div>
						<center style="margin: 0;margin-top: 20px;display: none;align-items: center;justify-content: center;" id="p-s">
							<div id="qak-progress-div" class="qak-progress-div" style="margin: 0;margin-top: -19px;width: 128px;"><div style="margin: 0;" id="qak-progress-bar" class="qak-progress-bar"></div></div>
						</center>
						<button id="btn-pub" class="qak-button-public-post <?php if ($result_user_post_c['public_post'] == 0) { echo 'border'; } ?>" <?php if ($result_user_post_c['public_post'] == 1) { ?>onclick="goPublicPost()"<?php } else { echo 'disabled'; } ?>><?php if ($result_user_post_c['public_post'] == 1) { echo $string['action_post_public']; } else { echo $string['action_post_public_disable']; } ?></button>
					</div>
				<?php } ?>
			</div>
		</center>
	</div>
</center>

<script type="text/javascript">
	var category_result = 0;

	function chooseCategory(arguments, arguments2, arguments3) {
		var testElements = document.getElementsByClassName('category-post');
		Array.prototype.filter.call(testElements, function(testElement){
		    document.getElementById(testElement.id).classList.remove('selected');
		});

		document.getElementById('qak-container-popup-text').textContent = arguments2;

		document.getElementById(arguments3).classList.add('selected');
		category_result = arguments;

		// Скрыть окно после выбора.
		// if (document.getElementById('post-category-popup').style.display != 'none') {
		// 	popupWindow('post-category-popup');
		// }
	}
</script>

<?php if ($result_user_post_c['public_post'] == 1) { ?>
	<script type="text/javascript">
		var time_post_deff = 0;

		function setTimeDeffPost() {
			var tmDefDay = document.getElementById('post-deffred-day').value;
			var tmDefMonth = document.getElementById('post-deffred-month').value;
			var tmDefYear = document.getElementById('post-deffred-year').value;

			var tmDefHour = document.getElementById('post-deffred-hour').value;
			var tmDefMin = document.getElementById('post-deffred-min').value;
			var tmDefSec = document.getElementById('post-deffred-sec').value;

			var tmResultPostDef = tmDefYear+'-'+tmDefMonth+'-'+tmDefDay+' '+tmDefHour+':'+tmDefMin+':'+tmDefSec;

			console.log(tmResultPostDef);
			time_post_deff = new Date(tmResultPostDef).getTime() / 1000;
			closePopups();
			toast(stringOBJ['toast_post_deffred_applied'] + ' ' + tmResultPostDef);
		}

		function deleteTimeDeffPost() {
			time_post_deff = 0;
			closePopups();
			toast(stringOBJ['toast_post_deffred_canceled']);
		}

		function goPublicPost() {
			// console.log(time_post_deff);
			// return;

			var arguments = document.getElementById('title-new-post').value;
			var arguments2 = document.getElementById('message-new-post').value;
			var fl = document.getElementById('pic');
			var formdata = new FormData();

			formdata.append('title', arguments);
			formdata.append('message', arguments2);
			formdata.append('category', category_result);
			formdata.append('deffred', time_post_deff);
			formdata.append('token', '<?php echo $_COOKIE['USID']; ?>');
			formdata.append('image1[]', fl.files[0]);
			formdata.append('image2[]', fl.files[1]);
			formdata.append('image3[]', fl.files[2]);

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
					url: "<?php echo $default_api; ?>/post/new.php", 
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
						toast(jsonOBJ['message']);
						if (jsonOBJ['type'] == 'success') {
							document.getElementById('message-new-post').value = '';
							document.getElementById('title-new-post').value = '';
							try {
								chooseCategory(0, stringOBJ['post_category_0'], 'category0')
							} catch (exx) {}
							try {
								openType(posts_type, posts_limit);
							} catch (exx) {}
							try {
								loadUserPosts();
							} catch (exx) {}
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

		updPreview(null);

		function updPreview(argument) {
			try {
				document.getElementById('post-pic-item-1').src = window.URL.createObjectURL(argument.files[0]);
			} catch (exx) {
				document.getElementById('post-pic-item-1').src = '/assets/images/qak-avatar-add-image.png';
			} try {
				document.getElementById('post-pic-item-2').src = window.URL.createObjectURL(argument.files[1]);
			} catch (exx) {
				document.getElementById('post-pic-item-2').src = '/assets/images/qak-avatar-add-image.png';
			} try {
				document.getElementById('post-pic-item-3').src = window.URL.createObjectURL(argument.files[2]);
			} catch (exx) {
				document.getElementById('post-pic-item-3').src = '/assets/images/qak-avatar-add-image.png';
			}
		}
	</script>
<?php } ?>