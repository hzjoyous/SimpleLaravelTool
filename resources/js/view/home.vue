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
        <el-main height="100%">
            <el-button @click="login">登陆系统</el-button>

            <el-row>
                <el-button>默认按钮</el-button>
                <el-button type="primary">主要按钮</el-button>
            </el-row>
        </el-main>

    </el-container>
</template>
<script>
export default {
    name: "home",
    methods:{
        login:function (){

        }
    }
}
</script>
