import { createRouter, createWebHistory } from "vue-router";
import { publicRoutes } from "./public";
import { adminRoutes } from "./admin";

const routes = [
    { path: "/", redirect: "/dashboard" },
    ...publicRoutes,
    ...adminRoutes,
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('token');

    if (to.meta.requiresAuth && !token) {
        next({ name: "login" });
    }

    if (token && to.path === "/login") {
        next("/dashboard");
    }

    next();
});

router.afterEach((to) => {
    if (to.meta && to.meta.title) {
        document.title = `${to.meta.title} | WordPress Laravel`;
    } else {
        document.title = "WordPress Laravel App";
    }
});

export default router;
