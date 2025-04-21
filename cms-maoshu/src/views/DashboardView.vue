<template>
    <div class="grid card">
        <div class="data-card card" v-for="item,index in datas" :key="index" :style="{backgroundColor: colors[index]}">
            <div class="title">
                {{ item.title }}

            </div>
            <div class="flex flex-between">
                <el-icon :size="40">
                    <component :is="item.icon"></component>
                </el-icon>
                <span class="count">
                    <count-to :startVal="0" :endVal="Number(item.count)" :decimals="0" :duration="3000"></count-to>
                </span>
            </div>
           
        </div>
    </div>
    <div class="flex flex-between mt-20">
        <div class="card mr-20" style="width:70%">

            <EchartsLine :x-data="lineData.x" :y-data="lineData.y"></EchartsLine>
        </div>
        <div class="card" style="width:25%">

            <EchartsPie :data="pieData"></EchartsPie>
        </div>
    </div>
</template>

<script setup>
import {ref,reactive} from 'vue'
import { CountTo } from 'vue3-count-to';
import {getDatas,getWeekDatas,getContentDatas} from '@/api/dashboard'
import EchartsLine from '@/components/EchartsLine.vue'
import EchartsPie from '@/components/EchartsPie.vue'
const colors = ["#ec4786","#7858bd","#5dc0ef","#faab34"]
const datas = ref([])


getDatas().then(res=>{
    datas.value = res.data
})

const lineData = reactive({})
const pieData = ref([])
getWeekDatas().then(res=>{
    if(res.code == 1){
        lineData.x = res.data.keys
        lineData.y = res.data.values
    }
})
getContentDatas().then(res=>{
    if(res.code == 1){
        pieData.value = res.data.values
    }
})

</script>

<style scoped  lang="scss">
.grid{
    grid-template-columns: repeat(4,1fr);
    gap:15px;

    .data-card{
        color:#fff;
    }

    .count{
        font-size:32px;
        font-weight: bold;
    }
}
</style>