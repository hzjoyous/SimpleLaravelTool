import home from "./view/home";
import login from "./view/login";
import about from "./view/about";

export default [
    {path: '/home', component: home},
    {path: '/login', component: login},
    {path: '/about', component: about},
    {
        path: "*",
        redirect: "/home"
    }
]
