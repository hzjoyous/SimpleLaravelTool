<template>
    <el-container>
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
        <span v-text="about"></span>
    </el-container>
</template>
<script>
export default {
    data() {
        return {
            about: "default about message"
        };
    }, mounted() {
        this.$remoteService.about().then((r) => {
            this.about = r.about
        }).catch(e => {
            console.log(e)
        })
    }
}
</script>
