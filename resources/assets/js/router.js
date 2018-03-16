import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter);

export default new VueRouter({
    mode: 'history',
    routes: [
        {path: '/', component: require('./components/Index.vue')},
        {path: '/expense', component: require('./components/Expense.vue')},
        {path: '/category', component: require('./components/Category.vue')},
        {path: '/users', component: require('./components/UserList.vue')},
        {path: '/users/:id/list', component: require('./components/UserExpenseList')},
        {path: '/login', component: require('./components/Login.vue')}
    ]
});