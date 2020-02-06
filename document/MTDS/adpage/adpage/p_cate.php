<?php
include_once('./_common.php');
$g5['title'] = '제품카테고리관리';
$admin_cate_gubun = "exp";
include_once ('./admin.head.php');

$where = " where ";
$sql_search = "";
if ($stx != "") {
    if ($sfl != "") {
        $sql_search .= " $where $sfl like '%$stx%' ";
        $where = " and ";
    }
    if ($save_stx != $stx)
        $page = 1;
}

$sql_common = " from g5_shop_category ";
if ($is_admin != 'super')
    $sql_common .= " $where ca_mb_id = '{$member['mb_id']}' ";
$sql_common .= $sql_search;


// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

if (!$sst)
{
    $sst  = "ca_id";
    $sod = "asc";
}
$sql_order = "order by $sst $sod";

// 출력할 레코드를 얻음
$sql  = " select *
             $sql_common
             $sql_order
             limit $from_record, $rows ";
$result = sql_query($sql);

$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'" class="ov_listall">전체목록</a>';
?>

<div class="local_ov01 local_ov">
    <?php echo $listall; ?>
    생성된 분류 수 <?php echo number_format($total_count); ?>개
</div>

<form name="flist" class="local_sch01 local_sch">
<input type="hidden" name="page" value="<?php echo $page; ?>">
<input type="hidden" name="save_stx" value="<?php echo $stx; ?>">

<label for="sfl" class="sound_only">검색대상</label>
<select name="sfl" id="sfl">
    <option value="ca_name"<?php echo get_selected($_GET['sfl'], "ca_name", true); ?>>분류명</option>
    <option value="ca_id"<?php echo get_selected($_GET['sfl'], "ca_id", true); ?>>분류코드</option>
</select>

<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
<input type="text" name="stx" value="<?php echo $stx; ?>" id="stx" required class="required frm_input">
<input type="submit" value="검색" class="btn_submit">

</form>

<?php if ($is_admin == 'super') {?>
<div class="btn_add01 btn_add">
    <a href="./categoryform.php" id="cate_add">분류 추가</a>
</div>
<?php } ?>

<form name="fcategorylist" method="post" action="./categorylistupdate.php" autocomplete="off">
<input type="hidden" name="sst" value="<?php echo $sst; ?>">
<input type="hidden" name="sod" value="<?php echo $sod; ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
<input type="hidden" name="stx" value="<?php echo $stx; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">

