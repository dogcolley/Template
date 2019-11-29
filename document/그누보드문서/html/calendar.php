<?php
	include_once("./_common.php");

	include(G5_PATH."/html/moonday.php");

	if (!function_exists("get_first_day")) {
		// mktime() 함수는 1970 ~ 2038년까지만 계산되므로 사용하지 않음
		// 참고 : http://phpschool.com/bbs2/inc_view.html?id=3924&code=tnt2&start=0&mode=search&s_que=mktime&field=title&operator=and&period=all
		function get_first_day($year, $month)
		{
			$day = 1;
			$spacer = array(0, 3, 2, 5, 0, 3, 5, 1, 4, 6, 2, 4);
			$year = $year - ($month < 3);
			$result = ($year + (int) ($year/4) - (int) ($year/100) + (int) ($year/400) + $spacer[$month-1] + $day) % 7;
			return $result;
		}
	}

	// 오늘
	$today = getdate(G5_SERVER_TIME);
	$year  = (int)substr($schedule_ym, 0, 4);
	$month = (int)substr($schedule_ym, 4, 2);
	if ($year  < 1)                $year  = $today[year];
	if ($month < 1 || $month > 12) $month = $today[mon];
	$current_ym = sprintf("%04d%02d", $year, $month);

	$end_day = array(1=>31, 28, 31, 30 , 31, 30, 31, 31, 30 ,31 ,30, 31);
	// 윤년 계산 부분이다. 4년에 한번꼴로 2월이 28일이 아닌 29일이 있다.
	if( $year%4 == 0 && $year%100 != 0 || $year%400 == 0 )
		$end_day[2] = 29; // 조건에 적합할 경우 28을 29로 변경

	// 해당월의 1일을 mktime으로 변경
	$mktime = mktime(0,0,0,$month,1,$year);
	$mkdate = getdate(strtotime(date("Y-m-1", $mktime)));

	// 1일의 첫번째 요일 (0:일, 1:월 ... 6:토)
	$first_day = get_first_day($year, $month);
	// 해당월의 마지막 날짜,
	$last_day  = $end_day[$month];

	if ($month - 1 < 1) {
		$before_ym = sprintf("%04d%02d", ($year-1), 12);
	} else {
		$before_ym = sprintf("%04d%02d", $year, ($month-1));
	}

	if ($month + 1 > 12) {
		$after_ym  = sprintf("%04d%02d", ($year+1), 1);
	} else {
		$after_ym  = sprintf("%04d%02d", $year, ($month+1));
	}

	$file_index = G5_PATH."/html"; ### 기념일 폴더 위치 지정

	### 양력 기념일 파일 지정 : 해당년도 파일이 없으면 기본파일(solar.txt)을 불러온다
	if(file_exists($file_index."/".$year.".txt")) {
		$dayfile = file($file_index."/".$year.".txt");
	} else { 
		$dayfile = file($file_index."/solar.txt");
	}


