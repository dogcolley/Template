<?
/*
20200428 장석환

#일반 그누보드에도 붙일수있게 확장성을 고려해서 만듬
#해당게시판이 메인, 추가로 여러 게시판을 기능을 사용해서묶어서 사용하는 용도, 해당파일같은 단일 컴먼을사용
#따로 메타 태그 사용없이 bo_여분 / wr_여분 등의 여분필드로 최소한 사용함
#대부분 함수형제어

bo_1 연동게시판
bo_2 예약가능기간 설정 
bo_3 충복 기능 활/비 기능
bo_4 공휴일설정

wr_1 wr_id
wr_2 예약일시
wr_3 연락처
wr_4 예약상태

*/


$week = array("일" , "월"  , "화" , "수" , "목" , "금" ,"토") ;
if($set_day){
	$info_arr = explode('-',$set_day);
	$year = $info_arr[0];
	$month = $info_arr[1];
	$day = $info_arr[2];
}
if(!$year)$year = date('Y'); // 4자리 연도
if(!$month)$month = sprintf('%02d',date('n')); // 0을 포함하지 않는 월
if(!$day)$day = sprintf('%02d',date('d')); // 0을 포함하지 않는 월
$set_day = $year.'-'.$month.'-'.$day;
$today = date("Y-m-d");
if(!$date)$date = $week[ date('w'  , strtotime($set_day)  )];  // 0을 포함하지 않는 월


$nextDay = date('Y-m-d', strtotime('+1 day', strtotime($set_day)));
$nextDayArr = explode("-", $nextDay);
$prevDay = date('Y-m-d', strtotime('-1 day', strtotime($set_day)));
$prevDayArr = explode("-", $prevDay);
$prev_month = $month - 1;
$next_month = $month + 1;
$prev_year = $next_year = $year;
if ($month == 1) {
    $prev_month = 12;
    $prev_year = $year - 1;
} else if ($month == 12) {
    $next_month = 1;
    $next_year = $year + 1;
}

$prev_month = $prev_month < 10? '0'.$prev_month: $prev_month;
$next_month = $next_month < 10? '0'.$next_month: $next_month;
$preyear = $year - 1;
$nextyear = $year + 1;

$link_table = $board['bo_1'];
$link_table_list = $g5['write_prefix'].$link_table;
$link_table_info = sql_fetch('select * from '.$g5['board_table'].' where bo_table = "'.$link_table.' "');
$limit_time = $board['bo_2'];
$write_table = $g5['write_prefix'].$bo_table;
$list_url = G5_BBS_URL.'/board.php?bo_table='.$bo_table;
$err_url = $list_url;

if($board['bo_4']){
$link_hd = $board['bo_4'];
$link_hd_list = $g5['write_prefix'].$board['bo_4'];
$link_hd_info = sql_fetch('select * from '.$g5['board_table'].' where bo_table = "'.$link_hd_list.'	"');
}

if ($is_admin == "super" || $is_admin == "group" || $member['mb_id'] == 'admin' || $member['mb_id'] == $board['bo_admin']) {
	$is_admin2 = true;
}

//예약리스트 가져오기
function ch_lists($set_day, $date){
	global $link_table_list;
	$sql = "select * from ".$link_table_list." WHERE
	 wr_7 != '1' AND (
	 (wr_3 = 'week' AND wr_4 like '%".$date."%' ) ||
	  (wr_3 = 'oneday' AND wr_4 = '".$set_day."') ||
	   (wr_3 = 'term' AND wr_5 >= str_to_date('".$set_day."', '%Y-%m-%d') AND wr_4 <= str_to_date('".$set_day."', '%Y-%m-%d') )
	   )
		order by wr_id
	";

	$qry = sql_query($sql);
	for($i=0; $row=sql_fetch_array($qry); $i++){
		$arr[$i] = $row;
	}
	return $arr;
}

//휴일리스트 가져오기
function hd_lists($mode='all'){

	global $link_hd_list;
	global $year;
	global $month;
	global $day;
	global $set_day;
	
	if($mode == 'month')
		$sql_ch = "wr_1 like '%".$year."-".$month."%' AND wr_2 = '' ";
	else if($mode == 'day')
		$sql_ch = "wr_1 = '".$set_day."'";
	else
		$sql_ch = "wr_2 != ''";


	$sql = "select ca_name,wr_subject,wr_1,wr_2,wr_content from ".$link_hd_list." WHERE ".$sql_ch;
	$qry = sql_query($sql);

	$day_all = false;
	for($i=0; $row=sql_fetch_array($qry); $i++){
		if($mode == 'month'){
			$day_arr = explode('-',$row['wr_1']);
			$set_arr = $day_arr[2];
		}else{
			$set_arr = $i;
		}
		$arr[$set_arr] = $row;
		$day_hd = 'false';
		if(!$row['wr_2'] && $mode == 'day'){
			$day_all = true;
			$arr2[] =  $row['wr_content'];
			$arr3[] = $row['wr_subject'];
			if($row['ca_name'] !== '공지')$day_hd = 'true'; 
		} 
		
	}
	
	if($day_all){
		$arr['range']= 'all';
		$arr['state']= $day_hd;
		$arr['allMage'] = $arr2;
		$arr['allTit'] = $arr3;
	}
	


	return $arr;
}


