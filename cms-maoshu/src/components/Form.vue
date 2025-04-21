<template>
  <el-form
    ref="formModelRef"
    :model="formModel"
    label-width="auto"
    class="form-model"
    :size="formSize"
    status-icon
  >
    <el-form-item
      :label="item.label"
      :rules="item.rules"
      :prop="item.field"
      v-for="(item, index) in formModelItems"
      :key="index"
      :class="{ 'is-hidden': item.type == 'hidden' }"
      :style="{ width: `${width}px` }"
    >
      <el-input
        v-if="item.type == 'textarea'"
        type="textarea"
        rows="6"
        v-model="formModel[item.field]"
        :placeholder="item.placeholder"
      />
      <el-select
        v-else-if="item.type == 'select'"
        v-model="formModel[item.field]"
        :placeholder="item.placeholder"
        @change="
          () => {
            item.changed ? item.changed(formModel) : '';
          }
        "
      >
        <el-option
          v-for="(itm, ind) in item.options"
          :key="ind"
          :value="itm.value"
          :label="itm.label"
        ></el-option>
      </el-select>
      <el-radio-group
        v-model="formModel[item.field]"
        v-else-if="item.type == 'radio'"
      >
        <el-radio
          v-for="(itm, ind) in item.options"
          :key="ind"
          :value="itm.value"
          :label="itm.label"
        ></el-radio>
      </el-radio-group>

      <Tags
        v-else-if="item.type == 'tags'"
        :tagsArray="formModel[item.field]"
        @update:tagsArray="
          (val) => {
            formModel[item.field] = val;
          }
        "
      ></Tags>
      <div v-else-if="item.type == 'markdown'" style="width: 100%">
        <Markdown
          :textContent="formModel[item.field]"
          @update:textContent="(val) => (formModel[item.field] = val)"
        >
        </Markdown>
      </div>

      <div v-else-if="item.type == 'image'">
        <el-upload
          class="upload-demo"
          :accept="item.accept ? item.accept : '.jpeg,.png'"
          drag
          :action="apiDomain + '/upload/file'"
          :before-upload="(rawFile) => beforeUpload(rawFile, item.size)"
          :on-success="
            (response, uploadFile, uploadFiles) =>
              handleUploadSuccess(response, uploadFile, uploadFiles, item.field)
          "
          :limit="1"
          :file-list="
            formModel[item.field]
              ? [{ name: formModel[item.field], url: formModel[item.field] }]
              : []
          "
          :headers="{ Authorization: getToken() }"
          :on-remove="
            (file, fileList) => handleRemove(fileList, item.field)
          "
        >
          <el-icon class="el-icon--upload"><upload-filled /></el-icon>
          <div class="el-upload__text">
            拖拽文件到这里 或者 <em>点击上传</em>
          </div>
          <template #tip>
            <div class="el-upload__tip">
              格式为 {{ item.accept ? item.accept : ".jpeg,.png" }} ，文件小于{{
                item.size ? item.size : "500"
              }}k
            </div>
          </template>
        </el-upload>
      </div>
      <div v-else-if="item.type == 'cropper'">
        <ImgCropper
          :imageUrl="formModel[item.field]"
          :width="400"
          :height="200"
          :category="item.field"
          @uploadSuccessCallback="
            (url) => uploadSuccessCallback(url, item.field)
          "
        ></ImgCropper>
      </div>
      <el-tree
        v-else-if="item.type == 'tree'"
        style="width:100%"
        :data="item.treeDatas"
        show-checkbox
        :node-key="item.treeNodeKey"
        :default-expand-all="item.defaultExpandedAll"
        :default-checked-keys="formModel[item.field] || []"
        :props="{ class: 'is-line-tree' }"
        @check="
          (obj, checked, key) => handleCheckChange(obj, checked, item.field)
        "
      />
      <el-input
        v-else
        v-model="formModel[item.field]"
        :placeholder="item.placeholder"
        :show-password="item.type == 'password'"
        :disabled="item.disabled ? true : false"
      />
    </el-form-item>

    <el-form-item>
      <el-button type="primary" @click="submitForm(formModelRef)">
        保存
      </el-button>
      <el-button @click="resetForm(formModelRef)">重置</el-button>
    </el-form-item>
  </el-form>
</template>

<script setup>
import { reactive, ref } from "vue";
import { post, apiDomain } from "@/utils/request";
import { getToken } from "@/utils/token";
import { ElMessage } from "element-plus";
import ImgCropper from "@/components/ImgCropper.vue";
import Tags from "@/components/Tags.vue";
import Markdown from "@/components/Markdown.vue";

const props = defineProps({
  formModelItems: { type: Array, required: true, default: [] },
  submitUrl: { type: String, required: true, default: "" },
  width: { type: Number },
});

const formSize = ref("default");
const formModelRef = ref();
const formModel = reactive({});

// 初始化表单数据
const initFormModelData = (data) => {
  // console.log("data: ", data);
  if (Object.keys(data).length == 0) {
    for (let i in formModel) {
      delete formModel[i];
    }
  } else {
    props.formModelItems.forEach((item) => {
      // console.log('item: ', item);
      formModel[item.field] = data[item.field];
    });
    if (typeof data.id !== "undefined") {
      formModel.id = data.id;
    }
  }
};
defineExpose({ initFormModelData, formModel });
//   设置验证规则
//   const rules = reactive({})
//   formModelItems.forEach(item=>{
//     if(item.rules){
//         rules[item.field] = item.rules
//     }
//   })

const emit = defineEmits(["submitCallback"]);
const submitForm = async (formEl) => {
  if (!formEl) return;
  await formEl.validate((valid, fields) => {
    if (valid) {
      console.log("submit!");
      post({
        url: props.submitUrl,
        data: formModel,
      }).then((res) => {
        if (res.code == 1) {
          emit("submitCallback");
          ElMessage.success(res.msg);
        } else {
          ElMessage.error(res.msg);
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
// 复选框发生选中变化
const handleCheckChange = (obj, checked, key) => {
  // console.log(obj,checked.checkedKeys,key);
  formModel[key] = checked.checkedKeys;
};
// 文件上传成功之后
const handleUploadSuccess = (response, uploadFile, uploadFiles, field) => {
  if (response.code == 1) {
    formModel[field] = response.data.url;
  }
};
const handleRemove = (fileList,field)=>{
  formModel[field] = null
}

// 上传文件之前，检测文件大小是否符合
const beforeUpload = (rawFile, size) => {
  console.log("rawFile,size: ", rawFile.size, size);
  size = size || 500;
  if (rawFile.size > size * 1024) {
    ElMessage.error("文件大小不能超过" + size + "k");
    return false;
  }
};

const uploadSuccessCallback = (url, field) => {
  formModel[field] = url;
};
</script>

<style>
.is-line-tree.el-tree-node {
  display: inline-block;
  white-space:normal;
}
</style>
