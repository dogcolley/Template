<?
$mt_sub['sub01']['title'] = '체험관소개';
$mt_sub['sub02']['title'] = '시설안내';
$mt_sub['sub03']['title'] = '체험신청';
$mt_sub['sub04']['title'] = '열린마당';
$mt_sub['sub05']['title'] = '마이페이지';
$mt_sub['sub06']['title'] = '사이트정책';
$mt_sub['sub07']['title'] = '검색';
$mt_sub['sub08']['title'] = '맴버쉽';

$mt_sub['sub01']['url'] = 'sub01';
$mt_sub['sub02']['url'] = 'sub02';
$mt_sub['sub03']['url'] = 'sub03';
$mt_sub['sub04']['url'] = 'sub04';
$mt_sub['sub05']['url'] = 'sub05';
$mt_sub['sub06']['url'] = 'sub06';
$mt_sub['sub07']['url'] = 'sub07';
$mt_sub['sub08']['url'] = 'sub08';

$mt_sub['sub01']['dep2'] = array('인사말','설립취지와 추진방향','오시는길');
$mt_sub['sub02']['dep2'] = array('체험관 이용안내','테마별 주요내용');
$mt_sub['sub02']['dep3']['테마별 주요내용'] = array('식품 구성 자전거','깨끗하게 손씻기','가공 식품 바로알기','몸 속 미끄럼틀','건강 장보기','나의 건강을 지켜요');
$mt_sub['sub03']['dep2'] = array('체험신청안내','체험예약신청');
$mt_sub['sub04']['dep2'] = array('새소식','특별프로그램','질문과답변','자료실','포토갤러리');
$mt_sub['sub04']['dep2_url']= array('community_news','community_program','community_fnq','community_download','community_poto');
$mt_sub['sub05']['dep2'] = array('나의 예약문의','회원정보수정' ,'회원탈퇴');
$mt_sub['sub06']['dep2'] = array('사이트 이용약관','개인정보 처리방침','이메일 무단수집 거부');
$mt_sub['sub07']['dep2'] = array('검색');
$mt_sub['sub08']['dep2'] = array('로그인','회원가입','회원정보찾기');



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


function mt_php_nv($mt_sub,$gnb_js,$mt_on){
	
	if($gnb_js)$gnb_js = 'id="U_gnb"';
	$mt_tag.='<ul class="clear P_nav01" '.$gnb_js.'>';
	for($i = 1; $i <5 ; $i++){
		$set_page = 'sub0'.$i;
		$set_title1 = $mt_sub[$set_page]['title'];
		if($i==4)$set_url =  '/bbs/board.php?bo_table='.$mt_sub[$set_page]['dep2_url'][0];
		else $set_url =  '/html/'.$set_page.'_01.php';
		$mt_tag .= '<li class="dep1"><a href="'.G5_URL.$set_url.'" class="T_fl_lt">'.$set_title1.'</a>';
		$mt_tag .= '<ul class="">';
		
		for($j = 1; $j <= count($mt_sub[$set_page ]['dep2']); $j++){
			$set_url2 = $mt_sub[$set_page]['dep2_url'][$j-1];
			$set_title2 =$mt_sub[$set_page ]['dep2'][$j-1];
			 if($i==4)$set_url2 =  '/bbs/board.php?bo_table='.$set_url2;
			else if($mt_sub[$set_page]['dep3'][$set_title2])$set_url2 =  '/html/'.$set_page.'_0'.$j.'_1.php';
			else $set_url2 =  '/html/'.$set_page.'_0'.$j.'.php';
			if($set_title2 == $mt_on)$mt_tag .= '<li class="on"><a href="'.$set_url2.'">'.$set_title2.'</a>';
			else $mt_tag .= '<li><a href="'.$set_url2.'">'.$set_title2.'</a>';

			if($mt_sub[$set_page]['dep3'][$set_title2]){	
				$mt_tag .='<ul class="">';
				for($k = 1; $k <= count($mt_sub[$set_page]['dep3'][$set_title2]); $k++){
					$set_title3 = $mt_sub[$set_page]['dep3'][$set_title2][$k-1];
					$set_url3 =  '/html/'.$set_page.'_0'.$j.'_'.$k.'.php';
				$mt_tag .='<li><a href="'.$set_url3.'">- '.$set_title3.'</a></li>';
				}
				$mt_tag .='</ul>';
			}
			$mt_tag .='</li>';
		}

		$mt_tag .='</ul>';
		$mt_tag .='</li>';
	}

	$mt_tag .='</ul>';
	echo $mt_tag;
}

?>