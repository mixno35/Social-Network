<?php
	$languageID = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

	$linkString = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/assets/lang/ru.json', false);
	$langTAG = 'ru-RU';

	if ($_COOKIE['lang'] == 'ru') {
		$linkString = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/assets/lang/ru.json', false);
		$langTAG = 'ru-RU';
	}

	$string = json_decode($linkString, true);

	sleep(0.1);
?>