<div id="sct" class="tbl_head02 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col" ><?php echo subject_sort_link("ca_id"); ?>분류코드</a></th>
        <th scope="col" id="sct_cate"><?php echo subject_sort_link("ca_name"); ?>분류명</a></th>
        <th scope="col" >관리</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++)
    {
        $level = strlen($row['ca_id']) / 2 - 1;
        $p_ca_name = '';

        if ($level > 0) {
            $class = 'class="name_lbl"'; // 2단 이상 분류의 label 에 스타일 부여 - 지운아빠 2013-04-02
            // 상위단계의 분류명
            $p_ca_id = substr($row['ca_id'], 0, $level*2);
            $sql = " select ca_name from g5_shop_category where ca_id = '$p_ca_id' ";
            $temp = sql_fetch($sql);
            $p_ca_name = $temp['ca_name'].'의하위';
        } else {
            $class = '';
        }

        $s_level = '<div><label for="ca_name_'.$i.'" '.$class.'><span class="sound_only">'.$p_ca_name.''.($level+1).'단 분류</span></label></div>';
        $s_level_input_size = 25 - $level *2; // 하위 분류일 수록 입력칸 넓이 작아짐 - 지운아빠 2013-04-02

        if ($level+2 < 3) $s_add = '<a href="./categoryform.php?ca_id='.$row['ca_id'].'&amp;'.$qstr.'">추가</a> '; // 분류는 5단계까지만 가능
        else $s_add = '';
        $s_upd = '<a href="./categoryform.php?w=u&amp;ca_id='.$row['ca_id'].'&amp;'.$qstr.'"><span class="sound_only">'.get_text($row['ca_name']).' </span>수정</a> ';

        if ($is_admin == 'super')
            $s_del = '<a href="./categoryformupdate.php?w=d&amp;ca_id='.$row['ca_id'].'&amp;'.$qstr.'" onclick="return delete_confirm(this);"><span class="sound_only">'.get_text($row['ca_name']).' </span>삭제</a> ';

        // 해당 분류에 속한 상품의 수
        $sql1 = " select COUNT(*) as cnt from {$g5['g5_shop_item_table']}
                      where ca_id = '{$row['ca_id']}'
                      or ca_id2 = '{$row['ca_id']}'
                      or ca_id3 = '{$row['ca_id']}' ";
        $row1 = sql_fetch($sql1);

        // 스킨 Path
        if(!$row['ca_skin_dir'])
            $g5_shop_skin_path = G5_SHOP_SKIN_PATH;
        else {
            if(preg_match('#^theme/(.+)$#', $row['ca_skin_dir'], $match))
                $g5_shop_skin_path = G5_THEME_PATH.'/'.G5_SKIN_DIR.'/shop/'.$match[1];
            else
                $g5_shop_skin_path  = G5_PATH.'/'.G5_SKIN_DIR.'/shop/'.$row['ca_skin_dir'];
        }

        if(!$row['ca_mobile_skin_dir'])
            $g5_mshop_skin_path = G5_MSHOP_SKIN_PATH;
        else {
            if(preg_match('#^theme/(.+)$#', $row['ca_mobile_skin_dir'], $match))
                $g5_mshop_skin_path = G5_THEME_MOBILE_PATH.'/'.G5_SKIN_DIR.'/shop/'.$match[1];
            else
                $g5_mshop_skin_path = G5_MOBILE_PATH.'/'.G5_SKIN_DIR.'/shop/'.$row['ca_mobile_skin_dir'];
        }

        $bg = 'bg'.($i%2);
    ?>
    <tr class="<?php echo $bg; ?>">
        <td class="td_code">
            <input type="hidden" name="ca_id[<?php echo $i; ?>]" value="<?php echo $row['ca_id']; ?>">
			<input type="hidden" name="ca_img_width[<?php echo $i; ?>]" value="<?php echo get_text($row['ca_img_width']); ?>" id="ca_out_width<?php echo $i; ?>" required class="required frm_input" size="3" >
			<input type="hidden" name="ca_img_height[<?php echo $i; ?>]" value="<?php echo $row['ca_img_height']; ?>" id="ca_img_height<?php echo $i; ?>" required class="required frm_input" size="3" >
			<input type="hidden" name="ca_list_mod[<?php echo $i; ?>]" size="3" value="<?php echo $row['ca_list_mod']; ?>" id="ca_lineimg_num<?php echo $i; ?>" required class="required frm_input">
			<input type="hidden" name="ca_mobile_list_mod[<?php echo $i; ?>]" size="3" value="<?php echo $row['ca_mobile_list_mod']; ?>" id="ca_mobileimg_num<?php echo $i; ?>" required class="required frm_input">
			<input type="hidden" name="ca_skin_dir[<?php echo $i; ?>]" value="<?php echo $row['ca_skin_dir']; ?>">
			<input type="hidden" name="ca_skin[<?php echo $i; ?>]" value="<?php echo $row['ca_skin']; ?>">
			<input type="hidden" name="ca_mobile_skin_dir[<?php echo $i; ?>]" value="<?php echo $row['ca_mobile_skin_dir']; ?>">
			<input type="hidden" name="ca_mobile_skin[<?php echo $i; ?>]" value="<?php echo $row['ca_mobile_skin']; ?>">
			<input type="hidden" name="ca_mb_id[<?php echo $i; ?>]" value="<?php echo $row['ca_mb_id']; ?>">
			<input type="hidden" name="ca_list_row[<?php echo $i; ?>]" value='<?php echo $row['ca_list_row']; ?>' id="ca_imgline_num<?php echo $i; ?>" required class="required frm_input" size="3">
			<input type="hidden" name="ca_mobile_list_row[<?php echo $i; ?>]" value='<?php echo $row['ca_mobile_list_row']; ?>' id="ca_mobileimg_row<?php echo $i; ?>" required class="required frm_input" size="3">
			<input type="hidden" name="ca_use[<?php echo $i; ?>]" value="1" id="ca_use<?php echo $i; ?>">
            <?php echo $row['ca_id']; ?>
        </td>
        <td headers="sct_cate" class="sct_name sct_name<?php echo $level; ?>"><?php echo $s_level; ?> <input type="text" name="ca_name[<?php echo $i; ?>]" value="<?php echo get_text($row['ca_name']); ?>" id="ca_name_<?php echo $i; ?>" required class="frm_input full_input required"></td>
        <td class="td_mng">
            <?php echo $s_add; ?>
            <?php echo $s_vie; ?>
            <?php echo $s_upd; ?>
            <?php echo $s_del; ?>
        </td>
    </tr>    
    <?php }
    if ($i == 0) echo "<tr><td colspan=\"5\" class=\"empty_table\">자료가 한 건도 없습니다.</td></tr>\n";
    ?>
    </tbody>
    </table>
