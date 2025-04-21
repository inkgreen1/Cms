<template>
  <div>
    <div class="upload-box">
      <el-upload
        class="image-cropper-uploader"
        accept=".jpeg,.jpg,.png"
        :limit="1"
        :auto-upload="false"
        :show-file-list="false"
        :file-list="fileList"
        :on-change="onImageChange"
      >
        <img
          v-if="imageUrl"
          :src="imageUrl"
          class="image-cropper"
          :width="width"
          :height="height"
        />
        <el-icon
          v-else
          class="image-cropper-uploader-icon"
          :style="{
            width: width - 2 + 'px',
            height: height - 2 + 'px',
            borderRadius: borderRadius,
          }"
          ><Plus
        /></el-icon>
      </el-upload>
      <div
        class="tip flex flex-center"
        :style="{ width: width + 'px', height: height + 'px' }"
      >
        <div class="tip-text">
          {{ tipText }}
        </div>
      </div>
    </div>

    <el-dialog
      v-model="cropperVisible"
      title="裁剪图片"
      append-to-body
      width="600"
    >
      <div style="width: 568px; height: 40vh" class="mb-20">
        <VueCropper
          ref="cropperRef"
          :img="option.img"
          :outputType="option.outputType"
          :autoCrop="option.autoCrop"
          :fixedNumber="option.fixedNumber"
          :centerBox="option.centerBox"
          :fixed="true"
        ></VueCropper>
      </div>

      <div class="bth-group flex flex-between">
        <div>
          <el-button type="primary" @click="uploadImage">上传</el-button>
          <el-button @click="cancelUpload">取消</el-button>
        </div>
        <div>
          <el-button @click="cropperRef.changeScale(1)"
            ><el-icon><Plus /></el-icon
          ></el-button>
          <el-button @click="cropperRef.changeScale(-1)"
            ><el-icon><Minus /></el-icon
          ></el-button>
          <el-button @click="cropperRef.rotateLeft()"
            ><el-icon><RefreshLeft /></el-icon
          ></el-button>
          <el-button @click="cropperRef.rotateRight()"
            ><el-icon><RefreshRight /></el-icon
          ></el-button>
        </div>
      </div>
    </el-dialog>
  </div>
</template>

<script setup>
import { ref, reactive } from "vue";

import "vue-cropper/dist/index.css";
import { VueCropper } from "vue-cropper";
import { uploadFile } from "@/api/upload";
import { ElMessage } from "element-plus";

const props = defineProps({
  imageUrl: {
    type: String,
  },
  width: {
    type: Number,
    default: 100,
  },
  height: {
    type: Number,
    default: 100,
  },
  tipText: {
    type: String,
    default: "点击上传图片",
  },
  borderRadius: {
    type: String,
    default: "5px",
  },
  category: {
    type: String,
    default: null,
  },
});
const fileList = ref([]);
const onImageChange = (obj) => {
  console.log("obj: ", obj);

  if (obj.raw.size <= 1024 * 1024 * 10) {
    const fileReader = new FileReader();

    fileReader.onload = function (e) {
      // console.log('e: ', e);
      option.img = e.target.result;
      cropperVisible.value = true;
    };
    fileReader.readAsDataURL(obj.raw);
  } else {
    ElMessage.error("图片大小不能超过10M");
  }

  fileList.value = [];
};

const cropperVisible = ref(false);
const cropperRef = ref();
const option = reactive({
  img: props.imageUrl || "",
  outputType: "png",
  autoCrop: true,
  centerBox: true,
  fixedNumber: [props.width, props.height],
});
console.log("option: ", option);

const emit = defineEmits(["uploadSuccessCallback"]);

const blobToFile = (blob, fileName) => { 
  return new window.File([blob], fileName, { type: blob.type, }); 
};

const uploadImage = () => {
  cropperRef.value.getCropBlob((data) => {
    // do something
    console.log(data);
    let file = blobToFile(data,'图片.'+option.outputType)

    uploadFile(file,props.category).then((res) => {
      if (res.code == 1) {
        emit("uploadSuccessCallback", res.data.url);
        ElMessage.success(res.msg);
      } else {
        ElMessage.error(res.msg);
      }

      option.img = "";
      cropperVisible.value = false;
    });
  });
};

const cancelUpload = () => {
  option.img = "";
  cropperVisible.value = false;
};
</script>

<style scoped lang="scss">
.upload-box {
  width: 100%;
  height: 100%;
  position: relative;

  .tip {
    position: absolute;
    top: 0;
    left: 0;
    background-color: rgba(0, 0, 0, 0.4);
    color: #fff;

    opacity: 0;

    -moz-transition: all 0.5s ease 0s;
    -webkit-transition: all 0.5s ease 0s;
    -o-transition: all 0.5s ease 0s;
    transition: all 0.5s ease 0s;

    pointer-events: none;
  }

  &:hover {
    .tip {
      opacity: 1;
    }
  }
}
</style>

<style>
.image-cropper-uploader .image-cropper-uploader-icon {
  border: 1px dashed var(--el-border-color);
  border-radius: 6px;
  cursor: pointer;
  position: relative;
  overflow: hidden;
  transition: var(--el-transition-duration-fast);
  border-radius: 50%;
}

.image-cropper-uploader .image-cropper-uploader-icon:hover {
  border-color: var(--el-color-primary);
}

.el-icon.image-cropper-uploader-icon {
  font-size: 28px;
  color: #8c939d;
  text-align: center;
}
</style>
