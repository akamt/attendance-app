<template>
    <el-main v-loading.fullscreen.lock="periodLoading">
        <div class="selector-wrapper">
            <el-select v-model="period" @change="getList" clearable placeholder="対象月を選択">
                <el-option
                        v-for="item in periodList"
                        :key="item.month"
                        :label="item.month"
                        :value="item.month">
                </el-option>
            </el-select>
        </div>
        <div class="button-area">
            <el-button type="primary" :disabled="Object.keys(editData).length === 0" @click="updateExpense">
                Save
            </el-button>
            <el-button type="danger" :disabled="deleteData.length === 0" @click="confirmDelete">
                Delete
            </el-button>
        </div>
        <el-table v-loading="listLoading" class="tb-edit" :data="tableData" highlight-current-row
                  @row-click="handleCurrentChange" style="width:100%;" @selection-change="handleSelectionChange">
            <el-table-column
                    type="selection"
                    width="55">
            </el-table-column>
            <el-table-column label="日付" sortable>
                <template slot-scope="scope">
                    <el-date-picker v-model="scope.row.use_day" value-format="yyyy-MM-dd" type="date"
                                    placeholder="対象日を選択" @change="handleEdit(scope.$index, scope.row)"
                                    style="width:100%;">
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
                    <el-select v-model="scope.row.category_id" placeholder="Select"
                               @change="handleEdit(scope.$index, scope.row)">
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
        </el-table>
        <el-dialog title="経費削除" :visible.sync="dialogVisible" width="80%">
            <span>選択した経費を削除しますか？</span>
            <el-table :data="deleteData">
                <el-table-column property="use_day" label="日付"></el-table-column>
                <el-table-column property="name" label="経費名"></el-table-column>
                <el-table-column property="payment" label="支払先"></el-table-column>
                <el-table-column property="category_name" label="経費項目"></el-table-column>
                <el-table-column property="value" label="値段"></el-table-column>
            </el-table>
            <span slot="footer" class="dialog-footer">
                <el-button @click="dialogVisible = false">Cancel</el-button>
                <el-button type="danger" @click="deleteExpense">Delete</el-button>
            </span>
        </el-dialog>
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
                editData: {},
                deleteData: [],
                dialogVisible: false,
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
            handleSelectionChange(val) {
                this.deleteData = val;
            },
            initialize() {
                // 初期化
                this.editData = {};
                this.deleteData = {};
            },
            getList() {
                let data = {
                    period: this.period
                };

                this.initialize();
                this.listLoading = true;
                http.post('expense/list', data, res => {
                    this.tableData = res.data;
                    this.listLoading = false;
                }, error => {
                    console.log(error);
                })
            },
            handleEdit(index, row) {
                // 編集されたらデータを入れる
                // this.editData[row.id] = row;

                this.$set(this.editData, row.id, row);
                console.log(index, row);
            },
            handleCurrentChange(row, event, column) {
                console.log(row, event, column, event.currentTarget)
            },
            deleteExpense() {
                this.dialogVisible = false;
                this.listLoading = true;

                let deleteData = {
                    deleteData: this.deleteData
                };
                http.delete('expenses', deleteData, res => {
                    this.$message('削除しました');
                    this.getList();
                });
            },
            updateExpense() {
                let updateData = {
                    updateData: this.editData
                };
                this.listLoading = true;
                http.put('expenses/update', updateData, res => {
                    this.$message({
                        message: '保存しました',
                        type: 'success'
                    });
                    this.getList();
                });
            },
            confirmDelete() {
                this.dialogVisible = true;
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

    .button-area {
        position: absolute;
        right: 250px;
        top: 10px;
        display: flex;
        align-items: center;
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