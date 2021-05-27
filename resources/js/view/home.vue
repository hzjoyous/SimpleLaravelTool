<template>

    <el-container direction="vertical">
        <el-header>FORGE_LOGIN_SYSTEM</el-header>
        <el-main height="100%">
            <el-button @click="login">登陆系统</el-button>

            <el-row>
                <el-button>默认按钮</el-button>
                <el-button type="primary">主要按钮</el-button>
                <el-button type="success">成功按钮</el-button>
                <el-button type="info">信息按钮</el-button>
                <el-button type="warning">警告按钮</el-button>
                <el-button type="danger">危险按钮</el-button>
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
