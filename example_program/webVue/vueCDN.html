<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

//$wset add front 

/*js*/
add_javascript('<script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.auto.js"></script>',0); //promise.auto.js 
add_javascript('<script src="https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.8.34/browser.js"></script>',0); //bable

/* use Vue js  */
add_javascript('<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>',0);
add_javascript('<script src="https://unpkg.com/vuex@3.1.3/dist/vuex.js"></script>',0);

/*use vue vuetify.js */
add_stylesheet('<link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">',0);
add_stylesheet('<link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">',0);
add_javascript('<script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>',0); 

/*use vue color picker type vue guide cdn*/
add_stylesheet('<link href="https://unpkg.com/@radial-color-picker/vue-color-picker/dist/vue-color-picker.min.css" rel="stylesheet">',0);
add_javascript('<script src="https://unpkg.com/@radial-color-picker/vue-color-picker@2.1.0/dist/vue-color-picker.min.js"></script>',0); 

/*use */
//add_stylesheet('<link href="https://uicdn.toast.com/tui-color-picker/latest/tui-color-picker.css" rel="stylesheet">',0);
//add_javascript('src="https://uicdn.toast.com/tui-color-picker/latest/tui-color-picker.js""></script>',0); 

/* ather js */
add_javascript('<script src="https://unpkg.com/axios/dist/axios.min.js"></script>',0); //ajax 대신 axios

?>




<div class="<?=$widget_id ?>" id="<?=$widget_id ?>">
    <?//print_r2($wset)?>
    이걸응용하면 widget 설정 UI를 더 좋게 만들지 않을까?
    <div id="<?=$widget_id ?>Vue">
        <v-app id="inspire">
            <v-container fluid>
                <v-row>
                    <v-col cols="12">
                        <h3 ref="radio" class="headline">Privew</h3>
                    </v-col>
                    <v-col cols="12" :style="PrivewStyle">
                        {{text}}
                    </v-col>
                </v-row>
                   
                <v-row>
                    <v-col cols="12">
                        <h3 ref="radio" class="headline">Setting</h3>
            
                        <v-radio-group v-model="type" row>
                            <v-radio label="font" value="font"></v-radio>
                        </v-radio-group>
            
                        <v-text-field
                            v-if="type === 'font'"
                            v-model="text"
                            type="text"
                            v-on:change="ChagePreView"
                            label="여기에 텍스트를 입력해주세요"
                        ></v-text-field>
                    </v-col>
            
                    <v-col cols="12">
                    <h3 class="headline">Options</h3>
            
                    <v-select
                        :items="fontOptions"
                        label="fontOptions"
                        v-model="fontOption"
                    ></v-select>
                    </v-col>

                    <v-col cols="12" v-if="fontOption=='기본'"> 
                        <v-slider
                            v-model="fontSize"
                            min="10"
                            max="40"
                            label="fontSize"
                            thumb-label
                        ></v-slider>
                        <v-select
                            :items="fontWeights"
                            label="fontWeights"
                            v-model="fontWeight"
                            menu-props="auto, overflowY"
                        ></v-select>
                        <v-select
                            :items="TextAligns"
                            label="TextAlign"
                            v-model="TextAlign"
                            menu-props="auto, overflowY"
                        ></v-select>
                    </v-col>

                    <v-col cols="12" v-if="fontOption=='그림자'"> 
                        <v-slider
                            v-model="fontShdowX"
                            min="-50"
                            max="100"
                            label="그림자 - x축"
                            thumb-label
                        ></v-slider>
                        <v-slider
                            v-model="fontShdowY"
                            min="-50"
                            max="100"
                            label="그림자 - Y축"
                            thumb-label
                        ></v-slider>
                        <v-slider
                            v-model="fontShdowBlur"
                            min="-50"
                            max="100"
                            label="그림자 굵기 축"
                            thumb-label
                        ></v-slider>
                    </v-col>


                    <v-col cols="12" v-if="fontOption=='자간,행간'"> 
                        <v-slider
                            v-model="letterSpacing"
                            min="-50"
                            max="100"
                            label="자간"
                            thumb-label
                        ></v-slider>
                        <v-slider
                            v-model="lineHeight"
                            min="-50"
                            max="100"
                            label="행간"
                            thumb-label
                        ></v-slider>
                    </v-col>
                    
                    <v-row v-if="fontOption=='컬러'">
                        <v-col cols="12" >
                            <v-btn
                                v-for="t in CLtypes"
                                :key="t"
                                class="my-4"
                                block
                                @click="CLtype = t"
                            >
                                {{ t }}
                            </v-btn>
                        </v-col>
                        <v-col class="d-flex justify-center">
                            <v-color-picker v-model="CLcolor"></v-color-picker>
                        </v-col>
                    </v-row>


                    <v-col cols="12" >
                        <form action="<?=G5_URL?>" method="get">
                        <input type="hidden" v-model="setWidget" name="wdiget">
                        <v-btn
                            type="submit"
                            block
                            color="primary"
                        >
                            SAVE
                        </v-btn>
                        </form>
                    </v-col>
                </v-row>


                
                
            </v-container>
        </v-app>
    </div>
    <?/*
    <div id="<?=$widget_id ?>Vue">
        <button type="button" id="testBtn">제이쿼리 연동확인 이벤트</button>
        <button type="button" @Click ="test01">Vue 연동확인 이벤트</button>
        <button type="button" @Click ="getAPI">Vuex 연동확인 이벤트(mutations)</button>
        <div  ref='setDom01' id="DomDiv">
            여기엔 돔에 대한 직접제어가 들어가는부분입니다.
        </div>
        {{getWidget.test}}
    </div>
    */?>
