<template>
  <div>
    <Table :columns="columns" :apiUrl="apiUrl" :formModelItems="formModelItems"
    :showPages = "false" @update:tableData="reFreshPidlist">
      <template #name="{ row }">
        <el-tag>
          {{ row.name }}
        </el-tag>
      </template>
    </Table>
  </div>
</template>

<script setup>
import { ref, reactive } from "vue";
import Table from "@/components/Table.vue";
import { getCatePidList } from "@/api/cate";

const columns = [
  { label: "分类ID", field: "id", width: 100 },
  {
    label: "父分类ID",
    field: "pid",
    width: 120,
    temp: (row, index) => {
      // console.log('row,index: ', row,index);
      return row.pid == 0 ? "-" : `<b>${row.pid}</b>`;
    },
    searchFormType: "select",
    searchList: () => {
      let obj = {}
      pidList.value.forEach(item=>{
        obj[item.value] = item.label
      })
      return obj;
    },
  },
  { label: "分类名称", field: "name" },
  { label: "分类描述", field: "desc" ,search:'like%'},
];

const pidNull =  { label: "无", value: 0 };
const pidList = ref([{...pidNull}])
const formModelItems = reactive([
  {
    label: "父分类",
    field: "pid",
    placeholder: "请选择父分类",
    type: "select",
    options: pidList.value,
    rules: [{ required: true, message: "请先选择父分类", trigger: "change" }],
  },
  {
    label: "分类名称",
    field: "name",
    placeholder: "请输入分类名称",
    rules: [
      { required: true, message: "请先填写分类名称", trigger: "blur" },
      { min: 3, max: 10, message: "长度必须在3--10之间", trigger: "blur" },
    ],
  },
  { label: "分类描述", field: "desc", type: "textarea" },
]);

const reFreshPidlist = ()=>{

  getCatePidList().then((res) => {
    if (res.code == 1) {
      let opt = res.data.map((x) => {
        return { label: x.name, value: x.id };
      });
  
      // formModelItems[0].options.push(...opt);
      
      pidList.value.splice(0,pidList.value.length,{...pidNull}, ...opt)
    }
  });
}

reFreshPidlist()

const apiUrl = {
  list: "/cate/list",
  add: "/cate/add",
  edit: "/cate/edit",
  del: "/cate/del",
};
</script>
