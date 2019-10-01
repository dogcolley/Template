/* 
	use extend type 
	: sumsing of 2 over object, 
	fn.extend 
	: make plugin
    
    var : 2019-09-20
    maker : jsh
*/

$.fn.extend({
	onepage: function(options){
		var defaults = {
			mode: 'mode1',
			nav:true,
			btn:true,
			speed: 400,
			foot:false,
		}

		opts = $.extend(defaults,options)

		var set = $(this),
		set_lg = set.find('.paper').length,
		set_ct = 1,
		set_pg_tag = new Array,
		set_action = 'next',
		set_keyset = undefined,
		set_toggle = true,
		set_touch_start,
		set_touch_end,
		set_touch_sum,
		set_foot_mode = false;

		for(var i = 0; i < set_lg; i++){
			set_pg_tag[i] = set.find('.paper').eq(i);
		}

		if(opts.nav){
			var make_tag = '<div class="onpage_btn side_btn">';
			make_tag += '<button type="button" class="onpage_pv">이전</button>';
			make_tag += '<button type="button" class="onpage_nt">다음</button>';
			make_tag += '</div>';
			set.after(make_tag);
			$('.onpage_btn button').on('click',function(){
				if($(this).hasClass("onpage_nt")) set_action = 'next';
				if($(this).hasClass("onpage_pv")) set_action = 'prev';
				if(opts.mode=='mode1')Move_page(set_action,opts.speed,set_lg);
			});
		}

		if(opts.nav){
			var make_tag = '<ul class="onpage_nav side_nav">';
			for(var i = 0; i < set_lg; i++){
				make_tag += '<li><a href="#">'+set_pg_tag[i].find('.paper_tit').text()+'</a></li>'
			}
			make_tag += '</ul>';
			set.after(make_tag);
			$('.onpage_nav a').on('click',function(){
				var btn_nums = $(this).parent().index()+1;
				if(btn_nums == set_ct) return false;
				Move_page2(set_action,opts.speed,set_lg,btn_nums-1);
				set_ct = btn_nums;
				return false;
			});
		}

		set.addClass(opts.mode);

		$(window).on('mousewheel DOMMouseScroll keydown', function (e) {
			var Event = e.type; // event type
			var E = e.originalEvent.wheelDelta || e.originalEvent.detail * -1; // scroll number
			var E2 = e.keyCode; // key dow code
			if(E2 !== undefined) set_keyset = E2;
			if(opts.mode =='mode1' && (E <0 || E2 == 40 )) set_action = 'next';
			if(opts.mode =='mode1' && (E >0 || E2 == 38 )) set_action = 'prev';
			if(opts.foot){if(Move_foot(set_action,opts.speed,set_lg) == true)set_foot_mode=true}
			if(opts.mode=='mode1' && !set_foot_mode)Move_page(set_action,opts.speed,set_lg);
			if(opts.foot){if(Move_foot(set_action,opts.speed,set_lg) == false)set_foot_mode=false}
		});

		$(window).on('touchstart', function (e) {
			var event = e.originalEvent;
			set_touch_start = event.changedTouches[0].pageY;
		});

		$(window).on('touchend', function (e) {
			var event = e.originalEvent;
			set_touch_end = event.changedTouches[0].pageY;
			set_touch_sum = set_touch_start - set_touch_end;
			if(opts.mode =='mode1' && ( set_touch_sum > 100 )){}set_action = 'next';
			if(opts.mode =='mode1' && ( set_touch_sum < -100 )) set_action = 'prev';
			if(opts.foot){if(Move_foot(set_action,opts.speed,set_lg) == true)set_foot_mode=true}
			if(opts.mode=='mode1' && !set_foot_mode && ( set_touch_sum > 100 || set_touch_sum < -100 ))Move_page(set_action,opts.speed,set_lg);
			if(opts.foot){if(Move_foot(set_action,opts.speed,set_lg) == false)set_foot_mode=false}
		});

		if(opts.mode=='mode1'){
		}

		if(opts.mode=='mode2'){
		}

		function Move_page(m_action,m_speed,m_limit){
			if(set_toggle){
				set_toggle = false;
				if(m_action == 'next' && set_ct < m_limit)set.animate({top: -(set_ct*100)+'%'},m_speed,function(){set_ct++;set_toggle=true});
				else if(m_action == 'prev' && set_ct > 1){set_ct--;set.animate({top: -((set_ct-1)*100)+'%'},m_speed,function(){set_toggle=true})}
				else set_toggle = true;
			}
		}

		function Move_page2(m_action,m_speed,m_limit,move_set){
			if(set_toggle){
				set.animate({top: -(move_set*100)+'%'},m_speed,function(){set_toggle=true});
			}
		}

		function Move_foot(m_action,m_speed,m_limit){
			var $footer = $('.one_foot');
			var f_h = ($footer.height() / $(window).height()) * 100;
			f_h =  -((m_limit-1)*100 + f_h)+'%';
			if(set_toggle && m_limit == set_ct && !set_foot_mode && set_action == 'next'){
				set.animate({top:f_h},m_speed,function(){set_toggle=true});
				return true;
			}else if(set_toggle && m_limit == set_ct && set_foot_mode && set_action == 'prev'){
				set.animate({top:-((m_limit-1)*100)+'%'},m_speed,function(){set_toggle=true});
				return false;
			}
		}
	}
});

