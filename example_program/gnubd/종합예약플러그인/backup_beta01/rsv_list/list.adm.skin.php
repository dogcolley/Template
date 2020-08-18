<?
/*

※회원은 자기 리스트만 보고싶을 경우
if($is_member && $member['mb_level'] < 8 && $bo_table = 'yp_rsv_list' ){
	$sfl = 'mb_id';	
	$stx = $member['mb_id'];
}

※정보
bo_1 연동게시판
bo_2 예약가능기간 설정 
bo_3 충복 기능 활/비 기능
bo_4 공휴일설정
bo_5 댓글기능 / 메모기능
bo_6 예약시간 사용 안함
bo_7 가격사용
bo_8 수량제어

*/


// 상태값 제어
if($is_admin2 && $action){
	if($action == 'ps_rv'){
		$arr =  explode('|',$ps_data);
		for($i=0;$i < count($arr); $i++){
			$sql = "update  ".$write_table." set wr_4 = '예약완료' where wr_id = '".$arr[$i]."'";
			sql_query($sql);
		}
		alert('예약완료로 변경했습니다.',$err_url);

	}else if($action == 'ps_cl'){
		$arr =  explode('|',$ps_data);
		for($i=0;$i < count($arr); $i++){
			$sql = "update  ".$write_table." set wr_4 = '예약취소' where wr_id = '".$arr[$i]."'";
			sql_query($sql);
		}
		alert('예약취소로 변경했습니다.',$err_url);
	}
}

?>