</div>
<script type="text/babel">
//jsh, dogcolley,장석환 2020-03-13 Test Vue(Dom,Compoment) + Vuex(data) + Vuetify(style,motion) + phpData(DB and apache)
//기존 php DV분들이 개발하기 편하게 변경하여 적용시켜 놓았다.

/*
    -셋팅방법 상단에 addscript로 Vue와 ES6의 셋팅을 직접 해줬습니다!
    -참고 : 비동기 통신[악시오스], 데이터관리[Vuex], 돔관리[Vue] //저는 프레임워크의 Vue기능은 쓰지않고 라이브러리의 기능을 사용했습니다.

    -목차
    1.const,let으로 php의 데이터들을 셋팅하여 나열해줍니다.
    2.vuex로 스토어를 만들어 데이터와 함수를 지정해줍니다.
    3.vue로 Dom처리를 해줍니다.
    4.vuetify.js로 구현하기힘든 UI를 간편하게 만들어줍니다.
*/


const setApi = "<?=$wset['sld_aixos_link']?>";
const setId = "#<?=$widget_id ?>Vue";
const setMethod = <?=$sld_aixos_method ? $sld_aixos_method : 'false' ?>;
const setCrowing = <?echo $sld_aixos_crawing == 0 ? 'false' : 'true' ?>;
//const setData = <?echo $sld_aixos_data01 ? $sld_aixos_data01 : 'NODATA'?>;

const easings = {
  linear: '',
  easeInQuad: '',
  easeOutQuad: '',
  easeInOutQuad: '',
  easeInCubic: '',
  easeOutCubic: '',
  easeInOutCubic: '',
  easeInQuart: '',
  easeOutQuart: '',
  easeInOutQuart: '',
  easeInQuint: '',
  easeOutQuint: '',
  easeInOutQuint: ''
}


const store = new Vuex.Store({
    //확장성을 위한 vuex 중앙 데이터 처리장치
    strict: true,
    state : { // like data();
        getWidget: {
            test: 0,
            setApi : "<?=$wset['sld_aixos_link']?>",
            setId : "<?=$widget_id ?>",
            setMethod : <?=$sld_aixos_method ? $sld_aixos_method : 'false' ?>,
            setCrowing : <?echo $sld_aixos_crawing == 0 ? 'false' : 'true' ?>
        },
        gestData : new Object(),
    },
    computed : { // event change created 
        
    },
    components: {
    },
    getters:{ // double 방지해주기 data의 중복 겹침 방지
        doneTodosCount: (state, getters) => {
            return getters.getWidget.test.length
        }
    },
    mutations:{ //methods
        API(state,n){
            this.state.getWidget.test ++;
            console.log('ok');
            console.log(this.state.getWidget.test);
        },
        functionB(state,n){},
        functionC(state,n){},
        functionD(state,n){},
    },
    action:{ //function async and complete function

    },
    modules:{ // 여러개의 store 정보들을 불러올때
    }
});


