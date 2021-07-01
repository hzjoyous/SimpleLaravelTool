<template>

    <el-container direction="vertical">
        <el-header style="padding: 0">
            <el-menu
                :default-active="this.$route.path"
                class="el-menu-demo"
                mode="horizontal"
                background-color="#545c64"
                text-color="#fff"
                router
                active-text-color="#ffd04b">
                <el-menu-item style="padding-left: 10px;padding-right: 10px;" index="/home">home</el-menu-item>
                <el-menu-item style="padding-left: 10px;padding-right: 10px;" index="/about">about</el-menu-item>
                <el-menu-item style="padding-left: 10px;padding-right: 10px;" index="/login">login</el-menu-item>
            </el-menu>

        </el-header>
        <el-header>WELCOME_USE_FORGE_LOGIN_SYSTEM</el-header>
        <el-main height="100%">
            <el-button type="warning" plain @click="goUserList">用户列表</el-button>
            <el-button type="danger" plain @click="logout">退出系统</el-button>
        </el-main>
    </el-container>
</template>

<script>
export default {
    name: "login",
    data: function () {
        return {}
    }, mounted: function () {
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
