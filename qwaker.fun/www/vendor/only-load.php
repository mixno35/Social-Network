<?php
	function convertTimeRus($originalDate) {
		include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';

		$day = date("d", strtotime($originalDate));
		$mounth = date("m", strtotime($originalDate));
		$year = date("Y", strtotime($originalDate));
		$hour = date("H", strtotime($originalDate));
		$minute = date("i", strtotime($originalDate));
		$second = date("s", strtotime($originalDate));

		$result_mounth = $string['short_text_month_1'];

		switch ($mounth) {
			case '01':
				$result_mounth = $string['short_text_month_1'];
				break;
			case '02':
				$result_mounth = $string['short_text_month_2'];
				break;
			case '03':
				$result_mounth = $string['short_text_month_3'];
				break;
			case '04':
				$result_mounth = $string['short_text_month_4'];
				break;
			case '05':
				$result_mounth = $string['short_text_month_5'];
				break;
			case '06':
				$result_mounth = $string['short_text_month_6'];
				break;
			case '07':
				$result_mounth = $string['short_text_month_7'];
				break;
			case '08':
				$result_mounth = $string['short_text_month_8'];
				break;
			case '09':
				$result_mounth = $string['short_text_month_9'];
				break;
			case '10':
				$result_mounth = $string['short_text_month_10'];
				break;
			case '11':
				$result_mounth = $string['short_text_month_11'];
				break;
			case '12':
				$result_mounth = $string['short_text_month_12'];
				break;
			
			default:
				$result_mounth = $string['short_text_month_1'];
				break;
		}

		return $day . ' ' . $result_mounth . ' ' . $year . ' ' . $hour . ':' . $minute;
	}

	function convertTimeSecRus($originalDate) {
		include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
		
		$day = date("d", strtotime($originalDate));
		$mounth = date("m", strtotime($originalDate));
		$year = date("Y", strtotime($originalDate));
		$hour = date("H", strtotime($originalDate));
		$minute = date("i", strtotime($originalDate));
		$second = date("s", strtotime($originalDate));

		switch ($mounth) {
			case '01':
				$mounth = $string['short_text_month_1'];
				break;
			case '02':
				$mounth = $string['short_text_month_2'];
				break;
			case '03':
				$mounth = $string['short_text_month_3'];
				break;
			case '04':
				$mounth = $string['short_text_month_4'];
				break;
			case '05':
				$mounth = $string['short_text_month_5'];
				break;
			case '06':
				$mounth = $string['short_text_month_6'];
				break;
			case '07':
				$mounth = $string['short_text_month_7'];
				break;
			case '08':
				$mounth = $string['short_text_month_8'];
				break;
			case '09':
				$mounth = $string['short_text_month_9'];
				break;
			case '10':
				$mounth = $string['short_text_month_10'];
				break;
			case '11':
				$mounth = $string['short_text_month_11'];
				break;
			case '12':
				$mounth = $string['short_text_month_12'];
				break;
			
			default:
				$mounth = $string['short_text_month_1'];
				break;
		}

		return $day . ' ' . $mounth . ' ' . $year . ' ' . $hour . ':' . $minute . ':' . $second;
	}

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

	function showDateOnlineUser($date) {
		include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';

		$stf = 0;
		$cur_time = time();
		$diff = $cur_time - $date;
		 
		$seconds = array($string['time_second_1'], $string['time_second_2'], $string['time_second_3']);
		$minutes = array($string['time_minute_1'], $string['time_minute_2'], $string['time_minute_3']);
		$hours = array($string['time_hour_1'], $string['time_hour_2'], $string['time_hour_3']);
		$days = array($string['time_day_1'], $string['time_day_2'], $string['time_day_3']);
		$weeks = array($string['time_week_1'], $string['time_week_2'], $string['time_week_3']);
		$months = array($string['time_month_1'], $string['time_month_2'], $string['time_month_3']);
		$years = array($string['time_year_1'], $string['time_year_2'], $string['time_year_3']);
		// $decades = array( 'десятилетие', 'десятилетия', 'десятилетий' );
		 
		$phrase = array($seconds, $minutes, $hours, $days, $weeks, $months, $years);
		$length = array(1, 60, 3600, 86400, 604800, 2630880, 31570560);
		 
		for ($i = sizeof($length) - 1; ($i >= 0) && (($no = $diff/$length[ $i ]) <= 1 ); $i --) {
			;
		}
		if ($i < 0) {
			$i = 0;
		}
		$_time = $cur_time - ($diff % $length[$i]);
		$no = floor($no);
		$value = sprintf("%d %s ", $no, getPhrase($no, $phrase[ $i ]));
		 
		if (($stf == 1) && ($i >= 1) && (($cur_time - $_time) > 0)) {
			$value .= time_ago($_time);
		}
		 
		return $value . $string['time_ago'];
	}

	function getPhrase($number, $titles) {
		$cases = array(2, 0, 1, 1, 1, 2);
	 
		return $titles[($number%100 > 4 && $number % 100 < 20 ) ? 2 : $cases[min($number % 10, 5)]];
	}
?>