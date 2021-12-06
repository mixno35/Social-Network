<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/only-load.php';
?>
<?php
	$url = $_GET['url'];
	$json = $_GET['json'];
	$jsonKEY = $_GET['key'];
?>
<div class="qak-alert-container" id="qak-alert-container-photo">
	<script type="text/javascript">
		var titleDefViewPhoto = document.title;

		document.title = '<?php echo $string['title_preview_photo']; ?>';
	</script>
	<?php if (!trim($_COOKIE['USID'])) { ?>
		<h4 class="qak-alert-message-centered"><?php echo $string['message_no_crop_view_photo_token_empty']; ?></h4>
	<?php } ?>
	<img src="<?php echo $url; ?>" class="qak-alert-container-image-view <?php if (!trim($_COOKIE['USID'])) { echo 'no-crop'; }?>" id="qak-alert-image-preview" draggable="false">
	<div class="qak-alert-contaoner-view-photo-actions">
		<?php if (trim($_COOKIE['USID'])) { ?>
			<span title="<?php echo $string['action_view_photo_download']; ?>" onclick="downloadPhoto()">
				<a id="qak-alert-container-action-image-view-download" download="<?php echo $url; ?>"><div class="qak-alert-container-action-image-view download"></div></a>
			</span>
		<?php } ?>
		<span onclick="document.getElementById('qak-alert-container-photo').remove(); document.title=titleDefViewPhoto;" title="<?php echo $string['action_view_photo_close']; ?>">
			<div class="qak-alert-container-action-image-view close"></div>
		</span>
	</div>

	<?php if (sizeof(json_decode($json)) > 1) { ?>
		<h3 class="qak-alert-container-multiimage-num" id="qak-alert-container-multiimage-num">1/<?php echo sizeof(json_decode($json)); ?></h3>
		<span title="<?php echo $string['action_view_photo_forward']; ?>" onclick="swipeImage('-')">
			<div class="qak-alert-container-action-image-view download forward"></div>
		</span>
		<span title="<?php echo $string['action_view_photo_next']; ?>" onclick="swipeImage('+')">
			<div class="qak-alert-container-action-image-view download next"></div>
		</span>

		<script type="text/javascript">
			var jsonIMAGES = JSON.parse('<?php echo $json; ?>');
			var limitJSONIMAGES = <?php echo sizeof(json_decode($json)); ?>;
			var numJSONIMAGE = <?php echo $jsonKEY; ?>;

			var durationFadeImage = 100;

			document.getElementById('qak-alert-container-multiimage-num').textContent = numJSONIMAGE+1 + '/' + limitJSONIMAGES;

			function swipeImage(argument) {
				if (argument == '+') {
					if (numJSONIMAGE == limitJSONIMAGES-1) {} else {
						numJSONIMAGE = numJSONIMAGE + 1;
						// document.getElementById('qak-alert-image-preview').src = jsonIMAGES[numJSONIMAGE];
						$('#qak-alert-image-preview').fadeOut(durationFadeImage, function() {
					        $('#qak-alert-image-preview').attr("src", jsonIMAGES[numJSONIMAGE]);
					        $('#qak-alert-image-preview').fadeIn(durationFadeImage);
					    });
						imageURL = jsonIMAGES[numJSONIMAGE];
						document.getElementById('qak-alert-container-action-image-view-download').download = jsonIMAGES[numJSONIMAGE];
						document.getElementById('qak-alert-container-multiimage-num').textContent = numJSONIMAGE+1 + '/' + limitJSONIMAGES;
					}
					return;
				} if (argument == '-') {
					if (numJSONIMAGE == 0) {} else {
						numJSONIMAGE = numJSONIMAGE - 1;
						// document.getElementById('qak-alert-image-preview').src = jsonIMAGES[numJSONIMAGE];
						$('#qak-alert-image-preview').fadeOut(durationFadeImage, function() {
					        $('#qak-alert-image-preview').attr("src", jsonIMAGES[numJSONIMAGE]);
					        $('#qak-alert-image-preview').fadeIn(durationFadeImage);
					    });
						imageURL = jsonIMAGES[numJSONIMAGE];
						document.getElementById('qak-alert-container-action-image-view-download').download = jsonIMAGES[numJSONIMAGE];
						document.getElementById('qak-alert-container-multiimage-num').textContent = numJSONIMAGE+1 + '/' + limitJSONIMAGES;
					}
					return;
				}
			}

			if (!viewPhotoRunOne) {
				document.addEventListener('keydown', function(e) {
				    switch (e.keyCode) {
				        case 37:
				            try {
				            	swipeImage('-');
				            } catch (exx) {}
				            break;
				        case 39:
				            try {
				            	swipeImage('+');
				            } catch (exx) {}
				            break;
				    }
				});
			}
		</script>
	<?php } ?>
	<?php if (trim($_COOKIE['USID'])) { ?>
		<script type="text/javascript">
			var scale = 1;
			var imageURL = '<?php echo $url; ?>';

			$(".qak-alert-container").hover(function() {
			    $(this).find(".qak-alert-container-action-image-view").fadeIn(0);
			    $(this).find(".qak-alert-container-multiimage-num").fadeIn(0);
			}, function() {
			    $(this).find(".qak-alert-container-action-image-view").fadeOut(200);
			    $(this).find(".qak-alert-container-multiimage-num").fadeOut(200);
			});

			$(document).ready(function(){
			    $("#qak-alert-container-photo").on("mousewheel DOMMouseScroll", function (e) {
				    e.preventDefault();
				    var delta = e.delta || e.originalEvent.wheelDelta;
				    var zoomOut;
				    if (delta === undefined) {
				    	delta = e.originalEvent.detail;
				    	zoomOut = delta ? delta < 0 : e.originalEvent.deltaY > 0;
				    	zoomOut = !zoomOut;
				    } else {
				    	zoomOut = delta ? delta < 0 : e.originalEvent.deltaY > 0;
				    }
				    var touchX = e.type === 'mousemove' ? e.changedTouches[0].pageX : e.pageX;
				    var touchY = e.type === 'mousemove' ? e.changedTouches[0].pageY : e.pageY;
				    // var translateX, translateY;
				    if (zoomOut) {
					    var offsetWidth = $("#qak-alert-image-preview")[0].offsetWidth;
					    var offsetHeight = $("#qak-alert-image-preview")[0].offsetHeight;

					    if (scale == 1 || scale < 1) {
					    	scale = 1;
					    	$("#qak-alert-image-preview")
						        // .css("transform-origin", touchX + 'px ' + touchY + 'px')
						        .css("transform", 'scale(' + scale + ')');
					    } else {
					      	scale = scale - 0.20;
					      	$("#qak-alert-image-preview")
						        // .css("transform-origin", touchX + 'px ' + touchY + 'px')
						        .css("transform", 'scale(' + scale + ')');
					    }

					    if (scale <= 1) {
					      	document.getElementById('qak-alert-image-preview').style.top = '';
					      	document.getElementById('qak-alert-image-preview').style.bottom = '';
					      	document.getElementById('qak-alert-image-preview').style.left = '';
					      	document.getElementById('qak-alert-image-preview').style.right = '';
					    }
				    } else {
					    var offsetWidth = $("#qak-alert-image-preview")[0].offsetWidth;
					    var offsetHeight = $("#qak-alert-image-preview")[0].offsetHeight;

					    if (scale > 7) {} else {
						    scale = scale + 0.20;
							$("#qak-alert-image-preview")
							   // .css("transform-origin", touchX + 'px ' + touchY + 'px')
							   .css("transform", 'scale(' + scale + ')');
					    }

					    if (scale <= 1) {
						    document.getElementById('qak-alert-image-preview').style.top = '';
						    document.getElementById('qak-alert-image-preview').style.bottom = '';
						    document.getElementById('qak-alert-image-preview').style.left = '';
						    document.getElementById('qak-alert-image-preview').style.right = '';
					    }
				    }
			    
			  	});


			});

			function addListeners() {
			    document.getElementById('qak-alert-image-preview').addEventListener('mousedown', mouseDown, false);
			    window.addEventListener('mouseup', mouseUp, false);
			}

			function mouseUp() {
			    window.removeEventListener('mousemove', divMove, true);
			}

			function mouseDown(e) {
			    gMouseDownX = e.clientX;
			    gMouseDownY = e.clientY;

			    var div = document.getElementById('qak-alert-image-preview');

			    let leftPart = "";
			    if(!div.style.left)
			        leftPart+="0px";
			    else
			        leftPart = div.style.left;
			    let leftPos = leftPart.indexOf("px");
			    let leftNumString = leftPart.slice(0, leftPos);
			    gMouseDownOffsetX = gMouseDownX - parseInt(leftNumString,10);

			    let topPart = "";
			    if(!div.style.top)
			        topPart+="0px";
			    else
			        topPart = div.style.top;
			    let topPos = topPart.indexOf("px");
			    let topNumString = topPart.slice(0, topPos);
			    gMouseDownOffsetY = gMouseDownY - parseInt(topNumString,10);

			    window.addEventListener('mousemove', divMove, true);
			}

			function divMove(e){
			    if (scale > 1) {
			    	var div = document.getElementById('qak-alert-image-preview');
				    div.style.position = 'absolute';
				    let topAmount = e.clientY - gMouseDownOffsetY;
				    div.style.top = topAmount + 'px';
				    let leftAmount = e.clientX - gMouseDownOffsetX;
				    div.style.left = leftAmount + 'px';
			    }
			}

			addListeners();
		</script>
	<?php } ?>
	<script type="text/javascript">
		viewPhotoRunOne = true;
	</script>
</div>