$.fn.extend({
	/* slider : 호완, 모드, 상태 올클 */
	j_slider : function(options){
		var defaults = {
			mode: 'slider', //mode = slider, fade, m3d,  
			nav:true,
			btn:true,
			speed: 400,
			loop:true,
			auto:false,
			autoT:3000, 
			autoS:1000,
			view:1,
			css:true,
			Indc:true
		}
		opts = $.extend(defaults,options)

		var set = $(this),
		set_container = $(this).find('.j_container'),
		set_lg = set.find('.j_content').length,
		set_ct = 1,
		set_pg_tag = new Array,
		set_move = 'next',
		set_keyset = undefined,
		set_toggle = true,
		set_touch_start,
		set_touch_end,
		set_touch_sum,
		set_stock = 0,
		set_stock2 = 0,
		set_action = true,
		set_ct_stack=0,
		set_loop_mode = false,
		set_show_wd = (set_lg+(opts.view*2)) / opts.view,
		set_show_wd2 = 100  / (set_lg+(opts.view*2)),
		set_show_wd3 = 100  / (set_lg),
		nums_ctMax = Math.ceil(set_lg / opts.view),
		nums_ct = 1;
		
		/*root check*/
		if( set_lg <= opts.view ) opts.loop = false;
		if( set_lg <= opts.view ) set_action = false;
		
	
		/*setting css*/
		if(set_action){
			set.css({position:'relative',overflow:'hidden'})
			set_container.css({left:'-100%',position:'relative',width:set_show_wd*100+'%'})
			set_container.find('.j_content').css({float:'left',width: set_show_wd2+'%'})
		}else{
			set_container.find('.j_content').css({float:'left',width: set_show_wd3+'%'})
		}

		/* odd style */
		if(set_lg % opts.view !==0){
			var make_num = opts.view - (set_lg % opts.view);
			for(var i = 0; i < make_num; i++){
				var make_tag = set_container.find('.j_content').last().clone();
				set_container.append(make_tag);
				set_container.find('.j_content').last().css('min-height','1px')
				set_container.find('.j_content').last().children().remove();
			}
		}		

		/*setting pv, df*/
		if(set_action){
			for(var i = 0; i < opts.view; i++){
				var ft_tg = set_container.find('.j_content').eq(-(i+1)).clone();
				set_container.prepend(ft_tg);
			}
		}

		/* setting btn */
		if(set_action){
			var make_btn = '<ul class="j_btns">';
			if(opts.btn)make_btn += '<li><button type="button" class="j_pv">이전</button></li>';
			if(opts.btn)make_btn += '<li><button type="button" class="j_nt">다음</button></li>';
			if(opts.auto)make_btn += '<li><button type="button" class="j_auto on"><span>자동재생</span></button></li>';
			if(opts.auto)make_btn += '<li><button type="button" class="j_stop"><span>자동재생정지</span></button></li>';
			make_btn += '</ul>';
			set.append(make_btn);
		}

		set.find('.j_pv').on('click',function(){
			j_pvcc(opts.speed);
			if(opts.auto){
				clearInterval(auto_fn);
				set_loop_mode = false;
				set.find('.j_auto').removeClass('on');
				$('.j_stop').addClass('on');
			}
		});

		set.find('.j_nt').on('click',function(){
			j_nt_cc(opts.speed);
			if(opts.auto){
				clearInterval(auto_fn);
				set_loop_mode = false;
				set.find('.j_auto').removeClass('on');
				$('.j_stop').addClass('on');
			}
		});
			
		/*setting indc*/
		if(opts.Indc && set_action){
			var make_Indc = '<ul class="j_indcs">';
			for(var i=0; i < set_lg; i ++){
				if(i == 0 )make_Indc += '<li class="on"><button type="button" class="indc_btn">'+(i+1)+'</button></li>';
				else make_Indc += '<li><button type="button" class="indc_btn">'+(i+1)+'</button></li>';
			}
			make_btn += '</ul>';
			set.append(make_Indc);
		}

		/*event */
		$(set).on('touchstart', function (e) {
			var event = e.originalEvent;
			set_touch_start = event.changedTouches[0].pageX;
		});

		$(set).on('touchend', function (e) {
			var event = e.originalEvent;
			set_touch_end = event.changedTouches[0].pageX;
			set_touch_sum = set_touch_start - set_touch_end;
			if(set_touch_sum > 100 )  j_nt_cc(opts.speed);
			if(set_touch_sum < -100 ) j_pvcc(opts.speed);
		});

		/* control CC */
		function j_nt_cc(cc_speed){
			set_move ='next';
			in_num_ct('add');
			if(set_ct < Math.ceil(set_lg/opts.view)-1 && set_stock <= 0){
				set_ct++;
				move(set_ct,cc_speed);
			}else if(set_stock > 0){
				apen_to2(cc_speed , set_stock);
				set_stock --;
			}else{
				prepe_top(cc_speed);
				set_stock2++;
			}
		}

		function j_pvcc(cc_speed){
			set_move ='prev';
			in_num_ct('mis');
			if( set_ct <=1){
				apen_to(cc_speed);
				set_stock ++;
			}
			else if(set_stock2 > 0){
				prepe_top2(cc_speed , set_stock2);
				set_stock2--;
			}else{
				set_ct--;
				move(set_ct,cc_speed);
			 }
		};

		function in_num_ct(in_mode){
			if(in_mode == 'add'){
				if(nums_ct<nums_ctMax)nums_ct++;
				else nums_ct = 1;
			}else if(in_mode=='mis'){
				if(nums_ct > 1)nums_ct--;
				else nums_ct = nums_ctMax;;
			}
			set.find('.j_indcs li').removeClass('on');
			set.find('.j_indcs li').eq(nums_ct-1).addClass('on');
		}

		/*action function*/
		function move(move_action,move_speed){
			if(set_toggle){
				set_toggle = false;
				set_container.animate({left:-(move_action*100)+'%'},move_speed,function(){
					set_toggle = true;
				});
			}
		}
		function apen_to(move_speed){
			if(set_toggle){
				set_toggle = false;
				set_container.animate({left:0},move_speed,function(){
					for(var i =0 ; i < opts.view ; i++){
						set_container.prepend(set_container.find('.j_content').eq(-(1+opts.view)));
					}
					set_container.css({left:'-100%'});
					set_toggle = true;
				});
			}
		}

		function apen_to2(move_speed, move_num){
			if(set_toggle){
				set_toggle = false;
				set_container.animate({left:'-200%'},move_speed,function(){
					for(var i =0 ; i < opts.view ; i++){
						//set_container.find('.j_content').eq(-opts.view).insertBefore(set_container.find('.j_content').eq(0));
						set_container.find('.j_content').eq(0).insertBefore(set_container.find('.j_content').eq(-opts.view));
					}
					set_container.css({left:'-100%'});
					set_toggle = true;
				});
			}
		}

		function prepe_top(move_speed){
			if(set_toggle){
				set_toggle = false;
				set_container.animate({left:-((set_ct+1)*100)+'%'},move_speed,function(){
					for(var i =0 ; i < opts.view ; i++){
						set_container.append(set_container.find('.j_content').eq(opts.view));
					}
					set_container.css({left:-((set_ct)*100)+'%'});
					set_toggle = true;
					});
			}
		}

		function prepe_top2(move_speed, move_num){
			if(set_toggle){
				set_toggle = false;
				set_container.animate({left:-((set_ct-1)*100)+'%'},move_speed,function(){
					for(var i =0 ; i < opts.view ; i++){
						set_container.find('.j_content').last().insertAfter(set_container.find('.j_content').eq(opts.view-1));
					}
					set_container.css({left: -(set_ct*100)+'%'});
					set_toggle = true;
					});
			}
		}

		/* Auto mode */
		if(opts.auto){
			set_loop_mode = true;

			var auto_fn = setInterval(function(){
				j_nt_cc(opts.autoS);
			},opts.autoT);

			set.find('.j_stop').on('click',function(){
				clearInterval(auto_fn);
				set_loop_mode = false;
				set.find('.j_auto').removeClass('on');
				$(this).addClass('on');
			});

			set.find('.j_auto').on('click',function(){
				set.find('.j_stop').removeClass('on');
				$(this).addClass('on');
				if(!set_loop_mode){
					auto_fn = setInterval(function(){
						j_nt_cc(opts.autoS);
					},opts.autoT);
					set_loop_mode = true;
				}
			});
		}

		set.on('mouseleave',function(){
			//console.log('test');
			if(opts.auto && !set.find('.j_auto').hasClass('on')){
				set.find('.j_auto').trigger('click');
			}
		});
		
		/* test filed*/
		set.find('button').click(function(){
		});
	}
});

