<template>
  <div class="flex flex-center card" style="flex-direction: column">
    <div class="flex mb-20">
      <!--  -->
      <div class="avatar-box" style="width: 100px; height: 100px">
        <ImgCropper
          :imageUrl="imageUrl"
          tipText="点击上传头像"
          borderRadius="50%"
          @uploadSuccessCallback="uploadSuccessCallback"
        ></ImgCropper>
      </div>
    </div>
    <Form
      ref="formRef"
      :formModelItems="formModelItems"
      :submitUrl="submitUrl"
      @submitCallback="submitCallback"
    ></Form>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from "vue";
import Form from "@/components/Form.vue";
import { userStore } from "@/stores/user";

import AvatarImageLocal from "@/assets/avatar.png";
import ImgCropper from "@/components/ImgCropper.vue";

const store = userStore();
const { userInfo } = store;
const formRef = ref();

const imageUrl = ref(AvatarImageLocal);

const userInfoData = ref({});
onMounted(() => {
  userInfoData.value = {
    avatar: userInfo.avatar,
    username: userInfo.username,
    nickname: userInfo.nickname,
    phone: userInfo.phone,
  };
  formRef.value?.initFormModelData(userInfoData.value);

  imageUrl.value = userInfo.avatar;
});

const formModelItems = reactive([
  {
    field: "avatar",
    label: "头像",
    type: "input",
    rules: [{ required: true, message: "请先上传头像", trigger: "blur" }],
  },
  {
    field: "username",
    label: "用户名",
    type: "input",
    placeholder: "填写用户名",
    rules: [{ required: true, message: "请先填写用户名", trigger: "blur" }],
  },
  {
    field: "nickname",
    label: "昵称",
    type: "input",
    placeholder: "填写昵称",
    rules: [{ required: true, message: "请先填写昵称", trigger: "blur" }],
  },
  {
    field: "phone",
    label: "手机号",
    type: "input",
    disabled: true,
  },
]);

const submitUrl = ref("/personal/saveinfo");

const uploadSuccessCallback = (url) => {
  imageUrl.value = url;

  userInfoData.value.avatar = url;
  formRef.value?.initFormModelData(userInfoData.value);
};

const submitCallback = () => {
  const info = formRef.value?.formModel;
  store.setUserinfo({ ...info });
};
</script>

<style scoped lang="scss">
.avatar-box {
  border-radius: 50%;
  overflow: hidden;
}
</style>
