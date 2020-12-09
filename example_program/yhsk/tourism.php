<?php
$sub_menu = "970300";
include_once('./_common.php');
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
auth_check($auth[$sub_menu],"r");

$g5['title'] = '관광공사API';
include_once('./_head.php');

//add_javascript('<script src="'.G5_USER_JS_URL.'/jquery-ui-1.12.1/jquery-ui.min.js"></script>', 0); 
//add_javascript('<script src="https://cdn.quilljs.com/1.3.4/quill.js"></script>');
add_javascript('<script src="https://cdn.jsdelivr.net/npm/vue@2.6.0"></script>');
//add_javascript('<script src="https://cdn.jsdelivr.net/npm/vue-quill-editor@3.0.4/dist/vue-quill-editor.js"></script>');
add_javascript('<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>');
add_javascript('<script src="https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.8.34/browser.js"></script>');
//add_stylesheet('<link href="https://cdn.quilljs.com/1.3.4/quill.core.css" rel="stylesheet">');
//add_stylesheet('<link href="https://cdn.quilljs.com/1.3.4/quill.snow.css" rel="stylesheet">');
//add_stylesheet('<link href="https://cdn.quilljs.com/1.3.4/quill.bubble.css" rel="stylesheet">');


?>

 
<section id="App">
    <div class="U_loding" v-if="show_lodding">
        <div>
            <i class="fa fa-spinner"></i>
            <span>로딩 중입니다. 잠시만 기다려주세요.</span>
        </div>
    </div>

    <div class="btn_fixed_top">
        <button class="btn_01 btn" @click="insertTour()">선택 항목 축제에 추가하기</button>
        <button class="btn_02 btn" @click="insertTourAll()">전체리스트 축제에 추가하기</button>
    </div>

    <div v-if="viewModal" class="U_modal">
        <div class="U_modal_wrap">
            <div class="U_modal_content">
                <h2 class="U_modal_head">{{view.title}}  
                </h2>
                <div class="U_modal_body">
                    <div class="tbl_frm01 tbl_wrap">
                        <table>
                            <tbody>
                                <tr>
                                    <th>시작일</th>
                                    <td>
                                        {{view.eventstartdate}}
                                    </td>
                                    <th>종료일</th>
                                    <td>
                                        {{view.eventenddate}}
                                    </td>
                                </tr>

                                <tr>
                                    <th>주소</th>
                                    <td colspan="3">
                                        {{view.addr1}} 
                                        {{view.addr2}}
                                    </td>
                                </tr>

                                <tr>
                                    <th>내용</th>
                                    <td colspan="3">
                                        {{view.content}}
                                    </td>
                                </tr>

                                <tr>
                                    <th>대표이미지1</th>
                                    <td colspan="3">
                                        <img :src="view.firstimage" alt="">
                                    </td>
                                </tr>
                                <tr>
                                    <th>대표이미지2</th>
                                    <td colspan="3">
                                        <img :src="view.firstimage2" alt="">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="U_modal_foot">
                    <button class="btn btn_01" @click="closeview()" >닫기</button>
                </div>
            </div>
        </div>
    </div>

    <div>
        <h2 class="h2_frm">떠날생각 리스트</h2>
        <div class="U_search local_sch01">
            <input type="date" class="frm_input" v-model="ch_start_date" >
            ~
            <input type="date" class="frm_input" v-model="ch_end_date" >
            <button class="btn_01 btn" @click="chdate()">검색</button>
            <button class="btn_02 btn" @click="resetdate()">전체보기</button>
            
            <?php /*
            <input type="text" class="frm_input" v-model="search_text">
            <input type="submit" class="btn_submit" @click="search()">
            <select  v-model="search_sido" id="search_col_2" @change="search_select('sido')">
                <option value="">선택안함</option>
                <option v-for="(key,index) in set_sido_idx" :value="key" :key="index">{{set_sido_name[index]}}</option>
            </select>
            <input type="checkbox" v-model="search_col" value="trm_idx_sido" class="sound_only">
            <label for="search_col_2" class="U_select_side">시·도</label>

            <select  v-model="search_gugun" id="search_col_3" @change="search_select('gugun')" v-if="search_col.indexOf('trm_idx_sido') !== -1">
                <option value="">선택안함</option>
                <option v-for="(key,index) in set_gugun_idx_s" :value="key" :key="index">{{set_gugun_name_s[index]}}</option>
            </select>
            <input type="checkbox" v-model="search_col" value="trm_idx_gugun" class="sound_only">
            <label for="search_col_3" class="U_select_side"  v-if="search_col.indexOf('trm_idx_sido') !== -1">시·군</label>
            
            <select  v-model="search_cate" id="search_col_4" @change="search_select('cate')">
                <option value="">선택안함</option>
                <option v-for="(key,index) in set_cate_idx" :value="key" :key="index">{{set_cate_name[index]}}</option>
            </select>
            <input type="checkbox" v-model="search_col" value="tmc_idx" class="sound_only">
            <label for="search_col_4" class="U_select_side">카테고리</label>

            <input type="checkbox" v-model="search_col" value="tm_subject" id="search_col_1">
            <label for="search_col_1">테마명</label>
            <input type="checkbox" v-model="search_col" value="tm_use_y" id="search_col_5">
            <label for="search_col_5">노출활성</label>
            <input type="checkbox" v-model="search_col" value="tm_use_n" id="search_col_6">
            <label for="search_col_6">노출비활성</label>
            */ ?>
        </div>
        <div>
            <div class="tbl_head01 tbl_wrap">
                <table>
                    <caption>휴일목록</caption>
                    <thead>
                        <tr>
                            <th scope="col"><input type="checkbox" v-model="allCheck" value="true" @change="checkAll()"></th>
                            <th scope="col">번호</th>
                            <th scope="col">축제명</th>
                            <th scope="col" style="width:250px">연락처</th>
                            <th scope="col" style="width:250px">기간</th>
                            <th scope="col" style="width:100px">상세보기</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg0"  v-for="(list,index) in set_list" :key="index" >
                            
                            <td>
                                <input type="checkbox" :value="list.contentid" v-model="ck_arr">
                            </td>
                            <td>
                                {{set_list_num - (index+ (set_list_page * set_list_row))}}
                            </td>
                            <td>
                                {{list.title}}
                            </td>
                            <td>
                                {{list.tel}}
                            </td>
                            <td>
                                {{list.eventenddate.substring(0,4)}}년
                                {{list.eventenddate.substring(4,6)}}월 
                                {{list.eventenddate.substring(6,8)}}일
                                ~
                                {{list.eventstartdate.substring(0,4)}}년 
                                {{list.eventstartdate.substring(4,6)}}월
                                {{list.eventstartdate.substring(6,8)}}일
                            </td>
                            <td>
                            <button class="btn_02 btn"  @click="getView(list)">보기</button></td>
                        </tr>

                        <tr v-if="set_list.length == 0">
                            <td colspan="8" style="padding:20px 0 ">
                                자료가 존재하지 않습니다.
                            </td>					
                        </tr>
                    </tbody>
                </table>

                <div style="text-align:center">
                    <nav class="pg_wrap">
                        <span class="pg">
                            <button type="button" @click="firstPage" class="pg_page pg_start">처음</button>
                            <button type="button" v-if="set_list_page > 0" @click="prevPage" class="pg_page pg_prev">이전</button>
                            <button type="button" v-for="(list,index) in set_list_pages" @click="clickPage(list)" class="pg_page" :class="set_list_page == list ? 'pg_current' : ''">{{list+1}}<span class="sound_only">{페이지}</span></button>
                            <button type="button" v-if="set_list_page < (set_list_total-1)" @click="nextPage" class="pg_page pg_next">다음</button>
                            <button type="button" @click="endPage" class="pg_page pg_end">맨끝</button>
                        </span>
                    </nav>
                </div>

            </div>
        </div>
    </div>
    
