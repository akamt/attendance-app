<template>
    <el-main v-loading="categoryLoading">
        <el-header>
            <span>日付</span>
            <span>経費名</span>
            <span>金額</span>
            <span>支払先</span>
            <span>種類</span>
        </el-header>

        <div class="form-wrapper">
            <el-form :model="form" :rules="rules" v-for="(form, index) in forms" :key="index"
                     :ref="`dynamicFieldsForm${index}`">
                <el-form-item prop="date">
                    <el-date-picker v-model="form.date" value-format="yyyy-MM-dd" type="date"
                                    placeholder="対象日を選択">
                    </el-date-picker>
                </el-form-item>
                <el-form-item prop="name">
                    <el-input placeholder="経費名" v-model="form.name" clearable>
                    </el-input>
                </el-form-item>
                <el-form-item prop="value">
                    <el-input v-model.number="form.value">
                    </el-input>
                </el-form-item>
                <el-form-item prop="payment">
                    <el-input placeholder="支払先" v-model="form.payment" clearable>
                    </el-input>
                </el-form-item>
                <el-form-item prop="category">
                    <el-select v-model="form.category_id" placeholder="種類を選択">
                        <el-option
                                v-for="item in options"
                                :key="item.id"
                                :label="item.name"
                                :value="item.id">
                        </el-option>
                    </el-select>
                </el-form-item>
                <i v-if="index >=1" class="el-icon-circle-close" @click="deleteForm(index)">
                </i>
            </el-form>
        </div>

        <div class="add-item-area">
            <el-button icon="el-icon-circle-plus" @click="addForm">
                項目追加
            </el-button>
        </div>

        <div class="register-area">
            <span>
                合計金額
                ¥
                {{ total_value }}
            </span>
            <el-button type="primary" @click="validate">Register</el-button>
        </div>
    </el-main>
</template>

<script>
    import http from '../services/http'
    import userStore from '../stores/userStore'

    export default {
        data() {
            return {
                forms: [
                    {
                        category_id: 1,
                        date: '',
                        name: '',
                        payment: '',
                        value: ''
                    }
                ],
                rules: {
                    date: [
                        {required: true, message: '支払日を選択してください', trigger: 'change'}
                    ],
                    name: [
                        {required: true, message: '経費名を入力してください', trigger: 'change', whitespace: true}
                    ],
                    value: [
                        {required: true, message: '金額を入力してください', trigger: 'blur'},
                        {type: 'number', message: '数値で入力してください'}
                    ],
                    payment: [
                        {required: true, message: '支払先を入力してください', trigger: 'change', whitespace: true}
                    ]
                },
                options: {},
                categoryLoading: false,
                userStatus: userStore.state
            }
        },
        computed: {
            total_value() {
                let total = 0;

                this.forms.forEach((item) => {
                    if (Number(item.value) > 0) {
                        total += item.value;
                    }
                });

                // 3桁区切りで返す
                return String(total).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, '$1,');
            }
        },
        created() {
            this.fetchCategory();
        },
        methods: {
            addForm() {
                this.forms.push({
                    category_id: 1,
                    date: '',
                    name: '',
                    payment: '',
                    value: 0
                });
            },
            deleteForm(index) {
                this.forms.splice(index, 1);
            },
            fetchCategory() {
                this.categoryLoading = true;
                http.get('categories', res => {
                    this.options = res.data;
                    this.categoryLoading = false;
                })
            },
            validate() {
                let validCount = 0;
                const formAmount = this.forms.length;

                this.forms.forEach((form, index) => {
                    this.$refs[`dynamicFieldsForm${index}`][0].validate(valid => {
                        if (valid) {
                            validCount++;
                        }
                    });
                });

                // form数とvalidateが通った回数を比較
                if (formAmount === validCount) {
                    this.register();
                }
            },
            register() {
                let data = {
                    forms: this.forms,
                    period: this.period
                };

                let apiUrl = 'users/' + this.userStatus.user.id + '/expenses';
                http.post(apiUrl, data, res => {
                    // formを初期化
                    this.forms = [{category_id: 1, date: '', name: '', payment: '', value: ''}];
                })
            }
        }
    }
</script>

<style lang="scss">
    $header-height: 60px;
    $add-area-height: 40px;
    $register-area-height: 50px;
    $margin-height: 10px;

    .el-header {
        align-items: center;
        border-bottom: 1px solid #ebeef5;
        color: #909399;
        display: flex;
        font-size: 14px;
        font-weight: bold;
        height: $header-height;
        margin-bottom: $margin-height;
        position: relative;

        > span {
            box-sizing: border-box;
            padding-left: 15px;
            width: 25%;
        }
    }

    .el-main {
        height: 100%;
        box-sizing: border-box;

        .form-wrapper {
            max-height: calc(100% - #{$header-height} - #{$add-area-height} - #{$register-area-height} - (#{$margin-height} * 2));
            overflow: scroll;
            &::-webkit-scrollbar {
                display: none;
            }

            .el-form {
                align-items: center;
                display: flex;
                margin-bottom: 20px;
                position: relative;

                .el-form-item {
                    box-sizing: border-box;
                    margin: 0;
                    padding: 0 10px;
                    width: calc(100% / 5);
                    &:last-of-type {
                        width: calc((100% / 5) - 16px);
                    }

                    .el-form-item__content {
                        .el-select {
                            width: 100%;
                        }

                        .el-date-editor--date {
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
        }

        .add-item-area {
            display: flex;
            justify-content: center;
            height: 40px;
        }

        .register-area {
            align-items: center;
            border-top: 1px solid #ebeef5;
            box-sizing: border-box;
            color: #909399;
            display: flex;
            height: $register-area-height;
            justify-content: space-around;
            margin-top: $margin-height;
            padding-top: 10px;
        }
    }
</style>