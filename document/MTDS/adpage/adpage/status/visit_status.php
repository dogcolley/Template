<?
			function printChar2Br($char) {
				$tSize = strlen($char);
				for ($i=0; $i<$tSize; $i++) {
					echo $char[$i] . '<br />';
				}
			}
			$oneDay = 86400;
			// 오늘(D)
			$sql = " select vs_count as cnt from g5_visit_sum
						where vs_date between '".date("Y-m-d",time())."' and '".date("Y-m-d",time())."' ";
			$row = sql_fetch($sql);
			$visit_cnt[0] = $row['cnt'];
			$visit_href_today = "$g5[admin_path]/visit_list.php?fr_date=".date("Y-m-d",time())."&to_date=".date("Y-m-d",time());

			// D-1
			$sql = " select vs_count as cnt from g5_visit_sum
						where vs_date between '".date("Y-m-d",time()-$oneDay)."' and '".date("Y-m-d",time()-$oneDay)."' ";
			$row = sql_fetch($sql);
			$visit_cnt[1] = $row['cnt'];
			$visit_href_l1 = "$g5[admin_path]/visit_list.php?fr_date=".date("Y-m-d",time()-$oneDay)."&to_date=".date("Y-m-d",time()-$oneDay);

			// D-2
			$sql = " select vs_count as cnt from g5_visit_sum
						where vs_date between '".date("Y-m-d",time()-$oneDay*2)."' and '".date("Y-m-d",time()-$oneDay*2)."' ";
			$row = sql_fetch($sql);
			$visit_cnt[2] = $row['cnt'];
			$visit_href_l2 = "$g5[admin_path]/visit_list.php?fr_date=".date("Y-m-d",time()-$oneDay*2)."&to_date=".date("Y-m-d",time()-$oneDay*2);

			// D-3
			$sql = " select vs_count as cnt from g5_visit_sum
						where vs_date between '".date("Y-m-d",time()-$oneDay*3)."' and '".date("Y-m-d",time()-$oneDay*3)."' ";
			$row = sql_fetch($sql);
			$visit_cnt[3] = $row['cnt'];
			$visit_href_l3 = "$g5[admin_path]/visit_list.php?fr_date=".date("Y-m-d",time()-$oneDay*3)."&to_date=".date("Y-m-d",time()-$oneDay*3);

			// D-4
			$sql = " select vs_count as cnt from g5_visit_sum
						where vs_date between '".date("Y-m-d",time()-$oneDay*4)."' and '".date("Y-m-d",time()-$oneDay*4)."' ";
			$row = sql_fetch($sql);
			$visit_cnt[4] = $row['cnt'];
			$visit_href_l4 = "$g5[admin_path]/visit_list.php?fr_date=".date("Y-m-d",time()-$oneDay*4)."&to_date=".date("Y-m-d",time()-$oneDay*4);

			// D-5
			$sql = " select vs_count as cnt from g5_visit_sum
						where vs_date between '".date("Y-m-d",time()-$oneDay*5)."' and '".date("Y-m-d",time()-$oneDay*5)."' ";
			$row = sql_fetch($sql);
			$visit_cnt[5] = $row['cnt'];
			$visit_href_l5 = "$g5[admin_path]/visit_list.php?fr_date=".date("Y-m-d",time()-$oneDay*5)."&to_date=".date("Y-m-d",time()-$oneDay*5);

			// D-6
			$sql = " select vs_count as cnt from g5_visit_sum
						where vs_date between '".date("Y-m-d",time()-$oneDay*6)."' and '".date("Y-m-d",time()-$oneDay*6)."' ";
			$row = sql_fetch($sql);
			$visit_cnt[6] = $row['cnt'];
			$visit_href_l6 = "$g5[admin_path]/visit_list.php?fr_date=".date("Y-m-d",time()-$oneDay*6)."&to_date=".date("Y-m-d",time()-$oneDay*6);

			// 금월
			$sql = " select sum(vs_count) as cnt from g5_visit_sum
						where vs_date between '".date("Y-m-01",time())."' and '".date("Y-m-d",time())."' ";
			$row = sql_fetch($sql);
			$visit_cnt[month] = $row['cnt'];
			$visit_href_thismonth = "$g5[admin_path]/visit_date.php?fr_date=".date("Y-m-01",time())."&to_date=".date("Y-m-d",time());

			// 금년
			$sql = " select sum(vs_count) as cnt from g5_visit_sum
						where vs_date between '".date("Y-01-01",time())."' and '".date("Y-m-d",time())."' ";
			$row = sql_fetch($sql);
			$visit_cnt[year] = $row['cnt'];
			$visit_href_thisyear = "$g5[admin_path]/visit_month.php?fr_date=".date("Y-01-01",time())."&to_date=".date("Y-m-d",time());

			// 전체
			$sql = " select sum(vs_count) as cnt from g5_visit_sum ";
			$row = sql_fetch($sql);
			$visit_cnt[total] = $row['cnt'];
			$visit_href_total = "$g5[admin_path]/visit_month.php?fr_date=".date("2000-01-01",time())."&to_date=".date("Y-m-d",time());

			$visit_cnt['max'] = max($visit_cnt[0], $visit_cnt[1], $visit_cnt[2], $visit_cnt[3], $visit_cnt[4], $visit_cnt[5], $visit_cnt[6]);
			$visit_cnt['sum'] = $visit_cnt[0] + $visit_cnt[1] + $visit_cnt[2] + $visit_cnt[3] + $visit_cnt[4] + $visit_cnt[5] + $visit_cnt[6];
			for ($i=0; $i<=6; $i++) {
				$visit_cnt_percent[$i] = round(($visit_cnt[$i] / $visit_cnt['sum'] * 100), 1);
				$visit_cnt_height[$i] = round((($visit_cnt[$i] / $visit_cnt['max'] * 100) * 0.85), 0);
			}
			$sql = " select max(vs_count) as cnt from $g5[visit_sum_table] ";
