<?php
	include_once('./_common.php');

	if(!$is_member)alert('회원이용 서비스 입니다.',G5_BBS_URL.'/login.php');
	$mt_set_page =  'sub05';
	$mt_set_dep2  = '01'; 

	include_once(G5_PATH.'/_head.php');

	$gopage = $page;

	$ser_sql1 = " and mb_id = '$member[mb_id]' ";

	//게시판 목록보기에 필요한 각종 변수 초기값을 설정합니다.
	$tablename="g5_write_reservation"; //테이블 이름
	if($gopage == '') $gopage = 1; //페이지 번호가 없으면 1
	$list_num = G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages']; //한 페이지에 보여줄 목록 갯수
	$page_num = 10; //한 화면에 보여줄 페이지 링크(묶음) 갯수
	$offset = $list_num*($gopage-1); //한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)

	//전체 글 수를 구합니다. (쿼리문을 사용하여 결과를 배열로 저장하는 일반적 인 방법)
	$query="select count(*) as cnt from $tablename where 1 $ser_sql1 $ser_sql2 $ser_sql3 $ser_sql4 $ser_sql5"; // SQL 쿼리문을 문자열 변수	에 일단 저장하고
	$result = sql_fetch($query);
	$total_no = $result[cnt]; //배열의 첫번째 요소의 값, 즉 테이블의 전체 글 수를 저장합니다.

	//전체 페이지 수와 현재 글 번호를 구합니다.
	$total_page=ceil($total_no/$list_num); // 전체글수를 페이지당글수로 나눈 값의 올림 값을 구합니다.
	$cur_num=$total_no - $list_num*($gopage-1); //현재 글번호

	$gopagesize = 10;

	$p_start=(ceil($gopage/$gopagesize)-1)*$gopagesize+1; //시작페이지수
	$p_last=ceil($gopage/$gopagesize)*$gopagesize; //마지막페이지

	if($p_last>$total_page)$p_last=$total_page; //마지막페이지가 전체보다크면 마지막페이지를 전체페이지수로
	$p_next=$p_start+$gopagesize; //다음페이지의 페이지번호
	$p_prev=$p_start-$gopagesize; //이전페이지의 페이지번호
	if($p_next>=$total_page)$p_next=$total_page; //다음페이지번호가 전체보다 크면 전체페이지수로
	if($p_prev<=0)$p_prev=1; //이전페이지번호가 0보다 작으면 1로셋팅

	//bbs테이블에서 목록을 가져옵니다. (위의 쿼리문 사용예와 비슷합니다 .)
	$query2="select * from $tablename where 1 $ser_sql1 $ser_sql2 $ser_sql3 $ser_sql4 $ser_sql5 order by wr_num, wr_reply limit $offset, $list_num"; // SQL 쿼리문
	//echo $query2;
	$result2 = sql_query($query2);

	$write_pages = get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $gopage, $total_page, $PHP_SELF.'?');

?>
<div id="bo_list" class="U_bd_list PC_pd_lt50 PC_pd_rt50 U_area_wd01 T_ps_rl T_ft_ct sub3_bd_list">
    <!-- 게시판 페이지 정보 및 버튼 시작 { -->
    <div id="bo_btn_top" class="T_ft_ct <?php if ($is_category) echo 'PC_fl_rt '?>">
        <div id="bo_list_total" class="sound_only">
            <span>Total <?php echo number_format($total_no) ?>건</span>
            <?php echo $gopage ?> 페이지
        </div>
    </div>
    <!-- } 게시판 페이지 정보 및 버튼 끝 -->

    <form name="fboardlist" id="fboardlist" action="./board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="sw" value="">

    <div class="U_table01" id="cel_reser">
        <table>
        <caption class="caption_blind"><?php echo $board['bo_subject'] ?> 목록</caption>
        <thead>
        <tr>
			<th scope="col">번호</th>
			<th scope="col">성명</th>
			<th scope="col " class="M_ds_non">연락처</th>
			<th scope="col " class="M_ds_non">소속</th>
			<th scope="col" class=" M_ds_non">등록일</th>
			<th scope="col">예약날짜</th>
			<th scope="col">예약상태</th>
			<th scope="col">상세보기</th>
        </tr>
        </thead>
        <tbody>
        <?php
			for ($i=0; $rs=sql_fetch_array($result2); $i++){
		?>
        <tr class="<?php if ($list[$i]['is_notice']) echo "bo_notice"; ?>">
            <td class="td_num2">
            <?php
				echo $cur_num;
			?>
            </td>

            <td style="padding-left:<?php echo $list[$i]['reply'] ? (strlen($list[$i]['wr_reply'])*10) : '0'; ?>px">
				<span class="T_ft_ct T_ds_block T_wd_full"><?=$rs['wr_1']?></span>
            </td>
			<?php
				$tel = explode("-",$rs['wr_2']);
				if($tel[1]){
					$tel_ = $tel[0]."-".$tel[1]."-****";
				}else{
					$tel_ = substr($rs['wr_2'],0,3)."-".substr($rs['wr_2'],3,4)."-****";
				}
			
			?>
            <td class="td_datetime M_ds_non"><?=$tel_?></td>
            <td class="td_datetime "><?=$rs['wr_6']?> <?=$rs['wr_7']?></td>
            <td class="td_datetime M_ds_non"><?=$rs['wr_datetime']?></td>
            <td class="td_datetime M_ds_non"><?=$rs['wr_10']?></td>
            <td class="td_datetime ">
				<?php if($rs['wr_15'] == "1"){ echo "예약완료"; }else{ echo "승인대기"; } ?>
			</td>
			<td><a href="<?php echo G5_BBS_URL?>/board.php?bo_table=reservation&wr_id=<?=$rs[wr_id]?>&page_type=mypage" class="U_cl_btn01 T_pd_ht5 T_pd_wd10">상세보기 </a>
        </tr>
        <?php
				$cur_num--;
			} 
		?>
        <?php 
			$mt_colspan = 8;
			if($is_admin) $mt_colspan = 9;
			if ($i == 0) { echo '<tr><td colspan="'.$mt_colspan.'" class="empty_table M_ds_non">등록하신 예약이 없습니다.</td></tr>'; } 
			if ($i == 0) { echo '<tr><td colspan="5" class="empty_table PT_ds_non">등록하신 예약이 없습니다.</td></tr>'; } 
		?>
        </tbody>
        </table>
    </div>

    <div class="U_btn_wrap01 T_mg_top30">        
		<?php echo $write_pages;  ?>
    </div>

    </form>
	<!-- 페이지 -->
</div>

<?php
include_once(G5_PATH.'/_tail.php');
?>