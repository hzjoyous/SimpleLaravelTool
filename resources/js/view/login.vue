<template>

    <el-container direction="vertical">
        <el-header>WELCOME_USE_FORGE_LOGIN_SYSTEM</el-header>
        <el-main height="100%">
            <el-button type="warning" plain @click="goUserList">用户列表</el-button>
            <el-button type="danger" plain @click="logout">退出系统</el-button>
        </el-main>
    </el-container>
</template>

<script>
export default {
    name:"login",
    data: function () {
        return {
            access_token: '{{$access_token}}',
            refresh_token: '{{$refresh_token}}',
            expires: '{{$expires}}',
        }
    }, mounted: function () {
        this.saveToken()
    }, methods: {
        saveToken: function () {
        },
        logout: function () {
        },
        goUserList: function () {
        }
    }
}
</script>
