<?
include_once('./_common.php');

$g5['title'] = '관리자정보';
$admin_cate_gubun = "log";
include_once ('./admin.head.php');

echo "<h2 class='admin_heading'>로그분석</h2>";

$day=30; //기간 - 기본검색설정된 기간입니다. 필요에따라 수정해서 사용가능합니다.
if (empty($fr_date)) $fr_date = date("Y-m-d", $g5[server_time]-86400*$day);
if (empty($to_date)) $to_date = $g5[time_ymd];
// m3stats 설정
$limit=(strtotime($to_date)- strtotime($fr_date)) / 86400;
$bar_width = 60; // 그래프 최대 너비 (기본 60)
$pluginDracoCounter = './plugin/DracoCounter/gDracoCounter.php';
include_once($pluginDracoCounter);
$pluginDracoData = ShowDracoCounter(30, 29); // 날짜, 날짜의 가로폭 : 총 가로폭은 날짜 * 날짜가로폭

// 전체 회원수
$sql = " select count(mb_id) as cnt from g5_member"; 
$row = sql_fetch($sql);
$total_member  = $row[cnt];

// 남/여 성비
// 남자 성비
$sql = " select count(mb_sex) as sex from g5_member where `mb_sex` = 'M'"; 
$row = sql_fetch($sql);
$man_num  = $row[sex];
// 여자 성비
$sql = " select count(mb_sex) as sex from g5_member where `mb_sex` = 'F'"; 
$row = sql_fetch($sql);
$woman_num  = $row[sex];
// 남/여 성비 % 계산
$total_num = $man_num+$woman_num;
$man_per = @sprintf("%.2f",(($man_num / $total_num)*100));
$woman_per = @sprintf("%.2f",(($woman_num / $total_num)*100));

// 연령분포
$old1 = date("Ymd",strtotime("-9 year", time()));
$old2 = date("Ymd",strtotime("-19 year", time()));
$old3 = date("Ymd",strtotime("-29 year", time()));
$old4 = date("Ymd",strtotime("-39 year", time()));
$old5 = date("Ymd",strtotime("-49 year", time()));
// 0~9세
$sql = " select count(mb_birth) as old from g5_member where `mb_birth` > '$old1'"; 
$row = sql_fetch($sql);
$year0  = $row[old];
// 10~19세
$sql = " select count(mb_birth) as old from g5_member where `mb_birth`  > '$old2' and `mb_birth`  <= '$old1'"; 
$row = sql_fetch($sql);
$year1  = $row[old];
// 20~29세
$sql = " select count(mb_birth) as old from g5_member where `mb_birth`  > '$old3' and `mb_birth`  <= '$old2'"; 
$row = sql_fetch($sql);
$year2  = $row[old];
// 30~39세
$sql = " select count(mb_birth) as old from g5_member where `mb_birth`  > '$old4' and `mb_birth`  <= '$old3'"; 
$row = sql_fetch($sql);
$year3  = $row[old];
// 40~49세
$sql = " select count(mb_birth) as old from g5_member where `mb_birth`  > '$old5' and `mb_birth`  <= '$old4'"; 
$row = sql_fetch($sql);
$year4  = $row[old];
// 50세 이상
$sql = " select count(mb_birth) as old from g5_member where `mb_birth`  <= '$old5'"; 
$row = sql_fetch($sql);
$year5  = $row[old];
// 연령분포 % 계산
$year0_per = @sprintf("%.2f",(($year0 / $total_num)*100));
$year1_per = @sprintf("%.2f",(($year1 / $total_num)*100));
$year2_per = @sprintf("%.2f",(($year2 / $total_num)*100));
$year3_per = @sprintf("%.2f",(($year3 / $total_num)*100));
$year4_per = @sprintf("%.2f",(($year4 / $total_num)*100));
$year5_per = @sprintf("%.2f",(($year5 / $total_num)*100));

