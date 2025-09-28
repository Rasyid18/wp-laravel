<template>
    <aside class="w-64 min-h-screen p-4">
        <div class="flex items-center mb-6">
            <img :src="logo" alt="Logo" class="w-12 h-12 object-contain mr-3" />
            <span class="text-2xl font-bold">WP Laravel</span>
        </div>

        <nav class="flex-1">
            <ul>
                <li
                    v-for="(routes, group) in groupedRoutes"
                    :key="group"
                    class="mb-2"
                >
                    <template v-if="group === 'ungrouped'">
                        <router-link
                            v-for="route in routes"
                            :key="route.path"
                            :to="route.path"
                            class="flex px-4 py-3 navbar"
                            :class="{
                                active:
                                    $route.path === route.path ||
                                    $route.path.startsWith(route.path + '/'),
                            }"
                        >
                            {{ route.meta.title }}
                        </router-link>
                    </template>

                    <template v-else>
                        <button
                            @click="toggleGroup(group)"
                            :class="[
                                'flex justify-between items-center w-full text-left pr-4 navbar',
                                isGroupActive(group) ? 'active-group' : '',
                            ]"
                        >
                            <span class="px-4 py-3">{{ group }}</span>
                            <svg
                                :class="[
                                    'w-4 h-4 transform transition-transform duration-200',
                                    openGroups[group] ? 'rotate-90' : '',
                                ]"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 5l7 7-7 7"
                                />
                            </svg>
                        </button>

                        <ul
                            v-show="openGroups[group]"
                            class="ml-8 mt-1 space-y-1 transition-all duration-200 pl-4 list-disc"
                        >
                            <li
                                class="marker:text-[#44a7f3]"
                                v-for="route in routes"
                                :key="route.path"
                            >
                                <router-link
                                    :to="route.path"
                                    class="block px-4 py-3 navbar-sub"
                                    :class="{
                                        active:
                                            $route.path === route.path ||
                                            $route.path.startsWith(
                                                route.path + '/'
                                            ),
                                    }"
                                >
                                    {{ route.meta.title }}
                                </router-link>
                            </li>
                        </ul>
                    </template>
                </li>
            </ul>
        </nav>
    </aside>
</template>

<script setup>
import { reactive, watch } from "vue";
import { useRoute } from "vue-router";
import { adminRoutes } from "../router/admin";
import logo from "../assets/logo.png";

const sidebarRoutes = adminRoutes.filter((r) => r.meta?.sidebar);

const groupedRoutes = sidebarRoutes.reduce((acc, route) => {
    const group = route.meta.group || "ungrouped";
    if (!acc[group]) acc[group] = [];
    acc[group].push(route);
    return acc;
}, {});

const openGroups = reactive({});

function toggleGroup(group) {
    openGroups[group] = !openGroups[group];
}

const route = useRoute();
watch(
    () => route.path,
    () => {
        for (const group in groupedRoutes) {
            if (group !== "ungrouped") {
                openGroups[group] = isGroupActive(group);
            }
        }
    },
    { immediate: true }
);

function isGroupActive(group) {
    const groupRoutes = groupedRoutes[group] || [];
    return groupRoutes.some((r) => {
        return route.path === r.path || route.path.startsWith(r.path + "/");
    });
}
</script>

<style scoped>
aside {
    background-color: #ffffff;
    box-shadow: 0px 10px 60px rgba(226, 236, 249, 0.5);
}

.navbar {
    font-family: "Poppins", sans-serif;
    font-weight: 400;
    font-size: 14px;
    line-height: 21px;
    letter-spacing: -0.01em;
    color: #9197b3;
}
.navbar:hover {
    background-color: hsl(206, 88%, 80%);
    border-radius: 8px;
    color: #ffffff;
}

.navbar-sub {
    font-family: "Poppins", sans-serif;
    font-weight: 400;
    font-size: 12px;
    line-height: 21px;
    letter-spacing: -0.01em;
    color: #9197b3;
}
.navbar-sub:hover {
    background-color: hsl(206, 88%, 85%);
    border-radius: 8px;
    color: #ffffff;
}

.active {
    background-color: hsl(206, 88%, 61%);
    border-radius: 8px;
    color: #ffffff;
}

.active-group {
    color: hsl(206, 88%, 61%);
    border-radius: 8px;
}
</style>
