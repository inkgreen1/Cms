<template>
  <el-form
    :inline="true"
    :model="formInline"
    ref="formModelRef"
    class="demo-form-inline"
  >
    <template v-for="(item, index) in columns" :key="index">
      <el-form-item
        :label="item.label"
        :prop="item.field"
        v-if="!item.searchHide"
      >
        <el-select
          v-model="formInline[item.field]"
          placeholder="请选择"
          clearable
          v-if="item.searchFormType == 'select' && item.searchList"
        >
          <el-option
            :label="itm"
            :value="ind"
            v-for="(itm, ind) in item.searchList()"
            :key="ind"
          />
        </el-select>
        <el-radio-group
          v-else-if="item.searchFormType == 'radio' && item.searchList"
          v-model="formInline[item.field]"
        >
          <el-radio
            :value="ind"
            v-for="(itm, ind) in item.searchList()"
            :key="ind"
            >{{ itm }}</el-radio
          >
        </el-radio-group>

        <el-date-picker
          v-model="formInline[item.field]"
          :type="item.searchFormType"
          placeholder=""
          clearable
          v-else-if="
            item.searchFormType == 'date' ||
            item.searchFormType == 'datetime' ||
            item.searchFormType == 'daterange'
          "
        />

        <template v-else-if="item.searchFormType == 'range'">
          <el-input
            v-model="formInline[item.field][0]"
            placeholder=""
            clearable
            style="width: 60px"
            class="mr-5"
          />
          -
          <el-input
            v-model="formInline[item.field][1]"
            placeholder=""
            clearable
            style="width: 60px"
            class="ml-5"
          />
        </template>
        <el-input
          v-else
          v-model="formInline[item.field]"
          placeholder=""
          clearable
        />
      </el-form-item>
    </template>
    <el-form-item>
      <el-button type="primary" @click="submitForm(formModelRef)">
        搜索
      </el-button>
      <el-button @click="resetForm(formModelRef)">重置</el-button>
    </el-form-item>
  </el-form>
</template>

<script setup>
import { ref, reactive } from "vue";

const props = defineProps({
  columns: { type: Array, required: true, default: [] },
});

const emit = defineEmits(["submitSearch"]);

const formInline = reactive({});
const formModelRef = ref();

props.columns.forEach((item) => {
  if (!item.searchHide) {
    formInline[item.field] = item.searchFormType == "range" ? [] : "";
  } else {
    formInline[item.field] = item.defaultValue ? item.defaultValue : "";
  }
});
const submitForm = async (formEl) => {
  if (!formEl) return;
  console.log("submit!");
  emit("submitSearch", formInline);
};

const resetForm = (formEl) => {
  if (!formEl) return;
  formEl.resetFields();
  emit("submitSearch", {});
};
</script>

<style>
.demo-form-inline .el-input {
  --el-input-width: 220px;
}

.demo-form-inline .el-select {
  --el-select-width: 220px;
}
</style>
