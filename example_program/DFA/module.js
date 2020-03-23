const setId = "#App";

const store = new Vuex.Store({
    //확장성을 위한 vuex 중앙 데이터 처리장치
    strict: true,
    state : { // like data();
        getWidget: {
            setId : setId,
        },
        gestData : new Object(),
    },
    computed : { // event change created 
        
    },
    components: {
    },
    getters:{ // double 방지해주기 data의 중복 겹침 방지
        doneTodosCount: (state, getters) => {
        }
    },
    mutations:{ //methods
        API(state,n){


        },
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
            fontUnit:'px',
            fontOption:'기본',
            fontColor: "#000",
            fontWeight:'400',
            textAlign:'left',
            textDeco:'unset',
            fontShdowX:0,
            fontShdowY:0,
            fontShdowBlur:0,
            fontShdowColor:'#000',
            letterSpacing:0, 
            lineHeight:1,
            colorSetting:true,
            colorSettingMode:'컬러',
            fontOptions:[
                {text:'기본'},
                {text:'그림자'},
                {text:'자간,행간'},
                {text:'컬러'},
                {text:'효과'},
            ],
            fontWeights:[
                {text:'300'},
                {text:'400'},
                {text:'500'},
                {text:'600'},
                {text:'700'},
                {text:'800'},
                {text:'900'},
            ],
            textDecos:[
                {text:'none'},
                {text:'overline'},
                {text:'line-through'},
                {text:'underline'},
            ],
            textAligns:[
                {text:'center'},
                {text:'left'},
                {text:'right'},
            ],
            fontUnits:[
                {text:'px'},
                {text:'rem'},
            ],
            CLtypes: ['hex', 'hexa', 'rgba', 'hsla', 'hsva'],
            CLtype: 'hex',
            hex: '#000',
            hexa: '#000',
            rgba: { r: 255, g: 255, b: 255, a: 1 },
            hsla: { h: 300, s: 1, l: 0.5, a: 1 },
            hsva: { h: 300, s: 1, v: 1, a: 1 },
            displayOptions:[
                {text:'block'},
                {text:'inline-block'},
                {text:'inline'},
                {text:'table'},
                {text:'table-Cell'}
            ],
            displayOption:'block',
            tagType:'normal',
            tagTypes: [
                {text:'normal'},
                {text:'button'},
                {text:'a'},
            ],
            Link:'',
            target:'새창열기',
            targets:[
                {text:'바로이동'},
                {text:'새창열기'},
            ],
            positionOption:'',
            positionOptions:[
                {text:'static'},
                {text:'absolute'},
                {text:'fixed'},
                {text:'relative'}
            ],
            blankOption:'padding',
            blankOptions:[
                {text:'padding'},
                {text:'margin'}
            ],
            unitPd:'px',
            unitMg:'px',
            paddingTop:0,
            paddingBottom:0,
            paddingLeft:0,
            paddingRight:0,
            marginTop:0,
            marginBottom:0,
            marginLeft:0,
            marginRight:0,
            decoractionOption:'background',
            borderBoth : true,
            borderPosition:'top',
            borderColor:'',
            borderColor01:'',
            borderColor02:'',
            borderColor03:'',
            borderColor04:'',
            borderSize:0,
            borderSize01:0,
            borderSize02:0,
            borderSize03:0,
            borderSize04:0,
            borderStyle:'solid',
            borderStyle01:'solid',
            borderStyle02:'solid',
            borderStyle03:'solid',
            borderStyle04:'solid',
            borderStyles:[
                {text:'solid'},
                {text:'dashed'},
                {text:'dotted'}
            ],
            backgroundColor:'',
    }),
    computed: {
        /*
        getWidget () {
            return store.state.getWidget 
        },
        */
        CLcolor: {
            get () {
                this.ColorSet(this[this.CLtype]);
                this.ChangeOption();
                return this[this.CLtype]
            },
            set (v) {
                this.ColorSet(this[this.CLtype]);
                this.ChangeOption();
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
        this.ChangeOption();
        //이런식으로 직접 호출하는 방식은 vue에서 돔구조에 접근이 불가능하기 떄문에 vue 선언한 다음 외부에서 접근하도록한다.
        //동적생성자들은 on을 이용한제어로 컨트롤하면 충분히 제어가능하다.
    },
    mounted:function(){
        //console.log('여기에 이벤트가 끝나고 나오는 마운트가실행')
    },
    methods: {
        /*
        getAPI () {
            store.commit('API','SET');
            axios.get(`${setApi}`).then(res=>{
                console.log(res.data);
            });
        },
        */
        ChangeOption(option,data){
            let CssTxt = '';
            if(this.fontUnit == 'rem')CssTxt += `fontSize:${this.fontSize / 10}${this.fontUnit};`;
            else CssTxt += `fontSize:${this.fontSize}${this.fontUnit};`;
            CssTxt += `fontWeight:${this.fontWeight};`;
            CssTxt += `textAlign:${this.textAlign};`;
            CssTxt += `textShadow:${this.fontShdowX}px ${this.fontShdowY}px ${this.fontShdowBlur}px ${this.fontShdowColor} ;`;
            CssTxt += `letterSpacing:${this.letterSpacing / 10}px;`;
            CssTxt += `lineHeight:${this.lineHeight};`;
            CssTxt += `color:${this.fontColor};`;
            CssTxt += `display:${this.displayOption};`;
            CssTxt += `textDecoration:${this.textDeco};`;
            CssTxt += `padding:${this.paddingTop}${this.unitPd} ${this.paddingRight}${this.unitPd} ${this.paddingBottom}${this.unitPd} ${this.paddingLeft}${this.unitPd};      `;
            CssTxt += `margin:${this.marginTop}${this.unitPd} ${this.marginRight}${this.unitPd} ${this.marginBottom}${this.unitPd} ${this.marginLeft}${this.unitPd};      `;
            CssTxt += `border:1px solid ${this.borderColor};`;
            CssTxt += `background:${this.backgroundColor};`;
            console.log(CssTxt);
            this.PrivewStyle = CssTxt;
        },
        ChangeSetting(){
            
        },
        ChangeCate(cate){
            console.log(cate);
            if(cate == '그림자' || cate == "컬러" || cate =="효과" || cate == "background"|| cate == 'border')this.colorSetting = true;
            else this.colorSetting = false;
            if(cate)this.colorSettingMode = cate;
        },
        ColorSet(colorData){
            if(this.colorSettingMode == '그림자'){
                this.fontShdowColor = colorData;
            }
            else if(this.colorSettingMode == '컬러'){
                this.fontColor = colorData;
            }
            else if(this.colorSettingMode == 'background'){
                this.backgroundColor = colorData;
            }
            else if(this.colorSettingMode == 'border'){
                this.borderColor = colorData;
            }
            console.log(colorData);
        }
    },
    watch:{
        PrivewStyle: function (newQuestion) {
        },
        type: function(state){
            if(state == 'decoraction'){
                this.ChangeCate(this.decoractionOption);
            }else if(state == 'font'){
                this.ChangeCate('컬러');
            }else{
                this.ChangeCate();
            }
        }
    }
});
