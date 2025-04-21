<template>
  <div class="flex gap-2">
    <el-tag
      v-for="tag in dynamicTags"
      :key="tag"
      closable
      :disable-transitions="false"
      @close="handleClose(tag)"
    >
      {{ tag }}
    </el-tag>
    <el-input
      v-if="inputVisible"
      ref="InputRef"
      v-model="inputValue"
      class="w-20"
      size="small"
      @keyup.enter="handleInputConfirm"
      @blur="handleInputConfirm"
    />
    <el-button v-else class="button-new-tag" size="small" @click="showInput">
      + New Tag
    </el-button>
  </div>
</template>

<script setup>
import { nextTick, ref, watch } from "vue";

const props = defineProps({
  tagsArray: {
    type: Array,
    default: [],
  },
});
const inputValue = ref("");
const dynamicTags = ref([]);
const inputVisible = ref(false);
const InputRef = ref();

const emit = defineEmits(["update:tagsArray"]);
watch(
  () => props.tagsArray,
  (newval) => {
    dynamicTags.value = [...newval];
  }
);

const handleClose = (tag) => {
  dynamicTags.value.splice(dynamicTags.value.indexOf(tag), 1);
  emit("update:tagsArray", dynamicTags.value);
};

const showInput = () => {
  inputVisible.value = true;
  nextTick(() => {
    InputRef.value?.input?.focus();
  });
};

const handleInputConfirm = () => {
  if (inputValue.value) {
    dynamicTags.value.push(inputValue.value);
    emit("update:tagsArray", dynamicTags.value);
  }
  inputVisible.value = false;
  inputValue.value = "";
};
</script>
