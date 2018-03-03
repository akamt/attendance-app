import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter);

export default new VueRouter({
    mode: 'history',
    routes: [
        {path: '/', component: require('./components/Index.vue')},
        {path: '/expense', component: require('./components/Expense.vue')},
        {path: '/list', component: require('./components/ExpenseList.vue')},
        {path: '/category', component: require('./components/Category.vue')},
        {path: '/login', component: require('./components/Login.vue')}
    ]
});