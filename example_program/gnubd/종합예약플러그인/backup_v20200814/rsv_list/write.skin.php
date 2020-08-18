<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);

include_once($board_skin_path."/add_module.php");

//널값체크
if($member['mb_level'] < 7 ){
	if(!$set_day){
		alert('날짜를 선택해주세요!');
	}

	if(!$link_wr_id){
		alert('예약을 선택해주세요!');
	}
}

if(ch_limo() == 'false'){
	alert('예약가능한 날이 아닙니다.','./board.php?bo_table='.$bo_table);
}

if(!$wr_2)$wr_2 = $set_day;

//리트스변수
$link_list_arr;

//유효값체크
if(gettype($link_wr_id) == 'array'){
	foreach($_POST['link_wr_id'] as $value){
		$wr_1 .= $value.'|';
	}
	$wr_1 = substr($wr_1 , 0, -1);
	$link_wr_ids = $_POST['link_wr_id'];
}else if($link_wr_id) $wr_1 = $link_wr_id;

//수정시 값리턴
if($wr_1){
	$link_wr_ids = explode('|',$wr_1);
}

//값 채크 및 담기
$cnt = 0;
foreach($link_wr_ids as $value){
	$link_list_arr[$cnt] = ch_list($value);
	$link_list_wrs[] = $link_list_arr[$cnt]['wr_id'];
	if($link_list_arr[$cnt]['wr_7'] == 1)alert('종료된 예약입니다.');
	ch_li($value,$link_list_arr[$cnt],$set_day);
	$ch_lt = ch_lt($link_list_arr[$cnt]['wr_id'],$set_day,$link_list_arr[$cnt]);
	if($ch_lt['rv-state'] == 'false')alert('예약이 마감되었습니다.');
	$cnt++;
}

ch_myrv($link_list_wrs, $set_day); //이미 신청한 예약인지 확인하는 함수

?>

