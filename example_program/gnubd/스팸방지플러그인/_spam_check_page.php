<?php
include_once('./_common.php');


if($member['mb_level'] < 8) {
	alert('접속 실패', G5_URL);
	exit;
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
<!--<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=0,maximum-scale=10,user-scalable=yes">-->
<?php
if($_POST['w'] == "d") {

	$tmp_array = array();
	$tmp_array = $_POST['chk_idx'];

	$chk_count = count($tmp_array);


	for ($i=$chk_count-1; $i>=0; $i--)
	{
		sql_query(" delete from {$g5['spam_log_table']} where sl_idx = '{$tmp_array[$i]}' ");
	}

	goto_url(G5_URL.'/_spam_check_page.php?&page='.$_POST['page']);
}


//퍼센트 함수
function fnPercent2($range, $total, $slice)
{
    if($total == 0)$total = 1; //Division by zero 에러방지
 
    $result;
 
    if($range == "totalPer" || $range == "total"){
        //n = 전체값 * 퍼센트 / 100;
        $result = ($total * $slice) / 100;
        return round($result);
    }else{
        //n% = 일부값 / 전체값 * 100;
        $result = ($slice / $total) * 100;
        return number_format($result, 2, '.', '');
    }
}


$page_rows = 20;

$sql = " SELECT COUNT(DISTINCT `sl_idx`) AS `cnt` FROM {$g5['spam_log_table']}";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)

$total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산
$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

$write_pages = get_paging($config['cf_write_pages'], $page, $total_page, $_SERVER['PHP_SELF'].'?');


$sql = "SELECT * FROM {$g5['spam_log_table']} ORDER BY sl_idx DESC limit {$from_record}, {$page_rows}";
$result = sql_query($sql);
$result_modal = sql_query($sql);

if($page_rows > 0) {
	$result_num = sql_query($sql);
	$i = 0;

	while ($rows = sql_fetch_array($result_num))
	{
		$list_num = $total_count - ($page - 1) * $page_rows;
		$num[$i]['num'] = $list_num - $i;

		$i++;
	}
}

// 캡챠로 등록된 글 개수
$cap_count = sql_fetch("SELECT COUNT(DISTINCT `sl_idx`) AS `cnt` FROM {$g5['spam_log_table']} WHERE `sl_captcha` != '' and `sl_captcha_chk` != '' ORDER BY sl_idx DESC");
$cap_count = $cap_count['cnt'];

// 등록 성공된 글 개수
$success_count = sql_fetch("SELECT COUNT(DISTINCT `sl_idx`) AS `cnt` FROM {$g5['spam_log_table']} WHERE `sl_captcha` = '' and `sl_confirm` = '등록성공'  ORDER BY sl_idx DESC");
$success_count = $success_count['cnt'];

// 등록 실패된 글 개수
$fail_count = sql_fetch("SELECT COUNT(DISTINCT `sl_idx`) AS `cnt` FROM {$g5['spam_log_table']} WHERE `sl_captcha` = '' and `sl_confirm` = '등록실패'  ORDER BY sl_idx DESC");
$fail_count = $fail_count['cnt'];

// 직접 쓴 글 성공된 글 개수
$w_success_count = sql_fetch("SELECT COUNT(DISTINCT `sl_idx`) AS `cnt` FROM {$g5['spam_log_table']} WHERE `sl_captcha` != '' and `sl_captcha_chk` != '' and `wr_name` != '' and `sl_confirm` = '등록성공'  ORDER BY sl_idx DESC");
$w_success_count = $w_success_count['cnt'];

