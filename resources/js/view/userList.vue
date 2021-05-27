<template>
    <el-container direction="vertical">
        <el-main height="100%">

            <el-button @click="logout">退出登陆</el-button>
            <el-container hidden-sm-and-down="1000">
                <el-main>
                    <el-table
                        :data="userList"
                        border
                        height="600"
                        style="width: 100%">
                        <el-table-column
                            fixed
                            prop="user_id"
                            label="userId"
                            width="150">
                        </el-table-column>
                        <el-table-column
                            prop="user_name"
                            label="username"
                            width="150">
                        </el-table-column>

                        <el-table-column
                            fixed="right"
                            label="操作">
                            <template slot-scope="scope">

                                <el-link type="primary" @click="handleClick(scope.row)"
                                         :disabled="scope.row.have_permission">申请权限
                                </el-link>
                                <el-link @click="forgeLogin(scope.row.user_id)" type="danger"
                                         :disabled="!scope.row.have_permission">伪登陆
                                </el-link>

                            </template>
                        </el-table-column>
                    </el-table>
                </el-main>

            </el-container>
        </el-main>
        <el-dialog
            title="工单申请"
            :visible.sync="dialogVisible"
            width="90%"
            center
            :before-close="handleClose">
            <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="100px" label-position="left">
                <span>你当前申请的目标用户id:</span><span style="color:red" v-text="ruleForm.authorization_id">121</span>

                <el-form-item label="申请理由" prop="cause">
                    <el-input v-model="ruleForm.cause" autocomplete="off"></el-input>
                </el-form-item>
                <el-form-item>
                    <el-button @click="dialogVisible = false">取 消</el-button>
                    <el-button type="primary" @click="submitApply('ruleForm')">确 定</el-button>
                </el-form-item>
            </el-form>
        </el-dialog>
    </el-container>


</template>
<script>
export default {
    name:"userList",
    data() {
        return {
            userList: [{user_id:1,have_permission:true,user_name:"xiaoming"}],
            dialogVisible: false,
            ruleForm: {
                authorization_id: 0,
                cause: "",
            },
            rules: {
                cause: [
                    {required: true, message: '请输入申请理由', trigger: 'blur'},
                ]
            }

        }
    },
    mounted: function () {

    },
    methods: {
        forgeLogin: function (userId) {

        },
        handleClick(row) {
            // this.resetForm()
            this.ruleForm.authorization_id = row.user_id
            this.dialogVisible = true
        },
        logout: function () {
        },
        handleClose(done) {
            this.$confirm('确认关闭？')
                .then(_ => {
                    done();
                })
                .catch(_ => {
                });
        },
        submitApply: function (formName) {
            console.log(formName)
            console.log(this.ruleForm.authorization_id, this.ruleForm.cause);
            this.$refs[formName].validate((valid) => {
                if (valid) {

                    then(r => {
                        console.log(r)
                        this.dialogVisible = false
                        location.reload();
                        //
                    }).catch()
                } else {
                    alert('error submit!');
                    return false;
                }
            });
        }
    }
}
</script>
