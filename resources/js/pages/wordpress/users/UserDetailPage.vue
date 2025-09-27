<template>
    <MainLayout>
        <div class="p-6">
            <router-link
                to="/wordpress/users"
                class="text-blue-500 hover:underline mb-4 inline-block"
            >
                &larr; Back to Users
            </router-link>

            <div v-if="loading" class="text-gray-500">Loading user...</div>

            <div v-else-if="error" class="text-red-500">
                {{ error }}
            </div>

            <div v-else class="card px-12 py-8">
                <h1 class="text-2xl font-bold mb-4">{{ user.display_name }}</h1>

                <div class="flex mb-2">
                    <strong class="w-40">Username:</strong>
                    <span>{{ user.user_login }}</span>
                </div>

                <div class="flex mb-2">
                    <strong class="w-40">Email:</strong>
                    <span>{{ user.user_email }}</span>
                </div>

                <div class="flex mb-2">
                    <strong class="w-40">First Name:</strong>
                    <span>{{ user.meta.first_name }}</span>
                </div>

                <div class="flex mb-2">
                    <strong class="w-40">Last Name:</strong>
                    <span>{{ user.meta.last_name }}</span>
                </div>

                <div class="flex mb-2">
                    <strong class="w-40">Website:</strong>
                    <span>{{ user.user_url }}</span>
                </div>

                <div class="flex mb-2">
                    <strong class="w-40">Nickname:</strong>
                    <span>{{ user.meta.nickname }}</span>
                </div>

                <div class="flex mb-2">
                    <strong class="w-40">Registered:</strong>
                    <span>{{ user.user_registered }}</span>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";
import { authApi } from "../../../api/api";
import MainLayout from "../../../layouts/MainLayout.vue";

const route = useRoute();

const user = ref(null);
const loading = ref(true);
const error = ref("");

async function fetchUser() {
    loading.value = true;
    error.value = "";
    try {
        const res = await authApi.get(`/wordpress/user/${route.params.id}`);
        user.value = res.data.data;
    } catch (err) {
        if (err.response?.status === 404) {
            error.value = "User not found.";
        } else {
            error.value = "Failed to fetch user data.";
        }
    } finally {
        loading.value = false;
    }
}

onMounted(fetchUser);
</script>

<style scoped>
.card {
    opacity: 1;
    border-radius: 30px;
    background: #ffffff;
    font-family: Poppins;
    color: darkslategrey;
}
</style>
