<?php
	include_once('./_common.php');
	$g5['title'] = '재정보고 관리';
	$admin_cate_gubun = "basic";
	include_once ('./admin.head.php');

	if($w=="d"){
		sql_query("delete from financialReporting where idx = '$idx'");
		alert("삭제되었습니다.",$PHP_SELF."?type=$type&gopage=$gopage&sfl=$sfl&stx=".urlencode($stx));
	}elseif($w=="ld"){
		for($i=0;$i<count($idx);$i++){
			sql_query("delete from financialReporting where idx = '$idx[$i]'");
		}
		alert("삭제되었습니다.",$PHP_SELF."?type=$type&gopage=$gopage&sfl=$sfl&stx=".urlencode($stx));
	}
	
	$ser_sql1 = "";
	if($f_year){
		$ser_sql1 .= "and f_year = '$f_year'";
	}

	if($gubun){
		$ser_sql1 .= "and gubun = '$gubun'";
	}

	if($stx){
		$ser_sql1 .= "and title like '%$stx%'";
	}

	//게시판 목록보기에 필요한 각종 변수 초기값을 설정합니다.
	$tablename="financialReporting"; //테이블 이름
	if($gopage == '') $gopage = 1; //페이지 번호가 없으면 1
	$list_num = 10; //한 페이지에 보여줄 목록 갯수
	$page_num = 10; //한 화면에 보여줄 페이지 링크(묶음) 갯수
	$offset = $list_num*($gopage-1); //한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)

	//전체 글 수를 구합니다. (쿼리문을 사용하여 결과를 배열로 저장하는 일반적 인 방법)
	$query="select count(*) as cnt from $tablename where 1 $ser_sql1 $ser_sql2 $ser_sql3 $ser_sql4 $ser_sql5"; // SQL 쿼리문을 문자열 변수	에 일단 저장하고
	$row = sql_fetch($query);
	$total_no = $row[cnt];

	//전체 페이지 수와 현재 글 번호를 구합니다.
	$total_page=ceil($total_no/$list_num); // 전체글수를 페이지당글수로 나눈 값의 올림 값을 구합니다.
	$cur_num=$total_no - $list_num*($gopage-1); //현재 글번호

	$gopagesize=10;

	$p_start=(ceil($gopage/$gopagesize)-1)*$gopagesize+1; //시작페이지수
	$p_last=ceil($gopage/$gopagesize)*$gopagesize; //마지막페이지

	if($p_last>$total_page)$p_last=$total_page; //마지막페이지가 전체보다크면 마지막페이지를 전체페이지수로
	$p_next=$p_start+$gopagesize; //다음페이지의 페이지번호
	$p_prev=$p_start-$gopagesize; //이전페이지의 페이지번호
	if($p_next>=$total_page)$p_next=$total_page; //다음페이지번호가 전체보다 크면 전체페이지수로
	if($p_prev<=0)$p_prev=1; //이전페이지번호가 0보다 작으면 1로셋팅

	//bbs테이블에서 목록을 가져옵니다. (위의 쿼리문 사용예와 비슷합니다 .)
	$query2="select * from $tablename where 1 $ser_sql1 $ser_sql2 $ser_sql3 $ser_sql4 $ser_sql5 order by reg_date desc limit $offset, $list_num"; // SQL 쿼리문
	$result2 = sql_query($query2);

	$qtr = "&sfl=$sfl&stx=".urlencode($stx)."&f_year=".$f_year."&gubun=".urlencode($gubun);
?>
<script type="text/javascript">
<!--
	function del_data(url){
		if (confirm("삭제한 데이타는 복구가 불가능합니다. 삭제 하시겠습니까?"))
		{
			location.href = url;
		}
	}

	$(function(){
		$("#all_chk").click(function(){
			var all_chk = $(this).prop("checked");

			if (all_chk){
				$("input:checkbox[name='idx[]']").each(function() {
					this.checked = true;
				});
			}else{
				$("input:checkbox[name='idx[]']").each(function() {
					this.checked = false;
				});
			}
		});
	});

	function sel_del(){
		var c_cnt = $("input:checkbox[name='idx[]']:checked").length;
		if (!c_cnt){
			alert("삭제할 내용을 하나이상 선택하세요.");
			return;
		}

		if (confirm("삭제하시면 복구가 불가능합니다. 그래도 삭제하시겠습니까?"))
		{
			document.fboardlist.submit();
		}
	}
