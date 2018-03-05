<template>
    <el-main>
        <div class="selector-wrapper">
            <el-select v-model="period" @change="periodChange" clearable placeholder="対象月を選択">
                <el-option
                        v-for="item in periodList"
                        :key="item.month"
                        :label="item.month"
                        :value="item.month">
                </el-option>
            </el-select>
        </div>
        <el-table v-loading="loading" :data="tableData" height="100%" style="width: 100%">
            <el-table-column
                    prop="use_day"
                    label="日付"
                    sortable
                    width="180">
            </el-table-column>
            <el-table-column
                    prop="name"
                    label="経費名"
                    width="180">
            </el-table-column>
            <el-table-column
                    prop="payment"
                    label="支払先">
            </el-table-column>
            <el-table-column
                    prop="value"
                    label="値段">
            </el-table-column>
            <el-table-column
                    prop="category_name"
                    label="経費項目"
                    width="180">
            </el-table-column>
            <el-table-column
                    fixed="right"
                    label="操作"
                    width="120">
                <template slot-scope="scope">
                    <el-button @click="editExpense" type="text" size="small">Edit</el-button>
                    <el-button @click="deleteExpense" type="text" size="small">Delete</el-button>
                </template>
            </el-table-column>
        </el-table>
    </el-main>
</template>

<script>
    import http from '../services/http'

    export default {
        data() {
            return {
                periodList: [],
                period: '',
                tableData: [],
                loading: false
            }
        },
        created() {
            http.get('period/list', res => {
                this.periodList = res.data
            });
        },
        methods: {
            periodChange() {
                let data = {
                    period: this.period
                };

                this.loading = true;
                http.post('expense/list', data, res => {
                    this.tableData = res.data;
                    this.loading = false;
                }, error => {
                    console.log(error);
                })
            },
            editExpense() {
                // TODO call API
            },
            deleteExpense() {
                // TODO call API
            }
        }
    }
</script>

<style type="scss">
    .selector-wrapper {
        position: absolute;
        right: 20px;
        top: 10px;
        width: 220px;
    }
</style>