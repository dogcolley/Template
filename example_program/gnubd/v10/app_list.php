<?php
$sub_menu = "951000";
include_once('./_common.php');
auth_check($auth[$sub_menu],"r");


$g5['title'] = '앱관리';
include_once('./_head.php');

if($member['mb_id'] !=='super'){
	alert('접근권한이 없습니다.');
}

//make adroid_token_table 
if(!sql_query(" DESC `g5_push_android` ", false)) {
    sql_query(" CREATE TABLE IF NOT EXISTS `g5_push_android` (
	  `ad_id` int(11) NOT NULL AUTO_INCREMENT,
	  `mb_id` varchar(20) NOT NULL,
	  `ad_token` text NOT NULL,
	  `ad_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	  PRIMARY KEY (`ad_id`),
	  KEY `mb_id` (`mb_id`)
	) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8; ", false);
}


//make ios_token_table 
if(!sql_query(" DESC `g5_push_ios` ", false)) {
    sql_query(" CREATE TABLE IF NOT EXISTS `g5_push_ios` (
	  `ad_id` int(11) NOT NULL AUTO_INCREMENT,
	  `mb_id` varchar(20) NOT NULL,
	  `ad_token` text NOT NULL,
	  `ad_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	  PRIMARY KEY (`ad_id`),
	  KEY `mb_id` (`mb_id`)
	) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8; ", false);
}

//make push_config  
if(!sql_query(" DESC `g5_push_config` ", false)) {
    sql_query("CREATE TABLE IF NOT EXISTS `g5_push_config` (
  `config_id` int(11) NOT NULL AUTO_INCREMENT,
  `config_os` varchar(50) NOT NULL,
  `config_key` varchar(255) NOT NULL,
  `config_value` varchar(255) NOT NULL,
  `config_tit` varchar(255) NOT NULL,
  `config_description` mediumtext,
  `config_use` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`config_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;", false);
}


//make push_msg_log 
if(!sql_query(" DESC `g5_push_msg` ", false)) {
    sql_query(" CREATE TABLE IF NOT EXISTS `g5_push_msg` (
	  `push_id` int(11) NOT NULL AUTO_INCREMENT,
	  `push_tit` varchar(50) NOT NULL,
	  `push_content` text NOT NULL,
	  `push_url` varchar(50) NULL DEFAULT '',
	  `push_os` varchar(50) NOT NULL DEFAULT 'all',
	  `push_cnt` int NOT NULL DEFAULT 0,
	  `push_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	  PRIMARY KEY (`push_id`),
	  KEY `mb_id` (`push_os`)
	) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8; ", false);
}


?>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.0"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.8.34/browser.js"></script>

<section id="pushConfig">
	<h2 class="h2_frm">앱 기본환경 </h2>
	<div>
		<div class="tbl_head01 tbl_wrap ">
			<table>
				<caption>안드로이드 토큰유저목록</caption>
				<thead>
					<tr>
						<th scope="col" id="th_img">설정명</th>
						<th scope="col" id="th_sido">설정설명</th>
						<th scope="col" id="th_pc_title">설정키</th>
						<th scope="col" id="th_pc_title">설정값</th>
						<th scope="col" id="th_pc_title">설정os</th>
						<th scope="col" id="th_pc_title">변경</th>
						<th scope="col" id="th_pc_title">삭제</th>
					</tr>
				</thead>
				<tbody>
					<tr class="bg0"  v-for="(idx,index) in arr_id" :key="index" >
						<td><input type="text" v-model="arr_tit[index]" id="tit"  class="frm_input" ></td>
						<td><input type="text" v-model="arr_des[index]" id="tit"  class="frm_input" ></td>
						<td><input type="text" v-model="arr_key[index]" id="tit"  class="frm_input" ></td>
						<td><input type="text" v-model="arr_val[index]" id="tit"  class="frm_input" ></td> 
						<td>
							<select name="push_os" v-model="arr_os[index]" id="push_os">
								<option value="ALL">전체</option>	
								<option value="ANDROID">안드로이드</option>	
								<option value="IOS">IOS</option>	
							</select>
						</td>
						<td><button class="btn_02 btn" @click="chageConfig(idx,index)">변경</button></td>
						<td><button class="btn_02 btn" @click="delConfig(idx)">삭제</button></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

    <h2 class="h2_frm">앱 기본환경 추가</h2>
	<div>
		<form v-on:submit.prevent="addConfig()">
			<div class="tbl_frm01 tbl_wrap">
				<table>
				<caption>앱 기본환경 설정</caption>
				<colgroup>
					<col class="grid_4">
					<col>
					<col class="grid_4">
					<col>
				</colgroup>
				<tbody>
					<tr>
						<th scope="row"><label for="mk01_key">Key<strong class="sound_only">필수</strong></label></th>
						<td><input type="text" v-model="set_key" id="tit"  class="frm_input" ></td>
						<th scope="row"><label for="mk01">value<strong class="sound_only">필수</strong></label></th>
						<td><input type="text" v-model="set_value"  id="value"  class="frm_input" ></td>
					</tr>
					<tr>
						<th scope="row"><label for="mk01">tit</label></th>
						<td><input type="text" v-model="set_tit" id="tit" class="frm_input" ></td>
						<th scope="row"><label for="mk01">description</label></th>
						<td><input type="text" v-model="set_description" id="tit" class="frm_input" ></td>
					</tr>
					<tr>
						<th scope="row"><label for="mk01">os</label></th>
						<td>
							<select name="push_os" v-model="set_os" id="push_os">
								<option value="ALL">전체</option>	
								<option value="ANDROID">안드로이드</option>	
								<option value="IOS">IOS</option>	
							</select>
						</td>
						<th scope="row"><label for="mk01">saveData</label></th>
						<td>
							<input type="submit" value="앱 기본환경 추가" class="btn_submit btn" accesskey="s">
						</td>
					</tr>
					</tbody>
				</table>
			</div>
		</form>	
	</div>
	
