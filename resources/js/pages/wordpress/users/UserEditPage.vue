<template>
    <MainLayout>
        <div class="p-6">
            <router-link
                to="/wordpress/users"
                class="text-blue-500 hover:underline mb-4 inline-block"
            >
                &larr; Back to Users
            </router-link>

            <div class="form-card px-12 py-8">
                <div class="mb-5">
                    <span class="title">User Information</span>
                </div>
                <form @submit.prevent="submit">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-1">
                                Username <span class="text-red-500">*</span>
                            </label>
                            <input
                                v-model="form.username"
                                type="text"
                                class="input"
                                placeholder="Username"
                                required
                            />
                        </div>

                        <div>
                            <label class="block mb-1"
                                >Email
                                <span class="text-red-500">*</span></label
                            >
                            <input
                                v-model="form.email"
                                type="email"
                                class="input"
                                placeholder="Email"
                                required
                            />
                        </div>

                        <div>
                            <label class="block mb-1">First Name</label>
                            <input
                                v-model="form.first_name"
                                type="text"
                                placeholder="First Name"
                                class="input"
                            />
                        </div>

                        <div>
                            <label class="block mb-1">Last Name</label>
                            <input
                                v-model="form.last_name"
                                type="text"
                                placeholder="Last Name"
                                class="input"
                            />
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block mb-1">Website</label>
                        <input
                            v-model="form.website"
                            type="url"
                            placeholder="Website URL"
                            class="input"
                        />
                    </div>

                    <div class="mt-4">
                        <label class="block mb-1">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <input
                            v-model="form.password"
                            type="password"
                            class="input"
                            placeholder="Password (Leave Blank To Keep Current)"
                            required
                        />
                    </div>

                    <div class="mt-4">
                        <label class="block mb-1">
                            Role <span class="text-red-500">*</span>
                        </label>
                        <select v-model="form.role" class="input" required>
                            <option
                                v-for="(label, value) in roles"
                                :key="value"
                                :value="value"
                            >
                                {{ label }}
                            </option>
                        </select>
                    </div>

                    <button
                        type="submit"
                        class="submit-button mt-4 px-4 py-3 w-full"
                    >
                        Update User
                    </button>
                </form>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";
import MainLayout from "../../../layouts/MainLayout.vue";
import { authApi } from "../../../api/api";

const route = useRoute();
const router = useRouter();

const userId = route.params.id;

const form = ref({
    username: "",
    email: "",
    first_name: "",
    last_name: "",
    website: "",
    password: "",
    role: "subscriber",
});

const roles = {
    subscriber: "Subscriber",
    contributor: "Contributor",
    author: "Author",
    editor: "Editor",
    administrator: "Administrator",
};

onMounted(async () => {
    try {
        const res = await authApi.get(`/wordpress/user/${userId}`);
        const detail = res.data.data;
        Object.assign(form.value, {
            username: detail.user_login,
            email: detail.user_email,
            first_name: detail.meta.first_name ?? "",
            last_name: detail.meta.last_name ?? "",
            website: detail.user_url ?? "",
            role: detail.meta.wp_capabilities ?? "subscriber",
        });
    } catch (err) {
        console.error(err);
        alert("Failed to fetch user data");
    }
});

const submit = async () => {
    try {
        await authApi.put(`/wordpress/user/${userId}`, form.value);
        alert("User updated successfully!");
        router.push("/wordpress/users");
    } catch (err) {
        console.error(err);
        alert(err.response?.data?.message || "Error updating user");
    }
};
</script>

<style>
.form-card {
    opacity: 1;
    border-radius: 30px;
    background: #ffffff;
}
.title {
    font-family: Poppins;
    font-weight: 600;
    font-size: 24px;
    line-height: 46px;
    color: #000000;
}
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
