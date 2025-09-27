import LoginPage from "../pages/LoginPage.vue";

export const publicRoutes = [
    {
        path: "/login",
        name: "login",
        component: LoginPage,
        meta: { title: "Login" },
    },
];
