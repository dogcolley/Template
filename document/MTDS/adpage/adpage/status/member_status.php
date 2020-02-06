<?
			$oneDay = 86400;
			$dTimeF = '00:00:00';
			$dTimeL = '23:59:59';
			// 오늘(D)
			$sql = " select count(*) as cnt from g5_member
						where mb_datetime between '".date("Y-m-d",time())." {$dTimeF}' and '".date("Y-m-d",time())." {$dTimeL}' ";
			$row = sql_fetch($sql);
			$member_cnt[0] = $row['cnt'];
			$member_href_today = "$g5[admin_path]/member_list.php?sfl=mb_datetime&stx=".date("Y-m-d",time());

			// D-1
			$sql = " select count(*) as cnt from g5_member
						where mb_datetime between '".date("Y-m-d",time()-$oneDay)." {$dTimeF}' and '".date("Y-m-d",time()-$oneDay)." {$dTimeL}' ";
			$row = sql_fetch($sql);
			$member_cnt[1] = $row['cnt'];
			$member_href_l1 = "$g5[admin_path]/member_list.php?sfl=mb_datetime&stx=".date("Y-m-d",time()-$oneDay);

			// D-2
			$sql = " select count(*) as cnt from g5_member
						where mb_datetime between '".date("Y-m-d",time()-$oneDay*2)." {$dTimeF}' and '".date("Y-m-d",time()-$oneDay*2)." {$dTimeL}' ";
			$row = sql_fetch($sql);
			$member_cnt[2] = $row['cnt'];
			$member_href_l2 = "$g5[admin_path]/member_list.php?sfl=mb_datetime&stx=".date("Y-m-d",time()-$oneDay*2);

			// D-3
			$sql = " select count(*) as cnt from g5_member
						where mb_datetime between '".date("Y-m-d",time()-$oneDay*3)." {$dTimeF}' and '".date("Y-m-d",time()-$oneDay*3)." {$dTimeL}' ";
			$row = sql_fetch($sql);
			$member_cnt[3] = $row['cnt'];
			$member_href_l3 = "$g5[admin_path]/member_list.php?sfl=mb_datetime&stx=".date("Y-m-d",time()-$oneDay*3);

			// D-4
			$sql = " select count(*) as cnt from g5_member
						where mb_datetime between '".date("Y-m-d",time()-$oneDay*4)." {$dTimeF}' and '".date("Y-m-d",time()-$oneDay*4)." {$dTimeL}' ";
			$row = sql_fetch($sql);
			$member_cnt[4] = $row['cnt'];
			$member_href_l4 = "$g5[admin_path]/member_list.php?sfl=mb_datetime&stx=".date("Y-m-d",time()-$oneDay*4);

			// D-5
			$sql = " select count(*) as cnt from g5_member
						where mb_datetime between '".date("Y-m-d",time()-$oneDay*5)." {$dTimeF}' and '".date("Y-m-d",time()-$oneDay*5)." {$dTimeL}' ";
			$row = sql_fetch($sql);
			$member_cnt[5] = $row['cnt'];
			$member_href_l5 = "$g5[admin_path]/member_list.php?sfl=mb_datetime&stx=".date("Y-m-d",time()-$oneDay*5);

			// D-6
			$sql = " select count(*) as cnt from g5_member
						where mb_datetime between '".date("Y-m-d",time()-$oneDay*6)." {$dTimeF}' and '".date("Y-m-d",time()-$oneDay*6)." {$dTimeL}' ";
			$row = sql_fetch($sql);
			$member_cnt[6] = $row['cnt'];
			$member_href_l6 = "$g5[admin_path]/member_list.php?sfl=mb_datetime&stx=".date("Y-m-d",time()-$oneDay*6);
			
			// 금월
			$sql = " select count(*) as cnt from g5_member
						where mb_datetime between '".date("Y-m-01",time())." {$dTimeF}' and '".date("Y-m-d",time())." {$dTimeL}' ";
			$row = sql_fetch($sql);
			$member_cnt[month] = $row['cnt'];
			$member_href_thismonth = "$g5[admin_path]/member_list.php?sfl=mb_datetime&stx=".date("Y-m",time());

			// 금년
			$sql = " select count(*) as cnt from g5_member
						where mb_datetime between '".date("Y-01-01",time())." {$dTimeF}' and '".date("Y-m-d",time())." {$dTimeL}' ";
			$row = sql_fetch($sql);
			$member_cnt[year] = $row['cnt'];
			$member_href_thisyear = "$g5[admin_path]/member_list.php?sfl=mb_datetime&stx=".date("Y-",time());

			// 전체
			$sql = " select count(*) as cnt from g5_member  ";
			$row = sql_fetch($sql);
			$member_cnt[total] = $row['cnt'];
			$member_href_total = "$g5[admin_path]/member_list.php";

			$member_cnt['max'] = max($member_cnt[0], $member_cnt[1], $member_cnt[2], $member_cnt[3], $member_cnt[4], $member_cnt[5], $member_cnt[6]);
			$member_cnt['sum'] = $member_cnt[0] + $member_cnt[1] + $member_cnt[2] + $member_cnt[3] + $member_cnt[4] + $member_cnt[5] + $member_cnt[5];
			for ($i=0; $i<=6; $i++) {
				$member_cnt_percent[$i] = 0;
				$member_cnt_height[$i] = 0;
				if ($member_cnt['sum']) {
					$member_cnt_percent[$i] = round(($member_cnt[$i] / $member_cnt['sum'] * 100), 1);
				}
				if ($member_cnt_percent[$i])
					$member_cnt_height[$i] = round((($member_cnt[$i] / $member_cnt['max'] * 100) * 0.85), 0);
			}
			
		?>

			<li>
				<strong>최근회원가입현황</strong>
				<table width="345" border="0" cellspacing="0" cellpadding="0" style="padding-top:11px;">
					<tr>
						<th style="vertical-align:bottom;"><?=$member_cnt[6]?></th>
						<th style="vertical-align:bottom;"><?=$member_cnt[5]?></th>
						<th style="vertical-align:bottom;"><?=$member_cnt[4]?></th>
						<th style="vertical-align:bottom;"><?=$member_cnt[3]?></th>
						<th style="vertical-align:bottom;"><?=$member_cnt[2]?></th>
						<th style="vertical-align:bottom;"><?=$member_cnt[1]?></th>
						<th style="vertical-align:bottom;"><?=$member_cnt[0]?></th>
					</tr>
					<tr class="graph_bottom">
						<td style="vertical-align:bottom;"><img height=<?=$member_cnt_height[6]?> src="images/graph.gif"></td>
						<td style="vertical-align:bottom;"><img height=<?=$member_cnt_height[5]?> src="images/graph.gif"></td>
						<td style="vertical-align:bottom;"><img height=<?=$member_cnt_height[4]?> src="images/graph.gif"></td>
						<td style="vertical-align:bottom;"><img height=<?=$member_cnt_height[3]?> src="images/graph.gif"></td>
						<td style="vertical-align:bottom;"><img height=<?=$member_cnt_height[2]?> src="images/graph.gif"></td>
						<td style="vertical-align:bottom;"><img height=<?=$member_cnt_height[1]?> src="images/graph.gif"></td>
						<td style="vertical-align:bottom;"><img height=<?=$member_cnt_height[0]?> src="images/graph.gif"></td>
					</tr>
					<tr class="graph_day">
						<td style="vertical-align:bottom;">D-6<p>(<?=get_yoil(date("Y-m-d",time()-$oneDay*6))?>)</p><p><?=$member_cnt_percent[6]?>%</p></td>
						<td style="vertical-align:bottom;">D-5<p>(<?=get_yoil(date("Y-m-d",time()-$oneDay*5))?>)</p><p><?=$member_cnt_percent[5]?>%</p></td>
						<td style="vertical-align:bottom;">D-4<p>(<?=get_yoil(date("Y-m-d",time()-$oneDay*4))?>)</p><p><?=$member_cnt_percent[4]?>%</p></td>
						<td style="vertical-align:bottom;">D-3<p>(<?=get_yoil(date("Y-m-d",time()-$oneDay*3))?>)</p><p><?=$member_cnt_percent[3]?>%</p></td>
						<td style="vertical-align:bottom;">D-2<p>(<?=get_yoil(date("Y-m-d",time()-$oneDay*2))?>)</p><p><?=$member_cnt_percent[2]?>%</p></td>
						<td style="vertical-align:bottom;">D-1<p>(<?=get_yoil(date("Y-m-d",time()-$oneDay*1))?>)</p><p><?=$member_cnt_percent[1]?>%</p></td>
						<td style="vertical-align:bottom;">오늘<p>(<?=get_yoil(date("Y-m-d",time()))?>)</p><p><?=$member_cnt_percent[0]?>%</p></td>
					</tr>
				</table>
			</li>