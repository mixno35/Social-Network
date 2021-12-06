<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/only-load.php';
?>
<?php
	function getLanguageSite() {
		include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';

		switch ($_COOKIE['lang']) {
			case 'en':
				return $string['setting_language_en'];
			case 'ru':
				return $string['setting_language_ru'];
			
			default:
				return $string['setting_language_en'];
		}
	}
?>
<?php
	function getColorSchemeSite() {
		include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';

		switch ($_COOKIE['color-scheme']) {
			case 'theme-default-dark':
				return $string['setting_color_scheme_dark'];
			case 'theme-default-light':
				return $string['setting_color_scheme_light'];
			
			default:
				return $string['setting_color_scheme_light'];
		}
	}
?>
<?php
	function getIntervalM() {
		switch ($_COOKIE['interval-m']) {
			case 10000:
				return '10s';
			case 9000:
				return '9s';
			case 8000:
				return '8s';
			case 7000:
				return '7s';
			case 6000:
				return '6s';
			case 5000:
				return '5s';
			case 4000:
				return '4s';
			case 3000:
				return '3s';
			case 2000:
				return '2s';
			case 1000:
				return '1s';
			
			default:
				return '10s';
		}
	}
?>
<?php
	function getLoadDialogsBottom() {
		include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';

		switch ($_COOKIE['load-dialogs-b']) {
			case 'true':
				return $string['text_true_on'];
			case 'false':
				return $string['text_false_off'];
			
			default:
				return $string['text_false_off'];
		}
	}
