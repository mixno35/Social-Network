<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/only-load.php';

	error_reporting(0);
?>
<!DOCTYPE html>
<html lang="<?php echo $langTAG; ?>" class="<?php echo $default_theme; ?>">
<head>
	<title><?php echo $title_docs; ?></title>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/style.php'; ?>
	<script src="https://cdn.jsdelivr.net/gh/google/code-prettify@master/loader/run_prettify.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo $default_theme_site; ?>dosc.css?v=<?php echo time(); ?>">
	<link rel="shortcut icon" href="/assets/images/qak-favicon.png" type="image/png">
	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/script.php'; ?>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/vendor/page/meta.php'; ?>
</head>
<body>

	<h2 class="title-qak-text"><?php echo $title_docs_text; ?></h2>
	<h2 class="subtitle-qak-text"><?php echo $subtitle_docs; ?></h2>

	<ul class="qak-doc-tablayout">
		<li class="qdtl" id="index" onclick="openAct(this.id)"><?php echo $action_doc_home; ?></li>
		<li class="qdtl" id="api-auth" onclick="openAct(this.id)"><?php echo $string_api_title_auth; ?></li>
	</ul>

	<hr>

	<div id="qak-doc-content">
		<?php include $_SERVER['DOCUMENT_ROOT'].'/docs/index.php'; ?>
	</div>

	<script type="text/javascript">
		function openHideContent(arguments) {
			if (document.getElementById(arguments).style.display == 'none') {
				document.getElementById(arguments).style.display = 'block';
			} else {
				document.getElementById(arguments).style.display = 'none';
			}
		}

		function openAct(argument) {
			$.ajax({
				type: "GET", 
				url:  '/docs/' + argument + '.php', 
				data: {req: 'ok'}, 
				success: function(result) {
					$('#qak-doc-content').empty();
					$('#qak-doc-content').append(result);
					updParam('act', argument);
				}
			});

			document.title = '<?php echo $title_docs; ?> | ' + document.getElementById(argument).textContent;

			var testElements = document.getElementsByClassName('qdtl');
			Array.prototype.filter.call(testElements, function(testElement){
			    document.getElementById(testElement.id).classList.remove('active');
			});
			document.getElementById(argument).classList.add('active');
		}
	</script>

	<script type="text/javascript">
		openAct('<?php echo $_GET['act']; ?>');
	</script>

	<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/design/holder.php'; ?>

</body>
</html>