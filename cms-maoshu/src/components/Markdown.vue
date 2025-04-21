<template>
  <div>
    <v-md-editor
      v-model="text"
      height="400px"
      :disabled-menus="[]"
      @upload-image="handleUploadImage"
      :upload-image-config="{ accept: 'image/*', multiple: true }"
    ></v-md-editor>
  </div>
</template>

<script setup>
import { ref, watch } from "vue";
import { uploadFiles } from "@/api/upload";

import VMdEditor from "@kangc/v-md-editor";
import "@kangc/v-md-editor/lib/style/base-editor.css";
import githubTheme from "@kangc/v-md-editor/lib/theme/github.js";
import "@kangc/v-md-editor/lib/theme/style/github.css";
import createLineNumbertPlugin from "@kangc/v-md-editor/lib/plugins/line-number/index";

// highlightjs
import hljs from "highlight.js";

VMdEditor.use(githubTheme, {
  Hljs: hljs,
});
VMdEditor.use(createLineNumbertPlugin());

const emit = defineEmits(["update:textContent"]);
const props = defineProps({
  textContent: {
    type: String,
    default: "",
  },
});
const text = ref("");

watch(
  () => props.textContent,
  (newVal) => {
    const val = newVal;
    text.value = val;
  }
);

watch(
  () => text.value,
  (newVal) => {
    emit("update:textContent", newVal);
  }
);
const handleUploadImage = (event, insertImage, files) => {
  // 拿到 files 之后上传到文件服务器，然后向编辑框中插入对应的内容
  console.log(files);

  uploadFiles(files).then((res) => {
    console.log("res: ", res);
    if (res.code == 1) {
      res.data.forEach((item) => {
        insertImage({
          url: item.url,
          desc: item.name,
          // width: 'auto',
          // height: 'auto',
        });
      });
    }
  });
};
</script>

<style scoped></style>
