<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/only-load.php';
?>
<?php
	$url = trim($_GET['url']);
	$text = trim($_GET['text']);
	$name = trim($_GET['name']);
?>
<div id="modalContainer" onclick="closeShareAlert()">
	<div id="alertBox" onclick=" event.stopPropagation();">
		<h1><?php echo $string['title_alert_share']; ?></h1>
		<input type="text" style="margin: 15px;" value="<?php echo $url; ?>">
		<div class="list-share">
			<a href="https://vk.com/share.php?url=<?php echo rawurlencode($url); ?>" target="_blank">
				<div class="item" title="<?php echo str_replace('%1s', 'ВКонтакте', $string['tooltip_alert_share_in']); ?>">
					<img src="/assets/icons/share-vk.png">
				</div>
			</a>
			<a href="http://www.reddit.com/submit?url=<?php echo rawurlencode($url); ?>&title=<?php echo rawurlencode($text); ?>" target="_blank">
				<div class="item" title="<?php echo str_replace('%1s', 'Reddit', $string['tooltip_alert_share_in']); ?>">
					<img src="/assets/icons/share-reddit.png">
				</div>
			</a>
			<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo rawurlencode($url); ?>" target="_blank">
				<div class="item" title="<?php echo str_replace('%1s', 'Facebook', $string['tooltip_alert_share_in']); ?>">
					<img src="/assets/icons/share-facebook.png">
				</div>
			</a>
			<a href="https://twitter.com/intent/tweet?text=<?php echo rawurlencode($text); ?>&url=<?php echo rawurlencode($url); ?>&via=<?php echo rawurlencode($name); ?>" target="_blank">
				<div class="item" title="<?php echo str_replace('%1s', 'Twitter', $string['tooltip_alert_share_in']); ?>">
					<img src="/assets/icons/share-twitter.png">
				</div>
			</a>
			<a href="https://www.instagram.com/?url=<?php echo rawurlencode($url); ?>" target="_blank">
				<div class="item" title="<?php echo str_replace('%1s', 'Instagram', $string['tooltip_alert_share_in']); ?>">
					<img src="/assets/icons/share-instagram.png">
				</div>
			</a>
			<a href="https://t.me/share/url?url=<?php echo rawurlencode($url); ?>&text=<?php echo rawurlencode($text); ?>" target="_blank">
				<div class="item" title="<?php echo str_replace('%1s', 'Telegram', $string['tooltip_alert_share_in']); ?>">
					<img src="/assets/icons/share-telegram.png">
				</div>
			</a>
			<a href="https://connect.ok.ru/offer?url=<?php echo rawurlencode($url); ?>&title=<?php echo rawurlencode($text); ?>" target="_blank">
				<div class="item" title="<?php echo str_replace('%1s', 'Одноклассники', $string['tooltip_alert_share_in']); ?>">
					<img src="/assets/icons/share-ok.png">
				</div>
			</a>
			<a href="https://api.whatsapp.com/send?text=<?php echo rawurlencode($text.' '.$url); ?>" target="_blank">
				<div class="item" title="<?php echo str_replace('%1s', 'WhatsApp', $string['tooltip_alert_share_in']); ?>">
					<img src="/assets/icons/share-whatsapp.png">
				</div>
			</a>
			<a href="https://pinterest.com/pin/create/bookmarklet/?url=<?php echo rawurlencode($url); ?>&description=<?php echo rawurlencode($text); ?>" target="_blank">
				<div class="item" title="<?php echo str_replace('%1s', 'Pinterest', $string['tooltip_alert_share_in']); ?>">
					<img src="/assets/icons/share-pinterest.png">
				</div>
			</a>
			<a href="https://www.linkedin.com/shareArticle?url=<?php echo rawurlencode($url); ?>&title=<?php echo rawurlencode($text); ?>" target="_blank">
				<div class="item" title="<?php echo str_replace('%1s', 'LinkedIn', $string['tooltip_alert_share_in']); ?>">
					<img src="/assets/icons/share-linkedin.png">
				</div>
			</a>
			<a href="https://bufferapp.com/add?text=<?php echo rawurlencode($text); ?>&url=<?php echo rawurlencode($url); ?>" target="_blank">
				<div class="item" title="<?php echo str_replace('%1s', 'Buffer', $string['tooltip_alert_share_in']); ?>">
					<img src="/assets/icons/share-buffer.png">
				</div>
			</a>
			<a href="https://www.tumblr.com/share/link?url=<?php echo rawurlencode($url); ?>&name=<?php echo rawurlencode($text); ?>" target="_blank">
				<div class="item" title="<?php echo str_replace('%1s', 'Tumblr.', $string['tooltip_alert_share_in']); ?>">
					<img src="/assets/icons/share-tumblr.png">
				</div>
			</a>
			<a href="https://www.stumbleupon.com/submit?url=<?php echo rawurlencode($url); ?>&title=<?php echo rawurlencode($text); ?>" target="_blank">
				<div class="item" title="<?php echo str_replace('%1s', 'StumbleUpon', $string['tooltip_alert_share_in']); ?>">
					<img src="/assets/icons/share-stumbleupon.png">
				</div>
			</a>
			<a href="https://www.evernote.com/clip.action?url=<?php echo rawurlencode($url); ?>&title=<?php echo rawurlencode($text); ?>" target="_blank">
				<div class="item" title="<?php echo str_replace('%1s', 'Evernote', $string['tooltip_alert_share_in']); ?>">
					<img src="/assets/icons/share-evernote.png">
				</div>
			</a>
		</div>

		<h3 class="message-short"><?php echo $string['message_alert_share']; ?></h3>
	</div>

	<script type="text/javascript">
		function closeShareAlert() {
			document.getElementById('modalContainer').remove();
		}
	</script>
</div>