$.fn.extend({
	nav : function(options){
	
	
	}
})

$.fn.extend({
	j_tab : function(options){
		var defaults = {
			// IC , CC
		}
		opts = $.extend(defaults,options)
		
		var set = $(this);

		set.find('.J_tab_btn li a').on('click', function(){
			$(this).parent().addClass('on').siblings().removeClass('on');
			var num = $(this).parent().index();
			set.find('.J_tab_con').find(' > li').eq(num).addClass('on').siblings().removeClass('on');
			return false;
		});
		/* IC mode */

		/* CC mode */
	}
});

$.fn.extend({
	hf_on : function(options){
		var defaults = {
		hf_out:true,
		hf_ch:true,
		}
		opts = $.extend(defaults,options)
		var set = $(this);
		
		set.on('mouseenter focusin',function(){
			set.addClass('hf_on');
		});

		set.find('a , button').on('mouseenter focusin',function(){
			if(opts.hf_ch){
				$(this).addClass('hf_on');
			}
		});
		

		set.on('mouseleave focusout',function(){
			set.removeClass('hf_on');
			//if(pots.hf_ch)set.children().addClass('hf_on');
		});

		set.find('a , button').on('mouseleave focusout',function(){
			if(opts.hf_ch){
				$(this).removeClass('hf_on');
			}
		});
	}
});


