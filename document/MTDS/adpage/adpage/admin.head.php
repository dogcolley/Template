<?php
if (!defined('_GNUBOARD_')) exit;

$begin_time = get_microtime();

include_once(G5_PATH.'/head.sub.php');

function print_menu1($key, $no)
{
    global $menu;

    $str = print_menu2($key, $no);

    return $str;
}

function print_menu2($key, $no)
{
    global $menu, $auth_menu, $is_admin, $auth, $g5;

    $str .= "<ul class=\"gnb_2dul\">";
    for($i=1; $i<count($menu[$key]); $i++)
    {
        if ($is_admin != 'super' && (!array_key_exists($menu[$key][$i][0],$auth) || !strstr($auth[$menu[$key][$i][0]], 'r')))
            continue;

        if (($menu[$key][$i][4] == 1 && $gnb_grp_style == false) || ($menu[$key][$i][4] != 1 && $gnb_grp_style == true)) $gnb_grp_div = 'gnb_grp_div';
        else $gnb_grp_div = '';

        if ($menu[$key][$i][4] == 1) $gnb_grp_style = 'gnb_grp_style';
        else $gnb_grp_style = '';

        $str .= '<li class="gnb_2dli"><a href="'.$menu[$key][$i][2].'" class="gnb_2da '.$gnb_grp_style.' '.$gnb_grp_div.'">'.$menu[$key][$i][1].'</a></li>';

        $auth_menu[$menu[$key][$i][0]] = $menu[$key][$i][1];
    }
    $str .= "</ul>";

    return $str;
}

	if(strpos($PHP_SELF, "sms_admin") !== false) {  
		$admin_cate_gubun = "sms";
	}

	//게시판관리를 위해 게시판 아이디 뽑기
	$b1 = sql_fetch("select * from g5_board where bo_table not like '%_eng' order by bo_table");
	$b2 = sql_fetch("select * from g5_board where bo_table like '%_eng' order by bo_table");

	if($bo_table || $admin_cate_gubun=="exp"){
		$menu_name = "게시판관리";
		$menu_list = "";
		$add_sql = "";
		if($member[mb_id] != "super"){
			//$add_sql = " and bo_table not in ('product', 'product_eng') ";
		}
		if(strpos($bo_table, "_eng") !== false) {  
			$result1 = sql_query("select * from g5_group where gr_id like '%_eng' order by gr_id");
		} else {  
			$result1 = sql_query("select * from g5_group where gr_id not like '%_eng' and gr_id <> 'type1' order by gr_id");
		} 		
		for($j=0;$row1=sql_fetch_array($result1);$j++){
			$row1[gr_subject] = str_replace("_eng","",$row1[gr_subject]);
			$menu_list .= "<li class='g_title'>- $row1[gr_subject]</li>";		
			$result = sql_query("select * from g5_board where gr_id = '$row1[gr_id]' $add_sql  order by bo_table");
			if($row1[gr_subject]=="제품관리") {
				$menu_list .="<li><a href='./p_cate.php'>제품카테고리관리</a></li>";
			}
			for($i=0;$row=sql_fetch_array($result);$i++){				
				$menu_list .= "<li><a href='".G5_USER_ADMIN_URL."/board.php?bo_table=".$row[bo_table]."'>".$row[bo_subject]."</a></li>";
			}
		}
	}elseif($admin_cate_gubun=="basic"){
		$menu_name = "기본관리";
		$menu_list = "";
		$menu_list .= "<li><a href='./admin_form.php'>관리자정보</a></li>";
		/*$menu_list .= "<li><a href='./config_form.php'>환경설정</a></li>";
		$menu_list .= "<li><a href='./member_list.php'>회원관리</a></li>";
		$menu_list .= "<li><a href='./mail_list.php'>회원메일발송</a></li>";
		$menu_list .= "<li><a href='./visit_list.php'>접속자집계</a></li>";
		$menu_list .= "<li><a href='./visit_search.php'>접속자검색</a></li>";
		$menu_list .= "<li><a href='./point_list.php'>포인트관리</a></li>";*/
		$menu_list .= "<li><a href='./newwinlist.php'>팝업관리</a></li>";
		//$menu_list .= "<li><a href='./financialReporting.php'>재정보고 관리</a></li>";
		if($member[mb_id] == "super"){
		$menu_list .= "<li><a href='./p_cate.php'>제품카테고리관리</a></li>";
		//$menu_list .= "<li><a href='./p_cate_eng.php'>제품카테고리관리(영문)</a></li>";
		}
	}elseif($admin_cate_gubun=="log"){
		$menu_name = "로그분석";
		$menu_list = "";
		$menu_list .= "<li><a href='./admin_log.php'>사이트 활성도 통계</a></li>";
	}/*elseif($admin_cate_gubun=="shop1"){
		$menu_name = "쇼핑몰관리";
		$menu_list = "";
		$menu_list .= "<li><a href='./configform.php'>쇼핑몰설정</a></li>";
		$menu_list .= "<li><a href='./orderlist.php'>주문내역</a></li>";
		$menu_list .= "<li><a href='./categorylist.php'>분류관리</a></li>";
		$menu_list .= "<li><a href='./itemlist.php'>상품관리</a></li>";
		$menu_list .= "<li><a href='./itemqalist.php'>상품문의</a></li>";
		$menu_list .= "<li><a href='./itemuselist.php'>사용후기</a></li>";
		$menu_list .= "<li><a href='./itemstocklist.php'>상품재고관리</a></li>";
		$menu_list .= "<li><a href='./optionstocklist.php'>상품옵션재고관리</a></li>";
		$menu_list .= "<li><a href='./itemtypelist.php'>상품유형관리</a></li>";
		$menu_list .= "<li><a href='./couponlist.php'>쿠폰관리</a></li>";
		$menu_list .= "<li><a href='./bannerlist.php'>배너관리</a></li>";
		$menu_list .= "<li><a href='./keywordlist.php'>키워드관리</a></li>";
		$menu_list .= "<li><a href='./sendcostlist.php'>추가배송비관리</a></li>";
	}elseif($admin_cate_gubun=="shop2"){
		$menu_name = "쇼핑몰현황";
		$menu_list = "";
		$menu_list .= "<li><a href='./sale1.php'>매출현황</a></li>";
		$menu_list .= "<li><a href='./itemsellrank.php'>상품판매순위</a></li>";
		$menu_list .= "<li><a href='./orderprint.php'>주문내역출력</a></li>";
		$menu_list .= "<li><a href='./wishlist.php'>보관함현황</a></li>";
		$menu_list .= "<li><a href='./price.php'>가격비교사이트</a></li>";
	}*/elseif($admin_cate_gubun=="sms"){
		$menu_name = "SMS관리";
		$menu_list = "";
		$menu_list .= "<li><a href='./config.php'>SMS 기본설정</a></li>";
		$menu_list .= "<li><a href='./member_update.php'>회원정보업데이트</a></li>";
		$menu_list .= "<li><a href='./sms_write.php'>문자 보내기</a></li>";
		$menu_list .= "<li><a href='./history_list.php'>전송내역-건별</a></li>";
		$menu_list .= "<li><a href='./history_num.php'>전송내역-번호별</a></li>";
		$menu_list .= "<li><a href='./form_group.php'>이모티콘 그룹</a></li>";
		$menu_list .= "<li><a href='./form_list.php'>이모티콘 관리</a></li>";
		$menu_list .= "<li><a href='./num_group.php'>휴대폰번호 그룹</a></li>";
		$menu_list .= "<li><a href='./num_book.php'>휴대폰번호 관리</a></li>";
		$menu_list .= "<li><a href='./num_book_file.php'>휴대폰번호 파일</a></li>";

	}
