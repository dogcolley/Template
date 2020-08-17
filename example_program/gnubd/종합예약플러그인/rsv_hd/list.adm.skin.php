<?
// 여기에 임시 그해 임시 공휴일 추가 소스 추가

if(!$list_href) $list_href= G5_BBS_URL.'/board.php?bo_table='.$bo_table;
if($action == 'add_rv' && $member['mb_level'] >7){
	

	//if(	$board['bo_2'] == $year ) alert('이미 추가하셨습니다');
	//설정된 휴일 load
	$lunar_arr = [
		['0101','설날'],
		['0102','설날'],
		['0408','석가탄신일'],
		['0814','추석'],
		['0815','추석'],
		['0816','추석']
	];
	$sola_arr = [
		['0101','신정'],
		['0301','3.1절'],
		['0606','현충일'],
		['0815','광복절'],
		['1003','개천절'],
		['1009','한글날'],	
		['1225','크리스마스']	
	];

	$total_arr = [];



	//음력을 양력으로 반환하는 식
	function sunlunar_data() { 
	return 
	"1212122322121-1212121221220-1121121222120-2112132122122-2112112121220-2121211212120-2212321121212-2122121121210-2122121212120-1232122121212-1212121221220-1121123221222-1121121212220-1212112121220-2121231212121-2221211212120-1221212121210-2123221212121-2121212212120-1211212232212-1211212122210-2121121212220-1212132112212-2212112112210-2212211212120-1221412121212-1212122121210-2112212122120-1231212122212-1211212122210-2121123122122-2121121122120-2212112112120-2212231212112-2122121212120-1212122121210-2132122122121-2112121222120-1211212322122-1211211221220-2121121121220-2122132112122-1221212121120-2121221212110-2122321221212-1121212212210-2112121221220-1231211221222-1211211212220-1221123121221-2221121121210-2221212112120-1221241212112-1212212212120-1121212212210-2114121212221-2112112122210-2211211412212-2211211212120-2212121121210-2212214112121-2122122121120-1212122122120-1121412122122-1121121222120-2112112122120-2231211212122-2121211212120-2212121321212-2122121121210-2122121212120-1212142121212-1211221221220-1121121221220-2114112121222-1212112121220-2121211232122-1221211212120-1221212121210-2121223212121-2121212212120-1211212212210-2121321212221-2121121212220-1212112112210-2223211211221-2212211212120-1221212321212-1212122121210-2112212122120-1211232122212-1211212122210-2121121122210-2212312112212-2212112112120-2212121232112-2122121212110-2212122121210-2112124122121-2112121221220-1211211221220-2121321122122-2121121121220-2122112112322-1221212112120-1221221212110-2122123221212-1121212212210-2112121221220-1211231212222-1211211212220-1221121121220-1223212112121-2221212112120-1221221232112-1212212122120-1121212212210-2112132212221-2112112122210-2211211212210-2221321121212-2212121121210-2212212112120-1232212122112-1212122122120-1121212322122-1121121222120-2112112122120-2211231212122-2121211212120-2122121121210-2124212112121-2122121212120-1212121223212-1211212221220-1121121221220-2112132121222-1212112121220-2121211212120-2122321121212-1221212121210-2121221212120-1232121221212-1211212212210-2121123212221-2121121212220-1212112112220-1221231211221-2212211211220-1212212121210-2123212212121-2112122122120-1211212322212-1211212122210-2121121122120-2212114112122-2212112112120-2212121211210-2212232121211-2122122121210-2112122122120-1231212122212-1211211221220-2121121321222-2121121121220-2122112112120-2122141211212-1221221212110-2121221221210-2114121221221"; 
	} 

	//음->양 변환
	function LunarToSola($yyyymmdd){ 
		$getYEAR = substr($yyyymmdd,0,4); 
		$getMONTH = substr($yyyymmdd,4,2); 
		$getDAY = substr($yyyymmdd,6,2); 

		$arrayDATASTR = sunlunar_data(); 
		$arrayDATA = explode("-",$arrayDATASTR); 

		$arrayLDAYSTR="31-0-31-30-31-30-31-31-30-31-30-31"; 
		$arrayLDAY = explode("-",$arrayLDAYSTR); 

		$arrayYUKSTR="갑-을-병-정-무-기-경-신-임-계"; 
		$arrayYUK = explode("-",$arrayYUKSTR); 

		$arrayGAPSTR="자-축-인-묘-진-사-오-미-신-유-술-해"; 
		$arrayGAP = explode("-",$arrayGAPSTR); 

		$arrayDDISTR="쥐-소-호랑이-토끼-용-뱀-말-양-원숭이-닭-개-돼지"; 
		$arrayDDI = explode("-",$arrayDDISTR); 

		$arrayWEEKSTR="일-월-화-수-목-금-토";
		$arrayWEEK = explode("-",$arrayWEEKSTR); 

		if ($getYEAR <= 1881 || $getYEAR >= 2050) { //년수가 해당일자를 넘는 경우 
			$YunMonthFlag = 0; 
			return false; //년도 범위가 벗어남.. 
		} 
		if ($getMONTH > 12) { // 달수가 13이 넘는 경우 
			$YunMonthFlag = 0; 
			return false; //달수 범위가 벗어남.. 
		} 

		$m1 = $getYEAR - 1881; 

		if (substr($arrayDATA[$m1],12,1) == 0) { // 윤달이 없는 해임 
		$YunMonthFlag = 0; 
		} else { 
			if (substr($arrayDATA[$m1],$getMONTH, 1) > 2) { 
				$YunMonthFlag = 1; 
			} else { 
				$YunMonthFlag = 0; 
			} 
		} 
		
		$m1 = -1; 
		$td = 0; 

		if ($getYEAR > 1881 && $getYEAR < 2050) { 
			$m1 = $getYEAR - 1882; 
			for ($i=0;$i<=$m1;$i++) { 
				for ($j=0;$j<=12;$j++) { 
					$td = $td + (substr($arrayDATA[$i],$j,1)); 
				} 

				if (substr($arrayDATA[$i],12,1) == 0) { 
					$td = $td + 336; 
				} else { 
					$td = $td + 362; 
				} 
			} 
		} else { 
			$gf_lun2sol = 0; 
		} 

		$m1++; 
		$n2 = $getMONTH - 1; 
		$m2 = -1; 

		while(1) { 
			$m2++; 
			if (substr($arrayDATA[$m1], $m2, 1) > 2) { 
				$td = $td + 26 + (substr($arrayDATA[$m1], $m2, 1)); 
				$n2++; 
			} else { 
				if ($m2 == $n2) { 
					if ($gf_yun) { 
						$td = $td + 28 + (substr($arrayDATA[$m1], $m2, 1)); 
					}
				break; 

				} else { 
					$td = $td + 28 + (substr($arrayDATA[$m1], $m2, 1)); 
				} 
			} 
		} 

		$td = $td + $getDAY + 29; 
		$m1 = 1880; 

		while(1) { 
			$m1++; 
			if ($m1 % 400 == 0 || $m1 % 100 != 0 && $m1 % 4 == 0) { 
				$leap = 1; 
			} else { 
				$leap = 0; 
			} 

			if ($leap == 1) { 
				$m2 = 366; 
			} else { 
				$m2 = 365; 
			} 

			if ($td < $m2) break; 

			$td = $td - $m2; 
		} 

		$syear = $m1; 
		$arrayLDAY[1] = $m2 - 337; 

		$m1 = 0; 

		while(1) { 
			$m1++; 
			if ($td <= $arrayLDAY[$m1-1]) { 
				break; 
			} 
			$td = $td - $arrayLDAY[$m1-1]; 
		} 
		$smonth = $m1; 
		$sday = $td; 
		$y = $syear - 1; 
		$td = intval($y*365) + intval($y/4) - intval($y/100) + intval($y/400); 

		if ($syear % 400 == 0 || $syear % 100 != 0 && $syear % 4 == 0) { 
			$leap = 1; 
		} else { 
			$leap = 0; 
		} 

		if ($leap == 1) { 
			$arrayLDAY[1] = 29; 
		} else { 
			$arrayLDAY[1] = 28; 
		} 

		for ($i=0;$i<=$smonth-2;$i++) { 
			$td = $td + $arrayLDAY[$i]; 
		} 

		$td = $td + $sday; 
		$w = $td % 7; 

		$sweek = $arrayWEEK[$w]; 
		$gf_lun2sol = 1; 

		if($smonth<10) $smonth="0".$smonth; 
		if($sday<10) $sday="0".$sday; 

		$Ary[year]=$syear;
		$Ary[month]=$smonth;
		$Ary[day]=$sday;
		$Ary[time]=mktime(0,0,0,$Ary[month],$Ary[day],$Ary[year]);
		return $Ary;
	}

	//양->음 변환
	function SolaToLunar($yyyymmdd) {
		$getYEAR = substr($yyyymmdd,0,4); 
		$getMONTH = substr($yyyymmdd,4,2); 
		$getDAY = substr($yyyymmdd,6,2); 

		$arrayDATASTR = sunlunar_data(); 
		$arrayDATA = explode("-",$arrayDATASTR); 

		$arrayLDAYSTR="31-0-31-30-31-30-31-31-30-31-30-31"; 
		$arrayLDAY = explode("-",$arrayLDAYSTR); 

		$dt = $arrayDATA; 

		for ($i=0;$i<=168;$i++) { 
			$dt[$i] = 0; 
			for ($j=0;$j<12;$j++) { 
				switch (substr($arrayDATA[$i],$j,1)) { 
					case 1: 
					$dt[$i] += 29; 
					break; 
					case 3: 
					$dt[$i] += 29; 
					break; 
					case 2: 
					$dt[$i] += 30; 
					break; 
					case 4: 
					$dt[$i] += 30; 
					break; 
				} 
			} 

			switch (substr($arrayDATA[$i],12,1)) { 
				case 0: 
				break; 
				case 1: 
				$dt[$i] += 29; 
				break; 
				case 3: 
				$dt[$i] += 29; 
				break; 
				case 2: 
				$dt[$i] += 30; 
				break; 
				case 4: 
				$dt[$i] += 30; 
				break; 
			} 
		} 


		$td1 = 1880 * 365 + (int)(1880/4) - (int)(1880/100) + (int)(1880/400) + 30; 
		$k11 = $getYEAR - 1; 

		$td2 = $k11 * 365 + (int)($k11/4) - (int)($k11/100) + (int)($k11/400); 

		if ($getYEAR % 400 == 0 || $getYEAR % 100 != 0 && $getYEAR % 4 == 0) { 
			$arrayLDAY[1] = 29; 
		} else { 
			$arrayLDAY[1] = 28; 
		} 

		if ($getMONTH > 13) { 
			$gf_sol2lun = 0; 
		} 

		if ($getDAY > $arrayLDAY[$getMONTH-1]) { 
			$gf_sol2lun = 0; 
		} 

		for ($i=0;$i<=$getMONTH-2;$i++) { 
			$td2 += $arrayLDAY[$i]; 
		} 

		$td2 += $getDAY; 
		$td = $td2 - $td1 + 1; 
		$td0 = $dt[0]; 

		for ($i=0;$i<=168;$i++) { 
			if ($td <= $td0) { 
				break; 
			} 
			$td0 += $dt[$i+1]; 
		} 

		$ryear = $i + 1881; 
		$td0 -= $dt[$i]; 
		$td -= $td0; 

		if (substr($arrayDATA[$i], 12, 1) == 0) { 
			$jcount = 11; 
		} else { 
			$jcount = 12; 
		} 
		$m2 = 0; 

		for ($j=0;$j<=$jcount;$j++) { // 달수 check, 윤달 > 2 (by harcoon) 
			if (substr($arrayDATA[$i],$j,1) <= 2) { 
				$m2++; 
				$m1 = substr($arrayDATA[$i],$j,1) + 28; 
				$gf_yun = 0; 
			} else { 
				$m1 = substr($arrayDATA[$i],$j,1) + 26; 
				$gf_yun = 1; 
			} 
			if ($td <= $m1) { 
				break; 
			} 
			$td = $td - $m1; 
		} 

		$k1=($ryear+6) % 10; 
		$syuk = $arrayYUK[$k1]; 
		$k2=($ryear+8) % 12; 
		$sgap = $arrayGAP[$k2]; 
		$sddi = $arrayDDI[$k2]; 

		$gf_sol2lun = 1; 

		if($m2<10) $m2="0".$m2; 
		if($sday<10) $td="0".$td; 

		$Ary[year]=$ryear;
		$Ary[month]=$m2;
		$Ary[day]=$td;
		$Ary[time]=mktime(0,0,0,$Ary[month],$Ary[day],$Ary[year]);

		return $Ary;
	}
	//해당 데이터를 모두 배열로처리 
	//wirte에 업데이트 추가

	
	foreach($lunar_arr as $value){
		$cd = LunarToSola($setYear.$value[0]);
		$total_arr[] = [$cd['year'].'-'.$cd['month'].'-'.$cd['day'], $value[1]];
	}

	foreach($sola_arr as $value){
		$total_arr[] = [ $setYear.'-'.substr($value[0], 0, 2).'-'.substr($value[0], 2, 2) ,  $value[1] ];
	}

	$write_table = $g5['write_prefix'].$bo_table;
	$wr_reply = '';

	foreach($total_arr as $value){

		$sql = "select * from $write_table where 
			wr_subject = '$value[1]' AND 
			wr_1 = '$value[0]'
		";
		$row = sql_fetch($sql);
		if($row) alert('이미 추가하셨습니다');
		$wr_num = get_next_num($write_table);
		$sql = " insert into $write_table
					set wr_num = '$wr_num',
						 wr_comment = 0,
						 ca_name = '공휴일',
						 wr_subject = '$value[1]',
						 wr_content = '휴일',
						 wr_link1_hit = 0,
						 wr_link2_hit = 0,
						 wr_hit = 0,
						 wr_good = 0,
						 wr_nogood = 0,
						 mb_id = '{$member['mb_id']}',
						 wr_password = '$wr_password',
						 wr_name = '$wr_name',
						 wr_email = '$wr_email',
						 wr_homepage = '$wr_homepage',
						 wr_datetime = '".G5_TIME_YMDHIS."',
						 wr_last = '".G5_TIME_YMDHIS."',
						 wr_ip = '{$_SERVER['REMOTE_ADDR']}',
						 wr_1 = '$value[0]',
						 wr_3 = '$value[0]'
						 ";
		sql_query($sql);
		$wr_id = sql_insert_id();

		// 부모 아이디에 UPDATE
		sql_query(" update $write_table set wr_parent = '$wr_id' where wr_id = '$wr_id' ");

		// 새글 INSERT
		sql_query(" insert into {$g5['board_new_table']} ( bo_table, wr_id, wr_parent, bn_datetime, mb_id ) values ( '{$bo_table}', '{$wr_id}', '{$wr_id}', '".G5_TIME_YMDHIS."', '{$member['mb_id']}' ) ");

		// 게시글 1 증가
		sql_query("update {$g5['board_table']} set bo_count_write = bo_count_write + 1 where bo_table = '{$bo_table}'");

	}
	$set_table = $g5['board_table'];
	$sql = "update  ".$set_table." set bo_2 = '".$year."'";
	sql_query($sql);
	alert('추가완료되었습니다.',$list_href);
}

