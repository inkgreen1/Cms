import {
  createRouter,
  createWebHistory
} from 'vue-router'

import {
  getToken,
  setToken,
  removeToken
} from '@/utils/token'
import {
  userStore
} from "@/stores/user"
import {
  getUserinfo
} from "@/api/user";

import {
  getFullRulelistbyid
} from "@/api/role";
const router = createRouter({
  history: createWebHistory(
    import.meta.env.BASE_URL),
  routes: [{
      path: '/',
      component: () => import('@/layout/index.vue'),
      redirect: '/dashboard',
      children: [{
          path: '/dashboard',
          name: 'dashboard',
          component: () => import("@/views/DashboardView.vue")
        },
        {
          path: '/cate',
          name: 'cate',
          component: () => import('@/views/CategoryView.vue')
        },
        {
          path: '/content',
          name: 'content',
          component: () => import('@/views/ContentView.vue')
        },
        {
          path: '/role',
          name: 'role',
          component: () => import('@/views/RoleView.vue')
        },
        {
          path: '/adminuser',
          name: 'adminuser',
          component: () => import('@/views/AdminuserView.vue')
        },
        {
          path: '/personal/info',
          name: 'info',
          component: () => import('@/views/personal/InfoView.vue')
        },
        {
          path: '/personal/bindphone',
          name: 'bindphone',
          component: () => import('@/views/personal/BindphoneView.vue')
        },
        {
          path: '/personal/resetpwd',
          name: 'resetpwd',
          component: () => import('@/views/personal/ResetpwdView.vue')
        },
        {
          path: '/personal/loginlog',
          name: 'loginlog',
          component: () => import('@/views/personal/LoginlogView.vue')
        },
        {
          path: '/system/site',
          name: 'site',
          component: () => import('@/views/system/SiteView.vue')
        },
        {
          path: '/system/files',
          name: 'files',
          component: () => import('@/views/system/FilesView.vue')
        },
        {
          path: '/system/adminlog',
          name: 'adminlog',
          component: () => import('@/views/system/AdminlogView.vue')
        },
        {
          path: '/about',
          name: 'about',
          component: () => import('../views/AboutView.vue')
        },
      ]
    },

    {
      path: "/login",
      name: "login",
      component: () => import("@/views/LoginView.vue"),
      meta: {
        title: '用户登录'
      }
    },

    {
      path: "/:pathMatch(.*)*",
      name: "not-found",
      component: () => import("@/views/NotFoundView.vue"),
      meta: {
        title: '页面未找到'
      }
    }
  ]
})

/**
 * 判断是否有权限访问路由
 * @param Array rules 
 * @param String path 
 * @returns Boolean
 */
const hasPathPermission = (rules, to) => {
  if (to.path.startsWith('/personal') || to.name == 'not-found') {
    return true
  }
  return rules.includes(to.path)
}

const pageTitle = "内容管理系统"
const whiteList = ['login', 'not-found']
router.beforeEach(async (to, from, next) => {
  // console.log('to: ', to);
  // console.log('from: ', from);

  if (to.meta.title) {
    document.title = to.meta.title + ' - ' + pageTitle
  }

  const token = getToken()
  if (!token) {
    if (whiteList.indexOf(to.name) !== -1) {
      next()
    } else {
      next(`/login?redirect=${to.path}`)
    }
  } else {
    // token存在
    if (to.name == 'login') {
      next('/')
    } else {
      let rules = []
      // 读取用户信息
      // pinia
      const store = userStore()
      if (store.userName) {
        rules = store.userPermission
        // console.log('rules: ', rules);
        if (hasPathPermission(rules, to)) {
          next()
        } else {
          next('/')
        }
      } else {
        let res = await getUserinfo()
        // console.log('res: ', res);
        if (res.code == 1) {
          setToken(res.data.token)
          store.setUserinfo(res.data)
          let rulesResult = await getFullRulelistbyid(store.userRoleId)
          if (rulesResult.code == 1) {
            rules = rulesResult.data.rules
            store.setUserPermission(rules)
            rules = store.userPermission
          }
          // console.log('rulesResult: ', rulesResult);
          if (hasPathPermission(rules, to)) {
            next()
          }
          else {
            next('/')
          }
          
        } else {
          removeToken()
          next(`/login?redirect=${to.path}`)
        }
      }
    }
  }
  // ...
  // 返回 false 以取消导航
  // return false
  // next()
})

export default router