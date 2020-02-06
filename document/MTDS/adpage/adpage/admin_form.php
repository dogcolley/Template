<?php
include_once('./_common.php');

if($mode){

	sql_query("update g5_config set cf_5 = '$cf_5', cf_6 = '$cf_6', cf_7 = '$cf_7', cf_8 = '$cf_8', cf_9 = '$cf_9', cf_10 = '$cf_10'");

	$sql_common = "mb_name = '$_POST[mb_name]', mb_nick = '$_POST[mb_name]', mb_email = '$_POST[mb_email]'";

    if ($mb_password)
        $sql_password = " , mb_password = '".sql_password($mb_password)."' ";
    else
        $sql_password = "";

    $sql = " update $g5[member_table] set $sql_common $sql_password where mb_id = '$mb_id' ";
    sql_query($sql);

	alert("수정되었습니다.",$PHP_SELF);

}

$g5['title'] = '관리자정보';
$admin_cate_gubun = "basic";
include_once ('./admin.head.php');
?>
<form name="admin_frm" method="post" action="<?=$PHP_SELF?>" />
<input type="hidden" name="mode" value="update" />
<div class="tbl_frm01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?></caption>
    <colgroup>
        <col class="grid_2">
        <col>
    </colgroup>
    <tbody>
    <tr>
        <th scope="row"><label for="mb_id">아이디</label></th>
        <td><input type="text" name="mb_id" value="<?php echo $member['mb_id'] ?>" id="mb_id" required class="frm_input required" /></td>
	</tr>
	<tr>
		<th scope="row"><label for="mb_password">패스워드</label></th>
        <td><input type="text" name="mb_password" value="" id="mb_password" class="frm_input" /></td>
	</tr>
	<tr>
        <th scope="row"><label for="mb_name">이름</label></th>
        <td><input type="text" name="mb_name" value="<?php echo $member['mb_name'] ?>" id="mb_name" required class="frm_input required" /></td>
	</tr>
	<tr>
        <th scope="row"><label for="mb_email">이메일</label></th>
        <td><input type="text" name="mb_email" value="<?php echo $member['mb_email'] ?>" id="mb_email" required class="frm_input required" style="width:300px;" /></td>		
	</tr>
	</table>
	<br />
	<h2>폼 메일별 수신 담당자</h2>
    <table>
    <caption><?php echo $g5['title']; ?></caption>
    <colgroup>
        <col class="grid_2">
        <col>
    </colgroup>
    <tbody>	
	<tr>
        <th scope="row"><label for="cf_8">영업문의</label></th>
        <td><textarea name="cf_8" id="cf_8" style="width:100%;"><?php echo $config['cf_8'] ?></textarea></td>		
	</tr>
	<tr>
        <th scope="row"><label for="cf_7">A/S</label></th>
        <td><textarea name="cf_7" id="cf_7" style="width:100%;"><?php echo $config['cf_7'] ?></textarea></td>		
	</tr>
	<?/*
	<tr>
        <th scope="row"><label for="cf_8">1:1 문의</label></th>
        <td><textarea name="cf_8" id="cf_8" style="width:100%;"><?php echo $config['cf_8'] ?></textarea></td>		
	</tr>
	*/?>
	<?/*
	<tr>
        <th scope="row"><label for="cf_7">사이버신고센터</label></th>
        <td><textarea name="cf_7" id="cf_7" style="width:100%;"><?php echo $config['cf_7'] ?></textarea></td>		
	</tr>
	*/?>
	<tr>
        <th scope="row"><label for="cf_6">IR 문의</label></th>
        <td><textarea name="cf_6" id="cf_6" style="width:100%;"><?php echo $config['cf_6'] ?></textarea></td>		
	</tr>
	<tr>
        <th scope="row"><label for="cf_5">채용문의</label></th>
        <td><textarea name="cf_5" id="cf_5" style="width:100%;"><?php echo $config['cf_5'] ?></textarea></td>		
	</tr>	
	</tbody>
	</table>
</div>

<div class="btn_confirm01 btn_confirm">
    <input type="submit" value="확인" class="btn_submit" accesskey="s">
</div>
</form>

<?php
include_once ('./admin.tail.php');
?>