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
                tableData: []
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

                http.post('expense/list', data, res => {
                    this.tableData = res.data;
                }, error => {
                    console.log(error);
                })
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