//-->
</script>



	<ul class="anchor">
	<li><a href="<?=$PHP_SELF?>">전체</a></li>
	<? for($i=2012;$i<=date(Y);$i++){?>
	<li><a href="<?=$PHP_SELF?>?f_year=<?=$i?>&gubun=<?=urlencode($gubun)?>"><?=$i?>년</a></li>
	<? } ?>
	</ul>

	<ul class="anchor">
	<li><a href="<?=$PHP_SELF?>">전체</a></li>
	<li><a href="<?=$PHP_SELF?>?gubun=<?=urlencode("수입")?>&f_year=<?=$f_year?>">수입</a></li>
	<li><a href="<?=$PHP_SELF?>?gubun=<?=urlencode("지출")?>&f_year=<?=$f_year?>">지출</a></li>
	</ul>

<form id="fsearch" name="fsearch" class="local_sch01 local_sch" method="get">
<input type="hidden" name="f_year" value="<?=$f_year?>">
<input type="hidden" name="gubun" value="<?=$gubun?>">

<label for="sfl" class="sound_only">검색대상</label>
<select name="sfl" id="sfl">
    <option value="title"<?php echo get_selected($_GET['sfl'], "title"); ?>>내용</option>
</select>
<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
<input type="text" name="stx" value="<?php echo $stx ?>" id="stx" required class="required frm_input">
<input type="submit" class="btn_submit" value="검색">

</form>

<form name="fboardlist" method="post" action="<?=$PHP_SELF?>">
<input type="hidden" name="w" value="ld" />
<div class="tbl_head01 tbl_wrap">
<table>
    <colgroup>
		<col class="grid_1">
        <col class="grid_2">
        <col class="grid_2">
        <col>
        <col class="grid_3">
		<col class="grid_3">
        <col class="grid_3">        
    </colgroup>
<thead>
<tr>
	<th><input type="checkbox" name="all_chk" id="all_chk" /></th>
	<th>년도</th>
	<th>구분</th>
	<th>내용</th>
	<th>금액</th>
	<th>등록일</th>
	<th>구분</th>
</tr>
</thead>
<tbody>
	<?
		for ($i=0; $rs=sql_fetch_array($result2); $i++){
	?>
	<tr>
		<td class="center"><input type='checkbox' name='idx[]' value="<?=$rs[idx]?>" /></td>
		<td class="center"><?=$rs[f_year]?></td>
		<td class="center"><?=$rs[gubun]?></td>
		<td class=""><?=$rs[title]?></td>
		<td class="right"><?=number_format($rs[price])?>원</td>
		<td class="center"><?=$rs[reg_date]?></td>
		<td class="center">
			<a href="./financialReporting_form.php?w=u&idx=<?=$rs[idx]?><?=$qtr?>&gopage=<?=$gopage?>">[수정]</a>
			<a href="javascript:del_data('<?=$PHP_SELF?>?w=d&idx=<?=$rs[idx]?><?=$qtr?>&gopage=<?=$gopage?>');">[삭제]</a>
		</td>
	</tr>
	<?
		$cur_num--;
		}

		if($total_no==0){
			echo "<tr><td colspan='8' class='center' height='100'>등록된 내용이 없습니다.</td></tr></table>";
		}
	?>
</tbody>
</table>
</div>
</form>

<?if($p_last>1){?>
<nav class="pg_wrap">
<span class="pg">
<a href="<?=$PHP_SELF?>?gopage=1<?=$qtr?>" class="pg_page">&lt;&lt;</a>
<?if($p_start>1){?>
<a href="<?=$PHP_SELF?>?gopage=<?=$p_prev?><?=$qtr?>" class="pg_page">&lt;</a>
<?}?>
<?for($i=$p_start;$i<=$p_last;$i++){?>
	<?if($gopage!=$i){?>
		<a href="<?=$PHP_SELF?>?gopage=<?=$i?><?=$qtr?>" class="pg_page"><?=$i?></a>
	<?}else{?>
		<strong class="pg_current"><?=$i?></strong>
	<? } ?>
<?}?>
<?if($p_last<$total_page){?>
<a href="<?=$PHP_SELF?>?gopage=<?=$p_next?><?=$qtr?>" class="pg_page">&gt;</a>
<?}?>
<a href="<?=$PHP_SELF?>?gopage=<?=$total_page?><?=$qtr?>" class="pg_page">&gt;&gt;</a>
</span>
</nav>
<? } ?>
<br />
<div>
<input type="button" value="선택삭제" class="btn" onclick="sel_del();" />
<input type="button" value="작성하기" class="btn btn_02" onclick="location.href='./financialReporting_form.php'" />
</div>
<?php
include_once ('./admin.tail.php');
?>