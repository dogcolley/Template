<?
$sql = " select sum(IF(mb_id<>'',1,0)) as mb_cnt, count(*) as total_cnt from $g5[login_table] where mb_id <> '$config[cf_admin]' ";
$row = sql_fetch($sql);
$g_count = $row['total_cnt']-$row['mb_cnt'];
$m_count = $row['total_cnt']-$g_count;
if ($row['total_cnt']>$config[cf_8]) {
$max=$row['total_cnt'];
mysql_query(" update g5_config set cf_8='$max' ");
}
$temp = sql_fetch("select vs_count from `g5_visit_sum` where vs_date = '$g5[time_ymd]'");
$today_visit = intval($temp[vs_count]);
$temp1 = sql_fetch("select vs_count from `g5_visit_sum` where vs_date = DATE_SUB('$g5[time_ymd]', INTERVAL 1 DAY)");
$yester_visit = intval($temp1[vs_count]);
$sql = " select max(vs_count) as cnt from $g5[visit_sum_table] ";
$row = sql_fetch($sql);
$vi_max = $row[cnt];
$sql = " select sum(vs_count) as cnt from g5_visit_sum ";
$row = sql_fetch($sql);
$visit_total = $row['cnt'];
   
        // 금월
			$sql = " select sum(vs_count) as cnt from g5_visit_sum
						where vs_date between '".date("Y-m-01",time())."' and '".date("Y-m-d",time())."' ";
			$row = sql_fetch($sql);
			$visit_cnt[month] = $row['cnt'];
			$visit_href_thismonth = "$g5[admin_path]/visit_date.php?fr_date=".date("Y-m-01",time())."&to_date=".date("Y-m-d",time());

        // 전체 게시물수
        $sql = " select sum(bo_count_write) as total from g5_board"; 
        $row = sql_fetch($sql);
        $total_write  = $row[total];

        // 전체 코멘트수
        $sql = " select sum(bo_count_comment) as total from g5_board"; 
        $row = sql_fetch($sql);
        $total_comment  = $row[total];

        // 그누보드 전체 디비용량 구하기
        $result = mysql_query("show table status from $mysql_db like 'g5%'");
        $db_size = 0;
        while($dbData=mysql_fetch_array($result)){
        $db_size += $dbData[Data_length]+$dbData[Index_length];
        }

        // 계정 용량 구하기 (기존)
        //$du = `du -csk`;
		
		// 계정 용량 구하기 (변경 후)
		$account_space = `du -sb $g5[path]`; 
		$account_space = substr($account_space,0,strlen($account_space)-3); 

?>

<ul class="statistics_box">
	<li class="statistics_tit"><img src="images/statistics_tit.gif" alt="사이트 활성도 통계" title="사이트 활성도 통계"></li>
	<li class="statistice_con">접속 (<strong style="color:#4a9ee9;">G</strong> : <?=$g_count;?>명 / <strong style="color:#4a9ee9;">M</strong> : <?=$m_count;?>명)</li>
</ul>
<div class="statistics_table">
	<table width="705" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td class="sta_top">
				총 방문객 : <strong><?=number_format($visit_total)?></strong>명   l   
				최대방문 : <strong><?=number_format($vi_max)?></strong>명   l   
				오늘방문 : <strong><?=number_format($today_visit)?></strong>명   l   
				어제방문 : <strong><?=number_format($yester_visit)?></strong>명   l   
				이달방문 : <strong><?=number_format($visit_cnt[month])?></strong>명
			</td>
		</tr>
		<tr>
			<td>
				총 게시물 : <strong><?=number_format($total_write)?></strong>개   l   
				총 코멘트 : <strong><?=number_format($total_comment)?></strong>개   l   
				DB 사용량 : <strong><? printf("%0.2f MB",$db_size / (1024*1024)); ?></strong>MB   l   
				계정사용량 : <strong><? printf("%0.2f MB",$account_space / (1024*1024)); ?></strong>MB
			</td>
		</tr>
	</table>
</div>