</section>

<script type="text/babel">

    const setParameterUrl  = (json) => {
		let urlGetData = '';
		Object.keys(json).forEach(function(key){
			urlGetData += `${key}=${json[key]}&`;
		});
		urlGetData = urlGetData.slice(0,-1); 
		return urlGetData;
    }
    
    const axios_url  = './_ajax/tourism_ajax.php';
	const App = new Vue({
		mode: 'production',
		el: '#App',
		data: {
            //API LIST 리스트셋팅
			set_list : [],
            set_list_num : 0,
			set_list_row : 50,
			set_list_page : 0,
			set_list_pages : [],
			set_list_total : 0,
            set_list_start_date : '',
            set_list_end_date : '',

            //선택 날짜
            ch_start_date : '',
            ch_end_date : '',

            //체크 배열
            allCheck : false,
            ck_arr : [],

            //API VIEW 리스트셋팅
            set_view : {

            },
            //API SHEARCH 옵션
            set_ch : {

            },
            viewModal : false,
            view : {},
		},
		created: function(){
            this.show_lodding = false;
            this.getList();
            //this.cate_search();
            //this.area_search('sido');
		},
        computed: {},
		methods:{
            checkAll:function(){
                const arr = new Array();
                if(this.allCheck){
                    for(let i = 0; i < this.set_list.length; i++){
                        arr.push(this.set_list[i].contentid);
                    }
                }
                this.ck_arr = arr;
            },
            chdate : function(){
                if(this.ch_start_date !== '' && this.ch_end_date !== ''){
                    this.set_list_start_date = this.ch_start_date
                    this.set_list_end_date = this.ch_end_date
                    this.getList();
                }else{
                    alert('날짜를 선택해주세요!');
                }
                    
            },
            resetdate :  function(){
                this.set_list_end_date = '';
                this.set_list_start_date = '';
                this.getList();
            },
            insertTour:function(){ //새로운 축제로 리스트 업데이트 하기
                this.show_lodding = true;
                if(this.ck_arr.length > 0){
                    if(confirm('선택한 항목을 생성하시겠습니까?\n이미 등록한 축제는 등록되지 않습니다.')){
                        const json = {
                                "mode" : "i",
                                "ids" : this.ck_arr
,
                        };
                        //setting url 
                        let urlGetData = '';
                        urlGetData = setParameterUrl(json);
                        const url = `${axios_url}?${urlGetData}`;
                        axios.get(url).then((response)=> {
                            this.show_lodding = false;
                            alert('완료되었습니다.');
                        });
                    }
                }else{
                    alert('한개 이상 선택해주세요!');
                }
            },
            insertTourAll:function(){ //새로운 축제로 리스트 업데이트 하기

                if(this.set_list_end_date == '' || this.set_list_start_date ==  ''){
                    alert('일괄 등록할 날짜를 검색후에 리스트를 생성하여 주세요!');
                    return false;
                }
                if(confirm('전체리스트를 출력하겠습니까?\n이미 등록한 축제는 등록되지 않습니다.')){
                    this.show_lodding = true;
                    const json = {
                            "mode" : "a",
                            "set_list_start_date" : this.set_list_start_date.replace(/-/gi,''),
                            "set_list_end_date" : this.set_list_end_date.replace(/-/gi,''),
                    };
                    //setting url 
                    let urlGetData = '';
                    urlGetData = setParameterUrl(json);
                    const url = `${axios_url}?${urlGetData}`;
                    axios.get(url).then((response)=> {
                        this.show_lodding = false;
                        alert('완료되었습니다.');
                    });
                }
            },
            closeview:function(){
                this.view = '';
                this.viewModal = false;
            },
            getView:function(data){ //상세보기
                this.show_lodding = true;
                this.viewModal = true;
                const json = {
						"mode" : "v",
						"id" : data.contentid ,
						"content_type" : data.contenttypeid,
                };

                //setting url 
                let urlGetData = '';
                urlGetData = setParameterUrl(json);
                const url = `${axios_url}?${urlGetData}`;
                axios.get(url).then((response)=> {
                    data.content = response.data.content[0];
                    this.view = data;
                    this.show_lodding = false;
                });
            },
            getList:function(){ //테마 목록호출
                    this.show_lodding = true;
					const json = {
						"mode" : "l",
                        "set_list_start_date" : this.set_list_start_date.replace(/-/gi,''),
                        "set_list_end_date" : this.set_list_end_date.replace(/-/gi,''),
 						"set_list_row" : this.set_list_row,
						"set_list_page" : this.set_list_page ,
						"set_list_total" : this.set_list_total,
                    };

                    //setting url 
					let urlGetData = '';
					urlGetData = setParameterUrl(json);
					const url = `${axios_url}?${urlGetData}`;
                    
					//axios data
					axios.get(url).then((response)=> {
                        console.log(response);
                        if(response.data.list){
						    this.set_list = response.data.list.item;
                        }else{
						    this.set_list = [];
                        }
                        this.setPage(response.data.totalCount[0]);
                        this.show_lodding = false;
					});
			},
			setPage:function(totalListNum){
                this.set_list_num = totalListNum;
				this.set_list_total = Math.ceil(totalListNum /this.set_list_row);
				this.set_list_pages = [];

				if(this.set_list_page > this.set_list_total-1)
					this.set_list_page = this.set_list_page - 1;

				const set_pages_list = Math.round( (this.set_list_page-5) / 10) * 10;
				const insArr = [];
				const setMax = this.set_list_total < 10 ? this.set_list_total : 10;
				for(let i =0; i < setMax; i++){
					if(set_pages_list+i < this.set_list_total)
						insArr.push(set_pages_list+i);
				}
				this.set_list_pages = insArr;
			},
			nextPage:function(e){
				const setNum = this.set_list_page+1;
				this.clickPage(setNum);
			},
			endPage:function(e){
				//this.set_list_page +;
				const setNum = this.set_list_total;
				this.clickPage(setNum-1);
			},
			prevPage:function(e){
				const setNum = this.set_list_page-1;
				this.clickPage(setNum);
			},
			firstPage:function(e){
				this.clickPage(0);
			},
			clickPage:function(page){
				this.set_list_page = page;
				this.getList();
			},
		}
	})