const app = new Vue({
    mode: 'production',
    el:setId,
    name: 'LayoutsDemosBaselineFlipped',
    vuetify: new Vuetify(),
    props: {
    },
    data: () => ({
            setWidget:'SendData',
            PrivewStyle:'',
            type: 'font',
            text: '여기에 텍스트를 입력해주세요.',
            fontSize:16,
            fontOption:'기본',
            fontWeight:null,
            TextAlign:null,
            fontShdowX:'',
            fontShdowY:'',
            fontShdowBlur:'',
            letterSpacing:'', 
            lineHeight:'',
            fontOptions:[
                {text:'기본'},
                {text:'그림자'},
                {text:'자간,행간'},
                {text:'컬러'},
            ],
            fontWeights:[
                {text:'300'},
                {text:'400'},
                {text:'500'},
                {text:'600'},
                {text:'700'},
            ],
            TextAligns:[
                {text:'center'},
                {text:'left'},
                {text:'right'},
            ],
            states: [
                'Alabama', 'Alaska', 'American Samoa', 'Arizona',
                'Arkansas', 'California', 'Colorado', 'Connecticut',
                'Delaware', 'District of Columbia', 'Federated States of Micronesia',
                'Florida', 'Georgia', 'Guam', 'Hawaii', 'Idaho',
                'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky',
                'Louisiana', 'Maine', 'Marshall Islands', 'Maryland',
                'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi',
                'Missouri', 'Montana', 'Nebraska', 'Nevada',
                'New Hampshire', 'New Jersey', 'New Mexico', 'New York',
                'North Carolina', 'North Dakota', 'Northern Mariana Islands', 'Ohio',
                'Oklahoma', 'Oregon', 'Palau', 'Pennsylvania', 'Puerto Rico',
                'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee',
                'Texas', 'Utah', 'Vermont', 'Virgin Island', 'Virginia',
                'Washington', 'West Virginia', 'Wisconsin', 'Wyoming'
            ],
            CLtypes: ['hex', 'hexa', 'rgba', 'hsla', 'hsva'],
            CLtype: 'hex',
            hex: '#FF00FF',
            hexa: '#FF00FFFF',
            rgba: { r: 255, g: 0, b: 255, a: 1 },
            hsla: { h: 300, s: 1, l: 0.5, a: 1 },
            hsva: { h: 300, s: 1, v: 1, a: 1 },
    }),
    computed: {
        getWidget () {
            return store.state.getWidget 
        },
        CLcolor: {
            get () {
                return this[this.CLtype]
            },
            set (v) {
                this[this.CLtype] = v
            },
        },
        showColor () {
            if (typeof this.color === 'string') return this.CLcolor

            return JSON.stringify(Object.keys(this.CLcolor).reduce((color, key) => {
                CLcolor[key] = Number(this.CLcolor[key].toFixed(2));
                return color
            }, {}), null, 2);
        },
    },
    created:function(){
        console.log(this.getWidget);
        console.log('test set Vue PJ');
        console.log($(window));
        console.log(window);
        console.log($('#testBtn'));

        $('#testBtn').click(function(){
            // 안되네
            console.log('?');
        });

        $('#testBtn').on('click',()=>{
            // 안되네
            console.log('testJqery');
            $(this).siblings('#DomDiv').css({background:'blue'});
            $(this).remove();
        });
    },
    mounted:function(){
        console.log('여기에 이벤트가 끝나고 나오는 마운트가실행')
    },
    methods: {
        getAPI () {
            store.commit('API','SET');
            //store.dispatch('increment');
            //console.log(store.state.count); 
            //
            //axios.get(`${setApi}`).then(res=>{
            //  console.log(res.data);
            //});
        },
        ChagePreView(){
            console.log('여기에 privew를 적용시켜준다.')
        }
    },
    watch:{ // like setIntvel
        changeConsole : function(){
        }
    }
});


$(function(){
    //제이쿼리가 vue를 조작할수있는 간단한 방법 
    //제어 대상 v-select 에서 사용하는 v-menu의 positon이 제어가 되지 않음 그걸 제조정해주는 제어문
    const J_v_array01 = new Array();
    $(window).on('load',function(){
        $('.v-select__slot').on('click',function(){
            const testSet = $(this).find("label").attr('for');
            $('.v-select__slot').each(function(e1,tag){
                const isExist = (J_v_array01.indexOf(testSet)!== -1);
                if(testSet == $(this).find("label").attr('for') && isExist == false){
                    J_v_array01.push(testSet);
                    setTimeout(() => {
                        const setTag = $('#list'+testSet.substr(5)).parent();
                        const setTop = parseInt(setTag.css('top')) - $(setId).offset().top; 
                        const setLeft = parseInt(setTag.css('left')) - $(setId).offset().left+5; 
                        setTag.css({top:setTop,left:setLeft});
                    }, 50);
                }
            })
        });
    });
});