</section>

<section id="anc_cf_basic">
    <h2 class="h2_frm">안드로이드 푸시 보내기</h2>
	<form method="post" action="./expoPush/android_message_update.php">
		<div class="tbl_frm01 tbl_wrap">
			<table>
			<caption>홈페이지 기본환경 설정</caption>
			<colgroup>
				<col class="grid_4">
				<col>
				<col class="grid_4">
				<col>
			</colgroup>
			<tbody>
			<tr>
				<th scope="row"><label for="tit">제목<strong class="sound_only">필수</strong></label></th>
				<td colspan="3"><input type="text" name="tit" value="<?php echo $tit ?>" id="tit" required class="required frm_input" ></td>
			</tr>
			<tr>
				<th scope="row"><label for="url">이동URL</th>
				<td colspan="3"><input type="text" name="url" value="<?php echo $url ?>" id="url"  class=" frm_input" ></td>
			</tr>
			<tr>
				<th scope="row"><label for="content">내용<strong class="sound_only">필수</strong></label></th>
				<td colspan="3"><input type="text" name="content" value="<?php echo $content ?>" id="content" required class="required frm_input" ></td>
			</tr>
			<tr>
				<th scope="row"><label for="mode">전송대상<strong class="sound_only">필수</strong></label></th>
				<td colspan="3">
					<select name="mode" id="mode">
						<option value="all">전체유저</option>
						<option value="one">특정유저</option>
					</select>
				</td>
			</tr>
			<tr class="one_input" style="display:none">
				<th scope="row"><label for="recipient">대상토큰<strong class="sound_only">필수</strong></label></th>
				<td colspan="3"><input type="text" name="recipient" value="<?php echo $recipient  ?>" id="recipient" required class="required frm_input" ></td>
			</tr>
			<tr class="one_input" style="display:none">
				<th scope="row"><label for="channelName">대상아이디<strong class="sound_only">필수</strong></label></th>
				<td colspan="3"><input type="text" name="channelName" value="<?php echo 'guest' ?>" id="channelName" required class="required frm_input" ></td>
			</tr>
			</tbody>
			</table>
			<div class="btn_fixed_top btn_confirm" style="right:120px">
				<input type="submit" value="푸시 보내기" class="btn_submit btn" accesskey="s">
			</div>
		</div>
	</form>	
</section>

<section id="listAndroid">
	<h2 class="h2_frm">안드로이드 토큰유저목록</h2>
	<div class="tbl_head01 tbl_wrap">
    <table>
		<caption>안드로이드 토큰유저목록</caption>
		<thead>
			<tr>
				<?/*
				<th scope="col">
					<label for="chkall" class="sound_only">상품 전체</label>
					<input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
				</th>
				*/?>
				<th scope="col">번호</th>
				<th scope="col" id="th_img">토큰값</th>
				<th scope="col" id="th_sido">유저</th>
				<th scope="col" id="th_pc_title">등록시간</th>
				<th scope="col">OS</th>
			</tr>
		</thead>
		<tbody>
			<tr class="bg0"  v-for="(items,index) in listArr" :key="index">
				<td v-for="(item,index2) in items" :key="index2">
					{{item}}
				</td>
				<td>Android</td>
			</tr>
		</tbody>
    </table>

	<nav class="pg_wrap">
		<span class="pg">
			<button href="#" @click="startPage" class="pg_page pg_start">처음</button>
			<button href="#" @click="prevPage"  class="pg_page pg_prev">이전</button>
			<button @click="loadPage('ad_list','clickPage',pages)"class="pg_page" :class="pages == page ? 'pg_current' : ''"  <? //pg_current?> v-for="(pages,index) in pageArr" :key="index">
			{{pages}}
			</button>
			<button href="#" @click="nextPage"  class="pg_page pg_next">다음</button>
			<button href="#" @click="endPage" class="pg_page pg_end">맨끝</button>
		</span>
	</nav>
