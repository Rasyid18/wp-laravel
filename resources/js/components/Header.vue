<template>
    <header v-if="isLoggedIn" class="pt-6 pl-10">
        <span class="text-xl font-bold">Hi, {{ user.name }} 👋🏼</span>
    </header>
</template>

<script setup>
const user = JSON.parse(localStorage.getItem("user"));
const token = localStorage.getItem("token");
const isLoggedIn = !!token;
</script>

<style scoped>
span {
    font-family: Poppins;
    font-weight: 500;
    font-style: Medium;
    font-size: 24px;
    line-height: 100%;
    letter-spacing: 0%;
}
</style>
