import Vue from "vue";
import VueRouter from "vue-router";
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import routes from "./routes";
import {remoteService} from "./service/remoteService"

Vue.use(VueRouter).use(ElementUI)
require('./bootstrap');


Vue.prototype.$remoteService = remoteService

const router = new VueRouter({
    routes // （缩写）相当于 routes: routes
});

const app = new Vue({
    router
}).$mount('#app');
