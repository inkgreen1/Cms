<template>
    <div>
      <Table :columns="columns" :apiUrl="apiUrl"
      :showPages = "false"
      :default-sort="{prop:'createtime',order:'descending'}"
      >
      </Table>
    </div>
  </template>
  
  <script setup>
//   import { ref, reactive } from "vue";
  import {Domain} from "@/utils/request"
  import Table from "@/components/Table.vue";
  
  const columns = [
    { label: "ID", field: "id", width: 100 },

    { label: "管理员", field: "admin_id" ,temp:(row)=>{
      return row.admin_name
    }},
    { label: "日志标题", field: "title" },
    { label: "网址", field: "url" },
    { label: "请求数据", field: "data",search:'like'},
    { label: "IP", field: "ip" ,search:'like'},
    { label: "UA", field: "useragent" ,search:'like'},
    { label: "操作时间", field: "createtime" ,search:'daterange',sortable :'custom'},
  ];
  
  
  const apiUrl = {
    list: "/system/adminlog/list",   
    del: "/system/adminlog/del",
  };
  </script>
  