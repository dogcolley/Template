<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

	include_once($board_skin_path."/add_module.php");

	$link_wr_ids = explode('|',$wr_1);
	foreach($link_wr_ids as $value){
		$link_list_arr[$cnt] = ch_list($value);
		$link_list_wrs[] = $link_list_arr[$cnt]['wr_id'];
		if($link_list_arr[$cnt]['wr_7'] == 1)alert('종료된 예약입니다.');
		ch_li($value,$link_list_arr[$cnt],$set_day);
		$ch_lt = ch_lt($link_list_arr[$cnt]['wr_id'],$set_day,$link_list_arr[$cnt]);
		if($ch_lt['rv-state'] == 'false')alert('예약가능 인원이 마감되었습니다.');
		$cnt++;
	}

	ch_myrv($link_list_wrs, $set_day); //이미 신청한 예약인지 확인하는 함수 회원
	ch_myrv2($link_list_wrs, $set_day); //이미 신청한 예약인지 확인하는 함수 비회원


	//예약가능한 기간설정
	if(ch_limo() == 'false'){
		alert('예약가능한 날이 아닙니다.','./board.php?bo_table='.$bo_table);
	}

?>