/*  거주지 분포  */
// 서울거주
$sql = " select count(mb_addr1) as addr from g5_member where `mb_addr1` LIKE '%서울%'"; 
$row = sql_fetch($sql);
$seoul  = $row[addr];
// 부산거주
$sql = " select count(mb_addr1) as addr from g5_member where `mb_addr1` LIKE '%부산%'"; 
$row = sql_fetch($sql);
$busan  = $row[addr];
// 대구거주
$sql = " select count(mb_addr1) as addr from g5_member where `mb_addr1` LIKE '%대구%'";
$row = sql_fetch($sql);
$daegu  = $row[addr];
// 인천거주
$sql = " select count(mb_addr1) as addr from g5_member where `mb_addr1` LIKE '%인천%'";
$row = sql_fetch($sql);
$incheon  = $row[addr];
// 광주
$sql = " select count(mb_addr1) as addr from g5_member where `mb_addr1` LIKE '%광주%'";
$row = sql_fetch($sql);
$gwangju  = $row[addr];
// 대전
$sql = " select count(mb_addr1) as addr from g5_member where `mb_addr1` LIKE '%대전%'";
$row = sql_fetch($sql);
$daejeon  = $row[addr];
// 울산
$sql = " select count(mb_addr1) as addr from g5_member where `mb_addr1` LIKE '%울산%'";
$row = sql_fetch($sql);
$ulsan  = $row[addr];
// 강원
$sql = " select count(mb_addr1) as addr from g5_member where `mb_addr1` LIKE '%강원%'";
$row = sql_fetch($sql);
$gangwon  = $row[addr];
// 경기
$sql = " select count(mb_addr1) as addr from g5_member where `mb_addr1` LIKE '%경기%'";
$row = sql_fetch($sql);
$gyeonggi  = $row[addr];
// 경남
$sql = " select count(mb_addr1) as addr from g5_member where `mb_addr1` LIKE '%경남%'";
$row = sql_fetch($sql);
$gyeongnam  = $row[addr];
// 경북
$sql = " select count(mb_addr1) as addr from g5_member where `mb_addr1` LIKE '%경북%'";
$row = sql_fetch($sql);
$gyeongbuk  = $row[addr];
// 전남
$sql = " select count(mb_addr1) as addr from g5_member where `mb_addr1` LIKE '%전남%'";
$row = sql_fetch($sql);
$jeonnam = $row[addr];
// 전북
$sql = " select count(mb_addr1) as addr from g5_member where `mb_addr1` LIKE '%전북%'";
$row = sql_fetch($sql);
$jeonbuk  = $row[addr];
// 제주
$sql = " select count(mb_addr1) as addr from g5_member where `mb_addr1` LIKE '%제주%'";
$row = sql_fetch($sql);
$jeju  = $row[addr];
// 충남
$sql = " select count(mb_addr1) as addr from g5_member where `mb_addr1` LIKE '%충남%'";
$row = sql_fetch($sql);
$chungnam  = $row[addr];
// 충북
$sql = " select count(mb_addr1) as addr from g5_member where `mb_addr1` LIKE '%충북%'";
$row = sql_fetch($sql);
$chungbuk  = $row[addr];
// 해외
$sql = " select count(mb_addr1) as addr from g5_member where `mb_addr1` LIKE '%해외%'";
$row = sql_fetch($sql);
$oversea  = $row[addr];
// 지역분포 % 계산
$seoul_per = @sprintf("%.2f",(($seoul / $total_num)*100));
$busan_per = @sprintf("%.2f",(($busan / $total_num)*100));
$daegu_per = @sprintf("%.2f",(($daegu / $total_num)*100));
$incheon_per = @sprintf("%.2f",(($incheon / $total_num)*100));
$gwangju_per = @sprintf("%.2f",(($gwangju / $total_num)*100));
$daejeon_per = @sprintf("%.2f",(($daejeon / $total_num)*100));
$ulsan_per = @sprintf("%.2f",(($ulsan / $total_num)*100));
$gangwon_per = @sprintf("%.2f",(($gangwon / $total_num)*100));
$gyeonggi_per = @sprintf("%.2f",(($gyeonggi / $total_num)*100));
$gyeongnam_per = @sprintf("%.2f",(($gyeongnam / $total_num)*100));
$gyeongbuk_per = @sprintf("%.2f",(($gyeongbuk / $total_num)*100));
$jeonnam_per = @sprintf("%.2f",(($jeonnam / $total_num)*100));
$jeonbuk_per = @sprintf("%.2f",(($jeonbuk / $total_num)*100));
$jeju_per = @sprintf("%.2f",(($jeju / $total_num)*100));
$chungnam_per = @sprintf("%.2f",(($chungnam / $total_num)*100));
$chungbuk_per = @sprintf("%.2f",(($chungbuk / $total_num)*100));
$oversea_per = @sprintf("%.2f",(($oversea / $total_num)*100));
?>
<script type="text/javascript">
	function fcount_submit(ymd, gr_id, bo_table) {
		var f = document.fcount;
		f.ymd.value = ymd;
		f.gr_id.value = gr_id;
		f.bo_table.value = bo_table;
		f.action = "<?=$PHP_SELF?>";
		f.submit();
	}
