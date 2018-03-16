<template>
    <expenseList :user_id="$route.params.id"></expenseList>
</template>

<script>
    import expenseList from './expense/List'

    export default {
        data() {
            return {}
        },
        components: {
            expenseList
        },
        methods: {}
    }
</script>