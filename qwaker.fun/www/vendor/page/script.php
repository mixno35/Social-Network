<script type="text/javascript">
	var viewPhotoRunOne = false;
</script>
<script type="text/javascript">
	var stringOBJ = JSON.parse(<?php echo json_encode($linkString); ?>);
</script>

<script type="text/javascript">
	Object.defineProperty(window, "console", {
	    value: console,
	    writable: false,
	    configurable: false
	});

	var i = 0;
	function showWarningAndThrow() {
	    if (!i) {
	        setTimeout(function () {
	            console.log("%cWarning message", "font: 2em sans-serif; color: yellow; background-color: red;");
	        }, 1);
	        i = 1;
	    }
	    throw "Console is disabled";
	}

	var l, n = {
	        set: function (o) {
	            l = o;
	        },
	        get: function () {
	            showWarningAndThrow();
	            return l;
	        }
	    };
	Object.defineProperty(console, "_commandLineAPI", n);
	Object.defineProperty(console, "__commandLineAPI", n);
</script>
<script src="/assets/js/jquery/jquery-3.5.0.js"></script>
<script src="/assets/js/jquery/jquery.min.js"></script>
<script src="/assets/js/jquery/jquery-ui.min.js"></script>
<script src="/assets/js/default.js?v=11"></script>
<script src="/assets/js/toast.js"></script>
<script src="/assets/js/progress-bar.js"></script>
<script src="/assets/js/alert-box.js"></script>
<script type="text/javascript" id="qak-script-custom-theme">
	let gMouseDownX = 0;
	let gMouseDownY = 0;
	let gMouseDownOffsetX = 0;
	let gMouseDownOffsetY = 0;
	
	window.onload = function() {
		if (window.localStorage.getItem('theme-custom') != null) {
			var THEME_CUSTOM_SOURCE_MAKE = document.createElement('style');
		        THEME_CUSTOM_SOURCE_MAKE.type = 'text/css';
		        THEME_CUSTOM_SOURCE_MAKE.innerHTML = 'html.theme-custom {' + window.localStorage.getItem('theme-custom') + '}';

		    document.head.appendChild(THEME_CUSTOM_SOURCE_MAKE);
		    document.getElementsByTagName('html')[0].className += ' theme-custom';
		}
		document.getElementById('qak-script-custom-theme').remove();
	}
</script>
<script type="text/javascript">
	// try {
	// 	requestPermission();
	// } catch (exx) {}

	// function requestPermission() {
	// 	return new Promise(function(resolve, reject) {
	// 		const permissionResult = Notification.requestPermission(function(result) {
	// 			// Поддержка устаревшей версии с функцией обратного вызова.
	// 			resolve(result);
	// 		});

	// 		if (permissionResult) {
	// 			permissionResult.then(resolve, reject);					
	// 		}
	// 	}).then(function(permissionResult) {
	// 		if (permissionResult !== 'granted') {
	// 			throw new Error('Permission not granted.');
	// 		} else {
	// 			console.log('Permission granded!');
	// 			if ('serviceWorker' in navigator) {
	// 			  window.addEventListener('load', function() {
	// 			    navigator.serviceWorker.register('/assets/js/sw-notify.js').then(function(registration) {
	// 			      // Успешная регистрация
	// 			      console.log('ServiceWorker registration successful');
	// 			    }, function(err) {
	// 			      // При регистрации произошла ошибка
	// 			      console.log('ServiceWorker registration failed: ', err);
	// 			    });
	// 			  });
	// 			}
	// 		}
	// 	});
	// }
</script>
<script type="text/javascript">
	function viewPhoto(url, json, key) {
		event.stopPropagation();
		showProgressBar();
		$.ajax({type: "GET", url: "/assets/alert/view-photo.php", data: {url: url, json: json, key: key}, success: function(result) {
				hideProgressBar();
				$('body').append(result);
			}
		});
	}
