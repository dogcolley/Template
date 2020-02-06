<?
	include("../common.php");
	$g5['title'] = '관리자 로그인';
	include_once ('../head.sub.php');

	$url = $_GET['url'];

	// url 체크
	check_url_host($url);

	// 이미 로그인 중이라면
	if ($is_member) {
		if ($url)
			goto_url($url);
		else
			goto_url(G5_URL);
	}

	$login_url        = login_url($url);
	$login_action_url = G5_HTTPS_BBS_URL."/login_check.php";
?>
<style>
.m_login_wrap{width:600px;margin:0 auto;margin-top:150px;text-align:center;}

.m_login_wrap > h2{font-weight:bold;color:#535353;font-size:22px;letter-spacing:-0.5px}
.m_login_wrap > p{margin-top:15px;line-height:160%;color:#535353;}

.input1{margin-top:20px;}
.input2{width:448px;border:1px solid #d2d2d2;height:48px;line-height:48px;padding-left:10px;font-size:14px}

.m_login_wrap > .line{width:460px;border-top:1px solid #e4e4e5;height:1px;margin:0 auto;}
</style>
<script type="text/javascript">
$(function(){
	$("body").css("width","100%").css("height","100%").css("background","#fafafa");
	$(".input_id").val("아이디").css("color","#999999").one("focus",function(){
		$(this).val("").css("color","#000");
	});
	$(".input_pw").val("비밀번호").css("color","#999999").one("focus",function(){
		$(this).val("").css("color","#000");
	});	
});
</script>
<form name="flogin" action="<?php echo $login_action_url ?>" onsubmit="return flogin_submit(this);" method="post">
<input type="hidden" name="url" value="<?php echo $login_url ?>">
	<div class="m_login_wrap">
		<h2><img src="/skin/member/admin/img/login_tilte.png" alt="홈페이지 관리자 전용 페이지입니다."></h2>
		<p>홈페이지 직접 관리가 가능한 관리자 전용페이지로,<br>게시글 관리에 주의를 요합니다.</p>
		<div class="input1">
			<p><input type="text" name="mb_id" itemname="아이디" required minlength="2" class="input2 input_id required" value=""></p>
			<p style="margin-top:10px;"><input type="password" name="mb_password" id="login_mb_password" itemname="패스워드" required class="input2 input_pw required"></p>
			<p style="margin-top:10px;"><input type="image" src="/skin/member/admin/img/login_btn.gif" style="460px;"></p>
		</div>
		<p style="height:10px;"></p>
		<p class="line"></p>
		<p style="margin-top:20px;">본 페이지는 홈페이지 관리를 위한 공간입니다..<br><strong>관계자외에는 접근을 금지합니다.</strong></p>
	</div>
</form>
<script type="text/javascript">
	function flogin_submit(f)
	{
		return true;
	}
</script>
<!-- } 로그인 끝 -->

<?php
include_once ('../tail.sub.php');
?>