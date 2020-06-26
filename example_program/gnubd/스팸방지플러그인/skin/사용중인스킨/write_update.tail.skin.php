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
 
 


/******************

스팸 로그 테스트 2019-05-02 이충희 : soullez@naver.com

--> /extend/spam_chk.extend.php 파일 추가되었습니다.
--> /테마/skin/board/스킨명/write_update.head.php 파일 추가되었습니다.

*******************/

// 글을 일단 등록하고 수정할때 악용할수도 있으므로 수정일때도 스팸 확인
if($w == "" || $w == "u") {
	
	$cap_val = "";
	$cap_chk = "";

	if ($member['mb_id']) {
		$wr_name = addslashes(clean_xss_tags($board['bo_use_name'] ? $member['mb_name'] : $member['mb_nick']));
	} else {
		// 비회원의 경우 이름이 누락되는 경우가 있음
		$wr_name = clean_xss_tags(trim($_POST['wr_name']));
	}
	
	if(get_session('ss_captcha_key')) { // 캡챠 값이 있으면 체크
		$cap_val = get_session('ss_captcha_key');
		$cap_chk = 1;
	}else{
		$cap_val = get_session('ss_captcha_key');
		$cap_chk = chk_captcha();
	}

	// 캡챠 값이 없지만 매크로가 아닌 실제 입력이면 회원으로 간주 (캡챠값이 인식이 안되는 업체가 있음)
	if(!$cap_val && $_POST['real_typing']) {
		$cap_val = "member";
		$cap_chk = 1;
	}
	
	// 관리자로 판단하여 캡챠 통과
	if($member['mb_level'] >= 8) {
		$cap_val = "admin";
		$cap_chk = 1;
	}

	$sql = " insert into {$g5['spam_log_table']}
				set sl_bo_table = '$bo_table',
					sl_confirm = '등록성공',
					sl_words = '',
					sl_filter = '',
					sl_before_site = '".get_session('referer_set_url')."',
					sl_now_site = '{$_SERVER['HTTP_REFERER']}',
					sl_content_type = '{$_SERVER['CONTENT_TYPE']}',
					sl_script_filename = '{$_SERVER['SCRIPT_FILENAME']}',
					sl_before_ip = '".get_session('remote_set_ip')."',
					sl_now_ip = '{$_SERVER['REMOTE_ADDR']}',
					sl_captcha = '".$cap_val."',
					sl_captcha_chk = '".$cap_chk."',
					sl_token = '{$_POST['token']}',
					sl_typing = '".$_POST['real_typing']."',
					sl_browser = '".@getBrowser2()."',
					sl_device = '".@MobileCheck2()."',
					sl_os = '".@getOS2()."',
					sl_staytime = '',
					sl_date = '".G5_TIME_YMD."',
					sl_time = '".G5_TIME_HIS."',
					sl_datetime = '".G5_TIME_YMDHIS."',
					bo_table = '$bo_table',
					wr_id = '$wr_id',
					wr_num = '$wr_num',
					mb_id = '{$member['mb_id']}',
					mb_name = '{$member['mb_name']}',
					wr_name = '$wr_name',
					wr_password = '$wr_password',
					wr_option = '$html,$secret,$mail',
					wr_email = '$wr_email',
					wr_subject = '$wr_subject',
					wr_content = '$wr_content',
					wr_datetime = '".G5_TIME_YMDHIS."',
					wr_ip = '{$_SERVER['REMOTE_ADDR']}',
					wr_1 = '$wr_1',
					wr_2 = '$wr_2'";
	sql_query($sql);
	$sl_idx = sql_insert_id();

	// 아이피차단 제외 체크
	$company_ip_arr = array("210.217.10.63", "119.207.79.+"); // 아이피차단에서 제외할 아이피 등록 
	
	$is_intercept_ip_cnt = 0;

	for ($i=0; $i<count($company_ip_arr); $i++) {
		$company_ip_arr[$i] = trim($company_ip_arr[$i]);
		$company_ip_arr[$i] = str_replace(".", "\.", $company_ip_arr[$i]);
		$company_ip_arr[$i] = str_replace("+", "[0-9\.]+", $company_ip_arr[$i]);
		$pat = "/^{$company_ip_arr[$i]}$/";
		$is_ipt_ip = preg_match($pat, $_SERVER['REMOTE_ADDR']);
		if($is_ipt_ip) {
			$is_intercept_ip_cnt++;
		}
	}

	// 캡챠 체크값이 없으면 스팸으로 간주
	if($member['mb_level'] < 8 && $cap_chk == "") { // 관리 권한 없는 회원 또는 비회원만 적용

		if($is_intercept_ip_cnt == 0) {
			// 스팸으로 간주하고 아이피 차단에 추가 (스팸으로 예상되는 아이피 차단 기능을 사용하지 않으려면 쿼리부분 주석처리 해주세요)
			$intercept_ip_pattern = $config['cf_intercept_ip'];
			$intercept_ip_add = trim($intercept_ip_pattern)."\n".trim($_SERVER['REMOTE_ADDR']);

			$sql = " update {$g5['config_table']}
				set 
					cf_intercept_ip = '".trim($intercept_ip_add)."'";
			sql_query($sql);

			// ip 차단 날짜 등록
			sql_query(" update {$g5['spam_log_table']} set sl_block_day = '".G5_TIME_YMD."' where sl_idx = '$sl_idx' ");
		}

		$row_mem = sql_fetch("select mb_no, mb_id from {$g5['member_table']} where mb_id = '{$member['mb_id']}'");

		// 회원가입되어있으면 탈퇴처리 (스팸으로 예상되는 아이디 삭제 기능을 사용하지 않으려면 쿼리부분 주석처리 해주세요)
		if($row_mem['mb_id'] == $member['mb_id']) {
			
			// 회원 삭제처리 
			member_delete($row_mem['mb_id']);
			
			// 메모 추가
			$sql = "update {$g5['member_table']}
							set
								mb_memo = '\n스팸 글 작성으로 인한 삭제'
						where mb_id = '{$row_mem['mb_id'] }' ";
			sql_query($sql);
			
			// 강제 로그인 해제
			// 이호경님 제안 코드
			session_unset(); // 모든 세션변수를 언레지스터 시켜줌
			session_destroy(); // 세션해제함

			// 자동로그인 해제 --------------------------------
			set_cookie('ck_mb_id', '', 0);
			set_cookie('ck_auto', '', 0);
			// 자동로그인 해제 end --------------------------------
		}
	}

}
?>