<template>
    <el-main>
        <el-form ref="categoryForm" :model="form" label-width="100px">
            <el-form-item label="項目名"
                          prop="name"
                          :rules="{required: true, message: 'カテゴリー名を入力してください', trigger: 'blur'}">
                <el-input placeholder="経費項目名" v-model="form.name" clearable>
                </el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="validate">Add</el-button>
            </el-form-item>
        </el-form>
    </el-main>
</template>

<script>
    import http from '../services/http'

    export default {
        data() {
            return {
                form: {
                    name: ''
                }
            }
        },
        methods: {
            validate() {
                this.$refs['categoryForm'].validate((valid) => {
                    if (valid) {
                        this.add();
                    }
                });
            },
            add() {
                let data = {
                    name: this.form.name
                };

                http.post('categories', data, res => {
                    this.$message({
                        message: '保存しました',
                        type: 'success'
                    });
                    this.form.name = '';
                })
            }
        }
    }
</script>