?>
<div id="calendar-wrap" class=" clear">
		<header class="clear">
			<a class="calendar_prve img_box"  id='cal_prev' href="<? echo G5_URL."/html/calendar.php?schedule_ym=$before_ym&pageName=$pageName&admin_cate_gubun=$admin_cate_gubun"; ?>">	<img src="<?=G5_IMG_URL?>/m/Sub_3-1_Calendar_arrow1.png" alt="이전달" /></a>
			<h3 style="display: inline-block">
				<?=$year?>년 <?=$month?>월
				<button type="button" class="J_tg_btn02"> <img src="<?=G5_IMG_URL?>/m/Sub_3-1_Calendar_arrow3.png" alt="년월 변경" /></button>
			</h3>
			<div class="J_tg_con02">
				<div class="clear">
					<label for="year" class="sound_only">년 선택 이동셀렉</label>
					<select name="year" id="year">
						<? for($i=2010;$i<=date(Y);$i++){?>
						<option value="<?=$i?>" <?if($i==$year){ echo "selected"; }?>><?=$i?>년</option>
						<? } ?>
					</select>
					<label for="month" class="sound_only">월 선택 이동셀렉</label>
					<select name="month" id="month">
						<? for($i=1;$i<=12;$i++){?>
						<option value="<?=sprintf("%02d",$i)?>" <?if(sprintf("%02d",$i)==$month){ echo "selected"; }?>><?=$i?>월</option>
						<? } ?>
					</select>
				</div>
			</div>
			<a class="calendar_next img_box" id='cal_next' href="<?php echo G5_URL."/html/calendar.php?schedule_ym=$after_ym&pageName=$pageName&admin_cate_gubun=$admin_cate_gubun"; ?>" ><img src="<?=G5_IMG_URL?>/m/Sub_3-1_Calendar_arrow2.png" alt="다음달" /></a>
			<? if($admin_cate_gubun == "basic"){ ?>
			<? }else{ ?>
			<ul class="calendar_info PT_ps_ab  M_fl_Clt T_ft_sz12"  aria-hidden="true">	
				<li class="PT_mg_btm5 T_mg_rt10 type1"><span class="T_mg_rt10"></span>예약 가능</li>
				<li class="PT_mg_btm5 T_mg_rt10 type2"><span class="T_mg_rt10"></span>승인 대기</li>
				<li class="PT_mg_btm5 T_mg_rt10 type3"><span class="T_mg_rt10"></span>예약 완료</li>
			</ul>
			<? } ?>
		</header>

		<div id="calendar">
			<?php
			// 요일
			$yoil = array ("일", "월", "화", "수", "목", "금", "토");
			echo '<strong class="sound_only">요일</strong>';
			echo "<ul class=\"weekdays\">";
			for ($i=0; $i<7; $i++) {
				$width = '13%';
				$class = array();
				$class[] = "sc_tit";		
				if ($i == 0)
					$class[] = "sc_sun";
				else if ($i == 6) {
					$class[] = "sc_sat";
					$width = '12%';
				}
				$class_list = implode(" ", $class);
				echo "<li>$yoil[$i]</li>";
			}
			echo "</ul>";

			$next_day = 1;

			$perv_day_ym = date("Ym", mktime(0, 0, 0, $month-1, 1, $year));
			$next_day_ym = date("Ym", mktime(0, 0, 0, $month+1, 1, $year));

			$perv_day = date("t", mktime(0, 0, 0, $month-1, 1, $year));
			$perv_day1 = $first_day;

			$cnt = $day = 0;
			for ($i=0; $i<6; $i++) {
				echo "<ul class='days'>";
				for ($k=0; $k<7; $k++) {
					$cnt++;
					echo "<li class='day'>";
					if ($cnt > $first_day) {
						$day++;
						if ($day <= $last_day) {

							$class = array();

							// 오늘이라면
							if ($today[year] == $year && $today[mon] == $month && $today[mday] == $day) {
								$class[] = "sc_today";
							}

							$current_ymd = $current_ym . sprintf("%02d", $day);

							$class[] = $current_ymd;

							if ($k == 0)
								$class[] = "sun_day";
							else if ($k == 6)
								$class[] = "satur_day";            

							// 기념일 파일 내용 비교위한 변수 선언, 월과 일을 두자리 포맷으로 고정
							$memday = $current_ymd;
							$daycolor = '#000';
							// 기념일(양력) 표시
							for($t=0 ; $t < sizeof($dayfile) ; $t++) {  // 파일 첫 행부터 끝행까지 루프
								$arrDay = explode("|", $dayfile[$t]);
								if($memday == $year.$arrDay[0]) {
									$daycont = $arrDay[1];
									$daycontcolor = $arrDay[2];
									if(substr($arrDay[2],0,3)=="red") $daycolor = "#e50000"; // 공휴일은 날짜를 빨간색으로 표시
								}
							}

							// 석봉운님의 음력날짜 변수선언
							$myarray = soltolun(substr($current_ymd,0,4),substr($current_ymd,4,2),substr($current_ymd,6,2));
							
							include($file_index."/lunar.txt"); ### 음력 기념일 파일 지정

							$hol_chk = sql_fetch("select * from reservation_hol where h_date = '".$current_ymd."'");

							$class[] = "date";

							$class_list = implode(" ", $class);
							//echo "<div class='$class_list'><a href='".G5_URL."/html/sub4_reservation.php'>";
							echo "<div class='$class_list' style='color:".$daycolor."'>";				
							echo $day;							
							echo "<span class='sound_only'>일</span>";
							echo "<span class='sound_only'>'".$yoil[$k]."요일'</span>";
							echo "</div>";

							if($admin_cate_gubun == "basic"){

								$hol_checked = "";
								if($hol_chk[idx]){
									$hol_checked = "checked";
								}
								echo "<div>";
								echo "<input type='checkbox' name='hol[]' value='".$current_ymd."' $hol_checked class='hol_checkbox'>";
								echo "<input type='text' name='h_content[".$current_ymd."]' value='".$hol_chk[h_content]."'>";
								echo "</div>";

							}else{

								if($k==0 || $k==6){
									echo '<div class="event"><div class="event-time event-time4">예약불가</div></div>';
								}elseif($hol_chk[idx]){
									echo '<div class="event"><div class="event-time event-time4">'.$hol_chk[h_content].'</div></div>';
								}elseif($daycont){
									echo '<div class="event"><div class="event-time event-time4 sun_day">'.$daycont.'</div></div>';
								}else{
	?>
									<div class="event">
										<?php
											echo est_box($current_ymd, "1회차(10:00~10:50)");
										?>
									</div>
									<div class="event">									
										<?php
											echo est_box($current_ymd, "2회차(11:00~11:50)");
										?>
									</div>
									<div class="event">
										<?php
											echo est_box($current_ymd, "3회차(14:30~15:30)");
										?>
									</div>
	<?
								}
							}

						} 

					}
					echo "</li>";
				}
				echo "</ul>\n";
				if ($day >= $last_day)
					break;
			}

			?>
	</div>
</div>

<?php 
	$move_url = G5_URL."/html/calendar.php?pageName=$pageName&admin_cate_gubun=$admin_cate_gubun&schedule_ym="; 
?>


<script >
	//$(document).on("click","#cal_prev",function(e){
	$("#cal_prev").click(function(e){
		e.preventDefault();
		var load_html = $(this).attr("href");
		//$("#reserCal").html("");
		$("#calendar-wrap").load(load_html);
	});

//	$(document).on("click","#cal_next",function(e){
	$("#cal_next").click(function(e){
		e.preventDefault();
		var load_html = $(this).attr("href");
		//$("#reserCal").html("");
		$("#calendar-wrap").load(load_html);
	});	
	$(document).on("change","#year, #month",function(e){
		var schedule_ym = $("#year").val() + $("#month").val();
		var load_html = "<?=$move_url?>"+schedule_ym;
		//$("#reserCal").html("");
		$("#calendar-wrap").load(load_html);
	});
</script>