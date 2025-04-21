<template>
    <div>
        <el-tooltip
            class="box-item"
            effect="dark"
            content="页面全屏"
            placement="bottom-end"
        >           
            <el-icon :size="20" @click="toggleFullScreen" class="mr-10"><FullScreen /></el-icon>    
        </el-tooltip>

        <el-dropdown>
            <span class="el-dropdown-link flex flex-center">
              <img :src="store.userInfo.avatar" class="small-avatar mr-5">
                <!-- <el-icon class="mr-5">
                    <UserFilled />
                </el-icon> -->

                {{ store.userName }}
                <el-icon class="el-icon--right">
                    <arrow-down />
                </el-icon>
            </span>
            <template #dropdown>
            <el-dropdown-menu>
                <el-dropdown-item>
                    <el-icon class="mr-5">
                        <UserFilled />
                    </el-icon>
                    个人中心
                </el-dropdown-item>
                <el-dropdown-item @click="logout">
                    <el-icon class="mr-5">
                        <SwitchButton />
                    </el-icon>
                    退出
                </el-dropdown-item>
            </el-dropdown-menu>
            </template>
        </el-dropdown>
    </div>
</template>

<script setup>
import {userStore} from "@/stores/user"
import {userLogout} from "@/api/user"
import {removeToken } from "@/utils/token"
import {useRouter} from 'vue-router'

const store = userStore()
const router = useRouter()
// 检查是否处于全屏模式的函数
function isFullScreen() {
  return document.fullscreenElement || document.webkitFullscreenElement || document.mozFullScreenElement || document.msFullscreenElement;
}

// 进入或退出全屏的函数
function toggleFullScreen() {
  let element = document.documentElement
//   let element = document.getElementById('ms-test')
  if (!isFullScreen()) {
    // 如果不是全屏，则尝试进入全屏
    if (element.requestFullscreen) {
      element.requestFullscreen();
    } else if (element.webkitRequestFullscreen) { // Safari
      element.webkitRequestFullscreen();
    } else if (element.mozRequestFullScreen) { // Firefox
      element.mozRequestFullScreen();
    } else if (element.msRequestFullscreen) { // IE/Edge
      element.msRequestFullscreen();
    }
  } else {
    // 如果已经是全屏，则退出全屏
    if (document.exitFullscreen) {
      document.exitFullscreen();
    } else if (document.webkitExitFullscreen) { // Safari
      document.webkitExitFullscreen();
    } else if (document.mozCancelFullScreen) { // Firefox
      document.mozCancelFullScreen();
    } else if (document.msExitFullscreen) { // IE/Edge
      document.msExitFullscreen();
    }
  }
}


const logout = ()=>{
    userLogout().then(res=>{
        removeToken()
        store.clearUserinfo()
        router.push('/login')

    })
}

</script>

<style>
.el-dropdown-link:focus-visible{
    outline: unset;
}
</style>

<style scoped  lang="scss">
.small-avatar{
  border-radius: 50%;
  width:22px;
  height: 22px;
}
</style>