//인원 예약인원 노출 (누가누가 예약했을까요?)
function ch_member($wr_id){
	global $link_table_list;
	global $write_table;
	global $set_day;
	global $g5;

	$sql = "select wr_name,wr_id,wr_1,wr_6 from ".$write_table." where wr_1 like '%".$wr_id."%' AND wr_2 = '".$set_day."' AND wr_4 != '예약취소' ";
	$qry = sql_query($sql);
	

	for($i=0; $row=sql_fetch_array($qry); $i++){
		$arr =  explode('|',$row['wr_1']);
		for($i=0;$i < count($arr); $i++){
			if($arr[$i] == $wr_id) {
				$arr_rs[] = $row;
			}
		}
	}
	return $arr_rs;
}

//예약가능여부 (바른예약일 선택했는지 필터링하는 함수)
function ch_li($wr_id,$item,$set_day){
	global $link_table_list;
	global $date;
	global $bo_table;
	global $is_member;
	global $member;
	global $g5;

	//아이템에 관한 정보가 없다면 정보를 담아주면 됩니다.
	if(!$item){
		$sql = "select * from ".$link_table_list." where wr_id= '".$wr_id."'";
		$item = sql_fetch($sql);
	}
	
	if(!$item)alert('예약일을 올바르게 선택해주세요!',G5_BBS_URL.'/board.php?bo_table='.$bo_table);

	if($item['wr_3'] =="week" && strpos($item['wr_4'], $date) !== false  ) ;//ok
	else if($item['wr_3'] =="oneday" && $item['wr_4'] == $set_day) ;//ok
	else if($item['wr_3'] =="term" && strtotime($item['wr_4']) <= strtotime($set_day) && strtotime($item['wr_5']) >= strtotime($set_day) );
	else  alert('예약일을 올바르게 선택해주세요!',$err_url);

}

//마감설정 (기간,시간,인원등을 체크해주는함수)
function ch_lt($wr_id,$date,$item){
	//반환해야하는거 예약가능인원, 예약토탈인원,
	global $link_table_list;
	global $write_table;
	global $set_day;
	global $g5;
	global $today;

	$sql = "select wr_name,wr_id,wr_1,wr_6 from ".$write_table." where wr_1 like '%".$wr_id."%' AND wr_4 != '예약취소' AND wr_2 = '".$set_day."'";
	$qry = sql_query($sql);
	$cnt = 0;

	for($i=0; $row=sql_fetch_array($qry); $i++){
		$arr =  explode('|',$row['wr_1']);
		if($row['wr_6'])$arr2 =  explode('|',$row['wr_6']);
		for($j=0;$j < count($arr); $j++){
			if($arr[$j] == $wr_id) {
				$cnt += $arr2[$j] ? $arr2[$j] : 1 ;
			}
		}

		$arr[$i.'test'] = $row;
	}

	$arr['now-rv'] = $cnt;
	$arr['tot-rv'] = $item['wr_2'];
	if($item['wr_2']){
		if($item['wr_2'] <= $cnt )
			$arr['rv-state'] = 'false';
		else 
			$arr['rv-state'] = 'true';
	}else{
		$arr['rv-state'] = 'true';
	}

	//지난날 마감처리
	if(strtotime($today) > strtotime($set_day)){
		$arr['rv-state'] = 'false';
	}

	//여기는 사용자들이 적은 시간의 단위나 형태가 다를수있어서 언제든 변경해야하는 부분입니다. 현재 설정 : 30분전 마감
	if($today == $set_day && $item['wr_2']){ //today일 경우에 마감을 강제로 진행하는 함수문
		$times = preg_replace("/\s+/", "", $item['wr_6']);
		$times = substr($times,0,'5');
		$set_tile = strtotime("+30 minutes");
		$set_tile = date("H:i",$set_tile);
		if(strtotime($times) - strtotime($set_tile) <= 0){
			$arr['rv-state'] = 'false';
		}
	}
	
	return $arr;
}


//정보가져오기 (예약의 정보 가져오는 함수)
function ch_list($wr_id){
	global $link_table_list;
	$sql = "select * from ".$link_table_list." WHERE wr_id = '".$wr_id."'";
	return sql_fetch($sql);
}

