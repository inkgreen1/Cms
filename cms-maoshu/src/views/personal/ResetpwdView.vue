<template>
    <div class="flex flex-center card">
        <Form ref="formRef" :formModelItems="formModelItems" :submitUrl="submitUrl"></Form>
    </div>
</template>

<script setup>
import {ref ,reactive} from 'vue'
import Form from '@/components/Form.vue'
import {pwdRules} from "@/utils/tool"

const formRef = ref()

const formModelItems = reactive([
    {
        field:"oldpwd",
        label:"旧密码",
        placeholder:"请输入旧密码",
        type:"password",
        rules:pwdRules
    },
    {
        field:"newpwd",
        label:"新密码",
        placeholder:"请输入新密码",
        type:"password",
        rules:pwdRules
    },
    {
        field:"re_newpwd",
        label:"确认密码",
        placeholder:"请再输入一遍新密码",
        type:"password",
        rules:[
            ...pwdRules,
            { validator: (rule, value, callback) => {
                if(value !== formRef.value.formModel.newpwd){
                    callback(new Error('两次密码输入不一致'))
                }
                else{
                    callback()
                }
            }, trigger: 'blur' }
        ]
    }
])


const submitUrl=ref('/personal/resetpwd')

</script>