$row = sql_fetch($sql);
$vi_max = $row[cnt];
		?>

			<li style="margin-right:14px;">
				<strong>최근방문자현황</strong>
				<table width="345" border="0" cellspacing="0" cellpadding="0" style="padding-top:11px;">
					<tr>
						<th style="vertical-align:bottom;"><?=$visit_cnt[6]?></th>
						<th style="vertical-align:bottom;"><?=$visit_cnt[5]?></th>
						<th style="vertical-align:bottom;"><?=$visit_cnt[4]?></th>
						<th style="vertical-align:bottom;"><?=$visit_cnt[3]?></th>
						<th style="vertical-align:bottom;"><?=$visit_cnt[2]?></th>
						<th style="vertical-align:bottom;"><?=$visit_cnt[1]?></th>
						<th style="vertical-align:bottom;"><?=$visit_cnt[0]?></th>
					</tr>
					<tr class="graph_bottom">
						<td style="vertical-align:bottom;"><img height=<?=$visit_cnt_height[6]?> src="images/graph.gif"></td>
						<td style="vertical-align:bottom;"><img height=<?=$visit_cnt_height[5]?> src="images/graph.gif"></td>
						<td style="vertical-align:bottom;"><img height=<?=$visit_cnt_height[4]?> src="images/graph.gif"></td>
						<td style="vertical-align:bottom;"><img height=<?=$visit_cnt_height[3]?> src="images/graph.gif"></td>
						<td style="vertical-align:bottom;"><img height=<?=$visit_cnt_height[2]?> src="images/graph.gif"></td>
						<td style="vertical-align:bottom;"><img height=<?=$visit_cnt_height[1]?> src="images/graph.gif"></td>
						<td style="vertical-align:bottom;"><img height=<?=$visit_cnt_height[0]?> src="images/graph.gif"></td>
					</tr>
					<tr class="graph_day">
						<td style="vertical-align:bottom;">D-6<p>(<?=get_yoil(date("Y-m-d",time()-$oneDay*6))?>)</p><p><?=$visit_cnt_percent[6]?>%</p></td>
						<td style="vertical-align:bottom;">D-5<p>(<?=get_yoil(date("Y-m-d",time()-$oneDay*5))?>)</p><p><?=$visit_cnt_percent[5]?>%</p></td>
						<td style="vertical-align:bottom;">D-4<p>(<?=get_yoil(date("Y-m-d",time()-$oneDay*4))?>)</p><p><?=$visit_cnt_percent[4]?>%</p></td>
						<td style="vertical-align:bottom;">D-3<p>(<?=get_yoil(date("Y-m-d",time()-$oneDay*3))?>)</p><p><?=$visit_cnt_percent[3]?>%</p></td>
						<td style="vertical-align:bottom;">D-2<p>(<?=get_yoil(date("Y-m-d",time()-$oneDay*2))?>)</p><p><?=$visit_cnt_percent[2]?>%</p></td>
						<td style="vertical-align:bottom;">D-1<p>(<?=get_yoil(date("Y-m-d",time()-$oneDay*1))?>)</p><p><?=$visit_cnt_percent[1]?>%</p></td>
						<td style="vertical-align:bottom;">오늘<p>(<?=get_yoil(date("Y-m-d",time()))?>)</p><p><?=$visit_cnt_percent[0]?>%</p></td>
					</tr>
				</table>
			</li>