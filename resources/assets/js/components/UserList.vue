<template>
    <el-main>
        <el-table v-loading="listLoading" :data="tableData" highlight-current-row height="100%"
                  @current-change="handleCurrentChange">
            <span slot="empty">
                ユーザーがいません
            </span>
            <el-table-column
                    fixed
                    type="index">
            </el-table-column>
            <el-table-column
                    prop="name"
                    label="名前">
            </el-table-column>
        </el-table>
    </el-main>
</template>

<script>
    import http from '../services/http';

    export default {
        data() {
            return {
                tableData: [],
                listLoading: false
            }
        },
        created() {
            this.listLoading = true;
            http.get('users', res => {
                this.listLoading = false;
                this.tableData = res.data;
            });
        },
        methods: {
            handleCurrentChange(row) {
                this.$router.push('users/' + row.id + '/list');
            }
        }
    }
</script>

<style>
    .el-table__row {
        cursor: pointer;
    }
</style>