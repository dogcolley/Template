<template>
  <div>
    <table-component :table-data="tableData" />
    <div v-if="winner">{{winner}}님의 승리</div>
  </div>
</template>
<script>
  import TableComponent from './TableComponent';

  export default {
    components: {
      TableComponent,
    },
    data() {
      return {
        winner: '',
        turn: 'O',
        recentCell: [-1, -1],
        tableData: [['', '', ''],['', '', ''],['', '', '']],
      };
    },
    methods: {

    },
  };
</script>

<style>
  table {
    border-collapse: collapse;
  }
  td {
    border: 1px solid black;
    width: 40px;
    height: 40px;
    text-align: center;
  }
</style>
