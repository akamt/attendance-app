<template>
    <el-main>
        <el-form @keyup.enter.native="login" ref="form" :model="form" label-width="100px">
            <el-form-item label="Email">
                <el-input placeholder="email" v-model="form.email" clearable>
                </el-input>
            </el-form-item>
            <el-form-item label="Password">
                <el-input placeholder="pass" v-model="form.password" type="password" clearable>
                </el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="login">Login</el-button>
            </el-form-item>
        </el-form>

        <el-dialog title="Wrong email or password." :visible.sync="showAlert" width="30%">
            <span>{{ alertMessage }}</span>
            <span slot="footer" class="dialog-footer">
                <el-button type="primary" @click="showAlert = false">OK</el-button>
            </span>
        </el-dialog>
    </el-main>
</template>

<script>
    import userStore from '../stores/userStore'
    import nabVar from './Navbar'

    export default {
        data() {
            return {
                form: {
                    email: '',
                    password: ''
                },
                showAlert: false,
                alertMessage: '',
            }
        },
        methods: {
            login() {
                userStore.login(this.form.email, this.form.password, res => {
                    console.log(res);
                    this.$router.push('/register');
                    nabVar.handleSelect('1');
                }, e => {
                    this.showAlert = true;
                    this.alertMessage = 'Wrong email or password.'
                })
            }
        }
    }
</script>