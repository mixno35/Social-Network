<?php
	include $_SERVER['DOCUMENT_ROOT'].'/assets/preferences.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/default.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/connect.php';
	include $_SERVER['DOCUMENT_ROOT'].'/vendor/only-load.php';
?>
<?php
	$id = $_GET['id'];

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

	function showDate($date) {
		include $_SERVER['DOCUMENT_ROOT'].'/vendor/lang.php';

		$stf = 0;
		$cur_time = time();
		$diff = $cur_time - $date;
		 
		$seconds = array($string_time_second_1, $string_time_second_2, $string_time_second_3);
		$minutes = array($string_time_minute_1, $string_time_minute_2, $string_time_minute_3);
		$hours = array($string_time_hour_1, $string_time_hour_2, $string_time_hour_3);
		$days = array($string_time_day_1, $string_time_day_2, $string_time_day_3);
		$weeks = array($string_time_week_1, $string_time_week_2, $string_time_week_3);
		$months = array($string_time_month_1, $string_time_month_2, $string_time_month_3);
		$years = array($string_time_year_1, $string_time_year_2, $string_time_year_3);
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
		 
		return $value . 'назад';
	}

	function getPhrase($number, $titles) {
		$cases = array(2, 0, 1, 1, 1, 2);
	 
		return $titles[($number%100 > 4 && $number % 100 < 20 ) ? 2 : $cases[min($number % 10, 5)]];
	}
?>
<?php
	$url_data = $default_api.'/user/data.php?id='.$id.'&token='.$_COOKIE['USID'];
	$result_user = json_decode(file_get_contents($url_data, false), true);
?>
<ol class="popup arrow user-view" id="view-user">
	<center>
		<img src="<?php echo $result_user['avatar']; ?>" onerror="this.src = '/assets/images/qak-avatar-v2.png'">
		<h2>
			<?php echo $result_user['login']; ?>
			<?php if (intval($result_user['user_verification']) == 1) { ?>
				<verification-user style="position: absolute;margin-top: 5px;margin-left: 4px;"></verification-user>
			<?php } ?>
		</h2>
		<h3>
			<?php if (userOnline($result_user['online'])) { ?>
				<?php echo $string_message_online; ?>
			<?php } else { ?>
				<?php echo $string_message_offline.' '.showDate($result_user['online']); ?>
			<?php }  ?>
		</h3>
		<button class="border"><?php echo $action_go_to_profile; ?></button>
	</center>
</ol>