<section id="bo_w">
    <h2 id="container_title"><?php echo $g5['title'] ?></h2>

    <form name="fwrite" id="fwrite" action="<?php echo $action_url ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="w" value="<?php echo $w ?>">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
	<input type="hidden" name="wr_1" value="<?php echo $wr_1?>" />
	<input type="hidden" name="wr_4" value="<?php echo $wr_4?>" />
	<input type="hidden" name="wr_2" value="<?php echo $wr_2?>" />
	<input type="hidden" name="wr_6" value="<?php echo $wr_6?>" />
	<input type="hidden" name="wr_content" value="예약"/>
	<input type="hidden" name="set_day" value="<?=$set_day?>"/>
	<input type="hidden" name="year" value="<?=$year?>"/>
	<input type="hidden" name="month" value="<?=$month?>"/>
	<input type="hidden" name="day" value="<?=$day?>"/>
	<input type="hidden" name="secret" value="secret">

    <?php

    $option = '';
    $option_hidden = '';
    if ($is_notice || $is_html || $is_secret || $is_mail) {
        $option = '';

        if ($is_secret) {
            if ($is_admin || $is_secret==1) {
                $option .= PHP_EOL.'<input type="checkbox" id="secret" name="secret" value="secret" '.$secret_checked.'>'.PHP_EOL.'<label for="secret">비밀글</label>';
            } else {
                $option_hidden .= '<input type="hidden" name="secret" value="secret">';
            }
        }

        if ($is_mail) {
            $option .= PHP_EOL.'<input type="checkbox" id="mail" name="mail" value="mail" '.$recv_email_checked.'>'.PHP_EOL.'<label for="mail">답변메일받기</label>';
        }
    }

    echo $option_hidden;
    ?>
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption><?php echo $g5['title'] ?></caption>
        <tbody>
		
		<?/*
        <?php if ($option) { ?>
        <tr>
            <th scope="row">옵션</th>
            <td><?php echo $option ?></td>
        </tr>
        <?php } ?>
		*/?>

        <?php if ($is_category) { ?>
        <tr>
            <th scope="row"><label for="ca_name">분류<strong class="sound_only">필수</strong></label></th>
            <td>
                <select class="form-control" style="width:120px; display: inline-table;" id="ca_name" name="ca_name" required>
                    <option value="">선택하세요</option>
                    <?php echo $category_option ?>
                </select>
            </td>
        </tr>
        <?php } ?>

		<tr class="sound_only">
            <th scope="row"><label for="wr_subject">작성자<strong class="sound_only">필수</strong></label></th>
            <td><input type="text" name="wr_subject" value="<?php echo $subject ? $subject : $member['mb_name'] ?>" id="wr_subject" required class="frm_input required" <?if($is_member)echo 'readonly'?>></td>
			<input type="hidden" name="wr_name" value="<?php echo $name ?>" id="wr_name"  class="frm_input " maxlength="20">
        </tr>

        <?php if ($is_name) { ?>
		<?/*
        <tr>
            <th scope="row"><label for="wr_name">이름<strong class="sound_only">필수</strong></label></th>
            <td></td>
        </tr>
		*/?>
        <?php } ?>

        <?php if ($is_password) { ?>
        <tr>
            <th scope="row"><label for="wr_password">비밀번호<strong class="sound_only">필수</strong></label></th>
            <td><input type="password" name="wr_password" id="wr_password" <?php echo $password_required ?> class="frm_input <?php echo $password_required ?>" maxlength="20">
			</td>
        </tr>
        <?php } ?>

        <?php if ($is_email) { ?>
        <tr>
            <th scope="row"><label for="wr_email">이메일</label></th>
            <td><input type="email" name="wr_email" value="<?php echo $email ?>" id="wr_email" class="frm_input email" maxlength="100"></td>
        </tr>
        <?php } ?>

		<?if(!$is_member){?>
			<th scope="row"><label for="wr_3">연락처<strong class="sound_only">필수</strong></label></th>
            <td><input type="text" name="wr_3" value="<?php echo $wr_3 ?>" id="wr_3" required class="frm_input required"></td>
		<?}?>

     
		<?if($board['bo_8'] == '1' && $wr_6){
				$peploe_arr = explode('|',$wr_6);  // 예약인원변수 
				$peploe_cnt = 0;
		}
		?>
	
		<?	
			foreach($link_list_arr as $value){
		?>
			<tr class="U_tr01">
				<td colspan="2">
					<table class="U_table01">
						<tr>
							<td>예약시간</td>
							<td><?=$value['wr_subject']?></td>
						</tr>
						<tr>
							<td>예약일</td>
							<td><?=$set_day?></td>
						</tr>
						
						<tr>
							<td><label for="wr_name">예약자</label></td>
							<td><input type="text" value="<? echo $wr_name ? $wr_name : $member['wr_name'] ?>" class="U_input01 required" name="wr_name" id="wr_name"/></td>
						</tr>

						<tr>
							<td><label for="wr_3">연락처</label></td>
							<td><input type="text" value="<? echo $wr_3 ? $wr_3 : $member['mb_hp'] ?>" class="U_input01 required" name="wr_3" id="wr_3"/></td>
						</tr>

						<?if($value['wr_6']){?>
						<tr>
							<td>예약시간</td>
							<td><?=$value['wr_6']?></td>
						</tr>
						<?}?>

						<?if($value['wr_content'] !== '부가설명이 있을경우 입력해주세요'){?>
						<tr>
							<td>예약정보</td>
							<td><?=get_view_thumbnail($value['wr_content'])?></td>
						</tr>
						<?}?>

						<?if($board['bo_7'] == '1' && $value['wr_9'] ){?>
						<tr>
							<td>가격</td>
							<td><? echo display_price($value['wr_9'],0);
									$price_arr[] = 	$value['wr_9'];
						?></td>
						</tr>
						<?}?>

						<?if($board['bo_8'] == '1' ){?>
						<tr>
							<td>예약인원</td>
							<td>
								<input type="text" name="peoples" data-max="<?= $value['wr_10'] ?  $value['wr_10'] : 1?>" class="U_input01" value ="<?=$peploe_arr['wr_10'] ? $peploe_arr[$peploe_cnt] : '1'?>" <?=$value['wr_10'] ? '' : 'readonly'?> />
								/
								<?	
									echo $value['wr_10'] ?  $value['wr_10'] : 1 ;
									$peploe_cnt ++;
								?>
							</td>
						</tr>
						<?}else{?>
						<tr class="sound_only">
							<td>예약인원</td>
							<td>
								<input type="hidden" name="peoples" data-max="<?= $value['wr_10'] ?  $value['wr_10'] : 1?>" value='1' />
							</td>
						</tr>
						<?}?>

						<?
							if($value['wr_13'] !== '' && $value['wr_11'] == 1){
								$wr_13 = $value['wr_13'];
								$wr_13_oj = json_decode($wr_13, true);
								$wr_13_arr =  (array) $wr_13_oj;
						?>
						<tr>
							<td>옵션</td>
							<td>
								<ul class="U_op_wrap" id="J_op_data">
									<?
										for($i=0;$i < count($wr_13_arr['opName']);$i++){
											$setNum = $i+1;	
											echo $wr_13_arr['use'][$i];
											if($wr_13_arr['use'][$i] !== 0){
									?>
									<li class="U_input02_wrap">
										<div class="wr_13_tit">
											<span class="wr_13_delect">#<?=$setNum?> 옵션 </span>
											<input type="radio" value="1" name="wr_13_use<?=$setNum?>" <?=$wr_13_arr['use'][$i] !== 0 ? "checked" : ''?> class="wr_13_use" id="wr_13_use<?=$setNum?>_1"/>
											<label for="wr_13_use<?=$setNum?>_1">활성</label>
											<input type="radio" value="0" name="wr_13_use<?=$setNum?>" <?=$wr_13_arr['use'][$i] == 0 ? "checked" : ''?> class="wr_13_use" id="wr_13_use<?=$setNum?>_0" />
											<label for="wr_13_use<?=$setNum?>_0">비활성</label>
										</div>
										<div class="U_input02_box">
											<label for="wr_13_name<?=$setNum?>">옵션명</label>
											<input name="wr_13_name<?=$setNum?>" id="wr_13_name<?=$setNum?>" value="<?=$wr_13_arr['opName'][$i];?>" type="text" class="U_input02 wr_13_name"/>
										</div>
										<div class="U_input02_box">
											<label for="wr_13_price<?=$setNum?>">가격</label>
											<input name="wr_13_price<?=$setNum?>" id="wr_13_price<?=$setNum?>" value="<?=$wr_13_arr['opPrice'][$i];?>" type="number" class="U_input02 wr_13_price" min="0"  />
										</div>
										<div class="U_input02_box">
											<label for="wr_13_num<?=$setNum?>">수량</label>
											<input name="wr_13_num<?=$setNum?>" id="wr_13_num<?=$setNum?>"  value="<?=$wr_13_arr['opNum'][$i];?>" type="number" class="U_input02 wr_13_num" min="0" />
										</div>
									</li>
									<?} }?>
								</ul>
							</td>
						</tr>
						<?}?>
					</table>
				</td>
			</tr>
		<?}?>

		<?if($board['bo_7'] == '1' && count($price_arr) > 0 ){?>
			<tr class="U_tr01">
				<td colspan="2">
					<table class="U_table01">
						<tr>
							<td>총합 가격</td>
							<?for($i = 0; $i < count($price_arr);$i++){
								$total_price += $price_arr[$i];
							?>
							<?}?>
							<td>	
								<?=display_price($total_price)?>
								<input type="hidden" value="<?=$wr_5 ? $wr_5 : $total_price?>"/>							
							</td>
						</tr>
					</table>
				</td>
			</tr>
		<?}?>
	
		<?/*
        <tr>
            <th scope="row"><label for="wr_content">내용<strong class="sound_only">필수</strong></label></th>
            <td class="wr_content">
                <?php if($write_min || $write_max) { ?>
                <!-- 최소/최대 글자 수 사용 시 -->
                <p id="char_count_desc">이 게시판은 최소 <strong><?php echo $write_min; ?></strong>글자 이상, 최대 <strong><?php echo $write_max; ?></strong>글자 이하까지 글을 쓰실 수 있습니다.</p>
                <?php } ?>
                <?php echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?>
                <?php if($write_min || $write_max) { ?>
                <!-- 최소/최대 글자 수 사용 시 -->
                <div id="char_count_wrap"><span id="char_count"></span>글자</div>
                <?php } ?>
            </td>
        </tr>
		*/?>
		
		<?/*
        <?php for ($i=1; $is_link && $i<=G5_LINK_COUNT; $i++) { ?>
        <tr>
            <th scope="row"><label for="wr_link<?php echo $i ?>">링크 #<?php echo $i ?></label></th>
            <td><input type="url" name="wr_link<?php echo $i ?>" value="<?php if($w=="u"){echo$write['wr_link'.$i];} ?>" id="wr_link<?php echo $i ?>" class="frm_input wr_link"></td>
        </tr>
        <?php } ?>

        <?php for ($i=0; $is_file && $i<$file_count; $i++) { ?>
        <tr>
            <th scope="row">파일 #<?php echo $i+1 ?></th>
            <td>
                <div class="file_box">
                    <input type="text" class="file_name frm_input">
                    <a href="javascript:" class="file_btn">파일첨부</a>
                    <input type="file" name="bf_file[]" title="파일첨부 <?php echo $i+1 ?> :  용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능" class="frm_file frm_input">
                </div>
                <?php if ($is_file_content) { ?>
                <input type="text" name="bf_content[]" value="<?php echo ($w == 'u') ? $file[$i]['bf_content'] : ''; ?>" title="파일 설명을 입력해주세요." class="frm_file frm_input">
                <?php } ?>
                <?php if($w == 'u' && $file[$i]['file']) { ?>
                <input type="checkbox" id="bf_file_del<?php echo $i ?>" name="bf_file_del[<?php echo $i; ?>]" value="1"> <label for="bf_file_del<?php echo $i ?>"><?php echo $file[$i]['source'].'('.$file[$i]['size'].')'; ?> 파일 삭제</label>
                <?php } ?>
            </td>
        </tr>
        <script>
            $('input[type=file]').change(function(){
                $(this).siblings('.file_name').val($(this).val());
            });
        </script>
        <?php } ?>
		*/?>

        <?php if ($is_guest) { //자동등록방지 ?>
        <tr>
            <th scope="row">자동등록방지</th>
            <td>
                <?php echo $captcha_html ?>
            </td>
        </tr>
        <?php } ?>
		
        </tbody>
        </table>
    </div>

    <div class="btn_confirm">
        <input type="submit" value="신청하기" id="btn_submit" class="btn_submit" accesskey="s">
        <a href="./board.php?bo_table=<?php echo $bo_table ?>" class="btn_cancel">취소</a>
    </div>
    </form>
