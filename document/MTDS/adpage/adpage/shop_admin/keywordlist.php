<?
include_once('./_common.php');

if($mode){
	$aa = implode("|",$keyword);
	sql_query("update g5_config set cf_1 = '$aa'");
	alert("저장되었습니다.",$PHP_SELF);
}
$g5['title'] = '키워드관리';
$admin_cate_gubun = "shop1";
include_once(G5_USER_ADMIN_PATH.'/admin.head.php');
$arr_keyword = explode("|",$config[cf_1]);
//｜
?>
<div class="btn_add01 btn_add">
    <a href="#n" onclick="add_tr();">추가</a>
</div>
<form name="frm" method="post" action="<?=$PHP_SELF?>" onsubmit="return chk_keyword(this);">
<input type="hidden" name="mode" value="ok" />
<div class="tbl_head02 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col">키워드</th>
		<th scope="col"></th>
	</tr>
	</thead>
	<tbody id="keyword_area">
	<? for($i=0;$i<count($arr_keyword);$i++){ ?>
	<tr id="keyword_<?=$i?>">
		<td><input type="text" name="keyword[]" value="<?=$arr_keyword[$i]?>" class="frm_input" /></td>
		<td align="center"><a href="#n" onclick="del_tr('<?=$i?>');">삭제</td>
	</tr>
	<? } ?>
	</tbody>
	</table>	
</div>
<div class="btn_confirm01 btn_confirm">
<input type="submit" value="저장하기" class="btn_submit" accesskey="s" />
</div>
</form>

<script type="text/javascript">
<!--
	var tr_cnt = $("#keyword_area").find("tr").length;

	function add_tr(){		
		var text = "";
		text += "<tr id=\"keyword_"+tr_cnt+"\">";
		text += "<td><input type=\"text\" name=\"keyword[]\" value=\"\" class=\"frm_input\" /></td>";
		text += "<td align=\"center\"><a href=\"#n\" onclick=\"del_tr('"+tr_cnt+"');\">삭제</td>";
		text += "</tr>";
		$("#keyword_area").append(text);
		tr_cnt++;
	}

	function del_tr(no){
		$("#keyword_"+no).remove();
	}

	function chk_keyword(f){
		var k_cnt = 0;
		$(".frm_input").each(function(){
			var thistype = $(this).attr("type");
			if (thistype=="text")
			{
				if($(this).val() == ""){
					k_cnt++;	
				}
			}
		});

		if (k_cnt > 0)
		{
			alert("키워드를 입력해주세요. 또는 빈 키워드 입력창을 삭제해주세요.");
			return false;
		}
	}
//-->
</script>
<?php
include_once (G5_USER_ADMIN_PATH.'/admin.tail.php');
?>