$.fn.extend({
	ch_vl : function(options){
		var defaults = {
			mode : 'IC' // IC , CC
		}
		opts = $.extend(defaults,options)
		
		var set = $(this);

		set_toggle = false;
		set.on('submit',function(){

			//set_toggle = true;
			$(this).find('input').each(function(){

				if($(this).hasClass() == 'ch_rq' && $(this).val() == ''){
					alert('값을 입력해주세요');
					setTimeout(function(){set.focus()},50);
				}
			});

			return false;
		});

		/* IC mode */

		/* CC mode */
	}
});


$.fn.extend({
	ch_item : function(options){
		var defaults = {
			mode : 'null' // IC , CC
		}
		opts = $.extend(defaults,options)
		
		var set = $(this),
        set_val = $(this).val(),
        setExp;
        /* null mode */
        if(opts.mode == 'null'){
            set_val =  /\s/g;
            
        }    
		/* phone mode */
        if(opts.mode == 'null'){
            set_val =  /^\d{3}-\d{3,4}-\d{4}$/;;
            
        }   
        
        /* address mode */
        if(opts.mode == 'null'){
            set_val =  /\s/g;
            
        }        
        
        /* pw mode */
        if(opts.mode == 'null'){
            set_val =  /^[a-z0-9_]{4,20}$/;
            
        }      
         
        /* ajax ckeck mode mode */
        
        
	}
});

$.fn.extend({
	mk_tem_tag : function(options){
	var defaults = {
		TH_Num : '01', //
		TH_F : 'on',
		TH_H : 'on',
		TH_F_txt : 'TH_F_txt에 내용을 입력해주세요',
		TH_H_txt : 'TH_F_txt에 내용을 입력해주세요'
	}
	opts = $.extend(defaults,options)
	
	var set = $(this);
		
	return false;
    }
});


