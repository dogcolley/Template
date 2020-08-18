<?php
include_once('./_common.php');

$sql = " SELECT cf_nct_sms_use,cf_nct_sms_id, cf_nct_sms_key,cf_nct_sms_num, cf_nct_sms_sendnum FROM {$g5['config_table']}  ";
$uplus_sms = sql_fetch($sql);

$sql = "select mta_key, mta_value from g5_5_meta where mta_db_table = 'board/".$bo_table."' and mta_db_id = 'sms_setting' order by mta_idx desc";
$result = sql_query($sql);


for ($i=0; $row=sql_fetch_array($result); $i++)
	$config_set[$row["mta_key"]] = $row["mta_value"];

/*
$chk_id = $_POST['chk_id'];
*/

/*
$chkarr = @explode(",", $chk_id);
$_POST['chk_wr_id'] = $chkarr;
*/

/*
if ($sms_wr_id) 
	$tmp_array[0] = $sms_wr_id;
else 
	$tmp_array = $_POST['chk_wr_id'];

$chk_count = count($tmp_array);


// 지난 날짜는 문자 발송 패스
for ($i=$chk_count-1; $i>=0; $i--)
{
	$row = sql_fetch(" select wr_id, mb_id, ca_name, wr_name, wr_2, wr_3, wr_4, wr_5, wr_6, wr_7 from $write_table where wr_id = '".$tmp_array[$i]."' order by wr_id ");
}
*/


/*
$timenow = date("Y-m-d"); 
$timetarget = $row['wr_2'];

$str_now = strtotime($timenow);
$str_target = strtotime($timetarget);

if($str_now <= $str_target) { // 지난 날짜는 문자 발송 건너뜀
*/	
/*
}
*/


