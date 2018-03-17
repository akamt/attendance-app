<template>
    <expenseList :user_id="String(userStatus.user.id)"></expenseList>
</template>

<script>
    import expenseList from './expense/List'
    import userStore from '../stores/userStore'

    export default {
        data() {
            return {
                userStatus: userStore.state
            }
        },
        components: {
            expenseList
        },
        methods: {}
    }
</script>