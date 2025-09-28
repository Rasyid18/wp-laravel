import ConnectionPage from "../pages/ConnectionPage.vue";
import DashboardPage from "../pages/DashboardPage.vue";
import UserAddPage from "../pages/wordpress/users/UserAddPage.vue";
import UserDetailPage from "../pages/wordpress/users/UserDetailPage.vue";
import UserEditPage from "../pages/wordpress/users/UserEditPage.vue";
import UserPage from "../pages/wordpress/users/UserPage.vue";

export const adminRoutes = [
    {
        path: "/dashboard",
        name: "dashboard",
        component: DashboardPage,
        meta: {
            title: "Dashboard",
            requiresAuth: true,
            sidebar: true,
            sidebarName: "Dashboard",
            icon: "fi fi-ss-home",
        },
    },
    {
        path: "/wordpress/users",
        name: "wordpress-users",
        component: UserPage,
        meta: {
            title: "Wordpress Users",
            requiresAuth: true,
            sidebar: true,
            sidebarName: "Users",
            group: "Wordpress",
            groupIcon: "fi fi-rr-cube",
            icon: "fi fi-rr-users",
        },
    },
    {
        path: "/wordpress/users/:id",
        name: "wordpress-user-detail",
        component: UserDetailPage,
        meta: {
            title: "User Detail",
            requiresAuth: true,
            sidebar: false,
        },
    },
    {
        path: "/wordpress/users/new",
        name: "wordpress-user-new",
        component: UserAddPage,
        meta: {
            title: "Create New User",
            requiresAuth: true,
            sidebar: false,
        },
    },
    {
        path: "/wordpress/users/:id/edit",
        name: "wordpress-user-edit",
        component: UserEditPage,
        meta: {
            title: "Update User",
            requiresAuth: true,
            sidebar: false,
        },
    },
    {
        path: "/connection",
        name: "connection",
        component: ConnectionPage,
        meta: {
            title: "Wordpress Connection",
            requiresAuth: true,
            sidebar: true,
            sidebarName: "Connection",
            group: "Wordpress",
            icon: "fi fi-ts-user-key",
        },
    },
];
