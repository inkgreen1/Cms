<script setup>
import {  RouterView } from 'vue-router'
import {get,post} from "@/utils/request"

// post({
//   url:'/posttest'
// }).then(res=>{
//   console.log(res)
// })

// get({
//   url:'/gettest',
//   data:{
//     test:'err'
//   }
// }).then(res=>{
//   console.log(res)
// })
// import {getToken,setToken,removeToken} from "@/utils/token"

// // removeToken()
// // setToken('测试猫叔')
// let token = getToken()
// console.log('token: ', token);

</script>

<template>
  <RouterView />
</template>

<style scoped>

</style>
