<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 6;

if ($is_checkbox) $colspan++;




// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
	if($board['bo_1'] == 'center'){
		$align = 'text-align:center;';
	}
	if($board['bo_1'] == 'left'){
		$align = 'text-align:left;';
	}
	if($board['bo_1'] == 'right'){
		$align = 'text-align:right;';
	}
	if($board['bo_1'] == ''){
		$align = 'text-align:left;';
	}
include_once($board_skin_path."/add_module.php");
include_once($board_skin_path."/list.adm.skin.php");

?>

<h2 id="container_title" style="font-size:30px;color:#000"><?php echo ($board['bo_mobile_subject'] ? $board['bo_mobile_subject'] : $board['bo_subject']) ?><span class="sound_only"> 목록</span></h2>



<div style="padding:30px 0;border-bottom:1px dashed #d9d9d9">
	<?php echo get_view_thumbnail($board['bo_9']); ?>
</div>

<?
if($board['bo_1']){
//add_calendar (캘린더 추가하는부분)
$hd_day = hd_lists('month');
?>
<div class="U_wrap02">
	<div class="tbl_head01 tbl_wrap">
		<div class="cal_navi" style="margin-bottom:15px">
			<h3><?php echo $year?> 년 <?php echo $month?> 월</h3>
			<!-- search -->
			<form id="frmSel" name="frmSel" method="get"  action="<?php echo G5_BBS_URL;?>/board.php">
			<input type="hidden" name="bo_table" id="bo_table" value="<?php echo $bo_table;?>" />
			<input type="hidden" id="year" name="year" value=<?php echo $year?> />
			<input type="hidden" id="month" name="month" value=<?php echo $month?> />
			<input type="hidden" id="day" name="day" value=<?php echo $day?> />
			<fieldset class="search3">
				<legend>검색</legend>
				<select id="sch_year" name="sch_year"  title="검색 옵션 선택">
				<?php
				$curr_year = 2020;
				for($i=$curr_year ; $i<=(substr(G5_TIME_YMD, 0, 4)+1) ; $i++) {
					if($i==$year) {	
						echo '<option value="'.$i.'" selected>'.$i.'</option>';	
					}
					else {	
						echo '<option value="'.$i.'">'.$i.'</option>';	
					}
				}
				?>
				</select>
				<select id="sch_month" name="sch_month"  title="검색 옵션 선택">
				<?php
				for ($i=1 ; $i<=12 ; $i++) {
					if (strlen($i) == "1") {	
						$tempI = "0".$i;	
					}
					else {	
						$tempI = $i;	
					}

					if ($tempI==$month) {	
						echo '<option value="'.$tempI.'" selected>'.$i.'월</option>';	
					}
					else {
						echo '<option value="'.$tempI.'">'.$i.'월</option>';	
					}
				}
				?>
				</select>
			</fieldset>
			</form>
		</div>
		
		<ul class="U_btns01">
			<li><a href="<?=$list_url.'&year='.$preyear.'&month='.$month.'&day=01'?>"><i class="fas fa-angle-double-left"></i></a></li>
			<li><a href="<?=$list_url.'&year='.$prev_year.'&month='.$prev_month.'&day=01'?>"><i class="fas fa-chevron-left"></i></a></li>
			<li><a href="<?=$list_url.'&year='.$next_year.'&month='.$next_month.'&day=01'?>"><i class="fas fa-chevron-right"></i></a></li>
			<li><a href="<?=$list_url.'&year='.$nextyear.'&month='.$month.'&day=01'?>"><i class="fas fa-angle-double-right"></i></a></li>
		</ul>

		<table class="wrap_calendar">
		<colgroup>
			<col width="14%" span="7" />
		</colgroup>
		<thead>
			<tr>
				<th scope="col" style="color: #e05349;">일</th>
				<th scope="col">월</th>
				<th scope="col">화</th>
				<th scope="col">수</th>
				<th scope="col">목</th>
				<th scope="col">금</th>
				<th scope="col" style="color: #49a1e0;">토</th>
			</tr>
		</thead>
		<tbody>
		<tr>
			<?php
			if($year)$sch_year = $year;
			if($month)$sch_month = $month;
			//print_r2($hd_day);
			$total_day = date('t', strtotime($sch_year.'-'.$sch_month.'-01'));
			$first_day      = date('w', mktime(0, 0, 0, $sch_month, 1, $sch_year));
			$count          = 0;
			$weekcut        = 0; // 한주가 지나면 초기화

			for ($i=0; $i<$first_day; $i++) {
				echo '<td><span class="date_head none">&nbsp;</span></td>'.PHP_EOL;
				$count++;
			}

			for ($days=1; $days<=$total_day; $days++) {
				$count++;
				$hd_color = false;
				$echoDays = '';
				$dayTxt = $days < 10 ? '0'.$days : $days; 
				$vDate = $sch_year ."-". $sch_month ."-". sprintf('%02d', $days); // 표시 날짜.
				$timestamp = strtotime( $vDate );
				$now = strtotime( date( 'Y-m-d' ) );
				echo '<td style="vertical-align: top;" data-date="'.$vDate.'">'.PHP_EOL;
				echo '<a href="'.G5_BBS_URL.'/board.php?bo_table='.$bo_table.'&year='.$sch_year.'&month='.$sch_month.'&day='.$dayTxt.'">'.PHP_EOL;
				
				if($hd_day[$days < 10 ? '0'.$days : $days]){
					$echoDays = $days;
					$echoDays .= '<span>'.$hd_day[$days < 10 ? '0'.$days : $days]['ca_name'].'</span>';
					$echoDays .= '<span class="hd_txt">'.$hd_day[$days < 10 ? '0'.$days : $days]['wr_subject'].'</span>';
					$hd_color = true;
				}else{
					$echoDays = $days;
				}
				
				if ( $hd_color) {
					$setColor = 'style="color: #ff9900"';
				}else if ( $count == 1) {
					$setColor = 'style="color: #e05349"';
				} else if ($count == 7  ) {
					$setColor = 'style="color: #49a1e0"';
				} else {
					$setColor = '';
				}
				if((int)$day == $days)echo '<strong class="ch_days">선택날짜</strong>'; 
				echo '<span class="date_head" '.$setColor.'>'.$echoDays.PHP_EOL;

				echo '</span>'.PHP_EOL; 
				echo '</a>'.PHP_EOL;
				echo '</td>'.PHP_EOL;
				if($count==7) { // 토요일이 되면 줄바꾸기 위한 <tr>태그 삽입을 위한 식
					echo '</tr>'.PHP_EOL;
					if($days != $total_day) {
						echo '<tr>'.PHP_EOL;
						$count = 0;
					}
				}
			}

			// 선택한 월의 마지막날 이후의 빈테이블 삽입
			for ($days++; $total_day < $days && $count < 7;) {
				$count++;
				echo '<td><span class="date_head none">&nbsp;</span></td>'.PHP_EOL;
				if ($count == 7) 
					echo '</tr>'.PHP_EOL;
			}
			?>
		</tbody>
		</table>
	</div>
</div>

<script>
    $(function(){
        function dateDiff(_date1, _date2) {
            var diffDate_1 = new Date(_date1);
            var diffDate_2 = new Date(_date2);
        
            diffDate_1 =new Date(diffDate_1.getFullYear(), diffDate_1.getMonth()+1, diffDate_1.getDate());
            diffDate_2 =new Date(diffDate_2.getFullYear(), diffDate_2.getMonth()+1, diffDate_2.getDate());
        
            var diff = (diffDate_2.getTime() - diffDate_1.getTime());
            diff = Math.ceil(diff / (1000 * 3600 * 24));
            if(!diff && diff !==0){
                return 'NO';
            }
            return diff;
        }
        var mt_set_data = new Date();
        var set_today = mt_set_data.getFullYear() + '-' + ((mt_set_data.getMonth()+1) < 10 ? '0'+(mt_set_data.getMonth()+1): (mt_set_data.getMonth()+1)) + '-' + mt_set_data.getDate();
       $('.wrap_calendar tbody td').each(function(){
            var setD = dateDiff(set_today ,$(this).data('date'));
            if( setD == 'NO'){
                $(this).css({background:'#f9f9f9'})
            }else if(setD < 0){
                $(this).css({background:'#f9f9f9'})
            }else if(setD == 0){
                var set_txt = $(this).find('.date_head').text();
                $(this).find('.date_head').text(set_txt+'오늘');
            }
       });

	   $('#sch_year').on('change',function(){
			location.href = g5_bbs_url+'/board.php?bo_table=' + g5_bo_table + '&year='+$(this).val()+'&month=<?=$month?>&day=<?=$day?>'; 
	   });

	   
	   $('#sch_month').on('change',function(){
			location.href = g5_bbs_url+'/board.php?bo_table=' + g5_bo_table + '&year=<?=$year?>'+'&month='+$(this).val()+'&day=<?=$day?>';
	   });

    });
</script>

<?
//add_today_rg_list (선택한 날짜 예약 리스트)
?>
<div class="U_wrap02">
	<form action="<?=G5_BBS_URL.'/write.php'?>" method="post" onsubmit="return ck_submit(this);"">
		<input type="hidden" value="<?=$bo_table?>" name="bo_table"/>
		<input type="hidden" value="<?=$set_day ? $set_day : $today?>" name="set_day"/>
		<table class="U_table02">
			<caption class="">
				<span class="caption_tit"><?=$year?>년 <?=$month?>월 <?=$day?>일 예약목록</span>
				<span class="sb_1 sb">예약대기</span>
				<span class="sb_2 sb">취소신청</span>
				<span class="sb_3 sb">승인완료</span>
			</caption>
			<thead>
			<? //일일 일정 나오는 부분
				$link_list_arr = ch_lists($set_day, $date);
				$hd_day = hd_lists('day');
				
				if(gettype($hd_day) == 'array'){
					$hd_day_arr = [];
					for($i = 0;$i < count($hd_day);$i++){
						$hd_day_arr[$hd_day[$i]['wr_2']][] = $hd_day[$i];
					}
				}
				
				if($hd_day['state'] == 'true')  $link_list_arr = [];
				if($hd_day['state'] == 'false'){
			?>
				<tr style="border-bottom:1px solid #d9d9d9;text-align:center;">
					<td colspan="6">
						<strong class="U_title02">금일 안내</strong>
						<ul class="U_info" style="padding-bottom:30px">
						<?
						for($i=0;$i < count($hd_day['allTit']);$i++){
						?>
							<strong><?=$hd_day['allTit'][$i]?></strong>
							<div class="U_info_conbox"><?=$hd_day['allMage'][$i]?></div>
						<?
						}
						?>
						</ul>
					</td>
				</tr>
			<?	}?>
				<tr >
					<th>선택</th>
					<th>에약명</th>
					<th>예약시간</th>
					<th>예약자</th>
					<th>예약인원</th>
					<th>예약하기</th>
				</tr>
			</thead>
			<tbody>
		<?
			for($i=0; $i < count($link_list_arr); $i++){
				$ch_rv = ch_lt($link_list_arr[$i]['wr_id'],$set_day,$link_list_arr[$i]);
		?>
			<tr>
				<? if($hd_day_arr &&  $hd_day_arr[$link_list_arr[$i]['wr_id']] && $hd_day_arr[$link_list_arr[$i]['wr_id']][0]['ca_name'] !=='공지'){?>
					<td colspan="6"><?=$link_list_arr[$i]['wr_subject']?> 강의는 휴강입니다.</td>
				<?}else{?>
				<td>
					<?if($ch_rv['rv-state'] !== 'false' && ch_limo() !== 'false'){?>
						<input type="checkbox" value="<?=$link_list_arr[$i]['wr_id']?>" name="link_wr_id[]" />
					<?}else{
						echo '선택불가';
					}
					?>
				</td>
				<td style="text-align:left"><?=$link_list_arr[$i]['wr_subject']?>
					<?
					if($board['bo_7'] == '1' && $link_list_arr[$i]['wr_9']){
					?>
					<div style="margin-top:10px;font-size:12px;text-align:left">가격 : <?=display_price($link_list_arr[$i]['wr_9'],0)?></div>
					<?}?>
				</td>	
				<td><?=$link_list_arr[$i]['wr_6'] ? $link_list_arr[$i]['wr_6'] : '제한없음' ?></td>	
				<td>
					<?
						$booker = ch_member($link_list_arr[$i]['wr_id']);
						$set_counter = 0;
						for($j=0;$j < count($booker);$j++){							
							$set_counter += (int)$booker[$j]['wr_6'];
							if($booker[$j]['mb_id'] == $member['mb_id'] || $member['mb_level'] > 7){
								echo '<a href= "'.G5_BBS_URL.'/board.php?bo_table='.$bo_table.'&wr_id='.$booker[$j]['wr_id'].'" >';
							}

							$set_txt = $member['mb_level'] > 7 ? $booker[$j]['wr_name'] :  preg_replace('/.(?=.$)/u','*',$booker[$j]['wr_name']);
							
							$color ='';
							if($booker[$j]['wr_4'] == '예약완료')$color = 'type01';
							if($booker[$j]['wr_4'] == '예약취소')$color = 'type02';
							if($booker[$j]['wr_4'] == '취소신청')$color = 'type02';
							
							echo '<div class="user_ft '.$color.'" style="padding:5px 0">'.$set_txt.'</div>';
							if($booker[$j]['wr_id'] == $member['mb_id'] || $member['mb_level'] > 7){
								echo '</a>';
							}
						}
						if(count($booker) == 0){
							echo '예약자없음';
						}
					?>
				</td>	
				<td><?= $link_list_arr[$i]['wr_2']? ($set_counter.'명/'.$link_list_arr[$i]['wr_2'].'명') : $set_counter.'명/'.'인원제한없음' ?></td>
				<td>
					<?
					//print_r2($ch_rv);
					if(ch_limo() == 'false'){
						echo '예약불가';
					}else if($ch_rv['rv-state'] !== 'false' ){?>
						<a href="<?=G5_BBS_URL.'/write.php?bo_table='.$bo_table?>&link_wr_id=<?=$link_list_arr[$i]['wr_id']?>&set_day=<?=$set_day ? $set_day : $today?>"  class="U_btn01">예약하기</a>
					<?}else{
						echo '마감';
					}?>
				</td>
				<?}?>
			</tr>

				<?
					if($hd_day_arr && $hd_day_arr[$link_list_arr[$i]['wr_id']]){
						$setArr = $hd_day_arr[$link_list_arr[$i]['wr_id']];
				?>
			<tr>
				<td colspan="6" style="padding:0">
					<?//print_r2($hd_day_arr[$link_list_arr[$i]['wr_id']])?>
						<ul class="U_info">
						<?
						for($j=0;$j < count($setArr);$j++){
						?>
							<strong><i class="fas fa-level-up-alt" style="transform:rotate(90deg);margin-right:10px"></i>[<?=$setArr[$j]['ca_name']?>]<?=$setArr[$j]['wr_subject']?></strong>
							<div class="U_info_conbox"><?=$setArr[$j]['wr_content']?></div>
						<?
						}
						?>
						</ul>
				</td>
			</tr>
			<?}?>
		<?}
			if(count($link_list_arr) <= 0){
		?>
			<tr style="border-bottom:1px solid #d9d9d9">
				<td colspan="6"> <?if($hd_day['state'] == 'true'){
				?>

					<strong class="U_title02">금일은 휴일입니다.</strong>
					<ul class="U_info">
					<?
					for($i=0;$i < count($hd_day['allTit']);$i++){
					?>
						<strong><?=$hd_day['allTit'][$i]?></strong>
						<p><?=$hd_day['allMage'][$i]?></p>
					<?
					}
					?>
					</ul>
				<?
					}else{ echo '가능한 예약이 없습니다.';}
				?>
				</td>
			</tr>
		<?}else{?>
			<tr >
				<td colspan="6"><button type="submit" class="U_btn01" style="float:right;">선택예약</button></td>
			</tr>
		<?}
		?>
			</tbody>
		</table>
	</form>
</div>

<script>
		function ck_submit(f){
			//;link_wr_id.name
			var ch_cnt = 0;
			for(var i =0; i < f.elements.length;i++){
				console.log(f.elements[i].name);
				if(f.elements[i].name == 'link_wr_id[]' && f.elements[i].checked )ch_cnt++;
			}
			if(ch_cnt < 1){
				alert('1개이상 선택해주세요!');
				return false;
			}
		}
</script>

<?}else{
//add_today_list bo_1(연동게시판이 없을경우)
?>

<div style="text-align:center;font-size:18px;background:#f9f9f9;padding:30px 0;border-top:1px solid #d9d9d9;margin-bottom:30px">
	연동게시판을 먼저 설정해주세요.
</div>

<?}?>




