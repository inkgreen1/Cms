<template>
    <div ref="chartRef" style="width:100%;height: 400px;"></div>
</template>
<script setup>
import {ref,onMounted,onBeforeUnmount,watch} from 'vue'

import * as echarts from 'echarts';
const chartRef = ref()

const props = defineProps({
    xData:{type:Array,default:[]},
    yData:{type:Array,default:[]},
    title:{type:String,default:'数据趋势图'},
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
      title: {
        text: props.title
      },
      tooltip: {
        trigger: 'axis',
        axisPointer: {
          type: 'cross',
          label: {
            backgroundColor: '#646cff'
          }
        }
      },
      legend: {
        data: [props.legendName]
      },
      xAxis: {
        type: 'category',
        boundaryGap: false,
        data:props.xData
        // data: 
      },
      yAxis: {
        type: 'value'
      },
      series: [
        {
          name: props.legendName,
        //   data: ,
          data:props.yData,
          type: 'line',
          areaStyle: {},
          smooth: true,
          areaStyle: {
            color: {
              type: 'linear',
              x: 0,
              y: 0,
              x2: 0,
              y2: 1,
              colorStops: [
                {
                  offset: 0,
                  color: '#646cff' // 0% 处的颜色
                },
                {
                  offset: 1,
                  color: '#858bfd' // 100% 处的颜色
                }
              ],
              global: false // 缺省为 false
            }
          }
        }
      ]
    };
    option && myChart.setOption(option);
}

watch(()=>props.xData,
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