/*
const store = new Vuex.Store({
    strict: true,
    state : { // like data();
        getWidget: {
            test: 0,
            setApi : "<?=$wset['sld_aixos_link']?>",
            setId : "<?=$widget_id ?>",
            setMethod : <?=$sld_aixos_method ? $sld_aixos_method : 'false' ?>,
            setCrowing : <?echo $sld_aixos_crawing == 0 ? 'false' : 'true' ?>
        },
        gestData : new Object(),
    },
    computed : { // like created
        
    },
    getters:{ // double 방지해주기 data의 중복 겹침 방지
        doneTodosCount: (state, getters) => {
            return getters.getWidget.test.length
        }
    },
    mutations:{ //methods
        API(state,n){
            this.state.getWidget.test ++;
            console.log('ok');
            console.log(this.state.getWidget.test);
        },
        functionB(state,n){},
        functionC(state,n){},
        functionD(state,n){},
    },
    action:{ //function async and complete function

    },
    modules:{ // 여러개의 store 정보들을 불러올때
    }

});


const app = new Vue({
    mode: 'production',
    el:setId,
    name: 'LayoutsDemosBaselineFlipped',
    vuetify: new Vuetify(),
    props: {
        source: String,
    },
    data () {
      return {
        type: 'number',
        number: 9999,
        selector: '#first',
        selections: ['#first', '#second', '#third'],
        selected: 'Button',
        elements: ['Button', 'Radio group'],
        duration: 300,
        offset: 0,
        easing: 'easeInOutCubic',
        easings: Object.keys(easings),
        fontSize:16
      }
    },
    computed: {
        getWidget () {
            return store.state.getWidget 
        },
        target () {
            const value = this[this.type]
            if (!isNaN(value)) return Number(value)
            else return value
        },
        options () {
            return {
            duration: this.duration,
            offset: this.offset,
            easing: this.easing,
            }
        },
        element () {
            if (this.selected === 'Button') return this.$refs.button
            else if (this.selected === 'Radio group') return this.$refs.radio
        },
    },
    created:function(){
        console.log(this.getWidget);
        console.log('test set Vue PJ');
        console.log($(window));
        console.log(window);
        console.log($('#testBtn'));

        $('#testBtn').click(function(){
            // 안되네
            console.log('?');
        });

        $('#testBtn').on('click',()=>{
            // 안되네
            console.log('testJqery');
            $(this).siblings('#DomDiv').css({background:'blue'});
            $(this).remove();
        });
    },
    mounted:function(){


    },
    methods: {
        getAPI () {
            store.commit('API','SET');
            //store.dispatch('increment');
            //console.log(store.state.count); 
            //
            //axios.get(`${setApi}`).then(res=>{
            //  console.log(res.data);
            //});
        },
        test01(){
            //console.log('test');
            this.$refs.setDom01.style.background = 'red';
        }
    },
    watch:{ // like setIntvel
        changeConsole : function(){
           
        }
    }
});
*/



/*
    const res = async queryString => {
    try {
        const res = await axios({
        url: `https://www.google.com/search?q=${qs.escape(queryString)}&tbm=isch`,
        method: 'GET',
        headers: {
            'User-Agent':
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36',
        },
        })
        const body = res
        console.log(body)
    } catch (err) {
        console.log(err)
    }
    }
*/

</script>
<?/* if you want auto setting layout use this
    <div id="<?=$widget_id ?>Vue"> 
        <v-app id="inspire">
            <v-navigation-drawer
            v-model="drawer"
            app
            right
            >
            <v-list dense>
                <v-list-item link>
                <v-list-item-action>
                    <v-icon>mdi-home</v-icon>
                </v-list-item-action>

                <v-list-item-content>
                    <v-list-item-title>Home</v-list-item-title>
                </v-list-item-content>
                </v-list-item>

                <v-list-item link>
                <v-list-item-action>
                    <v-icon>mdi-contact-mail</v-icon>
                </v-list-item-action>

                <v-list-item-content>
                    <v-list-item-title>Contact</v-list-item-title>
                </v-list-item-content>
                </v-list-item>
            </v-list>
            </v-navigation-drawer>

            <v-app-bar
            app
            color="cyan"
            dark
            >
            <v-spacer />

            <v-toolbar-title>Application</v-toolbar-title>

            <v-app-bar-nav-icon @click.stop="drawer = !drawer" />
            </v-app-bar>

            <v-content>
            <v-container
                class="fill-height"
                fluid
            >
                <v-row
                align="center"
                justify="center"
                >
                <v-col class="text-center">
                    <v-tooltip left>
                    <template v-slot:activator="{ on }">
                        <v-btn
                        :href="source"
                        icon
                        large
                        target="_blank"
                        v-on="on"
                        >
                        <v-icon large>mdi-code-tags</v-icon>
                        </v-btn>
                    </template>

                    <span>Source</span>
                    </v-tooltip>

                    <v-tooltip right>
                    <template v-slot:activator="{ on }">
                        <v-btn
                        icon
                        large
                        href="https://codepen.io/johnjleider/pen/WVbPgz"
                        target="_blank"
                        v-on="on"
                        >
                        <v-icon large>mdi-codepen</v-icon>
                        </v-btn>
                    </template>

                    <span>Codepen</span>
                    </v-tooltip>
                </v-col>
                </v-row>
            </v-container>
            </v-content>

            <v-footer
            color="cyan"
            app
            >
            <v-spacer />

            <span class="white--text">&copy; 2019</span>
            </v-footer>
        </v-app>
    </div>
    */?>