<!-- 게시판 목록 시작 -->
<div id="bo_list<?php if ($is_admin) echo "_admin"; ?>">
    <?php if ($is_category) { ?>
    <nav id="bo_cate" class="cate_mo dropdown" style="padding-bottom: 10px;">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
		<?php //echo ($board['bo_mobile_subject'] ? $board['bo_mobile_subject'] : $board['bo_subject']) ?> 카테고리<span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
            <?php echo $category_option ?>
        </ul>
    </nav>
	
    <nav id="bo_cate_pc" class="cate_pc" style="padding-bottom: 10px;">
        <!--<h2><?php //echo ($board['bo_mobile_subject'] ? $board['bo_mobile_subject'] : $board['bo_subject']) ?> </h2>-->
        <div id="bo_cate_pc_ul">
            <?php echo $category_option ?>
        </div>
    </nav>
	<script>
		$('#bo_cate_pc_ul li').each(function(){
			$(this).attr('class','btn_b02');
		});
		
		if($(window).width() <= 767){
			$('#bo_cate_pc').hide();
			$('#bo_cate').show();
		}
		else{
			$('#bo_cate_pc').show();
			$('#bo_cate').hide();
		}
		
		$(window).resize(function(){
			if($(window).width() <= 767){
				$('#bo_cate_pc').hide();
				$('#bo_cate').show();
			}
			else{
				$('#bo_cate_pc').show();
				$('#bo_cate').hide();
			}
		});
		
	</script>
	<?php } ?>

    <div class="bo_fx">
        <div id="bo_list_total">
            <span>Total <?php echo number_format($total_count) ?>건</span>
            <?php echo $page ?> 페이지
        </div>

		<?if($member['mb_level'] >7 || !$is_member){?>
        <fieldset id="bo_sch">
            <legend>게시물 검색</legend>

            <form name="fsearch" method="get">
            <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
            <input type="hidden" name="sca" value="<?php echo $sca ?>">
            <input type="hidden" name="sop" value="and">
			<input type="hidden" id="year" name="year" value=<?php echo $year?> />
			<input type="hidden" id="month" name="month" value=<?php echo $month?> />
			<input type="hidden" id="day" name="day" value=<?php echo $day?> />

            <label for="sfl" class="sound_only">검색대상</label>
            <select name="sfl">
				<?/*
                <option value="wr_subject"<?php echo get_selected($sfl, 'wr_subject', true); ?>>제목</option>
                <option value="wr_content"<?php echo get_selected($sfl, 'wr_content'); ?>>내용</option>
                <option value="wr_subject||wr_content"<?php echo get_selected($sfl, 'wr_subject||wr_content'); ?>>제목+내용</option>
                <option value="mb_id,1"<?php echo get_selected($sfl, 'mb_id,1'); ?>>회원아이디</option>
                <option value="mb_id,0"<?php echo get_selected($sfl, 'mb_id,0'); ?>>회원아이디(코)</option>
                <option value="wr_name,1"<?php echo get_selected($sfl, 'wr_name,1'); ?>>글쓴이</option>
                <option value="wr_name,0"<?php echo get_selected($sfl, 'wr_name,0'); ?>>글쓴이(코)</option>
				*/?>
				<option value="wr_name,1"<?php echo get_selected($sfl, 'wr_name,1'); ?>>신청자</option>
                <option value="mb_id,1"<?php echo get_selected($sfl, 'mb_id,1'); ?>>회원아이디</option>
                <option value="wr_2,1"<?php echo get_selected($sfl, 'wr_2,1'); ?>>날짜</option>

			</select>
            <input name="stx" value="<?php echo stripslashes($stx) ?>" placeholder="검색어(필수)" required id="stx" class="required frm_input" size="15" maxlength="20">
            <input type="submit" value="검색" class="btn_submit">
            </form>
        </fieldset>
		<?}?>
    </div>
    
    <form name="fboardlist" id="fboardlist" action="./board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="sw" value="">

    <div class="tbl_head01 tbl_wrap">
        <table>
        <thead>
        <tr>
            <?php if ($is_checkbox) { ?>
            <th scope="col">
                <label for="chkall">현재 페이지 게시물 전체</label>
                <input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);">
            </th>
            <?php } ?>
			<?/*
			<th scope="col" style="width:50px;">번호</th>
            <th scope="col" style="width:530px;">제목</th>
            */?>
			<th scope="col" style="width:100px;">신청자</th>
			<!--<th scope="col" style="width:100px;">상태</th>-->
			<th scope="col"style="width:130px;"><?php echo subject_sort_link('wr_2', $qstr2, 1) ?>전화번호</a></th>
			<th scope="col"style="width:130px;"><?php echo subject_sort_link('wr_3', $qstr2, 1) ?>예약상태</a></th>
			<th scope="col"style="width:130px;"><?php echo subject_sort_link('wr_4', $qstr2, 1) ?>예약일</a></th>
			<?if($is_admin2){?>
			<th scope="col"style="width:20px;">보기</th>
			<?}?>
        </tr>
        </thead>
        <tbody>
			

        <?php
		for ($i=0; $i<count($list); $i++) {
        ?>

        <tr class="J_list_base <?php if ($list[$i]['is_notice']) echo "bo_notice"; ?>">
            <?php if ($is_checkbox) { ?>
            <td class="td_chk">
                <label for="chk_wr_id_<?php echo $i ?>" class="sound_only"><?php echo $list[$i]['subject'] ?></label>
                <input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
            </td><?php } ?>
			<?/*
			<td style="text-align: center;"><?=$i+1?></td>
            <td class="td_subject" style="<?=$align;?> ">
                <?php
                if ($is_category && $list[$i]['ca_name']) {
                ?>                
				<a href="<?php echo $list[$i]['ca_name_href'] ?>" class="bo_cate_link"><?php echo $list[$i]['ca_name'] ?></a>
                <?php } ?>

                <a href="<?php echo $list[$i]['href'] ?>">
				<?echo $list[$i]['icon_reply'];?>
                    <?php echo $list[$i]['subject'] ?>
					<?php if ($list[$i]['comment_cnt']) { ?> 댓글 <?php echo $list[$i]['comment_cnt']; ?>개<?php } ?>
					<?php
                    // if ($list[$i]['link']['count']) { echo '['.$list[$i]['link']['count']}.']'; }
                    // if ($list[$i]['file']['count']) { echo '<'.$list[$i]['file']['count'].'>'; }

                    if (isset($list[$i]['icon_new'])) echo $list[$i]['icon_new'];
                    if (isset($list[$i]['icon_hot'])) echo $list[$i]['icon_hot'];
                    if (isset($list[$i]['icon_file'])) echo $list[$i]['icon_file'];
                    if (isset($list[$i]['icon_link'])) echo $list[$i]['icon_link'];
                    if (isset($list[$i]['icon_secret'])) echo $list[$i]['icon_secret'];

                    ?>
                </a>
				*/?>
				<td style="text-align: center;">
					<a  href="<?php echo $list[$i]['href'] ?>">
					<?= $is_member ? $list[$i]['wr_name']: preg_replace('/.(?=.$)/u','*',$list[$i]['wr_name'])?>
					</a>
				</td>
            </td>
            <td class="td_date">
				<?= $is_member ? $list[$i]['wr_3']: preg_replace('/.(?!....)/u','*',$list[$i]['wr_3'])?>
			</td>
            <td class="td_date"><?php echo $list[$i]['wr_4'] ? $list[$i]['wr_4'] : '예약대기' ?></td>
            <td class="td_date"><?php echo $list[$i]['wr_2']?></td>
			<?if($is_admin2){?>
			<td style="padding:0">
				<button type="button" class="op_info">보기</button>
			</td> 
			<?}?>
        </tr>
		<?if($is_admin2){?>
		<tr class="J_list_info">
			<td style="text-align:center;border-bottom:1px #d9d9d9;padding-bottom:40px" colspan="6">
				<?
					$arr = explode('|',$list[$i]['wr_1']);
					$arr2 = explode('|',$list[$i]['wr_6']);
					$cnt = 0;
					foreach($arr as $value){
						$item = ch_list($value);
				?>
					<table class="U_table01" style="margin-bottom:10px">
						<tbody>
							<tr>
								<td>예약명</td>
								<td><?=$item['wr_subject']?></td>
							</tr>
							<?if($item['wr_6']){?>
							<tr>
								<td>예약날짜</td>
								<td><?=$item['wr_6']?></td>
							</tr>
							<?}?>

							<?if($board['bo_8'] == '1' ){?>
							<tr>
								<td>예약인원</td>
								<td><?echo $arr2[$cnt]; $cnt++;?>명</td>
							</tr>
							<?}?>
						</tbody>
					</table>	
				<?}?>
				<a class="U_btn02" href="<?php echo $list[$i]['href'] ?>">상세보기</a>
			</td>
		</tr>
		<?}?>
        <?php } ?>
        <?php if (count($list) == 0) { echo '<tr><td colspan="'.$colspan.'" class="empty_table">신청된 예약이 없습니다.</td></tr>'; } ?>
        </tbody>
        </table>
    </div>
	

    <?php if ($list_href || $is_checkbox || $write_href) { ?>
    <div class="bo_fx">
		<?/*
        <?php if ($rss_href || $write_href) { ?>
            <ul class="btn_bo_user">
                <?php if ($rss_href) { ?><li><a href="<?php echo $rss_href ?>" class="btn_b02">RSS</a></li><?php } ?>
                <?php if ($admin_href) { ?><li><a href="<?php echo $admin_href ?>" class="btn_admin">관리자</a></li><?php } ?>
                <?php if ($write_href) { ?><li clss="write_btn"><a href="<?php echo $write_href ?>" class="btn_b02">글쓰기</a></li><?php } ?>
            </ul>
         <?php } ?>
		 */?>
         
        <ul class="btn_bo_adm">
			<?php if ($member['mb_level']>7){ ?><li><a href="<?php echo $write_href ?>" class="btn_b02" id="ajax_pass">선택승인</a></li><?php } ?>
			<?php if ($member['mb_level']>7){ ?><li><a href="<?php echo $write_href ?>" class="btn_b02" id="ajax_cencel">선택취소</a></li><?php } ?>

            <?php if ($list_href) { ?>
            <li><a href="<?php echo $list_href ?>" class="btn_b02"> 목록</a></li>
            <?php } ?>
            <?php if ($is_checkbox) { ?>
            <li><input type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value"></li>
			<?/*
            <li><input type="submit" name="btn_submit" value="선택복사" onclick="document.pressed=this.value"></li>
            <li><input type="submit" name="btn_submit" value="선택이동" onclick="document.pressed=this.value"></li>
            */?>
			<?php } ?>
        </ul>
    </div>
    <?php } ?>
    
    </form>
