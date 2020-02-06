<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<script type="text/javascript" src="<?=$g4[path]?>/js/capslock.js"></script>
<style>
.m_login_wrap{width:600px;margin:0 auto;margin-top:150px;text-align:center;}

.m_login_wrap > h2{font-weight:bold;color:#535353;font-size:22px;letter-spacing:-0.5px}
.m_login_wrap > p{margin-top:15px;line-height:160%;color:#535353;}

.input1{margin-top:20px;}
.input2{width:448px;border:1px solid #d2d2d2;height:48px;line-height:48px;padding-left:10px;font-size:14px}

.m_login_wrap > .line{width:460px;border-top:1px solid #e4e4e5;height:1px;margin:0 auto;}
</style>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script type="text/javascript">
$(function(){
	$(".input_id").val("아이디").css("color","#999999").one("focus",function(){
		$(this).val("").css("color","#000");
	});
	
});
$(function(){
	$(".input_pw").val("비밀번호").css("color","#999999").one("focus",function(){
		$(this).val("").css("color","#000");
	});
	
});
</script>
<form name="flogin" action="<?php echo $login_action_url ?>" onsubmit="return flogin_submit(this);" method="post">
<body style="width:100%;background:#fafafa;height:100%">
	<div class="m_login_wrap">
		<h2><img src="/skin/member/admin/img/login_tilte.png" alt="홈페이지 관리자 전용 페이지입니다."></h2>
		<p>홈페이지 직접 관리가 가능한 관리자 전용페이지로, <br>게시글 관리에 주의를 요합니다.</p>

		<div class="input1">
			<p><input type="text"  name=mb_id itemname="아이디" required minlength="2"  class="input2 input_id" value=''></p>


			<p style="margin-top:10px"><input type=password  name=mb_password id="login_mb_password" itemname="패스워드"  required onkeypress="check_capslock(event, 'login_mb_password');" class="input2 input_pw"></p>

			<p style="margin-top:10px"><input type="image" src="/skin/member/admin/img/login_btn.gif" style="width:460px;"></p>
		</div>

		<p style="height:10px"></p>
		<p class="line"></p>

		<p style="margin-top:20px;">본 페이지는 홈페이지 관리를 위한 공간입니다..<br>
		<strong>관계자외에는 접근을 금지합니다.</strong></p>
	</div>
</body>
</form>

<script type='text/javascript'>

	//로그인 박스 클릭시 아이디,비번 사라지게함
	$('.login_input').click(function(){
		var idx_val = $(this).val();
		$(this).val('');
		$(this).mouseleave(function(){
			if($(this).val()=='')
				$(this).val(idx_val);
		});
	});
	$('.login_input').focus(function(){
		var idx_val = $(this).val();
		$(this).val('');
		$(this).mouseleave(function(){
			if($(this).val()=='')
				$(this).val(idx_val);
		});
	});
	$('.login_input').change(function(){
		$(this).css('color', '#ddd');
	});

	function window_login_box_position(){
		var admin_margin_top = ($(window).height()-$('#admin_login_box').height())/2;
		$('#admin_login_box').css('top', admin_margin_top); 
	}
	$(window).resize(function(){
		window_login_box_position();
	});
	$(window).load(function(){
		window_login_box_position();
	});

	function flogin_submit(f)
	{
		return true;
	}

</script>
<!-- } 로그인 끝 -->