?>
<!-- 상단 -->
<header class="admin_header">
	<div class="admin_menu">
		<h1><a href="http://molto.kr" target="_blank"><img src="/adpage/img/adm_molto_logo.gif" title="몰토디자인"></a></h1>
		<ul>
			<li><a href="/"  target="_blank"><img src="/adpage/img/admin_home_btn.gif" title="홈"></a></li>
		</ul>
	</div>
	<div class="admin_nav">
		<ul>
			<li><a href="<?php echo G5_USER_ADMIN_URL ?>" class="item"><img src="/adpage/img/adm_menu00_off.gif" title></a></li>
			<li><img src="/adpage/img/adm_menu_line.gif"></li>
			<li><a href="/adpage/admin_form.php" class="item"><img src="/adpage/img/adm_menu01_off.gif" title></a></li>
			<li><img src="/adpage/img/adm_menu_line.gif"></li>
			<li><a href="<?php echo G5_USER_ADMIN_URL ?>/board.php?bo_table=<?=$b1[bo_table]?>" class="item"><img src="/adpage/img/adm_menuKR_off.png" title alt="게시판 관리 국문"></a></li>
			<li><img src="/adpage/img/adm_menu_line.gif"></li>
			<li><a href="<?php echo G5_USER_ADMIN_URL ?>/board.php?bo_table=<?=$b2[bo_table]?>" class="item"><img src="/adpage/img/adm_menuENG_off.png" title alt="게시판 관리 영문"></a></li>
			<!-- <li><img src="/adpage/img/adm_menu_line.gif"></li>
			<li><a href="<?php echo G5_USER_ADMIN_URL ?>" class="item"><img src="/adpage/img/adm_menu03_off.gif" title></a></li> -->
			<?/*<<li><img src="/adpage/img/adm_menu_line.gif"></li>
			li><a href="/adpage/shop_admin/" class="item"><img src="/adpage/img/adm_menu07_off.gif" title></a></li>
			<li><img src="/adpage/img/adm_menu_line.gif"></li>
			<li><a href="/adpage/shop_admin/itemsellrank.php" class="item"><img src="/adpage/img/adm_menu08_off.gif" title></a></li>
			<li><img src="/adpage/img/adm_menu_line.gif"></li>*/?>
			<?/*<li><a href="/adpage/sms_admin/sms_write.php" class="item"><img src="/adpage/img/adm_menu06_off.gif" title></a></li>
			<li><img src="/adpage/img/adm_menu_line.gif"></li>
			<li><a href="/adpage/admin_log.php" class="item"><img src="/adpage/img/adm_menu04_off.gif" title></a></li>
			*/?>
		</ul>
	</div>
	<script type="text/javascript">
	$(function(){
		$(".item").each(function(){
			var a = $(this);
			var img = a.find("img");
			var src = img.attr("src");
			var src_on = src.replace("_off", "_on");
			var src_off = src.replace("_on", "_off");
			a.hover(function(){
				img.attr("src", src_on);
			},function(){
				if(a.hasClass("active")){
					img.attr("src", src_on);
				} else {
					img.attr("src", src_off);
				}
			});
		});
	});
	</script>