$(function(){
	var shifton = false;
    var win_touch_start = 0;
    var win_touch_end = 0;
    var win_touch_sum = 0;

    function keyControl() {
		$(window).on({
			keyup: function (e) {
				if (e.keyCode == 16) shifton = false
			},
			keydown: function (e) {
				if (e.keyCode == 16) shifton = true
			}
		});
	}
    keyControl();

    
    //win key cuntrol funtion
    
	/* use code scroll and keydow event
	$(window).on('mousewheel DOMMouseScroll keydown', function (e) {
        var Event = e.type; // event type
        var E = e.originalEvent.wheelDelta || e.originalEvent.detail * -1; // scroll number
        var E2 = e.keyCode; // key dow code
	});
	*/
	
	/* use tuch event basic
	$(window).on('touchstart', function (e) {
        var event = e.originalEvent;
        win_touch_start = event.changedTouches[0].pageY;
		console.log('tocuh start');
    });

	$(window).on('touchend', function (e) {
        var event = e.originalEvent;
        win_touch_end = event.changedTouches[0].pageY;
        win_touch_sum = win_touch_start - win_touch_end;
		console.log('tocuh end',win_touch_sum);
    });
	*/
    
    /*header gnb*/
    $('#U_gnb > li > a').on('mouseenter focusin',function(){
        if(!shifton){
            $(this).parent().addClass('on'); 
            $(this).siblings('ul').stop().slideDown(500);    
        }
    });
    
    $('#U_gnb > li').find('ul li:last a').on('focusout',function(){
       if(!shifton){         $(this).parents('li').parents('li').removeClass('on').find('ul').stop().hide();  
       } 
    });
    $('#U_gnb > li > a').on('focusout',function(){
        if(shifton){
            $(this).parent().removeClass('on'); 
            $(this).siblings('ul').stop().hide();
        }
    });
    
    $('#U_gnb > li').on('mouseleave',function(){
        $(this).removeClass('on'); 
        $(this).find('ul').stop().hide();
    });
	
    /*header and sdSnb scroll event*/
    var sd_tg = $('#U_sd_nav').offset().top;
    $(window).on('scroll',function(){
        var hd_tg = $('#U_header').innerHeight();
        var win_sc = $(this).scrollTop();
        if(win_sc > hd_tg){
            $('#U_header > div').addClass('hd_fx');
        }else{
            $('.hd_fx').removeClass();
        }
        if(win_sc > sd_tg){
            $('#U_sd_nav').addClass('on');
        }else{
            $('#U_sd_nav').removeClass('on');
        }
        //fade event 
        $('.fadeIn').each(function(){
           var $fadeIn = $(this);
           var fadeOn = $(this).offset().top - ($(this).innerHeight() / 2);
            console.log(fadeOn , win_sc);

            if(win_sc > fadeOn){
                $fadeIn.addClass('on');
            }
        });
    });
    
    /* snb */
    if(!index){
        $('#U_snb').find('.dep1 button').text(dep1_name);
        $('#U_snb').find('.dep2 button').text(dep2_name);

        $('#U_snb').find('.dep1 ul li a').each(function(){
            if($(this).text() == dep1_name)$(this).addClass('on');  
        });

        $('#U_snb').find('.dep2 ul li a').each(function(){
            if($(this).text() == dep2_name)$(this).addClass('on');  
        });

        $('#U_snb button').on('click',function(){
           $(this).siblings('ul').toggle() 
        });

        $('#U_snb div div').on('mouseleave',function(){
           $(this).find('ul').hide(); 
        });
    }

    /*top_btn*/
    $('#Top_btn').on('click',function(){
       $('body , html').animate({scrollTop:0},500);
        return false;
    });
    
    /*tab*/
    $('.J_tab_wrap').j_tab();
    
    
    /*main J_slider*/
    $('#cnt1').j_slider({
            mode: 'slider', //mode = slider, fade, m3d,  
			nav:false,
			btn:true,
			speed: 400,
			loop:true,
			auto:false,
			autoT:3000, 
			autoS:1000,
			view:1,
			css:true,
			Indc:false
    });
    
    /*toggle*/
    $('#J_tg_btn01').on('click',function(){
        $(this).toggleClass('on');
        $(this).siblings('#J_tg_con01').toggle();
    });

    /*ad_modal*/
    var info_tg = true;
    $('.U_table05_btn button').on('click',function(){
            var info_txt = $(this).data('info');
            var make_tag = "<div class='J_mask02 T_ds_table'>";
            make_tag += "<div class='J_modal_wrap02 T_ds_cell'>";
            make_tag += "<div class=''>";
            make_tag += "<strong>개인정보 취급 방침</strong>";
            make_tag += "<p>";
            make_tag += info_txt;
            make_tag += "</p>";
            make_tag += "<button type='button' class='J_mask_cl2'>닫기</button>"
            make_tag += "</div>";
            make_tag += "</div>";
            if(info_tg){
                $(this).after(make_tag);
                info_tg =false;
            }
            $('.J_mask_cl2').on('click',function(){
                $('.J_mask02').remove();
                info_tg =true;
            });
        return false;          
    });
    
    /*ad_modal*/
    var ad_tg = true;
    $('#ad_btn').on('click',function(){
            var make_tag = "<div class='J_mask T_ds_table'>";
            make_tag += "<div class='J_modal_wrap T_ds_cell'>";
            make_tag += "<div class=''>";
            make_tag += "<div class='U_title03 clear T_mg_btm30'><strong>개인정보 취급 방침</strong>";
            make_tag += "<button type='button' class='J_mask_cl'>닫기</button>"
            make_tag += "</div>";
            make_tag += "<p>";
            make_tag += ad_text;
            make_tag += "</p>";
            make_tag += "</div>";
            make_tag += "</div>";
            make_tag += "</div>";
            if(ad_tg){
                $(this).after(make_tag);
                ad_tg =false;
            }
            $('.J_mask_cl').on('click',function(){
                $('.J_mask').remove();
                ad_tg =true;
            });
        return false;          
    });
    
    //include 방식으로 body태그도 공통으로 사용할 경우로 대비하여
    //body 태그에 적용한 class를 자동할당 되는문
    
    if(!index){
        if(dep1_num){
            $('body').addClass('sub'+dep1_num);
        }
    }
});

