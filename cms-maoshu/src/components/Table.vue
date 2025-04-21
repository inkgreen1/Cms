<template>
  <Search
    v-if="showSearch"
    :columns="columns"
    @submitSearch="submitSearch"
  ></Search>
  <div class="table-header flex flex-between mb-10">
    <div></div>
    <div class="btn-group">
      <el-button @click="getDataCallback">
        <el-icon>
          <Refresh></Refresh>
        </el-icon>
        刷新
      </el-button>
      <el-button type="success" v-if="hasPermission('add') && apiUrl.add" @click="handleAdd">
        <el-icon>
          <CirclePlus></CirclePlus>
        </el-icon>
        新增
      </el-button>
      <el-button
        type="danger"
        v-if="hasPermission('del') && apiUrl.del"
        :disabled="multipleSelection.length == 0"
        @click="handelDeleteSelection"
      >
        <el-icon>
          <Delete></Delete>
        </el-icon>
        批量删除
      </el-button>
    </div>
  </div>
  <el-table
    ref="multipleTableRef"
    :data="tableData"
    style="width: 100%"
    v-loading="tableLoading"
    :row-key="treeRowKey"
    default-expand-all
    @selection-change="handleSelectionChange"
    v-loading.fullscreen.lock="fullscreenLoading"

    :default-sort="defaultSort"
    @sort-change="handleSortChange"
  >
    <el-table-column type="selection" width="55" />
    <el-table-column
      :label="item.label"
      :width="item.width"
      v-for="(item, index) in columns"
      :key="index"
      :prop="item.field"
      :sortable="typeof item.sortable != 'undefined'?item.sortable:false"
    >
      <template #default="scope">
        <template v-if="$slots[item.field]">
          <slot
            :name="item.field"
            :row="scope.row"
            :index="scope.$index"
          ></slot>
        </template>
        <template v-else>
          <div
            v-html="item.temp(scope.row, scope.$index)"
            v-if="item.temp"
          ></div>
          <template v-else>
            {{ scope.row[item.field] }}
          </template>
        </template>
      </template>
    </el-table-column>
    <el-table-column label="操作">
      <template #default="scope">
        <el-button
          size="small"
          v-if="hasPermission('edit') &&  apiUrl.edit && scope.row.edit !== false"
          @click="handleEdit(scope.row, scope.$index)"
          >修改</el-button
        >
        <el-popconfirm
          title="确定要删除吗?"
          confirm-button-text="确定"
          cancel-button-text="取消"
          @confirm="handelDelete(scope.row, scope.$index)"
          v-if="hasPermission('del') &&  apiUrl.del && scope.row.del !== false"
        >
          <template #reference>
            <el-button size="small" type="danger">删除</el-button>
          </template>
        </el-popconfirm>
      </template>
    </el-table-column>
  </el-table>

  <!-- 分页 -->
  <el-pagination
    v-model:current-page="currentPage"
    v-model:page-size="pageSize"
    :page-sizes="[10, 15, 20, 50, 100, 200, 300, 400]"
    :background="true"
    layout="total, sizes, prev, pager, next, jumper"
    :total="total"
    @size-change="handleSizeChange"
    @current-change="handleCurrentChange"
    class="mt-10"
    v-if="showPages"
  />
  <el-dialog
    v-model="dialogFormVisible"
    :title="dialogtitle"
    @open="dialogFormOpened"
  >
    <Form
      ref="formRef"
      :formModelItems="formModelItems"
      :submitUrl="submitUrl"
      @submitCallback="submitCallback"
      v-if="dialogFormVisible"
    ></Form>
  </el-dialog>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { get, post } from "@/utils/request";
import { hasPermission } from "@/utils/tool";
import { ElMessage, ElMessageBox } from "element-plus";

import Form from "@/components/Form.vue";
import Search from "@/components/Search.vue";

const props = defineProps({
  columns: { type: Array, required: true, default: [] },
  apiUrl: { type: Object, default: {} },
  formModelItems: { type: Array, default: [] },
  treeRowKey: { type: String, default: "id" },
  showPages: { type: Boolean, default: true },
  showSearch: { type: Boolean, default: true },
  defaultSort: { type: Object, default: {} },
});

const emit = defineEmits(["update:tableData", "dialogFormOpened"]);

// 多选数据
const multipleTableRef = ref();
const multipleSelection = ref([]);
const handleSelectionChange = (val) => {
  multipleSelection.value = val;
};
// 表格数据
const tableData = ref([]);
const tableLoading = ref(false);

