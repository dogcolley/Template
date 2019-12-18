<template>
    <tr>
        <td-component v-for="(cellData,index) in rowData" :row-index="rowIndex" :cell-data="cellData" :cell-index="index" :key="index"></td-component>
    </tr>
</template>

<script>
import TdComponent from './TdComponent';

export default {
    components:{
      TdComponent
    },
    data(){
        return {
            parent:'내가니 애비다.'
        };
    },
    props:{
        rowData:Array,
        rowIndex:Number
    },

}
</script>

<style scoped>

</style>