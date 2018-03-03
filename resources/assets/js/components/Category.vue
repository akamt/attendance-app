<template>
    <div>
        <el-input placeholder="経費項目名" v-model="name" clearable>
        </el-input>
        <el-button type="primary" @click="add">Add</el-button>
    </div>
</template>

<script>
    import http from '../services/http'

    export default {
        data() {
            return {
                name: ''
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