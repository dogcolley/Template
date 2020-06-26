<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$g5['spam_log_table'] = "spam_log";

// 스팸 로그 테이블이 있는지 검사
if(!sql_query(" DESCRIBE {$g5['spam_log_table']} ", false)) {

	$query_sl = sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['spam_log_table']}` (
				  `sl_idx` int(11) NOT NULL AUTO_INCREMENT,
				  `sl_words` tinytext NOT NULL,
				  `sl_filter` varchar(50) NOT NULL,
				  `sl_confirm` varchar(30) NOT NULL,
				  `sl_bo_table` varchar(30) NOT NULL,
				  `sl_before_site` text NOT NULL,
				  `sl_now_site` text NOT NULL,
				  `sl_content_type` varchar(255) NOT NULL,
				  `sl_script_filename` varchar(255) NOT NULL,
				  `sl_before_ip` varchar(20) NOT NULL,
				  `sl_now_ip` varchar(20) NOT NULL,
				  `sl_captcha` varchar(20) NOT NULL,
				  `sl_captcha_chk` varchar(20) NOT NULL,
				  `sl_token` varchar(255) NOT NULL,
				  `sl_typing` longtext NOT NULL,
				  `sl_browser` text NOT NULL,
				  `sl_device` varchar(255) NOT NULL,
				  `sl_os` varchar(255) NOT NULL,
				  `sl_staytime` int(10) NOT NULL,
				  `sl_date` date NOT NULL DEFAULT '0000-00-00',
				  `sl_time` time NOT NULL DEFAULT '00:00:00',
				  `sl_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
				  `sl_block_day` date NOT NULL DEFAULT '0000-00-00',
				  `bo_table` varchar(255) NOT NULL,
				  `wr_id` int(11) NOT NULL,
				  `wr_num` int(11) NOT NULL,
				  `wr_parent` int(11) NOT NULL,
				  `mb_id` varchar(255) NOT NULL,
				  `mb_name` varchar(255) NOT NULL,
				  `wr_name` varchar(255) NOT NULL,
				  `wr_password` varchar(255) NOT NULL,
				  `wr_option` varchar(255) NOT NULL,
				  `wr_email` varchar(255) NOT NULL,
				  `wr_subject` varchar(255) NOT NULL,
				  `wr_content` longtext NOT NULL,
				  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
				  `wr_ip` varchar(20) NOT NULL,
				  `wr_1` varchar(255) NOT NULL,
				  `wr_2` varchar(255) NOT NULL,
				  PRIMARY KEY (`sl_idx`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 ", true);

}


$_referer_set_url = $_SERVER['HTTP_REFERER'];
$_remote_set_ip = $_SERVER['REMOTE_ADDR'];

if(!get_session('referer_set_url')) {
	set_session('referer_set_url', $_referer_set_url);
}
if(!get_session('remote_set_ip')) {
	set_session('remote_set_ip', $_remote_set_ip);
}

$_server_user_agent = $_SERVER['HTTP_USER_AGENT'];

function MobileCheck2() { 
	global $_server_user_agent; 
	$MobileArray  = array("iphone","lgtelecom","skt","mobile","samsung","nokia","blackberry","android","android","sony","phone");

	$checkCount = 0; 
	for($i=0; $i<sizeof($MobileArray); $i++){ 
		if(preg_match("/$MobileArray[$i]/", strtolower($_server_user_agent))){ $checkCount++; break; } 
	} 
   return ($checkCount >= 1) ? "mobile" : "pc"; 
}


function getOS2() { 

	global $_server_user_agent;

	$os_platform  = "Unknown OS Platform";

	$os_array     = array(
						  '/windows nt 10/i'      =>  'Windows 10',
						  '/windows nt 6.3/i'     =>  'Windows 8.1',
						  '/windows nt 6.2/i'     =>  'Windows 8',
						  '/windows nt 6.1/i'     =>  'Windows 7',
						  '/windows nt 6.0/i'     =>  'Windows Vista',
						  '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
						  '/windows nt 5.1/i'     =>  'Windows XP',
						  '/windows xp/i'         =>  'Windows XP',
						  '/windows nt 5.0/i'     =>  'Windows 2000',
						  '/windows me/i'         =>  'Windows ME',
						  '/win98/i'              =>  'Windows 98',
						  '/win95/i'              =>  'Windows 95',
						  '/win16/i'              =>  'Windows 3.11',
						  '/macintosh|mac os x/i' =>  'Mac OS X',
						  '/mac_powerpc/i'        =>  'Mac OS 9',
						  '/linux/i'              =>  'Linux',
						  '/ubuntu/i'             =>  'Ubuntu',
						  '/iphone/i'             =>  'iPhone',
						  '/ipod/i'               =>  'iPod',
						  '/ipad/i'               =>  'iPad',
						  '/android/i'            =>  'Android',
						  '/blackberry/i'         =>  'BlackBerry',
						  '/webos/i'              =>  'Mobile'
					);

	foreach ($os_array as $regex => $value)
		if (preg_match($regex, $_server_user_agent))
			$os_platform = $value;

	return $os_platform;
}

function getBrowser2() {

	global $_server_user_agent;

	$browser        = "Unknown Browser";

	$browser_array = array(
							'/msie/i'      => 'Internet Explorer',
							'/firefox/i'   => 'Firefox',
							'/safari/i'    => 'Safari',
							'/chrome/i'    => 'Chrome',
							'/edge/i'      => 'Edge',
							'/opera/i'     => 'Opera',
							'/netscape/i'  => 'Netscape',
							'/maxthon/i'   => 'Maxthon',
							'/konqueror/i' => 'Konqueror',
							'/mobile/i'    => 'Handheld Browser'
					 );

	foreach ($browser_array as $regex => $value)
		if (preg_match($regex, $_server_user_agent))
			$browser = $value;

	return $browser;
}
?>