<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

function tcDateToTime($ymd) // 블로그 방문자숫자를 시간 문자열로 변환
{
	$tmp_ymd = explode('-', $ymd);
	$y = $tmp_ymd[0];
	$m = $tmp_ymd[1];
	$d = $tmp_ymd[2];		
		
	return ("$y-$m-$d 00:00:00");
}
		
function dateDiff($d1, $d2) // 날짜 차이를 계산
{
	return floor((strtotime($d2) - strtotime($d1))/60/60/24);
}	

function ShowDracoCounter($how_day = 30, $graph_barwidth = 5) 
{
	global $g5, $current;
	
	$pluginPATH = $g5['path'] . '/plugin/DracoCounter';	
	
	// config
	$cut_peak = 'true';				// 봇이나 사용자 과다유입으로 그래프가 지나치게 피크인 날의 높이를 잘라냅니다.
	$view_marker = 'true';			// 최대 방문자일과 최소 방문자 일을 표시합니다.
	$view_grid = 'false';			// 격자를 표시합니다. x축 간격은 1주일입니다.
	$line_thickness = '1';			// 그래프 선의 두께를 설정합니다
	$line_blank = 'false';			// 그래프 선을 점선으로 사용합니다.
	$graph_color = '#9980FF';		// 그래프의 색을 지정합니다
	$graph_backcolor = '#FFFFFF';	// 그래프의 배경색을 지정합니다
	$graph_fillcolor = '#FAFFE2';	// 그래프의 아래쪽 색을 채웁니다
	$graph_highcolor = '#FF0000';	// 그래프 위에 마우스를 가져가면 변하는 색을 지정합니다
	$disp_y = 'true';				// 그래프 왼쪽에 최대값, 평균값 등을 표시합니다
	$disp_x = 'true';				// 그래프 아래쪽에 -날짜와 today를 표시합니다.
	$xy_color = '#cccccc';			// 그래프 왼쪽이나 아래쪽의 글자 색을 정합니다.
	
	// 날짜 계산		
	$now_day = date('Y-m-d', strtotime("now"));
	$old_day = date('Y-m-d', strtotime("-".($how_day-1)." days"));
	
# 최대 방문자 계산
	$max_query = "SELECT vs_count, vs_date FROM {$g5['visit_sum_table']} WHERE vs_date between '".$old_day."' and '".$now_day."' ORDER BY vs_count DESC LIMIT 1";
	$max_data = sql_fetch($max_query);
	$max_data['visits']=$max_data['vs_count']; 

# 평균 방문자 계산

	$avg_query = "SELECT AVG(vs_count) FROM {$g5['visit_sum_table']} WHERE vs_date between '".$old_day."' and '".$now_day."'";
	$avg_result = sql_query($avg_query);

	$avg_data = sql_fetch_array($avg_result);
	$avg = round($avg_data['AVG(vs_count)']);

# 평균의 2배보다 많은 수치를 제외하고 계산
	if($cut_peak == 'true') 
	{
		$cut_line = $avg * 2;
	
		$cut_query = "SELECT MAX(vs_count) FROM {$g5['visit_sum_table']} WHERE vs_count <= ".$cut_line." and vs_date between '".$old_day."' and '".$now_day."'";
		$cut_result = sql_query($cut_query);
	
		$cut_data = sql_fetch_array($cut_result);
		$graph_max = round($cut_data['MAX(vs_count)']);
	}
	else 
		$graph_max = $max_data['visits'];
	
#최대 날짜, 최소 날짜
	if($view_marker=='true') 
	{ 
		$high_date = $max_data['vs_date'];
		
		$low_query = "SELECT vs_date FROM {$g5['visit_sum_table']} WHERE vs_date between '".$old_day."' and '".$now_day."' ORDER BY vs_count ASC LIMIT 1";
		$low_data = sql_fetch($low_query);
		$low_date = $low_data['vs_date'];			
	
		$high_diff = dateDiff(tcDateToTime($old_day), tcDateToTime($high_date));
		$low_diff = dateDiff(tcDateToTime($old_day), tcDateToTime($low_date));
	}

# 실제 방문자수 리스팅
	$dcount_query = "SELECT vs_date, vs_count FROM {$g5['visit_sum_table']} WHERE vs_date between '".$old_day."' and '".$now_day."' ORDER BY vs_date ASC LIMIT ".$how_day; 
	$dcount_result = sql_query($dcount_query);
	
	// 그래프 폭
	$graph_width = ($how_day - 1) * $graph_barwidth;
			
	$target = "
<style type='text/css'>
#dhtmltooltip {
				position: absolute;
				border: 1px solid #ccc;
				padding: 0px 5px;
				visibility: hidden;
				z-index: 100;
				color : #000;
				font-size: 11px;
				text-align: left;
}
#tooltip_ul {
				list-style-type:none;
				margin: 0px  !important;
				padding : 0 !important;
}
#tooltip_ul li {
				margin: 4px  !important;
				padding: 0px 0px 2px 18px  !important;
				line-height: 16px !important;
}
#tooltip_date {
				font-size: 11px;
				color : #000060;
		
				background : url(".$pluginPATH."/date-plain.png) no-repeat 0px 50% !important;
				border-bottom-width: 1px !important;
				border-top-style: none !important;
				border-right-style: none !important;
				border-bottom-style: solid !important;
				border-left-style: none !important;
				border-bottom-color: #EEE !important;
}
#tooltip_post {
				background : url(".$pluginPATH."/doc-option-edit.png) no-repeat 0px 50% !important;
				border : none  !important; 
}
#tooltip_guest {
				background : url(".$pluginPATH."/icon_visit.png) no-repeat 0px 50% !important;
				border : none  !important; 
}
#tooltip_guest1 {
				background : url(".$pluginPATH."/user-plain-blue_mod.png) no-repeat 0px 50% !important;
				border : none  !important; 
}
#draco_counter {
				margin: 0px !important;
				padding: 0px !important;";
				
	$target .= "
				font-family: Tahoma; 
				font-size: 9px; ";
				
	$target .= "color : ".$xy_color.";";
				
	$target .="
}
#draco_counter_y p {
				display: block  !important;
				margin: 0px !important;
				line-height: 12px !important;
}
#draco_counter_x p {
				display: inline  !important;
				margin: 0px !important;
				line-height: 12px !important;
				padding: 0px !important;
}
#draco_counter_y {
				width: 30px;
				height: 100px;
				text-align: right;				
}
#draco_counter_y_max {
				font-size:10px;				
}
#draco_counter_y_mid {
				padding: 34px 0px 46px 0px;
				font-size:10px;
}
#draco_counter_x {
				width : ".($graph_width)."px;
				height: 12px;
				margin: 0px !important;
				padding: 0px !important;
}
#draco_counter_x1 {
				float: left !important;
				text-align: left;
				font-size:10px;
}
#draco_counter_x2 {
				float: right !important;
				text-align: right;
				font-size:10px;
}
</style>
<div id='dhtmltooltip'></div>
<script type='text/javascript'>
/***********************************************
* Cool DHTML tooltip script- ⓒ Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

var offsetxpoint=0 
var offsetypoint=20 
var ie=document.all
var ns6=document.getElementById && !document.all
var enabletip=false
if (ie||ns6)
var tipobj=document.all? document.all['dhtmltooltip'] : document.getElementById? document.getElementById('dhtmltooltip') : ''

function ietruebody() {
	return (document.compatMode && document.compatMode!='BackCompat')? document.documentElement : document.body
}

function ddrivetip(thetext, thecolor, thewidth) {
	if (ns6||ie) {
		if (typeof thewidth!='undefined') tipobj.style.width=thewidth+'px'
		if (typeof thecolor!='undefined' && thecolor!='') tipobj.style.backgroundColor=thecolor
		tipobj.innerHTML=thetext
		enabletip=true
		return false
	}
}

function positiontip(e) {
	if (enabletip) {
		var curX=(ns6)?e.pageX : event.clientX+ietruebody().scrollLeft;
		var curY=(ns6)?e.pageY : event.clientY+ietruebody().scrollTop;
		var rightedge=ie&&!window.opera? ietruebody().clientWidth-event.clientX-offsetxpoint : window.innerWidth-e.clientX-offsetxpoint-20
		var bottomedge=ie&&!window.opera? ietruebody().clientHeight-event.clientY-offsetypoint : window.innerHeight-e.clientY-offsetypoint-20

		var leftedge=(offsetxpoint<0)? offsetxpoint*(-1) : -1000

		if (rightedge<tipobj.offsetWidth)
		tipobj.style.left=ie? ietruebody().scrollLeft+event.clientX-tipobj.offsetWidth+'px' : window.pageXOffset+e.clientX-tipobj.offsetWidth+'px'
		else if (curX<leftedge)
		tipobj.style.left='5px'
		else
		tipobj.style.left=curX+offsetxpoint+'px'

		if (bottomedge<tipobj.offsetHeight)
		tipobj.style.top=ie? ietruebody().scrollTop+event.clientY-tipobj.offsetHeight-offsetypoint+'px' : window.pageYOffset+e.clientY-tipobj.offsetHeight-offsetypoint+'px'
		else
		tipobj.style.top=curY+offsetypoint+'px'
		tipobj.style.visibility='visible'
	}
}

function hideddrivetip() {
	if (ns6||ie) {
		enabletip=false
		tipobj.style.visibility='hidden'
		tipobj.style.left='-1000px'
		tipobj.style.backgroundColor=''
		tipobj.style.width=''
	}
}

function dc_draw(obj, thetxt) {
	obj.style.backgroundColor='".$graph_highcolor."';
	ddrivetip(thetxt,'#fff', 145);
}

function dc_hide(obj){
	obj.style.backgroundColor='';
	hideddrivetip();
}

document.onmousemove=positiontip
</script>
";

	$target .= "<table border='0' cellpadding='0' cellspacing='0' id='draco_counter'><tr>";

#그래프 왼쪽 Y축
	if($disp_y=='true') { 
		$target .="<td id='draco_counter_y'><p id='draco_counter_y_max'>".$max_data['visits']."</p><p id='draco_counter_y_mid'>";
		if($cut_peak == 'true') $target .= $avg;
		else $target .= round($max_data['visits']/2);
		$target .="</p></td>";
	}		

	$target .= "<td><map name='draco_counter_map'>";
	$chd = "";
	$map_x = 0;
	$map_x_next = $map_x + intval($graph_barwidth/2);
	$loopcount = 0;

#그래프 그리기 반복 부분
	while($dcount_data=sql_fetch_array($dcount_result)) 
	{
# 그래프 크기 계산
		//$dcount_data['visits']=stripslashes($dcount_data['vs_count']); 
		$dcount_data['visits']=$dcount_data['vs_count']; 
		
		$graph_high = round($dcount_data['visits'] / $graph_max * 95);
		if($graph_high>95) $graph_high = 95;
		else if($graph_high<0) $graph_high = 0;
		if($chd!="") $chd .= ",";
		$chd .= $graph_high.".0";

			
# 날짜 데이터 년월일로 쪼개기
		$tmp_ymd = explode('-', $dcount_data['vs_date']);
		$y = $tmp_ymd[0];
		$m = $tmp_ymd[1];
		$d = $tmp_ymd[2];
		$yoil = "(".get_yoil($dcount_data[vs_date]).")";
# 해당 날짜에 몇개의 글을 썼나 찾기
		$day_post_query = "select count(*) as cnt from {$g5['board_new_table']} where left(bn_datetime,10) = '$dcount_data[vs_date]' ";
		
		$day_post_data = sql_fetch($day_post_query);
		$day_post = $day_post_data['cnt'];
		
		$temp = sql_fetch("select count(*) as total from {$g5['member_table']} where left(mb_datetime,10) = '$dcount_data[vs_date]'");
	    $member_join = $temp[total];

# 툴팁 창 만들기
		$dcount_day = "<UL id=tooltip_ul><LI id=tooltip_date>".$y."년".$m."월".$d."일".$yoil."<LI id=tooltip_post>게시글 ";
		if($day_post) $dcount_day .= ": ".$day_post."개";
		else $dcount_day .= "없음";
		$dcount_day .= "<LI id=tooltip_guest>방문자 : ".$dcount_data['visits']."명";
		$dcount_day .= "<LI id=tooltip_guest1>가입 : ".$member_join."명</UL>";		

#이미지 맵 만들기		
		$target .= "<area shape='rect' coords='$map_x,0,$map_x_next,100' onmouseover=\"highlight(".$loopcount.");dc_draw(this, '".$dcount_day."');\" onmouseout=\"highlight(-1);dc_hide(this);\"/>";		
		
		$map_x = $map_x_next+1;
		$map_x_next = $map_x -1 + $graph_barwidth;

		$loopcount ++;
		$lastvisit = $dcount_data['visits'];
					
}
		
#구글 api 이미지 주소 만들기		
		$chart_img = "http://chart.apis.google.com/chart?chs=".$graph_width."x100&chd=t:".$chd."&cht=lc&chco=".str_replace("#","",$graph_color)."&chf=bg,s,".str_replace("#","",$graph_backcolor);
		
		if($view_grid=='true') $chart_img .="&chg=".(100/$how_day*7).",50";
				
		if($line_blank=='true') $chart_img .= "&chls=".$line_thickness.",".($line_thickness*2).",".$line_thickness;
		else $chart_img .= "&chls=".$line_thickness.",".($line_thickness*2).",0";
		
		if($graph_fillcolor) $chart_img .="&chm=B,".str_replace("#","",$graph_fillcolor).",0,0,0";
				
		if($view_marker=='true') { 
			if(!$graph_fillcolor) $chart_img .="&chm=";
			else $chart_img .="|";
			$chart_img .="c,6C57E2,0,$high_diff.0,10.0|x,E25757,0,$low_diff.0,10.0";
		}
		
		if($graph_fillcolor || $view_marker=='true') $chart_overimg = $chart_img."|";
		else $chart_overimg = $chart_img."&chm=";
		
		$target .= "</map><img src='$chart_img' name='d_chart' usemap='#draco_counter_map' border=0>";

		$target .= "</td></tr>";


#그래프 하단 X축
		if($disp_x=='true') {
			$target .="<tr>";
			if($disp_y=='true') $target .="<td></td>";
			$target .="<td  id='draco_counter_x'><p id='draco_counter_x1'>-$how_day days</p><p id='draco_counter_x2'> today : $lastvisit</p></td></tr>";
		}

		$target .= "</table> 
			<script type='text/javascript'>
				function highlight(which){
					if(which!=-1)document.images['d_chart'].src = \"".$chart_overimg."V,".str_replace("#","",$graph_highcolor).",0,\"+which+\".0,1.0\";
					else document.images['d_chart'].src = \"".$chart_img."\";
}
			</script>";
	return $target;
}
?>