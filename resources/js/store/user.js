import { defineStore } from "pinia";

export const useUserStore = defineStore("user", {
    state: () => ({
        name: "",
        loggedIn: false,
        token: "",
    }),
    actions: {
        login(name) {
            this.name = name;
            this.loggedIn = true;
        },
        setToken(token) {
            this.token = token;
        },
        logout() {
            this.name = "";
            this.loggedIn = false;
            this.token = "";
        },
    },
});
