<?php
	function normJsonStr($str){
	    $str = preg_replace_callback('/\\\\u([a-f0-9]{4})/i', create_function('$m', 'return chr(hexdec($m[1])-1072+224);'), $str);
	    return iconv('cp1251', 'utf-8', $str);
	}

	function checkIP($ip='') {
		$check_ip = explode('.', $ip);
		$user_ip = explode('.', $_SERVER['REMOTE_ADDR']);
		for ($i = 0; $i < 4; $i++){
		    if (($check_ip[$i] == $user_ip[$i]) OR $check_ip[$i] == "*") { 
		    	return true;
		    } else {
		    	return false;
		    }
		}
	}
?>