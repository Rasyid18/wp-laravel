<template>
    <MainLayout>
        <div class="p-6 content">
            <div class="flex justify-between items-center mb-4">
                <h1 class="title">WordPress Users</h1>
                <button
                    @click="goToAdd"
                    class="add-button px-4 py-2 cursor-pointer"
                >
                    + Add User
                </button>
            </div>

            <div v-if="loading" class="text-gray-500">Loading users...</div>
            <div v-if="error" class="text-red-500 mb-4">{{ error }}</div>

            <div v-if="users.data && users.data.length" class="overflow-x-auto">
                <table class="min-w-full rounded">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">Username</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="u in users.data" :key="u.ID">
                            <td class="px-4 py-2">{{ u.ID }}</td>
                            <td class="px-4 py-2">
                                <AppLink :to="`/wordpress/users/${u.ID}`">
                                    {{ u.user_login }}
                                </AppLink>
                            </td>
                            <td class="px-4 py-2">{{ u.user_email }}</td>
                            <td class="px-4 py-2">
                                <button
                                    @click="goToEdit(u.ID)"
                                    class="edit-button mr-2 cursor-pointer"
                                >
                                    Edit
                                </button>
                                <button
                                    @click="confirmDelete(u.ID)"
                                    class="delete-button cursor-pointer"
                                >
                                    Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <Pagination
                :current-page="users.current_page"
                :last-page="users.last_page"
                @page-change="fetchUsers"
            />
        </div>
    </MainLayout>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import { authApi } from "../../../api/api";
import MainLayout from "../../../layouts/MainLayout.vue";
import Pagination from "../../../components/Pagination.vue";
import AppLink from "../../../components/AppLink.vue";

const router = useRouter();

const users = ref({});
const loading = ref(false);
const error = ref("");

const fetchUsers = async (page = 1) => {
    loading.value = true;
    error.value = "";
    try {
        const response = await authApi.get("/wordpress/user", {
            params: { rpp: 20, page },
        });
        users.value = response.data;
    } catch (err) {
        console.error(err);
        error.value = "Failed to fetch WordPress users.";
    } finally {
        loading.value = false;
    }
};

const goToAdd = () => {
    router.push("/wordpress/users/new");
};

const goToEdit = (id) => {
    router.push(`/wordpress/users/${id}/edit`);
};

const confirmDelete = async (id) => {
    if (!confirm("Are you sure you want to delete this user?")) return;

    try {
        await authApi.delete(`/wordpress/user/${id}`);
        alert("User deleted successfully!");
        fetchUsers(users.value.current_page);
    } catch (err) {
        console.error(err);
        alert(err.response?.data?.message || "Failed to delete user.");
    }
};

onMounted(() => {
    fetchUsers();
});
</script>

<style scoped>
th {
    font-family: Poppins;
    font-weight: 500;
    font-style: Medium;
    font-size: 16px;
    line-height: 100%;
    letter-spacing: -1%;
    color: #b5b7c0;
    border-bottom: 1px solid #eeeeee;
    text-align: start;
}
td {
    font-family: Poppins;
    font-weight: 500;
    font-style: Medium;
    font-size: 14px;
    line-height: 100%;
    letter-spacing: -1%;
    border-bottom: 1px solid #eeeeee;
}

.content {
    box-shadow: 0px 10px 60px 0px #e2ecf980;
    opacity: 1;
    border-radius: 30px;
}
.title {
    font-family: Poppins;
    font-weight: 600;
    font-style: SemiBold;
    font-size: 32px;
    line-height: 100%;
    letter-spacing: -1%;
}

.add-button {
    opacity: 1;
    border-radius: 10px;
    background: #f9fbff;
    box-shadow: 0px 2px 2px 0px #00000040;

    font-family: Poppins;
    font-weight: 500;
    font-size: 20px;
    line-height: 100%;
    letter-spacing: -1%;
    color: #51a3ee;
}
.add-button:hover {
    background-color: hsl(206, 88%, 61%);
    border-radius: 8px;
    color: #fff;
}

.edit-button {
    background: #16c09861;
    border: 1px solid #00b087;
    opacity: 1;
    border-radius: 4px;
    border-width: 1px;
    padding-top: 4px;
    padding-right: 12px;
    padding-bottom: 4px;
    padding-left: 12px;
    gap: 10px;
    color: #008767;
    font-family: Poppins;
    font-weight: 500;
    font-style: Medium;
    font-size: 14px;
    line-height: 100%;
}
.edit-button:hover {
    background: #13a88561;
}
.delete-button {
    background: #ffc5c561;
    border: 1px solid #df0404;
    opacity: 1;
    border-radius: 4px;
    border-width: 1px;
    padding-top: 4px;
    padding-right: 12px;
    padding-bottom: 4px;
    padding-left: 12px;
    gap: 10px;
    color: #df0404;
    font-family: Poppins;
    font-weight: 500;
    font-style: Medium;
    font-size: 14px;
    line-height: 100%;
}
.delete-button:hover {
    background: #e6b1b161;
}
</style>