//회원: 이날 내가 예약했는지 확인하는 함수 + 막기기능 
function ch_myrv($wr_id,$day){
	global $member;
	global $write_table;
	global $is_member;
	global $board;
	
	//회원확인용
	if($is_member && !$board['bo_3']){
		$sql = "select * from ".$write_table." where wr_2 = '".$day."' AND mb_id = '".$member['mb_id']."'";
		$qry = sql_query($sql);

		$ch_arr;
		for($i=0; $row=sql_fetch_array($qry); $i++){
			$arr =  explode('|',$row['wr_1']);
			for($j=0;$j < count($arr); $j++){
				$ch_arr[] = $arr[$j];
			}
		}

		if(gettype($wr_id) == 'array'){
			for($i=0;$i < count($wr_id); $i++){
				for($j=0;$j < count($ch_arr); $j++){
					if($ch_arr[$j] == $wr_id[$i])alert('중복예약은 불가능합니다.',$err_url);
				}
			}
		}else if(gettype($wr_id) == 'string'){
			for($j=0;$j < count($ch_arr); $j++){
					if($ch_arr[$j] == $wr_id)alert('중복예약은 불가능합니다.',$err_url);
			}
		}else{
			alert('예약확인 오류'.$err_url,$err_url);
		}
	}
}

//비회원용 : 이날 내가 예약했는지 확인하는 함수 + 막기기능 
function ch_myrv2($wr_id,$day){
	global $write_table;
	global $is_member;
	global $board;
	global $wr_3;
	global $wr_name;
	//비회원확인용
	if(!$is_member && !$board['bo_3']){
		$sql = "select * from ".$write_table." where wr_name='".$wr_name."' AND wr_2 = '".$day."' AND wr_3 = '".$wr_3."'";
		$qry = sql_query($sql);
		$ch_arr;

		for($i=0; $row=sql_fetch_array($qry); $i++){
			$arr =  explode('|',$row['wr_1']);
			for($j=0;$j < count($arr); $j++){
				$ch_arr[] = $arr[$j];
			}
		}

		if(gettype($wr_id) == 'array'){
			for($i=0;$i < count($wr_id); $i++){
				for($j=0;$j < count($ch_arr); $j++){
					if($ch_arr[$j] == $wr_id[$i])alert('중복예약은 불가능합니다.',$err_url);
				}
			}
		}else if(gettype($wr_id) == 'string'){
			for($j=0;$j < count($ch_arr); $j++){
				if($ch_arr[$j] == $wr_id)alert('중복예약은 불가능합니다.',$err_url);
			}
		}else{
			alert('예약확인 오류',$err_url);
		}

	}
}


//날짜로 설정하는 예약 제한 기능
function ch_limo(){
	global $board;
	global $today;
	global $year;
	global $month;
	global $day;
	global $set_day;
	
	$set_year = (int)$year;
	$set_month = (int)$month;

	//$today = '2020-01-01';
	$today_arr = explode('-',$today);
	$match_year = (int)$today_arr[0];
	$match_month = (int)$today_arr[1];
	$state = 'true';
	
	
	/*strtotime
	셋팅날짜
	기준일 
	오늘

	셋팅날짜 - 오늘
	*/

	if($board['bo_2'] > 0){
	$setting_numday = date("Y-m-d", strtotime("+".$board['bo_2']." day", strtotime($today)));
		if(strtotime($setting_numday) - strtotime($set_day) < 0)
			$state = 'false';
	};
	/*
	if($board['bo_2'] == "1"){ //그달 매칭
		if($set_year !== $match_year)$state = 'false';
		if($match_month !== $set_month)$state = 'false';
	}else if($board['bo_2'] == "2"){//다음달까지 매칭
		if($set_year !== $match_year)$state = 'false';
		if($match_month !== $set_month){
			$match_month2 = $match_month == 12 ? 1 :  $match_month+1;
			$match_year = $match_month == 12 ? $match_year+1 :  $match_year;
			if($match_month2 !== $set_month)$state = 'false';
			else if($match_year == $set_year)$state = 'true';
		}
	}else if($board['bo_2'] == "3"){//그해 분기매칭
		if($set_year !== $match_year)$state = 'false';
		else if(ceil($match_month / 3) == '1' && !($set_month == 1 || $set_month ==2 || $set_month ==3 )){ //1,2,3
			$state = 'false';
		}else if(ceil($match_month / 3) == '2' && !($set_month == 4 || $set_month ==5 || $set_month ==6 )){//4,5,6
			$state = 'false';
		}else if(ceil($match_month / 3) == '3' && !($set_month == 7 || $set_month ==8 || $set_month ==9 )){//7,8,9
			$state = 'false';
		}else if(ceil($match_month / 3) == '4' && !($set_month == 10 || $set_month ==11 || $set_month ==12 )){//10,11,12
			$state = 'false';
		}

	}else if($board['bo_2'] == "6"){//그해 반년매칭
		if($set_year !== $match_year)$state = 'false';
		else if(ceil($match_month / 6) == '1' && !($set_month == 1 || $set_month ==2 || $set_month ==3 || $set_month == 4 || $set_month ==5 || $set_month ==6  )){ //1,2,3,4,5,6
			$state = 'false';
		}else if(ceil($match_month / 6) == '2' && !($set_month == 7 || $set_month ==8 || $set_month ==9 || $set_month == 10 || $set_month ==11 || $set_month ==12 )){//7,8,9,10,11,12
			$state = 'false';
		}
	}else if($board['bo_2'] == "12"){//올해 매칭
		if($set_year !== $match_year)$state = 'false';
	}*/


	return $state;	
}

?>