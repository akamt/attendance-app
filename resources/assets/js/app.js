import Vue from 'vue'

import router from './router'
import http from './services/http.js'
import userStore from './stores/userStore'

import ElementUI from 'element-ui'
import locale from 'element-ui/lib/locale/lang/ja'
import 'element-ui/lib/theme-chalk/index.css'

Vue.use(ElementUI, {local: locale});

const app = new Vue({
    router,
    el: '#app',
    created() {
        http.init();
        userStore.init();
    },
    render: h => h(require('./app.vue')),
});