/** sms 발송 **/
if($config_set['pn_pg_sms_use']==1 && $uplus_sms['cf_nct_sms_use']=='uplus') {

	if($uplus_sms['cf_nct_sms_use']=='uplus'){
		//sms 인증키
		$use_smsid = $uplus_sms['cf_nct_sms_id']; // SMSID
		$use_smskey = $uplus_sms['cf_nct_sms_key']; // SMSkey
	}

	//관리자 문자 발송
	$send_hp_mb = $uplus_sms['cf_nct_sms_num']; // 사전등록번호
	$admin_hp_mb = $uplus_sms['cf_nct_sms_sendnum']; // 관리자 전화번호

	$sql = " select * from $write_table where wr_id = '".$wr_id."' ";

	$result = sql_fetch($sql);
	

	$message_con = "";
	$sms_message = "";

	$use_hp_mb = $result['wr_3']; // 사용자 전화번호

	$send_hp = str_replace("-","",$send_hp_mb); // - 제거
	$admin_hp = str_replace("-","",$admin_hp_mb); // - 제거
	$use_hp = str_replace("-","",$use_hp_mb); // - 제거

	$send_number =  $send_hp; // 사전등록번호
	$admin_number =  $admin_hp; // 관리자 전화번호
	$use_number = $use_hp; // 사용자 전화번호

	//소켓통신
	$info = parse_url("http://sms.nccj.kr/api/remind_count/".$use_smsid."/".$use_smskey);
	$fp = fsockopen($info['host'], 80);

	if($fp){
		$remindCountResult = "0";
		$parm = "";
		$send = "POST " . $info["path"] . " HTTP/1.1\r\n"
		."Host: " . $info["host"] . "\r\n"
		. "Content-type: application/x-www-form-urlencoded\r\n"
		. "Content-length: " . strlen($parm) . "\r\n"
		. "Connection: close\r\n\r\n" . $parm."\r\n";

		fputs($fp, $send);

		while(!feof($fp)) $remindCountResult = fgets($fp, 128);

		$remindResult = json_decode($remindCountResult);
		$remindCount = $remindResult->remind_count;
	}

	//예약시 관리자 sms 전송
	if($use_smsid && $use_smskey && $remindCount>0) {
	
		if($sms_type == "예약대기") {
			
			if($config_set[pn_sms_reserv_ready_adm] == 1) {
				$message_con = str_replace("{name}", $result['wr_name'], $config_set['pn_sms_reserv_ready_adm_info']);
				$message_con = str_replace("{type}", $result['wr_subject'], $message_con);
				$sms_message = str_replace("{date}", $result['wr_2'], $message_con);
			}

		}
		if($sms_type == "예약완료") {
			
			if($config_set[pn_sms_reserv_comp_adm] == 1) {
				$message_con = str_replace("{name}", $result['wr_name'], $config_set['pn_sms_reserv_comp_adm_info']);
				$message_con = str_replace("{type}", $result['wr_subject'], $message_con);
				$sms_message = str_replace("{date}", $result['wr_2'], $message_con);
			}

		}
		if($sms_type == "취소요청") {
			
			if($config_set[pn_sms_reserv_canc_adm] == 1) {
				$message_con = str_replace("{name}", $result['wr_name'], $config_set['pn_sms_reserv_canc_adm_info']);
				$message_con = str_replace("{type}", $result['wr_subject'], $message_con);
				$sms_message = str_replace("{date}", $result['wr_2'], $message_con);
			}

		}
		if($sms_type == "취소완료") {
			
			if($config_set[pn_sms_reserv_canc_cplt_adm] == 1) {
				$message_con = str_replace("{name}", $result['wr_name'], $config_set['pn_sms_reserv_canc_cplt_adm_info']);
				$message_con = str_replace("{type}", $result['wr_subject'], $message_con);
				$sms_message = str_replace("{date}", $result['wr_2'], $message_con);
			}

		}
		
		/* 이부분 주석을 풀어줘야지 동작을함
		if($sms_message){
			$info = @parse_url("http://sms.nccj.kr/api/pension");
			$fp = @fsockopen($info['host'], 80);

			if($fp){
				//$parm = "callbackHp=".$send_number."&smsHp=".$admin_number."&smsId=".$use_smsid."&encCode=".$use_smskey."&receiveContent=".$sms_message;
				$parm = "callbackHp=".$admin_number."&smsHp=".$send_number."&smsId=".$use_smsid."&encCode=".$use_smskey."&receiveContent=".$sms_message;
				//echo $parm;
				$send = "POST " . $info["path"] . " HTTP/1.1\r\n"
				."Host: " . $info["host"] . "\r\n"
				. "Content-type: application/x-www-form-urlencoded\r\n"
				. "Content-length: " . strlen($parm) . "\r\n"
				. "Connection: close\r\n\r\n" . $parm."\r\n";

				@fputs($fp, $send);
			}
		}
		*/
	}

	//예약시 사용자 sms 전송
	if($use_smsid && $use_smskey && $remindCount>0){

		if($sms_type == "예약대기") {
			
			if($config_set[pn_sms_reserv_ready_user] == 1) {
				$message_con = str_replace("{name}", $result['wr_name'], $config_set['pn_sms_reserv_ready_user_info']);
				$message_con = str_replace("{type}", $result['wr_subject'], $message_con);
				$sms_message = str_replace("{date}", $result['wr_2'], $message_con);
			}

		}
		if($sms_type == "예약완료") {
			
			if($config_set[pn_sms_reserv_comp_user] == 1) {
				$message_con = str_replace("{name}", $result['wr_name'], $config_set['pn_sms_reserv_comp_user_info']);
				$message_con = str_replace("{type}", $result['wr_subject'], $message_con);
				$sms_message = str_replace("{date}", $result['wr_2'], $message_con);
			}

		}
		if($sms_type == "취소요청") {
			
			if($config_set[pn_sms_reserv_canc_user] == 1) {
				$message_con = str_replace("{name}", $result['wr_name'], $config_set['pn_sms_reserv_canc_user_info']);
				$message_con = str_replace("{type}", $result['wr_subject'], $message_con);
				$sms_message = str_replace("{date}", $result['wr_2'], $message_con);
			}

		}
		if($sms_type == "취소완료") {
			
			if($config_set[pn_sms_reserv_canc_cplt_user] == 1) {
				$message_con = str_replace("{name}", $result['wr_name'], $config_set['pn_sms_reserv_canc_cplt_user_info']);
				$message_con = str_replace("{type}", $result['wr_subject'], $message_con);
				$sms_message = str_replace("{date}", $result['wr_2'], $message_con);
			}

		}
		/* 실제로보는기능은 주석을 풀어줘야 동작함
		if($sms_message){
			$info = @parse_url("http://sms.nccj.kr/api/pension");
			$fp = @fsockopen($info['host'], 80);
		
			if($fp){
				$parm = "callbackHp=".$admin_number."&smsHp=".$use_number."&smsId=".$use_smsid."&encCode=".$use_smskey."&receiveContent=".$sms_message;
				//echo $parm;
				$send = "POST " . $info["path"] . " HTTP/1.1\r\n"
				."Host: " . $info["host"] . "\r\n"
				. "Content-type: application/x-www-form-urlencoded\r\n"
				. "Content-length: " . strlen($parm) . "\r\n"
				. "Connection: close\r\n\r\n" . $parm."\r\n";

				@fputs($fp, $send);

			}
		}
		*/

	}

}
?>