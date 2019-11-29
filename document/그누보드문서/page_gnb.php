<?
$mt_sub['sub01']['title'] = '이벤트';
$mt_sub['sub02']['title'] = '고객센터';
$mt_sub['sub03']['title'] = '마이페이지';
$mt_sub['sub04']['title'] = '멤버십';
$mt_sub['sub05']['title'] = '사이트정책';

$mt_sub['sub01']['dep2'] = array('진행중인 이벤트','마감된 이벤트','참여한 이벤트','이벤트 참여방법');
$mt_sub['sub02']['dep2'] = array('공지사항','온라인문의','포인트 변환 인증 후기','히든포인트 후기');
$mt_sub['sub03']['dep2'] = array('나의 이벤트 참여내역','환급 신청','나의 포인트내역','나의 환급내역','회원정보수정','회원탈퇴');
$mt_sub['sub04']['dep2'] = array('개인정보처리취급방침','사이트이용약관');


//$url = 'http://' . $http_host . $request_uri;
//$http_host = $_SERVER['HTTP_HOST'];
$request_uri = $_SERVER['REQUEST_URI'];


if(strpos($request_uri, 'register') !== false) {  
	$mt_set_dep2 = "02";
	if($is_member){
		$mt_set_page = 'sub05';  
	}else{
		$mt_set_page = 'sub08';  
	}
}

if($page_type == 'mypage'){
	$mt_set_page = 'sub05'; 
	$mt_set_dep2 = "01";
}


if(strpos($request_uri, 'login') !== false) {  
	$mt_set_page = 'sub08'; 
	$mt_set_dep2 = "01";
}
if(strpos($request_uri, 'member_confirm') !== false) {  
	$mt_set_page = 'sub05'; 
	$mt_set_dep2 = "02";
}
if(strpos($request_uri, 'register_result') !== false) {  
	$mt_set_page = 'sub08'; 
	$mt_set_dep2 = "02";
}
if(strpos($request_uri, 'member_leave') !== false) {  
	$mt_set_page = 'sub05'; 
	$mt_set_dep2 = "03";
}
if(strpos($request_uri, 'password_lost') !== false) {  
	$mt_set_page = 'sub08'; 
	$mt_set_dep2 = "03";
}

if(strpos($request_uri, 'search') !== false) {  
	$mt_set_page = 'sub07'; 
	$mt_set_dep2 = "01";
}

if($bo_table == "community_news" || $bo_table == "community_program" || $bo_table == "community_fnq" || $bo_table == "community_download" || $bo_table == "community_poto"){
	$mt_set_page = 'sub04';
	if($bo_table == "community_news")$mt_set_dep2 = 1;
	if($bo_table == "community_program")$mt_set_dep2 = 2;
	if($bo_table == "community_fnq")$mt_set_dep2 = 3;
	if($bo_table == "community_download")$mt_set_dep2 = 4;
	if($bo_table == "community_poto")$mt_set_dep2 = 5;
}

$set_sub_name = $mt_sub[$mt_set_page]['title'];
if($mt_set_dep2){$set_dep1_name  = $mt_sub[$mt_set_page]['dep2'][(int)$mt_set_dep2-1];}
if($mt_set_dep3){$set_dep2_name  =  $mt_sub[$mt_set_page]['dep3'][$set_dep1_name][(int)$mt_set_dep3-1];}


function mt_php_nv($mt_sub,$addClass){
	$mt_tag.='<ul class="clear P_nav01 '.$addClass.'" >';
	for($i = 1; $i <4 ; $i++){
		$set_page = 'sub0'.$i;
		$set_title1 = $mt_sub[$set_page]['title'];
		$set_url =  '/html/'.$set_page.'_01.php';
		$mt_tag .= '<li class="dep1"><a href="'.G5_URL.$set_url.'" class="T_fl_lt">'.$set_title1.'</a>'.PHP_EOL;

		if($mt_sub[$set_page]['dep2']){
			$mt_tag .= '<ul class="">';
			for($j = 1; $j <= count($mt_sub[$set_page ]['dep2']); $j++){
				$set_url2 = $mt_sub[$set_page]['dep2_url'][$j-1];
				$set_title2 =$mt_sub[$set_page ]['dep2'][$j-1];
				if($mt_sub[$set_page]['dep3'][$set_title2])$set_url2 =  '/html/'.$set_page.'_0'.$j.'_1.php';
				else $set_url2 =  '/html/'.$set_page.'_0'.$j.'.php';
				$mt_tag .= '<li><a href="'.$set_url2.'">'.$set_title2.'</a>'.PHP_EOL;

				if($mt_sub[$set_page]['dep3'][$set_title2]){
					$mt_tag .='<ul class="">';
					for($k = 1; $k <= count($mt_sub[$set_page]['dep3'][$set_title2]); $k++){
						$set_title3 = $mt_sub[$set_page]['dep3'][$set_title2][$k-1];
						$set_url3 =  '/html/'.$set_page.'_0'.$j.'_'.$k.'.php';
					$mt_tag .='<li><a href="'.$set_url3.'">- '.$set_title3.'</a></li>'.PHP_EOL;
					}
					$mt_tag .='</ul>'.PHP_EOL;
				}
				$mt_tag .='</li>'.PHP_EOL;
			}
		}
		$mt_tag .='</ul>'.PHP_EOL;
		$mt_tag .='</li>'.PHP_EOL;
	}

	$mt_tag .='</ul>';
	echo $mt_tag;
}

?>