<?if($member['mb_level'] > 7 || $is_admin2){
 //add_admin (연동게시판 설정하는 부분); 관리자 따로파일 안빼고 작업
?>
<!-- Button trigger modal -->


<div style="margin-top:10px">
	<?if($board['bo_1']){?>
	<a href="<?=G5_BBS_URL?>/board.php?bo_table=<?=$board['bo_1']?>" class="U_btn01 TM_ds_block U_ft_ct">예약목록관리</a>
	<?}?>
	<?if($board['bo_4']){?>
	<a href="<?=G5_BBS_URL?>/board.php?bo_table=<?=$board['bo_4']?>" class="U_btn01 TM_ds_block U_ft_ct">휴일관리하기</a>
	<?}?>
	<button type="button" class="U_btn01 TM_ds_block U_ft_ct" data-toggle="modal" data-target="#exampleModal">
	  관리설정
	</button>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<form action="<?=$url?>" id="ch_lbo" name="ch_lbo" method="post" onsubmit="check01(this);">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">관리 설정
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			</h5>
		  </div>
		  <div class="modal-body U_tab">
			<?  //제어 및 업데이트 
				$http_host = $_SERVER['HTTP_HOST'];
				$request_uri = $_SERVER['REQUEST_URI'];
				$url = 'http://' . $http_host . $request_uri;
				
				if($_POST['bo_9_bun'] && $_POST['bo_9_si']){
					$bo_9 = $_POST['bo_9_si'].":".$_POST['bo_9_bun'];
				}


				if($_POST['lbo'] == '1'){
					$set_table = $g5['write_prefix'].$_POST['lbo_table'];
					$sql = "SELECT 1 FROM ".$set_table;
					$ck_db =sql_query($sql);
					if(!$ck_db){
						$msg = '게시판이 존재하지 않습니다!';
					}else{ 
						$set_table = $g5['board_table'];
						$sql = "update  ".$set_table." set 
							bo_write_level = '".$_POST['bo_write_level']."' , 
							bo_use_secret = '".$_POST['bo_use_secret']."' , 
							bo_content_head = '".$_POST['bo_content_head']."' , 
							bo_9 = '".$bo_9."' , 
							bo_8 = '".$_POST['use_people']."' , 
							bo_7 = '".$_POST['use_price']."' , 
							bo_6 = '".$_POST['use_time']."' , 
							bo_5 = '".$_POST['use_commend']."' , 
							bo_4 = '".$_POST['hd_table']."' , 
							bo_3 = '".$_POST['lm_overlap']."' , 
							bo_2 = '".$_POST['lm_moth']."' , 
							bo_1 = '".$_POST['lbo_table']."' 
							where bo_table = '".$bo_table."'";
						$resulte = sql_query($sql);
						$msg = '적용완료 했습니다.';
					}

					//sms 업데이트 추가
					//SMS 전송유형 필드 추가
					if(!isset($config['cf_nct_sms_use'])) {
						sql_query(" ALTER TABLE `{$g5['config_table']}`
										ADD `cf_nct_sms_use` varchar(255) NOT NULL DEFAULT '' AFTER `cf_icode_server_port`,
										ADD `cf_nct_sms_id` varchar(255) NOT NULL DEFAULT '' AFTER `cf_nct_sms_use`,
										ADD `cf_nct_sms_key` varchar(255) NOT NULL DEFAULT '' AFTER `cf_nct_sms_id`,
										ADD `cf_nct_sms_num` varchar(255) NOT NULL DEFAULT '' AFTER `cf_nct_sms_key`,
										ADD `cf_nct_sms_sendnum` varchar(255) NOT NULL DEFAULT '' AFTER `cf_nct_sms_num` ", true);
					}


					if ( $w == 'u' ) {	
						$sql = " update {$g5['config_table']}
										set 
										cf_nct_sms_use = '{$_POST['cf_nct_sms_use']}',
										cf_nct_sms_id = '{$_POST['cf_nct_sms_id']}',
										cf_nct_sms_key  = '{$_POST['cf_nct_sms_key']}',
										cf_nct_sms_sendnum = '{$_POST['cf_nct_sms_sendnum']}',
										cf_nct_sms_num = '{$_POST['cf_nct_sms_num']}'";
						sql_query($sql);

						//-- 체크박스 값이 안 넘어오는 현상 때문에 추가, 폼의 체크박스는 모두 배열로 선언해 주세요.
						$checkbox_array=array("pn_sms_reserv_ready_adm", "pn_sms_reserv_ready_user", "pn_sms_reserv_comp_adm", "pn_sms_reserv_comp_user", "pn_sms_reserv_canc_adm", "pn_sms_reserv_canc_user", "pn_sms_reserv_canc_cplt_adm", "pn_sms_reserv_canc_cplt_user");
						for ($i=0;$i<sizeof($checkbox_array);$i++) {
							if(!$_REQUEST[$checkbox_array[$i]])
								$_REQUEST[$checkbox_array[$i]] = 0;
						}

						$db_fields[] = "mb_zip";	// 건너뛸 변수명은 배열로 추가해 준다.
						$db_fields[] = "mb_sido_cd";	// 건너뛸 변수명은 배열로 추가해 준다.
						$db_fields[] = "bo_table";	// 건너뛸 변수명은 배열로 추가해 준다.
						$db_fields[] = "w";	// 건너뛸 변수명은 배열로 추가해 준다.
						$db_fields[] = "cf_nct_sms_use";	// 건너뛸 변수명은 배열로 추가해 준다.
						$db_fields[] = "cf_nct_sms_id";	// 건너뛸 변수명은 배열로 추가해 준다.
						$db_fields[] = "cf_nct_sms_key";	// 건너뛸 변수명은 배열로 추가해 준다.
						$db_fields[] = "cf_nct_sms_sendnum";	// 건너뛸 변수명은 배열로 추가해 준다.
						$db_fields[] = "cf_nct_sms_num";	// 건너뛸 변수명은 배열로 추가해 준다.
						foreach($_REQUEST as $key => $value ) {
							//-- 해당 테이블에 있는 필드 제외하고 테이블 prefix 로 시작하는 변수들만 업데이트 --//
							if(!in_array($key,$db_fields)) {
								//echo $key."=".$_REQUEST[$key]."<br>";
								meta_update(array("mta_db_table"=>"board/".$bo_table,"mta_db_id"=>"sms_setting","mta_key"=>$key,"mta_value"=>$value));
							}
						}

					}
					alert($msg,$url);	
				}
			?>
			<ul class="U_tab_btn">
				<li><button type="button">기본설정</button></li>
				<li><button type="button">공통내용</button></li>
				<li><button type="button">SMS계정설정</button></li>
				<li><button type="button">SMS문자설정</button></li>
			</ul>
			<ul class="U_tab_con">
				<li>
					<?if($is_admin2){?>
					<div class="TM_ds_inbl">
						<label for="lbo_table" class="U_tit" >예약연동게시판</label>
						<input type="hidden" id="lbo" name="lbo" value="1" />
						<input type="text" id="lbo_table" name="lbo_table" value="<?=$board['bo_1']?>" class="required frm_input frm_input2"/>
					</div>

					<div class="TM_ds_inbl">
						<label for="hd_table" class="U_tit" >휴일연동게시판</label>
						<input type="text" id="hd_table" name="hd_table" value="<?=$board['bo_4']?>" class="frm_input frm_input2" placeholder="연동시 휴일이 연동됩니다."/>
					</div>
					<?}else{?>
						<input type="hidden" id="lbo" name="lbo" value="1" />
						<input type="hidden" id="hd_table" name="hd_table" value="<?=$board['bo_4']?>"/>
						<input type="hidden" id="lbo_table" name="lbo_table" value="<?=$board['bo_1']?>"/>
					<?}?>

					<div class="TM_ds_inbl">
						<label for="lm_moth" class="U_tit" >예약가능범위</label>
						<?/*
						//해당솔루션은 예약한 일자의 넘버에따라 정해짐
						<input type="text" id="lm_moth" name="lm_moth" value="<?=$board['bo_2'] ? $board['bo_2'] : 0?>" class="frm_input frm_input2" placeholder="오늘부터 입력한 날짜만큼만 예약을 받습니다."/>
						*/?>
						<?/*
						//해당솔루션은 예약의 모드를 정해짐
						*/?>
						<select name="lm_moth" id="lm_moth" class="frm_input frm_input2" >
							<option value="">제한없음</option>
							<option value="1" <? if($board['bo_2'] == '1')echo 'selected' ?>>이번달만</option>
							<option value="2" <? if($board['bo_2'] == '2')echo 'selected' ?>>다음달까지</option>
							<option value="3" <? if($board['bo_2'] == '3')echo 'selected' ?>>분기예약 (3개월단위)</option>
							<option value="6" <? if($board['bo_2'] == '6')echo 'selected' ?>>반년 (6개월단위)</option>
							<option value="12" <? if($board['bo_2'] == '12')echo 'selected' ?>>1년 (12개월단위)</option>
						</select>
						<p style="margin-top:5px">오늘부터 입력한 일수 만큼만 예약을 받습니다.</p>
					</div>

					<div class="TM_ds_inbl">
						<label for="lm_overlap" class="U_tit" >중복예약기능</label>
						<select name="lm_overlap" id="lm_overlap" class="frm_input frm_input2" >
							<option value="" <? if($board['bo_3'] == '')echo 'selected' ?>>비활성</option>
							<option value="1" <? if($board['bo_3'] == '1')echo 'selected' ?>>활성</option>
						</select>
						<p style="margin-top:5px">특정의 일의 예약을 한계정으로 중복예약할 수 있게 해주는 기능입니다.</p>
					</div>

					<div class="TM_ds_inbl">
						<label for="use_commend" class="U_tit" >댓글,메모기능</label>
						<select name="use_commend" id="use_commend" class="frm_input frm_input2" >
							<option value="" <? if($board['bo_5'] == '')echo 'selected' ?>>비활성</option>
							<option value="1" <? if($board['bo_5'] == '1')echo 'selected' ?>>활성</option>
						</select>
						<p style="margin-top:5px">신청된 예약,구매에 댓글과 메모를 남길수있는 기능입니다.</p>
					</div>

					<div class="TM_ds_inbl">
						<label for="use_time" class="U_tit" >시간기능</label>
						<select name="use_time" id="use_time" class="frm_input frm_input2" >
							<option value="" <? if($board['bo_6'] == '')echo 'selected' ?>>활성</option>
							<option value="1" <? if($board['bo_6'] == '1')echo 'selected' ?>>비활성</option>
						</select>
						<p style="margin-top:5px">예약시간에 따른 제약할수 있는기능을 활성,비활성 시킬수있습니다.</p>
					</div>

					<div class="TM_ds_inbl">
						<label for="use_price" class="U_tit" >가격사용</label>
						<select name="use_price" id="use_price" class="frm_input frm_input2" >
							<option value="" <? if($board['bo_7'] == '')echo 'selected' ?>>비활성</option>
							<option value="1" <? if($board['bo_7'] == '1')echo 'selected' ?>>활성</option>
						</select>
						<p style="margin-top:5px">활성시 입력한 예약정보의 가격이 노출됩니다.</p>
					</div>

					<div class="TM_ds_inbl">
						<label for="use_people" class="U_tit" >수량제어</label>
						<select name="use_people" id="use_people" class="frm_input frm_input2" >
							<option value="" <? if($board['bo_8'] == '')echo 'selected' ?>>비활성</option>
							<option value="1" <? if($board['bo_8'] == '1')echo 'selected' ?>>활성</option>
						</select>
						<p style="margin-top:5px">예약옵션에 수량,인원제어 기능</p>
					</div>

					<div class="TM_ds_inbl">
						<label for="bo_write_level" class="U_tit" >예약가능기준</label>
						<select name="bo_write_level" id="bo_write_level" class="frm_input frm_input2" >
							<option value="1" <? if($board['bo_write_level'] == '1')echo 'selected' ?>>비회원,회원모두</option>
							<option value="2" <? if($board['bo_write_level'] == '2')echo 'selected' ?>>회원만</option>
						</select>
						<p style="margin-top:5px">선택한 기준에 맞춰 예약신청이 가능합니다.</p>
					</div>

					<div class="TM_ds_inbl">
						<label for="bo_use_secret" class="U_tit" >비밀글설정</label>
						<select name="bo_use_secret" id="bo_use_secret" class="frm_input frm_input2" >
							<option value="" >사용하지 않음</option>
							<option value="1" <? if($board['bo_use_secret'] == '1')echo 'selected' ?>>체크박스</option>
							<option value="2" <? if($board['bo_use_secret'] == '2' || !$board['bo_use_secret'] )echo 'selected' ?>>무조건</option>
						</select>
						<p style="margin-top:5px">설정시 글은 작성자와 관리자만 볼수있습니다.</p>
					</div>

					<div>
						<label for="bo_9_si" class="U_tit" style="display:block" >1일 예약시간 오픈 설정</label>
						<select name="bo_9_si" id="bo_9_si" class="frm_input frm_input2" style="width:49%;float:left">
							<option value="" >사용안함</option>
							<?
								$bo_9_arr = explode(':',$board['bo_9']);
								for($i=1;$i < 24; $i++){
							?>
								<option value="<?=$i?>" <?=(int)$bo_9_arr[0]==$i?'selected':''?> ><?=$i?>시</option>
							<?}?>
						</select>

						<select name="bo_9_bun" id="bo_9_bun" class="frm_input frm_input2" style="width:49%;float:left;margin-left:1%">
							<option value="" >사용안함</option>
							<?
								for($i=0;$i < 60; $i++){
							?>
								<option value="<?=$i?>" <?=(int)$bo_9_arr[1]==$i?'selected':''?> ><?=$i?>분</option>
							<?}?>
						</select>
						<br/>

						<p style="margin-top:5px">설정시 글은 작성자와 관리자만 볼수있습니다.</p>
					</div>
				</li>

				<li>
					<div class="TM_ds_inbl" style="width:100%">
						<label for="bo_use_secret" class="U_tit" >기본메세지</label>
						<?php 
							include_once(G5_EDITOR_LIB);
							echo editor_html("bo_content_head", $board['bo_content_head']); ?>
						<?php// echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?>
						<p style="margin-top:5px">예약페이지에 상단에 노출되는 글입니다.</p>
					</div>
				</li>

				<li>
				<? //sns 관리부분
				if(@$config['cf_nct_sms_id'] && @$config['cf_nct_sms_key']){
					$info = parse_url("http://sms.nccj.kr/api/remind_count/".$config['cf_nct_sms_id']."/".$config['cf_nct_sms_key']);

					$fp = fsockopen($info['host'], 80);
					if($fp){
						$remindCountResult = "0";
						$parm = "";
						$send = "POST " . $info["path"] . " HTTP/1.1\r\n"
						."Host: " . $info["host"] . "\r\n"
						. "Content-type: application/x-www-form-urlencoded\r\n"
						. "Content-length: " . strlen($parm) . "\r\n"
						. "Connection: close\r\n\r\n" . $parm."\r\n";

						fputs($fp, $send);
						
						while(!feof($fp)) $remindCountResult = fgets($fp, 128);

						$remindResult = json_decode($remindCountResult);
						$remindCount = $remindResult->remind_count;
					}		   
				}

				$sql = "select mta_key, mta_value from g5_5_meta where mta_db_table = 'board/".$bo_table."' and mta_db_id = 'sms_setting' order by mta_idx desc";
				$result = sql_query($sql);

				for ($i=0; $row=sql_fetch_array($result); $i++)
					$mta[$row["mta_key"]] = $row["mta_value"];
				?>
					<form name="sms_frm" id="sms_frm" onsubmit="return sms_write(this);" method="post" autocomplete="off">
					<input type="hidden" name="w" value="u">
					<input type="hidden" name="bo_table" value="<?=$bo_table?>">
					<div class="tbl_frm01 tbl_wrap">
						<table>
						<caption class="caption_blind">SMS 설정</caption>
						<colgroup>
							<col class="grid_4">
							<col>
						</colgroup>
						<thead>
						<?/*
						<tr>
							<th scope="row" style="width:35%;"></th>
							<th scope="row" style="width:65%;"></th>
						</tr>
						*/?>
						</thead>
						<tbody>
						<tr>
							<th scope="row"><label for="cf_nct_sms_use">SMS 사용설정</label></th>
							<td>
								<select id="cf_nct_sms_use" name="cf_nct_sms_use">
									<option value="" <?php echo get_selected($config['cf_nct_sms_use'], ''); ?>>사용안함</option>
									<option value="uplus" <?php echo get_selected($config['cf_nct_sms_use'], 'uplus'); ?>>유플러스</option>
								</select>
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="cf_nct_sms_id">SMS 아이디</label></th>
							<td>
								<input type="text" name="cf_nct_sms_id" value="<?php echo $config['cf_nct_sms_id']; ?>" id="cf_nct_sms_id" class="frm_input" size="20">
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="cf_nct_sms_key">SMS 키값</label></th>
							<td>
								<input type="text" name="cf_nct_sms_key" value="<?php echo $config['cf_nct_sms_key']; ?>" id="cf_nct_sms_key" class="frm_input" size="50">
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="cf_nct_sms_sendnum">관리자 전화번호<br>(SMS 관리자 등록용 번호)</label></th>
							<td>
								<input type="text" name="cf_nct_sms_sendnum" value="<?php echo $config['cf_nct_sms_sendnum']; ?>" id="cf_nct_sms_sendnum" class="frm_input">
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="cf_nct_sms_num">발신전화번호<br>(발송할 때 번호)</label></th>
							<td>
								<input type="text" name="cf_nct_sms_num" value="<?php echo $config['cf_nct_sms_num']; ?>" id="cf_nct_sms_num" class="frm_input">
							</td>
						</tr>
						<tr>
							<th scope="row">충전 잔여량</th>
							<td colspan="3">
								<?=$remindCount?>
							</td>
						</tr>
						</tbody>
						</table>
					</div>			
				</li>
				<li>
					<div class="tbl_frm01 tbl_wrap tab-con" data-tabCon='2'>
						<table id="sms_table">
						<caption>SMS발송 설정</caption>
						<colgroup>
							<col class="grid_5">
							<col>
						</colgroup>
						<thead>
						<?/*
						<tr>
							<th scope="row" style="width:16%;"></th>
							<th scope="row" style="width:42%;"></th>
							<th scope="row" style="width:42%;"></th>
						</tr>
						*/?>
						</thead>
						<tbody>
						<tr>
							<th scope="row" colspan="3" style="height:50px;">SMS발송 메세지 여부 및 문구 설정</th>
						</tr>
						<tr>
							<td colspan="3">
								<strong>[TIP]</strong> 발송 여부 및 문구 설정시 <br><br>
								<font style="color:red;">※ 전송내용에 있는 각 변수 들은 {name}: 예약자, {date}: 예약날짜,{type}: 선박종류 입니다. <br>
								※ 변수 이외의 문구들은 직접 설정이 가능합니다. <br>
								※ SMS 서비스는 80 byte 길이 까지만 지원합니다. (한글 기준 약 40자) <br><br></font>
								ex) [관리자] {name}님 {type}  {date} 예약이 접수되었습니다. <br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[사용자] {name}님 {type} 예약접수 완료 공지사황 확인 부탁드립니다.
							</td>
						</tr>
						<tr>
							<th scope="row">SMS발송 여부 설정</th>
							<td colspan="3">
								<?php // echo help("예약시 SMS발송여부를 설정합니다.\n사용할 경우 SMS발송메세지를 반드시 입력하여 주십시오.", 50); ?>
								<select id="pn_pg_sms_use" name="pn_pg_sms_use">
									<option value="0" <?php if($mta['pn_pg_sms_use'] == "0") echo "selected"; ?>>사용안함</option>
									<option value="1" <?php if($mta['pn_pg_sms_use'] == "1") echo "selected"; ?>>사용</option>
								</select>
							</td>
						</tr>
						<tr class="sms_dis_table">
							<th scope="row">예약시</th>
							<td>
								<input type="checkbox" name="pn_sms_reserv_ready_adm" id="pn_sms_reserv_ready_adm" value="1" <?php echo ( $mta['pn_sms_reserv_ready_adm'] ) ?  "checked" :  ""?>> <strong>관리자</strong> <br><br>
								<div >ex) 예약이 접수되었습니다.</div>
								<textarea name="pn_sms_reserv_ready_adm_info" id="pn_sms_reserv_ready_adm_info" style="height:60px; resize: none;"><?php echo $mta['pn_sms_reserv_ready_adm_info']; ?></textarea>
							</td>
							<td>
								<input type="checkbox" name="pn_sms_reserv_ready_user" id="pn_sms_reserv_ready_user" value="1" <?php echo ( $mta['pn_sms_reserv_ready_user'] ) ?  "checked" :  ""?>> <strong>예약자</strong> <br><br>
								<div >ex) 예약이 접수되었습니다.</div>

								<textarea name="pn_sms_reserv_ready_user_info" id="pn_sms_reserv_ready_user_info" style="height:60px; resize: none;"><?php echo $mta['pn_sms_reserv_ready_user_info']; ?></textarea>
							</td>
						</tr>
						<tr class="sms_dis_table">
							<th scope="row">예약 완료시</th>
							<td>
								<input type="checkbox" name="pn_sms_reserv_comp_adm" id="pn_sms_reserv_comp_adm" value="1" <?php echo ( $mta['pn_sms_reserv_comp_adm'] ) ?  "checked" :  ""?>> <strong>관리자</strong> <br><br>
								<div >ex) 예약이 완료 되었습니다.</div>

								<textarea name="pn_sms_reserv_comp_adm_info" id="pn_sms_reserv_comp_adm_info" style="height:60px; resize: none;"><?php echo $mta['pn_sms_reserv_comp_adm_info']; ?></textarea>
							</td>
							<td>
								<input type="checkbox" name="pn_sms_reserv_comp_user" id="pn_sms_reserv_comp_user" value="1" <?php echo ( $mta['pn_sms_reserv_comp_user'] ) ?  "checked" :  ""?>> <strong>예약자</strong> <br><br>
								<div >ex) 예약이 완료 되었습니다.</div>

								<textarea name="pn_sms_reserv_comp_user_info" id="pn_sms_reserv_comp_user_info" style="height:60px; resize: none;"><?php echo $mta['pn_sms_reserv_comp_user_info']; ?></textarea>
							</td>
						</tr>
						<tr class="sms_dis_table">
							<th scope="row">취소 요청시</th>
							<td>
								<input type="checkbox" name="pn_sms_reserv_canc_adm" id="pn_sms_reserv_canc_adm" value="1" <?php echo ( $mta['pn_sms_reserv_canc_adm'] ) ?  "checked" :  ""?>> <strong>관리자</strong> <br><br>
								<div >ex) 예약이 취소요청 되었습니다.</div>

								<textarea name="pn_sms_reserv_canc_adm_info" id="pn_sms_reserv_canc_adm_info" style="height:60px; resize: none;"><?php echo $mta['pn_sms_reserv_canc_adm_info']; ?></textarea>
							</td>
							<td>
								<input type="checkbox" name="pn_sms_reserv_canc_user" id="pn_sms_reserv_canc_user" value="1" <?php echo ( $mta['pn_sms_reserv_canc_user'] ) ?  "checked" :  ""?>> <strong>예약자</strong> <br><br>
								<div >ex) 예약이 취소요청 되었습니다.</div>

								<textarea name="pn_sms_reserv_canc_user_info" id="pn_sms_reserv_canc_user_info" style="height:60px; resize: none;"><?php echo $mta['pn_sms_reserv_canc_user_info']; ?></textarea>
							</td>
						</tr>
						<tr class="sms_dis_table">
							<th scope="row">취소 완료시</th>
							<td>
								<input type="checkbox" name="pn_sms_reserv_canc_cplt_adm" id="pn_sms_reserv_canc_cplt_adm" value="1" <?php echo ( $mta['pn_sms_reserv_canc_cplt_adm'] ) ?  "checked" :  ""?>> <strong>관리자</strong> <br><br>
								<div >ex) 예약이 취소완료 되었습니다.</div>

								<textarea name="pn_sms_reserv_canc_cplt_adm_info" id="pn_sms_reserv_canc_cplt_adm_info" style="height:60px; resize: none;"><?php echo $mta['pn_sms_reserv_canc_cplt_adm_info']; ?></textarea>
							</td>
							<td>
								<input type="checkbox" name="pn_sms_reserv_canc_cplt_user" id="pn_sms_reserv_canc_cplt_user" value="1" <?php echo ( $mta['pn_sms_reserv_canc_cplt_user'] ) ?  "checked" :  ""?>> <strong>예약자</strong> <br><br>
								<div >ex) 예약이 취소완료 되었습니다.</div>

								<textarea name="pn_sms_reserv_canc_cplt_user_info" id="pn_sms_reserv_canc_cplt_user_info" style="height:60px; resize: none;"><?php echo $mta['pn_sms_reserv_canc_cplt_user_info']; ?></textarea>
							</td>
						</tr>
						</tbody>
						</table>
					</div>
				</li>
			</ul>			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="U_btn01 TM_ds_block" data-dismiss="modal" style="background:#f9f9f9;color:#777;border:1px solid #d9d9d9">닫기</button>
			<input value="저장하기" type="submit" class="U_btn01 TM_ds_block" />
		  </div>
		</div>
	  </div>
	</form>
</div>

<script>
	function check01 (f){
		<?php  echo get_editor_js('bo_content_head');?>
	}

	$('.U_tab_btn button').on('click',function(){
		var setTab = $('.U_tab_btn').parents('.U_tab');
		var setTabCon = setTab.find('.U_tab_con');
		var setTabBtn = setTab.find('.U_tab_btn');
		var indx = $(this).parent().index();
		setTabCon.find('>li').hide();
		setTabCon.find('>li').eq(indx).show();
		setTabBtn.find('li button').removeClass('on');
		$(this).addClass('on');
	});
</script>

<?}?>
