<template>
  <div>
    <div>{{turn}}님의 턴입니다.</div>
    <table-conponent :table-data="tableData"></table-conponent>
    <div v-if="winner">{{winner}}님의 승리</div>
  </div>
</template>

<script>
  import Vue from 'vue';
  import TableConponent from "./TableConponent";
  export default {
    components:{
      TableConponent
    },
    data() {
      return {
          tableData:[
            ['','',''],
            ['','',''],
            ['','','']
          ],
          turn:'O',
          winner:'',
      };
    },
  };
</script>

<style>

</style>
