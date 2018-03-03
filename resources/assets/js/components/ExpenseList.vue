<template>
    <el-main>
        <el-table :data="tableData" height="250" style="width: 100%">
            <el-table-column
                    prop="created_at"
                    label="日付"
                    width="180">
            </el-table-column>
            <el-table-column
                    prop="name"
                    label="経費名"
                    width="180">
            </el-table-column>
            <el-table-column
                    prop="kind"
                    label="経費項目"
                    width="180">
            </el-table-column>
            <el-table-column
                    prop="value"
                    label="値段">
            </el-table-column>
        </el-table>
    </el-main>
</template>

<script>
    import http from '../services/http'

    export default {
        data() {
            return {
                tableData: []
            }
        },
        created() {
            http.get('expenses', res => {
                this.tableData = res.data;
            })
        }
    }
</script>