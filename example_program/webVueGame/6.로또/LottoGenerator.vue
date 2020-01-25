<template>
  <div>
    <h1>로또 추첨기</h1>
    <div id="결과창">
      <strong class="block">당첨 숫자</strong>
      <lotto-ball v-for="ball in winBalls" :key="ball" :number="ball"></lotto-ball>
    </div>
    <div>
      <strong class="block">보너스!</strong>
      <lotto-ball v-if="bonus" :number="bonus"></lotto-ball>
      <button v-if="redo" @click="onClickRead">한번더</button>
    </div>
  </div>
</template>

<script>
  import LottoBall from "./LottoBall";

  function getWinNumber(){
    console.log('getWinNumbers');
    const candidate = Array(45).fill().map((v,i) => i+1);
    const shuffle = [];
    while (candidate.length > 0){
      shuffle.push(candidate.splice(Math.floor(Math.random() * candidate.length),1)[0]);
    }
    const bonusNumber = shuffle[shuffle.length-1];
    const winNumbers = shuffle.slice(0,6).sort((p,c) => p-c);
    return [...winNumbers, bonusNumber];
  }
  const timeouts = [];
  export default {
    components:{
      'lotto-ball':LottoBall,
    },
    data() {
      return {
        winNumbers: getWinNumber(),
        winBalls:[],
        bonus:null,
        redo:false
      };
    },
    computed: {
      computedStyleObject() {
        return {
        };
      }
    },
    methods: {
      onClickRead() {
        this.winNumbers = getWinNumber();
        this.winBalls = [];
        this.bonus = null;
        this.redo = false;
          for(let i =0; i < this.winNumbers.length-1;i++){
            timeouts[i] = setTimeout(()=>{
              this.winBalls.push(this.winNumbers[i]);
            },(i+1) * 1000);
          }
          timeouts[6] = setTimeout(()=>{
            this.bonus = this.winNumbers[6];
            this.redo = true
          },7000); 
      },
      showBalls(){
         for(let i =0; i < this.winNumbers.length-1;i++){
            timeouts[i] = setTimeout(()=>{
              this.winBalls.push(this.winNumbers[i]);
            },(i+1) * 1000);
          }
          timeouts[6] = setTimeout(()=>{
            this.bonus = this.winNumbers[6];
            this.redo = true
          },7000); 
      }
    },
    mounted() {
      this.showBalls();
    },
    beforeDestroy() {
      timeouts.forEach((t) =>{
        clearTimeout(t);
      })
    },
    /*
    watch:{
      // 단점 계속 오류가나옴
      bonus(val,oldval){
        console.log(val,oldval);
        if(val === false){
          this.showBalls();
        }
      }
    }
    */
  };
</script>

<style scoped>
  .block{display: block}
</style>
