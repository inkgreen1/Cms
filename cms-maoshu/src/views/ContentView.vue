<template>
  <div>
    <Table
      :columns="columns"
      :apiUrl="apiUrl"
      :formModelItems="formModelItems"
      @update:tableData="updateTableData"
      :default-sort = "{ prop: 'createtime', order: 'descending' }"
    >
      <template #coverimage="{ row, index }">
        <el-image
          style="width: 200px; height: 100px"
          :src="row.coverimage"
          :zoom-rate="1.2"
          :max-scale="7"
          :min-scale="0.2"
          :preview-src-list="srcList"
          :initial-index="initialIndex"
          :preview-teleported="true"
          :hide-on-click-modal="true"
          @show="showImage(index)"
          fit="cover"
        />
      </template>
      <template #tag="{ row }">
        <el-tag v-for="(item, index) in row.tag" type="info" :key="index">
          {{ item }}
        </el-tag>
      </template>
      <template #audit="{ row }">
        <el-tag
          :type="
            row.audit == 1 ? 'success' : row.audit == 2 ? 'danger' : 'primary'
          "
        >
          {{ auditObj[row.audit] }}
        </el-tag>
        <div v-if="hasPermission('changeaudit') && row.audit == 0" class="mt-10">
          <el-button
            size="small"
            type="success"
            @click="changeAuditStatus(row, 1)"
            >通过</el-button
          >
          <el-button
            size="small"
            type="danger"
            @click="changeAuditStatus(row, 2)"
            class="ml-0"
            >拒绝</el-button
          >
        </div>
      </template>
      <template #status="{ row }">
        <el-switch
          v-model="row.status"
          inline-prompt
          :active-value="1"
          :inactive-value="0"
          :active-text="statusObj[1]"
          :inactive-text="statusObj[0]"
          :loading="row.loading || false"
          :before-change="beforeChange.bind(this, row)"
          :disabled="!hasPermission('changestatus')"
        />
      </template>
    </Table>
  </div>
</template>

<script setup>
import { ref, reactive } from "vue";
import Table from "@/components/Table.vue";
import { getCateList } from "@/api/cate";
// import { getRoles } from "@/utils/tool";
import { hasPermission } from "@/utils/tool";
import { ElMessage, ElMessageBox } from "element-plus";
import { changeStatus, changeAudit } from "@/api/content";
const statusObj = ref({
  1: "展示",
  0: "隐藏",
});

const auditObj = ref({
  2: "已拒绝",
  1: "已审核",
  0: "待审核",
});
const cateList = ref({});
const cateArray = ref([]);

const columns = [
  { label: "ID", field: "id", width: 100 ,sortable :true},
  { label: "标题", field: "title", search: "like" },
  { label: "副标题", field: "subtitle" },
  { label: "缩略图", field: "coverimage", width: 200 },
  {
    label: "分类",
    field: "category_id",
    searchFormType: "select",
    temp:(row)=>{
      return row.category_text
    },
    searchList: () => {
      return cateList.value;
    },
  },
  { label: "标签", field: "tag" ,search:"find in set"},
  { label: "作者", field: "author" },
  { label: "点击量", field: "clicknum", searchFormType: "range" },
  { label: "描述", field: "desc" },
  {
    label: "状态",
    field: "status",
    searchFormType: "radio",
    searchList: () => {
      return statusObj.value;
    },
  },
  {
    label: "审核",
    field: "audit",
    searchFormType: "select",
    searchList: () => {
      return auditObj.value;
    },
  },
  { label: "发布时间", field: "createtime", searchFormType: "daterange",sortable :'custom' },
];

const formModelItems = reactive([
  {
    label: "标题",
    field: "title",
    placeholder: "请输入标题",
    rules: [
      { required: true, message: "请先填写标题", trigger: "blur" },
      { min: 5, max: 20, message: "长度必须在5--20之间", trigger: "blur" },
    ],
  },
  {
    label: "副标题",
    field: "subtitle",
    placeholder: "请输入副标题",
    rules: [
      { required: true, message: "请先填写副标题", trigger: "blur" },
      { min: 10, max: 50, message: "长度必须在10--50之间", trigger: "blur" },
    ],
  },
  {
    label: "封面图",
    field: "coverimage",
    type: "cropper",
    placeholder: "请输入封面图",
  },
  {
    label: "分类",
    field: "category_id",
    placeholder: "请选择分类",
    type: "select",
    options: cateArray.value,
    rules: [{ required: true, message: "请先选择分类", trigger: "change" }],
  },

  {
    label: "标签",
    field: "tag",
    type: "tags",
    placeholder: "请输入标签",
  },
  {
    label: "作者",
    field: "author",
    placeholder: "请输入作者",
  },
  {
    label: "摘要",
    field: "desc",
    type: "textarea",
    placeholder: "请输入摘要",
  },
  {
    label: "内容正文",
    field: "content",
    type: "markdown",
    // default: "猫叔666",
    placeholder: "请输入内容正文",
  },
  {
    label: "状态",
    field: "status",
    type: "radio",
    default: 1,
    options: [
      { label: statusObj.value[1], value: 1 },
      { label: statusObj.value[0], value: 0 },
    ],
    placeholder: "请输入状态",
  },
]);

getCateList().then((res) => {
  if (res.code == 1) {
    console.log("res.data: ", res.data);
    res.data.forEach((item) => {
      cateList.value[item.id] = item.name;
      cateArray.value.push({ label: item.name, value: item.id });
    });
  }
});

const apiUrl = {
  list: "/content/list",
  add: "/content/add",
  edit: "/content/edit",
  del: "/content/del",
  remoteDataUrl: "/content/getcontent",
};

// 切换switch开关
const beforeChange = (row) => {
  // console.log(row);
  row.loading = true;
  return new Promise((resolve) => {
    changeStatus({
      id: row.id,
    })
      .then((res) => {
        row.loading = false;
        if (res.code == 1) {
          ElMessage.success(res.msg);
          return resolve(true);
        } else {
          ElMessage.error(res.msg);
          return resolve(false);
        }
      })
      .catch((err) => {
        row.loading = false;
        return resolve(false);
      });
  });
};

const srcList = ref([]);
const updateTableData = (data) => {
  srcList.value = data.map((x) => x.coverimage);
};

const initialIndex = ref(0);
const showImage = (index) => {
  initialIndex.value = index;
};

// 改变审核状态
const changeAuditStatus = (row, audit) => {
  if (audit == 1) {
    changeAudit({
      id: row.id,
      audit: 1,
    }).then((res) => {
      if (res.code == 1) {
        row.audit = 1;
        ElMessage.success(res.msg);
      } else {
        ElMessage.error(res.msg);
      }
    });
  } else {
    ElMessageBox.prompt("请输入拒绝原因", "温馨提示", {
      confirmButtonText: "提交",
      cancelButtonText: "取消",
      inputType: "textarea",
      inputValidator: (val) => {
        if (!val) return "请填写拒绝原因";
      },
    }).then(({ value }) => {
      changeAudit({
        id: row.id,
        audit: 2,
        reason: value,
      }).then((res) => {
        if (res.code == 1) {
          row.audit = 2;
          ElMessage.success(res.msg);
        } else {
          ElMessage.error(res.msg);
        }
      });
    });
  }
};
</script>
