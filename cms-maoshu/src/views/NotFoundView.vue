<template>
    <div class="h-full">
        
        <div class="title">
            <b>404</b> 页面未找到
        </div>
        <img src="/svg/404.svg"/>
        <div style="margin-top: 30px;">
            <router-link to="/">

                <el-button type="primary">
                    返回首页
                </el-button>
            </router-link>
        </div>
    </div>
</template>

<style scoped lang="scss">
    .h-full{
        height: 100vh;

        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    .title{
        font-size: 22px;
        margin-bottom: 20px;
        font-weight: bold;

        b{
            color:var(--el-color-primary);
        }
    }
</style>