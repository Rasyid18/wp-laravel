<template>
    <MainLayout>
        <div class="flex justify-center items-center min-h-[70vh]">
            <Card class="w-120">
                <template #title>Login</template>

                <form @submit.prevent="submitLogin">
                    <div class="mb-4">
                        <label class="block mb-1">Email</label>
                        <input
                            v-model="form.email"
                            type="email"
                            placeholder="you@example.com"
                            class="input w-full border rounded p-2"
                            required
                        />
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Password</label>
                        <input
                            v-model="form.password"
                            type="password"
                            placeholder="••••••••"
                            class="input w-full border rounded p-2"
                            required
                        />
                    </div>

                    <div class="mb-4 text-red-500" v-if="error">
                        {{ error }}
                    </div>

                    <button
                        type="submit"
                        class="w-full submit-button px-4 py-3 cursor-pointer"
                    >
                        Login
                    </button>
                </form>
            </Card>
        </div>
    </MainLayout>
</template>

<script setup>
import { ref } from "vue";
import MainLayout from "../layouts/MainLayout.vue";
import { useRouter } from "vue-router";
import { api } from "../api/api";
import { useUserStore } from "../store/user";
import Card from "../components/Card.vue";

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

<style scoped>
.input {
    width: 100%;
    padding: 0.5rem;
    opacity: 1;
    border-radius: 10px;
    border: 1px solid #e0e5f2;
}
.input::placeholder {
    color: #a3aed0;
    opacity: 1;
}
.submit-button {
    opacity: 1;
    border-radius: 10px;
    background: #51a3ee;
    box-shadow: 0px 2px 2px 0px #00000040;
    font-family: Poppins;
    font-weight: 500;
    font-style: Bold;
    font-size: 20px;
    line-height: 100%;
    color: #f2f4f6;
}
</style>