const searchField = ref({});

let tableSortOrder = {...props.defaultSort}
// 获取列表
const getData = (callback) => {
  if (props.apiUrl.list) {
    tableLoading.value = true;

    let data = {}
    data.filter = searchField.value
    if (props.showPages) {
      data.page = currentPage.value;
      data.limit = pageSize.value;
    }
    if(Object.keys(tableSortOrder).length){
      data.order = tableSortOrder
    }

    post({
      url: props.apiUrl.list,
      data: data,
    }).then((res) => {
      tableLoading.value = false;
      if (res.code == 1) {
        tableData.value = res.data;
        total.value = res.total;
      }

      if (callback && typeof callback == "function") {
        callback(res.data);
      }
    });
  }
};

const handleSortChange = (val)=>{
  const  {column, prop, order } = val
  // console.log(column, prop, order);
  if(column.sortable == 'custom'){

    // tableSortOrder
    tableSortOrder = {prop,order}
    getData()
  }
}

// 获取列表（有回调函数）
const getDataCallback = () => {
  getData((data) => {
    emit("update:tableData", data);
  });
};

onMounted(() => {
  getDataCallback();
});

// 删除一条
const handelDelete = (row) => {
  //
  if (props.apiUrl.del) {
    post({
      url: props.apiUrl.del,
      data: {
        id: row.id,
      },
    }).then((res) => {
      if (res.code == 1) {
        getDataCallback();
      } else {
        ElMessage.error(res.msg);
      }
    });
  }
};

// 批量删除
const handelDeleteSelection = () => {
  if (props.apiUrl.del) {
    ElMessageBox.confirm("确定要删除吗?", "提示", {
      confirmButtonText: "确定",
      cancelButtonText: "取消",
      type: "warning",
    })
      .then(() => {
        let ids = multipleSelection.value.map((x) => x.id);
        // console.log('ids: ', ids);

        post({
          url: props.apiUrl.del,
          data: {
            id: ids,
          },
        }).then((res) => {
          if (res.code == 1) {
            getDataCallback();
          } else {
            ElMessage.error(res.msg);
          }
        });
      })
      .catch(() => {});
  }
};

const dialogFormVisible = ref(false);
const dialogtitle = ref("");
const formRef = ref();
const formData = ref({});

const submitUrl = ref("");
// 添加
const handleAdd = () => {
  dialogFormVisible.value = true;
  dialogtitle.value = "新增";

  // formData.value = {};

  const formdatas = {};
  props.formModelItems.forEach((item) => {
    formdatas[item.field] = item.default;
  });

  formData.value = formdatas;

  submitUrl.value = props.apiUrl.add;
};

const fullscreenLoading = ref(false);
// 编辑
const handleEdit = (row, index) => {
  dialogtitle.value = "修改";

  submitUrl.value = props.apiUrl.edit;

  if (props.apiUrl.remoteDataUrl) {
    fullscreenLoading.value = true;
    get({
      url: props.apiUrl.remoteDataUrl,
      data: {
        id: row.id,
      },
    }).then((res) => {
      fullscreenLoading.value = false;
      if (res.code == 1) {
        formData.value = { ...row, ...res.data };
      } else {
        formData.value = row;
      }

      dialogFormVisible.value = true;
    });
  } else {
    formData.value = row;
    dialogFormVisible.value = true;
  }
};

const dialogFormOpened = () => {
  formRef.value?.initFormModelData(formData.value);
  emit("dialogFormOpened", formData.value);
};

const submitCallback = () => {
  dialogFormVisible.value = false;
  getDataCallback();
};

// 提交搜索
const submitSearch = (data) => {
  searchField.value = {}
  // console.log('搜索的data: ', data);
  for (const key in data) {
    if (Object.hasOwnProperty.call(data, key)) {
      const element = data[key];

      for (const k in props.columns) {
        if (Object.hasOwnProperty.call(props.columns, k)) {
          const ele = props.columns[k];
          if (ele.field == key) {
            if (typeof ele.search !== "undefined") {
              searchField.value[key] = {
                opt: ele.search,
                val: element,
              };
            } else {
              searchField.value[key] = element;
            }

            break;
          }
        }
      }
    }
  }
  getData();
};

const currentPage = ref(1);
const pageSize = ref(15);
const total = ref(0);
// 下面是分页相关的
const handleSizeChange = () => {
  getData();
};
const handleCurrentChange = () => {
  getData();
};
</script>