</div>
	<?/*
	<div class="btn_fixed_top btn_confirm" style="right:230px">
		<input type="submit" value="토큰유저 선택삭제" class="btn_submit btn" accesskey="s">
	</div>
	*/?>
</section>

<?/*
<section id="pushAdList">
	<h2 class="h2_frm">푸시기록목록</h2>
	<div class="tbl_head01 tbl_wrap">
    <table>
    <caption>푸시기록목록</caption>
		<thead>
			<tr>
				<th scope="col">번호</th>
				<th scope="col" id="th_img">토큰값</th>
				<th scope="col" id="th_sido">유저</th>
				<th scope="col" id="th_gugun">타이틀</th>
				<th scope="col" id="th_sijang">내용</th>
				<th scope="col" id="th_store">경로설정</th>
				<th scope="col" id="th_pc_title">전송시간</th>
				<th scope="col">OS</th>
			</tr>
		</thead>
		<tbody>

		</tbody>
    </table>
</div>
</section>
*/?>

<script type="text/babel">
	const axios_url = './_ajax/expo/app_list_ajax.php';
	
	const pushConfig = new Vue({
		mode: 'production',
		el: '#pushConfig',
		data: {
			arr_id : [],
			arr_key : [],
			arr_val : [],
			arr_des : [],
			arr_tit : [],
			set_os : [],
			set_key : '',
			set_value : '',
			set_tit : '',
			set_description : '',
			set_os : 'ALL',
		},
		created: function(){
				//console.log('생성');
				this.getConfig();
		},
		methods:{
			addConfig:function(e){
				if(!this.set_key)
					alert('key값을 입력해주세요');
				else if(!this.set_value)
					alert('설정값을 입력해주세요');
				else if(!this.set_description)
					alert('설명을 입력해주세요');
				else if(!this.set_tit)
					alert('값을 입력해주세요');
				else {
					const VueThis = this;
					if(confirm('설정을 추가하시겠습니까?')){
						//setting json
						const json = {
							"mode" : "config_insert",
							"tit" : VueThis.set_tit,
							"os" : VueThis.set_os,
							"key" : VueThis.set_key,
							"value" : VueThis.set_value,
							"des" : VueThis.set_description,
						};
						//setting url 
						let urlGetData = '';
						Object.keys(json).forEach(function(key){
							urlGetData += `${key}=${json[key]}&`;
						});
						urlGetData = urlGetData.slice(0,-1); 
						const url = `${axios_url}?${urlGetData}`;
						//axios data
						axios.get(url).then(function(response) {
							if(response.data.state == "success"){
								alert('생성완료 했습니다.');
								VueThis.getConfig();
							}else{
								alert('오류입니다. 다시 시도해주세요');
							}
						});
					}
				}
			},
			getConfig:function(e){
					//setting json
					const json = {
						"mode" : "config_get"
					};
					//setting url 
					let urlGetData = '';
					Object.keys(json).forEach(function(key){
						urlGetData += `${key}=${json[key]}&`;
					});
					urlGetData = urlGetData.slice(0,-1); 
					const url = `${axios_url}?${urlGetData}`;
					const arr = [];
					const VueThis = this;
					
					//axios data
					axios.get(url).then(function(response) {
						VueThis.arr_id = response.data.config_id;
						VueThis.arr_key = response.data.config_key;
						VueThis.arr_val = response.data.config_val;
						VueThis.arr_des = response.data.config_des;
						VueThis.arr_tit = response.data.config_tit;
						VueThis.arr_os = response.data.config_os;
					});
			},
			chageConfig:function(idx,arrId){
				if(!this.arr_key[arrId])
					alert('key값을 입력해주세요');
				else if(!this.arr_tit[arrId])
					alert('설정값을 입력해주세요');
				else if(!this.arr_des[arrId])
					alert('설명을 입력해주세요');
				else if(!this.arr_val[arrId])
					alert('값을 입력해주세요');
				else {
					const VueThis = this;
					if(confirm('설정을 변경하시겠습니까?')){
						//setting json
						const json = {
							"mode" : "config_chage",
							"tit" : VueThis.arr_tit[arrId],
							"os" : VueThis.arr_os[arrId],
							"key" : VueThis.arr_key[arrId],
							"value" : VueThis.arr_val[arrId],
							"des" : VueThis.arr_des[arrId],
							"idx" : idx
						};
						//setting url 
						let urlGetData = '';
						Object.keys(json).forEach(function(key){
							urlGetData += `${key}=${json[key]}&`;
						});
						urlGetData = urlGetData.slice(0,-1); 
						const url = `${axios_url}?${urlGetData}`;
						
						//axios data
						axios.get(url).then(function(response) {
							console.log(response);
							if(response.data.state == "success"){
								alert('변경완료 했습니다.');
								VueThis.getConfig();
							}else{
								alert('오류입니다. 다시 시도해주세요');
							}
						});
					}
				}

			},
			delConfig:function(idx){
				const VueThis = this;
					if(confirm('삭제하시겠습니까?')){
						//setting json
						const json = {
							"mode" : "config_delate",
							"idx" : idx,
						};
						//setting url 
						let urlGetData = '';
						Object.keys(json).forEach(function(key){
							urlGetData += `${key}=${json[key]}&`;
						});
						urlGetData = urlGetData.slice(0,-1); 
						const url = `${axios_url}?${urlGetData}`;
						
						//axios data
						axios.get(url).then(function(response) {
							if(response.data.state == "success"){
								alert('삭제완료 했습니다.');
								VueThis.getConfig();
							}else{
								alert('오류입니다. 다시 시도해주세요');
							}
						});
					}

			}
		}
	})

	const listAndroid = new Vue({
		mode: 'production',
		el: '#listAndroid',
		data: {
			page:1,
			pageRow:15,
			pagePiece : 5,
			pageTotal : 0,
			pageItems : 0,
			pagePieceMax : 0,
			pagePieceNow : 1,
			pageArr : [],
			listArr : [],
		},
		created: function(){
			this.loadPage();
		},
		methods:{
			loadPage: function(mode,action,pageNum){
				//setting mode
				if(action == 'clickPage'){
					this.page = pageNum;
				}else if(action == 'chagePiece'){
					this.pagePieceNow = Math.ceil(this.page / this.pagePiece);
				}

				//setting json
				const json = {
					"mode" : mode ? mode : "ad_list",
					"page" : this.page,
					"pageRow" : this.pageRow,
					"pagePiece" : this.pagePiece,
					"pagePieceNow" : this.pagePieceNow,
					"action" : action ? action : 'load',
				};
				
				//setting url 
				let urlGetData = '';
				Object.keys(json).forEach(function(key){
					urlGetData += `${key}=${json[key]}&`;
				});
				urlGetData = urlGetData.slice(0,-1); 
				const url = `${axios_url}?${urlGetData}`;
				const arr = [];
				const VueThis = this;
						console.log(url);

				//axios data
				axios.get(url).then(function(response) {
					console.log(response)
					for(let item in response.data.list){
						arr.push(response.data.list[item]);
					}
					VueThis.listArr = arr;
					VueThis.pageItems = response.data.pageItems;
					VueThis.CreatePage(action);
				});

				//create pageing
			},
			CreatePage: function(setNow){
				this.pageTotal = Math.ceil(this.pageItems  / this.pageRow);
				this.pagePieceMax =  Math.ceil(this.pageTotal / this.pagePiece);
				const arr = [];
				for(let i=0; i< this.pagePiece; i++){
					if(((this.pagePieceNow - 1) * this.pagePiece) + i + 1 <= this.pageTotal)
						arr.push(((this.pagePieceNow - 1) * this.pagePiece) + i + 1);
				}
				this.pageArr = arr; 
			},
			nextPage: function(){
				if(this.page < this.pageTotal){
					this.page += 1;
					this.loadPage('ad_list','chagePiece');
				}
			},
			prevPage: function(){
				if(this.page > 1){
					this.page -= 1;
					this.loadPage('ad_list','chagePiece');
				}
			},
			startPage: function(){
				this.page = 1;
				this.loadPage('ad_list','chagePiece');
			},
			endPage: function(){
				this.page = this.pageTotal;
				this.loadPage('ad_list','chagePiece');
			}
		}
	})

	$(function(){
		$('#mode').on('change',function(){
			if($(this).val() =="one"){
				$('.one_input').show();
			}else{
				$('.one_input').hide();
			}
		});
	});

</script>

<?
include_once ('./_tail.php');
?>