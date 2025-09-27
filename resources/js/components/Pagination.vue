<template>
    <div v-if="lastPage > 1" class="flex justify-between mt-4">
        <button
            :disabled="currentPage <= 1"
            @click="$emit('page-change', currentPage - 1)"
            class="px-4 py-2 bg-gray-200 rounded disabled:opacity-50"
        >
            Previous
        </button>

        <span> Page {{ currentPage }} of {{ lastPage }} </span>

        <button
            :disabled="currentPage >= lastPage"
            @click="$emit('page-change', currentPage + 1)"
            class="px-4 py-2 bg-gray-200 rounded disabled:opacity-50"
        >
            Next
        </button>
    </div>
</template>

<script setup>
defineProps({
    currentPage: { type: Number, required: true, default: 1 },
    lastPage: { type: Number, required: true, default: 1 },
});

defineEmits(["page-change"]);
</script>
