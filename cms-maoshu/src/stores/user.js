import { ref,reactive, computed } from 'vue'
import { defineStore } from 'pinia'

export const userStore = defineStore('userinfo', () => {
  const userInfo = reactive({})
  const userName = computed(()=>userInfo.username)
  const nickName = computed(()=>userInfo.nickname)
  const userRoleId = computed(()=>userInfo.role_id)

  const setUserinfo = (info)=>{
    Object.assign(userInfo,info)
  }

  const clearUserinfo = ()=>{
    for(const k in userInfo){
      delete userInfo[k]
    }
  }

  const userPermission = ref(null)
  const setUserPermission = (rules) => {
    userPermission.value = ['/', '/dashboard',...rules]
  }

  return {
    userInfo,
    userName,
    nickName,
    userRoleId,
    setUserinfo,
    clearUserinfo,

    userPermission,
    setUserPermission
  }
})
