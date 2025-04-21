<template>
    <div ref="chartRef" style="width:100%;height: 400px;"></div>
</template>
<script setup>
import {ref,onMounted,onBeforeUnmount,watch} from 'vue'

import * as echarts from 'echarts';
const chartRef = ref()

const props = defineProps({
    data:{type:Array,default:[]},
    // title:{type:String,default:'数据趋势图'},
    legendName:{type:String,default:'内容数量'},
})

var myChart

const resizeChart = ()=>{
    if(myChart){
        myChart.resize()
    }
}

const initChart = ()=>{
    var chartDom = chartRef.value;
    myChart = echarts.init(chartDom);
    
    var option;
    
    option = {
      tooltip: {
        trigger: 'item'
      },
      legend: {
        top: '5%',
        left: 'center'
      },
      series: [
        {
          name: props.legendName,
          type: 'pie',
          radius: ['40%', '70%'],
          avoidLabelOverlap: false,
          padAngle: 5,
          itemStyle: {
            borderRadius: 10
          },
          label: {
            show: false,
            position: 'center'
          },
          emphasis: {
            label: {
              show: true,
              fontSize: 40,
              fontWeight: 'bold'
            }
          },
          labelLine: {
            show: false
          },
          data: props.data
        }
      ]
    };
    option && myChart.setOption(option);
}

watch(()=>props.data,
    ()=>{
        initChart()
    }
)

onMounted(()=>{
    window.addEventListener('resize',resizeChart)
    
})

onBeforeUnmount(()=>{
    window.removeEventListener('resize',resizeChart)
    myChart.dispose()
})
</script>