?>
<div class="qak-alert-container" id="qak-alert-container-settings">
	<div class="qak-alert-container-holder">
		<h2 class="qak-alert-container-holder-title"><?php echo $string['title_settings']; ?></h2>
		<div class="qak-alert-close" onclick="document.getElementById('qak-alert-container-settings').remove()"></div>
		
		<div class="qak-alert-settings-container">
			<div class="qak-alert-container-settings-item">
				<div class="v1-settings">
					<h1><?php echo $string['setting_title_language']; ?></h1>
					<h2><?php echo $string['setting_message_language']; ?></h2>
				</div>
				<div class="v2-settings">
					<button id="settings-lang-content" class="border" onclick="showMenu('settings-lang-content-popup')">
						<?php echo getLanguageSite(); ?>
						<olx class="popup center" style="display: none;" id="settings-lang-content-popup">
							<div class="container">
								<li class="<?php if($_COOKIE['lang']=='ru'){echo'selected';} ?>" onclick="chooseLanguage('ru')"><?php echo $string['setting_language_ru']; ?></li>
								<!-- <li class="<?php if($_COOKIE['lang']=='en'){echo'selected';} ?>" onclick="chooseLanguage('en')"><?php echo $string['setting_language_en']; ?></li> -->
							</div>
						</olx>
					</button>
				</div>
			</div>

			<hr class="qak-alert-archive-divider">

			<div class="qak-alert-container-settings-item">
				<div class="v1-settings">
					<h1><?php echo $string['setting_title_color_scheme']; ?></h1>
					<h2><?php echo $string['setting_message_color_scheme']; ?></h2>
				</div>
				<div class="v2-settings">
					<button id="settings-lang-content" class="border" onclick="showMenu('settings-lang-content-popup-2')">
						<?php echo getColorSchemeSite(); ?>
						<olx class="popup center" style="display: none;" id="settings-lang-content-popup-2">
							<div class="container">
								<li class="<?php if($_COOKIE['color-scheme']=='theme-default-dark'){echo'selected';} ?>" onclick="chooseColorScheme('theme-default-dark')"><?php echo $string['setting_color_scheme_dark']; ?></li>
								<li class="<?php if($_COOKIE['color-scheme']=='theme-default-light'){echo'selected';} ?>" onclick="chooseColorScheme('theme-default-light')"><?php echo $string['setting_color_scheme_light']; ?></li>
							</div>
						</olx>
					</button>
				</div>
			</div>

			<hr class="qak-alert-archive-divider">

			<div class="qak-alert-container-settings-item">
				<div class="v1-settings">
					<h1><?php echo $string['setting_title_user_extract']; ?></h1>
					<h2><?php echo $string['setting_message_user_extract']; ?></h2>
				</div>
				<div class="v2-settings">
					<button id="settings-extract-content" class="border" onclick="getExtract()">
						<?php echo $string['setting_action_extract']; ?>
					</button>
				</div>
			</div>

			<hr class="qak-alert-archive-divider">

			<div class="qak-alert-container-settings-item">
				<div class="v1-settings">
					<h1><?php echo $string['setting_title_interval_upd_messages']; ?></h1>
					<h2><?php echo $string['setting_message_interval_upd_messages']; ?></h2>
				</div>
				<div class="v2-settings">
					<button id="settings-lang-content" class="border" onclick="showMenu('settings-lang-content-popup-3')">
						<?php echo getIntervalM(); ?>
						<olx class="popup center" style="display: none;" id="settings-lang-content-popup-3">
							<div class="container">
								<li class="<?php if($_COOKIE['interval-m']==10000){echo'selected';} ?>" onclick="setIntervalM(10000)">10s</li>
								<li class="<?php if($_COOKIE['interval-m']==9000){echo'selected';} ?>" onclick="setIntervalM(9000)">9s</li>
								<li class="<?php if($_COOKIE['interval-m']==8000){echo'selected';} ?>" onclick="setIntervalM(8000)">8s</li>
								<li class="<?php if($_COOKIE['interval-m']==7000){echo'selected';} ?>" onclick="setIntervalM(7000)">7s</li>
								<li class="<?php if($_COOKIE['interval-m']==6000){echo'selected';} ?>" onclick="setIntervalM(6000)">6s</li>
								<li class="<?php if($_COOKIE['interval-m']==5000){echo'selected';} ?>" onclick="setIntervalM(5000)">5s</li>
								<li class="<?php if($_COOKIE['interval-m']==4000){echo'selected';} ?>" onclick="setIntervalM(4000)">4s</li>
								<li class="<?php if($_COOKIE['interval-m']==3000){echo'selected';} ?>" onclick="setIntervalM(3000)">3s</li>
								<li class="<?php if($_COOKIE['interval-m']==2000){echo'selected';} ?>" onclick="setIntervalM(2000)">2s</li>
								<li class="<?php if($_COOKIE['interval-m']==1000){echo'selected';} ?>" onclick="setIntervalM(1000)">1s</li>
							</div>
						</olx>
					</button>
				</div>
			</div>

			<hr class="qak-alert-archive-divider">

			<div class="qak-alert-container-settings-item">
				<div class="v1-settings">
					<h1><?php echo $string['setting_title_load_dialogs_bottom']; ?></h1>
					<h2><?php echo $string['setting_message_load_dialogs_bottom']; ?></h2>
				</div>
				<div class="v2-settings">
					<button id="settings-extract-content" class="border" onclick="showMenu('settings-load-d-b-content-popup')">
						<?php echo getLoadDialogsBottom(); ?>
						<olx class="popup center" style="display: none;" id="settings-load-d-b-content-popup">
							<div class="container">
								<li class="<?php if($_COOKIE['load-dialogs-b']=='true'){echo'selected';} ?>" onclick="chooseLoadDialogBottom(true)"><?php echo $string['text_true_on']; ?></li>
								<li class="<?php if($_COOKIE['load-dialogs-b']=='false'){echo'selected';} ?>" onclick="chooseLoadDialogBottom(false)"><?php echo $string['text_false_off']; ?></li>
							</div>
						</olx>
					</button>
				</div>
			</div>
		</div>

		<script type="text/javascript">
			function chooseLanguage(argument) {
				setLanguage(argument);
				window.location.reload();
			}

			function chooseLoadDialogBottom(argument) {
				setLoadDialogBottom(argument);
				window.location.reload();
			}

			function chooseColorScheme(argument) {
				setColorScheme(argument);
				document.getElementById('qak-alert-container-settings').remove();
			}

			function getExtract() {
				document.getElementById('settings-extract-content').textContent = stringOBJ['setting_action_extracting'];
				document.getElementById('settings-extract-content').disabled = true;

				$.ajax({
					type: "POST", 
					url: "<?php echo $default_api; ?>/user/extract.php", 
					data: {
						token: '<?php echo $_COOKIE['USID']; ?>'
					}, 
			    	success: function(result){
						var jsonOBJ = JSON.parse(result);
						document.getElementById('settings-extract-content').textContent = stringOBJ['setting_action_extract'];
						document.getElementById('settings-extract-content').disabled = false;
						
						alert(jsonOBJ['message']);
					}
				});
			}
		</script>

		<h2 class="qak-alert-container-holder-title-bottom-message">
			<?php echo $string['message_settings']; ?>
		</h2>
	</div>
</div>