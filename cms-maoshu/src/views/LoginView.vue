<template>
  <div class="main">
    <div class="login-box">
      <div class="title">Cms 管理系统</div>
      <div class="small-title">管理员登录</div>
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
          <el-form-item prop="username">
            <el-input v-model="formModel.username" placeholder="用户名" />
          </el-form-item>
          <el-form-item prop="password">
            <el-input
              v-model="formModel.password"
              show-password
              placeholder="密码"
            />
          </el-form-item>
          <el-form-item prop="captcha">
            <el-input v-model="formModel.captcha" maxlength="5" show-word-limit placeholder="图片验证码" style="width:calc(100% - 130px);"/>
            <img :src="capchaImgUrl" @click="refreshCaptcha" style="width:130px;"/>
           
          </el-form-item>
          <el-form-item>
            <div class="flex flex-between" style="width: 100%">

              <el-checkbox v-model="rememberMe" label="记住密码"></el-checkbox>
              <span @click="showPwdDialog = true">
                重置密码
              </span>
            </div>
          </el-form-item>


          <el-form-item class="btn-group">
            <el-button type="primary" @click="submitForm(formModelRef)">
              登录
            </el-button>
            <el-button @click="resetForm(formModelRef)">重置</el-button>
          </el-form-item>
        </el-form>
      </div>
    </div>
  </div>
  <PwdForm title="修改密码" :showDialog="showPwdDialog" @update:showDialog="(v)=>showPwdDialog = v"></PwdForm>
</template>

<script setup>
import { reactive, ref ,computed} from "vue";
import { login } from "@/api/user";
import { ElMessage } from "element-plus";
import { setToken } from "@/utils/token";
import { apiDomain } from "@/utils/request";
import { getUnamePwd,setUnamePwd,removeUnamePwd } from "@/utils/userinfo";
import { useRouter,useRoute } from "vue-router";
import {pwdRules} from "@/utils/tool"

import PwdForm from '@/components/PwdForm.vue'

const formSize = ref("default");
const formModelRef = ref();
const formModel = reactive({
  username: "",
  password: "",
  captcha: "",
});

const router = useRouter();
const route = useRoute();
// console.log('route: ', route);

const rules = reactive({
  username: [
    { required: true, message: "请先填写用户名", trigger: "blur" },
    { min: 3, max: 20, message: "长度范围应该在3--20之间", trigger: "blur" },
  ],
  captcha: [
    { required: true, message: "请先填写验证码", trigger: "blur" },
    { len:5, message: "长度应该是5", trigger: "blur" },
  ],
  password:pwdRules
  // password: [
  //   { required: true, message: "请先填写密码", trigger: "blur" },
  //   {
  //     validator: (rule, value, callback) => {
  //       const regex =/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,30}$/;

  //       // const regex = /^[A-Za-z0-9]{6,12}$/
  //       if (regex.test(value)) {
  //         callback();
  //       } else {
  //         callback(
  //           new Error("密码必须包含大小写字母、数字和特殊字符，长度在6到30之间")
  //         );
  //       }
  //     },
  //     trigger: "blur",
  //   },
  // ],
});

const rememberMe = ref(false);
const userPwd = getUnamePwd()
if(userPwd){
    formModel.username = userPwd.uname
    formModel.password = userPwd.pwd
    rememberMe.value = true
}

const submitForm = async (formEl) => {
  if (!formEl) return;
  await formEl.validate((valid, fields) => {
    if (valid) {
      console.log("submit!", formModel);
      //   请求接口 登录
      login(formModel).then((res) => {
        console.log("res: ", res);
        if (res.code == 1) {
          // 弹出 setToken
          ElMessage.success(res.msg || "登录成功");

          console.log(rememberMe.value,'== 是否记住密码')
          if(rememberMe.value){
            // 记住密码
            setUnamePwd({
                uname:formModel.username,
                pwd:formModel.password
            })
          }
          else{
            removeUnamePwd()
          }

          setToken(res.data.token);
          // 跳转到用户中心
          router.push(route.query.redirect || "/");
        } else {
          refreshCaptcha()
          ElMessage.error(res.msg || "登录失败");
        }
      });
    } else {
      console.log("error submit!", fields);
    }
  });
};

const resetForm = (formEl) => {
  if (!formEl) return;
  formEl.resetFields();
};

const showPwdDialog = ref(false)

const T = ref(new Date().getTime())
const capchaImgUrl = computed(()=>apiDomain+'/user/captcha?t='+T.value)
const refreshCaptcha = ()=>{
  T.value = new Date().getTime()
}
</script>

<style scoped lang="scss">
.main {
  background: #8089ff;
  width: 100%;
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;

  .login-box {
    background: #fff;
    width: 500px;
    padding: 30px;
    border-radius: 10px;

    .title {
      font-size: 32px;
      text-align: center;
      padding: 10px 0;
      color: var(--el-color-primary);
    }

    .small-title {
      color: var(--el-color-primary);
      text-align: center;
      padding: 15px 0;
    }

    .btn-group {
      button {
        width: 243px;
      }
    }
  }
}
</style>
