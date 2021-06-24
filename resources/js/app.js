import Vue from "vue";
import VueRouter from "vue-router";
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
Vue.use(VueRouter).use(ElementUI)
require('./bootstrap');

import home from "./view/home"
import login from "./view/login"
import userList from "./view/userList"
import test from "./view/test";


const routes = [
    // { path: '/', component: {template :"<div>home</div>"} },
    { path: '/', component: test },
    { path: '/home', component: home },
    { path: '/login', component: login },
    { path: '/userList', component: userList }

];

const router = new VueRouter({
    routes // （缩写）相当于 routes: routes
});

const app = new Vue({
    router
}).$mount('#app');
