<template>
    <div>
      <Table :columns="columns" :apiUrl="apiUrl"
      :showPages = "false"
      :default-sort="{prop:'createtime',order:'descending'}"
      >
        <template #category="{ row }">
          <el-tag>
            {{ row.category }}
          </el-tag>
        </template>

        <template #url="{ row }">
          <img :src="Domain+row.url" style="max-width:100px;max-height: 100px;"/>
        </template>
      </Table>
    </div>
  </template>
  
  <script setup>
//   import { ref, reactive } from "vue";
  import {Domain} from "@/utils/request"
  import Table from "@/components/Table.vue";
  
  const columns = [
    { label: "ID", field: "id", width: 100 },

    { label: "名称", field: "name" },
    { label: "分类", field: "category" },
    { label: "Mime类型", field: "mimetype"},
    { label: "url", field: "url" ,search:'like'},
    { label: "上传时间", field: "createtime" ,search:'daterange',sortable :'custom'},
  ];
  
  
  const apiUrl = {
    list: "/system/files/list",   
    del: "/system/files/del",
  };
  </script>
  