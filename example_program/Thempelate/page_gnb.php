<?

//$mt_sub['set_array'] = array("sub01","sub02","sub03","sub04","sub05","sub06","sub07","sub08","sub09");

//			인덱스,부모,뎁스, sort(배열)
$mt_sub[0][0][0] = "센터소개";
$mt_sub[1][0][0] = "센터소식";
$mt_sub[2][0][0] = "알림마당";
$mt_sub[3][0][0] = "정보공개";
$mt_sub[4][0][0] = "개인정보처리취급방침";
$mt_sub[5][0][0] = "저작권정책";
$mt_sub[6][0][0] = "사이트이용안내";
$mt_sub[7][0][0] = "이메일수집거부";
$mt_sub[8][0][0] = "뷰어프로그램다운로드";

$mt_sub[0][0][1] = array('인사말','센터소개','함께하는 사람들','함께하는 기관들','찾아오시는길');
$mt_sub[1][0][1] = array('센터공지사항','유관기관공지','활동소식','보도자료','영상소식');
$mt_sub[2][0][1] = array('우수봉사자증 발급안내','우수봉사자 할인가맹점 안내','자료실');
$mt_sub[3][0][1] = array('운영공시','계약정보');
$mt_sub[4][0][1] = array('개인정보처리취급방침');
$mt_sub[5][0][1] = array('저작권정책');
$mt_sub[6][0][1] = array('사이트이용안내');
$mt_sub[7][0][1] = array('이메일수집거부');
$mt_sub[8][0][1] = array('뷰어프로그램다운로드');

$mt_sub[0][0][2] = array('이사장 인사말','센터장 인사말');
$mt_sub[0][1][2] = array('센터현황','비전과 목표','걸어온길','브랜드/CI');
$mt_sub[0][2][2] = array('조직도','임원소개','회원현황','부서현황');


if(strpos($bo_table, 'sub2_') !== false) {  
   $set_dep1 = 1;
	if($bo_table == "sub2_1")$set_dep2 = 0;
	if($bo_table == "sub2_2")$set_dep2 = 1;
	if($bo_table == "sub2_3")$set_dep2 = 2;
	if($bo_table == "sub2_4")$set_dep2 = 3;
}

if(strpos($bo_table, 'sub3_') !== false) {  
   $set_dep1 = 2;
	if($bo_table == "sub3_2")$set_dep2 = 1;
	if($bo_table == "sub3_3")$set_dep2 = 2;
	if($bo_table == "sub3_4")$set_dep2 = 3;
	if($bo_table == "sub3_5")$set_dep2 = 4;
}

if(strpos($bo_table, 'sub4_') !== false) {  
   $set_dep1 = 'sub4';
	if($bo_table == "sub4_1")$set_dep2 = 0;
	if($bo_table == "sub4_2")$set_dep2 = 1;
}


function mk_nav($set_arr,$set_sub,$set_cancel,$set_class){
	$mt_tag  = '<nav class="'.$set_class.'">'.PHP_EOL;
	$mt_tag  .= '<ul>'.PHP_EOL;
	$mt_i = 0;
	$set_cancel_arr = explode(',',$set_cancel);

	while($mt_i < count($set_arr)){
		$set_cancels = false;
		for($i =0; $i < count($set_cancel_arr); $i++){
			if($mt_i == $set_cancel_arr[$i]){
				$set_cancels = true;	
			}
		}
		if(!$set_cancels){
			$mt_tag .= '<li>'.PHP_EOL;
			$mt_tag .= '<a href="'.G5_URL.'/html/sub'.($mt_i+1).'_0_0_1.php">'.$set_arr[$mt_i][0][0].'</a>'.PHP_EOL;
			$mt_tag .= mk_list($set_arr[$mt_i], 0,2,count($set_arr[$mt_i][0]),'',$mt_i);
			$mt_tag .= '</li>'.PHP_EOL;
		}
		$mt_i++;
	}
	$mt_tag .= '</ul>'.PHP_EOL;
	$mt_tag .= '</nav>'.PHP_EOL;
	
	return $mt_tag;
}

function mk_list($arr,$set_parent,$set_deps,$max_deps ,$str, $set_dep){
	if(count($arr[$set_parent][$set_deps-1]) > 0)$str .= "<ul>".PHP_EOL;
	if($set_deps == 2){
		for($i = 0; $i < count($arr[$set_parent][$set_deps-1]); $i++){
			$str .= '<li class="dep'.($set_deps-1).'">'.PHP_EOL;
			$str .= '<a href="'.G5_URL.'/html/sub'.($set_dep+1).'_0_0_'.($i+1).'.php">'.$arr[$set_parent][$set_deps-1][$i].'</a>'.PHP_EOL;
			if($set_deps < $max_deps){
				$str .= mk_list($arr,$i ,$set_deps+1,$max_deps ,'');
			}
			$str .= "</li>".PHP_EOL;
		}
	}else{
		for($i = 0; $i < count($arr[$set_parent][$set_deps-1]); $i++){
			$str .= '<li class="dep'.($set_deps-1).'">'.PHP_EOL;
			$str .= '<a href="'.G5_URL.'/html/sub'.($set_dep+1).'_0_0_'.($i+1).'.php">'.$arr[$set_parent][$set_deps-1][$i].'</a>'.PHP_EOL;
			if($set_deps < $max_deps){
				$str .= mk_list($arr,$i ,$set_deps+1,$max_deps ,'');
			}
			$str .= "</li>".PHP_EOL;
		}
	}
	if(count($arr[$set_parent][$set_deps-1]) > 0)$str .= "</ul>".PHP_EOL;
	return $str;
}
?>