var ad_text = '개인정보 취급 방침<br>원패스아카데미의 개인정보 취급 방침은 다음과 같습니다.<br>가. 개인정보 수집 항목 및 수집방법<br>1. 개인정보 취급방침은 원패스아카데미(이하 "회사"라 합니다) 회사는 회원가입, 원활한 고객상담, 각종 서비스의 제공을 위해 최고 회원가입 당시 아래와 같은 개인정보를 수집하고 있습니다.<br>① 고유식별정보항목 <br>성명, 생년월일, 아이핀, 외국인등록번호, 여권번호<br>② 수집 항목<br><일반/어린이 회원가입><br>필수정보 : 이름, 가입인증정보, 생년월일, 성별, 이름(영문), 회원 아이디, 비밀번호, 이메일,<br>연락처(일반 전화번호, 휴대 전화번호 중 택1), 주소(자택 및 직장 중 택1) 법정 대리인 정보(만14세 미만), 카카오톡 문자캡처, 이미지캡처, 은행계좌 정보, 신용카드정보, 추천인 성명<br>선택정보 : 현재 직업, 최종 학력, 관심사항, 전화마케팅/SMS, 수신/이메일 수신 수신동의 <br><외국인 회원가입><br>필수정보 : 이름, 가입인증정보, 생년월일, 성별, 이름(영문), 회원 아이디, 비밀번호, 이메일, <br>연락처(일반 전화번호, 휴대 전화번호 중 택1), 주소(자택 및 직장 중 택1), 법정 대리인 정보(만14세 미만), 카카오톡 문자캡처, 이미지캡처, 은행계좌 정보, 신용카드정보, 추천인 성명<br>선택정보 : 현재 직업, 최종 학력, 관심사항, 전화마케팅/SMS, 수신/이메일 수신 수신동의 <br>서비스 이용과정이나 사업처리 과정에서 아래와 같은 정보들이 자동으로 생성되어 수집될 수 있습니다. <br>IP Address, 쿠키, 방문 일시, 서비스 이용 기록 <br>나. 개인정보 수집 및 이용 목적<br>1. ‘개인정보’는 개인에 대한 정보로서 이름, 생년월일 등에 의하여 해당 개인을 알아볼 수 있는 부호, 문자, 음성, 음향, 영상 등의 정보를 말합니다. 해당 정보만으로는 특정 개인을 알아볼 수 없는 경우에도 다른 정보와 용이하게 결합하여 알아볼 수 있는 것을 포함합니다.<br>2. 회사는 회사 웹사이트에서 회원으로 가입하는 절차를 통하여 회원의 개인정보를 수집합니다. <br>회사는 회원가입 시 이 방침의 내용에 대해 ‘동의’ 혹은 ‘취소’할 수 있는 절차를 마련하고 있으며, 회원이 ‘동의’ 버튼을 선택하면 개인정보 수집에 대해 동의한 것으로 봅니다.<br>3. 회사는 수집한 개인정보를 다음의 목적을 위해 이용합니다.<br>① 서비스 제공을 위한 본인 확인, 개인 식별<br>② 서비스 관련 정보의 제공 (예: 신규서비스 소개, 이벤트 등 광고성 정보의 전달)<br>③ 마케팅 광고, 프로모션제공, 접속빈도 파악, 회원 서비스 이용에 대한 통계<br>4. 회사는 이용자들의 개인정보를 1~3. 항에서 고지한 범위 내에서 사용하며, 이용자의 사전 동의 없이는 동의 범위를 초과하여 이용하거나 원칙적으로 이용자의 개인정보를 외부에 공개하지 않습니다. <br>다만, 아래의 경우에는 예외로 합니다. <br>- 이용자들이 사전에 공개에 동의한 경우 - 법령의 규정에 의거하거나, 수사 목적으로 법령에 정해진 절차와 방법에 따라 수사기관의 요구가 있는 경우<br>다. 개인정보 보유 및 이용기간<br>1. 회사는 회원이 회원으로서의 자격을 유지하고 회사로부터 서비스를 제공받는 동안 회원의 개인정보를 계속적으로 보유하고 서비스의 제공 등을 위해서 이용합니다.<br>2. 회원의 권리 남용, 악용, 명의도용 등의 민원발생 시 이의사항의 처리 및 소명 등의 사실 확인을 위하여 회원탈퇴일로부터 1년 동안 개인정보를 보유할 수 있습니다.<br>3. 서비스를 불건전하게 이용한 불량 회원의 경우 부정한 이용의 재발 방지 및 사법기관 수사의뢰, 다른 회원을 보호할 목적으로 회원탈퇴 이후에도 1년간 해당 개인정보를 보유할 수 있습니다.<br>4. 관계법령 규정에 의하여 거래 관련 권리 의무 관계의 확인 등을 이유로 필요한 경우 회원탈퇴 이후 관계법령에서 정한 일정기간 동안 개인정보를 보유할 수 있습니다. 이 경우 회사는 보관하는 정보를 그 보관의 목적으로만 이용하며 보존기간은 아래와 같습니다.<br>① 계약 또는 청약철회 등에 관한 기록 <br>보존이유 : 전자상거래 등에서의 소비자보호에 관한 법률<br>보존기간 : 5년<br>② 대금결제 및 재화 등의 공급에 관한 기록<br>보존이유 : 전자상거래 등에서의 소비자보호에 관한 법률<br>보존기간 : 5년<br>③ 소비자의 불만 또는 분쟁처리에 관한 기록<br>보존이유 : 전자상거래 등에서의 소비자보호에 관한 법률<br>보존기간 : 3년<br>④ 본인확인에 관한 기록<br>보존이유 : 정보통신 이용촉진 및 정보보호 등에 관한 법률<br>보존기간 : 6개월<br>⑤ 방문에 관한 기록<br>보존이유 : 정보통신 이용촉진 및 정보보호 등에 관한 법률<br>보존기간 : 3개월<br>⑥ 회원탈퇴 시 개인정보의 보관<br>회원 등록하여 수집된 개인정보는 회원탈퇴 시 회사에서 정한 보상플랜 정산기간까지 개인정보를 보관할 수 있다.<br>라. 개인정보 파기절차 및 방법<br>1. 회사가 수집한 회원의 개인정보는 그 목적이 달성되거나 보유 및 이용기간이 경과한 후에는 지체 없이 파기합니다. <br>종이에 출력된 개인정보는 분쇄기로 분쇄하거나 소각을 통하여 파기하며, 전자적 파일형태로 저장된 개인정보는 기록을 재생할 수 없는 기술적 방법을 사용하여 삭제합니다.<br>2. 회원의 개인정보를 회원탈퇴 이후에 회사의 정책 및 관계법령에 의한 정보보호 사유에 따라 일정 기간 보유하는 경우 개인정보는 별도의 데이터베이스로 옮겨져 회사의 정책 및 관계법령에 의해 일정기간 저장된 후 파기합니다.<br>별도의 데이터베이스로 옮겨진 개인정보는 법률에 의한 경우가 아니고서는 보유목적 이외의 용도로 이용하지 않습니다.<br>3. 파기절차 : 이용자가 회원가입 등을 위해 입력한 정보는 목적이 달성된 후 별도의 DB로 옮겨져, (종이의 경우 별도의 서류함) 내부 방침 및 기타 관련 법령에 의한 정보보호 사유에 따라 (보유 및 이용기간 참조) 일정 기간 저장된 후 파기됩니다. 이용자의 개인정보는 법률에 의한 경유가 아니고서는 보유되는 이외의 다른 목적으로 이용되지 않습니다.<br>4. 파기방법 : 회사는 회원의 개인정보를 안전하게 처리하며, 유출의 방지를 위하여 다음과 같은 방법을 통하여 개인정보를 파기합니다.<br>1. 종이에 출력된 개인정보는 분쇄기로 분쇄하거나 소각을 통한 파기<br>2. 전자적 파일 형태로 저장된 개인정보는 기록을 재생할 수 없는 기술적 방법 사용하여 삭제<br>마. 개인정보 공유 및 제공<br>1. 회사는 회원의 개인정보를 회원의 사전 동의 없이 제3자에게 제공 및 공유할 수 없습니다. <br>단, 다음 각 호의 경우에는 합당한 절차를 통해 회원의 동의를 얻어 개인정보를 제공 또는 이용할 수 있습니다. <br>① 개인정보의 취급 위탁<br>ㄱ. 수탁업체 : ㈜웹모아<br>위탁업무내용 : 사이트 유지보수 및 프로그램 개발을 위한 업무<br>제공 항목 : 성명, 전화번호 및 게시물관련 기타 위탁업무 목적 달성을 위해 필요한 정보<br>보유 및 이용기간 : 회원탈퇴 시 혹은 위탁계약 종료 시까지<br>ㄴ. (추가될 수 있음)<br>② 관계법령에 의하여 국가기관이 요청한 경우<br>③ 범죄에 대한 수사 목적으로 수사기관이 요청한 경우<br>④ 회원의 약관 위반을 포함하여 부정행위 확인 등의 정보보호 업무를 위해 필요한 경우<br>⑤ 업무상 연락을 위하여 회원의 정보를 이용하는 경우<br>⑥ 은행업무상 관련사항에 한하여 일부 정보를 공유하는 경우<br>⑦ 통계작성, 홍보자료, 학술연구 또는 시장조사를 위하여 필요한 경우로서 특정회원임을 식별할 수 없는 형태로 제공하는 경우<br>2. 회사가 영업의 전부 또는 일부를 양수받거나 합병, 상속 등으로 제3자의 권리의무를 승계한 경우 제3자에게 가입된 회원에게 다음 각 호의 사항을 알립니다. 이 경우 회사는 회사의 웹사이트에 30일 동안 공지하거나 전화, 우편, 팩스, 전자우편 등의 방법으로 공지합니다. <br>단, 제3자가 개인정보 이전 사실을 동일한 절차와 내용으로 미리 통보한 경우에는 예외로 합니다.<br>① 제3자의 권리의무를 승계한 사실 및 회사명<br>② 개인정보관리책임자의 이름, 소속부서, 지위, 전화번호, 기타 연락처<br>③ 개인정보의 이용목적, 보유 및 이용기간<br>④ 개인정보의 수집, 이용 및 제공에 대한 동의 철회 등 회원의 권리 및 행사방법<br>바. 개인정보보호를 위한 조치<br>1. 회사는 회원의 개인정보를 취급함에 있어 개인정보가 분실, 도난, 누출, 변조 또는 훼손되지 않도록 안전성 확보를 위하여 다음과 같은 기술적 대책을 강구합니다.<br>① 회원의 개인정보는 회원가입 시 입력한 암호에 의해 철저히 보호합니다.<br>② 회사는 암호알고리즘을 이용하여 네트워크상의 개인정보를 안전하게 전송할 수 있는 보안장치(SSL, Secure Sockets Layer)를 채택합니다.<br>③ 회사는 백신프로그램을 이용하여 컴퓨터바이러스에 의해 회원 개인정보의 유출이나 훼손을 방지하는 조치를 취합니다. 개인정보의 훼손에 대비해서 자료를 수시로 백업하고 최신 백신프로그램을 이용하여 회원의 개인정보를 안전하게 전송합니다.<br>④ 회사는 침입차단시스템을 이용하여 외부로부터의 무단 접근을 통제하며 기타 시스템적으로  보안성을 확보하기 위한 가능한 모든 기술적 장치를 갖추려 노력합니다.<br>2. 회사는 회원의 개인정보를 취급하는 직원을 별도로 지정하여 회원의 개인정보를 취급할 수 있는 직원의 범위를 최소한으로 제한하고 있으며 그 최소한의 인원에 해당하는 자는 다음과 같습니다.<br>① 회원을 직접 상대로 하여 고객지원 또는 마케팅 업무를 수행하는 자<br>② 개인정보관리책임자 등 개인정보관리업무를 수행하는 자<br>③ 기타 업무상 개인정보의 취급이 불가피한 자<br>3. 회사는 개인정보를 취급하는 직원을 대상으로 새로운 보안기술 등에 대한 수시교육을 통하여 개인정보취급방침 준수를 강조합니다.<br>4. 회사는 개인정보취급자가 변경되었을 경우 지체 없이 개인정보처리시스템의 접근권한을 변경 또는 말소합니다.<br>5. 회사는 회원 개인의 실수나 기본적인 인터넷의 위험성 때문에 일어나는 일들에 대해 책임을 지지 않습니다. <br>회원 개개인이 본인의 개인정보를 보호하기 위해서 자신의 회원번호 및 아이디와 비밀번호를 적절하게 관리하고 여기에 대한 책임을 져야 합니다.<br>사. 쿠키 운영에 대한 사항<br>1. 회사는 회원에게 최적화된 서비스 제공을 하기 위하여 접속빈도, 방문시간 등을 분석하고 회원의 취향과 관심분야를 파악하는 ‘쿠키(cookie, 접속정보파일)’를 운용합니다.<br>2. 회원은 ‘쿠키’에 대한 선택권을 가지고 있습니다. 회원은 웹브라우저의 옵션을 선택함으로써 모든 쿠키를 허용하거나, 쿠키가 저장될 때마다 확인을 거치거나, 모든 쿠키의 저장을 거부할 수 있습니다. 단, 모든 쿠키의 저장을 거부하는 경우 쿠키를 통해 회사에서 제공하는 서비스를 이용할 수 없습니다.<br>○ 쿠키 설치 허용 여부를 지정하는 방법 : Internet Explorer를 사용하는 경우<br>[도구] 메뉴에서 [인터넷 옵션]을 선택 >[개인정보] 탭을 클릭 >[개인정보보호수준]을 설정<br>○ 받은 쿠키를 보는 방법 : Internet Explorer를 사용하는 경우<br>[도구] 메뉴에서 [인터넷옵션]을 선택 >[일반] 탭에서 [검색기록]의 [설정]을 선택 >[임시인터넷파일]의 [파일보기]를 선택<br>아. 회원의 권리와 그 행사방법<br>1. 회원은 개인정보를 최신의 상태로 정확하게 입력하여 불의의 사고를 예방해야 합니다.<br>회원이 입력한 부정확한 정보로 인해 발생하는 사고의 책임은 회원에게 있으며 타인 정보의 도용 등 허위정보를 입력할 경우 회사는 회원자격을 박탈할 수 있습니다.<br>2. 회원 및 법정대리인은 언제든지 회사에 등록되어 있는 회원의 개인정보를 열람하거나 오류가 있는 경우 정정할 수 있습니다. 개인정보 열람 및 오류정정의 경우 회사 웹사이트에서 '+"'내정보→정보수정'"+'을 클릭하여 직접 열람 또는 오류를 정정하거나 개인정보관리책임자에게 서면, 전화, 전자우편 등의 방법으로 열람 또는 정정을 요청할 수 있습니다.<br>이 경우 정정을 완료하기 전까지 해당 개인정보를 이용 또는 제공하지 않습니다.<br>3. 회원 및 법정대리인은 언제든지 개인정보수집, 이용, 제공 등의 동의를 철회할 수 있습니다. <br>이 경우 회원은 서면, 전화, 전자우편 등의 방법으로 회원탈퇴요청을 할 수 있습니다. <br>이용 중인 서비스가 없는 경우 회사는 이 방침 제5조에서 명시한 절차 및 방법으로 회원의 개인정보를 파기합니다.<br>제10조 개인정보관리책임자<br>1) 회사는 방송통신위원회 지정 ‘개인정보취급방침’에 의거한 개인정보 관리 책임자를 아래와 같이 지정합니다. <br>○ 개인정보관리책임자 : 황인근<br>○ 담당부서 : 원패스아카데미<br>○ 전화번호 : 010-5589-9812<br>○ E-mail : y0809y@naver.com<br>2) 회원은 회사의 서비스를 이용하며 발생하는 모든 개인정보보호 관련 민원을 담당부서 혹은 개인정보관리책임자에게 신고할 수 있습니다. 회사는 회원의 신고사항에 대해 신속하고 충분한 답변을 합니다. <br>또한 회사의 "웹사이트" 이용 중 회사의 개인정보보호에 관련된 처리에 대하여 만족하지 못하실 경우에는 정부에서 운영 중인 아래 기관을 통해 분쟁 조정할 수 있습니다.<br>- 개인정보침해 신고센터 (http://privacy.kisa.or.kr/kor/main.jsp / 국번 없이 118)<br>- 개인분쟁조정위원회 (http://www.1336.or.kr / 국번 없이 1336)<br>- 정보보호마크인증위원회 (http://www.eprivacy.or.kr / 02-580-0533~4)<br>- 대검찰청 인터넷범죄수사센터 (http://www.spo.go.kr / 02-3480-2000)<br>- 경찰청 사이버테러대응센터 (http://www.ctrc.go.kr / 02-392-0330)';






