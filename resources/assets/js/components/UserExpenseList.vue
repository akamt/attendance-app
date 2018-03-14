<template>
    <ExpenseList :user_id="$route.params.id"></ExpenseList>
</template>

<script>
    import ExpenseList from './expense/List'

    export default {
        data() {
            return {}
        },
        components: {
            ExpenseList
        },
        methods: {}
    }
</script>