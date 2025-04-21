<template>  
    <el-dialog
      v-model="dialogVisible"
      :title="title"
      width="500"
    >
      <div>
        <el-form
            ref="formModelRef"
            style="max-width: 600px"
            :model="formModel"
            :rules="rules"
            label-width="auto"
            class="demo-formModel"
            :size="formSize"
            status-icon
        >
            <el-form-item label="新密码" prop="password">
                <el-input v-model="formModel.password" />
            </el-form-item>
            <el-form-item label="确认密码" prop="re_password">
                <el-input v-model="formModel.re_password" />
            </el-form-item>
            <el-form-item label="手机号" prop="phone">
                <el-input v-model="formModel.phone" />
            </el-form-item>
            <el-form-item label="验证码" prop="code">
                <el-input v-model.number="formModel.code" style="width:65%;"/>
                <el-button type="primary" @click="sendSms" :disabled="seconds>0">
                  <span v-if="seconds>0">{{ seconds }}</span>
                  <span v-else>发送验证码</span>
                </el-button>
            </el-form-item>
        </el-form>
      </div>
      <template #footer>
        <div class="dialog-footer">
          <el-button @click="dialogVisible = false">取消</el-button>
          <el-button type="primary" @click="submitForm(formModelRef)">
            提交
          </el-button>
          <el-button @click="resetForm(formModelRef)">重置</el-button>
        </div>
      </template>
    </el-dialog>
</template>

<script setup>
import { ElMessage } from 'element-plus';
import {ref,reactive,computed} from 'vue'
import {resetPwdSms} from '@/api/sms'
import {resetpwdByPhone} from '@/api/user'
import {pwdRules} from "@/utils/tool"
const props = defineProps({
  showDialog: {
    type: Boolean,
    default: false
  },
  title: {
    type: String,
    default: ''
  }
})

const emit = defineEmits(['update:showDialog'])
const dialogVisible = computed({
  get: () => props.showDialog,
  set: (val) => {
    emit('update:showDialog', val)
  }
})


const formSize = ref('default')
const formModelRef = ref()
const formModel = reactive({
    password: '',
    re_password: '',
    phone: '',
    code: '',
})


const rules = reactive({
  password:pwdRules,
  re_password:[
    ...pwdRules,
    { validator: (rule, value, callback) => {
        if (value !== formModel.password) {
          callback(new Error('两次输入的密码不一致'))
        } else {
          callback()
        }
      }, trigger: 'blur'
    }
  ],
  phone:[
    { required: true, message: '请输入手机号', trigger: 'blur' },
    { pattern:/^1[3-9]\d{9}$/, message: '手机号格式不正确', trigger: 'blur' },
  ],
  code:[
    { required: true, message: '请输入验证码', trigger: 'blur' },
    // { min:6, max:6, message: '验证码的长度是6位', trigger: 'blur' }, 
    { pattern:/^\d{6}$/, message: '验证码必须是6位数字', trigger: 'blur' }, 
  ]
})

const submitForm = async (formEl) => {
  if (!formEl) return
  await formEl.validate((valid, fields) => {
    if (valid) {
      console.log('submit!')

       // 提交表单
       resetpwdByPhone({
        ...formModel
       }).then(res=>{
        if(res.code == 1){
          dialogVisible.value = false
          ElMessage.success(res.msg || '密码重置成功')
        }
        else{
          ElMessage.error(res.msg || '密码重置失败')
        }
       })
       
    } else {
      console.log('error submit!', fields)
    }
  })
}

const resetForm = (formEl) => {
  if (!formEl) return
  formEl.resetFields()
}

// 发送验证码
const seconds = ref(0)
let timer = null
const sendSms = ()=>{
  console.log('发送验证码');
  if(!/^1[3-9]\d{9}$/.test(formModel.phone)){
    ElMessage.error('手机号格式错误')
    return
  }
  // 直接发送验证码
  resetPwdSms({
    phone:formModel.phone
  }).then(res=>{
    if(res.code == 1){
      seconds.value = 60
      timer && clearInterval(timer)
      timer = setInterval(() => {
        seconds.value -- 
        if(seconds.value == 0){
          clearInterval(timer)
        }
      }, 1000);
      ElMessage.success(res.msg || '验证码发送成功')
    }
    else{
      ElMessage.error(res.msg || '验证码发送失败')
    }
  })

  

}
</script>