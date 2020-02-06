<?php
include_once('./_common.php');
$g5['title'] = '재정보고 관리';
$admin_cate_gubun = "basic";
include_once ('./admin.head.php');
?>
<?
//==============================================================================
$qtr = "&sfl=$sfl&stx=".urlencode($stx)."&f_year=".$f_year."&gubun=".urlencode($gubun);
$info = sql_fetch("select * from financialReporting where idx = '$idx'");
?>
<form name="s_form" method="post" action="financialReporting_exe.php">
<input type="hidden" name="idx" value="<?=$idx?>">
<input type="hidden" name="w" value="<?=$w?>">
<input type="hidden" name="gopage" value="<?=$gopage?>">
<input type="hidden" name="qtr" value="<?=$qtr?>">
<div class="tbl_frm01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?></caption>
    <colgroup>
        <col class="grid_4">
        <col>
    </colgroup>
    <tbody>
	<tr>
		<th scope="row">년도</th>
		<td>
			<select name="f_year" required class="required">
				<option value="">선택하세요</option>
				<? for($i=2012;$i<=date(Y);$i++){?>
				<option value="<?=$i?>" <?if($info[f_year] == $i){ echo "selected"; }?>><?=$i?>년</option>
				<? } ?>
			</select>
		</td>
	</tr>
	<tr>
		<th scope="row">구분</th>
		<td>
			<select name="gubun" required class="required">
				<option value="">선택하세요</option>
				<option value="수입" <?if($info[gubun] == "수입"){ echo "selected"; }?>>수입</option>
				<option value="지출" <?if($info[gubun] == "지출"){ echo "selected"; }?>>지출</option>
			</select>
		</td>
	</tr>
	<tr>
		<th scope="row">내용</th>
		<td><input type="text" name="title" value="<?=$info[title]?>" id="title" required class="required frm_input" size="60"></td>
	</tr>
	<tr>
		<th scope="row">금액</th>
		<td><input type="text" name="price" value="<?=$info[price]?>" id="price" required class="required frm_input" size="60"> ※ 숫자만 입력해주세요.</td>
	</tr>
</table>
</div>

<div class="">
    <a href="./financialReporting.php?gopage=<?=$gopage?><?=$qtr?>" class="btn btn_02">목록</a>
    <input type="submit" value="저장하기" class="btn_submit btn" accesskey='s'>
</div>

</form>
<?php
include_once ('./admin.tail.php');
?>