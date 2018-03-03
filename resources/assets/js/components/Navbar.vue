<template>
    <el-menu :default-active="activeIndex" class="el-menu-demo" mode="horizontal" @select="handleSelect">
        <el-menu-item @click="toTop" index="1">
            TOP
        </el-menu-item>
        <el-submenu v-if="userStatus.authenticated" @click="toExpense" index="2">
            <template slot="title">経費</template>
            <el-menu-item @click="toExpense" index="2-1">経費登録</el-menu-item>
            <el-menu-item @click="toExpenseList" index="2-2">経費一覧</el-menu-item>
        </el-submenu>
        <el-menu-item v-if="userStatus.authenticated" @click="toCategory" index="3">
            カテゴリー
        </el-menu-item>
        <el-menu-item v-if="!userStatus.authenticated" @click="toLogin" index="4">
            Login
        </el-menu-item>
        <el-menu-item v-if="userStatus.authenticated" @click="logout" index="4">
            Logout
        </el-menu-item>
    </el-menu>
</template>

<script>
    import userStore from '../stores/userStore'

    export default {
        data() {
            return {
                activeIndex: '1',
                userStatus: userStore.state
            }
        },
        methods: {
            handleSelect(key, keyPath) {
                console.log(key, keyPath);
            },
            toTop() {
                this.$router.push('/')
            },
            toExpense() {
                this.$router.push('expense')
            },
            toExpenseList() {
                this.$router.push('list')
            },
            toCategory() {
                this.$router.push('category')
            },
            toLogin() {
                this.$router.push('login')
            },
            logout() {
                userStore.logout(() => {
                    this.$router.push('/login');
                    this.handleSelect('4', null);
                })
            }
        }
    }
</script>