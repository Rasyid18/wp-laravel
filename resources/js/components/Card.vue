<template>
    <div class="form-card px-12 py-8">
        <div v-if="$slots.title" class="mb-5">
            <span class="title"><slot name="title" /></span>
        </div>
        <slot />
    </div>
</template>

<style scoped>
.form-card {
    opacity: 1;
    border-radius: 30px;
    background: #ffffff;
    font-family: Poppins;
}
.title {
    font-family: Poppins;
    font-weight: 600;
    font-size: 24px;
    line-height: 46px;
    color: #000000;
}
</style>
