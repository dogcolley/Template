<?php
$sub_menu = "970100";
include_once('./_common.php');
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
auth_check($auth[$sub_menu],"r");

$g5['title'] = '테마카테관리';
include_once('./_head.php');

add_javascript('<script src="https://cdn.jsdelivr.net/npm/vue@2.6.0"></script>');
add_javascript('<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>');
add_javascript('<script src="https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.8.34/browser.js"></script>');

?>

<section id="themaCate">
	<h2 class="h2_frm">테마 카테고리 리스트</h2>
	<div>
		<div class="tbl_head01 tbl_wrap ">
			<table>
				<caption>테마 카테고리 리스트</caption>
				<thead>
					<tr>
						<th scope="col">No.</th>
						<th scope="col">Idx</th>
						<th scope="col">카테고리이름</th>
						<th scope="col">생성일</th>
						<th scope="col">수정일</th>
						<th scope="col" style="width:80px">수정</th>
						<th scope="col" style="width:80px">삭제</th>
					</tr>
				</thead>
				<tbody>
					<tr class="bg0"  v-for="(list,index) in set_list" :key="index" >
						<td>
							{{index+1}}
						</td>
						<td>
							{{list.tmc_idx}}
						</td>
						<td>
                            <input type="text" v-model="cate_name_arr[index]" class="frm_input">
						</td>
						<td>
							{{list.tmc_reg_date}}
						</td>
						<td>
							{{list.tmc_update_date}}
						</td>
						<td><button class="btn_02 btn" <?php if(!auth_check($auth[$sub_menu],"w",true)){?>@click="updateCate(list.tmc_idx,index)"<?php }else{?>@click="alert('수정권한이 없습니다.')"<?php } ?>>수정</button></td>
						<td><button class="btn_02 btn" <?php if(!auth_check($auth[$sub_menu],"d",true)){?>@click="delCate(list.tmc_idx)"<?php }else{?>@click="alert('삭제권한이 없습니다.')"<?php } ?>>삭제</button></td>
					</tr>

					<tr v-if="set_list.length == 0">
						<td colspan="7" style="padding:20px 0 ">
							자료가 존재하지 않습니다.
						</td>					
					</tr>
				</tbody>
			</table>
		</div>
	</div>

    <h2 class="h2_frm" >테이블 추가</h2>
	<div>
		<form v-on:submit.prevent="setCate()">
			<div class="tbl_frm01 tbl_wrap">
				<table>
				<caption>테이블 설정</caption>
				<colgroup>
					<col>
					<col>
					<col>
				</colgroup>
				<tbody>
					<tr>
						<th scope="row"><label for="set_cate_name">카테고리 이름<strong class="sound_only">필수</strong></label></th>
						<td><input type="text" v-model="set_cate_name" id="set_cate_name"  class="frm_input" ></td>
						<td>
							<input type="submit" value="기본환경 추가" class="btn_submit btn" accesskey="s">
						</td>
					</tr>
					</tbody>
				</table>
			</div>
		</form>	
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

    const axios_url = './_ajax/thema_cate.php';

	const themaCate = new Vue({
		mode: 'themaCate',
		el: '#themaCate',
		data: {
			set_list : [],
            cate_name_arr  : [],
            set_cate_name : '',
		},
		created: function(){
				this.getList();
		},
		methods:{
            getList:function(e){
					//setting json
					const json = {
						"mode" : "r"
					};
					//setting url 
					let urlGetData = '';
					urlGetData = setParameterUrl(json);
					const url = `${axios_url}?${urlGetData}`;
					const arr = [];
					const VueThis = this;
					
					//axios data
					axios.get(url).then(function(response) {
                        const array = new Array();
                        for(let i=0; i < response.data.list.length;i++){
                            array.push(response.data.list[i].tmc_name);
                        }
						VueThis.set_list = response.data.list;
						VueThis.cate_name_arr = array;
					});
			},
            setCate:function(e){
                if(!this.set_cate_name)
                    alert('카테고리 이름을 등록해주세요.');
                else{
                    const json = {
						"mode" : "w",
                        "setCate" : this.set_cate_name
					};
					//setting url 
					let urlGetData = '';
					urlGetData = setParameterUrl(json);
					const url = `${axios_url}?${urlGetData}`;
					const arr = [];
					const VueThis = this;
					
					//axios data
					axios.get(url).then(function(response) {
                        if(response.data.status == 'ok'){
                            VueThis.getList();
                            alert('생성완료');
                        }else{
                            alert('생성실패 다시 시도해주세요.')
                        }
					});
                }
            },
            updateCate:function (idx,i) {
                
                //setting json
                const json = {
                    "mode" : "u",
                    "idx" : idx,
                    "setCate" : this.cate_name_arr[i]
                };

                //setting url 
                let urlGetData = '';
                urlGetData = setParameterUrl(json);
                const url = `${axios_url}?${urlGetData}`;
                const arr = [];
                const VueThis = this;
                
                //axios data
                axios.get(url).then(function(response) {
                    if(response.data.status == 'ok'){
                        VueThis.getList();
                        alert('수정완료');
                    }else{
                        alert('수정실패 다시 시도해주세요.')
                    }
                });
            },
            delCate:function (idx){
                if(confirm('삭제하겠습니까?')){
                    //setting json
                    const json = {
                        "mode" : "d",
                        "idx" : idx,
                    };

                    //setting url 
                    let urlGetData = '';
                    urlGetData = setParameterUrl(json);
                    const url = `${axios_url}?${urlGetData}`;
                    const arr = [];
                    const VueThis = this;
                    
                    //axios data
                    axios.get(url).then(function(response) {
                        if(response.data.status == 'ok'){
                            VueThis.getList();
                            alert('삭제완료');
                        }else{
                            alert('삭제실패 다시 시도해주세요.')
                        }
                    });
                }


            }
		}
	})

</script>

<?php
include_once ('./_tail.php');
?>