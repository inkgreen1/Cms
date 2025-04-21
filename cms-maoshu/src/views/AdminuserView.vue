<template>
  <div>
    <Table :columns="columns" :apiUrl="apiUrl" :formModelItems="formModelItems">
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
import { getRoleList } from "@/api/role";
import { getRoles } from "@/utils/tool";

const roleObject = ref({});

const columns = [
  { label: "ID", field: "id", width: 100 },
  { label: "用户名", field: "username" ,search:'like'},
  { label: "昵称", field: "nickname",searchHide:false },
  {
    label: "所属角色组",
    field: "role_id",
    searchFormType: "select",
    defaultValue:'2',
    searchList: () => {
      // console.log("roleObject.value: ", roleObject.value);
      return roleObject.value;
    },
    temp: (row, index) => {
      // console.log('row,index: ', row,index);
      return roleObject.value[row.role_id];
    },
  },
  { label: "最后登录时间", field: "lastlogintime",search:"daterange", searchFormType: "daterange" },
];

const roleList = ref([]);
const formModelItems = reactive([
  {
    label: "角色组",
    field: "role_id",
    placeholder: "请选择角色组",
    type: "select",
    options: roleList.value,
    rules: [{ required: true, message: "请先选择角色组", trigger: "change" }],
  },
  {
    label: "用户名",
    field: "username",
    placeholder: "请输入用户名",
    rules: [
      { required: true, message: "请先填写用户名", trigger: "blur" },
      { min: 4, max: 10, message: "长度必须在4--10之间", trigger: "blur" },
    ],
  },
  {
    label: "昵称",
    field: "nickname",
    placeholder: "请输入昵称",
    rules: [
      { required: true, message: "请先填写昵称", trigger: "blur" },
      { min: 4, max: 10, message: "长度必须在4--10之间", trigger: "blur" },
    ],
  },
  {
    label: "密码",
    field: "password",
    placeholder: "请输入密码"
  },
]);

getRoleList().then((res) => {
  if (res.code == 1) {
    let roles = getRoles(res.data);
    // console.log("roles: ", roles);
    roles.forEach((item) => {
      roleObject.value[item.value] = item.label;
    });
    // console.log('roleObject.value: ', roleObject.value);
    // formModelItems[0].options = [...roles];
    roleList.value.splice(0,roleList.value.length, ...roles)
  }
});

const apiUrl = {
  list: "/adminuser/list",
  add: "/adminuser/add",
  edit: "/adminuser/edit",
  del: "/adminuser/del",
};
</script>
