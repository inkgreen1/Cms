<template>
  <el-container class="layout-container-demo" style="height: 100vh">
    <el-aside class="sidebar" :class="{ 'is-collapse': isCollapse }">
      <div class="flex flex-center logo">
        <img src="@/assets/logo.png" />
        <Transition name="slide">
          <span v-if="!isCollapse">CMS管理系统</span>
        </Transition>
      </div>
      <el-scrollbar style="height: calc(100vh - 60px)">
        <el-menu
          :default-active="currentMenuIndex"
          :collapse="isCollapse"
          :router="true"
        >
          <template v-for="(item, index) in menu" :key="index">
            <el-menu-item :index="item.path" v-if="!item.children">
              <el-icon v-if="item.icon">
                <component :is="item.icon"></component>
              </el-icon>
              <template #title>
                <span> {{ item.name }} </span>
              </template>
            </el-menu-item>
            <el-sub-menu :index="index + 1 + ''" v-else>
              <template #title>
                <el-icon v-if="item.icon">
                  <component :is="item.icon"></component>
                </el-icon>
                <span>{{ item.name }}</span>
              </template>

              <el-menu-item
                :index="submenu.path"
                v-for="(submenu, ind) in item.children"
                :key="ind"
              >
                <el-icon v-if="submenu.icon">
                  <component :is="submenu.icon"></component>
                </el-icon>
                <span> {{ submenu.name }}</span></el-menu-item
              >
            </el-sub-menu>
          </template>
        </el-menu>
      </el-scrollbar>
    </el-aside>

    <el-container>
      <el-header style="font-size: 12px" class="flex flex-between">
        <div class="flex flex-start">
          <span @click="toggleSiderbarWidth" class="flex-center icon mr-5">
            <el-icon :size="20">
              <Fold v-if="!isCollapse" />
              <Expand v-else />
            </el-icon>
          </span>

          <el-breadcrumb separator="/" id="ms-test">
            <el-breadcrumb-item
              v-for="(item, index) in currentMenu"
              :key="index"
              class="flex flex-center"
            >
              <span class="flex flex-center">
                <el-icon :size="20" v-if="item.icon" class="mr-5">
                  <component :is="item.icon"></component>
                </el-icon>
                {{ item.name }}
              </span>
            </el-breadcrumb-item>
          </el-breadcrumb>
        </div>

        <div class="flex flex-end">
          <right></right>
        </div>
      </el-header>

      <el-main class="main-box">
        <el-scrollbar>
          <router-view></router-view>
        </el-scrollbar>
      </el-main>

      <el-footer class="flex flex-center">
        <span> Copyright © 2024-2025 版权所有 写代码的猫叔 </span>
      </el-footer>
    </el-container>
  </el-container>
</template>

<script setup>
import { ref, reactive } from "vue";
import { useRouter, useRoute, onBeforeRouteUpdate } from "vue-router";
import {userStore} from "@/stores/user"
import right from './right.vue'

const router = useRouter();
const route = useRoute();
const store = userStore()
// console.log('route: ', route);
const currentMenuIndex = ref(route.path);
const currentMenu = ref([]);

let menuArray = [
  {
    name: "数据面板",
    icon: "HomeFilled",
    path: "/dashboard",
  },
  {
    name: "分类管理",
    icon: "MoreFilled",
    path: "/cate",
  },
  {
    name: "内容管理",
    icon: "Coin",
    path: "/content",
  },
  {
    name: "权限管理",
    icon: "Grid",
    path: "/role",
  },{
    name: "管理员管理",
    icon: "HelpFilled",
    path: "/adminuser",
  },
  {
    name: "个人中心",
    icon: "Avatar",

    children: [
      {
        name: "我的信息",
        icon:"InfoFilled",
        path: "/personal/info",
      },
      {
        name: "绑定手机",
        icon:"Iphone",
        path: "/personal/bindphone",
      },
      {
        name: "修改密码",
        icon:"Lock",
        path: "/personal/resetpwd",
      },
      {
        name: "登录日志",
        icon:"Tickets",
        path: "/personal/loginlog",
      },
    ],
  },
  {
    name: "系统管理",
    icon: "Tools",

    children: [
      {
        name: "站点管理",
        icon: "Setting",
        path: "/system/site",
      },
      {
        name: "附件管理",
        icon: "Setting",
        path: "/system/files",
      },
      {
        name: "管理员日志",
        icon: "Setting",
        path: "/system/adminlog",
      }
    ]
  }
]

let rules = store.userPermission

const filerMenus = (menus) => {
  return menus.reduce((acc, menu) => {
    const newMenu = { ...menu }
    if (menu.path && (rules.includes(menu.path) || menu.path.startsWith('/personal'))) {
      acc.push(newMenu)
    }

    if (menu.children && menu.children.length > 0) {
      let fileredChildren = filerMenus(menu.children)
      if (fileredChildren.length > 0) {
        
        newMenu.children = fileredChildren
        acc.push(newMenu)
      }
    }
    //console.log('acc: ', acc);
    return acc
  },[])
}

// 
let filteredMenus = filerMenus(menuArray);
// console.log('filteredMenus: ', filteredMenus);
const menu = reactive(filteredMenus);

const getCurrentMenu = () => {
  const currentPath = currentMenuIndex.value;
  for (const key in menu) {
    if (Object.hasOwnProperty.call(menu, key)) {
      const element = menu[key];
      if (typeof element.children !== "undefined") {
        for (const k in element.children) {
          if (Object.hasOwnProperty.call(element.children, k)) {
            const child = element.children[k];
            if (child.path == currentPath) {
              currentMenu.value = [element, child];
              document.title = child.name
              return;
            }
          }
        }
      } else if (element.path == currentPath) {
        currentMenu.value = [element];
        document.title = element.name
        return;
      }
    }
  }
};

getCurrentMenu();

onBeforeRouteUpdate((to) => {
  currentMenuIndex.value = to.path;
  getCurrentMenu();
});
const routerTo = (path) => {
  router.push(path);
};

const isCollapse = ref(false);
const toggleSiderbarWidth = () => {
  isCollapse.value = !isCollapse.value;
};
</script>

<style scoped  lang="scss">
.layout-container-demo .el-menu {
  border-right: none;
}

.layout-container-demo .toolbar {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  height: 100%;
  right: 20px;
}

.sidebar {
  width: 200px;
  padding: 0 7px;
  transition: width 0.3s ease;
  overflow: hidden;
  background: #f0f0f0;

  &.is-collapse {
    width: 60px;

    span {
      width: 0px;
      margin-left: 0;
      opacity: 0;
    }
  }

  .logo {
    height: 60px;

    span {
      font-weight: bold;
      color: var(--el-color-primary);
      margin-left: 10px;
      white-space: nowrap;
    }
  }

  .slide-enter-active,
  .slide-leave-active {
    transition: all 0.3s ease;
  }
}

.icon {
  cursor: pointer;
  padding: 5px 8px;
  border-radius: 5px;
  display: inline-flex;

  &:hover {
    background: var(--el-menu-hover-bg-color);
  }
}
</style>

<style>

.el-menu-item {
  border-radius: 5px;
  margin: 8px 0;

  &.is-active {
    background-color: var(--el-menu-active-bg-color);
    color: #fff;
  }
}
.el-sub-menu__title {
  border-radius: 5px;
}

.el-popper.is-pure {
  /* padding: 0 10px; */
  border-radius: 10px;
}

.el-menu--popup {
  box-shadow: none;
  padding: 5px 10px;
}

.main-box{
  background-color: #f5f5f5;
}
</style>