</header>
<!-- 상단 끝 -->
<!-- 내용 -->
<div class="admin_contentswrap">
	<div class="admin_lnb">
		<div class="admin_box">
			<div class="admin_welcome"><strong><?=$member[mb_name]?></strong>님 환영합니다.</div>
			<div class="admin_info">
				<strong>아이디</strong>: <?=$member[mb_id]?>
			</div>
			<div class="admin_btn">
				<a href="/adpage/admin_form.php"><img src="/adpage/img/revise_btn.gif" title="정보수정"></a>
				<a href="/bbs/logout.php"><img src="/adpage/img/logout_btn.gif" title="로그아웃"></a>
			</div>
		</div>
		<?if($PHP_SELF=="/adpage/index.php"){?>
		<?}else{?>
		<div class="admin_list_box">
			<div class="admin_list_title">
				<?=$menu_name?>
			</div>
			<div class="admin_list">
				<ul>
					<?=$menu_list?>
				</ul>
			</div>
		</div>
		<?}?>
		<div class="admin_customer"><img src="/adpage/img/customer.gif" title="고객센터"></div>
		<div><a href="http://mt114.dgmolto.com/bbs/board.php?bo_table=uzi" target="_blank"  class="item"><img src="/adpage/img/uzi_icon_off.gif"title="유지관리 게시판"></a></div>
	</div>
	<div class="admin_contents">
		<? if(!$bo_table) { ?>
		<h2 class="admin_heading"><?php echo $g5['title']; ?></h2>
		<? } ?>
