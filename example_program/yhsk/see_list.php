<?php
$sub_menu = "970120";
include_once('./_common.php');
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
auth_check($auth[$sub_menu],"r");

$g5['title'] = '테마관리';
include_once('./_head.php');
add_javascript('<script src="https://cdn.quilljs.com/1.3.4/quill.js"></script>');
add_javascript('<script src="https://cdn.jsdelivr.net/npm/vue@2.6.0"></script>');
add_javascript('<script src="https://cdn.jsdelivr.net/npm/vue-quill-editor@3.0.4/dist/vue-quill-editor.js"></script>');
add_javascript('<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>');
add_javascript('<script src="https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.8.34/browser.js"></script>');
add_stylesheet('<link href="https://cdn.quilljs.com/1.3.4/quill.core.css" rel="stylesheet">');
add_stylesheet('<link href="https://cdn.quilljs.com/1.3.4/quill.snow.css" rel="stylesheet">');
add_stylesheet('<link href="https://cdn.quilljs.com/1.3.4/quill.bubble.css" rel="stylesheet">');



?>

<section id="leaveApp">
    <div class="U_loding" v-if="show_lodding">
        <div>
            <i class="fa fa-spinner"></i>
            <span>로딩 중입니다. 잠시만 기다려주세요.</span>
        </div>
    </div>

    <div class="btn_fixed_top">
        <button class="btn_01 btn" @click="showModal('i')">생성</button>
    </div>

	<form action="" @></form>
    <div v-if="show_modal" class="U_modal">
        <div class="U_modal_wrap">
            <div class="U_modal_content">
                <h2 class="U_modal_head">떠날생각{{set_mode == 'i' ? '생성': '수정'}}
                    <span>코스는 떠날생각 생성후 관리 할 수 있습니다.</span>
                </h2>
                <div class="U_modal_body tbl_frm01 tbl_wrap">
                    <table>
                        <tbody>
                            <tr>
                                <th>사용</th>
                                <td>
                                    <input type="radio" v-model="set_data.tm_use" id="tm_use1" value="1">
                                    <label for="tm_use1">활성</label>
                                    <input type="radio" v-model="set_data.tm_use" id="tm_use2" value="0">
                                    <label for="tm_use2">비활성</label>
                                </td>
                                <th>노출순서</th>
                                <td><input type="text" class="frm_input" v-model="set_data.tm_sort" ></td>
                            </tr>
                            <tr>
                                <th>제목</th>
                                <td><input type="text" class="frm_input" v-model="set_data.tm_subject" ></td>
                                <th>짧은소개글</th>
                                <td><input type="text" class="frm_input" v-model="set_data.tm_basic" ></td>
                            </tr>  
                            <tr>
                                <th>지역정보</th>
                                <td>
                                
                                    {{set_sido_name[set_sido_idx.indexOf(set_data.trm_idx_sido)] ? set_sido_name[set_sido_idx.indexOf(set_data.trm_idx_sido)] : ''}} 
                                    {{set_gugun_name[set_gugun_idx.indexOf(set_data.trm_idx_gugun)] ? '> '+set_gugun_name[set_gugun_idx.indexOf(set_data.trm_idx_gugun)] : ''}}

                                <button class="btn_01 btn" @click="showModal3()">지역검색</button></td>
                                <th>카테고리</th>
                                <td>
                                    {{set_cate_name.length > 0 ? set_cate_name[set_cate_idx.indexOf(set_data.tmc_idx)] : ''}}

                                <button class="btn_01 btn" @click="showModal4()">카테검색</button></td>
                            </tr>
                            
                            <?php /*
                            <tr>
                                <th>썸네일</th>
                                <td colspan="3">
                                    <input type="file"  ref="file_data" class="frm_input" v-model="set_data.tm_thumbnail">
                                </td>
                            </tr>
                            <tr>
                                <th>내용</th>
                                <td colspan="3">
                                    <quill-editor v-model="set_data.tm_content"
                                            ref="quillEditor01"
                                            :options="editor_Option"
                                            @blur="onEditorBlur($event)"
                                            @focus="onEditorFocus($event)"
                                            @ready="onEditorReady($event)">
                                    </quill-editor>
                                </td>
                            </tr>  
                            */?>
                            
                            <tr>
                                <th>소속된 코스</th>
                                <td colspan="3">
                                    <div class="U_thema_list" v-for="(data,index) in set_thema_arr" :key="index" :class="data.tml_use == 1 ? '' : 'off' ">
                                        <button type="button" @click="showModal2('u',data.tml_idx,index)">{{data.tml_name}}</button>
                                        <?php if(!auth_check($auth[$sub_menu],"d",true)){ ?><button type="button" @click="option_delete(data.tml_idx)"><i class="fa fa-times"></i></button><?}?>
                                    </div>
                                </td>
                            </tr>  
                        </tbody>
                    </table>
                </div>
                <div class="U_modal_foot">
                    <button class="btn btn_03" @click="showModal2('i')" v-if="set_mode == 'u' ">코스추가</button>
                    <button class="btn btn_03" @click="insert()">저장</button>
                    <button class="btn btn_01" @click="closeModal">닫기</button>
                </div>
            </div>
        </div>
    </div>

	<div v-if="show_modal2" class="U_modal">
        <div class="U_modal_wrap">
            <div class="U_modal_content">
                <h2 class="U_modal_head">코스정보입력
                </h2>
                <div class="U_modal_body">
                    <div class="tbl_frm01 tbl_wrap">
                        <table>
                            <tbody>
                                <tr>
                                    <th>코스사용</th>
                                    <td>
                                        <input type="radio" v-model="set_thema_data.tml_use" id="tm_use1" value="1">
                                        <label for="tm_use1">활성</label>
                                        <input type="radio" v-model="set_thema_data.tml_use" id="tm_use2" value="0">
                                        <label for="tm_use2">비활성</label>
                                    </td>
                                    <th>코스노출순서</th>
                                    <td><input type="text" class="frm_input" v-model="set_thema_data.tml_sort" ></td>
                                </tr>
                                <tr>
                                    <th>코스선택</th>
                                    <td colspan="3">
                                        {{set_thema_ca_name[set_thema_ca_idx.indexOf(set_thema_data.tml_table_idx)] ? set_thema_ca_name[set_thema_ca_idx.indexOf(set_thema_data.tml_table_idx)] : (set_thema_data.tml_name ? set_thema_data.tml_name : '') }}
                                        <button class="btn_01 btn" @click="showModal5()">코스검색</button>
                                    </td>
                                </tr>
                                <?php /*
                                <tr>
                                    <th>코스내용</th>
                                    <td colspan="3">
                                        <quill-editor v-model="set_thema_data.tml_content"
                                                ref="quillEditor02"
                                                :options="editor_Option"
                                                @blur="onEditorBlur($event)"
                                                @focus="onEditorFocus($event)"
                                                @ready="onEditorReady($event)">
                                        </quill-editor>
                                    </td>
                                </tr>
                                */ ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="U_modal_foot">
                    <?php if(!auth_check($auth[$sub_menu],"d",true)){ ?><button class="btn btn_03" @click="option_delete(set_thema_data.tml_idx)" v-if="set_thema_mode !== 'i' ">삭제</button><?php } ?>
                    <button class="btn btn_03" @click="option_insert()">{{set_thema_mode == 'i' ? '생성': '수정'}}</button>
                    <button class="btn btn_01" @click="closeModal2()">닫기</button>
                </div>
            </div>
        </div>
    </div>

    <div v-if="show_modal3" class="U_modal U_modal_mini">
        <div class="U_modal_wrap">
            <div class="U_modal_content">
                <h2 class="U_modal_head">지역카테고리</h2>
                <div class="U_modal_body">
                    <div class="tbl_frm01 tbl_wrap">
                        <div class="U_cate_box" v-if="set_sido_name.length > 0">
                            <strong>시 · 도 리스트</strong>
                            <ul class="U_cate_list">
                                <li v-for="(key,index) in set_sido_name" :key="index" type="button" :class="set_data.trm_idx_sido == set_sido_idx[index] ? 'on' : '' " @click="area_set(set_sido_idx[index],'sido')"><button>{{set_sido_name[index]}}</button></li>
                            </ul>
                        </div>
                        <div class="U_cate_box" v-if="set_gugun_name.length > 0">
                            <strong>군 리스트</strong>
                            <ul class="U_cate_list">
                                <li v-for="(key,index) in set_gugun_name" :key="index" type="button" :class="set_data.trm_idx_gugun == set_gugun_idx[index] ? 'on' : '' " @click="area_set(set_gugun_idx[index],'gugun')"><button>{{set_gugun_name[index]}}</button></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="U_modal_foot">
                    <button class="btn btn_01" @click="closeModal3()">닫기</button>
                </div>
            </div>
        </div>
    </div>

    <div v-if="show_modal4" class="U_modal U_modal_mini">
        <div class="U_modal_wrap">
            <div class="U_modal_content">
                <h2 class="U_modal_head">테마카테고리
                </h2>
                <div class="U_modal_body">
                    <div class="U_cate_box " v-if="set_cate_idx.length > 0">
                            <strong>카테고리 리스트</strong>
                            <ul class="U_cate_list">
                                <li v-for="(key,index) in set_cate_name" :key="index" type="button" :class="set_data.tmc_idx == set_cate_idx[index] ? 'on' : '' " @click="cate_set(set_cate_idx[index])"><button>{{set_cate_name[index]}}</button></li>
                            </ul>
                    </div> 
                </div>
                <div class="U_modal_foot">
                    <button class="btn btn_01" @click="closeModal3()">닫기</button>
                </div>
            </div>
        </div>
    </div>

    <div v-if="show_modal5" class="U_modal U_modal_mini U_modal_mini2">
        <div class="U_modal_wrap">
            <div class="U_modal_content">
                <h2 class="U_modal_head">코스검색
                </h2>
                <div class="U_modal_body">
                    <div class="U_cate_box U_cate_box2">
                        <strong>코스 종류 선택(별별시장 관리페이지 데이터)</strong>
                        <ul class="U_cate_list">
                            <li v-for="(key,index) in set_thema_ca_obj" :key="index" @click="option_cate_list(key.table)"><button>{{key.name}}</button></li>
                        </ul>
                    </div>
                    <div class="U_cate_ch_box">
                        <div class="U_cate_ch_input clear">
                            <input type="text" v-model="set_thema_ca_search" @keyup.enter="option_cate_list()">
                            <button   @click="option_cate_list()"><i class="fa fa-search"></i></button>
                        </div>
                        <ul class="U_cate_ch_list">
                            <li v-for="(key,index) in set_thema_ca_idx" :key="index" class="clear">
                                <span>{{set_thema_ca_name[index]}}</span>
                                <a :href="
                                set_thema_ca_table == 'g5_1_store'    ? './store_form.php?w=u&sto_idx='+key    : '' + 
                                set_thema_ca_table == 'g5_1_sijang'   ? './sijang_form.php?w=u&sij_idx='+key   : '' + 
                                set_thema_ca_table == 'g5_1_tour'     ? './tour_form.php?w=u&tou_idx='+key     : '' + 
                                set_thema_ca_table == 'g5_1_room'     ? './room_form.php?w=u&rom_idx='+key     : '' + 
                                set_thema_ca_table == 'g5_1_alley'    ? './alley_form.php?w=u&aly_idx='+key    : '' + 
                                set_thema_ca_table == 'g5_1_festival' ? './festival_form.php?w=u&fst_idx='+key : '' 
                                " target="_blank">상세보기</a>
                                <button type="button" @click="option_cate_set(key)">선택</button>
                            </li>
                            <li class="no_data" v-if="!set_thema_ca_idx" style="display:table;width:100%"><div style="display:table-cell;width:100%;height:100%;vertical-align:middle;text-align:center;font-size:14px;font-weight:700;color:#000"><i class="fa fa-folder-open"></i> 데이터가 없습니다.</div></li>
                        </ul>
                        <button></button>
                    </div>
                </div>
                <div class="U_modal_foot">
                    <button class="btn btn_01" @click="closeModal3()">닫기</button>
                    <button class="btn btn_01" v-if="set_thema_ca_idx"  @click="option_cate_list()">더보기</button>
                </div>
            </div>
        </div>
    </div>

    <div>
        <h2 class="h2_frm">떠날생각 리스트</h2>

        <div class="U_search local_sch01">
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
        </div>
        
        <div>
            <div class="tbl_head01 tbl_wrap">
                <table>
                    <caption>휴일목록</caption>
                    <thead>
                        <tr>
                            <th scope="col">번호</th>
                            <th scope="col">테마명</th>
                            <th scope="col">카테고리</th>
                            <th scope="col">지역</th>
                            <th scope="col" style="width:80px">노출</th>
                            <th scope="col" style="width:80px">수정</th>
                            <th scope="col" style="width:80px">삭제</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg0"  v-for="(list,index) in set_list" :key="index" >
                            <td>
                                {{set_list_num - (index+ (set_list_page * set_list_row))}}
                            </td>
                            <td>
                                {{list.tm_subject}}
                            </td>
                            <td>
                                {{set_cate_name[set_cate_idx.indexOf(list.tmc_idx)] ? set_cate_name[set_cate_idx.indexOf(list.tmc_idx)] : ''}}
                            </td>
                            <td>
                                {{set_sido_name[set_sido_idx.indexOf(list.trm_idx_sido)] ? set_sido_name[set_sido_idx.indexOf(list.trm_idx_sido)] : ''}}
                            </td>
                            <td>
                                {{list.tm_use == 1 ? '노출중' : '비노출'}}
                            </td>
                            <td>
                            <button class="btn_02 btn" <?php if(!auth_check($auth[$sub_menu],"w",true)){?> @click="showModal('u',list.tm_idx,list)"<?php }else{?>@click="alert('열람권한이 없습니다.')"<?php } ?>>보기</button></td>
                            <td><button class="btn_02 btn" <?php if(!auth_check($auth[$sub_menu],"d",true)){?> @click="del(list.tm_idx)" <?php }else{ ?> @click="alert('삭제권한이 없습니다.')"<?php } ?>>삭제</button></td>
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

    //Vue.use(VueQuillEditor);

	const setParameterUrl  = (json) => {
		let urlGetData = '';
		Object.keys(json).forEach(function(key){
			urlGetData += `${key}=${json[key]}&`;
		});
		urlGetData = urlGetData.slice(0,-1); 
		return urlGetData;
	}

    

    const axios_url  = './_ajax/see_ajax.php';
    const axios_url2 = './_ajax/thema_area.php';
    const axios_url3 = './_ajax/thema_cate.php';
    const axios_url4 = './_ajax/see_list_ajax.php';

	const leaveApp = new Vue({
		mode: 'production',
		el: '#leaveApp',
		data: {
            /*테마리스트셋팅*/
			set_list : [],
            set_list_num : 0,
			set_list_row : 10,
			set_list_page : 0,
			set_list_pages : [],
			set_list_total : 0,
            set_mode : 'i',

            /*테마정보*/
            set_data : {
                tm_use : 1,
                tm_sort : 0,
                tm_subject : '',
                tm_basic : '',
                tm_content : '테마내용을 입력해주세요!',
                tm_thumbnail : '',
                trm_sido_name : '',
                trm_gugun_name : '',
                tmc_name : '',
                trm_idx_sido : undefined,
                trm_idx_gugun : undefined,
                tmc_idx : undefined,
            },

            /*테마리셋정보*/
            set_data_reset : {
                tm_use : 1,
                tm_sort : 0,
                tm_subject : '',
                tm_basic : '',
                tm_content : '테마내용을 입력해주세요!',
                tm_thumbnail : '',
                trm_sido_name : '',
                trm_gugun_name : '',
                tmc_name : '',
                trm_idx_sido : undefined,
                trm_idx_gugun : undefined,
                tmc_idx : undefined,
            },
            
            /*검색*/
            search_col : [],
            search_text : '',
            search_continue : false,
            search_continue_text : '',
            search_continue_col : [],
            search_cate : '',
            search_gugun : '',
            search_sido  : '',
           
            /*코스 배열*/
            set_thema_arr : [],
            
            /*코스정보*/
            set_thema_idx : 0,
            set_thema_data : {
                tml_use: 1,
                tml_sort: 0,
                tml_subject : '',
                tml_basic: '',
                //tml_content: '',
                tml_table : '',
                tml_table_idx : undefined,
            },
            set_thema_mode : 'i',
            set_thema_data_reset : {
                tml_use: 1,
                tml_sort: 0,
                //tml_subject : '',
                //tml_basic: '',
                //tml_content: '',
                tml_table : '',
                tml_table_idx : undefined,
                tml_name : ''
            },

            /*코스카테고리정보*/
            set_thema_ca_table : '',
            set_thema_ca_row : 20,
            set_thema_ca_cnt : 0,
            set_thema_ca_obj : [
                {name:'스토어',table:'<?=$g5['store_table']?>'},
                {name:'시장',table:'<?=$g5['sijang_table']?>'},
                {name:'여행',table:'<?=$g5['tour_table']?>'},
                {name:'숙소',table:'<?=$g5['room_table']?>'},
                {name:'골목',table:'<?=$g5['alley_table'] ?>'},
                {name:'축제',table:'<?=$g5['festival_table']?>'},
            ],
            set_thema_ca_url :'',
            set_thema_ca_search : '',
            set_thema_ca_search_before : '',
            set_thema_ca_idx : [],
            set_thema_ca_name : [],
            
            /*지역정보*/
            set_sido_idx : [],
            set_sido_name : [],
            set_gugun_idx : [],
            set_gugun_name : [],
            set_gugun_idx_s : [],
            set_gugun_name_s : [],
            
            /*카테고리정보*/
            set_cate_idx : [],
            set_cate_name : [],

            /*모달 물리태그 셋팅*/
            show_lodding: true,
            show_modal :false,
            show_modal2:false,
            show_modal3:false,
            show_modal4:false,
            show_modal5:false,

            /*에디터 상태 셋팅*/
            editor_Option: {
                theme: 'snow'
            }
		},
		created: function(){
            this.show_lodding = false;
            this.getList();
            this.cate_search();
            this.area_search('sido');
		},
        computed: {
            /*
            editorA() {
                return this.$refs.quillEditor01.quill
			},
			editorB() {
                return this.$refs.quillEditor02.quill
            },
            */
        },
		methods:{
            onEditorBlur(quill){//console.log('editor blur!', quill)
            },
            onEditorFocus(quill){//console.log('editor focus!', quill)
            },
            onEditorReady(quill){//console.log('editor ready!', quill)
            },//editor end
            showModal(mode,idx,extendData){//테마 등록,수정 모달 열기
                this.show_modal = true;
                this.set_mode = mode ? mode : this.set_mode;
                if(extendData){
                    this.set_data = extendData;
                    this.set_thema_data.tm_idx = extendData.tm_idx;
                    this.option_list();
                    this.area_search('gugun',extendData.trm_idx_sido);
                }else
                    this.set_data = this.set_data_reset;
            },
            showModal2(mode,idx,i){//코스 등록,수정 모달열기
                this.show_modal2 = true;
                this.set_thema_mode = mode ? mode : this.set_thema_mode;
                if(mode == 'i'){
                    const saveIdx = this.set_thema_data.tm_idx;
                    this.set_thema_data = this.set_thema_data_reset;
                    this.set_thema_data.tm_idx = saveIdx;
                }
                if(idx){
                    this.set_thema_data = this.set_thema_arr[i];
                }
            },
            showModal3(){//지역 카테고리 등록 모달열기
                this.show_modal3 = true;
                this.area_search();
            },
            showModal4(){//테마카테고리 등록 모달열기
                this.show_modal4 = true;
                this.cate_search();
            },
            showModal5(){//코스에 등록할 아이템 검색
                this.show_modal5 = true;
            },
            closeModal(){//모달닫기
                this.show_modal =  false;
                this.show_modal2 =  false;
                this.show_modal3 =  false;
                this.show_modal4 =  false;
                this.show_modal5 =  false;
            },
            closeModal2(){//코스 등록,수정 모달 닫기
                this.show_modal2 =  false;

            },
            closeModal3(){//지역,카테,코스 아이템모달 닫기
                this.show_modal3 =  false;
                this.show_modal4 =  false;
                this.show_modal5 =  false;
            },
            insert:function(){// 테마 등록, 수정
                if(confirm(`테마를 ${this.set_mode == 'i' ? '생성': '수정'}하겠습니까?`)){
                    this.show_lodding = true;
					const json = {
						"mode" : this.set_mode,
						data : this.set_data,
					};
					axios.post(axios_url,
                        json,
                        {
                            headers: { 
                                'Content-type': 'application/x-www-form-urlencoded'
                            }
                        }).then((response) => {
                        this.show_lodding = false;
                        this.closeModal();
                        this.getList();
                        alert(`${this.set_mode == 'i' ? '생성': '수정'}이 완료되었습니다.`);
					});
				}
            },
            search:function(){
                this.show_lodding = true;
                let ch_continue = true;
                if(this.search_continue){
                    let arr_ch = false;

                    this.search_col.map((val)=>{
                         if(this.search_continue_col.indexOf(val) == -1){
                            arr_ch = true;
                         }
                    })

                    this.search_continue_col.map((val)=>{
                         if(this.search_col.indexOf(val) == -1){
                            arr_ch = true;
                         }
                    })

                    if(this.search_continue_text !== this.search_text || arr_ch)
                        ch_continue = true;
                    else 
                        ch_continue = false;
                }
                
                if(ch_continue){
                    this.set_list_page = 0;
                    this.search_continue = true;
                    this.search_continue_text = this.search_text;
                    this.search_continue_col = this.search_col;
                }       

                const json = {
                    "mode" : "c",
                    "search_col" : this.search_col,
                    "search_txt" : this.search_text,
                    "sido_idx" : this.search_sido,
                    "gugun_idx" : this.search_gugun,
                    "cate_idx" : this.search_cate,
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
                    if(response.data.list){
                        this.set_list = response.data.list;
                    }else{
                        this.set_list = [];
                    }
                    this.setPage(response.data.totalList);
                    this.show_lodding = false;
                });

            },
			del:function(idx){
                if(confirm(`선택하신 떠날생각 목록을 삭제하시겠습니까?`)){
                    this.show_lodding = true;
                    axios.get(`${axios_url}?mode=d&idx=${idx}`).then((response) => {
                        console.log(response);
                        this.show_lodding = false;
                        this.getList();
                        alert('삭제되었습니다.');
                    });
                };
			},
            search_select:function(mode){
                if(mode =='cate'){
                    const idx = this.search_col.indexOf('tmc_idx') 
                    if (idx > -1) 
                        this.search_col.splice(idx, 1);

                    if(this.search_cate)
                        this.search_col.push('tmc_idx');

                }else if(mode =='gugun'){
                    const idx = this.search_col.indexOf('trm_idx_gugun') 
                    if (idx > -1) 
                        this.search_col.splice(idx, 1);

                    if(this.search_gugun)
                        this.search_col.push('trm_idx_gugun');

                }else if(mode =='sido'){
                    const idx = this.search_col.indexOf('trm_idx_sido') 
                    if (idx > -1) 
                        this.search_col.splice(idx, 1);

                    if(this.search_sido){
                        let setMode = 'gugun';
                        let sidoIdx = this.search_sido;
                        this.search_col.push('trm_idx_sido');
                        this.set_gugun_idx_s = [];
                        this.set_gugun_name_s = [];
                        this.show_lodding = true;
                        axios.get(`${axios_url2}?mode=${setMode}${sidoIdx ? '&set_sido_idx='+sidoIdx : ''}`).then((response) => {
                            if(response.data.gugunIdx.length > 0)
                                this.set_gugun_idx_s  = response.data.gugunIdx;
                            if(response.data.gugunIdx.length > 0)
                                this.set_gugun_name_s = response.data.gugunName;
                            this.show_lodding = false;
                        });
                    }
                }
            },
            
            option_cate_list:function(table){ //선택한 코스 카테고리를 대상으로 검색 this.set_thema_ca_search_before
                if(this.set_thema_ca_search !== this.set_thema_ca_search_before || table){
                    this.set_thema_ca_cnt = 0;  
                    this.set_thema_ca_name = [];
                    this.set_thema_ca_idx = [];
                    this.set_thema_ca_search_before = this.set_thema_ca_search !== this.set_thema_ca_search_before ? this.set_thema_ca_search : this.set_thema_ca_search_before;
                }
                this.set_thema_ca_table = table ? table : this.set_thema_ca_table;
                if(!this.set_thema_ca_table){
                    alert('코스 카테고리를 선택해주세요!');
                    return false;
                }
                this.show_lodding = true;
                axios.get(`${axios_url4}?mode=c&table=${this.set_thema_ca_table}&row=${this.set_thema_ca_row}&cnt=${this.set_thema_ca_cnt}${this.set_thema_ca_search?'&ch='+this.set_thema_ca_search:''}`).then((response) => {
                    
                    console.log(response.data);
                    
                    if(response.data.idx){
                        this.set_thema_ca_cnt ++;
                        const saveArrIdx = this.set_thema_ca_idx;
                        const saveArrName = this.set_thema_ca_name;
                        response.data.idx.map(x => saveArrIdx.push(x));   
                        response.data.name.map(x => saveArrName.push(x));   
                        this.set_thema_ca_name = saveArrName;
                        this.set_thema_ca_idx = saveArrIdx;
                    }
                    else 
                        alert('불러 올 수 있는 목록이 없습니다.');

                    this.show_lodding = false;
                });
            },
            option_cate_set:function(idx){ //검색한 코스 선택
                this.set_thema_data.tml_table_idx = idx;
                this.set_thema_data.tml_table = this.set_thema_ca_table;
                this.set_thema_data.tml_name = this.set_thema_ca_name[this.set_thema_ca_idx.indexOf(idx)]
                alert('코스가 선택되었습니다.');
                this.closeModal3();
            },
            option_list:function(){ //테마에 소속된 코스 목록
                const idx = this.set_thema_data.tm_idx;
                this.show_lodding = true;
					const json = {
						"mode" : 'l',
                        "idx" : idx
					};
					axios.post(axios_url4,
                        json,
                        {
                            headers: { 
                                'Content-type': 'application/x-www-form-urlencoded'
                            }
                        }).then((response) => {
                        console.log(response);
                        
                        if(response.data.list){
                            this.set_thema_arr = response.data.list;
                        }else{
                            this.set_thema_arr = [];
                        }
                        this.show_lodding = false;
                });
            },
            option_insert:function(idx){ //코스생성
                if(this.set_thema_data.tml_table_idx == undefined){
                    alert('코스를 선택해주세요.')
                }else if(confirm(`테마를 ${this.set_thema_mode == 'i' ? '생성': '수정'}하겠습니까?`)){
                    this.show_lodding = true;
					const json = {
						"mode" : this.set_thema_mode,
						"data" : this.set_thema_data,
					};
					axios.post(axios_url4,
                        json,
                        {
                            headers: { 
                                'Content-type': 'application/x-www-form-urlencoded'
                            }
                        }).then((response) => {
                            console.log(response);
                            this.option_list();
                            this.closeModal2();
                            this.show_lodding = false;
					    });
				}
            },
            option_update:function(idx){ //코스수정
                alert('옵션의 정보를 업데이트 합니다.');
            },
            option_delete:function(idx){ //코스삭제
                if(confirm(`코스를 삭제하시겠습니까?`)){
                    this.show_lodding = true;
                    axios.get(`${axios_url4}?mode=d&idx=${idx}`).then((response) => {
                        this.show_lodding = false;
                        this.option_list();
                        alert('삭제되었습니다.');
                    });
                };
            },
            cate_search:function(){ //테마 카테고리 검색
                this.show_lodding = true;
                axios.get(`${axios_url3}?mode=c`).then((response) => {
                    this.set_cate_idx = response.data.cateIdx;
                    this.set_cate_name = response.data.cateName;
                    this.show_lodding = false;
                });
            },
            cate_set:function(idx){ //테마 카테고리 선택
                this.set_data.tmc_idx = idx;
            },
            area_search:function(mode,sidoIdx){ //지역 카테고리 검색
                let setMode = '';
                if(mode){
                    setMode = mode;
                }else if(this.trm_idx_sido){
                    setMode = 'all';
                }else if(sidoIdx){
                    setMode = 'gugun'
                }else{
                    setMode = 'sido';
                }
                this.show_lodding = true;
                axios.get(`${axios_url2}?mode=${setMode}${sidoIdx ? '&set_sido_idx='+sidoIdx : ''}`).then((response) => {
                    if(response.data.sidoIdx.length > 0)
                        this.set_sido_idx  = response.data.sidoIdx;
                    if(response.data.sidoIdx.length > 0)
                        this.set_sido_name = response.data.sidoName;
                    if(response.data.gugunIdx.length > 0)
                        this.set_gugun_idx  = response.data.gugunIdx;
                    if(response.data.gugunIdx.length > 0)
                        this.set_gugun_name = response.data.gugunName;

                    this.show_lodding = false;
                });
            },
            area_set:function(idx,target){ //지역 카테고리 선택
                if(target =='sido'){
                    this.set_data.trm_idx_sido=idx;
                    this.area_search('gugun',idx);
                    this.set_data.trm_idx_gugun = undefined;
                }
                else if(target =='gugun'){
                    this.set_data.trm_idx_gugun = idx;
                }
            },
			getList:function(e){ //테마 목록호출
					const json = {
						"mode" : "l",
                        "sido_idx" : this.search_sido,
                        "gugun_idx" : this.search_gugun,
                        "cate_idx" : this.search_cate,
                        "search_col" : this.search_col,
                        "search_txt" : this.search_text,
						"set_list_row" : this.set_list_row,
						"set_list_page" : this.set_list_page ,
						"set_list_total" : this.set_list_total,
					};
					//setting url 
					let urlGetData = '';
					urlGetData = setParameterUrl(json);
					const url = `${axios_url}?${urlGetData}`;
					const arr = [];
					
					//axios data
					axios.get(url).then((response)=> {
                        if(response.data.list){
						    this.set_list = response.data.list;
                        }else{
						    this.set_list = [];
                        }
                        this.setPage(response.data.totalList);
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


<?php
include_once ('./_tail.php');
?>
