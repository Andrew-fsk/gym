import {createRouter, createWebHistory } from "vue-router";
import NotFound from "./components/NotFound.vue";

const routes = [
    {
        path: '/users/login',
        component: () => import ('./components/User/Login.vue'),
        name: 'user.login'
    },
    {
        path: '/users/registration',
        component: () => import ('./components/User/Registration.vue'),
        name: 'user.registration'
    },
    {
        path: '/main',
        component: () => import ('./components/Index.vue'),
        name: 'main.index'
    }
];

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes,
});

router.beforeEach((to, from, next) => {
    const access_token = localStorage.getItem('access_token');
    if (!access_token) {
        if (to.name === 'user.login' || to.name === 'user.registration') {
            return next();
        } else {
            return next({name : 'user.login'})
        }
    }

    if (to.name === 'user.login' || to.name === 'user.registration' && access_token) {
        return next({name : 'fruits.index'})
    }
    return next();
});

export default router;
