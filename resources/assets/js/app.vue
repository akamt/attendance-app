<template>
    <div id="app">
        <nav-bar></nav-bar>
        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    export default {
        components: {
            navBar: require('./components/Navbar.vue')
        },
    }
</script>