<template>

    <el-container direction="vertical">
        <el-header>FORGE_LOGIN_SYSTEM</el-header>
        <el-main height="100%">

            <el-button @click="testIos">iosBtn</el-button>

        </el-main>

    </el-container>
</template>
<script>
export default {
    name: "home",
    methods: {
        testIos: function () {
            androidToken.weidengluToken("abcdefghijklmnopqistuvwxyz1234567890")

            let androidTokenType = typeof androidToken
            let msg = '开始尝试调用androidToken,check typeof androidToken:' + androidTokenType + "\n";
            if (androidTokenType !== 'undefined') {
                let androidTokenWeidengluTokenTypeof = typeof androidToken.weidengluToken
                if (androidTokenWeidengluTokenTypeof !== 'undefined') {
                    androidToken.weidengluToken("abcdefghijklmnopqistuvwxyz1234567890")
                }
                msg += ' androidTokenWeidengluTokenTypeof:' + androidTokenType
            }

            this.$message(msg);
        }
    }
}
</script>
