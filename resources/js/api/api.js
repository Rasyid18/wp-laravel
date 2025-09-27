import axios from "axios";
import { useUserStore } from "../store/user";

export const api = axios.create({
    baseURL: "/api",
    headers: {
        Accept: "application/json",
    },
});

export const authApi = axios.create({
    baseURL: "/api",
    headers: {
        Accept: "application/json",
    },
});

authApi.interceptors.request.use((config) => {
    const token = localStorage.getItem("token");
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
});

authApi.interceptors.response.use(
    (response) => response,
    (error) => {
        if (error.response?.status === 401) {
            logout();
        }
        return Promise.reject(error);
    }
);

export async function logout() {
    const user = useUserStore();

    try {
        await authApi.post("/logout");
    } catch (err) {
        console.warn("Logout request failed:", err);
    } finally {
        localStorage.removeItem("user");
        localStorage.removeItem("token");
        user.logout();
        window.location.href = "/login";
    }
}
