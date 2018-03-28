import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter);

export default new VueRouter({
    mode: 'history',
    routes: [
        {path: '/register', component: require('./components/Expense.vue')},
        {path: '/list', component: require('./components/ExpenseList')},
        {path: '/category', component: require('./components/Category.vue')},
        {path: '/users', component: require('./components/UserList.vue')},
        {path: '/users/:id/list', component: require('./components/UserExpenseList')},
        {path: '/login', component: require('./components/Login.vue')}
    ]
});