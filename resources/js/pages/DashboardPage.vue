<template>
    <MainLayout>
        <div class="p-6">
            <h1 class="text-3xl font-bold mb-4">Dashboard</h1>

            <div v-if="loading" class="text-gray-500">Loading...</div>

            <div v-else-if="user">
                <p class="mb-2">
                    Welcome back,
                    <span class="font-semibold">{{ user.name }}</span
                    >!
                </p>
                <p class="mb-6">Email: {{ user.email }}</p>

                <button
                    @click="handleLogout"
                    class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600"
                >
                    Logout
                </button>
            </div>

            <div v-else class="text-red-500">Failed to load user data.</div>
        </div>
    </MainLayout>
</template>

<script setup>
import { ref, onMounted } from "vue";
import MainLayout from "../layouts/MainLayout.vue";
import { authApi, logout } from "../api/api";

const user = ref(null);
const loading = ref(true);

onMounted(async () => {
    try {
        const response = await authApi.get("/me");
        user.value = response.data;
    } catch (err) {
        console.error("Error fetching user:", err);
        logout();
    } finally {
        loading.value = false;
    }
});

const handleLogout = () => {
    logout();
};
</script>
