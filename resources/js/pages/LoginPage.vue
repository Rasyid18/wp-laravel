<template>
    <MainLayout>
        <div class="flex justify-center items-center min-h-[70vh] bg-gray-100">
            <div class="w-full max-w-md bg-white p-8 rounded shadow-md">
                <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>

                <form @submit.prevent="submitLogin">
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">Email</label>
                        <input
                            v-model="form.email"
                            type="email"
                            placeholder="you@example.com"
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required
                        />
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">Password</label>
                        <input
                            v-model="form.password"
                            type="password"
                            placeholder="••••••••"
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required
                        />
                    </div>

                    <div class="mb-4 text-red-500" v-if="error">
                        {{ error }}
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600 transition"
                    >
                        Login
                    </button>
                </form>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import { ref } from "vue";
import MainLayout from "../layouts/MainLayout.vue";
import { useRouter } from "vue-router";
import { api } from "../api/api";
import { useUserStore } from "../store/user";

const router = useRouter();
const user = useUserStore();
const form = ref({
    email: "",
    password: "",
});
const error = ref("");

const submitLogin = async () => {
    error.value = "";
    try {
        const response = await api.post("/login", form.value);
        localStorage.setItem("user", JSON.stringify(response.data.user));
        localStorage.setItem("token", response.data.token);
        user.login(response.data.user.name);
        user.setToken(response.data.token);
        router.push("/dashboard");
    } catch (err) {
        if (err.response && err.response.data?.errors) {
            const messages = Object.values(err.response.data.errors).flat();
            error.value = messages[0] || "Login failed";
        } else {
            error.value = "Login failed";
        }
    }
};
</script>
