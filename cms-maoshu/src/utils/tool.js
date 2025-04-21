import {
  userStore
} from "@/stores/user"
import {
  useRoute
} from "vue-router"
// 递归获取角色组列表
// data: 角色组列表
// index: 递归层级
export function getRoles (data, index = 0) {
    let opts = [];
    index++;
  
    let arr = [];
    for (let i = 0; i < index; i++) {
      if (i == 0) {
        arr.push("└");
      } else {
        arr.push("┴");
      }
    }
  
    data.forEach((item) => {
      opts.push({
        label: arr.join("") + " " + item.name,
        value: item.id,
      });
  
      if (item.children && item.children.length > 0) {
        opts.push(...getRoles(item.children, index));
      }
    });
    return opts;
  };


  export const pwdRules = [
    { required: true, message: '请输入密码', trigger: 'blur' },
    { min:6, max:30, message: '密码的长度至少是6位，最多是30位', trigger: 'blur' },
    { pattern:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d@$!%*?&]{6,30}$/, message: '密码必须包含大小写字母、数字', trigger: 'blur' },
  ]



const store = userStore()
export const hasPermission = (name, path = null) => {
  
  
  if (!path) {
    const route = useRoute()
    path = route.path
  }

  if (path.startsWith('/personal')) {
    return true
  }

  let rules = store.userPermission
  // console.log('rules: ',path+'/'+name, rules);

  return rules.includes(path+'/'+name)
}