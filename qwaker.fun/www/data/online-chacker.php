<?php
	function userOnline($time) {
		// +- 1 MIN.
		$timeGet = time();
		$timeResult1 = $time - 60;
		$timeResult2 = $time + 60;
		if ($timeGet <= $timeResult2 and $timeGet > $timeResult1) {
			return true;
		} else {
			return false;
		}
	}
?>