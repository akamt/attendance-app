<template>
    <el-container>
        <el-header height="50px">
            <span>経費名</span>
            <span>金額</span>
            <span>支払先</span>
            <span>種類</span>
            <div class="picker-wrapper">
                <el-date-picker
                        v-model="period"
                        type="month"
                        value-format="yyyy-MM"
                        placeholder="対象月">
                </el-date-picker>
            </div>
        </el-header>
        <el-main>
            <el-form @keyup.enter.native="add">
                <div class="form-wrapper" v-for="(form, index) in forms">
                    <el-form-item>
                        <el-input placeholder="経費名" v-model="form.name" clearable>
                        </el-input>
                    </el-form-item>
                    <el-form-item>
                        <el-input type="number" placeholder="金額" v-model.number="form.value" clearable>
                        </el-input>
                    </el-form-item>
                    <el-form-item>
                        <el-input placeholder="支払先" v-model="form.payment" clearable>
                        </el-input>
                    </el-form-item>
                    <el-form-item>
                        <el-select v-model="form.category_id" clearable placeholder="Select">
                            <el-option
                                    v-for="item in options"
                                    :key="item.name"
                                    :label="item.name"
                                    :value="item.id">
                            </el-option>
                        </el-select>
                    </el-form-item>
                    <i v-if="index >=1" class="el-icon-circle-close" @click="deleteForm(index)">
                    </i>
                </div>
                <div class="add-item-area">
                    <el-button icon="el-icon-circle-plus" @click="addForm">
                        項目追加
                    </el-button>
                </div>
            </el-form>
            <div class="total-value-area">
                {{ total_value }}
            </div>
            <el-button type="primary" @click="add">Register</el-button>
        </el-main>
    </el-container>
</template>

<script>
    import http from '../services/http'
    import ElContainer from "element-ui/packages/container/src/main";

    export default {
        components: {ElContainer},
        data() {
            return {
                period: '',
                forms: [
                    {
                        name: '',
                        category_id: 1,
                        value: 0,
                        payment: ''
                    }
                ],
                options: []
            }
        },
        computed: {
            total_value() {
                let total = 0;

                this.forms.forEach((item) => {
                    total += item.value;
                });

                return total;
            }
        },
        created() {
            this.fetchCategory();
        },
        methods: {
            addForm() {
                this.forms.push({
                    name: '',
                    kind: 1,
                    value: 0,
                    payment: ''
                });
            },
            deleteForm(index) {
                this.forms.splice(index, 1);
            },
            fetchCategory() {
                http.get('categories', res => {
                    this.options = res.data;
                })
            },
            add() {
                let data = {
                    forms: this.forms,
                    period: this.period
                };

                http.post('expenses', data, res => {
                    console.log(res);
                })
            }
        }
    }
</script>

<style lang="scss">
    .el-header {
        align-items: center;
        display: flex;
        position: relative;

        > span {
            box-sizing: border-box;
            padding-left: 15px;
            width: 25%;
        }

        .picker-wrapper {
            position: absolute;
            right: 20px;
            top: -50px;
            width: 220px;
        }
    }

    .form-wrapper {
        align-items: center;
        display: flex;
        margin-bottom: 10px;
        position: relative;

        .el-form-item {
            box-sizing: border-box;
            margin: 0;
            padding: 0 10px;
            width: calc(100% / 4);
            &:last-of-type {
                width: calc((100% / 4) - 16px);
            }

            .el-form-item__content {
                .el-select {
                    width: 100%;
                }
            }
        }

        .el-icon-circle-close {
            cursor: pointer;
            position: absolute;
            right: 0;
        }
    }

    .add-item-area {
        display: flex;
        justify-content: center;
    }

    .total-value-area {
        display: flex;
        align-items: center;
    }
</style>