</script>
<script type="text/javascript">
	function setLanguage(argument) {
		document.cookie = "lang=" + argument + "; path=/; domain=<?php echo $_SERVER['SERVER_NAME']; ?>; expires=Tue, <?php echo intval(date('d')); ?> <?php echo date('M'); ?> <?php echo intval(date('Y')+1); ?> 00:00:00 GMT";
	}
	function getLanguage() {
		return '<?php echo $_COOKIE['lang']; ?>';
	}

	function setColorScheme(argument) {
		document.cookie = "color-scheme=" + argument + "; path=/; domain=<?php echo $_SERVER['SERVER_NAME']; ?>; expires=Tue, <?php echo intval(date('d')); ?> <?php echo date('M'); ?> <?php echo intval(date('Y')+1); ?> 00:00:00 GMT";
		document.querySelector("html").className = argument;
	}
	function getColorScheme() {
		return '<?php echo $_COOKIE['color-scheme']; ?>';
	}

	function setTheme(argument) {
		document.cookie = "theme=" + argument + "; path=/; domain=<?php echo $_SERVER['SERVER_NAME']; ?>; expires=Tue, <?php echo intval(date('d')); ?> <?php echo date('M'); ?> <?php echo intval(date('Y')+1); ?> 00:00:00 GMT";
	}
	function getTheme() {
		return '<?php echo $_COOKIE['theme']; ?>';
	}

	function setIntervalM(argument) {
		document.cookie = "interval-m=" + argument + "; path=/; domain=<?php echo $_SERVER['SERVER_NAME']; ?>; expires=Tue, <?php echo intval(date('d')); ?> <?php echo date('M'); ?> <?php echo intval(date('Y')+1); ?> 00:00:00 GMT";
		window.location.reload();
	}
	function getIntervalM() {
		return '<?php echo $_COOKIE['interval-m']; ?>';
	}

	function setLoadDialogBottom(argument) {
		document.cookie = "load-dialogs-b=" + argument + "; path=/; domain=<?php echo $_SERVER['SERVER_NAME']; ?>; expires=Tue, <?php echo intval(date('d')); ?> <?php echo date('M'); ?> <?php echo intval(date('Y')+1); ?> 00:00:00 GMT";
		window.location.reload();
	}
	function getLoadDialogBottom() {
		return '<?php echo $_COOKIE['load-dialogs-b']; ?>';
	}

	function setHidePopupRec(argument) {
		document.cookie = "hide-popup-rec=" + argument + "; path=/; domain=<?php echo $_SERVER['SERVER_NAME']; ?>; expires=Tue, <?php echo intval(date('d')); ?> <?php echo date('M'); ?> <?php echo intval(date('Y')+1); ?> 00:00:00 GMT";
	}
	function getHidePopupRec() {
		return '<?php echo $_COOKIE['hide-popup-rec']; ?>';
	}
</script>
<?php if (!trim($_COOKIE['lang'])) { ?>
	<script type="text/javascript">
		setLanguage('ru');
	</script>
<?php } ?>
<?php if (!trim($_COOKIE['color-scheme'])) { ?>
	<script type="text/javascript">
		setColorScheme('theme-default-light');
	</script>
<?php } ?>
<?php if (!trim($_COOKIE['interval-m'])) { ?>
	<script type="text/javascript">
		setIntervalM(10000);
	</script>
<?php } ?>
<?php if (!trim($_COOKIE['load-dialogs-b'])) { ?>
	<script type="text/javascript">
		setLoadDialogBottom(false);
	</script>
<?php } ?>
<?php if (!trim($_COOKIE['hide-popup-rec'])) { ?>
	<script type="text/javascript">
		setHidePopupRec(false);
	</script>
<?php } ?>
<script type="text/javascript">
	(function($) {
	    $.fn.hasScrollBar = function() {
	        var e = this.get(0);
	        return {
	            vertical: e.scrollHeight > e.clientHeight,
	            horizontal: e.scrollWidth > e.clientWidth
	        };
	    }
	})(jQuery);
</script>
<script type="text/javascript">
	if (navigator.cookieEnabled) {
		
	} else {
		alert('Please, allowed cookie!');
	}
</script>