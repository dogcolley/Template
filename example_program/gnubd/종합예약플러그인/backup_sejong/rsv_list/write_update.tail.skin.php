<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
 
//print_r2($_POST);
 
//-- 필드명 추출 wr_ 와 같은 앞자리 3자 추출 --//
$r = sql_query(" desc {$write_table} ");
while ( $d = sql_fetch_array($r) ) {$db_fields[] = $d['Field'];}
$db_prefix = substr($db_fields[0],0,3);
 
//-- 체크박스 값이 안 넘어오는 현상 때문에 추가, 폼의 체크박스는 모두 배열로 선언해 주세요.
$checkbox_array=array();
for ($i=0;$i<sizeof($checkbox_array);$i++) {
	if(!$_REQUEST[$checkbox_array[$i]])
		$_REQUEST[$checkbox_array[$i]] = 0;
}
 
//-- 메타 입력 (디비에 있는 설정된 값은 입력하지 않는다.) --//
$db_fields[] = "mb_zip";	// 건너뛸 변수명은 배열로 추가해 준다.
$db_fields[] = "mb_sido_cd";	// 건너뛸 변수명은 배열로 추가해 준다.
foreach($_REQUEST as $key => $value ) {
	//-- 해당 테이블에 있는 필드 제외하고 테이블 prefix 로 시작하는 변수들만 업데이트 --//
	if(!in_array($key,$db_fields) && substr($key,0,3)==$db_prefix) {
		echo $key."=".$_REQUEST[$key]."<br>";
		meta_update(array("mta_db_table"=>"board/".$bo_table,"mta_db_id"=>$wr_id,"mta_key"=>$key,"mta_value"=>$value));
	}
}
//exit;
//이업체 특이사항 2개의 여분 필드 정보 및 실크릿값 고정
$sql = " UPDATE {$write_table} SET wr_12 = '{$wr_12}' , wr_13 = '{$wr_13}',wr_option = 'secret' WHERE wr_id = '{$wr_id}' ";
sql_query($sql);
/* 비밀번호를 휴대폰 번호로 암호화 */
/* 이름도 관리자가 대리로 작성할 경우가 있으니 입력한 이름 그대로 저장 */
if($ca_name != "공지") {
	$wr_password = get_encrypt_string($wr_4);

	$sql = " UPDATE {$write_table} SET wr_password = '{$wr_password}' WHERE wr_id = '{$wr_id}' ";
	sql_query($sql);

	$sql2 = " UPDATE {$write_table} SET wr_name = '{$_POST[wr_name]}' WHERE wr_id = '{$wr_id}' ";
	sql_query($sql2);
	

	// 신청 시 sms 문자 발송
	$sms_type = "예약대기";
	$sms_wr_id = $wr_id;
	$wr_name = $_POST['wr_name'];
	@include_once($board_skin_path."/sms_chk_update.skin.php");

}


 
?>
