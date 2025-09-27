<template>
    <div class="min-h-screen flex">
        <Sidebar v-if="isLoggedIn" />
        <div class="flex-1 flex flex-col">
            <Header />
            <main class="flex-1 px-14 py-7">
                <slot />
            </main>
            <Footer />
        </div>
    </div>
</template>

<script setup>
import Header from "../components/Header.vue";
import Footer from "../components/Footer.vue";
import Sidebar from "../components/Sidebar.vue";

const token = localStorage.getItem("token");
const isLoggedIn = !!token;
</script>

<style scoped>
main {
    background-color: #fafbff;
}
</style>