</div>

<?php if($is_checkbox) { ?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>

<?if($member['mb_level'] > 7){?>
<script>
	$('.op_info').on('click',function(){
		$('.J_list_info').hide();
		if($(this).text() == '닫기'){
			$('.op_info').text('보기');
		}else{
			$('.op_info').text('보기');
			$(this).text('닫기');
			$(this).parents('tr').next('.J_list_info').slideDown();
		}

	});

	var arr = '';
	$('#ajax_pass').on('click',function(){
		arr ='';
		$('input[name="chk_wr_id[]"]:checked').each(function(){
			arr += $(this).val()+"|";
		});
		arr = arr.slice(0,-1);
		if(arr =='') {
			alert('1개이상 선택해주세요');
			return false;
		}
		location.href= g5_bbs_url+'/board.php?bo_table='+g5_bo_table+'&action=ps_rv&ps_data='+arr;
		return false;
	});	

	$('#ajax_cencel').on('click',function(){
		arr ='';
		$('input[name="chk_wr_id[]"]:checked').each(function(){
			arr += $(this).val()+"|";
		});
		arr = arr.slice(0,-1);
		if(arr =='') {
			alert('1개이상 선택해주세요');
			return false;
		}
		location.href= g5_bbs_url+'/board.php?bo_table='+g5_bo_table+'&action=ps_cl&ps_data='+arr;
		return false;
	});	


</script>
<?}?>

<!-- 페이지 -->
<?php echo $write_pages; ?>

<?php if ($is_checkbox) { ?>
<script>
function all_checked(sw) {
    var f = document.fboardlist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]")
            f.elements[i].checked = sw;
    }
}

function fboardlist_submit(f) {
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택복사") {
        select_copy("copy");
        return;
    }

    if(document.pressed == "선택이동") {
        select_copy("move");
        return;
    }

    if(document.pressed == "선택삭제") {
        if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다\n\n답변글이 있는 게시글을 선택하신 경우\n답변글도 선택하셔야 게시글이 삭제됩니다."))
            return false;

        f.removeAttribute("target");
        f.action = "./board_list_update.php";
    }

    return true;
}

// 선택한 게시물 복사 및 이동
function select_copy(sw) {
    var f = document.fboardlist;

    if (sw == 'copy')
        str = "복사";
    else
        str = "이동";

    var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

    f.sw.value = sw;
    f.target = "move";
    f.action = "./move.php";
    f.submit();
}
</script>
<?php } ?>
<!-- 게시판 목록 끝 -->
