<template>
  <div class="flex flex-center card">
    <Form ref="formRef" :formModelItems="formModelItems" :submitUrl="submitUrl" :width="400"></Form>
  </div>
</template>

<script setup>
import { ref,reactive,onMounted } from 'vue'
import Form from '@/components/Form.vue'
import { getSiteinfo } from "@/api/site"
import { hasPermission } from "@/utils/tool";

const formRef = ref()
onMounted(() => {
    
    getSiteinfo().then(res=>{
        if(res.code == 1){
            formRef.value?.initFormModelData(res.data)
        }
    })
})

let ItemsArray = [
    {
        field:"name",
        label:"站点名称",
        placeholder:"请输入站点名称",
        type:"input",
        rules: [{ required: true, message: "请先填写站点名称", trigger: "blur" }],
    },
    {
        field:"title",
        label:"首页标题",
        placeholder:"请输入首页标题",
        type:"input",
        rules: [{ required: true, message: "请先填写首页标题", trigger: "blur" }],
    },
    {
        field:"keywords",
        label:"关键词",
        placeholder:"请输入关键词",
        type:"textarea",
    },
    {
        field:"desc",
        label:"站点描述",
        placeholder:"请输入站点描述",
        type:"textarea",
    },
    {
        field:"record",
        label:"备案号",
        placeholder:"请输入备案号",
    },
    {
        field:"psrecord",
        label:"公安备案号",
        placeholder:"请输入公安备案号",
    },
    {
        field:"forbidip",
        label:"禁止ip",
        placeholder:"请输入禁止ip",
        type:"textarea",
    },
    {
        field:"status",
        label:"站点状态",
        placeholder:"请输入站点状态",
        type:"radio",
        options:[
            {label:"开启",value:1},
            {label:"关闭",value:0},
        ]
    },
    {
        field:"logo",
        label:"站点logo",
        placeholder:"请输入站点logo",
        type:"image",
    },
    {
        field:"favicon",
        label:"站点地址栏图标",
        placeholder:"请输入站点地址栏图标",
        type:"image",
        size:100,
        accept:'.png,.ico'
    },
]

ItemsArray = ItemsArray.filter(item => {
    if (['logo','status'].includes(item.field)) {        
        return hasPermission(item.field)
    }
    return true
})

const formModelItems = reactive(ItemsArray)
const submitUrl = ref('/site/save')
</script>

<style scoped lang="scss">

</style>