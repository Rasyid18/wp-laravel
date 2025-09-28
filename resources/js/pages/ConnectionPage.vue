<template>
    <MainLayout>
        <Card>
            <template #title>WordPress Connection</template>

            <form @submit.prevent="submitConnection">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1">Host</label>
                        <input
                            v-model="form.host"
                            type="text"
                            class="w-full border rounded p-2"
                            placeholder="e.g. localhost"
                        />
                    </div>

                    <div>
                        <label class="block mb-1">Port</label>
                        <input
                            v-model="form.port"
                            type="text"
                            class="w-full border rounded p-2"
                            placeholder="e.g. 3306"
                        />
                    </div>
                </div>

                <div class="mt-4">
                    <label class="block mb-1">Database</label>
                    <input
                        v-model="form.database"
                        type="text"
                        class="w-full border rounded p-2"
                        placeholder="wordpress_db"
                    />
                </div>

                <div class="mt-4">
                    <label class="block mb-1">Username</label>
                    <input
                        v-model="form.username"
                        type="text"
                        class="w-full border rounded p-2"
                        placeholder="db_user"
                    />
                </div>

                <div class="mt-4">
                    <label class="block mb-1">Password</label>
                    <input
                        v-model="form.password"
                        type="password"
                        class="w-full border rounded p-2"
                        placeholder="••••••"
                    />
                </div>

                <div class="mt-4">
                    <label class="block mb-1">Table Prefix</label>
                    <input
                        v-model="form.prefix"
                        type="text"
                        class="w-full border rounded p-2"
                        placeholder="wp_"
                    />
                </div>

                <div class="mt-4 flex justify-end gap-4">
                    <button
                        type="button"
                        @click="tryConnection"
                        class="try-button px-4 py-3 cursor-pointer"
                    >
                        Try Connection
                    </button>
                    <button
                        type="submit"
                        class="submit-button px-4 py-3 cursor-pointer"
                    >
                        Save
                    </button>
                </div>

                <div
                    v-if="message"
                    class="mt-4 text-center"
                    :class="success ? 'text-green-600' : 'text-red-600'"
                >
                    {{ message }}
                </div>
            </form>
        </Card>
    </MainLayout>
</template>

<script setup>
import { onMounted, reactive, ref } from "vue";
import MainLayout from "../layouts/MainLayout.vue";
import { authApi } from "../api/api";
import Card from "../components/Card.vue";

const form = reactive({
    host: "",
    port: "3306",
    database: "",
    username: "",
    password: "",
    prefix: "wp_",
});

const message = ref("");
const success = ref(false);

onMounted(async () => {
    try {
        const { data } = await authApi.get("/connection");
        if (data) {
            Object.assign(form, data);
        }
    } catch (err) {
        console.error("Failed to load connection:", err);
    }
});

const tryConnection = async () => {
    message.value = "";
    try {
        const response = await authApi.post("/connection/test", form);
        success.value = response.data.success;
        message.value = response.data.message;
    } catch (err) {
        success.value = false;
        message.value = "Connection failed";
    }
};

const saveConnection = async () => {
    try {
        await authApi.put("/connection", form);
        alert("Connection saved!");
    } catch (err) {
        console.error("Failed to save:", err);
    }
};

const submitConnection = () => {
    saveConnection();
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
.try-button {
    opacity: 1;
    border-radius: 10px;
    background: #eec251;
    box-shadow: 0px 2px 2px 0px #00000040;
    font-family: Poppins;
    font-weight: 500;
    font-style: Bold;
    font-size: 20px;
    line-height: 100%;
    color: #f2f4f6;
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
