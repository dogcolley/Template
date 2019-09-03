/* 
	use extend type 
	: sumsing of 2 over object, 
	fn.extend 
	: make plugin
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
			console.log('test');
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

		set.find('.tab_btn li a').on('click', function(){
			$(this).parent().addClass('on').siblings().removeClass('on');
			var num = $(this).parent().index();
			set.find('.tab_con').find(' > li').eq(num).addClass('on').siblings().removeClass('on');
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
		
		var set = $(this);

        /* null mode */

		/* phone mode */
        
        /* address mode */
        
        /* pw mode */
        
        
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
	});
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


});

