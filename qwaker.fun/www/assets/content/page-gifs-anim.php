<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/only-load.php';
?>
<?php
	$s = $_GET['s'];
	$l = $_GET['limit'];
	$key_api = 'OxJ6TQ8mW6iQOGubWXewrDz0LYTGZQSB';

	$type = 'trending';

	if (strlen($s) > 0) {
		$type = 'search';
	}

	if ($l < 1) {
		$l = 5;
	}

	$url = "http://api.giphy.com/v1/gifs/". $type ."?q=". $s ."&api_key=". $key_api ."&limit=". $limit ."&lang=". $_COOKIE['lang'];
	$result_gifs = json_decode(file_get_contents($url, false), true);
	// $result = json_encode($result_gifs['data']);
?>
<?php if (is_array($result_gifs['data'])) { ?>
	<div class="list-gifs scroll-new">
		<?php foreach($result_gifs['data'] as $key => $value) { ?>
			<?php
				$gif_url = $value['images']['original']['url'];
				$gif_static = $value['images']['fixed_height_small_still']['url'];
			?>
			<div class="item-gif" onmouseover="playGifAnim('item-gif-imag-<?php echo $value['id']; ?>', '<?php echo $gif_url; ?>')" onmouseout="playGifAnim('item-gif-imag-<?php echo $value['id']; ?>', '<?php echo $gif_static; ?>')" onclick="sendGifMessage('<?php echo $gif_static; ?>', '<?php echo $gif_url; ?>')">
				<img id="item-gif-imag-<?php echo $value['id']; ?>" src="<?php echo $gif_static; ?>">
			</div>
		<?php } ?>
	</div>
	<h3 class="message-short"><?php echo $string['message_gif_info']; ?></h3>
<?php } else { ?>
	<h2 class="message"><?php echo $string['message_no_content']; ?></h2>
<?php } ?>