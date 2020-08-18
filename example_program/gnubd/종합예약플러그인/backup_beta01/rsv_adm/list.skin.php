<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 6;

if ($is_checkbox) $colspan++;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
	/*
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
	}2020-05-14
	*/
?>
<h2 id="container_title"><?php echo ($board['bo_mobile_subject'] ? $board['bo_mobile_subject'] : $board['bo_subject']) ?><span class="sound_only"> 목록</span></h2>

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


    <?if($is_admin || $member['mb_level'] > 7){?>
	<div class="U_wrap01">
		<?
			$http_host = $_SERVER['HTTP_HOST'];
			$request_uri = $_SERVER['REQUEST_URI'];
			$url = 'http://' . $http_host . $request_uri;

			if($_POST['lbo'] == '1'){
				$set_table = $g5['write_prefix'].$_POST['lbo_table'];
				$sql = "SELECT 1 FROM ".$set_table;
				$ck_db =sql_query($sql);
				if(!$ck_db){
					$msg = '게시판이 존재하지 않습니다!';
				}else{
					$set_table = $g5['board_table'];
					$sql = "update  ".$set_table." set bo_1 = '".$_POST['lbo_table']."' where bo_table = '".$bo_table."'";
					$resulte = sql_query($sql,false);
					$msg = '적용완료 했습니다.';
				}
				alert($msg,$url);	
			}
		?>
		<form action="<?=$url?>" id="ch_lbo" name="ch_lbo" method="post">
			<?if($member['mb_id'] =='super' || $member['mb_id'] =='admin'){?>
			<div class="TM_ds_inbl">
				<label for="lbo_table" class="U_tit" >연동게시판</label>
				<input type="text" id="lbo_table" name="lbo_table" value="<?=$board['bo_1']?>" class="required frm_input"/>
				<input type="hidden" id="lbo" name="lbo" value="" />
			</div>
			<input value="저장하기" type="submit" class="TM_ds_block U_btn01" />
			<?}else{?>
				<input type="hidden" id="lbo_table" name="lbo_table" value="<?=$board['bo_1']?>"/>
			<?}?>
			
			<?if($board['bo_1']){?>
			<a href="<?=G5_BBS_URL?>/board.php?bo_table=<?=$board['bo_1']?>" class="TM_ds_block U_btn01 U_ft_ct">예약게시판 바로가기</a>
			<?}?>
		</form>
		<script>
			$('#ch_lbo').on('submit',function(){
				$('#lbo').val('1');
			});
		</script>
	</div>
    <?}?>

    <div class="bo_fx">
        <div id="bo_list_total">
            <span>Total <?php echo number_format($total_count) ?>건</span>
            <?php echo $page ?> 페이지
        </div>
        <fieldset id="bo_sch">
            <legend>게시물 검색</legend>
            <form name="fsearch" method="get">
            <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
            <input type="hidden" name="sca" value="<?php echo $sca ?>">
            <input type="hidden" name="sop" value="and">
            <label for="sfl" class="sound_only">검색대상</label>
            <select name="sfl">
                <option value="wr_subject"<?php echo get_selected($sfl, 'wr_subject', true); ?>>제목</option>
            </select>
            <input name="stx" value="<?php echo stripslashes($stx) ?>" placeholder="검색어(필수)" required id="stx" class="required frm_input" size="15" maxlength="20">
            <input type="submit" value="검색" class="btn_submit">
            </form>
        </fieldset>
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
			<th scope="col" style="width:50px;">번호</th>
            <th scope="col" style="width:530px;">예약명</th>
			<th>일정기간</th>
			<th>진행시간</th>
			<th>인원제한</th>
        </tr>
        </thead>
        <tbody>
			

        <?php
        for ($i=0; $i<count($list); $i++) {
        ?>

        <tr class="<?php if ($list[$i]['is_notice']) echo "bo_notice"; ?>">
            <?php if ($is_checkbox) { ?>
            <td class="td_chk">
                <label for="chk_wr_id_<?php echo $i ?>" class="sound_only"><?php echo $list[$i]['subject'] ?></label>
                <input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
            </td><?php } ?>
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
                </a>
			</td>
            <td class="" style="text-align:center">
				<?php
					if($list[$i]['wr_3'] == "week"){
						$arr = explode("|",$list[$i]['wr_4']);
						for($j=0;$j < count($arr);$j++ ){
							echo $arr[$j].' ';	
						}
					}
					else if($list[$i]['wr_3'] == "oneday"){
						echo $list[$i]['wr_4'];
					}
					else if($list[$i]['wr_3'] == "term"){
						echo $list[$i]['wr_4'].' ~ '.$list[$i]['wr_5'];
					}
				?>
			</td>
			<td style="text-align:center">
				<?echo $list[$i]['wr_6'] ? $list[$i]['wr_6']  : '제한없음'?>
			</td>
            <td class="" style="text-align:center">
				<?= $list[$i]['wr_2'] ? $list[$i]['wr_2'] : '제한없음'?>
			</td>
        </tr>
        <?php } ?>
        <?php if (count($list) == 0) { echo '<tr><td colspan="'.$colspan.'" class="empty_table">설정된 예약이 없습니다.</td></tr>'; } ?>
        </tbody>
        </table>
    </div>

    <?php if ($list_href || $is_checkbox || $write_href) { ?>
    <div class="bo_fx">
        <?php if ($rss_href || $write_href) { ?>
            <ul class="btn_bo_user">
                <?php if ($rss_href) { ?><li><a href="<?php echo $rss_href ?>" class="btn_b02">RSS</a></li><?php } ?>
                <?php if ($admin_href) { ?><li><a href="<?php echo $admin_href ?>" class="btn_admin">관리자</a></li><?php } ?>
				<?php if ($write_href) { ?><li clss="write_btn"><a href="<?php echo $write_href ?>" class="btn_b02">예약추가</a></li><?php } ?>
            </ul>
         <?php } ?>
         
        <ul class="btn_bo_adm">
            <?php if ($list_href) { ?>
            <li><a href="<?php echo $list_href ?>" class="btn_b02"> 목록</a></li>
            <?php } ?>
            <?php if ($is_checkbox) { ?>
            <li><input type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value"></li>
			<?if($member['mb_level'] == 10){?>
			<li><input type="submit" name="btn_submit" value="선택복사" onclick="document.pressed=this.value"></li>
			<li><input type="submit" name="btn_submit" value="선택이동" onclick="document.pressed=this.value"></li>
			<?php }} ?>
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
