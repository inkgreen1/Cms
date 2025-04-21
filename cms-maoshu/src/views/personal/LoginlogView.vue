<template>
  <div>
    <Table :columns="columns" :apiUrl="apiUrl"  :default-sort = "{ prop: 'createtime', order: 'descending' }">
      <template #operate="{ row }">
        <el-tag :type="row.operate=='登录'?'primary':'danger'">
          {{ row.operate }}
        </el-tag>
      </template>
    </Table>
  </div>
</template>

<script setup>
// import { ref, reactive } from "vue";
import Table from "@/components/Table.vue";

const columns = [
  { label: "ID", field: "id", width: 100 },
  { label: "操作", field: "operate" ,search:'like'},
  { label: "登录ip", field: "ip" },
  { label: "UA", field: "ua" ,search:'like'},
  
  { label: "操作时间", field: "createtime", searchFormType: "date",sortable :'custom' },
];


const apiUrl = {
  list: "/loginlog/list",
  del: "/loginlog/del",
};
</script>
