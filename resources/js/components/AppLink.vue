<template>
    <router-link
        v-bind="$attrs"
        class="text-blue-500 hover:text-blue-400 hover:underline"
    >
        <slot />
    </router-link>
</template>
