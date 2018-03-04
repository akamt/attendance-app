<template>
    <el-main>
        <el-form @keyup.enter.native="login" ref="form" :model="form" label-width="100px">
            <el-form-item label="項目名">
                <el-input placeholder="経費項目名" v-model="form.name" clearable>
                </el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="add">Add</el-button>
            </el-form-item>
        </el-form>
    </el-main>
</template>

<script>
    import http from '../services/http'

    export default {
        data() {
            return {
                form:{
                    name:''
                }
            }
        },
        methods: {
            add() {
                let data = {
                    name: this.name
                };

                http.post('categories', data, res => {
                    console.log(res);
                })
            }
        }
    }
</script>