</script>
	<div class="statistics">
		<? include_once ('./status/today_status.php'); ?>
		<div style="clear:both"></div>
		<div class="statistics_graph">
			<ul>
				<? include_once ('./status/visit_status.php'); ?>
				<? include_once ('./status/member_status.php'); ?>
			</ul>
		</div>
		<? 
		$sql = " select count(*) as cnt from $g5[member_table] where  mb_id <> '$config[cf_admin]' ";
		$row = sql_fetch($sql);
		$total_count = $row['cnt'];
		$sql2 = "select count(*) as cnt from $g5[member_table] where mb_sex = 'F' and mb_id <> '$config[cf_admin]'"; 
		$row2 = sql_fetch($sql2);
		$count_f = $row2['cnt'];
		$count_m=$total_count-$count_f;
		$sql3 = " select count(*) as cnt from $g5[member_table] where mb_level between 3 and 11 "; 
		$row3 = sql_fetch($sql3); 
		$count_3 = $row3['cnt'];
		$sql4 = " select count(*) as cnt from $g5[member_table] where mb_level = '2'"; 
		$row4 = sql_fetch($sql4); 
		$count_2 = $row4['cnt'];
		$sql5 = " select count(*) as cnt from $g5[member_table] where mb_level between 13 and 14 "; 
		$row5 = sql_fetch($sql5); 
		$count_s = $row5['cnt'];
		$count_t = $count_3 + $count_s;
		if ($member[mb_level]=="15") {
			echo " <font color='#666666'>- 등급별 회원수 &nbsp;&nbsp;";
			for( $i = 2 ; $i <= 14 ; $i++) { 
				$sql = "select count(*) as mb_num from $g5[member_table] where mb_level = '$i'"; 
				$result = sql_query($sql); 
				$row = mysql_fetch_array($result); 
				if($row[mb_num]!=0) echo " 레벨[$i] : $row[mb_num] 명 &nbsp;</font> ";
			}
		}
		?>
		<div class="total"><img src="images/point_icon.gif"> <b style="color:#5a5a5a;">총 회원 수</b> : <strong><?=number_format($total_member)?></strong> 명   (오늘가입: <strong><?=$member_cnt[0]?></strong> 명 ,  이달가입 <strong><?=number_format($member_cnt[month])?></strong> 명)</div>
		<div class="distribution">
			<ul>
				<li>
					<strong><img src="images/point_icon.gif"> 연령별 분포</strong>
					<table width="155" border="0" cellspacing="0" cellpadding="0">
						<tr><td width="155"> - 만 0 ~ 9세 : <?=number_format($year0);?> 명 (<?=$year0_per?>%)</td></tr>
						<tr><td width="155"> - 만 10 ~ 19세 : <?=number_format($year1);?> 명 (<?=$year1_per?>%)</td></tr>
						<tr><td width="155"> - 만 20 ~ 29세 : <?=number_format($year2);?> 명 (<?=$year2_per?>%)</td></tr>
						<tr><td width="155"> - 만 30 ~ 39세 : <?=number_format($year3);?> 명 (<?=$year3_per?>%)</td></tr>
						<tr><td width="155"> - 만 40 ~ 49세 : <?=number_format($year4);?> 명 (<?=$year4_per?>%)</td></tr>
						<tr><td width="155"> - 만 50세 이상 : <?=number_format($year5);?> 명 (<?=$year5_per?>%)</td></tr>
					</table>
				</li>
				<li class="w50"></li>
				<li>
					<strong><img src="images/point_icon.gif"> 남/여성별 분포</strong>
					<table width="115" border="0" cellspacing="0" cellpadding="0">
						<tr><td width="115"> - 남자 : <?=number_format($man_num);?> 명 (<?=$man_per?>%)</td></tr>
						<tr><td width="115"> - 여자 : <?=number_format($woman_num);?> 명 (<?=$woman_per?>%)</td></tr>
					</table>
				</li>
				<li class="w50"></li>
				<li>
					<strong><img src="images/point_icon.gif"> 지역별 분포</strong>
					<table width="345" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="115"> - 서울 : <?=number_format($seoul);?> 명 (<?=$seoul_per?>%)</td>
							<td width="115"> - 대전 : <?=number_format($daejeon);?> 명 (<?=$daejeon_per?>%)</td>
							<td width="115"> - 전북 : <?=number_format($jeonbuk);?> 명 (<?=$jeonbuk_per?>%)</td>
						</tr>
						<tr>
							<td width="115"> - 경기 : <?=number_format($gyeonggi);?> 명 (<?=$gyeonggi_per?>%)</td>
							<td width="115"> - 경북 : <?=number_format($gyeongbuk);?> 명 (<?=$gyeongbuk_per?>%)</td>
							<td width="115"> - 전남 : <?=number_format($jeonnam);?> 명 (<?=$jeonnam_per?>%)</td>
						</tr>
						<tr>
							<td width="115"> - 인천 : <?=number_format($incheon);?> 명 (<?=$incheon_per?>%)</td>
							<td width="115"> - 경남 : <?=number_format($gyeongnam);?> 명 (<?=$gyeongnam_per?>%)</td>
							<td width="115"> - 광주 : <?=number_format($gwangju);?> 명 (<?=$gwangju_per?>%)</td>
						</tr>
						<tr>
							<td width="115"> - 강원 : <?=number_format($gangwon);?> 명 (<?=$gangwon_per?>%)</td>
							<td width="115"> - 대구 : <?=number_format($daegu);?> 명 (<?=$daegu_per?>%)</td>
							<td width="115"> - 제주 : <?=number_format($jeju);?> 명 (<?=$jeju_per?>%)</td>
						</tr>
						<tr>
							<td width="115"> - 충북 : <?=number_format($chungbuk);?> 명 (<?=$chungbuk_per?>%)</td>
							<td width="115"> - 울산 : <?=number_format($ulsan);?> 명 (<?=$ulsan_per?>%)</td>
							<td width="115"> - 해외 : <?=number_format($oversea);?> 명 (<?=$oversea_per?>%)</td>
						</tr>
						<tr>
							<td width="115"> - 충남 : <?=number_format($chungnam);?> 명 (<?=$chungnam_per?>%)</td>
							<td width="115"> - 부산 : <?=number_format($busan);?> 명 (<?=$busan_per?>%)</td>
							<td width="115">&nbsp;</td>
						</tr>
					</table>
				</li>
			</ul>
		</div>
		<div class="today_statistics">
			<table width="705" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<th class="left_none">날짜</th>
					<th colspan="2">전체방문</th>
					<th colspan="2">직접방문</th>
					<th colspan="2">가입</th>
					<th colspan="2">원글/댓글</th>
				</tr>
				<?
				$day .= " (".get_yoil($print_date[i]).")";
				for($i=0; $i<$limit; $i++) {
					$date = date("Y-m-d", time()-$i*24*60*60);
					$print_date[$i] = substr($date,2);
					$date_1 = date("Y-m-d", time()-($i-1)*24*60*60);
					// 방문자 수
					$temp = sql_fetch("select vs_count from `g5_visit_sum` where vs_date='$date'");
					$count_visit[$i] = intval($temp[vs_count]);
					if($max_count_visit<$count_visit[$i]) $max_count_visit = $count_visit[$i];
					// 직접 방문자 수 (referer가 없는 경우)
					$temp = sql_fetch("select count(*) as total from `g5_visit` where vi_date='$date' AND vi_referer=''");
					$count_direct[$i] = $temp[total];
					if($max_count_direct<$count_direct[$i]) { 
						$max_count_direct = $count_direct[$i];
						if($max_count_direct>$config[cf_3]){ mysql_query(" update g5_config set cf_3='$max_count_direct' "); }
					}
					// 가입자 수 (mb_datetime으로 확인)
					$temp = sql_fetch("select count(*) as total from `g5_member` where mb_datetime LIKE '$date%'");
					$count_join[$i] = $temp[total];
					if($max_count_join<$count_join[$i]) $max_count_join = $count_join[$i];
					// 로그인 수 (로그인 포인트가 없으면 계산 안되므로 안 띄운다)
					if($config[cf_login_point]) {
						$temp = sql_fetch("select count(*) as total from `g5_point` where po_rel_table='@login' AND po_datetime LIKE '$date%'");
						$count_login[$i] = $temp[total];
						if($max_count_login<$count_login[$i]) $max_count_login = $count_login[$i];
						if($max_count_login>$config[cf_2]){
							mysql_query(" update g5_config set cf_2='$max_count_login' ");
						}
					}
					// 원글 수
					$temp = sql_fetch("select count(*) as total from `g5_board_new` where wr_id=wr_parent AND bn_datetime LIKE '$date%'");
					$count_article[$i] = $temp[total];
					if($max_count_article<$count_article[$i]) $max_count_article = $count_article[$i];
					// 댓글 수
					$temp = sql_fetch("select count(*) as total from `g5_board_new` where wr_id!=wr_parent AND bn_datetime LIKE '$date%'");
					$count_comment[$i] = $temp[total];
					if($max_count_comment<$count_comment[$i]) $max_count_comment = $count_comment[$i];
				}
				for ($i=0; $i<$limit; $i++) {
				?>
					<tr>
						<td class="left_none"><?=$print_date[$i]?> (<?=get_yoil($print_date[$i])?>)</td>
						<td class="today_no"><?=$count_visit[$i]?></td>
						<td width="124px"><img src="images/graph_horizontally.gif" width="<?=ceil($count_visit[$i]/$max_count_visit*$bar_width)?>" /></td>
						<td class="today_no"><?=$count_direct[$i]?></td>
						<td width="124px"><img src="images/graph_horizontally.gif" width="<?=ceil($count_direct[$i]/$max_count_direct*$bar_width)?>" /></td>
						<td class="today_no"><?=$count_join[$i]?></td>
						<td width="124px"><img src="images/graph_horizontally.gif" width="<?=ceil($count_join[$i]/$max_count_join*$bar_width)?>" /></td>
						<td class="today_no"><?=$count_article[$i]?>/<?=$count_comment[$i]?></td>
						<td width="124px"><img src="images/graph_horizontally.gif" width="<?=ceil($count_article[$i]/$max_count_article*$bar_width)?>" /></td>
					</tr>
				<? } ?>
			</table>
		</div>
		<?
		// 날짜 설정
		if(!$fr_date) $fr_date = date("Y-m-d", strtotime("0 days ago"));
		if(!$to_date) $to_date = $g5[time_ymd];
		// 주사 지랄 방지
		$fr_date = substr($fr_date, 0, 10);
		$to_date = substr($to_date, 0, 10);
		$site = substr($site, 0, 10);
		$site_ori = $site;
		// 검색사이트들
		$site_arr = array("Google", "Nate", "Yahoo", "Daum", "Naver", "Bing");
		$surl_arr = array("Google" => "http://www.google.%", "Nate" => "%nate.com%", "Yahoo" => "%search.yahoo.com%", "Daum" => "%search.daum.net%", "Naver" => "%search.naver.com%", "Bing" => "http://www.bing.com%");
		$svar_arr = array("Google" => "q", "Nate" => "q", "Yahoo" => "p", "Daum" => "q", "Naver" => "query", "Bing" => "q");
		?>
		<div class="adm_search">
			<div class="total"><img src="images/point_icon.gif"> <b style="color:#5a5a5a;">외부 유입 검색어(키워드) 분석기</b></div>
			<div class="search_btn">
				<ul>
					<li><a href="<?=$PHP_SELF?>?to_date=<?=$to_date?>&fr_date=<?=$fr_date?>"><b>All</b></a></li>
					<? foreach($site_arr as $site) { ?><li><a href="<?=$PHP_SELF?>?site=<?=$site?>&to_date=<?=$to_date?>&fr_date=<?=$fr_date?>"><b><?=$site?></b></a></li><? } ?>
				</ul>
			</div>
			<div class="search_date">
				<form method="get" action="<?=$_SERVER[PHP_SELF]?>">
					* 시작 : <input type="text" name="fr_date" value="<?=$fr_date?>" class="basis_txt1" /> &nbsp;&nbsp; * 끝 : <input type="text" name="to_date" value="<?=$to_date?>" class="basis_txt1" />&nbsp; <input type="image" src="images/search_btn.gif" accesskey="s"  style="vertical-align:middle;" />
				</form>
				<form action="javascript:;" onsubmit="findsq(getElementById('sq').value)" />
					<p>* 결과내 검색 : <input type="text" name="sq" value="<?=$sq?>" class="basis_txt1" />&nbsp; <input type="image" src="images/search_btn.gif" accesskey="s" style="vertical-align:middle;" /><img src="images/reset_btn.gif" onclick="resetsq()" style="cursor:pointer; vertical-align:middle;"><span id="search_cnt"></span></p>
				</form>
				<?
				// vi_referer에서 사이트 찾고, vi_date로 범위 정하기, 정렬은 vi_id 역순 (속도 개선 필요)
				if(in_array($site_ori, $site_arr)) {
					$where1 = "vi_referer LIKE '{$surl_arr[$site_ori]}' ";
				} else { // 5개 사이트 모두 포함
					$where1 = " ( ";
					foreach($surl_arr as $site => $surl) {
						$where1 .= " vi_referer LIKE '$surl' OR ";
					}
					$where1 .= " 0 )";
				}
				$query = sql_query("select * from `$g5[visit_table]` where $where1 AND vi_date>='$fr_date' AND vi_date<='$to_date' order by vi_id desc");
				?>
				<p>
					<table width="705" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<th>날짜</th>
							<th>시간</th>
							<th>사이트</th>
							<th>검색어</th>
						</tr>
						<?
						$cnt = 0;
						$cnt2 = array();
						while($row = sql_fetch_array($query)) {
							// 어느 사이트인지 찾기
							foreach($surl_arr as $site => $surl) {
								if(strstr($row[vi_referer], str_replace("%", "", $surl))) {
									$engine = $site;
									break;
								}
							}
							// 검색문자열 찾기
							$regex = "/(\?|&){$svar_arr[$engine]}\=([^&]*)/i";
							preg_match($regex, $row[vi_referer], $matches);
							$querystr = $matches[2];
							// 보통 검색어 사이를 +로 넘긴다
							$querystr = str_replace("+", " ", $querystr);
							// %ab 이런 식으로 된 걸 바꿔주기
							$querystr = urldecode($querystr);
							// 네이버는 unicode로 된 경우도 있어서
							if($engine=="Naver") $querystr = utf8_urldecode($querystr);
							// 캐릭터셋이 UTF-8인 경우는 EUC-KR로 고치기 (UTF-8 유저는 EUC-KR과 UTF-8을 서로 바꿔주면 될 듯)
							$charset = mb_detect_encoding($querystr, "ASCII, EUC-KR, UTF-8");
							if($charset=="EUC-KR") $querystr = iconv("UTF-8", "EUC-KR", $querystr);
							// 자잘한 처리들
							$querystr = trim($querystr);
							$querystr = htmlspecialchars($querystr);
							// 가끔 빈 것들도 있다 -_-
							if(!strlen($querystr)) continue;
							// 에코
							echo "<tr><td>$row[vi_date]</td>";
							echo "<td>$row[vi_time]</td>";
							echo "<td><a href=\"$PHP_SELF?site=$engine\"><img src=\"$g5[admin_path]/img/".strtolower($engine).".jpg\" /></a></td>";
							echo "<td style=\"text-align:left\" id=\"m3sqtd[$cnt]\"><a href=\"$row[vi_referer]\" target=\"_blank\">$querystr</a></td></tr>\n";
							// 카운트용 변수
							$cnt++;
							$cnt2[$engine]++;
						}
						ksort($cnt2);

						// 베짱이님 제공 함수
						function utf8_urldecode($str, $chr_set='CP949') {
							$callback_function = create_function('$matches, $chr_set="'.$chr_set.'"', 'return iconv("UTF-16BE", $chr_set, pack("n*", hexdec($matches[1])));');
							return rawurldecode(preg_replace_callback('/%u([[:alnum:]]{4})/', $callback_function, $str));
						}
						?>
					</table>
				</p>
				<p>Total : <?=$days=(strtotime($to_date)-strtotime($fr_date))/(24*60*60)+1?> days, <?=$cnt?> results (<?=sprintf("%.1f",$cnt/$days)?>/day)</p>
				<? 
				if(!$site_ori) { // 모든 사이트의 경우 비율 분석
					foreach($cnt2 as $engine => $count) {
						echo "$engine : $count (".sprintf("%.1f",$count/$cnt*100)."%)<br />";
					}
				}
				?>
			</div>
		</div>
	</div>

<? include_once("./admin_tail.php"); ?>