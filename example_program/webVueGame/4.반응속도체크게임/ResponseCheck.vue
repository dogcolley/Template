<template>
  <div>
    <div id="screen" v-bind:class="state" @click="onClickScreen">{{message}}</div>
    <div >
      <div>평균시간 : {{ avarage }} ms</div>
      <button @click="onReset">초기화</button>
    </div>
  </div>
</template>

<script>
  let startTime = 0;
  let endTime = 0;
  let timeout = null;
  export default {
    data() {
      return {
        result:[],
        state:'waiting',
        message:'클릭해서 시작하세요.',
      }
    },
    computed :{
      avarage(){
        return this.result.reduce((a,c) => a + c , 0) / this.result.length || 0
      }
    },
    methods: {
      onReset(e) {
        this.result = [];
        this.state ='waiting';
        this.message = "클릭해서 시작하세요.";
      },
      onClickScreen(){
        if(this.state ==='waiting'){
          this.state ='ready';
          this.message ="초록색이 되면클릭하세요";
          timeout = setTimeout(() => {
            this.state ='now';
            startTime = new Date();
          }, Math.floor(Math.random() *1000) + 2000);
        }else if(this.state === 'ready'){
          clearTimeout(timeout);
          this.message ="너무 성급하시네요. 초록색이 되면 클릭하세요";
        }else{
          endTime = new Date();
          this.state ='waiting';
          this.message = "클릭해서 시작하세요.";
          this.result.push(endTime -startTime);
        }
      }
    }
  };
</script>

<style scoped>
  /*scoped*/ 
  #screen{
    width:300px;
    height:300px;
    text-align: center;
    user-select: none;
  }
  .waiting{background-color:aqua}
  .ready{background-color:red}
  .now{background-color:greenyellow}
</style>