</section>

<script>
<?php if($write_min || $write_max) { ?>
// 글자수 제한
var char_min = parseInt(<?php echo $write_min; ?>); // 최소
var char_max = parseInt(<?php echo $write_max; ?>); // 최대
check_byte("wr_content", "char_count");

$(function() {
    $("#wr_content").on("keyup", function() {
        check_byte("wr_content", "char_count");
    });
});

<?php } ?>
function html_auto_br(obj)
{
    if (obj.checked) {
        result = confirm("자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을<br>태그로 변환하는 기능입니다.");
        if (result)
            obj.value = "html2";
        else
            obj.value = "html1";
    }
    else
        obj.value = "";
}

function fwrite_submit(f)
{
	f.wr_name.value = f.wr_subject.value;
	f.wr_3.value = f.wr_3.value.replace(/[^0-9]/g,"");

	wr_6_value = '';
	if(f.peoples){
		var wr_6_cnt = 0;
	
		for(var i =0 ; i < f.peoples.length;i++){
			var num_check=/^[0-9,-]*$/;
			if (!num_check.test(f.peoples[i].value)){
				alert('숫자만 입력해주세요');
				return false;
			}
			if(f.peoples[i].value > f.peoples[i].getAttribute('data-max')){
				alert('제한된 수보다 큰값을 입력할수 없습니다.');
				return false;
			}
			if(f.peoples[i].value < 1){
				alert('수는 1이상 입력 하셔야 합니다.');
				return false;
			}
			wr_6_value += f.peoples[i].value+'|';
			wr_6_cnt++;
		}

		if(wr_6_cnt == 0){
			var num_check=/^[0-9,-]*$/;
			if (!num_check.test(f.peoples.value)){
				alert('숫자만 입력해주세요');
				return false;
			}
			if(Number(f.peoples.value) > Number(f.peoples.getAttribute('data-max'))){
				alert('제한된 수보다 큰값을 입력할수 없습니다.');
				return false;
			}
			if(f.peoples.value < 1){
				alert('수는 1이상 입력 하셔야 합니다.');
				return false;
			}
			f.wr_6.value = f.peoples.value;
		}else{
			f.wr_6.value = wr_6_value.slice(0,-1);
		}
	}

	
    <?php echo $editor_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함   ?>

    var subject = "";
    var content = "";
    $.ajax({
        url: g5_bbs_url+"/ajax.filter.php",
        type: "POST",
        data: {
            "subject": f.wr_subject.value,
            "content": f.wr_content.value
        },
        dataType: "json",
        async: false,
        cache: false,
        success: function(data, textStatus) {
            subject = data.subject;
            content = data.content;
        }
    });

    if (subject) {
        alert("제목에 금지단어('"+subject+"')가 포함되어있습니다");
        f.wr_subject.focus();
        return false;
    }

    if (content) {
        alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
        if (typeof(ed_wr_content) != "undefined")
            ed_wr_content.returnFalse();
        else
            f.wr_content.focus();
        return false;
    }
	

	if (document.getElementById("char_count")) {
        if (char_min > 0 || char_max > 0) {
            var cnt = parseInt(check_byte("wr_content", "char_count"));
            if (char_min > 0 && char_min > cnt) {
                alert("내용은 "+char_min+"글자 이상 쓰셔야 합니다.");
                return false;
            }
            else if (char_max > 0 && char_max < cnt) {
                alert("내용은 "+char_max+"글자 이하로 쓰셔야 합니다.");
                return false;
            }
        }
    }

    <?php echo $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  ?>

    document.getElementById("btn_submit").disabled = "disabled";

    return true;
}
</script>
