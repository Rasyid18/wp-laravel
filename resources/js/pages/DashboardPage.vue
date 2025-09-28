<template>
    <MainLayout>
        <Card class="w-150">
            <div v-if="loading" class="text-gray-500">Loading...</div>
            <div v-else-if="user">
                <div class="text-center">
                    <img
                        :src="logo"
                        alt="Logo"
                        class="w-24 h-24 mb-6 mx-auto"
                    />

                    <h1 class="text-3xl font-bold text-blue-700 mb-2">
                        Welcome, {{ user.name }}.
                    </h1>

                    <p class="text-gray-500 max-w-lg mb-4 mx-auto">
                        This is your profile page. You can see the progress
                        you’ve made with your work and manage your projects or
                        assigned tasks.
                    </p>

                    <p class="text-blue-900 font-semibold mb-6">
                        Email : {{ user.email }}
                    </p>

                    <button
                        @click="handleLogout"
                        class="px-6 py-2 bg-red-500 text-white rounded shadow hover:bg-red-600 transition"
                    >
                        Logout
                    </button>
                </div>
            </div>
            <div v-else class="text-red-500">Failed to load user data.</div>
        </Card>
    </MainLayout>
</template>

<script setup>
import { ref, onMounted } from "vue";
import MainLayout from "../layouts/MainLayout.vue";
import { authApi, logout } from "../api/api";
import Card from "../components/Card.vue";
import logo from "../assets/dashboard.png";

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