//자동카테추가
if(!$board['bo_category_list']){
$bo_category_list = '공휴일|임시휴일|기타|공지';
$sql = "update ".$g5['board_table']." set bo_category_list = '".$bo_category_list."' where bo_table = '".$board['bo_table']."'";
sql_query($sql);
}

?>


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
		<form action="<?=$url?>" id="ch_lbo" name="ch_lbo" method="post" style="display:inline-block" class="TM_ds_inbl">
			<?if($member['mb_id'] =='super' || $member['mb_id'] =='admin' ){?>
			<div class="">
				<label for="lbo_table" class="U_tit" >연동게시판</label>
				<input type="text" id="lbo_table" name="lbo_table" value="<?=$board['bo_1']?>" class="required frm_input"/>
				<input type="hidden" id="lbo" name="lbo" value="" />
				<input value="저장하기" type="submit" class="TM_ds_block U_btn01" />
			</div>
			<?}else{?>
				<input type="hidden" id="lbo_table" name="lbo_table" value="<?=$board['bo_1']?>" class="required frm_input"/>
			<?}?>	
		</form>

		<form action="<?=$url?>" method="post" style="display:inline-block" class="TM_ds_inbl" >
			<input type="hidden" name="action" value="add_rv" />
			<select name="setYear" id="setYear" class="frm_input" style="padding: 0 20px">
				<option value="<?=$year?>"><?=$year?></option>
				<option value="<?=$year+1?>"><?=$year+1?></option>
				<option value="<?=$year+2?>"><?=$year+2?></option>
			</select>
			<input type="submit" value="년도 공휴일 자동등록" class="TM_ds_block U_btn01 U_ft_ct"/>
		</form>

		<?if($board['bo_1']){?>
		<a href="<?=G5_BBS_URL?>/board.php?bo_table=<?=$board['bo_1']?>" class="link_bd TM_ds_block U_btn01 U_ft_ct">예약목록관리</a>
		<?}?>

		<script>
			$('#ch_lbo').on('submit',function(){
				$('#lbo').val('1');
			});
		</script>
	</div>
    <?}?>