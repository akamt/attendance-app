<template>
    <el-main v-loading.fullscreen.lock="periodLoading">
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
        <el-table v-loading="listLoading" class="tb-edit" :data="tableData" highlight-current-row
                  @row-click="handleCurrentChange" style="width:100%;">
            <el-table-column label="日付" sortable width="220">
                <template slot-scope="scope">
                    <el-date-picker v-model="scope.row.use_day" value-format="yyyy-MM-dd" type="date"
                                    placeholder="対象日を選択" @change="handleEdit(scope.$index, scope.row)">
                    </el-date-picker>
                    <span>{{ scope.row.use_day }}</span>
                </template>
            </el-table-column>
            <el-table-column
                    prop="name"
                    label="経費名"
                    width="180">
                <template slot-scope="scope">
                    <el-input v-model="scope.row.name" placeholder="経費名"
                              @change="handleEdit(scope.$index, scope.row)">
                    </el-input>
                    <span>{{ scope.row.name }}</span>
                </template>
            </el-table-column>
            <el-table-column
                    prop="payment"
                    label="支払先">
                <template slot-scope="scope">
                    <el-input v-model="scope.row.payment" placeholder="支払先"
                              @change="handleEdit(scope.$index, scope.row)">
                    </el-input>
                    <span>{{ scope.row.payment }}</span>
                </template>
            </el-table-column>
            <el-table-column
                    prop="value"
                    label="値段">
                <template slot-scope="scope">
                    <el-input v-model.number="scope.row.value" placeholder="値段"
                              @change="handleEdit(scope.$index, scope.row)">
                    </el-input>
                    <span>{{ scope.row.value }}</span>
                </template>
            </el-table-column>
            <el-table-column
                    prop="category_name"
                    label="経費項目"
                    width="180">
                <template slot-scope="scope">
                    <el-select v-model="scope.row.category_id" placeholder="Select">
                        <el-option
                                v-for="item in options"
                                :key="item.name"
                                :label="item.name"
                                :value="item.id">
                        </el-option>
                    </el-select>
                    <span>{{ scope.row.category_name }}</span>
                </template>
            </el-table-column>
            <el-table-column
                    fixed="right"
                    label="操作"
                    width="120">
                <template slot-scope="scope">
                    <el-button @click="updateExpense(scope.row)" type="text" size="small">
                        Save
                    </el-button>
                    <el-button @click="deleteExpense(scope.row)" type="text" size="small">
                        Delete
                    </el-button>
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
                options: [],
                periodList: [],
                period: '',
                tableData: [],
                periodLoading: false,
                listLoading: false
            }
        },
        created() {
            this.periodLoading = true;

            // TODO 同時に行えるように
            http.get('period/list', res => {
                this.periodLoading = false;
                this.periodList = res.data
            });

            http.get('categories', res => {
                this.options = res.data;
            });
        },
        methods: {
            periodChange() {
                let data = {
                    period: this.period
                };

                this.listLoading = true;
                http.post('expense/list', data, res => {
                    this.tableData = res.data;
                    this.listLoading = false;
                }, error => {
                    console.log(error);
                })
            },
            handleCurrentChange(row, event, column) {
                console.log(row, event, column, event.currentTarget)
            },
            handleEdit(index, row) {
                console.log(index, row);
            },
            deleteExpense(row) {
                http.delete('expenses/' + row.id, null, res => {
                    console.log(res);
                });
            },
            updateExpense(row) {
                http.put('expenses/' + row.id, row, res => {
                    console.log(res);
                });
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

    /* TODO scssに対応 */
    .tb-edit .el-input {
        display: none;
    }

    .tb-edit .current-row .el-input {
        display: block;
    }

    .tb-edit .current-row .el-input + span {
        display: none;
    }

    .tb-edit .el-select {
        display: none;
    }

    .tb-edit .current-row .el-select {
        display: block;
    }

    .tb-edit .current-row .el-select + span {
        display: none;
    }
</style>