<?php
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
	// error_reporting(0);

	$serverTIME = date('Y-m-d H:i:s');
	$userLANGUAGE = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
	$userIP = strval("128.0.0.1");
	$userIPREAL = strval($_SERVER['REMOTE_ADDR']);
	$userHOST = strval($_SERVER['REMOTE_HOST']);
	$userMETHOD = strval($_SERVER['REQUEST_METHOD']);
	$useragent = $_SERVER['HTTP_USER_AGENT'];
	$domain = $_SERVER['SERVER_NAME'];
	$timeUSER = intval(time());
	$emailSENDER = 'no-reply@qwaker.fun';
	$defaultDOMAIN = 'https://qwaker.fun';
	$defaultDOMAINSTORAGE_START = 'api.';
	$defaultDOMAINSTORAGE_END = 'sun.';
	$defaultDOMAINSTORAGE_URL = 'https://sun.qwaker.net';
?>