</script>


<style>
    @-webkit-keyframes rotation {
        from {-webkit-transform: rotate(0deg);}
        to   {-webkit-transform: rotate(359deg);}
    }

    .U_loding , .U_modal{position:fixed;width:100%;height:100%;background:rgba(0,0,0,0.6);top:0;left:0;z-index:9999;display:table}
    .U_loding{z-index:10000;background:rgba(0,0,0,0.8);}
    .U_loding > div ,.U_modal_wrap{display:table-cell;width:100%;height:100%;vertical-align:middle;}
    .U_loding > div span{display:block;font-size:14px;margin-top:15px}
    .U_loding > div{text-align:center;color:#fff}
    .U_loding > div i {font-size:20px;animation: rotation 2s infinite linear;}
    .U_modal_content{width:90%;max-width:1200px;background:#fff;height:80%;overflow:hidden;margin:0 auto;max-height:600px}
    .U_modal_content > *{ padding:10px 20px;margin:0}
    .U_modal_content .U_modal_head{font-size:18px;line-height:38px;}
    .U_modal_content .U_modal_head span{font-size:12px;color:#777}
    .U_modal_content .U_modal_foot{height:50px}
    .U_modal_content .U_modal_body{height:calc( 100% - 108px ); overflow:auto}
    .U_modal_mini2 .U_modal_content .U_modal_body{overflow:hidden}
    .tbl_frm01 th{width:120px}
	.U_thema_list{background:#3f51b5;color:#fff;border-radius:100px;display:inline-block;padding:0 10px;margin:7px 0;margin-right:5px}
	.U_thema_list button{border:0;padding:0;vertical-align:inherit;color:#fff;background:none}
	.U_thema_list.off {background:#8d8d8d}
    .U_modal.U_modal_mini .U_modal_content{max-width:800px;max-height:600px}
    .U_modal_body .U_cate_box:first-child{margin-bottom:30px}
    .U_cate_box strong{display:block;font-size:15px;margin-bottom:15px;font-weight:700}
    .U_cate_list li{display:inline-block;margin-bottom:7px;margin-right:7px}
    .U_cate_list button{font-size:12px;height:22px;padding:0 10px;border:1px solid #3f51b5;background:#3f51b5;border-radius:20px;color:#fff}
    .U_cate_list .on button{border:2px solid #000;background:#fff;;color:#3f51b5}
    .U_modal_body .U_cate_box2 {margin-bottom:0!important;height:64px}
    .U_cate_ch_box {height: calc( 100% - 64px );}
    .U_cate_ch_input {height:40px;background:#f1f1f1;border-radius:100px}
    .U_cate_ch_input > *{float:left;height:40px;}
    .U_cate_ch_input input{width:calc( 100% - 40px );border:0;padding:0 20px;background:none}
    .U_cate_ch_input button{width:40px;border:0;background:none;text-align:center;font-size:16px;color:#000}
    .U_cate_ch_input button i{vertical-align:baseline}
    .U_cate_ch_list{height:calc( 100% - 60px);overflow:auto;margin-top:20px}
    .U_cate_ch_list{padding-top:0px;border:1px solid #d9d9d9;}
    .U_cate_ch_list .no_data{height:100%;background:#d9d9d9;border:0!important;}
    .U_cate_ch_list li{background:#fff;border-bottom:1px dashed #d9d9d9;padding:5px 15px}
    .U_cate_ch_list li:last-child{border-bottom:0}
    .U_cate_ch_list li *{line-height:20px;font-size:12px}
    .U_cate_ch_list li button,.U_cate_ch_list li a{width:65px;color:#fff;font-size:12px;border:0;background:pink;margin-left:10px;border-radius:30px;background:#d9d9d9;text-align:center;color:#333}
    .U_cate_ch_list li button{float:right;}
    .U_cate_ch_list li a{float:right;}
    .U_cate_ch_list li span{float:left;width:calc(100% - 160px);padding:0 10px}
    .clear:after{content:"";clear:both;display:block}
    .U_select_side{height:32px;display:inline-block;line-height:32px;width:55px;text-align:center;position:relative;left:-7px;background:#60718b;color:#fff;border-radius:0 5px 5px 0 }
    
</style>



<?
include_once("./_tail.php");
?>