// 직접 쓴 글 실패된 글 개수
$w_fail_count = sql_fetch("SELECT COUNT(DISTINCT `sl_idx`) AS `cnt` FROM {$g5['spam_log_table']} WHERE `sl_captcha` != '' and `sl_captcha_chk` != '' and `wr_name` != '' and `sl_confirm` = '등록실패'  ORDER BY sl_idx DESC");
$w_fail_count = $w_fail_count['cnt'];
?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<style>
.table tr {
    cursor: pointer;
}
.hiddenRow {
    padding: 0 4px !important;
    background-color: #eeeeee;
    font-size: 13px;
}
/* 페이징 */
.pg_wrap {clear:both;margin:0;padding:10px 0 10px 0;font-size:12px;text-align:center}
.pg {}
.pg_page, .pg_current, .qa_page {}
.pg_page, .qa_page {}
.pg_page, .pg_current {display:inline-block;width:30px;height:30px;margin:0 1px;padding:0 8px;color:#7a7e8a;font-size:12px;letter-spacing:0;line-height:2.5em;vertical-align:middle}
.pg a:focus, .pg a:hover {text-decoration:none}
.pg_page {border:1px solid #b1b4bb;border-radius:4px;color:#7a7e8a !important;text-decoration:none}
.pg_start, .pg_prev {/* 이전 */width:42px;background-position:8px 1px;}
.pg_end, .pg_next {/* 다음 */width:42px;}
.pg_end {background:url('./img/paging.gif');background-position:-75px 1px;}
.pg_current {display:inline-block;margin:0;background:#7a7e8a;border-radius:4px;color:#fff !important;font-weight:normal}

.sound_only { display:none; }

@media (min-width: 1200px) {
.container {
    max-width: 1440px;
}
}

</style>

<div class="container-fluid">
	<div class="row">
		
		<div class="container">
			<div class="col-lg-12 p-1 pt-2">
				<a href="<?=G5_URL?>" class="btn btn-sm btn-dark">홈으로</a>
			</div>
		</div>

		<div class="container">
			<div class="col-lg-12 text-center p-1">
				<div class="float-left text-left">
					<div class="small font-weight-bold">Total : <?=$total_count?> (100%)</div>
					<div class="small">스팸 예상 Total : <?=$total_count-$cap_count?><?php echo " (".fnPercent2("dd", $total_count, $total_count-$cap_count)."%)"; ?></div>
					<div class="small">스팸 예상 성공 : <?=$success_count?><?php echo " (".fnPercent2("dd", $total_count-$cap_count, $success_count)."%)"; ?></div>
					<div class="small text-danger">스팸 예상 실패 : <?=$fail_count?><?php echo " (".fnPercent2("dd", $total_count-$cap_count, $fail_count)."%)"; ?></div>
				</div>
				<div class="float-right text-right">
					<div class="small">실제 작성 Total : <?=$cap_count?><?php echo " (".fnPercent2("dd", $total_count, $cap_count)."%)"; ?></div>
					<div class="small table-primary">실제 작성 성공 : <?=$w_success_count?><?php echo " (".fnPercent2("dd", $cap_count, $w_success_count)."%)"; ?></div>
					<div class="small table-danger">실제 작성 실패 : <?=$w_fail_count?><?php echo " (".fnPercent2("dd", $cap_count, $w_fail_count)."%)"; ?></div>
				</div>
				<?php echo $write_pages; ?>
			</div>
		</div>
		
		<div class="col-lg-12">
			<div class="container">
				<form name="frm_ls" id="frm_ls" action="<?=$_SERVER['PHP_SELF']?>" onsubmit="return f_submit(this);" method="post">
					<input type="hidden" name="page" value="<?=$page?>">
					<input type="hidden" name="w" value="d">
					
					<div class="float-right mb-2">
						<input type="submit" value="선택삭제" class="btn btn-sm btn-danger" onclick="document.pressed=this.value">
					</div>

					<table class="table table-responsive table-sm table-bordered table-hover text-center small">
						<thead class="thead-dark">
							<tr>
								<th scope="col" class="align-middle">No</th>
								<th scope="col" class="align-middle">상태</th>
								<th scope="col" class="align-middle">사유</th>
								<th scope="col" class="align-middle">제목</th>
								<th scope="col" class="align-middle">bo_table</th>
								<th scope="col" class="align-middle">captcha</th>
								<th scope="col" class="align-middle">captcha 체크</th>
								<th scope="col" class="align-middle">접속ip</th>
								<th scope="col" class="align-middle">브라우저</th>
								<th scope="col" class="align-middle">디바이스</th>
								<th scope="col" class="align-middle">OS</th>
								<th scope="col" class="align-middle">일시</th>
								<th scope="col" class="align-middle"><label>전체<input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);"></label></th>
							</tr>
						</thead>
						<tbody>
							<?php
							$r_num=1;
							$i=0;
							while($row=sql_fetch_array($result)) {
								$modal_tr = 'data-toggle="modal" data-target="#largeModal'.$r_num.'"';
							?>	
							<tr class="<? if($row['sl_confirm'] == "등록성공" && $row['sl_captcha'] != "" && $row['wr_name']) { ?>table-primary<? } ?><? if($row['sl_confirm'] == "등록실패" && $row['sl_captcha'] != "" && $row['wr_name']) { ?>table-danger<? } ?>">
								<th <?=$modal_tr?> scope="row" class="align-middle"><?=$num[$i]['num'];?></th>
								<td <?=$modal_tr?> class="align-middle">
								<? if($row['sl_confirm'] == "등록실패") { ?>
									<?php
										if($row['sl_captcha'] != "" && $row['wr_name']) {
											echo '<span class="text-danger font-weight-bold">실&nbsp;패</span>';
										}else{
											echo '<span class="text-danger">실&nbsp;패<br>&nbsp;(스&nbsp;팸)&nbsp;</span>';
										}
									?>
								<? }else{ ?>
									<?php
										if($row['sl_captcha'] != "" && $row['wr_name']) {
											echo '<span class="text-primary font-weight-bold">성&nbsp;공</span>';
										}else{
											echo '<span>성&nbsp;공<br>&nbsp;(스&nbsp;팸)&nbsp;</span>';
										}
									?>
								<? } ?>
								</td>
								<td <?=$modal_tr?> class="align-middle"><?=$row['sl_filter'];?></td>
								<td <?=$modal_tr?> class="align-middle"><?=$row['wr_subject'];?></td>
								<td <?=$modal_tr?> class="align-middle"><?=$row['sl_bo_table'];?><br><? $bo_name = sql_fetch("select bo_subject from {$g5['board_table']} where bo_table = '{$row['sl_bo_table']}'"); echo "(".$bo_name['bo_subject'].")";?></td>
								<td <?=$modal_tr?> class="align-middle"><?=$row['sl_captcha'];?></td>
								<td <?=$modal_tr?> class="align-middle"><?=$row['sl_captcha_chk'];?></td>
								<td <?=$modal_tr?> class="align-middle"><?=$row['sl_now_ip'];?></td>
								<td <?=$modal_tr?> class="align-middle"><?=$row['sl_browser'];?></td>
								<td <?=$modal_tr?> class="align-middle"><?=$row['sl_device'];?></td>
								<td <?=$modal_tr?> class="align-middle"><?=$row['sl_os'];?></td>
								<td <?=$modal_tr?> class="align-middle"><?=$row['sl_date'];?><br><?=$row['sl_time'];?></td>
								<td class="align-middle"><input type="checkbox" name="chk_idx[]" value="<?=$row['sl_idx']?>" style="width:15px;height:15px;"></td>
							</tr>
							</a>

							<?php
							$i++;
							$r_num++;
							}
							?>
						</tbody>
					</table>

					<div class="float-right">
						<input type="submit" value="선택삭제" class="btn btn-sm btn-danger" onclick="document.pressed=this.value">
					</div>

				</form>
			</div>
		</div>

		<div class="col-lg-12 text-center p-3 mb-5">
			<?php echo $write_pages; ?>
		</div>
	</div>
</div>

<script>
function all_checked(sw) {
    var f = document.frm_ls;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_idx[]")
            f.elements[i].checked = sw;
    }
}

function f_submit(f) {
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_idx[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }

	if(document.pressed == "선택삭제") {
        if (!confirm("선택한 데이터를 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다."))
            return false;

        f.removeAttribute("target");
        f.action = "./_spam_check_page.php";
    }
}
</script>

<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
			<?php
			$r_num=1;
			while($row=sql_fetch_array($result_modal)) {

				$html = 0;
				if (strstr($view['wr_option'], 'html1'))
					$html = 1;
				else if (strstr($view['wr_option'], 'html2'))
					$html = 2;

				$row['content'] = conv_content($row['wr_content'], $html);
				$row['r_typing'] = conv_content($row['sl_typing'], $html);
			?>

			<div class="modal fade" id="largeModal<?=$r_num?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" style="display:none;">
			  <div class="modal-dialog modal-lg">
				<div class="modal-content">
				  <div class="modal-header">
					<h4 class="modal-title font-weight-bold" id="myModalLabel">
						<? if($row['sl_confirm'] == "등록실패") { ?>
							<?php
								if($row['sl_captcha'] != "" && $row['wr_name']) {
									echo '<span class="text-danger">실패</span>';
								}else{
									echo '<span class="text-danger">실패 (스팸)</span>';
								}
							?>
						<? }else{ ?>
							<?php
								if($row['sl_captcha'] != "" && $row['wr_name']) {
									echo '<span class="text-primary">성공</span>';
								}else{
									echo '<span>성공 (스팸)</span>';
								}
							?>
						<? } ?>
					</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body">
					<table class="table table-responsive table-sm small table-bordered text-center">
						<thead class="thead-dark ">
							<tr>
								<th scope="col">bo_table</th>
								<th scope="col">wr_id</th>
								<th scope="col">wr_num</th>
								<th scope="col">mb_id</th>
								<th scope="col">mb_name</th>
								<th scope="col">wr_name</th>
								<th scope="col">wr_email</th>
							</tr>
							<tr>
								<th scope="col">wr_subject</th>
								<th scope="col">sl_typing</th>
								<th scope="col">wr_content</th>
								<th scope="col">wr_1</th>
								<th scope="col">wr_2</th>
								<th scope="col">wr_ip</th>
								<th scope="col">wr_datetime</th>
							</tr>
							<tr>
								<th scope="col" colspan="3">최초접속경로</th>
								<th scope="col" colspan="4">update접속경로</th>
							</tr>
						</thead>
						<tbody style="max-height:100px;">
							<tr>
								<td class="align-middle"><?=$row['bo_table'];?><br><? $bo_name = sql_fetch("select bo_subject from {$g5['board_table']} where bo_table = '{$row['bo_table']}'"); echo $bo_name['bo_subject'];?></td>
								<td class="align-middle"><?=$row['wr_id'];?></td>
								<td class="align-middle"><?=$row['wr_num'];?></td>
								<td class="align-middle"><?=$row['mb_id'];?></td>
								<td class="align-middle"><?=$row['mb_name'];?></td>
								<td class="align-middle"><?=$row['wr_name'];?></td>
								<td class="align-middle"><?=$row['wr_email'];?></td>
							</tr>
							<tr>
								<td class="align-middle"><?=$row['wr_subject'];?></td>
								<td class="align-middle">
								<? if($row['sl_typing']) { ?>
								<?php echo (cut_str($row['sl_typing'], 30)); ?><br><br><a href="#" class="btn btn-sm btn-primary small" data-toggle="modal" data-target="#largeModal2<?=$r_num?>">내용보기</a><? } ?></td>
								<td class="align-middle"><?php echo (cut_str($row['content'], 50)); ?><br><br><a href="#" class="btn btn-sm btn-primary small" data-toggle="modal" data-target="#largeModal3<?=$r_num?>">내용보기</a></td>
								<td class="align-middle"><?=$row['wr_1'];?></td>
								<td class="align-middle"><?=$row['wr_2'];?></td>
								<td class="align-middle"><?=$row['wr_ip'];?></td>
								<td class="align-middle"><?=$row['wr_datetime'];?></td>
							</tr>
							<tr>
								<td colspan="3" class="align-middle"><a href="<?=$row['sl_before_site'];?>" target="_blank"><?=$row['sl_before_site'];?></a></td>
								<td colspan="4" class="align-middle"><a href="<?=$row['sl_now_site'];?>" target="_blank"><?=$row['sl_now_site'];?></a></td>
							</tr>
						</tbody>

					</table>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-secondary btn-sm small" data-dismiss="modal">닫기</button>
				  </div>
				</div>
			  </div>
			</div>

			<div class="modal fade" id="largeModal2<?=$r_num?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" style="display:none;">
			  <div class="modal-dialog modal-lg">
				<div class="modal-content">
				  <div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">실제 타이핑 확인</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body">
					<div class="container">
						<div class="small" style="overflow:hidden;word-wrap:break-word;">
						<?php
							$real_arr = @explode(",", trim($row['r_typing']));
							
							$end_item = @end($real_arr);

							if (empty($end_item)) { 
								@array_pop($real_arr); 
							}

							$rArr = @array_count_values($real_arr);
							foreach( $rArr as $key => $value ){
								echo $key. " => " .$value. '번';
								echo "<br>";
							}
							echo "<br>";
						?>
						<?=$row['r_typing'];?>
						</div>
					</div>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-secondary btn-sm small" data-dismiss="modal">닫기</button>
				  </div>
				 </div>
				</div>
			</div>

			<div class="modal fade" id="largeModal3<?=$r_num?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" style="display:none;">
			  <div class="modal-dialog modal-lg">
				<div class="modal-content">
				  <div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">wr_content 컨텐츠 확인</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body">
					<div class="container">
						<div class="small" style="overflow:hidden;word-wrap:break-word;">
						<?=$row['content'];?>
						</div>
					</div>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-secondary btn-sm small" data-dismiss="modal">닫기</button>
				  </div>
				 </div>
				</div>
			</div>

			<?php
			$r_num++;
			}
			?>
		</div>
	</div>
</div>


<script>
$('.accordian-body').on('show.bs.collapse', function () {
    $(this).closest("table")
        .find(".collapse.in")
        .not(this)
        .collapse('toggle')
});
</script>


</body>
</html>