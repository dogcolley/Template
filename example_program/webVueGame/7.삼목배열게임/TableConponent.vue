<template>
    <table>
        <tr-component v-for="(rowData, index) in tableData" :row-data="rowData" :row-index="index" :key="index"></tr-component>        
    </table>
</template>

<script>
import TrComponent from './TrComponent';

export default {
    components:{
      TrComponent
    },
    props:{
        tableData: Array
    },
    Component :{
        TrComponent
    },

}
</script>

<style >
    table{border-collapse: collapse}
    td{
        border: 1px solid #000;
        width: 40px;
        height:40px;
        text-align: center
    }
</style>