</div>

<div class="btn_list01 btn_list">
    <input type="submit" value="일괄수정">
</div>

</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

<script>
$(function() {
    $("select.skin_dir").on("change", function() {
        var type = "";
        var dir = $(this).val();
        if(!dir)
            return false;

        var id = $(this).attr("id");
        var $sel = $(this).siblings("select");
        var sval = $sel.find("option:selected").val();

        if(id.search("mobile") > -1)
            type = "mobile";

        $sel.load(
            "./ajax.skinfile.php",
            { dir : dir, type : type, sval: sval }
        );
    });
});
</script>



<?php
include_once ('./admin.tail.php');
?>

<style type="text/css">
	.admin_contents * {font-family:'Noto Sans KR', sans-serif;box-sizing:border-box}
	.local_ov01 {border:1px solid #d9d9d9;background:#f9f9f9;padding:15px 20px;margin-bottom:15px;line-height:40px;font-size:15px;color:#333}
	.local_ov01 .ov_listall{height:40px;line-height:40px;padding: 0 30px ;background:#0062be;width:auto;border-radius:0px;font-size:16px;color:#ff;border-color:#0062be}
	.local_ov01 .ov_listall:hover{background:#0062be}
	.local_sch01{padding:0 0 15px 0}
	.local_sch01 input{border:1px solid #d9d9d9;padding-left:20px;height:40px;font-size:16px}
	.local_sch01 select{ border-radius:0; /* 아이폰 사파리 보더 없애기 */ -webkit-appearance:none; /* 화살표 없애기 for chrome*/ -moz-appearance:none; /* 화살표 없애기 for firefox*/ appearance:none /* 화살표 없애기 공통*/ }
	.local_sch01 select::-ms-expand{display:none}
	.local_sch01 select{background:#fff url('/images/mt_select3.png')no-repeat 90% center;width:180px;height:40px;padding-left:20px;font-size:16px}
	.local_sch .btn_submit{width:40px;height:40px;border:0;background:url("/images/borad_search.png")no-repeat center;text-indent:-9999px}

	#sct table{border-top:2px solid #000;border-collapse: collapse;}
	#sct table tr > *{height:60px;border-bottom:1px solid #d9d9d9;background:#fff}
	#sct table th{background:#f9f9f9;border-left:0;font-size:15px;color:#000;font-weight:500;}
	#sct table td{font-size:14px}
	#sct table td input{width:100%;padding-left:10px}
	#sct table tr > *:first-child{border-left:0}
	#sct table tr > td:last-child{border-right:0;text-align:left}
	#sct table tr > *:first-child{width:8%}
	#sct table tr > *:nth-child(2){width:67%;padding:7px 10px}
	#sct table tr > *:last-child{width:15%}
	
	
	#sct table tr .sct_name1{padding-left:40px}
	.btn_list01 input,.btn_add01 a{height:40px;line-height:38px;border:1px solid #d9d9d9;border-radius:0px;color:#777;background:#f9f9f9;padding: 0 30px;font-size:16px}
	#sct .name_lbl{background:none;border-left:2px solid #d9d9d9;border-bottom:2px solid #d9d9d9;left:-25px;top:8px}
	.btn_add{margin:20px 0 10px}
	.td_mng a.btn, .td_mng a{background:#f9f9f9;border-radius:26px;padding: 0 10px;border:1px solid #d9d9d9;font-size:13px;line-height:24px;text-align:center;color:#555}
	.pg_wrap a ,.pg_current{height:40px;width:40px;line-height:38px;border-radius:50%!important;margin: 0 3px;color:#777;font-size:16px}
	.pg_current{color:#fff;background:#0062be;border-color:#0062be}
	

</style>