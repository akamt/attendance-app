<template>
    <el-main>
        <el-table v-loading="listLoading" class="tb-edit" :data="tableData" highlight-current-row
                  style="width:100%;">
            <span slot="empty">
                ユーザーがいません
            </span>
            <el-table-column
                    prop="name"
                    label="名前"
                    width="180">
                <template slot-scope="scope">
                    <span @click="toList(scope.row.id)">{{ scope.row.name }}</span>
                </template>
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
            toList(id) {
                this.$router.push('users/' + id + '/list');
            }
        }
    }
</script>

<style></style>