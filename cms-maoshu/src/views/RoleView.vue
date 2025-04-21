<template>
  <div>
    <Table
      :columns="columns"
      :apiUrl="apiUrl"
      :formModelItems="formModelItems"
      @update:tableData="updateTableData"
      @dialogFormOpened="updateRuleList"
      :showPages = "false"
      :showSearch = "false"
    >
    </Table>
  </div>
</template>

<script setup>
import { ref, reactive } from "vue";
import Table from "@/components/Table.vue";
import {getRuleList} from "@/api/role"
import {getRoles} from "@/utils/tool"


// 权限列表
// 内容管理：发布 修改 删除 审核
// 权限管理：角色创建 角色修改 角色删除
// 管理员管理：管理员创建 管理员修改 管理员删除
const treeDatas = ref([])

getRuleList().then(res=>{
  if(res.code == 1){
    treeDatas.value = res.data
  }
})

// 更新权限列表
const updateRuleList=(fromdata)=>{
  console.log('fromdata: ', fromdata);
  getRuleList({
    pid:fromdata.pid
  }).then(res=>{
    if(res.code == 1){
      treeDatas.value = res.data
    }
  })
}

// 表格：列
const columns = [
  { label: "角色组名称", field: "name" },
  { label: "ID", field: "id", width: 100 },
  {
    label: "父角色ID",
    field: "pid",
    width: 120,
    temp: (row, index) => {
      return row.pid == 0 ? "-" : `<b>${row.pid}</b>`;
    },
  },
];

// 表单：表单字段
const formModelItems = reactive([
  {
    label: "父角色组",
    field: "pid",
    placeholder: "请选择角色组",
    type: "select",
    options: [],
    changed:(data)=>{
      // console.log('data: ', data);
      updateRuleList({pid:data.pid})
      data.rules = []
    },
    rules: [{ required: true, message: "请先选择父角色组", trigger: "change" }],
  },
  {
    label: "角色组名称",
    field: "name",
    placeholder: "请输入角色组名称",
    rules: [
      { required: true, message: "请先填写角色组名称", trigger: "blur" },
      { min: 5, max: 10, message: "长度必须在5--10之间", trigger: "blur" },
    ],
  },
  {
    label: "选择权限",
    field: "rules",
    treeDatas:treeDatas,
    defaultExpandedAll:true,
    treeNodeKey:"rule",
    type:"tree",
    rules: [
      { required: true, message: "请先选择权限", trigger: "change" },
    ],
  },
]);



// 获取到最新的表格数据，并处理出下拉菜单
const updateTableData = (data) => {
  // console.log('data: ', data);
  let roleslist = getRoles(data, 0);
  // console.log('roleslist: ', roleslist);
  formModelItems[0].options = [...roleslist];
};

const apiUrl = {
  list: "/role/list",
  add: "/role/add",
  edit: "/role/edit",
  del: "/role/del",
  remoteDataUrl:'/role/getrulelistbyid'
};
</script>
