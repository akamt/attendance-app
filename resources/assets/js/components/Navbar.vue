<template>
    <el-menu :router="true" :default-active="link" class="el-menu-demo" mode="horizontal" @select="handleSelect">
        <el-submenu v-if="userStatus.authenticated" index="expense">
            <template slot="title">経費</template>
            <el-menu-item @click="toRegister" index="/register">
                経費登録
            </el-menu-item>
            <el-menu-item @click="toExpenseList" index="/list">
                経費一覧
            </el-menu-item>
        </el-submenu>
        <el-menu-item v-if="userStatus.authenticated && role_status" @click="toCategory" index="/category">
            カテゴリー
        </el-menu-item>
        <el-menu-item v-if="userStatus.authenticated && role_status" @click="toUsers" index="/users">
            ユーザーリスト
        </el-menu-item>
        <el-menu-item v-if="!userStatus.authenticated" @click="toLogin" index="/login">
            Login
        </el-menu-item>
        <el-menu-item v-if="userStatus.authenticated" @click="logout" index="/logout">
            Logout
        </el-menu-item>
    </el-menu>
</template>

<script>
    import userStore from '../stores/userStore'

    export default {
        data() {
            return {
                userStatus: userStore.state
            }
        },
        computed: {
            link() {
                // TODO nav store
                return this.$route.path;
            },
            role_status() {
                // 管理者権限があるか

                let role = this.userStatus.user.role_id;
                return role === 1 || role === 2 || role === 3
            }
        },
        methods: {
            handleSelect(key, keyPath) {
                console.log(key, keyPath);
            },
            toTop() {
                this.$router.push('/')
            },
            toRegister() {
                this.$router.push('register')
            },
            toExpenseList() {
                this.$router.push('/list')
            },
            toCategory() {
                this.$router.push('category')
            },
            toUsers() {
                this.$router.push('users')
            },
            toLogin() {
                this.$router.push('login')
            },
            logout() {
                userStore.logout(() => {
                    this.$router.push('/login');
                })
            }
        }
    }
</script>